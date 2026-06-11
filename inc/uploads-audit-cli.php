<?php
/**
 * WP-CLI uploads audit command.
 */
defined( 'ABSPATH' ) || exit;

if ( ! ( defined( 'WP_CLI' ) && WP_CLI ) || ! class_exists( 'WP_CLI' ) ) {
    return;
}

function dv_uploads_audit_normalize_relative_path( $path ) {
    $path = str_replace( '\\', '/', (string) $path );
    $path = preg_replace( '#/+#', '/', $path );
    $path = ltrim( $path, '/' );
    $path = preg_replace( '/[?#].*$/', '', $path );

    return trim( (string) $path );
}

function dv_uploads_audit_is_candidate_file( $relative_path, $extensions ) {
    $extension = strtolower( pathinfo( (string) $relative_path, PATHINFO_EXTENSION ) );

    return in_array( $extension, $extensions, true );
}

function dv_uploads_audit_file_row_data( $absolute_path ) {
    return array(
        'size_bytes' => is_file( $absolute_path ) ? (int) filesize( $absolute_path ) : 0,
        'modified'   => is_file( $absolute_path ) ? gmdate( 'c', (int) filemtime( $absolute_path ) ) : '',
    );
}

function dv_uploads_audit_scan_files( $base_dir, $extensions ) {
    $files = array();

    if ( ! is_dir( $base_dir ) ) {
        return $files;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator( $base_dir, FilesystemIterator::SKIP_DOTS )
    );

    foreach ( $iterator as $file ) {
        if ( ! $file instanceof SplFileInfo || ! $file->isFile() ) {
            continue;
        }

        $absolute = $file->getPathname();
        $relative = dv_uploads_audit_normalize_relative_path( substr( $absolute, strlen( $base_dir ) ) );

        if ( ! dv_uploads_audit_is_candidate_file( $relative, $extensions ) ) {
            continue;
        }

        $files[ $relative ] = array_merge(
            array( 'path' => $relative ),
            dv_uploads_audit_file_row_data( $absolute )
        );
    }

    ksort( $files );

    return $files;
}

function dv_uploads_audit_attachment_size_paths( $attached_file, $metadata ) {
    $paths = array();
    $attached_file = dv_uploads_audit_normalize_relative_path( $attached_file );

    if ( '' === $attached_file ) {
        return $paths;
    }

    $paths[] = $attached_file;
    $base_dir = trim( dirname( $attached_file ), '.\\/' );

    if ( is_string( $metadata ) ) {
        $metadata = maybe_unserialize( $metadata );
    }

    if ( is_array( $metadata ) && ! empty( $metadata['sizes'] ) && is_array( $metadata['sizes'] ) ) {
        foreach ( $metadata['sizes'] as $size ) {
            if ( empty( $size['file'] ) ) {
                continue;
            }

            $paths[] = dv_uploads_audit_normalize_relative_path(
                ( '' !== $base_dir ? $base_dir . '/' : '' ) . $size['file']
            );
        }
    }

    return array_values( array_unique( array_filter( $paths ) ) );
}

function dv_uploads_audit_get_attachments() {
    global $wpdb;

    $rows = $wpdb->get_results(
        "SELECT p.ID, p.post_title, filemeta.meta_value AS attached_file, datameta.meta_value AS attachment_metadata
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->postmeta} filemeta
            ON filemeta.post_id = p.ID AND filemeta.meta_key = '_wp_attached_file'
        LEFT JOIN {$wpdb->postmeta} datameta
            ON datameta.post_id = p.ID AND datameta.meta_key = '_wp_attachment_metadata'
        WHERE p.post_type = 'attachment'
            AND p.post_mime_type LIKE 'image/%'"
    );

    return is_array( $rows ) ? $rows : array();
}

function dv_uploads_audit_add_used_file( &$used_files, $relative_path, $reason ) {
    $relative_path = dv_uploads_audit_normalize_relative_path( $relative_path );
    $reason = trim( (string) $reason );

    if ( '' === $relative_path ) {
        return;
    }

    if ( ! isset( $used_files[ $relative_path ] ) ) {
        $used_files[ $relative_path ] = array();
    }

    if ( '' !== $reason ) {
        $used_files[ $relative_path ][ $reason ] = true;
    }
}

function dv_uploads_audit_add_attachment_usage( &$used_files, $attachment_files, $attachment_id, $reason ) {
    $attachment_id = absint( $attachment_id );

    if ( ! $attachment_id || empty( $attachment_files[ $attachment_id ] ) ) {
        return;
    }

    foreach ( $attachment_files[ $attachment_id ] as $relative_path ) {
        dv_uploads_audit_add_used_file(
            $used_files,
            $relative_path,
            'attachment #' . $attachment_id . ': ' . $reason
        );
    }
}

function dv_uploads_audit_relative_from_upload_url( $url, $uploads ) {
    $url = html_entity_decode( trim( (string) $url ), ENT_QUOTES, 'UTF-8' );

    if ( '' === $url ) {
        return '';
    }

    $url = strtok( $url, '?#' );
    $base_url = rtrim( (string) ( $uploads['baseurl'] ?? '' ), '/' ) . '/';

    if ( 0 === strpos( $url, $base_url ) ) {
        return dv_uploads_audit_normalize_relative_path( substr( $url, strlen( $base_url ) ) );
    }

    $path = wp_parse_url( $url, PHP_URL_PATH );
    if ( ! is_string( $path ) || '' === $path ) {
        return '';
    }

    $needle = '/wp-content/uploads/';
    $pos = strpos( $path, $needle );
    if ( false === $pos ) {
        return '';
    }

    return dv_uploads_audit_normalize_relative_path( substr( $path, $pos + strlen( $needle ) ) );
}

function dv_uploads_audit_collect_urls_from_text( $text, $uploads ) {
    $text = (string) maybe_serialize( $text );
    $text = str_replace( '\/', '/', $text );
    $paths = array();

    if ( '' === $text ) {
        return $paths;
    }

    $patterns = array(
        '#https?://[^"\'\s<>)]+/wp-content/uploads/[^"\'\s<>)]+#i',
        '#/wp-content/uploads/[^"\'\s<>)]+#i',
    );

    foreach ( $patterns as $pattern ) {
        if ( ! preg_match_all( $pattern, $text, $matches ) ) {
            continue;
        }

        foreach ( $matches[0] as $url ) {
            $relative = dv_uploads_audit_relative_from_upload_url( $url, $uploads );
            if ( '' !== $relative ) {
                $paths[] = $relative;
            }
        }
    }

    return array_values( array_unique( array_filter( $paths ) ) );
}

function dv_uploads_audit_collect_attachment_ids_from_text( $text ) {
    $text = (string) maybe_serialize( $text );
    $ids = array();

    if ( '' === $text ) {
        return $ids;
    }

    $patterns = array(
        '/wp-image-([0-9]+)/',
        '/"id"\s*:\s*([0-9]+)/',
        '/"attachment_id"\s*:\s*([0-9]+)/',
        '/attachment[_-]?id["\']?\s*[:=]\s*["\']?([0-9]+)/i',
    );

    foreach ( $patterns as $pattern ) {
        if ( ! preg_match_all( $pattern, $text, $matches ) ) {
            continue;
        }

        foreach ( $matches[1] as $id ) {
            $ids[] = absint( $id );
        }
    }

    return array_values( array_unique( array_filter( $ids ) ) );
}

function dv_uploads_audit_collect_post_references( &$used_files, $attachment_files, $uploads ) {
    global $wpdb;

    $posts = $wpdb->get_results(
        "SELECT ID, post_type, post_title, post_content, post_excerpt
        FROM {$wpdb->posts}
        WHERE post_status NOT IN ('auto-draft', 'trash', 'inherit')"
    );

    foreach ( (array) $posts as $post ) {
        $label = $post->post_type . ' #' . (int) $post->ID . ' "' . wp_strip_all_tags( (string) $post->post_title ) . '"';
        $text = (string) $post->post_content . "\n" . (string) $post->post_excerpt;

        foreach ( dv_uploads_audit_collect_urls_from_text( $text, $uploads ) as $relative_path ) {
            dv_uploads_audit_add_used_file( $used_files, $relative_path, $label . ' content URL' );
        }

        foreach ( dv_uploads_audit_collect_attachment_ids_from_text( $text ) as $attachment_id ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $label . ' content ID' );
        }
    }
}

function dv_uploads_audit_collect_postmeta_references( &$used_files, $attachment_files, $uploads ) {
    global $wpdb;

    $rows = $wpdb->get_results(
        "SELECT post_id, meta_key, meta_value
        FROM {$wpdb->postmeta}
        WHERE meta_key IN ('_thumbnail_id', '_product_image_gallery')
            OR meta_value LIKE '%wp-content/uploads/%'
            OR meta_value LIKE '%wp-image-%'"
    );

    foreach ( (array) $rows as $row ) {
        $post_id = absint( $row->post_id );
        $meta_key = (string) $row->meta_key;
        $reason = 'postmeta ' . $meta_key . ' post #' . $post_id;

        if ( '_thumbnail_id' === $meta_key ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, (int) $row->meta_value, $reason );
            continue;
        }

        if ( '_product_image_gallery' === $meta_key ) {
            foreach ( wp_parse_id_list( $row->meta_value ) as $attachment_id ) {
                dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $reason );
            }
            continue;
        }

        foreach ( dv_uploads_audit_collect_urls_from_text( $row->meta_value, $uploads ) as $relative_path ) {
            dv_uploads_audit_add_used_file( $used_files, $relative_path, $reason . ' URL' );
        }

        foreach ( dv_uploads_audit_collect_attachment_ids_from_text( $row->meta_value ) as $attachment_id ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $reason . ' ID' );
        }
    }
}

function dv_uploads_audit_collect_termmeta_references( &$used_files, $attachment_files, $uploads ) {
    global $wpdb;

    $rows = $wpdb->get_results(
        "SELECT term_id, meta_key, meta_value
        FROM {$wpdb->termmeta}
        WHERE meta_key IN ('thumbnail_id')
            OR meta_value LIKE '%wp-content/uploads/%'
            OR meta_value LIKE '%wp-image-%'"
    );

    foreach ( (array) $rows as $row ) {
        $reason = 'termmeta ' . (string) $row->meta_key . ' term #' . absint( $row->term_id );

        if ( 'thumbnail_id' === (string) $row->meta_key ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, (int) $row->meta_value, $reason );
            continue;
        }

        foreach ( dv_uploads_audit_collect_urls_from_text( $row->meta_value, $uploads ) as $relative_path ) {
            dv_uploads_audit_add_used_file( $used_files, $relative_path, $reason . ' URL' );
        }

        foreach ( dv_uploads_audit_collect_attachment_ids_from_text( $row->meta_value ) as $attachment_id ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $reason . ' ID' );
        }
    }
}

function dv_uploads_audit_collect_option_references( &$used_files, $attachment_files, $uploads ) {
    global $wpdb;

    $known_options = array(
        'custom_logo',
        'theme_mods_' . get_option( 'stylesheet' ),
        'dv_store_profile',
        'dv_theme_content',
        'dv_theme_options',
    );

    $placeholders = implode( ',', array_fill( 0, count( $known_options ), '%s' ) );
    $sql = $wpdb->prepare(
        "SELECT option_name, option_value
        FROM {$wpdb->options}
        WHERE option_value LIKE %s
            OR option_value LIKE %s
            OR option_name IN ({$placeholders})",
        array_merge( array( '%wp-content/uploads/%', '%wp-image-%' ), $known_options )
    );

    $rows = $wpdb->get_results( $sql );

    foreach ( (array) $rows as $row ) {
        $option_name = (string) $row->option_name;
        $reason = 'option ' . $option_name;
        $value = maybe_unserialize( $row->option_value );

        if ( 'custom_logo' === $option_name ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, (int) $row->option_value, $reason );
        }

        foreach ( dv_uploads_audit_collect_urls_from_text( $value, $uploads ) as $relative_path ) {
            dv_uploads_audit_add_used_file( $used_files, $relative_path, $reason . ' URL' );
        }

        foreach ( dv_uploads_audit_collect_attachment_ids_from_text( $value ) as $attachment_id ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $reason . ' ID' );
        }
    }
}

function dv_uploads_audit_build_report( $extensions ) {
    $uploads = wp_get_upload_dir();
    $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );
    $files = dv_uploads_audit_scan_files( $base_dir, $extensions );
    $attachments = dv_uploads_audit_get_attachments();
    $attachment_files = array();
    $file_attachments = array();
    $missing_files = array();
    $used_files = array();

    foreach ( $attachments as $attachment ) {
        $attachment_id = absint( $attachment->ID );
        $paths = dv_uploads_audit_attachment_size_paths(
            $attachment->attached_file,
            $attachment->attachment_metadata
        );

        foreach ( $paths as $relative_path ) {
            if ( ! dv_uploads_audit_is_candidate_file( $relative_path, $extensions ) ) {
                continue;
            }

            $attachment_files[ $attachment_id ][] = $relative_path;
            $file_attachments[ $relative_path ][] = $attachment_id;

            if ( ! isset( $files[ $relative_path ] ) ) {
                $missing_files[] = array(
                    'path'          => $relative_path,
                    'attachment_id' => $attachment_id,
                    'title'         => $attachment->post_title,
                );
            }
        }

        if ( isset( $attachment_files[ $attachment_id ] ) ) {
            $attachment_files[ $attachment_id ] = array_values( array_unique( $attachment_files[ $attachment_id ] ) );
        }
    }

    dv_uploads_audit_collect_post_references( $used_files, $attachment_files, $uploads );
    dv_uploads_audit_collect_postmeta_references( $used_files, $attachment_files, $uploads );
    dv_uploads_audit_collect_termmeta_references( $used_files, $attachment_files, $uploads );
    dv_uploads_audit_collect_option_references( $used_files, $attachment_files, $uploads );

    $used_rows = array();
    $unused_rows = array();
    $orphan_rows = array();

    foreach ( $files as $relative_path => $file ) {
        $attachment_ids = array_values( array_unique( array_map( 'absint', $file_attachments[ $relative_path ] ?? array() ) ) );
        $reasons = array_keys( $used_files[ $relative_path ] ?? array() );
        $is_used = ! empty( $reasons );
        $is_orphan = empty( $attachment_ids );
        $row = array(
            'path'             => $relative_path,
            'size_bytes'       => $file['size_bytes'],
            'modified'         => $file['modified'],
            'attachment_ids'   => implode( ',', $attachment_ids ),
            'in_media_library' => $is_orphan ? 'no' : 'yes',
            'used'             => $is_used ? 'yes' : 'no',
            'reasons'          => implode( ' | ', $reasons ),
        );

        if ( $is_used ) {
            $used_rows[] = $row;
        } else {
            $unused_rows[] = $row;
        }

        if ( $is_orphan ) {
            $orphan_rows[] = $row;
        }
    }

    return array(
        'base_dir'      => $base_dir,
        'files'         => $files,
        'used'          => $used_rows,
        'unused'        => $unused_rows,
        'orphan'        => $orphan_rows,
        'missing'       => $missing_files,
        'summary'       => array(
            'scanned_files' => count( $files ),
            'attachments'   => count( $attachments ),
            'used_files'    => count( $used_rows ),
            'unused_files'  => count( $unused_rows ),
            'orphan_files'  => count( $orphan_rows ),
            'missing_files' => count( $missing_files ),
        ),
    );
}

function dv_uploads_audit_csv_cell( $value ) {
    $value = wp_strip_all_tags( (string) $value );
    $value = html_entity_decode( $value, ENT_QUOTES, 'UTF-8' );
    $value = preg_replace( '/\s+/', ' ', $value );
    $value = trim( (string) $value );

    if ( '' !== $value && preg_match( '/^[=+\-@]/', $value ) ) {
        $value = "'" . $value;
    }

    return $value;
}

function dv_uploads_audit_write_csv( $path, $headers, $rows ) {
    $handle = fopen( $path, 'w' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen

    if ( ! $handle ) {
        return false;
    }

    fwrite( $handle, "\xEF\xBB\xBF" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite
    fputcsv( $handle, $headers, ';' );

    foreach ( $rows as $row ) {
        $line = array();
        foreach ( $headers as $header ) {
            $line[] = dv_uploads_audit_csv_cell( $row[ $header ] ?? '' );
        }
        fputcsv( $handle, $line, ';' );
    }

    fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose

    return true;
}

function dv_uploads_audit_write_reports( $report, $out_dir ) {
    wp_mkdir_p( $out_dir );

    $file_headers = array(
        'path',
        'size_bytes',
        'modified',
        'attachment_ids',
        'in_media_library',
        'used',
        'reasons',
    );

    dv_uploads_audit_write_csv( $out_dir . '/used-files.csv', $file_headers, $report['used'] );
    dv_uploads_audit_write_csv( $out_dir . '/unused-files.csv', $file_headers, $report['unused'] );
    dv_uploads_audit_write_csv( $out_dir . '/orphan-files.csv', $file_headers, $report['orphan'] );
    dv_uploads_audit_write_csv(
        $out_dir . '/missing-files.csv',
        array( 'path', 'attachment_id', 'title' ),
        $report['missing']
    );

    $summary = array_merge(
        array(
            'generated_at' => gmdate( 'c' ),
            'uploads_dir'  => $report['base_dir'],
        ),
        $report['summary']
    );

    file_put_contents( // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
        $out_dir . '/summary.json',
        wp_json_encode( $summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
    );
}

function dv_uploads_audit_cli_command( $args, $assoc_args ) {
    $default_extensions = array( 'jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'svg' );
    $extensions_arg = isset( $assoc_args['extensions'] ) ? (string) $assoc_args['extensions'] : '';
    $extensions = '' !== $extensions_arg
        ? array_filter( array_map( 'sanitize_key', explode( ',', $extensions_arg ) ) )
        : $default_extensions;

    $uploads = wp_get_upload_dir();
    $default_out = trailingslashit( $uploads['basedir'] ) . 'detalivam-uploads-audit-' . gmdate( 'Ymd-His' );
    $out_dir = isset( $assoc_args['out'] ) ? (string) $assoc_args['out'] : $default_out;
    $out_dir = untrailingslashit( wp_normalize_path( $out_dir ) );

    WP_CLI::log( 'Scanning uploads: ' . untrailingslashit( $uploads['basedir'] ) );
    WP_CLI::log( 'Extensions: ' . implode( ', ', $extensions ) );

    $report = dv_uploads_audit_build_report( $extensions );
    dv_uploads_audit_write_reports( $report, $out_dir );

    WP_CLI::success( 'Uploads audit report created: ' . $out_dir );
    WP_CLI::log( 'Scanned files: ' . $report['summary']['scanned_files'] );
    WP_CLI::log( 'Used files: ' . $report['summary']['used_files'] );
    WP_CLI::log( 'Unused candidates: ' . $report['summary']['unused_files'] );
    WP_CLI::log( 'Orphan files: ' . $report['summary']['orphan_files'] );
    WP_CLI::log( 'Missing files: ' . $report['summary']['missing_files'] );
}

function dv_uploads_audit_read_csv_report( $path ) {
    if ( ! is_readable( $path ) ) {
        WP_CLI::error( 'Report file is not readable: ' . $path );
    }

    $handle = fopen( $path, 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
    if ( ! $handle ) {
        WP_CLI::error( 'Could not open report file: ' . $path );
    }

    $headers = fgetcsv( $handle, 0, ';' );
    if ( ! is_array( $headers ) || empty( $headers ) ) {
        fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
        WP_CLI::error( 'Report file has no header row: ' . $path );
    }

    $headers[0] = preg_replace( '/^\xEF\xBB\xBF/', '', (string) $headers[0] );
    $headers = array_map( 'trim', $headers );
    $rows = array();

    while ( false !== ( $line = fgetcsv( $handle, 0, ';' ) ) ) {
        if ( ! is_array( $line ) || empty( $line ) ) {
            continue;
        }

        $row = array();
        foreach ( $headers as $index => $header ) {
            $row[ $header ] = isset( $line[ $index ] ) ? (string) $line[ $index ] : '';
        }

        if ( '' !== trim( (string) ( $row['path'] ?? '' ) ) ) {
            $rows[] = $row;
        }
    }

    fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose

    return $rows;
}

function dv_uploads_audit_path_starts_with( $path, $base ) {
    $path = untrailingslashit( wp_normalize_path( $path ) );
    $base = untrailingslashit( wp_normalize_path( $base ) );

    return $path === $base || 0 === strpos( $path, trailingslashit( $base ) );
}

function dv_uploads_audit_resolve_upload_file_path( $relative_path, $uploads_base_dir ) {
    $relative_path = dv_uploads_audit_normalize_relative_path( $relative_path );

    if ( '' === $relative_path || false !== strpos( $relative_path, '../' ) || '..' === $relative_path ) {
        return '';
    }

    $target = wp_normalize_path( trailingslashit( $uploads_base_dir ) . $relative_path );
    $parent = realpath( dirname( $target ) );

    if ( false === $parent ) {
        return '';
    }

    $resolved = wp_normalize_path( trailingslashit( $parent ) . basename( $target ) );

    if ( ! dv_uploads_audit_path_starts_with( $resolved, $uploads_base_dir ) ) {
        return '';
    }

    return $resolved;
}

function dv_uploads_audit_unique_backup_path( $backup_path ) {
    if ( ! file_exists( $backup_path ) ) {
        return $backup_path;
    }

    $dir = dirname( $backup_path );
    $name = pathinfo( $backup_path, PATHINFO_FILENAME );
    $extension = pathinfo( $backup_path, PATHINFO_EXTENSION );
    $suffix = 1;

    do {
        $candidate = trailingslashit( $dir ) . $name . '-' . $suffix . ( '' !== $extension ? '.' . $extension : '' );
        ++$suffix;
    } while ( file_exists( $candidate ) );

    return $candidate;
}

function dv_uploads_audit_delete_report_row( $row, $uploads_base_dir, $backup_base_dir, $confirm, $use_backup, $older_than_days ) {
    $relative_path = dv_uploads_audit_normalize_relative_path( $row['path'] ?? '' );
    $result = array(
        'path'        => $relative_path,
        'action'      => 'skip',
        'reason'      => '',
        'source'      => $uploads_base_dir,
        'backup_path' => '',
        'size_bytes'  => '',
        'modified'    => '',
    );

    if ( '' === $relative_path ) {
        $result['reason'] = 'empty path';
        return $result;
    }

    if ( isset( $row['used'] ) && 'yes' === strtolower( trim( (string) $row['used'] ) ) ) {
        $result['reason'] = 'report row is marked as used';
        return $result;
    }

    $target = dv_uploads_audit_resolve_upload_file_path( $relative_path, $uploads_base_dir );
    if ( '' === $target ) {
        $result['reason'] = 'path is outside uploads or invalid';
        return $result;
    }

    $result['source'] = $target;

    if ( ! is_file( $target ) ) {
        $result['reason'] = 'file does not exist';
        return $result;
    }

    $mtime = (int) filemtime( $target );
    $age_days = $mtime > 0 ? floor( ( time() - $mtime ) / DAY_IN_SECONDS ) : 0;
    $result['size_bytes'] = (int) filesize( $target );
    $result['modified'] = gmdate( 'c', $mtime );

    if ( $older_than_days > 0 && $age_days < $older_than_days ) {
        $result['reason'] = 'file is newer than --older-than=' . $older_than_days . ' days';
        return $result;
    }

    if ( ! $confirm ) {
        $result['action'] = $use_backup ? 'would-move-to-backup' : 'would-delete';
        $result['reason'] = 'dry-run';
        $result['backup_path'] = $use_backup ? wp_normalize_path( trailingslashit( $backup_base_dir ) . $relative_path ) : '';
        return $result;
    }

    if ( $use_backup ) {
        $backup_path = dv_uploads_audit_unique_backup_path(
            wp_normalize_path( trailingslashit( $backup_base_dir ) . $relative_path )
        );

        wp_mkdir_p( dirname( $backup_path ) );

        if ( ! rename( $target, $backup_path ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.rename_rename
            $result['reason'] = 'failed to move file to backup';
            $result['backup_path'] = $backup_path;
            return $result;
        }

        $result['action'] = 'moved-to-backup';
        $result['reason'] = 'confirmed';
        $result['backup_path'] = $backup_path;

        return $result;
    }

    if ( ! unlink( $target ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.unlink_unlink
        $result['reason'] = 'failed to delete file';
        return $result;
    }

    $result['action'] = 'deleted';
    $result['reason'] = 'confirmed with --no-backup';

    return $result;
}

function dv_uploads_audit_delete_cli_command( $args, $assoc_args ) {
    if ( empty( $assoc_args['report'] ) ) {
        WP_CLI::error( 'Please pass --report=/path/to/unused-files.csv or orphan-files.csv' );
    }

    $report_path = wp_normalize_path( (string) $assoc_args['report'] );
    $uploads = wp_get_upload_dir();
    $uploads_base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );
    $confirm = isset( $assoc_args['confirm'] );
    $use_backup = ! isset( $assoc_args['no-backup'] );
    $older_than_days = isset( $assoc_args['older-than'] ) ? max( 0, absint( $assoc_args['older-than'] ) ) : 30;
    $default_backup_dir = trailingslashit( $uploads_base_dir ) . 'detalivam-uploads-trash-' . gmdate( 'Ymd-His' );
    $backup_base_dir = isset( $assoc_args['backup-dir'] )
        ? untrailingslashit( wp_normalize_path( (string) $assoc_args['backup-dir'] ) )
        : untrailingslashit( wp_normalize_path( $default_backup_dir ) );
    $output_dir = isset( $assoc_args['out'] )
        ? untrailingslashit( wp_normalize_path( (string) $assoc_args['out'] ) )
        : untrailingslashit( wp_normalize_path( dirname( $report_path ) ) );

    if ( '' === $uploads_base_dir || ! is_dir( $uploads_base_dir ) ) {
        WP_CLI::error( 'Uploads directory was not found.' );
    }

    if ( $use_backup && ! dv_uploads_audit_path_starts_with( $backup_base_dir, $uploads_base_dir ) ) {
        WP_CLI::error( 'Backup directory must be inside uploads: ' . $backup_base_dir );
    }

    $rows = dv_uploads_audit_read_csv_report( $report_path );
    $results = array();
    $summary = array(
        'processed' => 0,
        'skipped'   => 0,
        'planned'   => 0,
        'moved'     => 0,
        'deleted'   => 0,
    );

    WP_CLI::log( 'Report: ' . $report_path );
    WP_CLI::log( 'Mode: ' . ( $confirm ? 'confirm' : 'dry-run' ) );
    WP_CLI::log( 'Older than days: ' . $older_than_days );
    WP_CLI::log( 'Backup: ' . ( $use_backup ? $backup_base_dir : 'disabled' ) );

    foreach ( $rows as $row ) {
        $result = dv_uploads_audit_delete_report_row(
            $row,
            $uploads_base_dir,
            $backup_base_dir,
            $confirm,
            $use_backup,
            $older_than_days
        );

        $results[] = $result;
        ++$summary['processed'];

        if ( 'skip' === $result['action'] ) {
            ++$summary['skipped'];
        } elseif ( 0 === strpos( $result['action'], 'would-' ) ) {
            ++$summary['planned'];
        } elseif ( 'moved-to-backup' === $result['action'] ) {
            ++$summary['moved'];
        } elseif ( 'deleted' === $result['action'] ) {
            ++$summary['deleted'];
        }
    }

    wp_mkdir_p( $output_dir );
    $result_filename = ( $confirm ? 'deleted-files-' : 'delete-plan-' ) . gmdate( 'Ymd-His' ) . '.csv';
    $result_path = trailingslashit( $output_dir ) . $result_filename;

    dv_uploads_audit_write_csv(
        $result_path,
        array( 'path', 'action', 'reason', 'source', 'backup_path', 'size_bytes', 'modified' ),
        $results
    );

    WP_CLI::success( ( $confirm ? 'Delete run complete: ' : 'Dry-run plan created: ' ) . $result_path );
    WP_CLI::log( 'Processed rows: ' . $summary['processed'] );
    WP_CLI::log( 'Planned: ' . $summary['planned'] );
    WP_CLI::log( 'Moved to backup: ' . $summary['moved'] );
    WP_CLI::log( 'Deleted: ' . $summary['deleted'] );
    WP_CLI::log( 'Skipped: ' . $summary['skipped'] );
}

WP_CLI::add_command(
    'dv uploads-audit',
    'dv_uploads_audit_cli_command',
    array(
        'shortdesc' => 'Audit wp-content/uploads image usage and write CSV reports.',
        'synopsis'  => array(
            array(
                'type'        => 'assoc',
                'name'        => 'out',
                'optional'    => true,
                'description' => 'Output directory for report files.',
            ),
            array(
                'type'        => 'assoc',
                'name'        => 'extensions',
                'optional'    => true,
                'description' => 'Comma-separated file extensions to scan.',
            ),
        ),
    )
);

WP_CLI::add_command(
    'dv uploads-audit-delete',
    'dv_uploads_audit_delete_cli_command',
    array(
        'shortdesc' => 'Dry-run or move/delete files listed in an uploads audit CSV report.',
        'synopsis'  => array(
            array(
                'type'        => 'assoc',
                'name'        => 'report',
                'optional'    => false,
                'description' => 'Path to unused-files.csv or orphan-files.csv.',
            ),
            array(
                'type'        => 'flag',
                'name'        => 'confirm',
                'optional'    => true,
                'description' => 'Actually move/delete files. Without this flag only a dry-run plan is written.',
            ),
            array(
                'type'        => 'assoc',
                'name'        => 'older-than',
                'optional'    => true,
                'description' => 'Only process files older than this many days. Default: 30. Use 0 to disable.',
            ),
            array(
                'type'        => 'assoc',
                'name'        => 'backup-dir',
                'optional'    => true,
                'description' => 'Backup directory inside uploads. Used unless --no-backup is passed.',
            ),
            array(
                'type'        => 'flag',
                'name'        => 'no-backup',
                'optional'    => true,
                'description' => 'Permanently delete files when used together with --confirm.',
            ),
            array(
                'type'        => 'assoc',
                'name'        => 'out',
                'optional'    => true,
                'description' => 'Directory for delete-plan/deleted-files CSV.',
            ),
        ),
    )
);
