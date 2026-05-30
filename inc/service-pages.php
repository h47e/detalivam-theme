<?php
/**
 * Virtual service pages for theme-owned informational URLs.
 */
defined( 'ABSPATH' ) || exit;

function dv_reserved_service_page_slugs() {
    return array(
        'o-kompanii',
        'about',
        'dostavka',
        'delivery',
        'kontakty',
        'contacts',
        'vozvrat',
        'return',
        'politika-konfidencialnosti',
        'privacy-policy',
        'polzovatelskoe-soglashenie',
        'publichna-oferta',
        'user-agreement',
    );
}

function dv_virtual_service_page_map() {
    $map = array(
        'o-kompanii' => array(
            'template' => DV_DIR . '/page-o-kompanii.php',
            'title'    => html_entity_decode( '&#1054; &#1082;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'about',
        ),
        'about'      => array(
            'template' => DV_DIR . '/page-o-kompanii.php',
            'title'    => html_entity_decode( '&#1054; &#1082;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'about',
        ),
        'dostavka'   => array(
            'template' => DV_DIR . '/page-dostavka.php',
            'title'    => html_entity_decode( '&#1044;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'delivery',
        ),
        'delivery'   => array(
            'template' => DV_DIR . '/page-dostavka.php',
            'title'    => html_entity_decode( '&#1044;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'delivery',
        ),
        'kontakty'   => array(
            'template' => DV_DIR . '/page-kontakty.php',
            'title'    => html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'contacts',
        ),
        'contacts'   => array(
            'template' => DV_DIR . '/page-kontakty.php',
            'title'    => html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'contacts',
        ),
        'vozvrat'    => array(
            'template' => DV_DIR . '/page-vozvrat.php',
            'title'    => html_entity_decode( '&#1042;&#1086;&#1079;&#1074;&#1088;&#1072;&#1090; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'return',
        ),
        'return'     => array(
            'template' => DV_DIR . '/page-vozvrat.php',
            'title'    => html_entity_decode( '&#1042;&#1086;&#1079;&#1074;&#1088;&#1072;&#1090; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'return',
        ),
        'politika-konfidencialnosti' => array(
            'template' => DV_DIR . '/page-politika-konfidencialnosti.php',
            'title'    => html_entity_decode( '&#1055;&#1086;&#1083;&#1080;&#1090;&#1080;&#1082;&#1072; &#1082;&#1086;&#1085;&#1092;&#1080;&#1076;&#1077;&#1085;&#1094;&#1080;&#1072;&#1083;&#1100;&#1085;&#1086;&#1089;&#1090;&#1080;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'privacy',
        ),
        'privacy-policy' => array(
            'template' => DV_DIR . '/page-politika-konfidencialnosti.php',
            'title'    => html_entity_decode( '&#1055;&#1086;&#1083;&#1080;&#1090;&#1080;&#1082;&#1072; &#1082;&#1086;&#1085;&#1092;&#1080;&#1076;&#1077;&#1085;&#1094;&#1080;&#1072;&#1083;&#1100;&#1085;&#1086;&#1089;&#1090;&#1080;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'privacy',
        ),
        'polzovatelskoe-soglashenie' => array(
            'template' => DV_DIR . '/page-polzovatelskoe-soglashenie.php',
            'title'    => html_entity_decode( '&#1055;&#1086;&#1083;&#1100;&#1079;&#1086;&#1074;&#1072;&#1090;&#1077;&#1083;&#1100;&#1089;&#1082;&#1086;&#1077; &#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1077;&#1085;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'agreement',
        ),
        'publichna-oferta' => array(
            'template' => DV_DIR . '/page-polzovatelskoe-soglashenie.php',
            'title'    => html_entity_decode( '&#1055;&#1086;&#1083;&#1100;&#1079;&#1086;&#1074;&#1072;&#1090;&#1077;&#1083;&#1100;&#1089;&#1082;&#1086;&#1077; &#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1077;&#1085;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'agreement',
        ),
        'user-agreement' => array(
            'template' => DV_DIR . '/page-polzovatelskoe-soglashenie.php',
            'title'    => html_entity_decode( '&#1055;&#1086;&#1083;&#1100;&#1079;&#1086;&#1074;&#1072;&#1090;&#1077;&#1083;&#1100;&#1089;&#1082;&#1086;&#1077; &#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1077;&#1085;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
            'type'     => 'agreement',
        ),
    );

    foreach ( dv_get_custom_service_pages() as $page ) {
        if ( empty( $page['slug'] ) || isset( $map[ $page['slug'] ] ) ) {
            continue;
        }

        $map[ $page['slug'] ] = array(
            'template' => DV_DIR . '/page-service-custom.php',
            'title'    => $page['title'],
            'type'     => $page['type'],
            'custom'   => $page,
        );
    }

    return $map;
}

function dv_get_custom_service_pages() {
    if ( ! function_exists( 'dv_get_theme_content_settings' ) ) {
        return array();
    }

    $settings = dv_get_theme_content_settings();
    $pages    = array();
    $used_slugs = array_fill_keys( dv_reserved_service_page_slugs(), true );

    for ( $i = 1; $i <= 5; $i++ ) {
        $prefix  = 'custom_page_' . $i;
        $enabled = '1' === (string) ( $settings[ $prefix . '_enabled' ] ?? '0' );
        $title   = trim( (string) ( $settings[ $prefix . '_title' ] ?? '' ) );
        $slug    = sanitize_title( $settings[ $prefix . '_slug' ] ?? '' );

        if ( ! $enabled || '' === $title || '' === $slug ) {
            continue;
        }

        if ( isset( $used_slugs[ $slug ] ) ) {
            continue;
        }

        $used_slugs[ $slug ] = true;

        $cards = array();
        for ( $card_index = 1; $card_index <= 3; $card_index++ ) {
            $card_title = trim( (string) ( $settings[ $prefix . '_card_' . $card_index . '_title' ] ?? '' ) );
            $card_text  = trim( (string) ( $settings[ $prefix . '_card_' . $card_index . '_text' ] ?? '' ) );

            if ( '' === $card_title && '' === $card_text ) {
                continue;
            }

            $fallback_icon = array( 'request', 'check', 'delivery' )[ $card_index - 1 ];
            $card_icon     = sanitize_key( $settings[ $prefix . '_card_' . $card_index . '_icon' ] ?? $fallback_icon );

            $cards[] = array(
                'icon'  => $card_icon ? $card_icon : $fallback_icon,
                'title' => $card_title,
                'text'  => $card_text,
            );
        }

        $pages[] = array(
            'type'            => 'custom_page_' . $i,
            'slot'            => $i,
            'title'           => $title,
            'slug'            => $slug,
            'footer_enabled'  => (string) ( $settings[ $prefix . '_footer_enabled' ] ?? '1' ),
            'intro'           => trim( (string) ( $settings[ $prefix . '_intro' ] ?? '' ) ),
            'body'            => trim( (string) ( $settings[ $prefix . '_body' ] ?? '' ) ),
            'cta_label'       => trim( (string) ( $settings[ $prefix . '_cta_label' ] ?? '' ) ),
            'cta_url'         => trim( (string) ( $settings[ $prefix . '_cta_url' ] ?? '' ) ),
            'seo_title'       => trim( (string) ( $settings[ $prefix . '_seo_title' ] ?? '' ) ),
            'seo_description' => trim( (string) ( $settings[ $prefix . '_seo_description' ] ?? '' ) ),
            'cards'           => $cards,
        );
    }

    return $pages;
}

function dv_get_custom_service_page_by_type( $type ) {
    foreach ( dv_get_custom_service_pages() as $page ) {
        if ( $type === $page['type'] ) {
            return $page;
        }
    }

    return null;
}

function dv_get_current_custom_service_page() {
    $type = (string) get_query_var( 'dv_virtual_page' );

    if ( '' === $type || 0 !== strpos( $type, 'custom_page_' ) ) {
        return null;
    }

    return dv_get_custom_service_page_by_type( $type );
}

function dv_service_page_enabled( $type ) {
    $type = (string) $type;
    $map  = array(
        'about'     => 'service_about_enabled',
        'delivery'  => 'service_delivery_enabled',
        'contacts'  => 'service_contacts_enabled',
        'return'    => 'service_return_enabled',
        'privacy'   => 'service_privacy_enabled',
        'agreement' => 'service_agreement_enabled',
    );

    if ( empty( $map[ $type ] ) || ! function_exists( 'dv_theme_option_enabled' ) ) {
        return 0 === strpos( $type, 'custom_page_' ) ? (bool) dv_get_custom_service_page_by_type( $type ) : true;
    }

    return dv_theme_option_enabled( $map[ $type ] );
}

function dv_service_page_url( $type ) {
    $type = (string) $type;
    $map  = array(
        'about'     => '/o-kompanii',
        'delivery'  => '/dostavka',
        'contacts'  => '/kontakty',
        'return'    => '/vozvrat',
        'privacy'   => '/politika-konfidencialnosti',
        'agreement' => '/polzovatelskoe-soglashenie',
    );

    if ( empty( $map[ $type ] ) ) {
        $custom_page = dv_get_custom_service_page_by_type( $type );
        if ( ! empty( $custom_page['slug'] ) ) {
            return home_url( '/' . $custom_page['slug'] );
        }

        return home_url( '/' );
    }

    return home_url( $map[ $type ] );
}

function dv_maybe_use_virtual_service_page( $template ) {
    if ( ! is_404() ) {
        return $template;
    }

    $request_uri  = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
    $request_path = trim( (string) wp_parse_url( $request_uri, PHP_URL_PATH ), '/' );

    if ( '' === $request_path ) {
        return $template;
    }

    $request_path  = strtolower( $request_path );
    $request_parts = explode( '/', $request_path );
    $slug          = end( $request_parts );

    $map = dv_virtual_service_page_map();
    if ( empty( $map[ $slug ]['template'] ) || ! file_exists( $map[ $slug ]['template'] ) ) {
        return $template;
    }

    if ( empty( $map[ $slug ]['type'] ) || ! dv_service_page_enabled( $map[ $slug ]['type'] ) ) {
        return $template;
    }

    global $wp_query;
    if ( $wp_query instanceof WP_Query ) {
        $wp_query->is_404      = false;
        $wp_query->is_page     = true;
        $wp_query->is_singular = true;
    }

    status_header( 200 );
    set_query_var( 'dv_virtual_page', $map[ $slug ]['type'] );
    set_query_var( 'dv_virtual_page_title', $map[ $slug ]['title'] );

    return $map[ $slug ]['template'];
}
add_filter( 'template_include', 'dv_maybe_use_virtual_service_page', 99 );
