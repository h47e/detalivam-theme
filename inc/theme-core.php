<?php
/**
 * Core theme labels, store profile, assets and sidebars.
 */
defined( 'ABSPATH' ) || exit;

function dv_theme_labels() {
    static $labels_cache = null;

    if ( is_array( $labels_cache ) ) {
        return $labels_cache;
    }

    $compare_limit = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'compare_limit', 4, 2, 8 ) : 4;
    $labels = array(
        'store_name'          => html_entity_decode( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;', ENT_QUOTES, 'UTF-8' ),
        'city'                => html_entity_decode( '&#1058;&#1086;&#1083;&#1100;&#1103;&#1090;&#1090;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'region'              => html_entity_decode( '&#1057;&#1072;&#1084;&#1072;&#1088;&#1089;&#1082;&#1072;&#1103; &#1086;&#1073;&#1083;&#1072;&#1089;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
        'country'             => html_entity_decode( '&#1056;&#1086;&#1089;&#1089;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'menu_primary'        => html_entity_decode( '&#1054;&#1089;&#1085;&#1086;&#1074;&#1085;&#1072;&#1103; &#1085;&#1072;&#1074;&#1080;&#1075;&#1072;&#1094;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'menu_footer'         => html_entity_decode( '&#1055;&#1086;&#1076;&#1074;&#1072;&#1083;', ENT_QUOTES, 'UTF-8' ),
        'adding'              => html_entity_decode( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1083;&#1103;&#1077;&#1084;...', ENT_QUOTES, 'UTF-8' ),
        'added_to_cart'       => html_entity_decode( '&#1058;&#1086;&#1074;&#1072;&#1088; &#1076;&#1086;&#1073;&#1072;&#1074;&#1083;&#1077;&#1085; &#1074; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'removed_from_cart'   => html_entity_decode( '&#1058;&#1086;&#1074;&#1072;&#1088; &#1091;&#1076;&#1072;&#1083;&#1105;&#1085; &#1080;&#1079; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1099;', ENT_QUOTES, 'UTF-8' ),
        'cart_qty_increased'  => html_entity_decode( '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1091;&#1074;&#1077;&#1083;&#1080;&#1095;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'cart_qty_decreased'  => html_entity_decode( '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1091;&#1084;&#1077;&#1085;&#1100;&#1096;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'add_error'           => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1076;&#1086;&#1073;&#1072;&#1074;&#1083;&#1077;&#1085;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'security_error'      => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1073;&#1077;&#1079;&#1086;&#1087;&#1072;&#1089;&#1085;&#1086;&#1089;&#1090;&#1080;. &#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1077; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1091;.', ENT_QUOTES, 'UTF-8' ),
        'connection_error'    => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1089;&#1086;&#1077;&#1076;&#1080;&#1085;&#1077;&#1085;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'wishlist_error'      => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'wishlist_added'      => html_entity_decode( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1083;&#1077;&#1085;&#1086; &#1074; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'wishlist_removed'    => html_entity_decode( '&#1059;&#1076;&#1072;&#1083;&#1077;&#1085;&#1086; &#1080;&#1079; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'compare_limit'       => sprintf( html_entity_decode( '&#1052;&#1086;&#1078;&#1085;&#1086; &#1089;&#1088;&#1072;&#1074;&#1085;&#1080;&#1074;&#1072;&#1090;&#1100; &#1085;&#1077; &#1073;&#1086;&#1083;&#1077;&#1077; %d &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;', ENT_QUOTES, 'UTF-8' ), $compare_limit ),
        'compare_added'       => html_entity_decode( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1083;&#1077;&#1085;&#1086; &#1082; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1102;', ENT_QUOTES, 'UTF-8' ),
        'compare_removed'     => html_entity_decode( '&#1059;&#1076;&#1072;&#1083;&#1077;&#1085;&#1086; &#1080;&#1079; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'recounting'          => html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1089;&#1095;&#1080;&#1090;&#1099;&#1074;&#1072;&#1077;&#1084;...', ENT_QUOTES, 'UTF-8' ),
        'update_cart'         => html_entity_decode( '&#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1100; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'search_empty'        => html_entity_decode( '&#1053;&#1080;&#1095;&#1077;&#1075;&#1086; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091; &laquo;%s&raquo;', ENT_QUOTES, 'UTF-8' ),
        'search_found'        => html_entity_decode( '&#1053;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;:', ENT_QUOTES, 'UTF-8' ),
        'search_in_stock'     => html_entity_decode( '&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'search_out_stock'    => html_entity_decode( '&#1053;&#1077;&#1090; &#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'search_all_results'  => html_entity_decode( '&#1057;&#1084;&#1086;&#1090;&#1088;&#1077;&#1090;&#1100; &#1074;&#1089;&#1077; &#1088;&#1077;&#1079;&#1091;&#1083;&#1100;&#1090;&#1072;&#1090;&#1099; (%s) &rarr;', ENT_QUOTES, 'UTF-8' ),
        'search_loading'      => html_entity_decode( '&#1055;&#1086;&#1080;&#1089;&#1082;...', ENT_QUOTES, 'UTF-8' ),
        'compare_load_error'  => html_entity_decode( '&#1053;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1079;&#1072;&#1075;&#1088;&#1091;&#1079;&#1080;&#1090;&#1100; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1077;.', ENT_QUOTES, 'UTF-8' ),
        'wishlist_load_error' => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1079;&#1072;&#1075;&#1088;&#1091;&#1079;&#1082;&#1080;. &#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1077; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1091;.', ENT_QUOTES, 'UTF-8' ),
        'compare_empty'       => html_entity_decode( '&#1057;&#1087;&#1080;&#1089;&#1086;&#1082; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103; &#1087;&#1091;&#1089;&#1090;', ENT_QUOTES, 'UTF-8' ),
        'go_catalog'          => html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1081;&#1090;&#1080; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;', ENT_QUOTES, 'UTF-8' ),
        'to_cart'             => html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'in_cart'             => html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'related_heading'     => html_entity_decode( '&#1057; &#1101;&#1090;&#1080;&#1084; &#1087;&#1086;&#1082;&#1091;&#1087;&#1072;&#1102;&#1090;', ENT_QUOTES, 'UTF-8' ),
        'upsells_heading'     => html_entity_decode( '&#1056;&#1077;&#1082;&#1086;&#1084;&#1077;&#1085;&#1076;&#1091;&#1077;&#1084; &#1090;&#1072;&#1082;&#1078;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'description'         => html_entity_decode( '&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'specs'               => html_entity_decode( '&#1061;&#1072;&#1088;&#1072;&#1082;&#1090;&#1077;&#1088;&#1080;&#1089;&#1090;&#1080;&#1082;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'reviews'             => html_entity_decode( '&#1054;&#1090;&#1079;&#1099;&#1074;&#1099;', ENT_QUOTES, 'UTF-8' ),
        'buy_now'             => html_entity_decode( '&#1050;&#1091;&#1087;&#1080;&#1090;&#1100; &#1089;&#1077;&#1081;&#1095;&#1072;&#1089;', ENT_QUOTES, 'UTF-8' ),
        'price_request'       => html_entity_decode( '&#1062;&#1077;&#1085;&#1072; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'low_stock_with_qty'  => html_entity_decode( '&#1052;&#1072;&#1083;&#1086; &mdash; %s &#1096;&#1090;.', ENT_QUOTES, 'UTF-8' ),
        'stock_suffix'        => html_entity_decode( '&#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'stock_in'            => html_entity_decode( '&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'stock_out'           => html_entity_decode( '&#1053;&#1077;&#1090; &#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'compatibility'       => html_entity_decode( '&#1057;&#1086;&#1074;&#1084;&#1077;&#1089;&#1090;&#1080;&#1084;&#1086;&#1089;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
        'economy_html'        => html_entity_decode( '&#1069;&#1082;&#1086;&#1085;&#1086;&#1084;&#1080;&#1103; %s &#8381;', ENT_QUOTES, 'UTF-8' ),
        'sidebar_catalog'     => html_entity_decode( '&#1041;&#1086;&#1082;&#1086;&#1074;&#1072;&#1103; &#1087;&#1072;&#1085;&#1077;&#1083;&#1100; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'footer_col_1'        => html_entity_decode( '&#1055;&#1086;&#1076;&#1074;&#1072;&#1083; &mdash; &#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; 1', ENT_QUOTES, 'UTF-8' ),
        'footer_col_2'        => html_entity_decode( '&#1055;&#1086;&#1076;&#1074;&#1072;&#1083; &mdash; &#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; 2', ENT_QUOTES, 'UTF-8' ),
    );

    if ( function_exists( 'dv_get_theme_content_settings' ) ) {
        $content = dv_get_theme_content_settings();
        $labels['to_cart'] = $content['cta_to_cart'] ?? $labels['to_cart'];
        $labels['buy_now'] = $content['cta_buy_now'] ?? $labels['buy_now'];
    }

    $labels_cache = $labels;

    return $labels_cache;
}

function dv_core_default_label( $key ) {
    static $labels = null;

    if ( null === $labels ) {
        $labels = array(
            'store_name'      => html_entity_decode( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;', ENT_QUOTES, 'UTF-8' ),
            'city'            => html_entity_decode( '&#1058;&#1086;&#1083;&#1100;&#1103;&#1090;&#1090;&#1080;', ENT_QUOTES, 'UTF-8' ),
            'region'          => html_entity_decode( '&#1057;&#1072;&#1084;&#1072;&#1088;&#1089;&#1082;&#1072;&#1103; &#1086;&#1073;&#1083;&#1072;&#1089;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
            'country'         => html_entity_decode( '&#1056;&#1086;&#1089;&#1089;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
            'menu_primary'    => html_entity_decode( '&#1054;&#1089;&#1085;&#1086;&#1074;&#1085;&#1072;&#1103; &#1085;&#1072;&#1074;&#1080;&#1075;&#1072;&#1094;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
            'menu_footer'     => html_entity_decode( '&#1055;&#1086;&#1076;&#1074;&#1072;&#1083;', ENT_QUOTES, 'UTF-8' ),
            'sidebar_catalog' => html_entity_decode( '&#1041;&#1086;&#1082;&#1086;&#1074;&#1072;&#1103; &#1087;&#1072;&#1085;&#1077;&#1083;&#1100; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072;', ENT_QUOTES, 'UTF-8' ),
            'footer_col_1'    => html_entity_decode( '&#1055;&#1086;&#1076;&#1074;&#1072;&#1083; &mdash; &#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; 1', ENT_QUOTES, 'UTF-8' ),
            'footer_col_2'    => html_entity_decode( '&#1055;&#1086;&#1076;&#1074;&#1072;&#1083; &mdash; &#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; 2', ENT_QUOTES, 'UTF-8' ),
        );
    }

    return $labels[ $key ] ?? '';
}

function dv_string_value( $value, $fallback = '' ) {
    if ( is_array( $value ) ) {
        $value = reset( $value );
    }

    if ( is_array( $fallback ) ) {
        $fallback = reset( $fallback );
    }

    if ( is_object( $value ) || is_array( $value ) || null === $value ) {
        $value = $fallback;
    }

    if ( is_object( $value ) || is_array( $value ) || null === $value ) {
        return '';
    }

    $value = trim( (string) $value );

    if ( '' !== $value ) {
        return $value;
    }

    return is_scalar( $fallback ) ? trim( (string) $fallback ) : '';
}

function dv_frontend_script_labels() {
    static $labels = null;

    if ( is_array( $labels ) ) {
        return $labels;
    }

    $content       = get_option( 'dv_theme_content', array() );
    $content       = is_array( $content ) ? $content : array();
    $compare_limit = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'compare_limit', 4, 2, 8 ) : 4;

    $labels = array(
        'adding'                 => html_entity_decode( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1083;&#1103;&#1077;&#1084;...', ENT_QUOTES, 'UTF-8' ),
        'added_to_cart'          => html_entity_decode( '&#1058;&#1086;&#1074;&#1072;&#1088; &#1076;&#1086;&#1073;&#1072;&#1074;&#1083;&#1077;&#1085; &#1074; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'add_error'              => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1076;&#1086;&#1073;&#1072;&#1074;&#1083;&#1077;&#1085;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'security_error'         => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1073;&#1077;&#1079;&#1086;&#1087;&#1072;&#1089;&#1085;&#1086;&#1089;&#1090;&#1080;. &#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1077; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1091;.', ENT_QUOTES, 'UTF-8' ),
        'connection_error'       => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1089;&#1086;&#1077;&#1076;&#1080;&#1085;&#1077;&#1085;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'wishlist_error'         => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'wishlist_added'         => html_entity_decode( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1083;&#1077;&#1085;&#1086; &#1074; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'wishlist_removed'       => html_entity_decode( '&#1059;&#1076;&#1072;&#1083;&#1077;&#1085;&#1086; &#1080;&#1079; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'wishlist_empty_short'   => html_entity_decode( '&#1055;&#1091;&#1089;&#1090;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'compare_limit'          => sprintf( html_entity_decode( '&#1052;&#1086;&#1078;&#1085;&#1086; &#1089;&#1088;&#1072;&#1074;&#1085;&#1080;&#1074;&#1072;&#1090;&#1100; &#1085;&#1077; &#1073;&#1086;&#1083;&#1077;&#1077; %d &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;', ENT_QUOTES, 'UTF-8' ), $compare_limit ),
        'compare_added'          => html_entity_decode( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1083;&#1077;&#1085;&#1086; &#1082; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1102;', ENT_QUOTES, 'UTF-8' ),
        'compare_removed'        => html_entity_decode( '&#1059;&#1076;&#1072;&#1083;&#1077;&#1085;&#1086; &#1080;&#1079; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'compare_empty'          => html_entity_decode( '&#1057;&#1087;&#1080;&#1089;&#1086;&#1082; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103; &#1087;&#1091;&#1089;&#1090;', ENT_QUOTES, 'UTF-8' ),
        'compare_load_error'     => html_entity_decode( '&#1053;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1079;&#1072;&#1075;&#1088;&#1091;&#1079;&#1080;&#1090;&#1100; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1077;.', ENT_QUOTES, 'UTF-8' ),
        'wishlist_load_error'    => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1079;&#1072;&#1075;&#1088;&#1091;&#1079;&#1082;&#1080;. &#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1077; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1091;.', ENT_QUOTES, 'UTF-8' ),
        'cart_qty_increased'     => html_entity_decode( '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1091;&#1074;&#1077;&#1083;&#1080;&#1095;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'cart_qty_decreased'     => html_entity_decode( '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1091;&#1084;&#1077;&#1085;&#1100;&#1096;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'recounting'             => html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1089;&#1095;&#1080;&#1090;&#1099;&#1074;&#1072;&#1077;&#1084;...', ENT_QUOTES, 'UTF-8' ),
        'update_cart'            => html_entity_decode( '&#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1100; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'search_empty'           => html_entity_decode( '&#1053;&#1080;&#1095;&#1077;&#1075;&#1086; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091; &laquo;%s&raquo;', ENT_QUOTES, 'UTF-8' ),
        'search_found'           => html_entity_decode( '&#1053;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;:', ENT_QUOTES, 'UTF-8' ),
        'search_in_stock'        => html_entity_decode( '&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'search_out_of_stock'    => html_entity_decode( '&#1053;&#1077;&#1090; &#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'search_all_results_link' => html_entity_decode( '&#1057;&#1084;&#1086;&#1090;&#1088;&#1077;&#1090;&#1100; &#1074;&#1089;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'search_loading'         => html_entity_decode( '&#1055;&#1086;&#1080;&#1089;&#1082;...', ENT_QUOTES, 'UTF-8' ),
        'go_catalog'             => html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1081;&#1090;&#1080; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;', ENT_QUOTES, 'UTF-8' ),
        'to_cart'                => $content['cta_to_cart'] ?? html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'in_cart'                => $content['cta_in_cart'] ?? html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1077;', ENT_QUOTES, 'UTF-8' ),
    );

    return $labels;
}

function dv_get_store_profile() {
    static $profile_cache = null;

    if ( is_array( $profile_cache ) ) {
        return $profile_cache;
    }

    $defaults = array(
        'name'         => dv_core_default_label( 'store_name' ),
        'site_url'     => home_url( '/' ),
        'logo_url'     => '',
        'phone'        => '+7-927-216-60-99',
        'phone_display'=> '+7 (927) 216-60-99',
        'email'        => 'info@detalivam63.ru',
        'city'         => dv_core_default_label( 'city' ),
        'region'       => dv_core_default_label( 'region' ),
        'country_name' => dv_core_default_label( 'country' ),
        'country_code' => 'RU',
        'currency'     => 'RUB',
        'ozon_url'     => 'https://www.ozon.ru/seller/detali-vam/',
        'ozon_icon_url'=> '',
        'marketplace_2_name' => '',
        'marketplace_2_url'  => '',
        'marketplace_2_icon' => '',
        'marketplace_3_name' => '',
        'marketplace_3_url'  => '',
        'marketplace_3_icon' => '',
        'workdays'     => html_entity_decode( '&#1055;&#1085;-&#1055;&#1090;', ENT_QUOTES, 'UTF-8' ),
        'opens'        => '09:00',
        'closes'       => '18:00',
        'footer_description' => sprintf(
            '%1$s %2$s. %3$s, %4$s, %5$s, %6$s. %7$s %8$s.',
            html_entity_decode( '&#1048;&#1085;&#1090;&#1077;&#1088;&#1085;&#1077;&#1090;-&#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; &#1074;', ENT_QUOTES, 'UTF-8' ),
            dv_core_default_label( 'city' ),
            html_entity_decode( '&#1050;&#1091;&#1079;&#1086;&#1074;&#1085;&#1099;&#1077; &#1076;&#1077;&#1090;&#1072;&#1083;&#1080;', ENT_QUOTES, 'UTF-8' ),
            html_entity_decode( '&#1089;&#1080;&#1089;&#1090;&#1077;&#1084;&#1072; &#1074;&#1099;&#1087;&#1091;&#1089;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ),
            html_entity_decode( '&#1087;&#1086;&#1076;&#1074;&#1077;&#1089;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ),
            html_entity_decode( '&#1076;&#1074;&#1080;&#1075;&#1072;&#1090;&#1077;&#1083;&#1100;', ENT_QUOTES, 'UTF-8' ),
            html_entity_decode( '&#1054;&#1088;&#1080;&#1075;&#1080;&#1085;&#1072;&#1083;&#1099; &#1080;', ENT_QUOTES, 'UTF-8' ),
            html_entity_decode( '&#1082;&#1072;&#1095;&#1077;&#1089;&#1090;&#1074;&#1077;&#1085;&#1085;&#1099;&#1077; &#1072;&#1085;&#1072;&#1083;&#1086;&#1075;&#1080;', ENT_QUOTES, 'UTF-8' )
        ),
    );

    $saved = get_option( 'dv_store_profile', array() );
    if ( ! is_array( $saved ) ) {
        $saved = array();
    }

    $profile = wp_parse_args( $saved, $defaults );
    $profile['site_url'] = home_url( '/' );
    $profile['logo_url'] = esc_url_raw( dv_string_value( $profile['logo_url'] ?? '', '' ) );
    $profile['ozon_url'] = esc_url_raw( dv_string_value( $profile['ozon_url'] ?? '', $defaults['ozon_url'] ) );
    $profile['ozon_icon_url'] = esc_url_raw( dv_string_value( $profile['ozon_icon_url'] ?? '', '' ) );
    $profile['marketplace_2_name'] = sanitize_text_field( dv_string_value( $profile['marketplace_2_name'] ?? '', '' ) );
    $profile['marketplace_2_url'] = esc_url_raw( dv_string_value( $profile['marketplace_2_url'] ?? '', '' ) );
    $profile['marketplace_2_icon'] = esc_url_raw( dv_string_value( $profile['marketplace_2_icon'] ?? '', '' ) );
    $profile['marketplace_3_name'] = sanitize_text_field( dv_string_value( $profile['marketplace_3_name'] ?? '', '' ) );
    $profile['marketplace_3_url'] = esc_url_raw( dv_string_value( $profile['marketplace_3_url'] ?? '', '' ) );
    $profile['marketplace_3_icon'] = esc_url_raw( dv_string_value( $profile['marketplace_3_icon'] ?? '', '' ) );
    $profile['name'] = dv_string_value( $profile['name'] ?? '', $defaults['name'] );
    $profile['city'] = dv_string_value( $profile['city'] ?? '', $defaults['city'] );
    $profile['region'] = dv_string_value( $profile['region'] ?? '', $defaults['region'] );
    $profile['country_name'] = dv_string_value( $profile['country_name'] ?? '', $defaults['country_name'] );
    $profile['currency'] = dv_string_value( $profile['currency'] ?? '', $defaults['currency'] );
    $profile['footer_description'] = dv_string_value( $profile['footer_description'] ?? '', $defaults['footer_description'] );
    $profile['workdays'] = dv_string_value( $profile['workdays'] ?? '', $defaults['workdays'] );
    $profile['opens'] = dv_string_value( $profile['opens'] ?? '', $defaults['opens'] );
    $profile['closes'] = dv_string_value( $profile['closes'] ?? '', $defaults['closes'] );
    $profile['phone'] = dv_string_value( $profile['phone'] ?? '', $defaults['phone'] );
    $profile['phone_display'] = dv_string_value( $profile['phone_display'] ?? '', $defaults['phone_display'] );
    $profile['email'] = sanitize_email( dv_string_value( $profile['email'] ?? '', $defaults['email'] ) );
    $profile['phone_href'] = preg_replace( '/[^0-9\+]/', '', $profile['phone'] );
    $profile['email_href'] = ! empty( $profile['email'] ) ? 'mailto:' . $profile['email'] : '';

    $profile_cache = $profile;

    return $profile_cache;
}

function dv_get_theme_logo_url() {
    static $logo_url_cache = null;

    if ( null !== $logo_url_cache ) {
        return $logo_url_cache;
    }

    $saved = get_option( 'dv_store_profile', array() );
    $logo_url = is_array( $saved ) ? esc_url_raw( $saved['logo_url'] ?? '' ) : '';

    if ( '' !== $logo_url ) {
        $logo_url_cache = $logo_url;

        return $logo_url_cache;
    }

    $custom_logo_id = (int) get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $custom_logo = wp_get_attachment_image_url( $custom_logo_id, 'full' );
        if ( $custom_logo ) {
            $logo_url_cache = $custom_logo;

            return $logo_url_cache;
        }
    }

    $logo_url_cache = DV_URI . '/assets/logo.png';

    return $logo_url_cache;
}

function dv_get_ozon_icon_url() {
    static $icon_url_cache = null;

    if ( null !== $icon_url_cache ) {
        return $icon_url_cache;
    }

    $profile = dv_get_store_profile();
    $icon_url = esc_url_raw( $profile['ozon_icon_url'] ?? '' );

    $icon_url_cache = '' !== $icon_url ? $icon_url : DV_URI . '/assets/ozon.png';

    return $icon_url_cache;
}

function dv_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'menus' );

    register_nav_menus(
        array(
            'primary' => dv_core_default_label( 'menu_primary' ),
            'footer'  => dv_core_default_label( 'menu_footer' ),
        )
    );

    add_image_size( 'dv-product', 600, 600, false );
    add_image_size( 'dv-product-sm', 300, 300, false );
    add_image_size( 'dv-product-lg', 1200, 1200, false );
    add_image_size( 'dv-hero', 1400, 600, true );
}
add_action( 'after_setup_theme', 'dv_setup' );

function dv_theme_visual_preset_body_class( $classes ) {
    $preset       = 'default';
    $color_scheme = 'preset';
    $options = array();

    if ( function_exists( 'dv_get_theme_options' ) ) {
        $options      = dv_get_theme_options();
        $preset       = sanitize_key( $options['theme_visual_preset'] ?? 'default' );
        $color_scheme = sanitize_key( $options['theme_color_scheme'] ?? 'preset' );
    }

    if ( ! in_array( $preset, array( 'default', 'contrast', 'soft', 'graphite', 'ozon', 'market', 'wildberries' ), true ) ) {
        $preset = 'default';
    }

    if ( ! in_array( $color_scheme, array( 'preset', 'default', 'contrast', 'soft', 'graphite', 'ozon', 'market', 'wildberries' ), true ) ) {
        $color_scheme = 'preset';
    }

    $resolved_color_scheme = 'preset' === $color_scheme ? $preset : $color_scheme;

    $classes[] = 'dv-preset-' . $preset;
    $classes[] = 'dv-color-scheme-' . $resolved_color_scheme;

    if ( 'preset' !== $color_scheme ) {
        $classes[] = 'dv-color-scheme-override';
    }

    $visual_options = array(
        'theme_layout_width'     => array( 'contained', 'wide', 'fluid' ),
        'theme_radius_style'     => array( 'sharp', 'soft', 'round' ),
        'theme_density_style'    => array( 'compact', 'balanced', 'air' ),
        'theme_shadow_style'     => array( 'none', 'soft', 'deep' ),
        'theme_header_style'     => array( 'compact', 'balanced', 'wide-search' ),
        'theme_footer_style'     => array( 'compact', 'standard', 'spacious' ),
        'theme_card_style'       => array( 'standard', 'compact', 'showcase' ),
        'theme_card_image_ratio' => array( 'square', 'portrait', 'wide' ),
        'theme_card_image_padding' => array( 'tight', 'balanced', 'safe' ),
        'theme_card_hover_style'  => array( 'none', 'soft', 'lift' ),
        'theme_card_title_lines'  => array( 'two', 'three', 'four' ),
    );

    foreach ( $visual_options as $key => $allowed ) {
        $value = sanitize_key( $options[ $key ] ?? '' );

        if ( '' !== $value && in_array( $value, $allowed, true ) ) {
            $class_slug = preg_replace( '/^theme_/', '', $key );
            $class_slug = str_replace( '_', '-', $class_slug );
            $classes[]  = 'dv-' . $class_slug . '-' . $value;
        }
    }

    return $classes;
}
add_filter( 'body_class', 'dv_theme_visual_preset_body_class' );

function dv_body_class( $class = '' ) {
    global $wp_query;

    $restore_singular = null;
    $restore_page     = null;

    if ( is_singular() && ! ( get_post() instanceof WP_Post ) && $wp_query instanceof WP_Query ) {
        $restore_singular      = $wp_query->is_singular;
        $restore_page          = $wp_query->is_page;
        $wp_query->is_singular = false;
        $wp_query->is_page     = false;
        $class                 = trim( (string) $class . ' dv-virtual-page' );
    }

    body_class( $class );

    if ( null !== $restore_singular && $wp_query instanceof WP_Query ) {
        $wp_query->is_singular = $restore_singular;
        $wp_query->is_page     = $restore_page;
    }
}

function dv_is_woocommerce_context() {
    static $is_context = null;

    if ( null !== $is_context ) {
        return $is_context;
    }

    if ( ! class_exists( 'WooCommerce' ) ) {
        $is_context = false;

        return $is_context;
    }

    $checks = array( 'is_woocommerce', 'is_cart', 'is_checkout', 'is_account_page', 'is_shop', 'is_product', 'is_product_category', 'is_product_tag' );
    foreach ( $checks as $check ) {
        if ( function_exists( $check ) && $check() ) {
            $is_context = true;

            return $is_context;
        }
    }

    if ( is_singular() ) {
        $post = get_post();
        $body = $post instanceof WP_Post ? (string) $post->post_content : '';

        if (
            false !== strpos( $body, '<!-- wp:woocommerce/' )
            || has_shortcode( $body, 'products' )
            || has_shortcode( $body, 'product_page' )
            || has_shortcode( $body, 'product_category' )
            || has_shortcode( $body, 'woocommerce_cart' )
            || has_shortcode( $body, 'woocommerce_checkout' )
            || has_shortcode( $body, 'woocommerce_my_account' )
        ) {
            $is_context = true;

            return $is_context;
        }
    }

    $is_context = false;

    return $is_context;
}

function dv_theme_asset_version( $relative_path ) {
    static $versions = array();

    $relative_path = ltrim( (string) $relative_path, '/' );

    if ( isset( $versions[ $relative_path ] ) ) {
        return $versions[ $relative_path ];
    }

    $path    = get_stylesheet_directory() . '/' . $relative_path;
    $version = DV_VERSION;

    if ( file_exists( $path ) ) {
        $version .= '.' . filemtime( $path );
    }

    $versions[ $relative_path ] = $version;

    return $versions[ $relative_path ];
}

function dv_optimize_woocommerce_assets() {
    if ( ! class_exists( 'WooCommerce' ) || dv_is_woocommerce_context() ) {
        return;
    }

    foreach ( array( 'woocommerce-general', 'woocommerce-layout', 'woocommerce-smallscreen' ) as $style_handle ) {
        wp_dequeue_style( $style_handle );
    }

    foreach ( array( 'wc-cart-fragments', 'wc-add-to-cart', 'woocommerce' ) as $script_handle ) {
        wp_dequeue_script( $script_handle );
    }
}
add_action( 'wp_enqueue_scripts', 'dv_optimize_woocommerce_assets', 100 );

function dv_optimize_cart_fragment_assets() {
    if ( is_admin() || ! class_exists( 'WooCommerce' ) ) {
        return;
    }

    $needs_fragments =
        ( function_exists( 'is_cart' ) && is_cart() )
        || ( function_exists( 'is_checkout' ) && is_checkout() )
        || ( function_exists( 'is_account_page' ) && is_account_page() );

    if ( ! $needs_fragments ) {
        wp_dequeue_script( 'wc-cart-fragments' );
        wp_deregister_script( 'wc-cart-fragments' );
    }
}
add_action( 'wp_enqueue_scripts', 'dv_optimize_cart_fragment_assets', 120 );

function dv_optimize_core_frontend_assets() {
    if ( is_admin() ) {
        return;
    }

    foreach (
        array(
            'wp-block-library',
            'wp-block-library-theme',
            'global-styles',
            'classic-theme-styles',
        ) as $style_handle
    ) {
        wp_dequeue_style( $style_handle );
        wp_deregister_style( $style_handle );
    }

    $keep_woocommerce_blocks =
        ( function_exists( 'is_cart' ) && is_cart() )
        || ( function_exists( 'is_checkout' ) && is_checkout() )
        || ( function_exists( 'is_account_page' ) && is_account_page() );

    if ( ! $keep_woocommerce_blocks ) {
        foreach (
            array(
                'wc-blocks-style',
                'wc-blocks-vendors-style',
                'wc-blocks-packages-style',
                'wc-block-style',
                'wc-blocks-integration',
                'wc-blocks-checkout-style',
                'wc-blocks-cart-style',
            ) as $style_handle
        ) {
            wp_dequeue_style( $style_handle );
            wp_deregister_style( $style_handle );
        }

        foreach (
            array(
                'wc-blocks',
                'wc-blocks-registry',
                'wc-blocks-middleware',
                'wc-blocks-data-store',
            ) as $script_handle
        ) {
            wp_dequeue_script( $script_handle );
            wp_deregister_script( $script_handle );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'dv_optimize_core_frontend_assets', 130 );

function dv_cleanup_frontend_assets() {
    if ( is_admin() ) {
        return;
    }

    wp_deregister_script( 'wp-embed' );

    if ( ! is_user_logged_in() ) {
        wp_dequeue_style( 'dashicons' );
    }
}
add_action( 'wp_enqueue_scripts', 'dv_cleanup_frontend_assets', 110 );

function dv_get_yandex_metrika_counter_id() {
    $theme_options = get_option( 'dv_theme_options', array() );
    $theme_options = is_array( $theme_options ) ? $theme_options : array();
    $counter_id    = get_option( 'dv_yandex_metrika_counter_id', '' );

    foreach ( array( 'yandex_metrika_counter_id', 'metrika_counter_id', 'metrika_id' ) as $option_key ) {
        if ( '' !== trim( (string) $counter_id ) ) {
            break;
        }

        $counter_id = $theme_options[ $option_key ] ?? '';
    }

    return preg_replace( '/\D+/', '', (string) $counter_id );
}

function dv_enqueue() {
    $labels = dv_frontend_script_labels();
    wp_enqueue_style(
        'dv-fonts',
        'https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Golos+Text:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'dv-main',
        DV_URI . '/assets/css/main.css',
        array( 'dv-fonts' ),
        dv_theme_asset_version( 'assets/css/main.css' )
    );

    if ( dv_is_woocommerce_context() ) {
        wp_enqueue_style( 'woocommerce-general' );
    }

    if ( function_exists( 'is_product' ) && is_product() ) {
        $single_product_css = get_stylesheet_directory() . '/assets/css/single-product.css';
        if ( file_exists( $single_product_css ) ) {
            wp_enqueue_style(
                'dv-single-product',
                DV_URI . '/assets/css/single-product.css',
                array( 'dv-main' ),
                dv_theme_asset_version( 'assets/css/single-product.css' )
            );
        }
    }

    wp_enqueue_script(
        'dv-main',
        DV_URI . '/assets/js/main.js',
        array( 'jquery' ),
        dv_theme_asset_version( 'assets/js/main.js' ),
        true
    );
    wp_script_add_data( 'dv-main', 'defer', true );

    wp_localize_script(
        'dv-main',
        'dvConfig',
        array(
            'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
            'nonce'       => wp_create_nonce( 'dv_add_cart' ),
            'listsNonce'  => wp_create_nonce( 'dv_lists_action' ),
            'cartUrl'     => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' ),
            'checkoutUrl' => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/' ),
            'compareLimit' => function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'compare_limit', 4, 2, 8 ) : 4,
            'metrika'     => array(
                'counterId' => dv_get_yandex_metrika_counter_id(),
                'debug'     => current_user_can( 'manage_options' ) && isset( $_GET['dv_metrika_debug'] ),
                'goals'     => array(
                    'addToCart'     => 'add_to_cart',
                    'phoneClick'    => 'phone_click',
                    'siteSearch'    => 'site_search',
                    'ozonClick'     => 'ozon_click',
                    'productClick'  => 'product_click',
                    'checkoutStart' => 'checkout_start',
                    'orderSuccess'  => 'order_success',
                ),
            ),
            'i18n'        => array(
                'adding'                => $labels['adding'],
                'added_to_cart'         => $labels['added_to_cart'],
                'add_error'             => $labels['add_error'],
                'security_error'        => $labels['security_error'],
                'connection_error'      => $labels['connection_error'],
                'wishlist_error'        => $labels['wishlist_error'],
                'wishlist_added'        => $labels['wishlist_added'],
                'wishlist_removed'      => $labels['wishlist_removed'],
                'compare_limit'         => $labels['compare_limit'],
                'compare_added'         => $labels['compare_added'],
                'compare_removed'       => $labels['compare_removed'],
                'recounting'            => $labels['recounting'],
                'update_cart'           => $labels['update_cart'],
                'search_empty'          => $labels['search_empty'],
                'search_found'          => $labels['search_found'],
                'search_in_stock'       => $labels['search_in_stock'],
                'search_out_of_stock'   => $labels['search_out_of_stock'],
                'search_all_results_link' => $labels['search_all_results_link'],
                'search_loading'        => $labels['search_loading'],
                'compare_load_error'    => $labels['compare_load_error'],
                'wishlist_load_error'   => $labels['wishlist_load_error'],
                'compare_empty'         => $labels['compare_empty'],
                'wishlist_empty_short'  => $labels['wishlist_empty_short'],
                'cart_qty_increased'    => $labels['cart_qty_increased'],
                'cart_qty_decreased'    => $labels['cart_qty_decreased'],
                'to_cart'               => $labels['to_cart'],
                'in_cart'               => $labels['in_cart'],
                'go_catalog'            => $labels['go_catalog'],
            ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'dv_enqueue' );

function dv_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' !== $relation_type ) {
        return $urls;
    }

    $urls[] = array(
        'href'        => 'https://fonts.gstatic.com',
        'crossorigin' => 'anonymous',
    );
    $urls[] = 'https://fonts.googleapis.com';

    return $urls;
}
add_filter( 'wp_resource_hints', 'dv_resource_hints', 10, 2 );

function dv_disable_unused_core_frontend_assets() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
    remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'dv_disable_unused_core_frontend_assets' );

function dv_load_wc_cart_for_ajax() {
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX && function_exists( 'wc_load_cart' ) ) {
        wc_load_cart();
    }
}
add_action( 'wp_loaded', 'dv_load_wc_cart_for_ajax' );

function dv_register_sidebars() {
    register_sidebar(
        array(
            'name'          => dv_core_default_label( 'sidebar_catalog' ),
            'id'            => 'shop-sidebar',
            'before_widget' => '<div class="filter-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="filter-title">',
            'after_title'   => '</div>',
        )
    );

    register_sidebar(
        array(
            'name'          => dv_core_default_label( 'footer_col_1' ),
            'id'            => 'footer-1',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="footer-col-title">',
            'after_title'   => '</div>',
        )
    );

    register_sidebar(
        array(
            'name'          => dv_core_default_label( 'footer_col_2' ),
            'id'            => 'footer-2',
            'before_widget' => '<div>',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="footer-col-title">',
            'after_title'   => '</div>',
        )
    );
}
add_action( 'widgets_init', 'dv_register_sidebars' );
