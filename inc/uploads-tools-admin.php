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

    if ( '' === $status ) {
        return;
    }

    $messages = array(
        'ok'      => array( 'success', dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083; &#1074;&#1086;&#1089;&#1089;&#1090;&#1072;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085; &#1074; uploads.' ) ),
        'exists'  => array( 'warning', dv_uploads_tools_label( '&#1060;&#1072;&#1081;&#1083; &#1091;&#1078;&#1077; &#1077;&#1089;&#1090;&#1100; &#1074; &#1080;&#1089;&#1093;&#1086;&#1076;&#1085;&#1086;&#1084; &#1087;&#1091;&#1090;&#1080;.' ) ),
        'invalid' => array( 'error', dv_uploads_tools_label( '&#1053;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100; &#1087;&#1091;&#1090;&#1080; &#1092;&#1072;&#1081;&#1083;&#1072;.' ) ),
        'failed'  => array( 'error', dv_uploads_tools_label( '&#1053;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1089;&#1082;&#1086;&#1087;&#1080;&#1088;&#1086;&#1074;&#1072;&#1090;&#1100; &#1092;&#1072;&#1081;&#1083;.' ) ),
    );

    if ( empty( $messages[ $status ] ) ) {
        return;
    }

    list( $type, $message ) = $messages[ $status ];
    echo '<div class="notice notice-' . esc_attr( $type ) . ' is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
}

function dv_uploads_tools_render_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to manage these settings.', 'default' ) );
    }

    $state = dv_uploads_tools_current_site_icon_state();
    $candidates = dv_uploads_tools_find_restore_candidates();
    ?>
    <div class="wrap dv-suite-wrap">
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

        <div class="dv-admin-card">
            <h2><?php echo esc_html( dv_uploads_tools_label( 'Favicon / site icon' ) ); ?></h2>
            <table class="widefat striped">
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

        <div class="dv-admin-card">
            <h2><?php echo esc_html( dv_uploads_tools_label( '&#1050;&#1072;&#1085;&#1076;&#1080;&#1076;&#1072;&#1090;&#1099; &#1076;&#1083;&#1103; &#1074;&#1086;&#1089;&#1089;&#1090;&#1072;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085;&#1080;&#1103;' ) ); ?></h2>
            <p><?php echo esc_html( dv_uploads_tools_label( '&#1048;&#1097;&#1077;&#1084; &#1074; wp-content/uploads/detalivam-uploads-trash-* &#1092;&#1072;&#1081;&#1083;&#1099;, &#1087;&#1086;&#1093;&#1086;&#1078;&#1080;&#1077; &#1085;&#1072; favicon &#1080;&#1083;&#1080; &#1090;&#1077;&#1082;&#1091;&#1097;&#1080;&#1081; site_icon.' ) ); ?></p>

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
    </div>
    <?php
}
