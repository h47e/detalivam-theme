<?php
/**
 * Image-size policy and one-time cleanup of retired generated files.
 */
defined( 'ABSPATH' ) || exit;

function dv_media_retired_image_sizes() {
    return array(
        '1536x1536',
        '2048x2048',
        'woocommerce_thumbnail',
        'woocommerce_single',
        'woocommerce_gallery_thumbnail',
        'dv-product',
        'dv-product-sm',
        'dv-product-lg',
        'dv-hero',
    );
}

function dv_media_cleanup_version() {
    return '1';
}

function dv_media_cleanup_version_option_name() {
    return 'dv_media_cleanup_version';
}

function dv_media_cleanup_state_option_name() {
    return 'dv_media_cleanup_state';
}

function dv_media_cleanup_hook() {
    return 'dv_media_cleanup_retired_sizes';
}

function dv_media_cleanup_purge_hook() {
    return 'dv_media_cleanup_purge_backup';
}

function dv_media_cleanup_manifest_filename() {
    return '.dv-image-size-metadata.json';
}

function dv_media_normalize_relative_path( $path ) {
    $path = str_replace( '\\', '/', (string) $path );
    $path = preg_replace( '#/+#', '/', $path );

    return ltrim( (string) $path, '/' );
}

function dv_media_path_starts_with( $path, $base ) {
    $path = untrailingslashit( wp_normalize_path( $path ) );
    $base = untrailingslashit( wp_normalize_path( $base ) );

    return $path === $base || 0 === strpos( $path, trailingslashit( $base ) );
}

function dv_media_cleanup_get_state() {
    $state = get_option( dv_media_cleanup_state_option_name(), array() );

    return is_array( $state ) ? $state : array();
}

function dv_media_cleanup_schedule() {
    if ( dv_media_cleanup_version() === (string) get_option( dv_media_cleanup_version_option_name(), '' ) ) {
        return;
    }

    $state = dv_media_cleanup_get_state();
    if ( 'failed' === ( $state['status'] ?? '' ) ) {
        return;
    }

    if ( empty( $state ) ) {
        $uploads = wp_get_upload_dir();
        $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );

        if ( '' === $base_dir || ! is_dir( $base_dir ) || ! is_writable( $base_dir ) ) {
            return;
        }

        $state = array(
            'status'              => 'scheduled',
            'cursor'              => 0,
            'processed'           => 0,
            'attachments_updated' => 0,
            'files_moved'         => 0,
            'bytes_moved'         => 0,
            'shared_files'        => 0,
            'missing_files'       => 0,
            'failed_files'        => 0,
            'backup_dir'          => function_exists( 'dv_uploads_storage_operation_dir' )
                ? dv_uploads_storage_operation_dir( 'backups', 'generated-image-sizes' )
                : trailingslashit( $base_dir ) . 'detalivam-uploads-trash-image-sizes-' . gmdate( 'Ymd-His' ),
            'started_at'          => current_time( 'mysql' ),
            'updated_at'          => current_time( 'mysql' ),
        );

        update_option( dv_media_cleanup_state_option_name(), $state, false );
    }

    if ( ! wp_next_scheduled( dv_media_cleanup_hook() ) ) {
        wp_schedule_single_event( time() + 10, dv_media_cleanup_hook() );
    }
}
add_action( 'init', 'dv_media_cleanup_schedule', 20 );

function dv_media_cleanup_attachment_ids( $after_id, $limit = 40 ) {
    global $wpdb;

    $mime_like = $wpdb->esc_like( 'image/' ) . '%';
    $sql = $wpdb->prepare(
        "SELECT ID
        FROM {$wpdb->posts}
        WHERE post_type = 'attachment'
          AND post_mime_type LIKE %s
          AND ID > %d
        ORDER BY ID ASC
        LIMIT %d",
        $mime_like,
        max( 0, absint( $after_id ) ),
        max( 1, absint( $limit ) )
    );

    return array_map( 'absint', (array) $wpdb->get_col( $sql ) );
}

function dv_media_cleanup_load_manifest( $backup_dir ) {
    $path = trailingslashit( $backup_dir ) . dv_media_cleanup_manifest_filename();
    if ( ! is_readable( $path ) ) {
        return array( 'version' => 1, 'attachments' => array() );
    }

    $decoded = json_decode( (string) file_get_contents( $path ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

    if ( ! is_array( $decoded ) ) {
        return array( 'version' => 1, 'attachments' => array() );
    }

    $decoded['attachments'] = isset( $decoded['attachments'] ) && is_array( $decoded['attachments'] ) ? $decoded['attachments'] : array();

    return $decoded;
}

function dv_media_cleanup_save_manifest( $backup_dir, $manifest ) {
    if ( ! wp_mkdir_p( $backup_dir ) ) {
        return false;
    }

    $manifest['updated_at'] = current_time( 'mysql' );
    $encoded = wp_json_encode( $manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
    if ( ! is_string( $encoded ) || '' === $encoded ) {
        return false;
    }

    $path = trailingslashit( $backup_dir ) . dv_media_cleanup_manifest_filename();

    return false !== file_put_contents( $path, $encoded, LOCK_EX ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
}

function dv_media_cleanup_build_plan( $attachment_ids ) {
    $retired = array_fill_keys( dv_media_retired_image_sizes(), true );
    $plan = array();

    foreach ( $attachment_ids as $attachment_id ) {
        $metadata = wp_get_attachment_metadata( $attachment_id );
        if ( ! is_array( $metadata ) || empty( $metadata['sizes'] ) || ! is_array( $metadata['sizes'] ) ) {
            continue;
        }

        $retired_sizes = array_intersect_key( $metadata['sizes'], $retired );
        if ( empty( $retired_sizes ) ) {
            continue;
        }

        $attached_file = dv_media_normalize_relative_path( get_post_meta( $attachment_id, '_wp_attached_file', true ) );
        if ( '' === $attached_file || false !== strpos( $attached_file, '../' ) ) {
            continue;
        }

        $plan[ $attachment_id ] = array(
            'attached_file' => $attached_file,
            'metadata'      => $metadata,
            'retired_sizes' => $retired_sizes,
        );
    }

    return $plan;
}

function dv_media_cleanup_move_file( $source, $destination ) {
    if ( ! is_file( $source ) ) {
        return 'missing';
    }

    if ( is_file( $destination ) ) {
        if ( (int) filesize( $source ) === (int) filesize( $destination ) && unlink( $source ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.unlink_unlink
            return 'moved';
        }

        return 'failed';
    }

    if ( ! wp_mkdir_p( dirname( $destination ) ) ) {
        return 'failed';
    }

    if ( rename( $source, $destination ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.rename_rename
        return 'moved';
    }

    if ( copy( $source, $destination ) && unlink( $source ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.copy_copy,WordPress.WP.AlternativeFunctions.unlink_unlink
        return 'moved';
    }

    return 'failed';
}

function dv_media_cleanup_process_plan( $plan, $backup_dir, $state ) {
    $uploads = wp_get_upload_dir();
    $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );

    foreach ( $plan as $attachment_id => $item ) {
        $metadata = $item['metadata'];
        $retired_sizes = $item['retired_sizes'];
        $retained_sizes = array_diff_key( $metadata['sizes'], $retired_sizes );
        $retained_files = array();
        $metadata_changed = false;

        foreach ( $retained_sizes as $retained_size ) {
            if ( ! empty( $retained_size['file'] ) ) {
                $retained_files[ dv_media_normalize_relative_path( $retained_size['file'] ) ] = true;
            }
        }

        $relative_dir = trim( dirname( $item['attached_file'] ), '.\\/' );

        foreach ( $retired_sizes as $size_name => $size_data ) {
            $filename = dv_media_normalize_relative_path( $size_data['file'] ?? '' );
            if ( '' === $filename || false !== strpos( $filename, '../' ) ) {
                ++$state['failed_files'];
                continue;
            }

            if ( isset( $retained_files[ $filename ] ) ) {
                unset( $metadata['sizes'][ $size_name ] );
                $metadata_changed = true;
                ++$state['shared_files'];
                continue;
            }

            $relative_path = dv_media_normalize_relative_path( ( '' !== $relative_dir ? $relative_dir . '/' : '' ) . $filename );
            $source = wp_normalize_path( trailingslashit( $base_dir ) . $relative_path );
            $destination = wp_normalize_path( trailingslashit( $backup_dir ) . $relative_path );

            if ( ! dv_media_path_starts_with( $source, $base_dir ) || ! dv_media_path_starts_with( $destination, $backup_dir ) ) {
                ++$state['failed_files'];
                continue;
            }

            $size_bytes = is_file( $source ) ? (int) filesize( $source ) : 0;
            $result = dv_media_cleanup_move_file( $source, $destination );

            if ( 'failed' === $result ) {
                ++$state['failed_files'];
                continue;
            }

            unset( $metadata['sizes'][ $size_name ] );
            $metadata_changed = true;

            if ( 'moved' === $result ) {
                ++$state['files_moved'];
                $state['bytes_moved'] += $size_bytes;
            } else {
                ++$state['missing_files'];
            }
        }

        if ( $metadata_changed ) {
            wp_update_attachment_metadata( $attachment_id, $metadata );
            ++$state['attachments_updated'];
        }
    }

    return $state;
}

function dv_media_cleanup_complete( $state ) {
    wp_clear_scheduled_hook( dv_media_cleanup_hook() );

    $state['status'] = 'done';
    $state['updated_at'] = current_time( 'mysql' );
    $state['completed_at'] = current_time( 'mysql' );

    update_option( dv_media_cleanup_state_option_name(), $state, false );
    update_option( dv_media_cleanup_version_option_name(), dv_media_cleanup_version(), false );

    if ( function_exists( 'dv_uploads_tools_clear_backup_dirs_cache' ) ) {
        dv_uploads_tools_clear_backup_dirs_cache();
    }

    if ( function_exists( 'dv_uploads_tools_last_backup_action_option_name' ) ) {
        update_option(
            dv_uploads_tools_last_backup_action_option_name(),
            array(
                'type'       => 'image-size-cleanup',
                'updated_at' => current_time( 'mysql' ),
                'backup_dir' => $state['backup_dir'] ?? '',
                'summary'    => array(
                    'attachments' => absint( $state['attachments_updated'] ?? 0 ),
                    'files'       => absint( $state['files_moved'] ?? 0 ),
                    'size'        => size_format( absint( $state['bytes_moved'] ?? 0 ) ),
                    'failed'      => absint( $state['failed_files'] ?? 0 ),
                ),
            ),
            false
        );
    }

    if ( function_exists( 'dv_admin_action_log_record' ) ) {
        dv_admin_action_log_record( 'uploads_image_sizes_cleanup', 'Завершена очистка старых размеров изображений', $state );
    }

    if ( ! wp_next_scheduled( dv_media_cleanup_purge_hook() ) ) {
        wp_schedule_single_event( time() + ( 14 * DAY_IN_SECONDS ), dv_media_cleanup_purge_hook() );
    }
}

function dv_media_cleanup_run_batch() {
    if ( get_transient( 'dv_media_cleanup_lock' ) ) {
        return;
    }

    set_transient( 'dv_media_cleanup_lock', '1', 5 * MINUTE_IN_SECONDS );

    $state = dv_media_cleanup_get_state();
    if ( empty( $state['backup_dir'] ) ) {
        delete_transient( 'dv_media_cleanup_lock' );
        return;
    }

    $state['status'] = 'running';
    $state['updated_at'] = current_time( 'mysql' );
    update_option( dv_media_cleanup_state_option_name(), $state, false );

    $attachment_ids = dv_media_cleanup_attachment_ids( $state['cursor'] ?? 0, 40 );
    if ( empty( $attachment_ids ) ) {
        dv_media_cleanup_complete( $state );
        delete_transient( 'dv_media_cleanup_lock' );
        return;
    }

    $plan = dv_media_cleanup_build_plan( $attachment_ids );
    if ( ! empty( $plan ) ) {
        $manifest = dv_media_cleanup_load_manifest( $state['backup_dir'] );
        foreach ( $plan as $attachment_id => $item ) {
            $manifest['attachments'][ (string) $attachment_id ] = array(
                'attached_file' => $item['attached_file'],
                'sizes'         => $item['retired_sizes'],
            );
        }

        if ( ! dv_media_cleanup_save_manifest( $state['backup_dir'], $manifest ) ) {
            $state['status'] = 'failed';
            $state['updated_at'] = current_time( 'mysql' );
            update_option( dv_media_cleanup_state_option_name(), $state, false );
            delete_transient( 'dv_media_cleanup_lock' );
            return;
        }

        $state = dv_media_cleanup_process_plan( $plan, $state['backup_dir'], $state );
    }

    $state['cursor'] = max( $attachment_ids );
    $state['processed'] += count( $attachment_ids );
    $state['updated_at'] = current_time( 'mysql' );
    update_option( dv_media_cleanup_state_option_name(), $state, false );
    delete_transient( 'dv_media_cleanup_lock' );

    if ( ! wp_next_scheduled( dv_media_cleanup_hook() ) ) {
        wp_schedule_single_event( time() + 10, dv_media_cleanup_hook() );
    }
}
add_action( dv_media_cleanup_hook(), 'dv_media_cleanup_run_batch' );

function dv_media_cleanup_purge_backup() {
    $state = dv_media_cleanup_get_state();
    $backup_dir = untrailingslashit( wp_normalize_path( $state['backup_dir'] ?? '' ) );
    $uploads = wp_get_upload_dir();
    $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );

    $is_new_backup = function_exists( 'dv_uploads_storage_is_backup_operation_dir' )
        && dv_uploads_storage_is_backup_operation_dir( $backup_dir, 'generated-image-sizes' );
    $is_legacy_backup = 0 === strpos( basename( $backup_dir ), 'detalivam-uploads-trash-image-sizes-' );

    if (
        'done' !== ( $state['status'] ?? '' )
        || '' === $backup_dir
        || ! is_dir( $backup_dir )
        || ! dv_media_path_starts_with( $backup_dir, $base_dir )
        || ( ! $is_new_backup && ! $is_legacy_backup )
    ) {
        return;
    }

    if ( ! function_exists( 'dv_uploads_tools_remove_dir_recursive' ) || ! dv_uploads_tools_remove_dir_recursive( $backup_dir ) ) {
        wp_schedule_single_event( time() + DAY_IN_SECONDS, dv_media_cleanup_purge_hook() );
        return;
    }

    $state['backup_purged_at'] = current_time( 'mysql' );
    $state['updated_at'] = current_time( 'mysql' );
    update_option( dv_media_cleanup_state_option_name(), $state, false );

    if ( function_exists( 'dv_uploads_tools_clear_backup_dirs_cache' ) ) {
        dv_uploads_tools_clear_backup_dirs_cache();
    }

    if ( function_exists( 'dv_admin_action_log_record' ) ) {
        dv_admin_action_log_record(
            'uploads_image_sizes_backup_purge',
            'Удалён резерв старых размеров изображений',
            array( 'backup_dir' => $backup_dir )
        );
    }
}
add_action( dv_media_cleanup_purge_hook(), 'dv_media_cleanup_purge_backup' );

function dv_media_restore_cleanup_manifest( $backup_dir ) {
    $manifest = dv_media_cleanup_load_manifest( $backup_dir );
    $summary = array(
        'metadata_restored' => 0,
        'metadata_skipped'  => 0,
    );

    foreach ( $manifest['attachments'] as $attachment_id => $item ) {
        $attachment_id = absint( $attachment_id );
        $metadata = $attachment_id ? wp_get_attachment_metadata( $attachment_id ) : array();
        if ( ! is_array( $metadata ) || empty( $item['sizes'] ) || ! is_array( $item['sizes'] ) ) {
            ++$summary['metadata_skipped'];
            continue;
        }

        $metadata['sizes'] = isset( $metadata['sizes'] ) && is_array( $metadata['sizes'] ) ? $metadata['sizes'] : array();
        $metadata['sizes'] = array_merge( $metadata['sizes'], $item['sizes'] );
        wp_update_attachment_metadata( $attachment_id, $metadata );
        ++$summary['metadata_restored'];
    }

    return $summary;
}
