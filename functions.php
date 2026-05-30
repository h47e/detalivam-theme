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
    'inc/seo-admin.php',
    'inc/store-admin.php',
    'inc/theme-content-admin.php',
    'inc/lists.php',
    'inc/search.php',
    'inc/cart.php',
    'inc/slugs.php',
    'inc/wholesale.php',
    'inc/template-functions.php',
    'inc/woocommerce.php',
);

foreach ( $dv_theme_modules as $dv_theme_module ) {
    dv_require_theme_module( $dv_theme_module );
}
