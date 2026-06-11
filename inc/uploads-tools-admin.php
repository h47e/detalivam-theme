<?php
/**
 * Admin tools for uploads recovery.
 */
defined( 'ABSPATH' ) || exit;

function dv_uploads_tools_label( $text ) {
    return html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
}

function dv_uploads_tools_normalize_relative_path( $path ) {
    $path = str_replace( '\\', '/', (string) $path );
    $path = preg_replace( '#/+#', '/', $path );
    $path = ltrim( $path, '/' );
    $path = preg_replace( '/[?#].*$/', '', $path );

    return trim( (string) $path );
}

function dv_uploads_tools_path_starts_with( $path, $base ) {
    $path = untrailingslashit( wp_normalize_path( $path ) );
    $base = untrailingslashit( wp_normalize_path( $base ) );

    return $path === $base || 0 === strpos( $path, trailingslashit( $base ) );
}

function dv_uploads_tools_current_site_icon_state() {
    $uploads = wp_get_upload_dir();
    $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );
    $base_url = untrailingslashit( (string) ( $uploads['baseurl'] ?? '' ) );
    $site_icon_id = absint( get_option( 'site_icon' ) );
    $relative_path = $site_icon_id ? dv_uploads_tools_normalize_relative_path( get_post_meta( $site_icon_id, '_wp_attached_file', true ) ) : '';
    $absolute_path = $relative_path ? wp_normalize_path( trailingslashit( $base_dir ) . $relative_path ) : '';
    $file_exists = '' !== $absolute_path && is_file( $absolute_path );

    return array(
        'site_icon_id'  => $site_icon_id,
        'relative_path' => $relative_path,
        'absolute_path' => $absolute_path,
        'file_exists'   => $file_exists,
        'url'           => $file_exists && $relative_path ? trailingslashit( $base_url ) . $relative_path : '',
        'uploads_dir'   => $base_dir,
    );
}

function dv_uploads_tools_last_audit_option_name() {
    return 'dv_uploads_tools_last_audit';
}

function dv_uploads_tools_last_delete_option_name() {
    return 'dv_uploads_tools_last_delete';
}

function dv_uploads_tools_get_last_audit() {
    $audit = get_option( dv_uploads_tools_last_audit_option_name(), array() );

    return is_array( $audit ) ? $audit : array();
}

function dv_uploads_tools_get_last_delete() {
    $delete = get_option( dv_uploads_tools_last_delete_option_name(), array() );

    return is_array( $delete ) ? $delete : array();
}

function dv_uploads_tools_file_url( $path ) {
    $uploads = wp_get_upload_dir();
    $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );
    $base_url = untrailingslashit( (string) ( $uploads['baseurl'] ?? '' ) );
    $path = wp_normalize_path( (string) $path );

    if ( '' === $base_dir || '' === $base_url || ! dv_uploads_tools_path_starts_with( $path, $base_dir ) ) {
        return '';
    }

    return trailingslashit( $base_url ) . ltrim( substr( $path, strlen( $base_dir ) ), '/' );
}

function dv_uploads_tools_read_csv_report( $path ) {
    if ( ! is_readable( $path ) ) {
        return array();
    }

    $handle = fopen( $path, 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
    if ( ! $handle ) {
        return array();
    }

    $headers = fgetcsv( $handle, 0, ';' );
    if ( ! is_array( $headers ) || empty( $headers ) ) {
        fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
        return array();
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

function dv_uploads_tools_report_config( $report_type ) {
    $configs = array(
        'unused' => array(
            'path_key' => 'unused_path',
            'label'    => 'Unused',
            'prefix'   => 'unused',
        ),
        'orphan' => array(
            'path_key' => 'orphan_path',
            'label'    => 'Orphan',
            'prefix'   => 'orphan',
        ),
    );

    $report_type = sanitize_key( $report_type );

    return isset( $configs[ $report_type ] ) ? $configs[ $report_type ] : $configs['unused'];
}

function dv_uploads_tools_process_delete_report( $confirm, $older_than_days, $report_type = 'unused' ) {
    if (
        ! function_exists( 'dv_uploads_audit_delete_report_row' )
        || ! function_exists( 'dv_uploads_audit_write_csv' )
        || ! function_exists( 'dv_uploads_audit_get_attachment_files_for_ids' )
        || ! function_exists( 'dv_uploads_audit_get_service_attachment_ids' )
    ) {
        return new WP_Error( 'missing_audit_engine', dv_uploads_tools_label( '&#1052;&#1086;&#1076;&#1091;&#1083;&#1100; &#1072;&#1091;&#1076;&#1080;&#1090;&#1072; &#1085;&#1077; &#1079;&#1072;&#1075;&#1088;&#1091;&#1078;&#1077;&#1085;.' ) );
    }

    $last_audit = dv_uploads_tools_get_last_audit();
    $report_config = dv_uploads_tools_report_config( $report_type );
    $report_path = isset( $last_audit[ $report_config['path_key'] ] ) ? wp_normalize_path( (string) $last_audit[ $report_config['path_key'] ] ) : '';

    if ( '' === $report_path || ! is_readable( $report_path ) ) {
        return new WP_Error( 'missing_report', dv_uploads_tools_label( '&#1057;&#1085;&#1072;&#1095;&#1072;&#1083;&#1072; &#1079;&#1072;&#1087;&#1091;&#1089;&#1090;&#1080;&#1090;&#1077; &#1072;&#1091;&#1076;&#1080;&#1090; uploads.' ) );
    }

    $uploads = wp_get_upload_dir();
    $uploads_base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );
    $rows = dv_uploads_tools_read_csv_report( $report_path );
    $backup_base_dir = trailingslashit( $uploads_base_dir ) . 'detalivam-uploads-trash-admin-' . $report_config['prefix'] . '-' . gmdate( 'Ymd-His' );
    $protected_files = dv_uploads_audit_get_attachment_files_for_ids( dv_uploads_audit_get_service_attachment_ids() );
    $results = array();
    $summary = array(
        'processed' => 0,
        'skipped'   => 0,
        'planned'   => 0,
        'moved'     => 0,
        'deleted'   => 0,
    );

    foreach ( $rows as $row ) {
        $result = dv_uploads_audit_delete_report_row(
            $row,
            $uploads_base_dir,
            $backup_base_dir,
            (bool) $confirm,
            true,
            max( 0, absint( $older_than_days ) ),
            $protected_files
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

    $out_dir = ! empty( $last_audit['out_dir'] ) ? untrailingslashit( wp_normalize_path( (string) $last_audit['out_dir'] ) ) : dirname( $report_path );
    wp_mkdir_p( $out_dir );

    $result_path = trailingslashit( $out_dir ) . ( $confirm ? 'moved-files-admin-' : 'delete-plan-admin-' ) . $report_config['prefix'] . '-' . gmdate( 'Ymd-His' ) . '.csv';
    dv_uploads_audit_write_csv(
        $result_path,
        array( 'path', 'action', 'reason', 'source', 'backup_path', 'size_bytes', 'modified' ),
        $results
    );

    $state = array(
        'generated_at'    => current_time( 'mysql' ),
        'confirm'         => (bool) $confirm,
        'report_type'     => $report_config['prefix'],
        'report_label'    => $report_config['label'],
        'older_than_days' => max( 0, absint( $older_than_days ) ),
        'report_path'     => $result_path,
        'backup_dir'      => $backup_base_dir,
        'summary'         => $summary,
    );

    update_option( dv_uploads_tools_last_delete_option_name(), $state, false );

    return $state;
}

function dv_uploads_tools_preview_report_rows( $last_audit, $report_type = 'unused', $limit = 12 ) {
    $report_config = dv_uploads_tools_report_config( $report_type );
    $report_path = isset( $last_audit[ $report_config['path_key'] ] ) ? wp_normalize_path( (string) $last_audit[ $report_config['path_key'] ] ) : '';
    $rows = dv_uploads_tools_read_csv_report( $report_path );

    if ( empty( $rows ) ) {
        return array(
            'total' => 0,
            'rows'  => array(),
        );
    }

    usort(
        $rows,
        static function ( $a, $b ) {
            return absint( $b['size_bytes'] ?? 0 ) <=> absint( $a['size_bytes'] ?? 0 );
        }
    );

    return array(
        'total' => count( $rows ),
        'rows'  => array_slice( $rows, 0, max( 1, absint( $limit ) ) ),
    );
}

function dv_uploads_tools_render_preview_table( $preview, $title, $is_open = false ) {
    if ( empty( $preview['rows'] ) ) {
        return;
    }
    ?>
    <details class="dv-uploads-preview"<?php echo $is_open ? ' open' : ''; ?>>
        <summary class="dv-uploads-preview-head">
            <strong><?php echo esc_html( $title ); ?></strong>
            <span><?php echo esc_html( sprintf( dv_uploads_tools_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1072;&#1085;&#1086; %1$d &#1080;&#1079; %2$d' ), count( $preview['rows'] ), absint( $preview['total'] ) ) ); ?></span>
        </summary>
        <table class="widefat striped dv-uploads-preview-table">
            <thead>
                <tr>
                    <th><?php echo esc_html( dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;' ) ); ?></th>
                    <th><?php echo esc_html( dv_uploads_tools_label( '&#1056;&#1072;&#1079;&#1084;&#1077;&#1088;' ) ); ?></th>
                    <th><?php echo esc_html( dv_uploads_tools_label( '&#1044;&#1072;&#1090;&#1072;' ) ); ?></th>
                    <th><?php echo esc_html( dv_uploads_tools_label( '&#1057;&#1090;&#1072;&#1090;&#1091;&#1089;' ) ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $preview['rows'] as $row ) : ?>
                    <tr>
                        <td><code><?php echo esc_html( (string) ( $row['path'] ?? '' ) ); ?></code></td>
                        <td><?php echo esc_html( size_format( absint( $row['size_bytes'] ?? 0 ) ) ); ?></td>
                        <td><?php echo esc_html( (string) ( $row['modified'] ?? '' ) ); ?></td>
                        <td>
                            <?php if ( 'yes' === strtolower( (string) ( $row['used'] ?? '' ) ) ) : ?>
                                <span class="dv-uploads-badge is-safe"><?php echo esc_html( dv_uploads_tools_label( '&#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1077;&#1090;&#1089;&#1103;' ) ); ?></span>
                            <?php elseif ( 'no' === (string) ( $row['in_media_library'] ?? '' ) ) : ?>
                                <span class="dv-uploads-badge is-warning"><?php echo esc_html( dv_uploads_tools_label( '&#1085;&#1077; &#1074; &#1084;&#1077;&#1076;&#1080;&#1072;' ) ); ?></span>
                            <?php else : ?>
                                <span class="dv-uploads-badge"><?php echo esc_html( dv_uploads_tools_label( '&#1085;&#1077;&#1090; &#1089;&#1089;&#1099;&#1083;&#1086;&#1082;' ) ); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </details>
    <?php
}

function dv_uploads_tools_is_service_candidate( $original_relative, $current_relative ) {
    $original_relative = dv_uploads_tools_normalize_relative_path( $original_relative );
    $current_relative = dv_uploads_tools_normalize_relative_path( $current_relative );

    if ( '' !== $current_relative && $original_relative === $current_relative ) {
        return true;
    }

    if ( '' !== $current_relative && strtolower( basename( $original_relative ) ) === strtolower( basename( $current_relative ) ) ) {
        return true;
    }

    $basename = strtolower( basename( $original_relative ) );

    foreach ( array( 'favicon', 'site-icon', 'apple-touch-icon', 'android-chrome', 'mstile', 'cropped' ) as $needle ) {
        if ( false !== strpos( $basename, $needle ) ) {
            return true;
        }
    }

    return false;
}

function dv_uploads_tools_find_restore_candidates( $limit = 80 ) {
    $uploads = wp_get_upload_dir();
    $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );
    $state = dv_uploads_tools_current_site_icon_state();
    $candidates = array();

    if ( ! is_dir( $base_dir ) ) {
        return $candidates;
    }

    $trash_dirs = glob( trailingslashit( $base_dir ) . 'detalivam-uploads-trash-*', GLOB_ONLYDIR );

    if ( ! is_array( $trash_dirs ) ) {
        return $candidates;
    }

    foreach ( $trash_dirs as $trash_dir ) {
        $trash_dir = untrailingslashit( wp_normalize_path( $trash_dir ) );

        if ( ! dv_uploads_tools_path_starts_with( $trash_dir, $base_dir ) ) {
            continue;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $trash_dir, FilesystemIterator::SKIP_DOTS )
        );

        foreach ( $iterator as $file ) {
            if ( ! $file instanceof SplFileInfo || ! $file->isFile() ) {
                continue;
            }

            $source_path = wp_normalize_path( $file->getPathname() );
            $original_relative = dv_uploads_tools_normalize_relative_path( substr( $source_path, strlen( $trash_dir ) ) );

            if ( ! dv_uploads_tools_is_service_candidate( $original_relative, $state['relative_path'] ) ) {
                continue;
            }

            $restore_path = wp_normalize_path( trailingslashit( $base_dir ) . $original_relative );
            $candidates[] = array(
                'source_path'       => $source_path,
                'trash_dir'         => $trash_dir,
                'original_relative' => $original_relative,
                'restore_path'      => $restore_path,
                'size'              => (int) $file->getSize(),
                'modified'          => gmdate( 'Y-m-d H:i:s', (int) $file->getMTime() ),
                'is_exact'          => '' !== $state['relative_path'] && $original_relative === $state['relative_path'],
                'restore_exists'    => is_file( $restore_path ),
            );
        }
    }

    usort(
        $candidates,
        static function ( $a, $b ) {
            if ( $a['is_exact'] !== $b['is_exact'] ) {
                return $a['is_exact'] ? -1 : 1;
            }

            return strcmp( $b['modified'], $a['modified'] );
        }
    );

    return array_slice( $candidates, 0, max( 1, absint( $limit ) ) );
}

function dv_uploads_tools_register_page() {
    add_submenu_page(
        'dv-theme-options',
        dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;&#1099;' ),
        dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;&#1099;' ),
        'manage_options',
        'dv-uploads-tools',
        'dv_uploads_tools_render_page'
    );
}
add_action( 'admin_menu', 'dv_uploads_tools_register_page', 35 );

function dv_uploads_tools_run_audit() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to manage these settings.', 'default' ) );
    }

    check_admin_referer( 'dv_uploads_run_audit' );

    $redirect = admin_url( 'admin.php?page=dv-uploads-tools' );

    if ( ! function_exists( 'dv_uploads_audit_build_report' ) || ! function_exists( 'dv_uploads_audit_write_reports' ) ) {
        wp_safe_redirect( add_query_arg( 'dv_uploads_status', 'audit-missing', $redirect ) );
        exit;
    }

    $extensions = array( 'jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'svg' );
    $uploads = wp_get_upload_dir();
    $out_dir = trailingslashit( $uploads['basedir'] ) . 'detalivam-uploads-audit-admin-' . gmdate( 'Ymd-His' );
    $report = dv_uploads_audit_build_report( $extensions );

    dv_uploads_audit_write_reports( $report, $out_dir );

    update_option(
        dv_uploads_tools_last_audit_option_name(),
        array(
            'generated_at' => current_time( 'mysql' ),
            'out_dir'      => untrailingslashit( wp_normalize_path( $out_dir ) ),
            'used_path'    => untrailingslashit( wp_normalize_path( $out_dir ) ) . '/used-files.csv',
            'unused_path'  => untrailingslashit( wp_normalize_path( $out_dir ) ) . '/unused-files.csv',
            'orphan_path'  => untrailingslashit( wp_normalize_path( $out_dir ) ) . '/orphan-files.csv',
            'missing_path' => untrailingslashit( wp_normalize_path( $out_dir ) ) . '/missing-files.csv',
            'summary'      => $report['summary'],
        ),
        false
    );

    wp_safe_redirect( add_query_arg( 'dv_uploads_status', 'audit-ok', $redirect ) );
    exit;
}
add_action( 'admin_post_dv_uploads_run_audit', 'dv_uploads_tools_run_audit' );

function dv_uploads_tools_make_delete_plan() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to manage these settings.', 'default' ) );
    }

    check_admin_referer( 'dv_uploads_delete_plan' );

    $older_than_days = isset( $_POST['older_than_days'] ) ? absint( wp_unslash( $_POST['older_than_days'] ) ) : 30;
    $report_type = isset( $_POST['report_type'] ) ? sanitize_key( wp_unslash( $_POST['report_type'] ) ) : 'unused';
    $result = dv_uploads_tools_process_delete_report( false, $older_than_days, $report_type );
    $status = is_wp_error( $result ) ? $result->get_error_code() : 'plan-ok';

    wp_safe_redirect( add_query_arg( 'dv_uploads_status', $status, admin_url( 'admin.php?page=dv-uploads-tools' ) ) );
    exit;
}
add_action( 'admin_post_dv_uploads_delete_plan', 'dv_uploads_tools_make_delete_plan' );

function dv_uploads_tools_move_unused_to_backup() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to manage these settings.', 'default' ) );
    }

    check_admin_referer( 'dv_uploads_move_unused' );

    $older_than_days = isset( $_POST['older_than_days'] ) ? absint( wp_unslash( $_POST['older_than_days'] ) ) : 30;
    $report_type = isset( $_POST['report_type'] ) ? sanitize_key( wp_unslash( $_POST['report_type'] ) ) : 'unused';
    $ack = isset( $_POST['dv_uploads_confirm_move'] ) ? sanitize_key( wp_unslash( $_POST['dv_uploads_confirm_move'] ) ) : '';
    $status = 'move-not-confirmed';

    if ( '1' === $ack ) {
        $result = dv_uploads_tools_process_delete_report( true, $older_than_days, $report_type );
        $status = is_wp_error( $result ) ? $result->get_error_code() : 'move-ok';
    }

    wp_safe_redirect( add_query_arg( 'dv_uploads_status', $status, admin_url( 'admin.php?page=dv-uploads-tools' ) ) );
    exit;
}
add_action( 'admin_post_dv_uploads_move_unused', 'dv_uploads_tools_move_unused_to_backup' );

function dv_uploads_tools_restore_candidate() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to manage these settings.', 'default' ) );
    }

    check_admin_referer( 'dv_uploads_restore_service_image' );

    $source = isset( $_POST['source_path'] ) ? wp_normalize_path( sanitize_text_field( wp_unslash( $_POST['source_path'] ) ) ) : '';
    $relative = isset( $_POST['original_relative'] ) ? dv_uploads_tools_normalize_relative_path( sanitize_text_field( wp_unslash( $_POST['original_relative'] ) ) ) : '';
    $uploads = wp_get_upload_dir();
    $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );
    $destination = wp_normalize_path( trailingslashit( $base_dir ) . $relative );
    $redirect = admin_url( 'admin.php?page=dv-uploads-tools' );

    if (
        '' === $source
        || '' === $relative
        || false !== strpos( $relative, '../' )
        || ! is_file( $source )
        || ! dv_uploads_tools_path_starts_with( $source, $base_dir )
        || false === strpos( $source, '/detalivam-uploads-trash-' )
        || ! dv_uploads_tools_path_starts_with( $destination, $base_dir )
    ) {
        wp_safe_redirect( add_query_arg( 'dv_restore', 'invalid', $redirect ) );
        exit;
    }

    wp_mkdir_p( dirname( $destination ) );

    if ( is_file( $destination ) ) {
        wp_safe_redirect( add_query_arg( 'dv_restore', 'exists', $redirect ) );
        exit;
    }

    if ( ! copy( $source, $destination ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.copy_copy
        wp_safe_redirect( add_query_arg( 'dv_restore', 'failed', $redirect ) );
        exit;
    }

    clearstatcache( true, $destination );
    wp_safe_redirect( add_query_arg( 'dv_restore', 'ok', $redirect ) );
    exit;
}
add_action( 'admin_post_dv_uploads_restore_service_image', 'dv_uploads_tools_restore_candidate' );

function dv_uploads_tools_render_notice() {
    $status = isset( $_GET['dv_restore'] ) ? sanitize_key( wp_unslash( $_GET['dv_restore'] ) ) : '';
    $uploads_status = isset( $_GET['dv_uploads_status'] ) ? sanitize_key( wp_unslash( $_GET['dv_uploads_status'] ) ) : '';

    if ( '' === $status && '' === $uploads_status ) {
        return;
    }

    $messages = array(
        'ok'      => array( 'success', dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083; &#1074;&#1086;&#1089;&#1089;&#1090;&#1072;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085; &#1074; uploads.' ) ),
        'exists'  => array( 'warning', dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083; &#1091;&#1078;&#1077; &#1077;&#1089;&#1090;&#1100; &#1074; &#1080;&#1089;&#1093;&#1086;&#1076;&#1085;&#1086;&#1084; &#1087;&#1091;&#1090;&#1080;.' ) ),
        'invalid' => array( 'error', dv_uploads_tools_label( '&#1053;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100; &#1087;&#1091;&#1090;&#1080; &#1092;&#1072;&#1081;&#1083;&#1072;.' ) ),
        'failed'  => array( 'error', dv_uploads_tools_label( '&#1053;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1089;&#1082;&#1086;&#1087;&#1080;&#1088;&#1086;&#1074;&#1072;&#1090;&#1100; &#1092;&#1072;&#1081;&#1083;.' ) ),
    );

    $uploads_messages = array(
        'audit-ok'           => array( 'success', dv_uploads_tools_label( '&#1040;&#1091;&#1076;&#1080;&#1090; uploads &#1075;&#1086;&#1090;&#1086;&#1074;.' ) ),
        'audit-missing'      => array( 'error', dv_uploads_tools_label( '&#1052;&#1086;&#1076;&#1091;&#1083;&#1100; &#1072;&#1091;&#1076;&#1080;&#1090;&#1072; &#1085;&#1077; &#1079;&#1072;&#1075;&#1088;&#1091;&#1078;&#1077;&#1085;.' ) ),
        'missing_audit_engine' => array( 'error', dv_uploads_tools_label( '&#1052;&#1086;&#1076;&#1091;&#1083;&#1100; &#1072;&#1091;&#1076;&#1080;&#1090;&#1072; &#1085;&#1077; &#1079;&#1072;&#1075;&#1088;&#1091;&#1078;&#1077;&#1085;.' ) ),
        'missing_report'     => array( 'warning', dv_uploads_tools_label( '&#1057;&#1085;&#1072;&#1095;&#1072;&#1083;&#1072; &#1079;&#1072;&#1087;&#1091;&#1089;&#1090;&#1080;&#1090;&#1077; &#1072;&#1091;&#1076;&#1080;&#1090; uploads.' ) ),
        'plan-ok'            => array( 'success', dv_uploads_tools_label( '&#1055;&#1083;&#1072;&#1085; &#1091;&#1076;&#1072;&#1083;&#1077;&#1085;&#1080;&#1103; &#1089;&#1086;&#1079;&#1076;&#1072;&#1085;.' ) ),
        'move-ok'            => array( 'success', dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;&#1099; &#1087;&#1077;&#1088;&#1077;&#1085;&#1077;&#1089;&#1077;&#1085;&#1099; &#1074; backup-&#1087;&#1072;&#1087;&#1082;&#1091;.' ) ),
        'move-not-confirmed' => array( 'warning', dv_uploads_tools_label( '&#1055;&#1086;&#1076;&#1090;&#1074;&#1077;&#1088;&#1076;&#1080;&#1090;&#1077; &#1087;&#1077;&#1088;&#1077;&#1085;&#1086;&#1089; &#1092;&#1072;&#1081;&#1083;&#1086;&#1074; &#1095;&#1077;&#1082;&#1073;&#1086;&#1082;&#1089;&#1086;&#1084;.' ) ),
    );

    if ( '' !== $status && ! empty( $messages[ $status ] ) ) {
        list( $type, $message ) = $messages[ $status ];
        echo '<div class="notice notice-' . esc_attr( $type ) . ' is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
    }

    if ( '' !== $uploads_status && ! empty( $uploads_messages[ $uploads_status ] ) ) {
        list( $type, $message ) = $uploads_messages[ $uploads_status ];
        echo '<div class="notice notice-' . esc_attr( $type ) . ' is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
    }
}

function dv_uploads_tools_render_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to manage these settings.', 'default' ) );
    }

    $state = dv_uploads_tools_current_site_icon_state();
    $candidates = dv_uploads_tools_find_restore_candidates();
    $last_audit = dv_uploads_tools_get_last_audit();
    $last_delete = dv_uploads_tools_get_last_delete();
    $audit_summary = isset( $last_audit['summary'] ) && is_array( $last_audit['summary'] ) ? $last_audit['summary'] : array();
    $delete_summary = isset( $last_delete['summary'] ) && is_array( $last_delete['summary'] ) ? $last_delete['summary'] : array();
    $unused_preview = ! empty( $last_audit ) ? dv_uploads_tools_preview_report_rows( $last_audit, 'unused' ) : array( 'total' => 0, 'rows' => array() );
    $orphan_preview = ! empty( $last_audit ) ? dv_uploads_tools_preview_report_rows( $last_audit, 'orphan' ) : array( 'total' => 0, 'rows' => array() );
    ?>
    <div class="wrap dv-suite-page dv-uploads-tools-page">
        <?php
        if ( function_exists( 'dv_render_admin_suite_header' ) ) {
            dv_render_admin_suite_header(
                'dv-uploads-tools',
                dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;&#1099;' ),
                dv_uploads_tools_label( '&#1044;&#1080;&#1072;&#1075;&#1085;&#1086;&#1089;&#1090;&#1080;&#1082;&#1072; favicon &#1080; &#1074;&#1086;&#1089;&#1089;&#1090;&#1072;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085;&#1080;&#1077; &#1092;&#1072;&#1081;&#1083;&#1086;&#1074; &#1080;&#1079; &#1087;&#1072;&#1087;&#1082;&#1080; &#1088;&#1077;&#1079;&#1077;&#1088;&#1074;&#1072;.' )
            );
        } else {
            echo '<h1>' . esc_html( dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;&#1099;' ) ) . '</h1>';
        }

        dv_uploads_tools_render_notice();
        ?>

        <nav class="dv-uploads-page-nav" aria-label="<?php echo esc_attr( dv_uploads_tools_label( '&#1053;&#1072;&#1074;&#1080;&#1075;&#1072;&#1094;&#1080;&#1103; &#1087;&#1086; &#1092;&#1072;&#1081;&#1083;&#1072;&#1084;' ) ); ?>">
            <a href="#dv-uploads-audit"><?php echo esc_html( dv_uploads_tools_label( '&#1040;&#1091;&#1076;&#1080;&#1090;' ) ); ?></a>
            <a href="#dv-uploads-cleanup"><?php echo esc_html( dv_uploads_tools_label( '&#1054;&#1095;&#1080;&#1089;&#1090;&#1082;&#1072;' ) ); ?></a>
            <a href="#dv-uploads-favicon">Favicon</a>
            <?php if ( ! $state['file_exists'] ) : ?>
                <a href="#dv-uploads-restore"><?php echo esc_html( dv_uploads_tools_label( '&#1042;&#1086;&#1089;&#1089;&#1090;&#1072;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085;&#1080;&#1077;' ) ); ?></a>
            <?php endif; ?>
        </nav>

        <div class="dv-admin-card dv-uploads-card" id="dv-uploads-audit">
            <div class="dv-uploads-card-head">
                <div>
            <h2><?php echo esc_html( dv_uploads_tools_label( '&#1040;&#1091;&#1076;&#1080;&#1090; uploads' ) ); ?></h2>
            <p><?php echo esc_html( dv_uploads_tools_label( '&#1057;&#1082;&#1072;&#1085;&#1080;&#1088;&#1091;&#1077;&#1090; &#1082;&#1072;&#1088;&#1090;&#1080;&#1085;&#1082;&#1080; &#1074; uploads, &#1084;&#1077;&#1076;&#1080;&#1072;&#1073;&#1080;&#1073;&#1083;&#1080;&#1086;&#1090;&#1077;&#1082;&#1091;, &#1090;&#1086;&#1074;&#1072;&#1088;&#1099;, &#1082;&#1086;&#1085;&#1090;&#1077;&#1085;&#1090;, &#1086;&#1087;&#1094;&#1080;&#1080; &#1080; &#1089;&#1086;&#1079;&#1076;&#1072;&#1077;&#1090; CSV-&#1086;&#1090;&#1095;&#1077;&#1090;&#1099;.' ) ); ?></p>
                </div>

            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <?php wp_nonce_field( 'dv_uploads_run_audit' ); ?>
                <input type="hidden" name="action" value="dv_uploads_run_audit">
                <button type="submit" class="button button-primary"><?php echo esc_html( dv_uploads_tools_label( '&#1047;&#1072;&#1087;&#1091;&#1089;&#1090;&#1080;&#1090;&#1100; &#1072;&#1091;&#1076;&#1080;&#1090;' ) ); ?></button>
            </form>
            </div>

            <?php if ( ! empty( $last_audit ) ) : ?>
                <hr>
                <p class="dv-uploads-muted">
                    <strong><?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1086;&#1089;&#1083;&#1077;&#1076;&#1085;&#1080;&#1081; &#1072;&#1091;&#1076;&#1080;&#1090;:' ) ); ?></strong>
                    <?php echo esc_html( (string) ( $last_audit['generated_at'] ?? '' ) ); ?>
                    <br><code><?php echo esc_html( (string) ( $last_audit['out_dir'] ?? '' ) ); ?></code>
                </p>
                <div class="dv-uploads-metrics">
                    <div><span><?php echo esc_html( dv_uploads_tools_label( '&#1042;&#1089;&#1077;&#1075;&#1086; &#1092;&#1072;&#1081;&#1083;&#1086;&#1074;' ) ); ?></span><strong><?php echo esc_html( (string) ( $audit_summary['scanned_files'] ?? 0 ) ); ?></strong></div>
                    <div><span><?php echo esc_html( dv_uploads_tools_label( '&#1048;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1102;&#1090;&#1089;&#1103;' ) ); ?></span><strong><?php echo esc_html( (string) ( $audit_summary['used_files'] ?? 0 ) ); ?></strong></div>
                    <div><span><?php echo esc_html( dv_uploads_tools_label( '&#1050;&#1072;&#1085;&#1076;&#1080;&#1076;&#1072;&#1090;&#1099;' ) ); ?></span><strong><?php echo esc_html( (string) ( $audit_summary['unused_files'] ?? 0 ) ); ?></strong></div>
                    <div><span><?php echo esc_html( dv_uploads_tools_label( 'Orphan' ) ); ?></span><strong><?php echo esc_html( (string) ( $audit_summary['orphan_files'] ?? 0 ) ); ?></strong></div>
                    <div><span><?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1088;&#1086;&#1087;&#1091;&#1097;&#1077;&#1085;&#1086; &#1087;&#1072;&#1087;&#1086;&#1082;' ) ); ?></span><strong><?php echo esc_html( (string) ( $audit_summary['skipped_dirs'] ?? 0 ) ); ?></strong></div>
                </div>
                <p class="dv-uploads-actions">
                    <?php foreach ( array( 'used_path' => 'used-files.csv', 'unused_path' => 'unused-files.csv', 'orphan_path' => 'orphan-files.csv', 'missing_path' => 'missing-files.csv' ) as $key => $label ) : ?>
                        <?php $url = dv_uploads_tools_file_url( $last_audit[ $key ] ?? '' ); ?>
                        <?php if ( $url ) : ?>
                            <a class="button" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $label ); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>
                <?php dv_uploads_tools_render_preview_table( $unused_preview, dv_uploads_tools_label( 'Unused: &#1085;&#1077;&#1090; &#1089;&#1089;&#1099;&#1083;&#1086;&#1082; &#1085;&#1072; &#1092;&#1072;&#1081;&#1083;' ), true ); ?>
                <?php dv_uploads_tools_render_preview_table( $orphan_preview, dv_uploads_tools_label( 'Orphan: &#1092;&#1072;&#1081;&#1083; &#1085;&#1077; &#1074; &#1084;&#1077;&#1076;&#1080;&#1072;&#1073;&#1080;&#1073;&#1083;&#1080;&#1086;&#1090;&#1077;&#1082;&#1077;' ), false ); ?>
            <?php endif; ?>
        </div>

        <div class="dv-admin-card dv-uploads-card" id="dv-uploads-cleanup">
            <h2><?php echo esc_html( dv_uploads_tools_label( '&#1059;&#1076;&#1072;&#1083;&#1077;&#1085;&#1080;&#1077; &#1085;&#1077;&#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1077;&#1084;&#1099;&#1093;' ) ); ?></h2>
            <p><?php echo esc_html( dv_uploads_tools_label( '&#1040;&#1076;&#1084;&#1080;&#1085;&#1082;&#1072; &#1085;&#1077; &#1091;&#1076;&#1072;&#1083;&#1103;&#1077;&#1090; &#1092;&#1072;&#1081;&#1083;&#1099; &#1085;&#1072;&#1074;&#1089;&#1077;&#1075;&#1076;&#1072;: &#1086;&#1085;&#1080; &#1087;&#1077;&#1088;&#1077;&#1085;&#1086;&#1089;&#1103;&#1090;&#1089;&#1103; &#1074; backup-&#1087;&#1072;&#1087;&#1082;&#1091; &#1074; uploads. Favicon &#1080; site icon &#1079;&#1072;&#1097;&#1080;&#1097;&#1077;&#1085;&#1099;.' ) ); ?></p>

            <div class="dv-uploads-cleanup-panel">
                <h3>Unused</h3>
                <p><?php echo esc_html( dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;&#1099; &#1080;&#1079; unused-files.csv: &#1077;&#1089;&#1090;&#1100; &#1074; uploads, &#1085;&#1086; &#1072;&#1091;&#1076;&#1080;&#1090; &#1085;&#1077; &#1085;&#1072;&#1096;&#1077;&#1083; &#1080;&#1093; &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1086;&#1074;&#1072;&#1085;&#1080;&#1077;.' ) ); ?></p>
            <form class="dv-uploads-inline-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <?php wp_nonce_field( 'dv_uploads_delete_plan' ); ?>
                <input type="hidden" name="action" value="dv_uploads_delete_plan">
                <input type="hidden" name="report_type" value="unused">
                <label>
                    <?php echo esc_html( dv_uploads_tools_label( '&#1057;&#1090;&#1072;&#1088;&#1096;&#1077; &#1076;&#1085;&#1077;&#1081;' ) ); ?>
                    <input type="number" name="older_than_days" min="0" max="3650" value="30" class="small-text">
                </label>
                <button type="submit" class="button"><?php echo esc_html( dv_uploads_tools_label( '&#1057;&#1086;&#1079;&#1076;&#1072;&#1090;&#1100; &#1087;&#1083;&#1072;&#1085;' ) ); ?></button>
            </form>

            <form class="dv-uploads-inline-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <?php wp_nonce_field( 'dv_uploads_move_unused' ); ?>
                <input type="hidden" name="action" value="dv_uploads_move_unused">
                <input type="hidden" name="report_type" value="unused">
                <label>
                    <?php echo esc_html( dv_uploads_tools_label( '&#1057;&#1090;&#1072;&#1088;&#1096;&#1077; &#1076;&#1085;&#1077;&#1081;' ) ); ?>
                    <input type="number" name="older_than_days" min="0" max="3650" value="30" class="small-text">
                </label>
                <label>
                    <input type="checkbox" name="dv_uploads_confirm_move" value="1">
                    <?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1086;&#1076;&#1090;&#1074;&#1077;&#1088;&#1078;&#1076;&#1072;&#1102; &#1087;&#1077;&#1088;&#1077;&#1085;&#1086;&#1089; &#1074; backup' ) ); ?>
                </label>
                <button type="submit" class="button button-primary"><?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1077;&#1088;&#1077;&#1085;&#1077;&#1089;&#1090;&#1080; &#1074; backup' ) ); ?></button>
            </form>
            </div>

            <div class="dv-uploads-cleanup-panel">
                <h3>Orphan</h3>
                <p><?php echo esc_html( dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;&#1099; &#1080;&#1079; orphan-files.csv: &#1085;&#1077; &#1087;&#1088;&#1080;&#1074;&#1103;&#1079;&#1072;&#1085;&#1099; &#1082; &#1084;&#1077;&#1076;&#1080;&#1072;&#1073;&#1080;&#1073;&#1083;&#1080;&#1086;&#1090;&#1077;&#1082;&#1077;. &#1057;&#1090;&#1088;&#1086;&#1082;&#1080; used=yes &#1073;&#1091;&#1076;&#1091;&#1090; &#1087;&#1088;&#1086;&#1087;&#1091;&#1097;&#1077;&#1085;&#1099;.' ) ); ?></p>
                <form class="dv-uploads-inline-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                    <?php wp_nonce_field( 'dv_uploads_delete_plan' ); ?>
                    <input type="hidden" name="action" value="dv_uploads_delete_plan">
                    <input type="hidden" name="report_type" value="orphan">
                    <label>
                        <?php echo esc_html( dv_uploads_tools_label( '&#1057;&#1090;&#1072;&#1088;&#1096;&#1077; &#1076;&#1085;&#1077;&#1081;' ) ); ?>
                        <input type="number" name="older_than_days" min="0" max="3650" value="30" class="small-text">
                    </label>
                    <button type="submit" class="button"><?php echo esc_html( dv_uploads_tools_label( '&#1057;&#1086;&#1079;&#1076;&#1072;&#1090;&#1100; &#1087;&#1083;&#1072;&#1085;' ) ); ?></button>
                </form>

                <form class="dv-uploads-inline-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                    <?php wp_nonce_field( 'dv_uploads_move_unused' ); ?>
                    <input type="hidden" name="action" value="dv_uploads_move_unused">
                    <input type="hidden" name="report_type" value="orphan">
                    <label>
                        <?php echo esc_html( dv_uploads_tools_label( '&#1057;&#1090;&#1072;&#1088;&#1096;&#1077; &#1076;&#1085;&#1077;&#1081;' ) ); ?>
                        <input type="number" name="older_than_days" min="0" max="3650" value="30" class="small-text">
                    </label>
                    <label>
                        <input type="checkbox" name="dv_uploads_confirm_move" value="1">
                        <?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1086;&#1076;&#1090;&#1074;&#1077;&#1088;&#1078;&#1076;&#1072;&#1102; &#1087;&#1077;&#1088;&#1077;&#1085;&#1086;&#1089; Orphan &#1074; backup' ) ); ?>
                    </label>
                    <button type="submit" class="button button-primary"><?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1077;&#1088;&#1077;&#1085;&#1077;&#1089;&#1090;&#1080; Orphan &#1074; backup' ) ); ?></button>
                </form>
            </div>

            <?php if ( ! empty( $last_delete ) ) : ?>
                <hr>
                <p>
                    <strong><?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1086;&#1089;&#1083;&#1077;&#1076;&#1085;&#1077;&#1077; &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1077;:' ) ); ?></strong>
                    <?php echo esc_html( (string) ( $last_delete['report_label'] ?? 'Unused' ) ); ?> /
                    <?php echo ! empty( $last_delete['confirm'] ) ? esc_html( dv_uploads_tools_label( '&#1087;&#1077;&#1088;&#1077;&#1085;&#1086;&#1089;' ) ) : esc_html( dv_uploads_tools_label( '&#1087;&#1083;&#1072;&#1085;' ) ); ?>
                    <?php echo esc_html( (string) ( $last_delete['generated_at'] ?? '' ) ); ?>
                </p>
                <p>
                    <?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1083;&#1072;&#1085;:' ) ); ?> <?php echo esc_html( (string) ( $delete_summary['planned'] ?? 0 ) ); ?>,
                    <?php echo esc_html( dv_uploads_tools_label( '&#1087;&#1077;&#1088;&#1077;&#1085;&#1077;&#1089;&#1077;&#1085;&#1086;:' ) ); ?> <?php echo esc_html( (string) ( $delete_summary['moved'] ?? 0 ) ); ?>,
                    <?php echo esc_html( dv_uploads_tools_label( '&#1087;&#1088;&#1086;&#1087;&#1091;&#1097;&#1077;&#1085;&#1086;:' ) ); ?> <?php echo esc_html( (string) ( $delete_summary['skipped'] ?? 0 ) ); ?>
                </p>
                <?php $delete_url = dv_uploads_tools_file_url( $last_delete['report_path'] ?? '' ); ?>
                <?php if ( $delete_url ) : ?>
                    <p><a class="button" href="<?php echo esc_url( $delete_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( basename( (string) $last_delete['report_path'] ) ); ?></a></p>
                <?php endif; ?>
                <?php if ( ! empty( $last_delete['backup_dir'] ) && ! empty( $last_delete['confirm'] ) ) : ?>
                    <p><code><?php echo esc_html( (string) $last_delete['backup_dir'] ); ?></code></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="dv-admin-card dv-uploads-card" id="dv-uploads-favicon">
            <h2><?php echo esc_html( dv_uploads_tools_label( 'Favicon / site icon' ) ); ?></h2>
            <table class="widefat striped dv-uploads-state-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo esc_html( dv_uploads_tools_label( 'Attachment ID' ) ); ?></th>
                        <td><?php echo $state['site_icon_id'] ? esc_html( (string) $state['site_icon_id'] ) : '&mdash;'; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1091;&#1090;&#1100; &#1074; &#1073;&#1072;&#1079;&#1077;' ) ); ?></th>
                        <td><code><?php echo esc_html( $state['relative_path'] ?: '-' ); ?></code></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo esc_html( dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;' ) ); ?></th>
                        <td>
                            <?php if ( $state['file_exists'] ) : ?>
                                <strong style="color:#008a20;"><?php echo esc_html( dv_uploads_tools_label( '&#1053;&#1072; &#1084;&#1077;&#1089;&#1090;&#1077;' ) ); ?></strong>
                                <br><code><?php echo esc_html( $state['absolute_path'] ); ?></code>
                            <?php else : ?>
                                <strong style="color:#b32d2e;"><?php echo esc_html( dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;' ) ); ?></strong>
                                <?php if ( $state['absolute_path'] ) : ?>
                                    <br><code><?php echo esc_html( $state['absolute_path'] ); ?></code>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if ( $state['url'] ) : ?>
                        <tr>
                            <th scope="row"><?php echo esc_html( dv_uploads_tools_label( '&#1055;&#1088;&#1077;&#1074;&#1100;&#1102;' ) ); ?></th>
                            <td><img src="<?php echo esc_url( $state['url'] ); ?>" alt="" style="width:64px;height:64px;object-fit:contain;border:1px solid #dcdcde;border-radius:8px;background:#fff;"></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ( ! $state['file_exists'] ) : ?>
            <div class="dv-admin-card dv-uploads-card" id="dv-uploads-restore">
                <h2><?php echo esc_html( dv_uploads_tools_label( '&#1042;&#1086;&#1089;&#1089;&#1090;&#1072;&#1085;&#1086;&#1074;&#1080;&#1090;&#1100; favicon' ) ); ?></h2>
                <p><?php echo esc_html( dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083; site_icon &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085; &#1085;&#1072; &#1084;&#1077;&#1089;&#1090;&#1077;. &#1048;&#1097;&#1077;&#1084; &#1087;&#1086;&#1076;&#1093;&#1086;&#1076;&#1103;&#1097;&#1080;&#1081; &#1092;&#1072;&#1081;&#1083; &#1074; wp-content/uploads/detalivam-uploads-trash-*.' ) ); ?></p>

                <?php if ( empty( $candidates ) ) : ?>
                    <p><strong><?php echo esc_html( dv_uploads_tools_label( '&#1050;&#1072;&#1085;&#1076;&#1080;&#1076;&#1072;&#1090;&#1099; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1099;.' ) ); ?></strong></p>
                <?php else : ?>
                    <table class="widefat striped">
                        <thead>
                            <tr>
                                <th><?php echo esc_html( dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083;' ) ); ?></th>
                                <th><?php echo esc_html( dv_uploads_tools_label( '&#1050;&#1091;&#1076;&#1072; &#1074;&#1077;&#1088;&#1085;&#1077;&#1090;&#1089;&#1103;' ) ); ?></th>
                                <th><?php echo esc_html( dv_uploads_tools_label( '&#1056;&#1072;&#1079;&#1084;&#1077;&#1088;' ) ); ?></th>
                                <th><?php echo esc_html( dv_uploads_tools_label( '&#1044;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1077;' ) ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $candidates as $candidate ) : ?>
                                <tr>
                                    <td>
                                        <?php if ( $candidate['is_exact'] ) : ?>
                                            <strong style="color:#0073e6;"><?php echo esc_html( dv_uploads_tools_label( '&#1058;&#1086;&#1095;&#1085;&#1086;&#1077; &#1089;&#1086;&#1074;&#1087;&#1072;&#1076;&#1077;&#1085;&#1080;&#1077;' ) ); ?></strong><br>
                                        <?php endif; ?>
                                        <code><?php echo esc_html( $candidate['source_path'] ); ?></code>
                                        <br><small><?php echo esc_html( $candidate['modified'] ); ?></small>
                                    </td>
                                    <td><code><?php echo esc_html( $candidate['restore_path'] ); ?></code></td>
                                    <td><?php echo esc_html( size_format( $candidate['size'] ) ); ?></td>
                                    <td>
                                        <?php if ( $candidate['restore_exists'] ) : ?>
                                            <span class="button disabled"><?php echo esc_html( dv_uploads_tools_label( '&#1059;&#1078;&#1077; &#1077;&#1089;&#1090;&#1100;' ) ); ?></span>
                                        <?php else : ?>
                                            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                                                <?php wp_nonce_field( 'dv_uploads_restore_service_image' ); ?>
                                                <input type="hidden" name="action" value="dv_uploads_restore_service_image">
                                                <input type="hidden" name="source_path" value="<?php echo esc_attr( $candidate['source_path'] ); ?>">
                                                <input type="hidden" name="original_relative" value="<?php echo esc_attr( $candidate['original_relative'] ); ?>">
                                                <button type="submit" class="button button-primary"><?php echo esc_html( dv_uploads_tools_label( '&#1042;&#1086;&#1089;&#1089;&#1090;&#1072;&#1085;&#1086;&#1074;&#1080;&#1090;&#1100;' ) ); ?></button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
