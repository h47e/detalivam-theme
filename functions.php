<?php
/**
 * DetaliVam theme bootstrap.
 */
defined( 'ABSPATH' ) || exit;

define( 'DV_VERSION', '1.0.2' );
define( 'DV_DIR', get_template_directory() );
define( 'DV_URI', get_template_directory_uri() );

function dv_require_theme_module( $relative_path ) {
    $path = DV_DIR . '/' . ltrim( (string) $relative_path, '/' );

    if ( ! file_exists( $path ) ) {
        wp_die( esc_html( 'Required theme module is missing: ' . $relative_path ) );
    }

    require_once $path;
}

$dv_theme_modules = array(
    'inc/theme-core.php',
    'inc/theme-options.php',
    'inc/service-pages.php',
    'inc/seo.php',
    'inc/product-feed.php',
    'inc/theme-content.php',
    'inc/lists.php',
    'inc/search.php',
    'inc/cart.php',
    'inc/wholesale.php',
    'inc/template-functions.php',
    'inc/woocommerce.php',
);

foreach ( $dv_theme_modules as $dv_theme_module ) {
    dv_require_theme_module( $dv_theme_module );
}

function dv_is_admin_module_request() {
    if ( defined( 'WP_CLI' ) && WP_CLI ) {
        return true;
    }

    if ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) {
        return true;
    }

    if ( ! is_admin() ) {
        return false;
    }

    if ( ! function_exists( 'wp_doing_ajax' ) || ! wp_doing_ajax() ) {
        return true;
    }

    $action = isset( $_REQUEST['action'] ) ? sanitize_key( wp_unslash( $_REQUEST['action'] ) ) : '';

    return ! in_array(
        $action,
        array(
            'dv_add_to_cart',
            'dv_get_compare_table',
            'dv_get_header_cart_preview',
            'dv_get_header_list_preview',
            'dv_get_wishlist_products',
            'dv_live_search',
            'dv_toggle_wishlist',
            'dv_update_header_cart_item_qty',
        ),
        true
    );
}

if ( dv_is_admin_module_request() ) {
    foreach ( array( 'inc/theme-options-admin.php', 'inc/seo-sitemap.php', 'inc/seo-admin.php', 'inc/store-admin.php', 'inc/theme-content-admin.php', 'inc/slugs.php', 'inc/uploads-audit-cli.php', 'inc/uploads-tools-admin.php' ) as $dv_theme_admin_module ) {
        dv_require_theme_module( $dv_theme_admin_module );
    }
}
