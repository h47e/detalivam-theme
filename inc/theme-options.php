<?php
/**
 * Theme display options managed from wp-admin.
 */
defined( 'ABSPATH' ) || exit;

function dv_get_theme_options_defaults() {
    return array(
        'catalog_per_page'        => 24,
        'catalog_columns'         => 4,
        'theme_visual_preset'     => 'default',
        'theme_color_scheme'      => 'preset',
        'theme_layout_width'      => 'wide',
        'theme_radius_style'      => 'soft',
        'theme_density_style'     => 'balanced',
        'theme_shadow_style'      => 'soft',
        'theme_header_style'      => 'balanced',
        'theme_footer_style'      => 'standard',
        'theme_card_style'        => 'standard',
        'theme_card_image_ratio'  => 'square',
        'theme_card_image_padding' => 'balanced',
        'theme_card_hover_style'  => 'soft',
        'theme_card_title_lines'  => 'three',
        'header_topbar_enabled'   => '1',
        'topbar_city_enabled'     => '1',
        'topbar_phone_enabled'    => '1',
        'topbar_shop_enabled'     => '1',
        'topbar_delivery_enabled' => '1',
        'topbar_about_enabled'    => '1',
        'topbar_contacts_enabled' => '1',
        'header_search_enabled'   => '1',
        'header_actions_enabled'  => '1',
        'header_compare_enabled'  => '1',
        'header_wishlist_enabled' => '1',
        'header_cart_enabled'     => '1',
        'header_ozon_enabled'     => '1',
        'header_account_enabled'  => '1',
        'header_catalog_dropdown_enabled' => '1',
        'header_nav_links_enabled' => '1',
        'header_categories_limit' => 8,
        'footer_brand_enabled'    => '1',
        'footer_description_enabled' => '1',
        'footer_contacts_enabled' => '1',
        'footer_catalog_enabled'  => '1',
        'footer_customers_enabled' => '1',
        'footer_company_enabled'  => '1',
        'footer_bottom_enabled'   => '1',
        'footer_payment_icons_enabled' => '1',
        'footer_legal_links_enabled' => '1',
        'footer_customers_1_enabled' => '1',
        'footer_customers_2_enabled' => '1',
        'footer_customers_3_enabled' => '1',
        'footer_customers_4_enabled' => '1',
        'footer_customers_5_enabled' => '1',
        'footer_company_1_enabled' => '1',
        'footer_company_2_enabled' => '1',
        'footer_company_3_enabled' => '1',
        'footer_company_4_enabled' => '1',
        'footer_privacy_enabled'  => '1',
        'footer_offer_enabled'    => '1',
        'footer_categories_limit' => 6,
        'cart_coupon_enabled'     => '1',
        'cart_cross_sells_enabled' => '1',
        'cart_product_image_enabled' => '1',
        'cart_price_enabled'      => '1',
        'cart_subtotal_enabled'   => '1',
        'checkout_coupon_enabled' => '1',
        'checkout_login_enabled'  => '1',
        'checkout_order_notes_enabled' => '1',
        'service_about_enabled'   => '1',
        'service_delivery_enabled' => '1',
        'service_contacts_enabled' => '1',
        'service_return_enabled'  => '1',
        'service_privacy_enabled' => '1',
        'service_agreement_enabled' => '1',
        'product_related_enabled' => '1',
        'product_related_limit'   => 4,
        'product_similar_enabled' => '1',
        'product_similar_limit'   => 4,
        'product_recent_enabled'  => '1',
        'product_recent_limit'    => 4,
        'catalog_marka_limit'     => 30,
        'catalog_category_limit'   => 10,
        'catalog_path_enabled'     => '1',
        'catalog_marka_enabled'    => '1',
        'catalog_categories_enabled' => '1',
        'catalog_price_enabled'    => '1',
        'catalog_stock_enabled'    => '1',
        'catalog_recs_enabled'    => '1',
        'catalog_recs_limit'      => 3,
        'catalog_path_order'       => 10,
        'catalog_marka_order'      => 20,
        'catalog_categories_order' => 30,
        'catalog_price_order'      => 40,
        'catalog_stock_order'      => 50,
        'catalog_recs_order'       => 60,
        'catalog_card_badges_enabled' => '1',
        'catalog_card_actions_enabled' => '1',
        'catalog_card_compat_enabled' => '1',
        'catalog_card_rating_enabled' => '1',
        'catalog_card_sku_enabled' => '1',
        'catalog_card_stock_qty_enabled' => '1',
        'home_product_columns'    => 4,
        'search_live_limit'       => 8,
        'search_page_per_page'    => 24,
        'not_found_search_enabled' => '1',
        'not_found_actions_enabled' => '1',
        'not_found_categories_enabled' => '1',
        'not_found_categories_limit' => 6,
        'compare_limit'           => 4,
        'product_gallery_hint_enabled' => '1',
        'product_meta_sku_enabled' => '1',
        'product_actions_enabled'  => '1',
        'product_wishlist_enabled' => '1',
        'product_compare_enabled'  => '1',
        'product_ozon_enabled'     => '1',
        'product_summary_description_enabled' => '1',
        'product_tab_description_enabled' => '1',
        'product_tab_specs_enabled' => '1',
        'product_tab_reviews_enabled' => '1',
        'product_purchase_order'    => 10,
        'product_ozon_order'        => 20,
        'product_actions_order'     => 30,
        'product_tabs_order'        => 40,
        'product_related_order'     => 50,
        'product_similar_order'     => 60,
        'product_recent_order'      => 70,
    );
}

function dv_get_theme_options() {
    $saved = get_option( 'dv_theme_options', array() );
    if ( ! is_array( $saved ) ) {
        $saved = array();
    }

    return wp_parse_args( $saved, dv_get_theme_options_defaults() );
}

function dv_theme_option_int( $key, $fallback = 1, $min = 1, $max = 999 ) {
    $options = dv_get_theme_options();
    $value   = isset( $options[ $key ] ) ? absint( $options[ $key ] ) : absint( $fallback );

    return max( $min, min( $max, $value ) );
}

function dv_theme_option_enabled( $key ) {
    $options = dv_get_theme_options();

    return ! isset( $options[ $key ] ) || '1' === (string) $options[ $key ];
}

function dv_sanitize_theme_options( $input ) {
    $input    = is_array( $input ) ? $input : array();
    $defaults = dv_get_theme_options_defaults();
    $visual_preset = sanitize_key( $input['theme_visual_preset'] ?? $defaults['theme_visual_preset'] );
    if ( ! in_array( $visual_preset, array( 'default', 'contrast', 'soft', 'graphite', 'ozon', 'market', 'wildberries' ), true ) ) {
        $visual_preset = $defaults['theme_visual_preset'];
    }

    $color_scheme = sanitize_key( $input['theme_color_scheme'] ?? $defaults['theme_color_scheme'] );
    if ( ! in_array( $color_scheme, array( 'preset', 'default', 'contrast', 'soft', 'graphite', 'ozon', 'market', 'wildberries' ), true ) ) {
        $color_scheme = $defaults['theme_color_scheme'];
    }

    $radius_style = sanitize_key( $input['theme_radius_style'] ?? $defaults['theme_radius_style'] );
    if ( ! in_array( $radius_style, array( 'sharp', 'soft', 'round' ), true ) ) {
        $radius_style = $defaults['theme_radius_style'];
    }

    $layout_width = sanitize_key( $input['theme_layout_width'] ?? $defaults['theme_layout_width'] );
    if ( ! in_array( $layout_width, array( 'contained', 'wide', 'fluid' ), true ) ) {
        $layout_width = $defaults['theme_layout_width'];
    }

    $density_style = sanitize_key( $input['theme_density_style'] ?? $defaults['theme_density_style'] );
    if ( ! in_array( $density_style, array( 'compact', 'balanced', 'air' ), true ) ) {
        $density_style = $defaults['theme_density_style'];
    }

    $shadow_style = sanitize_key( $input['theme_shadow_style'] ?? $defaults['theme_shadow_style'] );
    if ( ! in_array( $shadow_style, array( 'none', 'soft', 'deep' ), true ) ) {
        $shadow_style = $defaults['theme_shadow_style'];
    }

    $header_style = sanitize_key( $input['theme_header_style'] ?? $defaults['theme_header_style'] );
    if ( ! in_array( $header_style, array( 'compact', 'balanced', 'wide-search' ), true ) ) {
        $header_style = $defaults['theme_header_style'];
    }

    $footer_style = sanitize_key( $input['theme_footer_style'] ?? $defaults['theme_footer_style'] );
    if ( ! in_array( $footer_style, array( 'compact', 'standard', 'spacious' ), true ) ) {
        $footer_style = $defaults['theme_footer_style'];
    }

    $card_style = sanitize_key( $input['theme_card_style'] ?? $defaults['theme_card_style'] );
    if ( ! in_array( $card_style, array( 'standard', 'compact', 'showcase' ), true ) ) {
        $card_style = $defaults['theme_card_style'];
    }

    $card_image_ratio = sanitize_key( $input['theme_card_image_ratio'] ?? $defaults['theme_card_image_ratio'] );
    if ( ! in_array( $card_image_ratio, array( 'square', 'portrait', 'wide' ), true ) ) {
        $card_image_ratio = $defaults['theme_card_image_ratio'];
    }

    $card_image_padding = sanitize_key( $input['theme_card_image_padding'] ?? $defaults['theme_card_image_padding'] );
    if ( ! in_array( $card_image_padding, array( 'tight', 'balanced', 'safe' ), true ) ) {
        $card_image_padding = $defaults['theme_card_image_padding'];
    }

    $card_hover_style = sanitize_key( $input['theme_card_hover_style'] ?? $defaults['theme_card_hover_style'] );
    if ( ! in_array( $card_hover_style, array( 'none', 'soft', 'lift' ), true ) ) {
        $card_hover_style = $defaults['theme_card_hover_style'];
    }

    $card_title_lines = sanitize_key( $input['theme_card_title_lines'] ?? $defaults['theme_card_title_lines'] );
    if ( ! in_array( $card_title_lines, array( 'two', 'three', 'four' ), true ) ) {
        $card_title_lines = $defaults['theme_card_title_lines'];
    }

    $output = array(
        'catalog_per_page'        => max( 1, min( 96, absint( $input['catalog_per_page'] ?? $defaults['catalog_per_page'] ) ) ),
        'catalog_columns'         => max( 2, min( 6, absint( $input['catalog_columns'] ?? $defaults['catalog_columns'] ) ) ),
        'theme_visual_preset'     => $visual_preset,
        'theme_color_scheme'      => $color_scheme,
        'theme_layout_width'      => $layout_width,
        'theme_radius_style'      => $radius_style,
        'theme_density_style'     => $density_style,
        'theme_shadow_style'      => $shadow_style,
        'theme_header_style'      => $header_style,
        'theme_footer_style'      => $footer_style,
        'theme_card_style'        => $card_style,
        'theme_card_image_ratio'  => $card_image_ratio,
        'theme_card_image_padding' => $card_image_padding,
        'theme_card_hover_style'  => $card_hover_style,
        'theme_card_title_lines'  => $card_title_lines,
        'header_topbar_enabled'   => ! empty( $input['header_topbar_enabled'] ) ? '1' : '0',
        'topbar_city_enabled'     => ! empty( $input['topbar_city_enabled'] ) ? '1' : '0',
        'topbar_phone_enabled'    => ! empty( $input['topbar_phone_enabled'] ) ? '1' : '0',
        'topbar_shop_enabled'     => ! empty( $input['topbar_shop_enabled'] ) ? '1' : '0',
        'topbar_delivery_enabled' => ! empty( $input['topbar_delivery_enabled'] ) ? '1' : '0',
        'topbar_about_enabled'    => ! empty( $input['topbar_about_enabled'] ) ? '1' : '0',
        'topbar_contacts_enabled' => ! empty( $input['topbar_contacts_enabled'] ) ? '1' : '0',
        'header_search_enabled'   => ! empty( $input['header_search_enabled'] ) ? '1' : '0',
        'header_actions_enabled'  => ! empty( $input['header_actions_enabled'] ) ? '1' : '0',
        'header_compare_enabled'  => ! empty( $input['header_compare_enabled'] ) ? '1' : '0',
        'header_wishlist_enabled' => ! empty( $input['header_wishlist_enabled'] ) ? '1' : '0',
        'header_cart_enabled'     => ! empty( $input['header_cart_enabled'] ) ? '1' : '0',
        'header_ozon_enabled'     => ! empty( $input['header_ozon_enabled'] ) ? '1' : '0',
        'header_account_enabled'  => ! empty( $input['header_account_enabled'] ) ? '1' : '0',
        'header_catalog_dropdown_enabled' => ! empty( $input['header_catalog_dropdown_enabled'] ) ? '1' : '0',
        'header_nav_links_enabled' => ! empty( $input['header_nav_links_enabled'] ) ? '1' : '0',
        'header_categories_limit' => max( 0, min( 16, absint( $input['header_categories_limit'] ?? $defaults['header_categories_limit'] ) ) ),
        'footer_brand_enabled'    => ! empty( $input['footer_brand_enabled'] ) ? '1' : '0',
        'footer_description_enabled' => ! empty( $input['footer_description_enabled'] ) ? '1' : '0',
        'footer_contacts_enabled' => ! empty( $input['footer_contacts_enabled'] ) ? '1' : '0',
        'footer_catalog_enabled'  => ! empty( $input['footer_catalog_enabled'] ) ? '1' : '0',
        'footer_customers_enabled' => ! empty( $input['footer_customers_enabled'] ) ? '1' : '0',
        'footer_company_enabled'  => ! empty( $input['footer_company_enabled'] ) ? '1' : '0',
        'footer_bottom_enabled'   => ! empty( $input['footer_bottom_enabled'] ) ? '1' : '0',
        'footer_payment_icons_enabled' => ! empty( $input['footer_payment_icons_enabled'] ) ? '1' : '0',
        'footer_legal_links_enabled' => ! empty( $input['footer_legal_links_enabled'] ) ? '1' : '0',
        'footer_customers_1_enabled' => ! empty( $input['footer_customers_1_enabled'] ) ? '1' : '0',
        'footer_customers_2_enabled' => ! empty( $input['footer_customers_2_enabled'] ) ? '1' : '0',
        'footer_customers_3_enabled' => ! empty( $input['footer_customers_3_enabled'] ) ? '1' : '0',
        'footer_customers_4_enabled' => ! empty( $input['footer_customers_4_enabled'] ) ? '1' : '0',
        'footer_customers_5_enabled' => ! empty( $input['footer_customers_5_enabled'] ) ? '1' : '0',
        'footer_company_1_enabled' => ! empty( $input['footer_company_1_enabled'] ) ? '1' : '0',
        'footer_company_2_enabled' => ! empty( $input['footer_company_2_enabled'] ) ? '1' : '0',
        'footer_company_3_enabled' => ! empty( $input['footer_company_3_enabled'] ) ? '1' : '0',
        'footer_company_4_enabled' => ! empty( $input['footer_company_4_enabled'] ) ? '1' : '0',
        'footer_privacy_enabled'  => ! empty( $input['footer_privacy_enabled'] ) ? '1' : '0',
        'footer_offer_enabled'    => ! empty( $input['footer_offer_enabled'] ) ? '1' : '0',
        'footer_categories_limit' => max( 0, min( 16, absint( $input['footer_categories_limit'] ?? $defaults['footer_categories_limit'] ) ) ),
        'cart_coupon_enabled'     => ! empty( $input['cart_coupon_enabled'] ) ? '1' : '0',
        'cart_cross_sells_enabled' => ! empty( $input['cart_cross_sells_enabled'] ) ? '1' : '0',
        'cart_product_image_enabled' => ! empty( $input['cart_product_image_enabled'] ) ? '1' : '0',
        'cart_price_enabled'      => ! empty( $input['cart_price_enabled'] ) ? '1' : '0',
        'cart_subtotal_enabled'   => ! empty( $input['cart_subtotal_enabled'] ) ? '1' : '0',
        'checkout_coupon_enabled' => ! empty( $input['checkout_coupon_enabled'] ) ? '1' : '0',
        'checkout_login_enabled'  => ! empty( $input['checkout_login_enabled'] ) ? '1' : '0',
        'checkout_order_notes_enabled' => ! empty( $input['checkout_order_notes_enabled'] ) ? '1' : '0',
        'service_about_enabled'   => ! empty( $input['service_about_enabled'] ) ? '1' : '0',
        'service_delivery_enabled' => ! empty( $input['service_delivery_enabled'] ) ? '1' : '0',
        'service_contacts_enabled' => ! empty( $input['service_contacts_enabled'] ) ? '1' : '0',
        'service_return_enabled'  => ! empty( $input['service_return_enabled'] ) ? '1' : '0',
        'service_privacy_enabled' => ! empty( $input['service_privacy_enabled'] ) ? '1' : '0',
        'service_agreement_enabled' => ! empty( $input['service_agreement_enabled'] ) ? '1' : '0',
        'product_related_enabled' => ! empty( $input['product_related_enabled'] ) ? '1' : '0',
        'product_related_limit'   => max( 1, min( 12, absint( $input['product_related_limit'] ?? $defaults['product_related_limit'] ) ) ),
        'product_similar_enabled' => ! empty( $input['product_similar_enabled'] ) ? '1' : '0',
        'product_similar_limit'   => max( 1, min( 12, absint( $input['product_similar_limit'] ?? $defaults['product_similar_limit'] ) ) ),
        'product_recent_enabled'  => ! empty( $input['product_recent_enabled'] ) ? '1' : '0',
        'product_recent_limit'    => max( 1, min( 12, absint( $input['product_recent_limit'] ?? $defaults['product_recent_limit'] ) ) ),
        'catalog_marka_limit'     => max( 1, min( 80, absint( $input['catalog_marka_limit'] ?? $defaults['catalog_marka_limit'] ) ) ),
        'catalog_category_limit'   => max( 1, min( 40, absint( $input['catalog_category_limit'] ?? $defaults['catalog_category_limit'] ) ) ),
        'catalog_path_enabled'     => ! empty( $input['catalog_path_enabled'] ) ? '1' : '0',
        'catalog_marka_enabled'    => ! empty( $input['catalog_marka_enabled'] ) ? '1' : '0',
        'catalog_categories_enabled' => ! empty( $input['catalog_categories_enabled'] ) ? '1' : '0',
        'catalog_price_enabled'    => ! empty( $input['catalog_price_enabled'] ) ? '1' : '0',
        'catalog_stock_enabled'    => ! empty( $input['catalog_stock_enabled'] ) ? '1' : '0',
        'catalog_recs_enabled'    => ! empty( $input['catalog_recs_enabled'] ) ? '1' : '0',
        'catalog_recs_limit'      => max( 1, min( 12, absint( $input['catalog_recs_limit'] ?? $defaults['catalog_recs_limit'] ) ) ),
        'catalog_path_order'       => max( 1, min( 99, absint( $input['catalog_path_order'] ?? $defaults['catalog_path_order'] ) ) ),
        'catalog_marka_order'      => max( 1, min( 99, absint( $input['catalog_marka_order'] ?? $defaults['catalog_marka_order'] ) ) ),
        'catalog_categories_order' => max( 1, min( 99, absint( $input['catalog_categories_order'] ?? $defaults['catalog_categories_order'] ) ) ),
        'catalog_price_order'      => max( 1, min( 99, absint( $input['catalog_price_order'] ?? $defaults['catalog_price_order'] ) ) ),
        'catalog_stock_order'      => max( 1, min( 99, absint( $input['catalog_stock_order'] ?? $defaults['catalog_stock_order'] ) ) ),
        'catalog_recs_order'       => max( 1, min( 99, absint( $input['catalog_recs_order'] ?? $defaults['catalog_recs_order'] ) ) ),
        'catalog_card_badges_enabled' => ! empty( $input['catalog_card_badges_enabled'] ) ? '1' : '0',
        'catalog_card_actions_enabled' => ! empty( $input['catalog_card_actions_enabled'] ) ? '1' : '0',
        'catalog_card_compat_enabled' => ! empty( $input['catalog_card_compat_enabled'] ) ? '1' : '0',
        'catalog_card_rating_enabled' => ! empty( $input['catalog_card_rating_enabled'] ) ? '1' : '0',
        'catalog_card_sku_enabled' => ! empty( $input['catalog_card_sku_enabled'] ) ? '1' : '0',
        'catalog_card_stock_qty_enabled' => ! empty( $input['catalog_card_stock_qty_enabled'] ) ? '1' : '0',
        'home_product_columns'    => max( 2, min( 6, absint( $input['home_product_columns'] ?? $defaults['home_product_columns'] ) ) ),
        'search_live_limit'       => max( 1, min( 20, absint( $input['search_live_limit'] ?? $defaults['search_live_limit'] ) ) ),
        'search_page_per_page'    => max( 1, min( 96, absint( $input['search_page_per_page'] ?? $defaults['search_page_per_page'] ) ) ),
        'not_found_search_enabled' => ! empty( $input['not_found_search_enabled'] ) ? '1' : '0',
        'not_found_actions_enabled' => ! empty( $input['not_found_actions_enabled'] ) ? '1' : '0',
        'not_found_categories_enabled' => ! empty( $input['not_found_categories_enabled'] ) ? '1' : '0',
        'not_found_categories_limit' => max( 0, min( 20, absint( $input['not_found_categories_limit'] ?? $defaults['not_found_categories_limit'] ) ) ),
        'compare_limit'           => max( 2, min( 8, absint( $input['compare_limit'] ?? $defaults['compare_limit'] ) ) ),
        'product_gallery_hint_enabled' => ! empty( $input['product_gallery_hint_enabled'] ) ? '1' : '0',
        'product_meta_sku_enabled' => ! empty( $input['product_meta_sku_enabled'] ) ? '1' : '0',
        'product_actions_enabled'  => ! empty( $input['product_actions_enabled'] ) ? '1' : '0',
        'product_wishlist_enabled' => ! empty( $input['product_wishlist_enabled'] ) ? '1' : '0',
        'product_compare_enabled'  => ! empty( $input['product_compare_enabled'] ) ? '1' : '0',
        'product_ozon_enabled'     => ! empty( $input['product_ozon_enabled'] ) ? '1' : '0',
        'product_summary_description_enabled' => ! empty( $input['product_summary_description_enabled'] ) ? '1' : '0',
        'product_tab_description_enabled' => ! empty( $input['product_tab_description_enabled'] ) ? '1' : '0',
        'product_tab_specs_enabled' => ! empty( $input['product_tab_specs_enabled'] ) ? '1' : '0',
        'product_tab_reviews_enabled' => ! empty( $input['product_tab_reviews_enabled'] ) ? '1' : '0',
        'product_purchase_order'    => max( 1, min( 99, absint( $input['product_purchase_order'] ?? $defaults['product_purchase_order'] ) ) ),
        'product_ozon_order'        => max( 1, min( 99, absint( $input['product_ozon_order'] ?? $defaults['product_ozon_order'] ) ) ),
        'product_actions_order'     => max( 1, min( 99, absint( $input['product_actions_order'] ?? $defaults['product_actions_order'] ) ) ),
        'product_tabs_order'        => max( 1, min( 99, absint( $input['product_tabs_order'] ?? $defaults['product_tabs_order'] ) ) ),
        'product_related_order'     => max( 1, min( 99, absint( $input['product_related_order'] ?? $defaults['product_related_order'] ) ) ),
        'product_similar_order'     => max( 1, min( 99, absint( $input['product_similar_order'] ?? $defaults['product_similar_order'] ) ) ),
        'product_recent_order'      => max( 1, min( 99, absint( $input['product_recent_order'] ?? $defaults['product_recent_order'] ) ) ),
    );

    return $output;
}

function dv_theme_options_label( $text ) {
    return html_entity_decode( $text, ENT_QUOTES, 'UTF-8' );
}

function dv_admin_suite_pages() {
    return array(
        'dv-theme-options'  => array(
            'label'       => dv_theme_options_label( '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080;' ),
            'description' => dv_theme_options_label( '&#1042;&#1080;&#1090;&#1088;&#1080;&#1085;&#1072;, &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080;, &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1072;, checkout &#1080; &#1089;&#1077;&#1088;&#1074;&#1080;&#1089;&#1085;&#1099;&#1077; &#1087;&#1077;&#1088;&#1077;&#1082;&#1083;&#1102;&#1095;&#1072;&#1090;&#1077;&#1083;&#1080;.' ),
        ),
        'dv-seo-tools'      => array(
            'label'       => 'SEO',
            'description' => dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1082;&#1072; head, sitemap, &#1087;&#1088;&#1086;&#1075;&#1088;&#1077;&#1089;&#1089;&#1072; &#1080; SEO-&#1079;&#1072;&#1076;&#1072;&#1095;.' ),
        ),
        'dv-store-settings' => array(
            'label'       => dv_theme_options_label( '&#1052;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;' ),
            'description' => dv_theme_options_label( '&#1055;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100;, &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;, &#1083;&#1086;&#1075;&#1086;&#1090;&#1080;&#1087;, &#1092;&#1091;&#1090;&#1077;&#1088; &#1080; &#1084;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089;&#1099;.' ),
        ),
        'dv-theme-content'  => array(
            'label'       => dv_theme_options_label( '&#1050;&#1086;&#1085;&#1090;&#1077;&#1085;&#1090;' ),
            'description' => dv_theme_options_label( '&#1058;&#1077;&#1082;&#1089;&#1090;&#1099;, &#1089;&#1089;&#1099;&#1083;&#1082;&#1080;, CTA &#1080; &#1089;&#1077;&#1088;&#1074;&#1080;&#1089;&#1085;&#1099;&#1077; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1099;.' ),
        ),
    );
}

function dv_admin_suite_page_url( $page ) {
    return admin_url( 'admin.php?page=' . sanitize_key( $page ) );
}

function dv_admin_suite_search_text( $text ) {
    $text = wp_strip_all_tags( (string) $text );

    if ( function_exists( 'mb_strtolower' ) ) {
        return mb_strtolower( $text, 'UTF-8' );
    }

    return strtolower( $text );
}

function dv_admin_suite_quick_actions() {
    $catalog_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '';

    if ( ! $catalog_url ) {
        $catalog_url = home_url( '/catalog/' );
    }

    return array(
        array(
            'label'       => dv_theme_options_label( '&#1054;&#1090;&#1082;&#1088;&#1099;&#1090;&#1100; &#1089;&#1072;&#1081;&#1090;' ),
            'description' => dv_theme_options_label( '&#1043;&#1083;&#1072;&#1074;&#1085;&#1072;&#1103; &#1074; &#1085;&#1086;&#1074;&#1086;&#1081; &#1074;&#1082;&#1083;&#1072;&#1076;&#1082;&#1077;' ),
            'url'         => home_url( '/' ),
            'external'    => true,
        ),
        array(
            'label'       => dv_theme_options_label( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;' ),
            'description' => dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100; &#1074;&#1080;&#1090;&#1088;&#1080;&#1085;&#1091;' ),
            'url'         => $catalog_url,
            'external'    => true,
        ),
        array(
            'label'       => dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099;' ),
            'description' => dv_theme_options_label( '&#1055;&#1088;&#1072;&#1074;&#1082;&#1072; WooCommerce' ),
            'url'         => admin_url( 'edit.php?post_type=product' ),
            'external'    => false,
        ),
        array(
            'label'       => dv_theme_options_label( '&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;' ),
            'description' => dv_theme_options_label( 'SEO &#1080; &#1089;&#1090;&#1088;&#1091;&#1082;&#1090;&#1091;&#1088;&#1072;' ),
            'url'         => admin_url( 'edit-tags.php?taxonomy=product_cat&post_type=product' ),
            'external'    => false,
        ),
        array(
            'label'       => 'Slug',
            'description' => dv_theme_options_label( '&#1058;&#1088;&#1072;&#1085;&#1089;&#1083;&#1080;&#1090;&#1077;&#1088;&#1072;&#1094;&#1080;&#1103; URL' ),
            'url'         => admin_url( 'admin.php?page=dv-slug-tools' ),
            'external'    => false,
        ),
        array(
            'label'       => 'Sitemap',
            'description' => dv_theme_options_label( '&#1050;&#1072;&#1088;&#1090;&#1072; &#1089;&#1072;&#1081;&#1090;&#1072;' ),
            'url'         => home_url( '/sitemaps.xml' ),
            'external'    => true,
        ),
        array(
            'label'       => dv_theme_options_label( '&#1057;&#1082;&#1072;&#1095;&#1072;&#1090;&#1100; &#1088;&#1077;&#1079;&#1077;&#1088;&#1074;' ),
            'description' => 'JSON ' . dv_theme_options_label( '&#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1077;&#1082;' ),
            'url'         => wp_nonce_url( admin_url( 'admin-post.php?action=dv_theme_backup_export' ), 'dv_theme_backup_export' ),
            'external'    => false,
        ),
    );
}

function dv_admin_suite_command_items( $pages, $quick_actions ) {
    $items = array();

    foreach ( $pages as $page => $item ) {
        $items[] = array(
            'label'       => $item['label'],
            'description' => $item['description'],
            'group'       => dv_theme_options_label( '&#1056;&#1072;&#1079;&#1076;&#1077;&#1083;&#1099; &#1090;&#1077;&#1084;&#1099;' ),
            'url'         => dv_admin_suite_page_url( $page ),
            'external'    => false,
        );
    }

    foreach ( $quick_actions as $action ) {
        $items[] = array(
            'label'       => $action['label'],
            'description' => $action['description'],
            'group'       => dv_theme_options_label( '&#1041;&#1099;&#1089;&#1090;&#1088;&#1099;&#1077; &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1103;' ),
            'url'         => $action['url'],
            'external'    => ! empty( $action['external'] ),
        );
    }

    return $items;
}

function dv_render_admin_suite_header( $current_page, $title, $description = '' ) {
    $pages         = dv_admin_suite_pages();
    $quick_actions = dv_admin_suite_quick_actions();
    $command_items = dv_admin_suite_command_items( $pages, $quick_actions );
    ?>
    <header class="dv-suite-header">
        <div class="dv-suite-heading">
            <span class="dv-suite-kicker"><?php echo esc_html( dv_theme_options_label( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;' ) ); ?></span>
            <h1><?php echo esc_html( $title ); ?></h1>
            <?php if ( '' !== trim( (string) $description ) ) : ?>
                <p><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>
            <button type="button" class="dv-suite-command-button" id="dv-suite-command-open">
                <span><?php echo esc_html( dv_theme_options_label( '&#1041;&#1099;&#1089;&#1090;&#1088;&#1099;&#1081; &#1087;&#1077;&#1088;&#1077;&#1093;&#1086;&#1076;' ) ); ?></span>
                <kbd>Ctrl K</kbd>
            </button>
        </div>
        <nav class="dv-suite-tabs" aria-label="<?php echo esc_attr( dv_theme_options_label( '&#1056;&#1072;&#1079;&#1076;&#1077;&#1083;&#1099; &#1072;&#1076;&#1084;&#1080;&#1085;&#1082;&#1080; &#1090;&#1077;&#1084;&#1099;' ) ); ?>">
            <?php foreach ( $pages as $page => $item ) : ?>
                <a
                    class="dv-suite-tab<?php echo $page === $current_page ? ' is-active' : ''; ?>"
                    href="<?php echo esc_url( dv_admin_suite_page_url( $page ) ); ?>"
                    <?php echo $page === $current_page ? 'aria-current="page"' : ''; ?>
                >
                    <strong><?php echo esc_html( $item['label'] ); ?></strong>
                    <span><?php echo esc_html( $item['description'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="dv-suite-quick-actions" aria-label="<?php echo esc_attr( dv_theme_options_label( '&#1041;&#1099;&#1089;&#1090;&#1088;&#1099;&#1077; &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1103;' ) ); ?>">
            <?php foreach ( $quick_actions as $action ) : ?>
                <a
                    class="dv-suite-quick-action"
                    href="<?php echo esc_url( $action['url'] ); ?>"
                    <?php echo ! empty( $action['external'] ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
                >
                    <span><?php echo esc_html( $action['label'] ); ?></span>
                    <small><?php echo esc_html( $action['description'] ); ?></small>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="dv-suite-command" id="dv-suite-command" hidden>
            <div class="dv-suite-command-backdrop" data-dv-command-close></div>
            <div class="dv-suite-command-panel" role="dialog" aria-modal="true" aria-labelledby="dv-suite-command-title">
                <div class="dv-suite-command-head">
                    <div>
                        <strong id="dv-suite-command-title"><?php echo esc_html( dv_theme_options_label( '&#1050;&#1086;&#1084;&#1072;&#1085;&#1076;&#1085;&#1072;&#1103; &#1087;&#1072;&#1085;&#1077;&#1083;&#1100;' ) ); ?></strong>
                        <span><?php echo esc_html( dv_theme_options_label( '&#1053;&#1072;&#1081;&#1076;&#1080;&#1090;&#1077; &#1085;&#1091;&#1078;&#1085;&#1099;&#1081; &#1088;&#1072;&#1079;&#1076;&#1077;&#1083; &#1080;&#1083;&#1080; &#1073;&#1099;&#1089;&#1090;&#1088;&#1086;&#1077; &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1077;' ) ); ?></span>
                    </div>
                    <button type="button" class="button" data-dv-command-close><?php echo esc_html( dv_theme_options_label( '&#1047;&#1072;&#1082;&#1088;&#1099;&#1090;&#1100;' ) ); ?></button>
                </div>
                <label class="screen-reader-text" for="dv-suite-command-search"><?php echo esc_html( dv_theme_options_label( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1087;&#1086; &#1072;&#1076;&#1084;&#1080;&#1085;&#1082;&#1077; &#1090;&#1077;&#1084;&#1099;' ) ); ?></label>
                <input type="search" id="dv-suite-command-search" class="dv-suite-command-search" role="combobox" aria-expanded="true" aria-controls="dv-suite-command-list" autocomplete="off" placeholder="<?php echo esc_attr( dv_theme_options_label( '&#1053;&#1072;&#1087;&#1088;&#1080;&#1084;&#1077;&#1088;: SEO, &#1090;&#1086;&#1074;&#1072;&#1088;&#1099;, sitemap' ) ); ?>">
                <div class="dv-suite-command-list" id="dv-suite-command-list" role="listbox">
                    <?php foreach ( $command_items as $index => $item ) : ?>
                        <a
                            id="<?php echo esc_attr( 'dv-suite-command-item-' . $index ); ?>"
                            class="dv-suite-command-item"
                            href="<?php echo esc_url( $item['url'] ); ?>"
                            data-search="<?php echo esc_attr( dv_admin_suite_search_text( $item['label'] . ' ' . $item['description'] . ' ' . $item['group'] ) ); ?>"
                            role="option"
                            <?php echo ! empty( $item['external'] ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
                        >
                            <small><?php echo esc_html( $item['group'] ); ?></small>
                            <span><?php echo esc_html( $item['label'] ); ?></span>
                            <em><?php echo esc_html( $item['description'] ); ?></em>
                        </a>
                    <?php endforeach; ?>
                </div>
                <p class="dv-suite-command-empty" hidden><?php echo esc_html( dv_theme_options_label( '&#1053;&#1080;&#1095;&#1077;&#1075;&#1086; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;. &#1055;&#1086;&#1087;&#1088;&#1086;&#1073;&#1091;&#1081;&#1090;&#1077; &#1076;&#1088;&#1091;&#1075;&#1086;&#1081; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;.' ) ); ?></p>
            </div>
        </div>
    </header>
    <?php
}

function dv_theme_admin_enqueue_common_assets() {
    $page  = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
    $pages = dv_admin_suite_pages();

    if ( ! isset( $pages[ $page ] ) ) {
        return;
    }

    $css_path = DV_DIR . '/assets/css/theme-admin.css';

    wp_enqueue_style(
        'dv-theme-admin',
        DV_URI . '/assets/css/theme-admin.css',
        array(),
        file_exists( $css_path ) ? filemtime( $css_path ) : DV_VERSION
    );

    $js_path = DV_DIR . '/assets/js/theme-admin.js';

    wp_enqueue_script(
        'dv-theme-admin',
        DV_URI . '/assets/js/theme-admin.js',
        array(),
        file_exists( $js_path ) ? filemtime( $js_path ) : DV_VERSION,
        true
    );

    wp_localize_script(
        'dv-theme-admin',
        'dvThemeAdmin',
        array(
            'unsavedMessage' => dv_theme_options_label( '&#1045;&#1089;&#1090;&#1100; &#1085;&#1077;&#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1105;&#1085;&#1085;&#1099;&#1077; &#1080;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1080;&#1103;' ),
            'dirtyCount'     => dv_theme_options_label( '&#1048;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1086; &#1087;&#1086;&#1083;&#1077;&#1081;:' ),
            'saveLabel'      => dv_theme_options_label( '&#1057;&#1086;&#1093;&#1088;&#1072;&#1085;&#1080;&#1090;&#1100;' ),
        )
    );
}
add_action( 'admin_enqueue_scripts', 'dv_theme_admin_enqueue_common_assets', 5 );

function dv_theme_admin_body_class( $classes ) {
    $page  = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
    $pages = dv_admin_suite_pages();

    if ( ! isset( $pages[ $page ] ) ) {
        return $classes;
    }

    $extra = ' dv-suite-admin dv-suite-admin-' . sanitize_html_class( $page );

    return trim( $classes . $extra );
}
add_filter( 'admin_body_class', 'dv_theme_admin_body_class' );

function dv_dashboard_status_cache_key() {
    return 'dv_dashboard_status_summary_v1';
}

function dv_dashboard_status_clear_cache() {
    delete_transient( dv_dashboard_status_cache_key() );
}

function dv_dashboard_status_clear_cache_on_option_change( $option_name ) {
    $watched_options = array(
        'dv_theme_options',
        'dv_theme_content',
        'dv_store_profile',
        'dv_seo_settings',
    );

    if ( function_exists( 'dv_theme_backup_last_import_option_name' ) ) {
        $watched_options[] = dv_theme_backup_last_import_option_name();
    }

    if ( function_exists( 'dv_theme_auto_backup_option_name' ) ) {
        $watched_options[] = dv_theme_auto_backup_option_name();
    }

    if ( in_array( (string) $option_name, $watched_options, true ) ) {
        dv_dashboard_status_clear_cache();
    }
}
add_action( 'updated_option', 'dv_dashboard_status_clear_cache_on_option_change', 10, 1 );
add_action( 'added_option', 'dv_dashboard_status_clear_cache_on_option_change', 10, 1 );

function dv_handle_dashboard_status_refresh() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to refresh this dashboard widget.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_dashboard_status_refresh' );
    dv_dashboard_status_clear_cache();

    wp_safe_redirect(
        add_query_arg(
            array(
                'dv-dashboard-status' => 'refreshed',
            ),
            admin_url( 'index.php' )
        )
    );
    exit;
}
add_action( 'admin_post_dv_dashboard_status_refresh', 'dv_handle_dashboard_status_refresh' );

function dv_dashboard_status_summary() {
    $cached = get_transient( dv_dashboard_status_cache_key() );

    if ( is_array( $cached ) ) {
        return $cached;
    }

    $options      = function_exists( 'dv_get_theme_options' ) ? dv_get_theme_options() : array();
    $audit        = function_exists( 'dv_theme_product_audit_report' ) ? dv_theme_product_audit_report() : array();
    $profile      = function_exists( 'dv_theme_store_profile_health_report' ) ? dv_theme_store_profile_health_report() : array();
    $marketplaces = function_exists( 'dv_theme_marketplace_diagnostics_report' ) ? dv_theme_marketplace_diagnostics_report( $options ) : array();
    $maintenance  = function_exists( 'dv_theme_maintenance_report' ) ? dv_theme_maintenance_report() : array();
    $backup       = function_exists( 'dv_theme_backup_state' ) ? dv_theme_backup_state() : array();
    $history      = function_exists( 'dv_theme_settings_history_get' ) ? array_slice( dv_theme_settings_history_get(), 0, 4 ) : array();
    $seo_health   = null;
    $seo_actions  = array();

    if (
        function_exists( 'dv_seo_tools_get_manual_overview' )
        && function_exists( 'dv_seo_tools_get_product_seo_gaps' )
        && function_exists( 'dv_seo_tools_get_sitemap_stats' )
        && function_exists( 'dv_seo_tools_get_progress_summary' )
        && function_exists( 'dv_seo_tools_get_action_queue' )
        && function_exists( 'dv_seo_tools_get_health_score' )
    ) {
        $overview   = dv_seo_tools_get_manual_overview();
        $gaps       = dv_seo_tools_get_product_seo_gaps( 4 );
        $stats      = dv_seo_tools_get_sitemap_stats();
        $progress   = dv_seo_tools_get_progress_summary( $overview, $gaps );
        $seo_actions = dv_seo_tools_get_action_queue( $overview, $gaps );
        $seo_health  = dv_seo_tools_get_health_score( $progress, $seo_actions, $stats );
    }

    $summary = array(
        'audit'        => $audit,
        'profile'      => $profile,
        'marketplaces' => $marketplaces,
        'maintenance'  => $maintenance,
        'backup'       => $backup,
        'settings_history' => $history,
        'seo_health'   => $seo_health,
        'seo_actions'  => is_array( $seo_actions ) ? $seo_actions : array(),
        'generated_at' => time(),
        'generated_at_display' => date_i18n( 'd.m.Y H:i' ),
    );

    set_transient( dv_dashboard_status_cache_key(), $summary, 10 * MINUTE_IN_SECONDS );

    return $summary;
}

function dv_dashboard_status_tasks( $summary ) {
    $tasks = array();
    $audit = isset( $summary['audit'] ) && is_array( $summary['audit'] ) ? $summary['audit'] : array();

    foreach ( $audit['issues'] ?? array() as $issue ) {
        if ( empty( $issue['count'] ) ) {
            continue;
        }

        $tasks[] = array(
            'label' => sprintf(
                /* translators: 1: issue label, 2: count. */
                '%1$s: %2$d',
                wp_strip_all_tags( (string) ( $issue['label'] ?? '' ) ),
                absint( $issue['count'] )
            ),
            'url'   => ! empty( $issue['sample_url'] ) ? $issue['sample_url'] : admin_url( 'admin.php?page=dv-theme-options#dv-options-diagnostics' ),
        );
    }

    foreach ( array_slice( $summary['seo_actions'] ?? array(), 0, 3 ) as $action ) {
        if ( empty( $action['label'] ) ) {
            continue;
        }

        $tasks[] = array(
            'label' => 'SEO: ' . wp_strip_all_tags( (string) $action['label'] ),
            'url'   => ! empty( $action['link'] ) ? $action['link'] : admin_url( 'admin.php?page=dv-seo-tools#dv-seo-actions' ),
        );
    }

    $profile = isset( $summary['profile'] ) && is_array( $summary['profile'] ) ? $summary['profile'] : array();
    if ( ! empty( $profile['issue_count'] ) ) {
        $tasks[] = array(
            'label' => sprintf(
                /* translators: %d: issues count. */
                dv_theme_options_label( '&#1055;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;: &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100; %d' ),
                absint( $profile['issue_count'] )
            ),
            'url'   => admin_url( 'admin.php?page=dv-store-settings' ),
        );
    }

    $marketplaces = isset( $summary['marketplaces'] ) && is_array( $summary['marketplaces'] ) ? $summary['marketplaces'] : array();
    if ( empty( $marketplaces['status'] ) ) {
        $tasks[] = array(
            'label' => sprintf(
                /* translators: %d: issues count. */
                'Ozon / marketplace: %d',
                count( $marketplaces['issues'] ?? array() )
            ),
            'url'   => admin_url( 'admin.php?page=dv-store-settings#dv-store-marketplaces' ),
        );
    }

    return array_slice( $tasks, 0, 6 );
}

function dv_render_dashboard_metric( $label, $value, $hint, $status = 'ok' ) {
    ?>
    <article class="dv-dashboard-metric is-<?php echo esc_attr( sanitize_html_class( $status ) ); ?>">
        <span><?php echo esc_html( $label ); ?></span>
        <strong><?php echo esc_html( $value ); ?></strong>
        <small><?php echo esc_html( $hint ); ?></small>
    </article>
    <?php
}

function dv_render_dashboard_status_widget() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $summary      = dv_dashboard_status_summary();
    $audit        = $summary['audit'];
    $profile      = $summary['profile'];
    $marketplaces = $summary['marketplaces'];
    $maintenance  = $summary['maintenance'];
    $backup       = $summary['backup'];
    $seo_health   = $summary['seo_health'];
    $tasks        = dv_dashboard_status_tasks( $summary );
    $history      = isset( $summary['settings_history'] ) && is_array( $summary['settings_history'] ) ? $summary['settings_history'] : array();
    $refresh_url  = wp_nonce_url( admin_url( 'admin-post.php?action=dv_dashboard_status_refresh' ), 'dv_dashboard_status_refresh' );
    ?>
    <div class="dv-dashboard-widget">
        <div class="dv-dashboard-widget-head">
            <div>
                <strong><?php echo esc_html( dv_theme_options_label( '&#1057;&#1086;&#1089;&#1090;&#1086;&#1103;&#1085;&#1080;&#1077; &#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;' ) ); ?></strong>
                <p><?php echo esc_html( dv_theme_options_label( '&#1050;&#1086;&#1088;&#1086;&#1090;&#1082;&#1080;&#1081; &#1089;&#1088;&#1077;&#1079; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;, SEO, &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1103; &#1080; &#1088;&#1077;&#1079;&#1077;&#1088;&#1074;&#1072;.' ) ); ?></p>
                <small><?php echo esc_html( dv_theme_options_label( '&#1054;&#1073;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085;&#1086;: ' ) . ( $summary['generated_at_display'] ?? '' ) ); ?></small>
            </div>
            <div class="dv-dashboard-widget-actions">
                <a class="button" href="<?php echo esc_url( $refresh_url ); ?>">
                    <?php echo esc_html( dv_theme_options_label( '&#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1100;' ) ); ?>
                </a>
                <a class="button button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=dv-theme-options#dv-options-diagnostics' ) ); ?>">
                    <?php echo esc_html( dv_theme_options_label( '&#1044;&#1080;&#1072;&#1075;&#1085;&#1086;&#1089;&#1090;&#1080;&#1082;&#1072;' ) ); ?>
                </a>
            </div>
        </div>

        <div class="dv-dashboard-metrics">
            <?php
            dv_render_dashboard_metric(
                dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099;' ),
                number_format_i18n( absint( $audit['total'] ?? 0 ) ),
                sprintf(
                    /* translators: %d: issue count. */
                    dv_theme_options_label( '&#1047;&#1072;&#1084;&#1077;&#1095;&#1072;&#1085;&#1080;&#1081;: %d' ),
                    absint( $audit['issue_count'] ?? 0 )
                ),
                empty( $audit['issue_count'] ) ? 'ok' : 'warning'
            );

            dv_render_dashboard_metric(
                'SEO',
                $seo_health ? ( absint( $seo_health['score'] ?? 0 ) . '%' ) : '-',
                $seo_health ? (string) ( $seo_health['label'] ?? '' ) : dv_theme_options_label( '&#1053;&#1077;&#1090; &#1089;&#1074;&#1086;&#1076;&#1082;&#1080;' ),
                $seo_health && absint( $seo_health['score'] ?? 0 ) >= 80 ? 'ok' : 'warning'
            );

            dv_render_dashboard_metric(
                dv_theme_options_label( '&#1055;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100;' ),
                absint( $profile['passed'] ?? 0 ) . '/' . absint( $profile['total'] ?? 0 ),
                empty( $profile['issue_count'] ) ? dv_theme_options_label( '&#1047;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;' ) : dv_theme_options_label( '&#1045;&#1089;&#1090;&#1100; &#1087;&#1088;&#1086;&#1087;&#1091;&#1089;&#1082;&#1080;' ),
                empty( $profile['issue_count'] ) ? 'ok' : 'warning'
            );

            dv_render_dashboard_metric(
                'Ozon',
                ! empty( $marketplaces['status'] ) ? 'OK' : dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100;' ),
                sprintf(
                    /* translators: %d: issue count. */
                    dv_theme_options_label( '&#1047;&#1072;&#1084;&#1077;&#1095;&#1072;&#1085;&#1080;&#1081;: %d' ),
                    count( $marketplaces['issues'] ?? array() )
                ),
                ! empty( $marketplaces['status'] ) ? 'ok' : 'warning'
            );

            dv_render_dashboard_metric(
                dv_theme_options_label( '&#1056;&#1077;&#1079;&#1077;&#1088;&#1074;' ),
                ! empty( $backup['has_restore'] ) ? 'OK' : dv_theme_options_label( '&#1054;&#1078;&#1080;&#1076;&#1072;&#1077;&#1090;' ),
                ! empty( $backup['created_at_display'] ) ? (string) $backup['created_at_display'] : dv_theme_options_label( '&#1089;&#1085;&#1080;&#1084;&#1086;&#1082; &#1087;&#1086;&#1089;&#1083;&#1077; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1072;' ),
                ! empty( $backup['has_restore'] ) ? 'ok' : 'neutral'
            );

            dv_render_dashboard_metric(
                dv_theme_options_label( '&#1054;&#1073;&#1089;&#1083;&#1091;&#1078;&#1080;&#1074;&#1072;&#1085;&#1080;&#1077;' ),
                ! empty( $maintenance['status'] ) ? 'OK' : dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100;' ),
                sprintf(
                    /* translators: %d: issue count. */
                    dv_theme_options_label( '&#1047;&#1072;&#1084;&#1077;&#1095;&#1072;&#1085;&#1080;&#1081;: %d' ),
                    absint( $maintenance['issue_count'] ?? 0 )
                ),
                ! empty( $maintenance['status'] ) ? 'ok' : 'warning'
            );
            ?>
        </div>

        <div class="dv-dashboard-next">
            <strong><?php echo esc_html( dv_theme_options_label( '&#1041;&#1083;&#1080;&#1078;&#1072;&#1081;&#1096;&#1080;&#1077; &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1103;' ) ); ?></strong>
            <?php if ( empty( $tasks ) ) : ?>
                <p><?php echo esc_html( dv_theme_options_label( '&#1050;&#1088;&#1080;&#1090;&#1080;&#1095;&#1085;&#1099;&#1093; &#1079;&#1072;&#1076;&#1072;&#1095; &#1085;&#1077;&#1090;.' ) ); ?></p>
            <?php else : ?>
                <ul>
                    <?php foreach ( $tasks as $task ) : ?>
                        <li><a href="<?php echo esc_url( $task['url'] ); ?>"><?php echo esc_html( $task['label'] ); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="dv-dashboard-history">
            <div class="dv-dashboard-history-head">
                <strong><?php echo esc_html( dv_theme_options_label( '&#1055;&#1086;&#1089;&#1083;&#1077;&#1076;&#1085;&#1080;&#1077; &#1080;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1080;&#1103;' ) ); ?></strong>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=dv-theme-options#dv-options-backup' ) ); ?>">
                    <?php echo esc_html( dv_theme_options_label( '&#1046;&#1091;&#1088;&#1085;&#1072;&#1083;' ) ); ?>
                </a>
            </div>
            <?php if ( empty( $history ) ) : ?>
                <p><?php echo esc_html( dv_theme_options_label( '&#1048;&#1089;&#1090;&#1086;&#1088;&#1080;&#1103; &#1087;&#1086;&#1082;&#1072; &#1087;&#1091;&#1089;&#1090;&#1072;.' ) ); ?></p>
            <?php else : ?>
                <ul>
                    <?php foreach ( $history as $entry ) : ?>
                        <?php
                        $changed_at_time = ! empty( $entry['changed_at'] ) ? strtotime( (string) $entry['changed_at'] ) : 0;
                        $changed_at      = $changed_at_time ? date_i18n( 'd.m.Y H:i', $changed_at_time ) : '';
                        $entry_label     = ! empty( $entry['label'] ) ? dv_theme_options_label( (string) $entry['label'] ) : dv_theme_options_label( '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080;' );
                        $entry_user      = ! empty( $entry['user_name'] ) ? (string) $entry['user_name'] : '';
                        $changed_count   = absint( $entry['changed_count'] ?? 0 );
                        ?>
                        <li>
                            <span><?php echo esc_html( $changed_at ); ?></span>
                            <strong><?php echo esc_html( $entry_label ); ?></strong>
                            <small>
                                <?php
                                echo esc_html(
                                    trim(
                                        sprintf(
                                            /* translators: 1: changed fields count, 2: user name. */
                                            dv_theme_options_label( '&#1055;&#1086;&#1083;&#1077;&#1081;: %1$d%2$s' ),
                                            $changed_count,
                                            $entry_user ? ' · ' . $entry_user : ''
                                        )
                                    )
                                );
                                ?>
                            </small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="dv-dashboard-links">
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=dv-store-settings' ) ); ?>"><?php echo esc_html( dv_theme_options_label( '&#1052;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;' ) ); ?></a>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=dv-seo-tools' ) ); ?>">SEO</a>
            <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product' ) ); ?>"><?php echo esc_html( dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099;' ) ); ?></a>
            <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=dv_theme_backup_export' ), 'dv_theme_backup_export' ) ); ?>"><?php echo esc_html( dv_theme_options_label( '&#1056;&#1077;&#1079;&#1077;&#1088;&#1074;' ) ); ?></a>
        </div>
    </div>
    <?php
}

function dv_register_dashboard_status_widget() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    wp_add_dashboard_widget(
        'dv_dashboard_status_widget',
        dv_theme_options_label( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;: &#1089;&#1086;&#1089;&#1090;&#1086;&#1103;&#1085;&#1080;&#1077; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;' ),
        'dv_render_dashboard_status_widget'
    );
}
add_action( 'wp_dashboard_setup', 'dv_register_dashboard_status_widget' );

function dv_dashboard_status_enqueue_assets( $hook_suffix ) {
    if ( 'index.php' !== $hook_suffix ) {
        return;
    }

    $css_path = DV_DIR . '/assets/css/theme-admin.css';

    wp_enqueue_style(
        'dv-theme-admin-dashboard',
        DV_URI . '/assets/css/theme-admin.css',
        array(),
        file_exists( $css_path ) ? filemtime( $css_path ) : DV_VERSION
    );
}
add_action( 'admin_enqueue_scripts', 'dv_dashboard_status_enqueue_assets', 6 );

function dv_register_theme_options_page() {
    add_menu_page(
        dv_theme_options_label( '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1090;&#1077;&#1084;&#1099;' ),
        dv_theme_options_label( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;' ),
        'manage_options',
        'dv-theme-options',
        'dv_render_theme_options_page',
        'dashicons-admin-customizer',
        58
    );

    add_submenu_page(
        'dv-theme-options',
        dv_theme_options_label( '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1090;&#1077;&#1084;&#1099;' ),
        dv_theme_options_label( '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080;' ),
        'manage_options',
        'dv-theme-options',
        'dv_render_theme_options_page'
    );
}
add_action( 'admin_menu', 'dv_register_theme_options_page', 8 );

function dv_theme_options_admin_enqueue_assets( $hook_suffix ) {
    $page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
    if ( 'dv-theme-options' !== $page ) {
        return;
    }

    $css_path = DV_DIR . '/assets/css/theme-options-admin.css';

    wp_enqueue_style(
        'dv-theme-options-admin',
        DV_URI . '/assets/css/theme-options-admin.css',
        array(),
        file_exists( $css_path ) ? filemtime( $css_path ) : DV_VERSION
    );

    $js_path = DV_DIR . '/assets/js/theme-options-admin.js';

    wp_enqueue_script(
        'dv-theme-options-admin',
        DV_URI . '/assets/js/theme-options-admin.js',
        array(),
        file_exists( $js_path ) ? filemtime( $js_path ) : DV_VERSION,
        true
    );
}
add_action( 'admin_enqueue_scripts', 'dv_theme_options_admin_enqueue_assets' );

function dv_handle_theme_options_save() {
    if ( empty( $_POST['dv_theme_options_action'] ) || 'save' !== $_POST['dv_theme_options_action'] ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to manage theme options.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_save_theme_options' );

    $options = dv_sanitize_theme_options( wp_unslash( $_POST['dv_theme_options'] ?? array() ) );
    update_option( 'dv_theme_options', $options, false );

    wp_safe_redirect(
        add_query_arg(
            array(
                'page'             => 'dv-theme-options',
                'settings-updated' => '1',
            ),
            admin_url( 'admin.php' )
        )
    );
    exit;
}
add_action( 'admin_init', 'dv_handle_theme_options_save' );

function dv_theme_backup_option_names() {
    return array(
        'dv_theme_options',
        'dv_theme_content',
        'dv_store_profile',
        'dv_seo_settings',
    );
}

function dv_theme_settings_history_option_name() {
    return 'dv_theme_settings_history';
}

function dv_theme_settings_history_option_labels() {
    return array(
        'dv_theme_options' => '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1090;&#1077;&#1084;&#1099;',
        'dv_theme_content' => '&#1050;&#1086;&#1085;&#1090;&#1077;&#1085;&#1090; &#1090;&#1077;&#1084;&#1099;',
        'dv_store_profile' => '&#1055;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;',
        'dv_seo_settings' => 'SEO',
    );
}

function dv_theme_settings_history_changed_keys( $old_value, $new_value ) {
    if ( is_array( $new_value ) && ! is_array( $old_value ) ) {
        return array_map( 'sanitize_key', array_map( 'strval', array_keys( $new_value ) ) );
    }

    if ( ! is_array( $old_value ) || ! is_array( $new_value ) ) {
        return array();
    }

    $keys    = array_unique( array_merge( array_keys( $old_value ), array_keys( $new_value ) ) );
    $changed = array();

    foreach ( $keys as $key ) {
        $old_item = array_key_exists( $key, $old_value ) ? $old_value[ $key ] : null;
        $new_item = array_key_exists( $key, $new_value ) ? $new_value[ $key ] : null;

        if ( maybe_serialize( $old_item ) !== maybe_serialize( $new_item ) ) {
            $changed[] = sanitize_key( (string) $key );
        }
    }

    return $changed;
}

function dv_theme_settings_history_get() {
    $history = get_option( dv_theme_settings_history_option_name(), array() );

    if ( ! is_array( $history ) ) {
        return array();
    }

    return array_values(
        array_filter(
            $history,
            static function ( $entry ) {
                return is_array( $entry ) && ! empty( $entry['option'] ) && ! empty( $entry['changed_at_gmt'] );
            }
        )
    );
}

function dv_theme_settings_history_record( $option_name, $old_value, $new_value ) {
    if ( ! in_array( $option_name, dv_theme_backup_option_names(), true ) ) {
        return;
    }

    if ( maybe_serialize( $old_value ) === maybe_serialize( $new_value ) ) {
        return;
    }

    $labels       = dv_theme_settings_history_option_labels();
    $changed_keys = dv_theme_settings_history_changed_keys( $old_value, $new_value );
    $user         = wp_get_current_user();
    $history      = dv_theme_settings_history_get();

    array_unshift(
        $history,
        array(
            'id'             => function_exists( 'wp_generate_uuid4' ) ? wp_generate_uuid4() : uniqid( 'dv_', true ),
            'option'         => $option_name,
            'label'          => $labels[ $option_name ] ?? $option_name,
            'changed_at'     => current_time( 'mysql' ),
            'changed_at_gmt' => current_time( 'mysql', true ),
            'user_id'        => get_current_user_id(),
            'user_name'      => $user && $user->exists() ? $user->display_name : '',
            'changed_count'  => count( $changed_keys ),
            'changed_keys'   => array_slice( $changed_keys, 0, 10 ),
        )
    );

    update_option( dv_theme_settings_history_option_name(), array_slice( $history, 0, 12 ), false );
}

function dv_theme_settings_history_track_updated_option( $option_name, $old_value, $new_value ) {
    dv_theme_settings_history_record( (string) $option_name, $old_value, $new_value );
}
add_action( 'updated_option', 'dv_theme_settings_history_track_updated_option', 10, 3 );

function dv_theme_settings_history_track_added_option( $option_name, $value ) {
    dv_theme_settings_history_record( (string) $option_name, null, $value );
}
add_action( 'added_option', 'dv_theme_settings_history_track_added_option', 10, 2 );

function dv_theme_settings_history_csv_cell( $value ) {
    $value = wp_strip_all_tags( (string) $value );
    $value = html_entity_decode( $value, ENT_QUOTES, 'UTF-8' );
    $value = preg_replace( '/\s+/', ' ', $value );
    $value = trim( (string) $value );

    if ( '' !== $value && preg_match( '/^[=+\-@]/', $value ) ) {
        $value = "'" . $value;
    }

    return $value;
}

function dv_theme_settings_history_csv_row( $handle, $row ) {
    fputcsv( $handle, array_map( 'dv_theme_settings_history_csv_cell', $row ), ';' );
}

function dv_handle_theme_settings_history_export() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to export settings history.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_settings_history_export' );

    nocache_headers();
    header( 'Content-Type: text/csv; charset=UTF-8' );
    header( 'Content-Disposition: attachment; filename="detalivam-settings-history-' . gmdate( 'Y-m-d-H-i' ) . '.csv"' );

    $handle = fopen( 'php://output', 'w' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
    echo "\xEF\xBB\xBF"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    dv_theme_settings_history_csv_row(
        $handle,
        array(
            dv_theme_options_label( '&#1044;&#1072;&#1090;&#1072;' ),
            dv_theme_options_label( '&#1043;&#1088;&#1091;&#1087;&#1087;&#1072;' ),
            dv_theme_options_label( '&#1054;&#1087;&#1094;&#1080;&#1103;' ),
            dv_theme_options_label( '&#1055;&#1086;&#1083;&#1100;&#1079;&#1086;&#1074;&#1072;&#1090;&#1077;&#1083;&#1100;' ),
            dv_theme_options_label( '&#1055;&#1086;&#1083;&#1077;&#1081;' ),
            dv_theme_options_label( '&#1050;&#1083;&#1102;&#1095;&#1080;' ),
        )
    );

    foreach ( dv_theme_settings_history_get() as $entry ) {
        $timestamp = ! empty( $entry['changed_at_gmt'] ) ? strtotime( (string) $entry['changed_at_gmt'] . ' UTC' ) : false;
        $date      = $timestamp ? wp_date( 'd.m.Y H:i', $timestamp ) : (string) ( $entry['changed_at'] ?? '' );
        $keys      = ! empty( $entry['changed_keys'] ) && is_array( $entry['changed_keys'] ) ? implode( ', ', $entry['changed_keys'] ) : '';

        dv_theme_settings_history_csv_row(
            $handle,
            array(
                $date,
                dv_theme_options_label( (string) ( $entry['label'] ?? $entry['option'] ?? '' ) ),
                (string) ( $entry['option'] ?? '' ),
                (string) ( $entry['user_name'] ?? '' ),
                absint( $entry['changed_count'] ?? 0 ),
                $keys,
            )
        );
    }

    fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
    exit;
}
add_action( 'admin_post_dv_theme_settings_history_export', 'dv_handle_theme_settings_history_export' );

function dv_handle_theme_settings_history_clear() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to clear settings history.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_settings_history_clear' );

    delete_option( dv_theme_settings_history_option_name() );

    if ( function_exists( 'dv_dashboard_status_clear_cache' ) ) {
        dv_dashboard_status_clear_cache();
    }

    wp_safe_redirect(
        add_query_arg(
            array(
                'page'             => 'dv-theme-options',
                'settings-history' => 'cleared',
            ),
            admin_url( 'admin.php' )
        ) . '#dv-options-backup'
    );
    exit;
}
add_action( 'admin_post_dv_theme_settings_history_clear', 'dv_handle_theme_settings_history_clear' );

function dv_theme_backup_last_import_option_name() {
    return 'dv_theme_backup_before_last_import';
}

function dv_theme_auto_backup_option_name() {
    return 'dv_theme_auto_backup_before_save';
}

function dv_theme_options_reset_groups() {
    return array(
        'visual'       => array(
            'label'       => '&#1042;&#1080;&#1079;&#1091;&#1072;&#1083;&#1100;&#1085;&#1099;&#1081; &#1089;&#1090;&#1080;&#1083;&#1100;',
            'description' => '&#1055;&#1088;&#1077;&#1089;&#1077;&#1090;, &#1094;&#1074;&#1077;&#1090;&#1072;, &#1096;&#1080;&#1088;&#1080;&#1085;&#1072;, &#1089;&#1082;&#1088;&#1091;&#1075;&#1083;&#1077;&#1085;&#1080;&#1103;, &#1090;&#1077;&#1085;&#1080;, &#1087;&#1083;&#1086;&#1090;&#1085;&#1086;&#1089;&#1090;&#1100; &#1080; &#1074;&#1080;&#1076; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1077;&#1082;.',
            'anchor'      => 'dv-options-visual',
            'keys'        => array(
                'theme_visual_preset',
                'theme_color_scheme',
                'theme_layout_width',
                'theme_radius_style',
                'theme_density_style',
                'theme_shadow_style',
                'theme_header_style',
                'theme_footer_style',
                'theme_card_style',
                'theme_card_image_ratio',
                'theme_card_image_padding',
                'theme_card_hover_style',
                'theme_card_title_lines',
            ),
        ),
        'header'       => array(
            'label'       => '&#1064;&#1072;&#1087;&#1082;&#1072;',
            'description' => '&#1042;&#1077;&#1088;&#1093;&#1085;&#1103;&#1103; &#1087;&#1072;&#1085;&#1077;&#1083;&#1100;, &#1087;&#1086;&#1080;&#1089;&#1082;, &#1080;&#1082;&#1086;&#1085;&#1082;&#1080;, Ozon, &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075; &#1080; &#1085;&#1072;&#1074;&#1080;&#1075;&#1072;&#1094;&#1080;&#1103;.',
            'anchor'      => 'dv-options-header',
            'keys'        => array(
                'header_topbar_enabled',
                'topbar_city_enabled',
                'topbar_phone_enabled',
                'topbar_shop_enabled',
                'topbar_delivery_enabled',
                'topbar_about_enabled',
                'topbar_contacts_enabled',
                'header_search_enabled',
                'header_actions_enabled',
                'header_compare_enabled',
                'header_wishlist_enabled',
                'header_cart_enabled',
                'header_ozon_enabled',
                'header_account_enabled',
                'header_catalog_dropdown_enabled',
                'header_nav_links_enabled',
                'header_categories_limit',
            ),
        ),
        'catalog'      => array(
            'label'       => '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;',
            'description' => '&#1057;&#1077;&#1090;&#1082;&#1072;, &#1092;&#1080;&#1083;&#1100;&#1090;&#1088;&#1099;, &#1083;&#1080;&#1084;&#1080;&#1090;&#1099;, &#1087;&#1091;&#1090;&#1100;, &#1084;&#1072;&#1088;&#1082;&#1080;, &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;, &#1094;&#1077;&#1085;&#1072;, &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077; &#1080; &#1088;&#1077;&#1082;&#1086;&#1084;&#1077;&#1085;&#1076;&#1072;&#1094;&#1080;&#1080;.',
            'anchor'      => 'dv-options-catalog',
            'keys'        => array(
                'catalog_per_page',
                'catalog_columns',
                'catalog_marka_limit',
                'catalog_category_limit',
                'catalog_path_enabled',
                'catalog_marka_enabled',
                'catalog_categories_enabled',
                'catalog_price_enabled',
                'catalog_stock_enabled',
                'catalog_recs_enabled',
                'catalog_recs_limit',
                'catalog_path_order',
                'catalog_marka_order',
                'catalog_categories_order',
                'catalog_price_order',
                'catalog_stock_order',
                'catalog_recs_order',
            ),
        ),
        'catalog-card' => array(
            'label'       => '&#1050;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1072; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1077;',
            'description' => '&#1041;&#1077;&#1081;&#1076;&#1078;&#1080;, &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1103;, &#1089;&#1086;&#1074;&#1084;&#1077;&#1089;&#1090;&#1080;&#1084;&#1086;&#1089;&#1090;&#1100;, &#1088;&#1077;&#1081;&#1090;&#1080;&#1085;&#1075;, SKU &#1080; &#1086;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082;.',
            'anchor'      => 'dv-options-catalog-card',
            'keys'        => array(
                'catalog_card_badges_enabled',
                'catalog_card_actions_enabled',
                'catalog_card_compat_enabled',
                'catalog_card_rating_enabled',
                'catalog_card_sku_enabled',
                'catalog_card_stock_qty_enabled',
            ),
        ),
        'home-search'  => array(
            'label'       => '&#1043;&#1083;&#1072;&#1074;&#1085;&#1072;&#1103;, &#1087;&#1086;&#1080;&#1089;&#1082; &#1080; 404',
            'description' => '&#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1080; &#1075;&#1083;&#1072;&#1074;&#1085;&#1086;&#1081;, live-search, &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1072; &#1087;&#1086;&#1080;&#1089;&#1082;&#1072;, 404 &#1080; &#1083;&#1080;&#1084;&#1080;&#1090; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103;.',
            'anchor'      => 'dv-options-search',
            'keys'        => array(
                'home_product_columns',
                'search_live_limit',
                'search_page_per_page',
                'not_found_search_enabled',
                'not_found_actions_enabled',
                'not_found_categories_enabled',
                'not_found_categories_limit',
                'compare_limit',
            ),
        ),
        'footer'       => array(
            'label'       => '&#1060;&#1091;&#1090;&#1077;&#1088;',
            'description' => '&#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1080;, &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;, &#1089;&#1089;&#1099;&#1083;&#1082;&#1080;, &#1073;&#1077;&#1081;&#1076;&#1078;&#1080;, &#1085;&#1080;&#1078;&#1085;&#1103;&#1103; &#1089;&#1090;&#1088;&#1086;&#1082;&#1072; &#1080; &#1083;&#1080;&#1084;&#1080;&#1090; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081;.',
            'anchor'      => 'dv-options-footer',
            'keys'        => array(
                'footer_brand_enabled',
                'footer_description_enabled',
                'footer_contacts_enabled',
                'footer_catalog_enabled',
                'footer_customers_enabled',
                'footer_company_enabled',
                'footer_bottom_enabled',
                'footer_payment_icons_enabled',
                'footer_legal_links_enabled',
                'footer_customers_1_enabled',
                'footer_customers_2_enabled',
                'footer_customers_3_enabled',
                'footer_customers_4_enabled',
                'footer_customers_5_enabled',
                'footer_company_1_enabled',
                'footer_company_2_enabled',
                'footer_company_3_enabled',
                'footer_company_4_enabled',
                'footer_privacy_enabled',
                'footer_offer_enabled',
                'footer_categories_limit',
            ),
        ),
        'cart'         => array(
            'label'       => '&#1050;&#1086;&#1088;&#1079;&#1080;&#1085;&#1072;',
            'description' => '&#1060;&#1086;&#1090;&#1086;, &#1094;&#1077;&#1085;&#1072;, &#1089;&#1091;&#1084;&#1084;&#1072;, &#1087;&#1088;&#1086;&#1084;&#1086;&#1082;&#1086;&#1076; &#1080; cross-sells.',
            'anchor'      => 'dv-options-cart',
            'keys'        => array(
                'cart_coupon_enabled',
                'cart_cross_sells_enabled',
                'cart_product_image_enabled',
                'cart_price_enabled',
                'cart_subtotal_enabled',
            ),
        ),
        'checkout'     => array(
            'label'       => 'Checkout',
            'description' => '&#1050;&#1091;&#1087;&#1086;&#1085;, &#1092;&#1086;&#1088;&#1084;&#1072; &#1074;&#1093;&#1086;&#1076;&#1072; &#1080; &#1087;&#1088;&#1080;&#1084;&#1077;&#1095;&#1072;&#1085;&#1080;&#1077; &#1082; &#1079;&#1072;&#1082;&#1072;&#1079;&#1091;.',
            'anchor'      => 'dv-options-checkout',
            'keys'        => array(
                'checkout_coupon_enabled',
                'checkout_login_enabled',
                'checkout_order_notes_enabled',
            ),
        ),
        'product'      => array(
            'label'       => '&#1050;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1072; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;',
            'description' => '&#1055;&#1086;&#1076;&#1089;&#1082;&#1072;&#1079;&#1082;&#1080;, SKU, Ozon, &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;, tabs, related, similar, recent &#1080; &#1087;&#1086;&#1088;&#1103;&#1076;&#1086;&#1082; &#1073;&#1083;&#1086;&#1082;&#1086;&#1074;.',
            'anchor'      => 'dv-options-product',
            'keys'        => array(
                'product_gallery_hint_enabled',
                'product_meta_sku_enabled',
                'product_actions_enabled',
                'product_wishlist_enabled',
                'product_compare_enabled',
                'product_ozon_enabled',
                'product_summary_description_enabled',
                'product_tab_description_enabled',
                'product_tab_specs_enabled',
                'product_tab_reviews_enabled',
                'product_purchase_order',
                'product_ozon_order',
                'product_actions_order',
                'product_tabs_order',
                'product_related_order',
                'product_similar_order',
                'product_recent_order',
                'product_related_enabled',
                'product_related_limit',
                'product_similar_enabled',
                'product_similar_limit',
                'product_recent_enabled',
                'product_recent_limit',
            ),
        ),
        'service'      => array(
            'label'       => '&#1057;&#1077;&#1088;&#1074;&#1080;&#1089;&#1085;&#1099;&#1077; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1099;',
            'description' => '&#1054; &#1082;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1080;, &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072;, &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;, &#1074;&#1086;&#1079;&#1074;&#1088;&#1072;&#1090;, privacy &#1080; agreement.',
            'anchor'      => 'dv-options-service',
            'keys'        => array(
                'service_about_enabled',
                'service_delivery_enabled',
                'service_contacts_enabled',
                'service_return_enabled',
                'service_privacy_enabled',
                'service_agreement_enabled',
            ),
        ),
    );
}

function dv_theme_options_reset_group_redirect( $status, $anchor = 'dv-options-backup' ) {
    $url = add_query_arg(
        array(
            'page'        => 'dv-theme-options',
            'theme-reset' => sanitize_key( $status ),
        ),
        admin_url( 'admin.php' )
    );

    wp_safe_redirect( $url . '#' . sanitize_key( $anchor ) );
    exit;
}

function dv_handle_theme_options_reset_group() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to reset theme settings.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_options_reset_group' );

    $group_key = isset( $_POST['dv_theme_reset_group'] ) ? sanitize_key( wp_unslash( $_POST['dv_theme_reset_group'] ) ) : '';
    $groups    = dv_theme_options_reset_groups();

    if ( empty( $groups[ $group_key ] ) ) {
        dv_theme_options_reset_group_redirect( 'invalid' );
    }

    $defaults = dv_get_theme_options_defaults();
    $current  = get_option( 'dv_theme_options', array() );
    $current  = is_array( $current ) ? $current : array();

    foreach ( $groups[ $group_key ]['keys'] as $key ) {
        if ( array_key_exists( $key, $defaults ) ) {
            $current[ $key ] = $defaults[ $key ];
        }
    }

    update_option( 'dv_theme_options', dv_sanitize_theme_options( $current ), false );

    dv_theme_options_reset_group_redirect( $group_key, $groups[ $group_key ]['anchor'] ?? 'dv-options-backup' );
}
add_action( 'admin_post_dv_theme_options_reset_group', 'dv_handle_theme_options_reset_group' );

function dv_theme_backup_sanitize_value( $value ) {
    if ( is_array( $value ) ) {
        $clean = array();

        foreach ( $value as $key => $item ) {
            $clean[ sanitize_key( (string) $key ) ] = dv_theme_backup_sanitize_value( $item );
        }

        return $clean;
    }

    if ( is_scalar( $value ) || null === $value ) {
        return sanitize_textarea_field( (string) $value );
    }

    return '';
}

function dv_theme_backup_collect_options() {
    $options = array();

    foreach ( dv_theme_backup_option_names() as $option_name ) {
        $value = get_option( $option_name, null );

        if ( null !== $value ) {
            $options[ $option_name ] = $value;
        }
    }

    return $options;
}

function dv_theme_backup_build_payload( $options = null ) {
    return array(
        'schema'      => 'detalivam-theme-settings',
        'version'     => defined( 'DV_VERSION' ) ? DV_VERSION : '1.0.0',
        'exported_at' => gmdate( 'c' ),
        'site_url'    => home_url( '/' ),
        'options'     => is_array( $options ) ? $options : dv_theme_backup_collect_options(),
    );
}

function dv_theme_auto_backup_capture( $source ) {
    $payload           = dv_theme_backup_build_payload();
    $payload['source'] = sanitize_text_field( (string) $source );

    update_option( dv_theme_auto_backup_option_name(), $payload, false );
}

function dv_theme_auto_backup_capture_before_option_update( $new_value, $old_value, $option_name = '' ) {
    static $captured = false;

    if ( $captured || maybe_serialize( $new_value ) === maybe_serialize( $old_value ) ) {
        return $new_value;
    }

    $labels      = dv_theme_settings_history_option_labels();
    $option_name = (string) $option_name;
    $source      = $labels[ $option_name ] ?? $option_name;

    $captured = true;
    dv_theme_auto_backup_capture( dv_theme_options_label( $source ) );

    return $new_value;
}

foreach ( dv_theme_backup_option_names() as $dv_theme_auto_backup_option ) {
    add_filter( 'pre_update_option_' . $dv_theme_auto_backup_option, 'dv_theme_auto_backup_capture_before_option_update', 10, 3 );
}
unset( $dv_theme_auto_backup_option );

function dv_theme_backup_is_valid_payload( $payload ) {
    return is_array( $payload )
        && 'detalivam-theme-settings' === ( $payload['schema'] ?? '' )
        && ! empty( $payload['options'] )
        && is_array( $payload['options'] );
}

function dv_theme_backup_apply_options( $options ) {
    $options = is_array( $options ) ? $options : array();

    if ( array_key_exists( 'dv_theme_options', $options ) ) {
        update_option( 'dv_theme_options', dv_sanitize_theme_options( $options['dv_theme_options'] ), false );
    }

    if ( array_key_exists( 'dv_theme_content', $options ) && function_exists( 'dv_sanitize_theme_content' ) ) {
        update_option( 'dv_theme_content', dv_sanitize_theme_content( $options['dv_theme_content'] ), false );
    }

    if ( array_key_exists( 'dv_store_profile', $options ) && function_exists( 'dv_sanitize_store_profile' ) ) {
        update_option( 'dv_store_profile', dv_sanitize_store_profile( $options['dv_store_profile'] ), false );
    }

    if ( array_key_exists( 'dv_seo_settings', $options ) ) {
        update_option( 'dv_seo_settings', dv_theme_backup_sanitize_value( $options['dv_seo_settings'] ), false );
    }
}

function dv_theme_backup_redirect( $status ) {
    $url = add_query_arg(
        array(
            'page'         => 'dv-theme-options',
            'theme-backup' => sanitize_key( $status ),
        ),
        admin_url( 'admin.php' )
    );

    wp_safe_redirect( $url . '#dv-options-backup' );
    exit;
}

function dv_handle_theme_backup_export() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to export theme settings.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_backup_export' );

    $payload = dv_theme_backup_build_payload();

    $json = wp_json_encode( $payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

    if ( ! is_string( $json ) || '' === $json ) {
        dv_theme_backup_redirect( 'export-error' );
    }

    nocache_headers();
    header( 'Content-Type: application/json; charset=UTF-8' );
    header( 'Content-Disposition: attachment; filename="detalivam-theme-settings-' . gmdate( 'Y-m-d-H-i' ) . '.json"' );
    echo $json; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    exit;
}
add_action( 'admin_post_dv_theme_backup_export', 'dv_handle_theme_backup_export' );

function dv_handle_theme_backup_import() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to import theme settings.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_backup_import' );

    if ( empty( $_FILES['dv_theme_backup_file']['tmp_name'] ) ) {
        dv_theme_backup_redirect( 'import-empty' );
    }

    $file = $_FILES['dv_theme_backup_file'];

    if ( ! empty( $file['error'] ) || ! is_uploaded_file( $file['tmp_name'] ) ) {
        dv_theme_backup_redirect( 'import-upload-error' );
    }

    $raw = file_get_contents( $file['tmp_name'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

    if ( ! is_string( $raw ) || '' === trim( $raw ) ) {
        dv_theme_backup_redirect( 'import-empty' );
    }

    $payload = json_decode( $raw, true );

    if ( ! dv_theme_backup_is_valid_payload( $payload ) ) {
        dv_theme_backup_redirect( 'import-invalid' );
    }

    update_option( dv_theme_backup_last_import_option_name(), dv_theme_backup_build_payload(), false );
    dv_theme_backup_apply_options( $payload['options'] );

    if ( function_exists( 'dv_clear_sitemap_cache' ) ) {
        dv_clear_sitemap_cache();
    }

    dv_theme_backup_redirect( 'imported' );
}
add_action( 'admin_post_dv_theme_backup_import', 'dv_handle_theme_backup_import' );

function dv_handle_theme_backup_restore_last() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to restore theme settings.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_backup_restore_last' );

    $payload = get_option( dv_theme_backup_last_import_option_name(), array() );

    if ( ! dv_theme_backup_is_valid_payload( $payload ) ) {
        dv_theme_backup_redirect( 'restore-empty' );
    }

    dv_theme_backup_apply_options( $payload['options'] );

    if ( function_exists( 'dv_clear_sitemap_cache' ) ) {
        dv_clear_sitemap_cache();
    }

    dv_theme_backup_redirect( 'restored' );
}
add_action( 'admin_post_dv_theme_backup_restore_last', 'dv_handle_theme_backup_restore_last' );

function dv_handle_theme_auto_backup_restore() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to restore theme settings.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_auto_backup_restore' );

    $payload = get_option( dv_theme_auto_backup_option_name(), array() );

    if ( ! dv_theme_backup_is_valid_payload( $payload ) ) {
        dv_theme_backup_redirect( 'auto-restore-empty' );
    }

    dv_theme_backup_apply_options( $payload['options'] );

    if ( function_exists( 'dv_clear_sitemap_cache' ) ) {
        dv_clear_sitemap_cache();
    }

    dv_theme_backup_redirect( 'auto-restored' );
}
add_action( 'admin_post_dv_theme_auto_backup_restore', 'dv_handle_theme_auto_backup_restore' );

function dv_theme_backup_state() {
    $payload     = get_option( dv_theme_backup_last_import_option_name(), array() );
    $has_restore = dv_theme_backup_is_valid_payload( $payload );
    $created_at  = $has_restore ? (string) ( $payload['exported_at'] ?? '' ) : '';
    $timestamp   = $created_at ? strtotime( $created_at ) : false;
    $option_count = $has_restore && ! empty( $payload['options'] ) && is_array( $payload['options'] )
        ? count( $payload['options'] )
        : 0;

    return array(
        'has_restore'        => $has_restore,
        'created_at'         => $created_at,
        'created_at_display' => $timestamp ? date_i18n( 'd.m.Y H:i', $timestamp ) : '',
        'option_count'       => $option_count,
    );
}

function dv_theme_auto_backup_state() {
    $payload     = get_option( dv_theme_auto_backup_option_name(), array() );
    $has_restore = dv_theme_backup_is_valid_payload( $payload );
    $created_at  = $has_restore ? (string) ( $payload['exported_at'] ?? '' ) : '';
    $timestamp   = $created_at ? strtotime( $created_at ) : false;
    $option_count = $has_restore && ! empty( $payload['options'] ) && is_array( $payload['options'] )
        ? count( $payload['options'] )
        : 0;

    return array(
        'has_restore'        => $has_restore,
        'created_at'         => $created_at,
        'created_at_display' => $timestamp ? date_i18n( 'd.m.Y H:i', $timestamp ) : '',
        'option_count'       => $option_count,
        'source'             => $has_restore ? sanitize_text_field( (string) ( $payload['source'] ?? '' ) ) : '',
    );
}

function dv_theme_maintenance_report() {
    $history     = function_exists( 'dv_theme_settings_history_get' ) ? dv_theme_settings_history_get() : array();
    $auto_backup = function_exists( 'dv_theme_auto_backup_state' ) ? dv_theme_auto_backup_state() : array();
    $groups      = function_exists( 'dv_theme_options_reset_groups' ) ? dv_theme_options_reset_groups() : array();
    $main_css    = trailingslashit( get_stylesheet_directory() ) . 'assets/css/main.css';
    $css_content = is_readable( $main_css ) ? file_get_contents( $main_css ) : '';
    $has_mobile_safety = is_string( $css_content ) && false !== strpos( $css_content, 'MOBILE SAFETY PASS' );

    $checks = array(
        array(
            'key'    => 'settings_history',
            'label'  => dv_theme_options_label( '&#1048;&#1089;&#1090;&#1086;&#1088;&#1080;&#1103; &#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1077;&#1082;' ),
            'status' => is_array( $history ),
            'hint'   => sprintf(
                /* translators: %d: history items count. */
                dv_theme_options_label( '&#1047;&#1072;&#1087;&#1080;&#1089;&#1077;&#1081; &#1074; &#1078;&#1091;&#1088;&#1085;&#1072;&#1083;&#1077;: %d' ),
                count( is_array( $history ) ? $history : array() )
            ),
        ),
        array(
            'key'    => 'auto_backup',
            'label'  => dv_theme_options_label( '&#1040;&#1074;&#1090;&#1086;&#1073;&#1101;&#1082;&#1072;&#1087;' ),
            'status' => is_array( $auto_backup ),
            'hint'   => ! empty( $auto_backup['has_restore'] )
                ? sprintf(
                    /* translators: 1: date, 2: source. */
                    dv_theme_options_label( '&#1054;&#1090;&#1082;&#1072;&#1090; &#1077;&#1089;&#1090;&#1100;: %1$s, %2$s' ),
                    (string) ( $auto_backup['created_at_display'] ?? '' ),
                    (string) ( $auto_backup['source'] ?? '' )
                )
                : dv_theme_options_label( '&#1057;&#1085;&#1080;&#1084;&#1086;&#1082; &#1087;&#1086;&#1103;&#1074;&#1080;&#1090;&#1089;&#1103; &#1087;&#1077;&#1088;&#1077;&#1076; &#1089;&#1083;&#1077;&#1076;&#1091;&#1102;&#1097;&#1080;&#1084; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1077;&#1085;&#1080;&#1077;&#1084;.' ),
        ),
        array(
            'key'    => 'reset_groups',
            'label'  => dv_theme_options_label( '&#1058;&#1086;&#1095;&#1077;&#1095;&#1085;&#1099;&#1081; &#1089;&#1073;&#1088;&#1086;&#1089;' ),
            'status' => is_array( $groups ) && count( $groups ) >= 8 && function_exists( 'dv_handle_theme_options_reset_group' ),
            'hint'   => sprintf(
                /* translators: %d: reset groups count. */
                dv_theme_options_label( '&#1044;&#1086;&#1089;&#1090;&#1091;&#1087;&#1085;&#1086; &#1073;&#1083;&#1086;&#1082;&#1086;&#1074; &#1089;&#1073;&#1088;&#1086;&#1089;&#1072;: %d' ),
                count( is_array( $groups ) ? $groups : array() )
            ),
        ),
        array(
            'key'    => 'mobile_safety',
            'label'  => 'Mobile safety-pass',
            'status' => $has_mobile_safety,
            'hint'   => $has_mobile_safety
                ? dv_theme_options_label( '&#1052;&#1086;&#1073;&#1080;&#1083;&#1100;&#1085;&#1099;&#1081; CSS-&#1089;&#1083;&#1086;&#1081; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085; &#1074; main.css.' )
                : dv_theme_options_label( '&#1053;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085; &#1084;&#1072;&#1088;&#1082;&#1077;&#1088; MOBILE SAFETY PASS &#1074; main.css.' ),
        ),
    );

    $issues = array_values(
        array_filter(
            $checks,
            static function ( $check ) {
                return empty( $check['status'] );
            }
        )
    );

    return array(
        'status'      => empty( $issues ),
        'checks'      => $checks,
        'issue_count' => count( $issues ),
        'issues'      => $issues,
    );
}

function dv_theme_diagnostics_settings_snapshot( $options ) {
    $defaults = function_exists( 'dv_get_theme_options_defaults' ) ? dv_get_theme_options_defaults() : array();
    $options  = wp_parse_args( is_array( $options ) ? $options : array(), $defaults );
    $backup   = dv_theme_backup_state();

    return array(
        array(
            'key'   => 'catalog',
            'label' => 'Каталог',
            'value' => absint( $options['catalog_per_page'] ?? 12 ) . ' / ' . absint( $options['catalog_columns'] ?? 4 ),
            'hint'  => 'товаров на странице / колонок',
        ),
        array(
            'key'   => 'home',
            'label' => 'Главная',
            'value' => absint( $options['home_product_columns'] ?? 4 ),
            'hint'  => 'колонок товаров',
        ),
        array(
            'key'   => 'search',
            'label' => 'Поиск',
            'value' => absint( $options['search_live_limit'] ?? 8 ) . ' / ' . absint( $options['search_page_per_page'] ?? 24 ),
            'hint'  => 'dropdown / страница результатов',
        ),
        array(
            'key'   => 'product',
            'label' => 'Карточка товара',
            'value' => absint( $options['product_related_limit'] ?? 4 ) . ' / ' . absint( $options['product_similar_limit'] ?? 4 ) . ' / ' . absint( $options['product_recent_limit'] ?? 4 ),
            'hint'  => 'с этим покупают / похожие / недавно',
        ),
        array(
            'key'   => 'compare',
            'label' => 'Сравнение',
            'value' => absint( $options['compare_limit'] ?? 4 ),
            'hint'  => 'максимум товаров',
        ),
        array(
            'key'   => 'style',
            'label' => 'Визуальный стиль',
            'value' => sanitize_key( $options['theme_visual_preset'] ?? 'default' ) . ' / ' . sanitize_key( $options['theme_color_scheme'] ?? 'preset' ),
            'hint'  => 'активный пресет темы',
        ),
        array(
            'key'   => 'backup',
            'label' => 'Резерв',
            'value' => ! empty( $backup['has_restore'] ) ? 'откат доступен' : 'ожидает импорта',
            'hint'  => ! empty( $backup['created_at_display'] ) ? 'снимок от ' . $backup['created_at_display'] : 'снимок появится перед импортом JSON',
        ),
    );
}

function dv_theme_environment_report() {
    $theme       = wp_get_theme();
    $parent      = $theme->parent();
    $woo_version = class_exists( 'WooCommerce' ) && defined( 'WC_VERSION' ) ? WC_VERSION : '';

    return array(
        array(
            'key'   => 'wordpress',
            'label' => 'WordPress',
            'value' => get_bloginfo( 'version' ),
            'hint'  => is_multisite() ? 'Multisite' : 'Single site',
        ),
        array(
            'key'   => 'php',
            'label' => 'PHP',
            'value' => PHP_VERSION,
            'hint'  => 'memory_limit: ' . (string) ini_get( 'memory_limit' ),
        ),
        array(
            'key'   => 'woocommerce',
            'label' => 'WooCommerce',
            'value' => $woo_version ? $woo_version : dv_theme_options_label( '&#1085;&#1077; &#1072;&#1082;&#1090;&#1080;&#1074;&#1077;&#1085;' ),
            'hint'  => post_type_exists( 'product' ) ? 'product post type OK' : 'product post type missing',
        ),
        array(
            'key'   => 'theme',
            'label' => dv_theme_options_label( '&#1058;&#1077;&#1084;&#1072;' ),
            'value' => (string) $theme->get( 'Name' ) . ' ' . (string) $theme->get( 'Version' ),
            'hint'  => $parent ? ( dv_theme_options_label( '&#1056;&#1086;&#1076;&#1080;&#1090;&#1077;&#1083;&#1100;: ' ) . $parent->get( 'Name' ) ) : dv_theme_options_label( '&#1073;&#1077;&#1079; parent theme' ),
        ),
        array(
            'key'   => 'debug',
            'label' => 'WP_DEBUG',
            'value' => defined( 'WP_DEBUG' ) && WP_DEBUG ? 'on' : 'off',
            'hint'  => defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ? 'debug log on' : 'debug log off',
        ),
    );
}

function dv_theme_diagnostics_report_payload( $options ) {
    $theme     = wp_get_theme();
    $checks    = dv_theme_diagnostics_checks( $options );
    $overrides = dv_theme_woocommerce_overrides_report();
    $snapshot  = dv_theme_diagnostics_settings_snapshot( $options );
    $backup    = dv_theme_backup_state();
    $auto_backup = dv_theme_auto_backup_state();
    $audit     = dv_theme_product_audit_report();
    $marketplaces = dv_theme_marketplace_diagnostics_report( $options );
    $history   = dv_theme_settings_history_get();
    $profile_health = dv_theme_store_profile_health_report();
    $maintenance = dv_theme_maintenance_report();
    $environment = dv_theme_environment_report();

    $normalized_checks = array();
    foreach ( $checks as $check ) {
        $normalized_checks[] = array(
            'label'   => (string) ( $check['label'] ?? '' ),
            'status'  => ! empty( $check['status'] ) ? 'ok' : 'attention',
            'message' => ! empty( $check['status'] ) ? (string) ( $check['ok'] ?? '' ) : (string) ( $check['fail'] ?? '' ),
        );
    }

    return array(
        'schema'        => 'detalivam-theme-diagnostics',
        'version'       => defined( 'DV_VERSION' ) ? DV_VERSION : (string) $theme->get( 'Version' ),
        'exported_at'   => gmdate( 'c' ),
        'site_url'      => home_url( '/' ),
        'admin_url'     => admin_url( 'admin.php?page=dv-theme-options' ),
        'wordpress'     => get_bloginfo( 'version' ),
        'php'           => PHP_VERSION,
        'theme'         => array(
            'name'    => (string) $theme->get( 'Name' ),
            'version' => (string) $theme->get( 'Version' ),
        ),
        'settings'      => array(
            'visual_preset'    => sanitize_key( $options['theme_visual_preset'] ?? 'default' ),
            'color_scheme'     => sanitize_key( $options['theme_color_scheme'] ?? 'preset' ),
            'catalog_per_page' => absint( $options['catalog_per_page'] ?? 0 ),
            'catalog_columns'  => absint( $options['catalog_columns'] ?? 0 ),
            'compare_limit'    => absint( $options['compare_limit'] ?? 0 ),
        ),
        'applied_settings' => $snapshot,
        'environment'   => $environment,
        'backup'       => $backup,
        'auto_backup'  => $auto_backup,
        'settings_history' => array_slice( $history, 0, 5 ),
        'store_profile' => $profile_health,
        'product_audit' => $audit,
        'marketplaces' => $marketplaces,
        'maintenance' => $maintenance,
        'support_summary' => dv_theme_diagnostics_support_summary( $options ),
        'woocommerce_overrides' => $overrides,
        'checks'        => $normalized_checks,
    );
}

function dv_theme_diagnostics_support_summary( $options ) {
    $theme        = wp_get_theme();
    $checks       = dv_theme_diagnostics_checks( $options );
    $audit        = dv_theme_product_audit_report();
    $marketplaces = dv_theme_marketplace_diagnostics_report( $options );
    $profile      = dv_theme_store_profile_health_report();
    $maintenance  = dv_theme_maintenance_report();
    $backup       = dv_theme_backup_state();
    $auto_backup  = dv_theme_auto_backup_state();
    $options      = is_array( $options ) ? $options : array();
    $woo_version  = class_exists( 'WooCommerce' ) && defined( 'WC_VERSION' ) ? WC_VERSION : dv_theme_options_label( '&#1085;&#1077; &#1072;&#1082;&#1090;&#1080;&#1074;&#1077;&#1085;' );

    $failed_checks = array_values(
        array_filter(
            $checks,
            static function ( $check ) {
                return empty( $check['status'] );
            }
        )
    );

    $summary_lines = array(
        dv_theme_options_label( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;: &#1089;&#1074;&#1086;&#1076;&#1082;&#1072; &#1076;&#1080;&#1072;&#1075;&#1085;&#1086;&#1089;&#1090;&#1080;&#1082;&#1080;' ),
        dv_theme_options_label( '&#1044;&#1072;&#1090;&#1072;: ' ) . date_i18n( 'd.m.Y H:i' ),
        dv_theme_options_label( '&#1057;&#1072;&#1081;&#1090;: ' ) . home_url( '/' ),
        dv_theme_options_label( '&#1058;&#1077;&#1084;&#1072;: ' ) . (string) $theme->get( 'Name' ) . ' ' . (string) $theme->get( 'Version' ),
        'WordPress / PHP: ' . get_bloginfo( 'version' ) . ' / ' . PHP_VERSION,
        'WooCommerce: ' . $woo_version,
        'WP_DEBUG: ' . ( defined( 'WP_DEBUG' ) && WP_DEBUG ? 'on' : 'off' ),
        dv_theme_options_label( '&#1055;&#1088;&#1077;&#1089;&#1077;&#1090;: ' ) . sanitize_key( $options['theme_visual_preset'] ?? 'default' ) . ' / ' . sanitize_key( $options['theme_color_scheme'] ?? 'preset' ),
        dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099;: ' ) . absint( $audit['total'] ?? 0 ) . ', ' . dv_theme_options_label( '&#1079;&#1072;&#1084;&#1077;&#1095;&#1072;&#1085;&#1080;&#1081;: ' ) . absint( $audit['issue_count'] ?? 0 ),
        dv_theme_options_label( '&#1055;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100;: ' ) . absint( $profile['passed'] ?? 0 ) . '/' . absint( $profile['total'] ?? 0 ),
        'Ozon / marketplace: ' . ( ! empty( $marketplaces['status'] ) ? 'OK' : dv_theme_options_label( '&#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100; ' ) . count( $marketplaces['issues'] ?? array() ) ),
        dv_theme_options_label( '&#1054;&#1073;&#1089;&#1083;&#1091;&#1078;&#1080;&#1074;&#1072;&#1085;&#1080;&#1077;: ' ) . ( ! empty( $maintenance['status'] ) ? 'OK' : dv_theme_options_label( '&#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100; ' ) . absint( $maintenance['issue_count'] ?? 0 ) ),
        dv_theme_options_label( '&#1056;&#1077;&#1079;&#1077;&#1088;&#1074;: ' ) . ( ! empty( $backup['has_restore'] ) ? $backup['created_at_display'] : dv_theme_options_label( '&#1085;&#1077;&#1090; &#1089;&#1085;&#1080;&#1084;&#1082;&#1072; &#1086;&#1090;&#1082;&#1072;&#1090;&#1072;' ) ),
        dv_theme_options_label( '&#1040;&#1074;&#1090;&#1086;&#1073;&#1101;&#1082;&#1072;&#1087;: ' ) . ( ! empty( $auto_backup['has_restore'] ) ? $auto_backup['created_at_display'] : dv_theme_options_label( '&#1086;&#1078;&#1080;&#1076;&#1072;&#1077;&#1090; &#1089;&#1083;&#1077;&#1076;&#1091;&#1102;&#1097;&#1077;&#1075;&#1086; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1077;&#1085;&#1080;&#1103;' ) ),
        '',
        dv_theme_options_label( '&#1063;&#1090;&#1086; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100;:' ),
    );

    if ( empty( $failed_checks ) && empty( $audit['issue_count'] ) && empty( $profile['issue_count'] ) && ! empty( $marketplaces['status'] ) && ! empty( $maintenance['status'] ) ) {
        $summary_lines[] = dv_theme_options_label( '&#1050;&#1088;&#1080;&#1090;&#1080;&#1095;&#1085;&#1099;&#1093; &#1079;&#1072;&#1084;&#1077;&#1095;&#1072;&#1085;&#1080;&#1081; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;.' );
    } else {
        foreach ( array_slice( $failed_checks, 0, 8 ) as $check ) {
            $summary_lines[] = '- ' . wp_strip_all_tags( (string) ( $check['label'] ?? '' ) ) . ': ' . wp_strip_all_tags( (string) ( $check['fail'] ?? '' ) );
        }

        foreach ( array_slice( $audit['issues'] ?? array(), 0, 5 ) as $issue ) {
            if ( ! empty( $issue['count'] ) ) {
                $summary_lines[] = '- ' . wp_strip_all_tags( (string) ( $issue['label'] ?? '' ) ) . ': ' . absint( $issue['count'] );
            }
        }
    }

    return implode( "\n", $summary_lines );
}

function dv_handle_theme_diagnostics_export() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to export theme diagnostics.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_diagnostics_export' );

    $payload = dv_theme_diagnostics_report_payload( dv_get_theme_options() );
    $json    = wp_json_encode( $payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

    if ( ! is_string( $json ) || '' === $json ) {
        wp_die( esc_html__( 'Unable to build diagnostics report.', 'detalivam' ) );
    }

    nocache_headers();
    header( 'Content-Type: application/json; charset=utf-8' );
    header( 'Content-Disposition: attachment; filename=detalivam-diagnostics-' . gmdate( 'Y-m-d-His' ) . '.json' );
    echo $json; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    exit;
}
add_action( 'admin_post_dv_theme_diagnostics_export', 'dv_handle_theme_diagnostics_export' );

function dv_theme_product_audit_issue_query_args( $issue_key ) {
    switch ( sanitize_key( (string) $issue_key ) ) {
        case 'image':
            return array(
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key'     => '_thumbnail_id',
                        'compare' => 'NOT EXISTS',
                    ),
                    array(
                        'key'     => '_thumbnail_id',
                        'value'   => '',
                        'compare' => '=',
                    ),
                    array(
                        'key'     => '_thumbnail_id',
                        'value'   => '0',
                        'compare' => '=',
                    ),
                ),
            );

        case 'gallery':
            return array(
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key'     => '_product_image_gallery',
                        'compare' => 'NOT EXISTS',
                    ),
                    array(
                        'key'     => '_product_image_gallery',
                        'value'   => '',
                        'compare' => '=',
                    ),
                ),
            );

        case 'price':
            return array(
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key'     => '_price',
                        'compare' => 'NOT EXISTS',
                    ),
                    array(
                        'key'     => '_price',
                        'value'   => '',
                        'compare' => '=',
                    ),
                ),
            );

        case 'zero_price':
            return array(
                'meta_query' => array(
                    array(
                        'key'     => '_price',
                        'value'   => 0,
                        'compare' => '=',
                        'type'    => 'NUMERIC',
                    ),
                ),
            );

        case 'sale_price':
            $ids = dv_theme_product_audit_bad_sale_price_ids();

            return array(
                'post__in' => ! empty( $ids ) ? $ids : array( 0 ),
            );

        case 'sale_regular_price':
            $ids = dv_theme_product_audit_sale_without_regular_price_ids();

            return array(
                'post__in' => ! empty( $ids ) ? $ids : array( 0 ),
            );

        case 'sku':
            return array(
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key'     => '_sku',
                        'compare' => 'NOT EXISTS',
                    ),
                    array(
                        'key'     => '_sku',
                        'value'   => '',
                        'compare' => '=',
                    ),
                ),
            );

        case 'duplicate_sku':
            $ids = dv_theme_product_audit_duplicate_sku_ids();

            return array(
                'post__in' => ! empty( $ids ) ? $ids : array( 0 ),
            );

        case 'image_alt':
            $ids = dv_theme_product_audit_missing_image_alt_ids();

            return array(
                'post__in' => ! empty( $ids ) ? $ids : array( 0 ),
            );

        case 'excerpt':
            $ids = dv_theme_product_audit_empty_excerpt_ids();

            return array(
                'post__in' => ! empty( $ids ) ? $ids : array( 0 ),
            );

        case 'category':
            return array(
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'operator' => 'NOT EXISTS',
                    ),
                ),
            );

        case 'stock':
            return array(
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key'     => '_stock_status',
                        'compare' => 'NOT EXISTS',
                    ),
                    array(
                        'key'     => '_stock_status',
                        'value'   => '',
                        'compare' => '=',
                    ),
                ),
            );

        case 'negative_stock':
            $ids = dv_theme_product_audit_negative_stock_ids();

            return array(
                'post__in' => ! empty( $ids ) ? $ids : array( 0 ),
            );

        case 'stock_mismatch':
            $ids = dv_theme_product_audit_stock_mismatch_ids();

            return array(
                'post__in' => ! empty( $ids ) ? $ids : array( 0 ),
            );

        case 'weight':
            $ids = dv_theme_product_audit_missing_weight_ids();

            return array(
                'post__in' => ! empty( $ids ) ? $ids : array( 0 ),
            );

        case 'dimensions':
            $ids = dv_theme_product_audit_missing_dimensions_ids();

            return array(
                'post__in' => ! empty( $ids ) ? $ids : array( 0 ),
            );
    }

    return array();
}

function dv_theme_product_audit_issue_list_url( $issue_key ) {
    $issue_key = sanitize_key( (string) $issue_key );

    if ( '' === $issue_key ) {
        return '';
    }

    return add_query_arg(
        array(
            'post_type'              => 'product',
            'dv_product_audit_issue' => $issue_key,
        ),
        admin_url( 'edit.php' )
    );
}

function dv_theme_product_audit_export_query_ids( $args ) {
    if ( ! class_exists( 'WP_Query' ) ) {
        return array();
    }

    $query_args = wp_parse_args(
        $args,
        array(
            'post_type'              => 'product',
            'post_status'            => 'publish',
            'posts_per_page'         => -1,
            'fields'                 => 'ids',
            'ignore_sticky_posts'    => true,
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'suppress_filters'       => true,
        )
    );

    $query = new WP_Query( $query_args );

    return array_values( array_filter( array_map( 'absint', $query->posts ) ) );
}

function dv_theme_product_audit_export_empty_description_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $where = $wpdb->prepare(
        "post_type = %s AND post_status = %s AND TRIM(COALESCE(post_content, '')) = '' AND TRIM(COALESCE(post_excerpt, '')) = ''",
        'product',
        'publish'
    );

    $ids = $wpdb->get_col( "SELECT ID FROM {$wpdb->posts} WHERE {$where} ORDER BY ID DESC" ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_duplicate_sku_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $duplicate_skus_sql = $wpdb->prepare(
        "SELECT pm_inner.meta_value
        FROM {$wpdb->postmeta} pm_inner
        INNER JOIN {$wpdb->posts} p_inner ON p_inner.ID = pm_inner.post_id
        WHERE pm_inner.meta_key = %s
            AND pm_inner.meta_value <> ''
            AND p_inner.post_type = %s
            AND p_inner.post_status = %s
        GROUP BY pm_inner.meta_value
        HAVING COUNT(pm_inner.post_id) > 1",
        '_sku',
        'product',
        'publish'
    );

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT pm.post_id
            FROM {$wpdb->postmeta} pm
            INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            INNER JOIN ({$duplicate_skus_sql}) duplicate_skus ON duplicate_skus.meta_value = pm.meta_value
            WHERE pm.meta_key = %s
                AND p.post_type = %s
                AND p.post_status = %s
            ORDER BY pm.meta_value ASC, pm.post_id DESC",
            '_sku',
            'product',
            'publish'
        )
    ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_missing_image_alt_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT p.ID
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} thumb ON thumb.post_id = p.ID AND thumb.meta_key = %s
            LEFT JOIN {$wpdb->postmeta} alt ON alt.post_id = CAST(thumb.meta_value AS UNSIGNED) AND alt.meta_key = %s
            WHERE p.post_type = %s
                AND p.post_status = %s
                AND thumb.meta_value <> ''
                AND thumb.meta_value <> '0'
                AND TRIM(COALESCE(alt.meta_value, '')) = ''
            ORDER BY p.ID DESC",
            '_thumbnail_id',
            '_wp_attachment_image_alt',
            'product',
            'publish'
        )
    );

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_empty_excerpt_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT ID
            FROM {$wpdb->posts}
            WHERE post_type = %s
                AND post_status = %s
                AND TRIM(COALESCE(post_excerpt, '')) = ''
            ORDER BY ID DESC",
            'product',
            'publish'
        )
    );

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_bad_sale_price_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT p.ID
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} regular ON regular.post_id = p.ID AND regular.meta_key = %s
            INNER JOIN {$wpdb->postmeta} sale ON sale.post_id = p.ID AND sale.meta_key = %s
            WHERE p.post_type = %s
                AND p.post_status = %s
                AND regular.meta_value <> ''
                AND sale.meta_value <> ''
                AND CAST(sale.meta_value AS DECIMAL(20,6)) >= CAST(regular.meta_value AS DECIMAL(20,6))
            ORDER BY p.ID DESC",
            '_regular_price',
            '_sale_price',
            'product',
            'publish'
        )
    );

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_sale_without_regular_price_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT p.ID
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} sale ON sale.post_id = p.ID AND sale.meta_key = %s
            LEFT JOIN {$wpdb->postmeta} regular ON regular.post_id = p.ID AND regular.meta_key = %s
            WHERE p.post_type = %s
                AND p.post_status = %s
                AND sale.meta_value <> ''
                AND TRIM(COALESCE(regular.meta_value, '')) = ''
            ORDER BY p.ID DESC",
            '_sale_price',
            '_regular_price',
            'product',
            'publish'
        )
    );

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_negative_stock_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT p.ID
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} stock ON stock.post_id = p.ID AND stock.meta_key = %s
            WHERE p.post_type = %s
                AND p.post_status = %s
                AND stock.meta_value <> ''
                AND CAST(stock.meta_value AS SIGNED) < 0
            ORDER BY p.ID DESC",
            '_stock',
            'product',
            'publish'
        )
    );

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_stock_mismatch_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT p.ID
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} manage_stock ON manage_stock.post_id = p.ID AND manage_stock.meta_key = %s
            INNER JOIN {$wpdb->postmeta} stock ON stock.post_id = p.ID AND stock.meta_key = %s
            INNER JOIN {$wpdb->postmeta} stock_status ON stock_status.post_id = p.ID AND stock_status.meta_key = %s
            WHERE p.post_type = %s
                AND p.post_status = %s
                AND manage_stock.meta_value = %s
                AND stock.meta_value <> ''
                AND (
                    (CAST(stock.meta_value AS SIGNED) > 0 AND stock_status.meta_value <> %s)
                    OR (CAST(stock.meta_value AS SIGNED) <= 0 AND stock_status.meta_value = %s)
                )
            ORDER BY p.ID DESC",
            '_manage_stock',
            '_stock',
            '_stock_status',
            'product',
            'publish',
            'yes',
            'instock',
            'instock'
        )
    );

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_missing_weight_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT p.ID
            FROM {$wpdb->posts} p
            LEFT JOIN {$wpdb->postmeta} weight ON weight.post_id = p.ID AND weight.meta_key = %s
            WHERE p.post_type = %s
                AND p.post_status = %s
                AND (
                    TRIM(COALESCE(weight.meta_value, '')) = ''
                    OR CAST(weight.meta_value AS DECIMAL(20,6)) <= 0
                )
            ORDER BY p.ID DESC",
            '_weight',
            'product',
            'publish'
        )
    );

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_missing_dimensions_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT p.ID
            FROM {$wpdb->posts} p
            LEFT JOIN {$wpdb->postmeta} length_meta ON length_meta.post_id = p.ID AND length_meta.meta_key = %s
            LEFT JOIN {$wpdb->postmeta} width_meta ON width_meta.post_id = p.ID AND width_meta.meta_key = %s
            LEFT JOIN {$wpdb->postmeta} height_meta ON height_meta.post_id = p.ID AND height_meta.meta_key = %s
            WHERE p.post_type = %s
                AND p.post_status = %s
                AND (
                    TRIM(COALESCE(length_meta.meta_value, '')) = ''
                    OR TRIM(COALESCE(width_meta.meta_value, '')) = ''
                    OR TRIM(COALESCE(height_meta.meta_value, '')) = ''
                    OR CAST(length_meta.meta_value AS DECIMAL(20,6)) <= 0
                    OR CAST(width_meta.meta_value AS DECIMAL(20,6)) <= 0
                    OR CAST(height_meta.meta_value AS DECIMAL(20,6)) <= 0
                )
            ORDER BY p.ID DESC",
            '_length',
            '_width',
            '_height',
            'product',
            'publish'
        )
    );

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_theme_product_audit_export_issues() {
    return array(
        'image'       => array(
            'label' => dv_theme_options_label( '&#1060;&#1086;&#1090;&#1086;' ),
            'hint'  => dv_theme_options_label( '&#1053;&#1077;&#1090; &#1086;&#1089;&#1085;&#1086;&#1074;&#1085;&#1086;&#1075;&#1086; &#1092;&#1086;&#1090;&#1086; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' ),
            'ids'   => dv_theme_product_audit_export_query_ids( dv_theme_product_audit_issue_query_args( 'image' ) ),
        ),
        'gallery'     => array(
            'label' => dv_theme_options_label( '&#1043;&#1072;&#1083;&#1077;&#1088;&#1077;&#1103;' ),
            'hint'  => dv_theme_options_label( 'У товара нет дополнительных фото в галерее.' ),
            'ids'   => dv_theme_product_audit_export_query_ids( dv_theme_product_audit_issue_query_args( 'gallery' ) ),
        ),
        'price'       => array(
            'label' => dv_theme_options_label( '&#1062;&#1077;&#1085;&#1072;' ),
            'hint'  => dv_theme_options_label( '&#1055;&#1091;&#1089;&#1090;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072; &#1080;&#1083;&#1080; &#1085;&#1077; &#1079;&#1072;&#1076;&#1072;&#1085;&#1072; _price.' ),
            'ids'   => dv_theme_product_audit_export_query_ids( dv_theme_product_audit_issue_query_args( 'price' ) ),
        ),
        'zero_price'  => array(
            'label' => dv_theme_options_label( '&#1053;&#1091;&#1083;&#1077;&#1074;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072;' ),
            'hint'  => dv_theme_options_label( '&#1062;&#1077;&#1085;&#1072; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1088;&#1072;&#1074;&#1085;&#1072; 0; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1100;&#1090;&#1077; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090; &#1080;&#1083;&#1080; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1091;.' ),
            'ids'   => dv_theme_product_audit_export_query_ids( dv_theme_product_audit_issue_query_args( 'zero_price' ) ),
        ),
        'sale_price'  => array(
            'label' => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1086;&#1095;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072;' ),
            'hint'  => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1086;&#1095;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072; &#1074;&#1099;&#1096;&#1077; &#1080;&#1083;&#1080; &#1088;&#1072;&#1074;&#1085;&#1072; &#1086;&#1073;&#1099;&#1095;&#1085;&#1086;&#1081;.' ),
            'ids'   => dv_theme_product_audit_bad_sale_price_ids(),
        ),
        'sale_regular_price' => array(
            'label' => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1082;&#1072; &#1073;&#1077;&#1079; &#1094;&#1077;&#1085;&#1099;' ),
            'hint'  => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1086;&#1095;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072; &#1079;&#1072;&#1076;&#1072;&#1085;&#1072;, &#1072; &#1086;&#1073;&#1099;&#1095;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072; &#1087;&#1091;&#1089;&#1090;&#1072;.' ),
            'ids'   => dv_theme_product_audit_sale_without_regular_price_ids(),
        ),
        'sku'         => array(
            'label' => dv_theme_options_label( '&#1040;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083;' ),
            'hint'  => dv_theme_options_label( '&#1055;&#1091;&#1089;&#1090;&#1086;&#1081; SKU.' ),
            'ids'   => dv_theme_product_audit_export_query_ids( dv_theme_product_audit_issue_query_args( 'sku' ) ),
        ),
        'duplicate_sku' => array(
            'label' => dv_theme_options_label( '&#1044;&#1091;&#1073;&#1083;&#1080; SKU' ),
            'hint'  => dv_theme_options_label( '&#1054;&#1076;&#1080;&#1085; SKU &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1077;&#1090;&#1089;&#1103; &#1074; &#1085;&#1077;&#1089;&#1082;&#1086;&#1083;&#1100;&#1082;&#1080;&#1093; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;&#1093;.' ),
            'ids'   => dv_theme_product_audit_duplicate_sku_ids(),
        ),
        'image_alt'   => array(
            'label' => dv_theme_options_label( 'Alt &#1092;&#1086;&#1090;&#1086;' ),
            'hint'  => dv_theme_options_label( '&#1059; &#1086;&#1089;&#1085;&#1086;&#1074;&#1085;&#1086;&#1075;&#1086; &#1092;&#1086;&#1090;&#1086; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1085;&#1077;&#1090; alt-&#1090;&#1077;&#1082;&#1089;&#1090;&#1072;.' ),
            'ids'   => dv_theme_product_audit_missing_image_alt_ids(),
        ),
        'category'    => array(
            'label' => dv_theme_options_label( '&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1103;' ),
            'hint'  => dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088; &#1085;&#1077; &#1087;&#1088;&#1080;&#1074;&#1103;&#1079;&#1072;&#1085; &#1082; product_cat.' ),
            'ids'   => dv_theme_product_audit_export_query_ids( dv_theme_product_audit_issue_query_args( 'category' ) ),
        ),
        'description' => array(
            'label' => dv_theme_options_label( '&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;' ),
            'hint'  => dv_theme_options_label( '&#1055;&#1091;&#1089;&#1090;&#1099;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1080; &#1082;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;.' ),
            'ids'   => dv_theme_product_audit_export_empty_description_ids(),
        ),
        'excerpt'     => array(
            'label' => dv_theme_options_label( '&#1050;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;' ),
            'hint'  => dv_theme_options_label( '&#1055;&#1091;&#1089;&#1090;&#1086;&#1077; &#1082;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' ),
            'ids'   => dv_theme_product_audit_empty_excerpt_ids(),
        ),
        'stock'       => array(
            'label' => dv_theme_options_label( '&#1053;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;' ),
            'hint'  => dv_theme_options_label( '&#1053;&#1077;&#1090; &#1089;&#1090;&#1072;&#1090;&#1091;&#1089;&#1072; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1103; WooCommerce.' ),
            'ids'   => dv_theme_product_audit_export_query_ids( dv_theme_product_audit_issue_query_args( 'stock' ) ),
        ),
        'negative_stock' => array(
            'label' => dv_theme_options_label( '&#1054;&#1090;&#1088;&#1080;&#1094;&#1072;&#1090;&#1077;&#1083;&#1100;&#1085;&#1099;&#1081; &#1086;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082;' ),
            'hint'  => dv_theme_options_label( '&#1054;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1084;&#1077;&#1085;&#1100;&#1096;&#1077; 0; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1100;&#1090;&#1077; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090; &#1089;&#1082;&#1083;&#1072;&#1076;&#1072;.' ),
            'ids'   => dv_theme_product_audit_negative_stock_ids(),
        ),
        'stock_mismatch' => array(
            'label' => dv_theme_options_label( '&#1054;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082; / &#1089;&#1090;&#1072;&#1090;&#1091;&#1089;' ),
            'hint'  => dv_theme_options_label( '&#1054;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082; &#1080; &#1089;&#1090;&#1072;&#1090;&#1091;&#1089; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1103; &#1087;&#1088;&#1086;&#1090;&#1080;&#1074;&#1086;&#1088;&#1077;&#1095;&#1072;&#1090; &#1076;&#1088;&#1091;&#1075; &#1076;&#1088;&#1091;&#1075;&#1091;.' ),
            'ids'   => dv_theme_product_audit_stock_mismatch_ids(),
        ),
        'weight'      => array(
            'label' => dv_theme_options_label( '&#1042;&#1077;&#1089;' ),
            'hint'  => dv_theme_options_label( 'Нет веса товара; доставка и маркетплейсы могут считать стоимость неверно.' ),
            'ids'   => dv_theme_product_audit_missing_weight_ids(),
        ),
        'dimensions'  => array(
            'label' => dv_theme_options_label( '&#1043;&#1072;&#1073;&#1072;&#1088;&#1080;&#1090;&#1099;' ),
            'hint'  => dv_theme_options_label( 'Не заполнены длина, ширина или высота товара.' ),
            'ids'   => dv_theme_product_audit_missing_dimensions_ids(),
        ),
    );
}

function dv_theme_product_audit_csv_cell( $value ) {
    $value = wp_strip_all_tags( (string) $value );
    $value = html_entity_decode( $value, ENT_QUOTES, 'UTF-8' );
    $value = preg_replace( '/\s+/', ' ', $value );
    $value = trim( (string) $value );

    if ( '' !== $value && preg_match( '/^[=+\-@]/', $value ) ) {
        $value = "'" . $value;
    }

    return $value;
}

function dv_theme_product_audit_csv_row( $handle, $row ) {
    fputcsv( $handle, array_map( 'dv_theme_product_audit_csv_cell', $row ), ';' );
}

function dv_theme_product_audit_product_row( $issue_key, $issue_label, $issue_hint, $post_id ) {
    $post_id  = absint( $post_id );
    $product  = function_exists( 'wc_get_product' ) ? wc_get_product( $post_id ) : null;
    $terms    = get_the_terms( $post_id, 'product_cat' );
    $category = '';

    if ( is_array( $terms ) && ! is_wp_error( $terms ) ) {
        $category = implode( ', ', wp_list_pluck( $terms, 'name' ) );
    }

    return array(
        $issue_key,
        $issue_label,
        $issue_hint,
        $post_id,
        get_the_title( $post_id ),
        $product ? $product->get_sku() : get_post_meta( $post_id, '_sku', true ),
        $product ? $product->get_price() : get_post_meta( $post_id, '_price', true ),
        $product ? $product->get_stock_status() : get_post_meta( $post_id, '_stock_status', true ),
        $category,
        dv_theme_product_audit_sample_url( $post_id ),
        get_permalink( $post_id ),
    );
}

function dv_handle_theme_product_audit_export() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to export product audit.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_product_audit_export' );

    nocache_headers();
    header( 'Content-Type: text/csv; charset=UTF-8' );
    header( 'Content-Disposition: attachment; filename="detalivam-product-audit-' . gmdate( 'Y-m-d-H-i' ) . '.csv"' );

    $handle = fopen( 'php://output', 'w' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
    echo "\xEF\xBB\xBF"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    dv_theme_product_audit_csv_row(
        $handle,
        array(
            dv_theme_options_label( '&#1050;&#1083;&#1102;&#1095; &#1087;&#1088;&#1086;&#1073;&#1083;&#1077;&#1084;&#1099;' ),
            dv_theme_options_label( '&#1055;&#1088;&#1086;&#1073;&#1083;&#1077;&#1084;&#1072;' ),
            dv_theme_options_label( '&#1055;&#1086;&#1103;&#1089;&#1085;&#1077;&#1085;&#1080;&#1077;' ),
            'ID',
            dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;' ),
            'SKU',
            dv_theme_options_label( '&#1062;&#1077;&#1085;&#1072;' ),
            dv_theme_options_label( '&#1053;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;' ),
            dv_theme_options_label( '&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;' ),
            dv_theme_options_label( '&#1057;&#1089;&#1099;&#1083;&#1082;&#1072; &#1085;&#1072; &#1088;&#1077;&#1076;&#1072;&#1082;&#1090;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;&#1080;&#1077;' ),
            dv_theme_options_label( '&#1055;&#1091;&#1073;&#1083;&#1080;&#1095;&#1085;&#1072;&#1103; URL' ),
        )
    );

    foreach ( dv_theme_product_audit_export_issues() as $issue_key => $issue ) {
        $ids = isset( $issue['ids'] ) && is_array( $issue['ids'] ) ? $issue['ids'] : array();

        foreach ( $ids as $post_id ) {
            dv_theme_product_audit_csv_row(
                $handle,
                dv_theme_product_audit_product_row(
                    (string) $issue_key,
                    (string) ( $issue['label'] ?? '' ),
                    (string) ( $issue['hint'] ?? '' ),
                    $post_id
                )
            );
        }
    }

    fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose
    exit;
}
add_action( 'admin_post_dv_theme_product_audit_export', 'dv_handle_theme_product_audit_export' );

function dv_theme_product_audit_cache_key() {
    return 'dv_theme_product_audit_report_v1';
}

function dv_theme_product_audit_clear_cache() {
    delete_transient( dv_theme_product_audit_cache_key() );

    if ( function_exists( 'dv_dashboard_status_clear_cache' ) ) {
        dv_dashboard_status_clear_cache();
    }
}

function dv_theme_product_audit_clear_cache_for_post( $post_id ) {
    if ( 'product' === get_post_type( absint( $post_id ) ) ) {
        dv_theme_product_audit_clear_cache();
    }
}
add_action( 'save_post_product', 'dv_theme_product_audit_clear_cache_for_post', 10, 1 );
add_action( 'trashed_post', 'dv_theme_product_audit_clear_cache_for_post', 10, 1 );
add_action( 'untrashed_post', 'dv_theme_product_audit_clear_cache_for_post', 10, 1 );
add_action( 'deleted_post', 'dv_theme_product_audit_clear_cache_for_post', 10, 1 );

function dv_theme_product_audit_clear_cache_for_meta( $meta_id, $post_id, $meta_key = '' ) {
    $watched_keys = array( '_thumbnail_id', '_price', '_sku', '_stock_status' );

    if ( '_wp_attachment_image_alt' === (string) $meta_key ) {
        dv_theme_product_audit_clear_cache();
        return;
    }

    if ( in_array( (string) $meta_key, $watched_keys, true ) ) {
        dv_theme_product_audit_clear_cache_for_post( $post_id );
    }
}
add_action( 'added_post_meta', 'dv_theme_product_audit_clear_cache_for_meta', 10, 3 );
add_action( 'updated_post_meta', 'dv_theme_product_audit_clear_cache_for_meta', 10, 3 );
add_action( 'deleted_post_meta', 'dv_theme_product_audit_clear_cache_for_meta', 10, 3 );

function dv_theme_product_audit_clear_cache_for_terms( $object_id, $terms, $tt_ids, $taxonomy ) {
    if ( 'product_cat' === $taxonomy ) {
        dv_theme_product_audit_clear_cache_for_post( $object_id );
    }
}
add_action( 'set_object_terms', 'dv_theme_product_audit_clear_cache_for_terms', 10, 4 );

function dv_handle_theme_product_audit_refresh() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to refresh product audit.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_product_audit_refresh' );
    dv_theme_product_audit_clear_cache();

    wp_safe_redirect(
        add_query_arg(
            array(
                'page'          => 'dv-theme-options',
                'product-audit' => 'refreshed',
            ),
            admin_url( 'admin.php' )
        ) . '#dv-options-diagnostics'
    );
    exit;
}
add_action( 'admin_post_dv_theme_product_audit_refresh', 'dv_handle_theme_product_audit_refresh' );

function dv_handle_theme_product_audit_fill_image_alt() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to update product image alt text.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_product_audit_fill_image_alt' );

    $updated = 0;

    foreach ( dv_theme_product_audit_missing_image_alt_ids() as $post_id ) {
        $thumbnail_id = absint( get_post_thumbnail_id( $post_id ) );

        if ( ! $thumbnail_id ) {
            continue;
        }

        $current_alt = trim( (string) get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) );

        if ( '' !== $current_alt ) {
            continue;
        }

        $title = trim( wp_strip_all_tags( get_the_title( $post_id ) ) );

        if ( '' === $title ) {
            continue;
        }

        update_post_meta( $thumbnail_id, '_wp_attachment_image_alt', sanitize_text_field( $title ) );
        ++$updated;
    }

    dv_theme_product_audit_clear_cache();

    wp_safe_redirect(
        add_query_arg(
            array(
                'page'           => 'dv-theme-options',
                'product-audit'  => 'image-alt-filled',
                'alt-updated'    => $updated,
            ),
            admin_url( 'admin.php' )
        ) . '#dv-options-diagnostics'
    );
    exit;
}
add_action( 'admin_post_dv_theme_product_audit_fill_image_alt', 'dv_handle_theme_product_audit_fill_image_alt' );

function dv_theme_product_audit_excerpt_source_ids() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    $ids = $wpdb->get_col(
        $wpdb->prepare(
            "SELECT ID
            FROM {$wpdb->posts}
            WHERE post_type = %s
                AND post_status = %s
                AND TRIM(COALESCE(post_excerpt, '')) = ''
                AND TRIM(COALESCE(post_content, '')) <> ''
            ORDER BY ID DESC",
            'product',
            'publish'
        )
    );

    return array_values( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) );
}

function dv_handle_theme_product_audit_fill_excerpt() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to update product excerpts.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_product_audit_fill_excerpt' );

    $updated = 0;

    foreach ( dv_theme_product_audit_excerpt_source_ids() as $post_id ) {
        $content = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
        $content = trim( preg_replace( '/\s+/', ' ', (string) $content ) );

        if ( '' === $content ) {
            continue;
        }

        $excerpt = function_exists( 'wp_trim_words' ) ? wp_trim_words( $content, 28, '' ) : substr( $content, 0, 180 );

        wp_update_post(
            array(
                'ID'           => $post_id,
                'post_excerpt' => sanitize_textarea_field( $excerpt ),
            )
        );
        ++$updated;
    }

    dv_theme_product_audit_clear_cache();

    wp_safe_redirect(
        add_query_arg(
            array(
                'page'            => 'dv-theme-options',
                'product-audit'   => 'excerpt-filled',
                'excerpt-updated' => $updated,
            ),
            admin_url( 'admin.php' )
        ) . '#dv-options-diagnostics'
    );
    exit;
}
add_action( 'admin_post_dv_theme_product_audit_fill_excerpt', 'dv_handle_theme_product_audit_fill_excerpt' );

function dv_theme_clear_service_caches() {
    if ( function_exists( 'dv_dashboard_status_clear_cache' ) ) {
        dv_dashboard_status_clear_cache();
    }

    if ( function_exists( 'dv_theme_product_audit_clear_cache' ) ) {
        dv_theme_product_audit_clear_cache();
    }

    if ( function_exists( 'dv_clear_sitemap_cache' ) ) {
        dv_clear_sitemap_cache();
    }
}

function dv_handle_theme_service_cache_clear() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to clear service caches.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_theme_service_cache_clear' );
    dv_theme_clear_service_caches();

    wp_safe_redirect(
        add_query_arg(
            array(
                'page'          => 'dv-theme-options',
                'service-cache' => 'cleared',
            ),
            admin_url( 'admin.php' )
        ) . '#dv-options-diagnostics'
    );
    exit;
}
add_action( 'admin_post_dv_theme_service_cache_clear', 'dv_handle_theme_service_cache_clear' );

function dv_theme_product_audit_current_filter_issue() {
    if ( empty( $_GET['dv_product_audit_issue'] ) ) {
        return '';
    }

    return sanitize_key( wp_unslash( $_GET['dv_product_audit_issue'] ) );
}

function dv_theme_product_audit_issue_labels() {
    return array(
        'image'       => dv_theme_options_label( '&#1060;&#1086;&#1090;&#1086;' ),
        'gallery'     => dv_theme_options_label( '&#1043;&#1072;&#1083;&#1077;&#1088;&#1077;&#1103;' ),
        'price'       => dv_theme_options_label( '&#1062;&#1077;&#1085;&#1072;' ),
        'zero_price'  => dv_theme_options_label( '&#1053;&#1091;&#1083;&#1077;&#1074;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072;' ),
        'sale_price'  => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1086;&#1095;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072;' ),
        'sale_regular_price' => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1082;&#1072; &#1073;&#1077;&#1079; &#1094;&#1077;&#1085;&#1099;' ),
        'sku'         => dv_theme_options_label( '&#1040;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083;' ),
        'duplicate_sku' => dv_theme_options_label( '&#1044;&#1091;&#1073;&#1083;&#1080; SKU' ),
        'image_alt'   => dv_theme_options_label( 'Alt &#1092;&#1086;&#1090;&#1086;' ),
        'category'    => dv_theme_options_label( '&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1103;' ),
        'description' => dv_theme_options_label( '&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;' ),
        'excerpt'     => dv_theme_options_label( '&#1050;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;' ),
        'stock'       => dv_theme_options_label( '&#1053;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;' ),
        'negative_stock' => dv_theme_options_label( '&#1054;&#1090;&#1088;&#1080;&#1094;&#1072;&#1090;&#1077;&#1083;&#1100;&#1085;&#1099;&#1081; &#1086;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082;' ),
        'stock_mismatch' => dv_theme_options_label( '&#1054;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082; / &#1089;&#1090;&#1072;&#1090;&#1091;&#1089;' ),
        'weight'      => dv_theme_options_label( '&#1042;&#1077;&#1089;' ),
        'dimensions'  => dv_theme_options_label( '&#1043;&#1072;&#1073;&#1072;&#1088;&#1080;&#1090;&#1099;' ),
    );
}

function dv_theme_product_audit_filter_admin_products_query( $query ) {
    global $pagenow;

    if ( ! is_admin() || ! $query instanceof WP_Query || ! $query->is_main_query() || 'edit.php' !== $pagenow ) {
        return;
    }

    $post_type = $query->get( 'post_type' );

    if ( 'product' !== $post_type ) {
        return;
    }

    $issue_key = dv_theme_product_audit_current_filter_issue();

    if ( '' === $issue_key ) {
        return;
    }

    if ( 'description' === $issue_key ) {
        $query->set( 'dv_product_audit_issue', 'description' );
        return;
    }

    $issue_args = dv_theme_product_audit_issue_query_args( $issue_key );

    if ( ! empty( $issue_args['meta_query'] ) ) {
        $query->set( 'meta_query', $issue_args['meta_query'] );
    }

    if ( ! empty( $issue_args['tax_query'] ) ) {
        $query->set( 'tax_query', $issue_args['tax_query'] );
    }

    if ( ! empty( $issue_args['post__in'] ) ) {
        $query->set( 'post__in', array_map( 'absint', $issue_args['post__in'] ) );
    }
}
add_action( 'pre_get_posts', 'dv_theme_product_audit_filter_admin_products_query' );

function dv_theme_product_audit_filter_notice() {
    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

    if ( ! $screen || 'edit-product' !== $screen->id ) {
        return;
    }

    $issue_key = dv_theme_product_audit_current_filter_issue();
    $labels    = dv_theme_product_audit_issue_labels();

    if ( empty( $labels[ $issue_key ] ) ) {
        return;
    }

    $reset_url = admin_url( 'edit.php?post_type=product' );
    ?>
    <div class="notice notice-info">
        <p>
            <?php
            echo esc_html(
                sprintf(
                    /* translators: %s: product audit issue label. */
                    dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1072;&#1085;&#1099; &#1090;&#1086;&#1074;&#1072;&#1088;&#1099; &#1080;&#1079; &#1072;&#1091;&#1076;&#1080;&#1090;&#1072;: %s.' ),
                    $labels[ $issue_key ]
                )
            );
            ?>
            <a href="<?php echo esc_url( $reset_url ); ?>"><?php echo esc_html( dv_theme_options_label( '&#1057;&#1073;&#1088;&#1086;&#1089;&#1080;&#1090;&#1100; &#1092;&#1080;&#1083;&#1100;&#1090;&#1088;' ) ); ?></a>
        </p>
    </div>
    <?php
}
add_action( 'admin_notices', 'dv_theme_product_audit_filter_notice' );

function dv_theme_product_audit_filter_description_where( $where, $query ) {
    global $wpdb;

    if ( ! is_admin() || ! $query instanceof WP_Query || 'description' !== $query->get( 'dv_product_audit_issue' ) ) {
        return $where;
    }

    return $where . " AND TRIM(COALESCE({$wpdb->posts}.post_content, '')) = '' AND TRIM(COALESCE({$wpdb->posts}.post_excerpt, '')) = ''";
}
add_filter( 'posts_where', 'dv_theme_product_audit_filter_description_where', 10, 2 );

function dv_theme_product_audit_sample_url( $post_id ) {
    $post_id = absint( $post_id );

    if ( ! $post_id ) {
        return '';
    }

    $url = get_edit_post_link( $post_id, '' );

    return is_string( $url ) ? $url : '';
}

function dv_theme_product_audit_query_result( $args ) {
    if ( ! class_exists( 'WP_Query' ) ) {
        return array(
            'count'      => 0,
            'sample_id'  => 0,
            'sample_url' => '',
        );
    }

    $query_args = wp_parse_args(
        $args,
        array(
            'post_type'              => 'product',
            'post_status'            => 'publish',
            'posts_per_page'         => 1,
            'fields'                 => 'ids',
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'suppress_filters'       => true,
        )
    );

    $query     = new WP_Query( $query_args );
    $sample_id = ! empty( $query->posts[0] ) ? absint( $query->posts[0] ) : 0;

    return array(
        'count'      => absint( $query->found_posts ),
        'sample_id'  => $sample_id,
        'sample_url' => dv_theme_product_audit_sample_url( $sample_id ),
    );
}

function dv_theme_product_audit_empty_description_result() {
    global $wpdb;

    if ( ! $wpdb ) {
        return array(
            'count'      => 0,
            'sample_id'  => 0,
            'sample_url' => '',
        );
    }

    $where = $wpdb->prepare(
        "post_type = %s AND post_status = %s AND TRIM(COALESCE(post_content, '')) = '' AND TRIM(COALESCE(post_excerpt, '')) = ''",
        'product',
        'publish'
    );

    $count     = absint( $wpdb->get_var( "SELECT COUNT(ID) FROM {$wpdb->posts} WHERE {$where}" ) ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
    $sample_id = absint( $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE {$where} ORDER BY ID DESC LIMIT 1" ) ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared

    return array(
        'count'      => $count,
        'sample_id'  => $sample_id,
        'sample_url' => dv_theme_product_audit_sample_url( $sample_id ),
    );
}

function dv_theme_product_audit_report() {
    $cached = get_transient( dv_theme_product_audit_cache_key() );

    if ( is_array( $cached ) ) {
        return $cached;
    }

    $available = class_exists( 'WooCommerce' ) && post_type_exists( 'product' );
    $total     = 0;

    if ( post_type_exists( 'product' ) ) {
        $counts = wp_count_posts( 'product' );
        $total  = isset( $counts->publish ) ? absint( $counts->publish ) : 0;
    }

    $issues = array(
        array(
            'key'    => 'image',
            'label'  => dv_theme_options_label( '&#1060;&#1086;&#1090;&#1086;' ),
            'hint'   => dv_theme_options_label( '&#1053;&#1077;&#1090; &#1086;&#1089;&#1085;&#1086;&#1074;&#1085;&#1086;&#1075;&#1086; &#1092;&#1086;&#1090;&#1086; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'image' ) ),
        ),
        array(
            'key'    => 'gallery',
            'label'  => dv_theme_options_label( '&#1043;&#1072;&#1083;&#1077;&#1088;&#1077;&#1103;' ),
            'hint'   => dv_theme_options_label( 'У товара нет дополнительных фото в галерее.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'gallery' ) ),
        ),
        array(
            'key'    => 'price',
            'label'  => dv_theme_options_label( '&#1062;&#1077;&#1085;&#1072;' ),
            'hint'   => dv_theme_options_label( '&#1055;&#1091;&#1089;&#1090;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072; &#1080;&#1083;&#1080; &#1085;&#1077; &#1079;&#1072;&#1076;&#1072;&#1085;&#1072; _price.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'price' ) ),
        ),
        array(
            'key'    => 'zero_price',
            'label'  => dv_theme_options_label( '&#1053;&#1091;&#1083;&#1077;&#1074;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072;' ),
            'hint'   => dv_theme_options_label( '&#1062;&#1077;&#1085;&#1072; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1088;&#1072;&#1074;&#1085;&#1072; 0; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1100;&#1090;&#1077; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090; &#1080;&#1083;&#1080; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1091;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'zero_price' ) ),
        ),
        array(
            'key'    => 'sale_price',
            'label'  => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1086;&#1095;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072;' ),
            'hint'   => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1086;&#1095;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072; &#1074;&#1099;&#1096;&#1077; &#1080;&#1083;&#1080; &#1088;&#1072;&#1074;&#1085;&#1072; &#1086;&#1073;&#1099;&#1095;&#1085;&#1086;&#1081;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'sale_price' ) ),
        ),
        array(
            'key'    => 'sale_regular_price',
            'label'  => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1082;&#1072; &#1073;&#1077;&#1079; &#1094;&#1077;&#1085;&#1099;' ),
            'hint'   => dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1086;&#1095;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072; &#1079;&#1072;&#1076;&#1072;&#1085;&#1072;, &#1072; &#1086;&#1073;&#1099;&#1095;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072; &#1087;&#1091;&#1089;&#1090;&#1072;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'sale_regular_price' ) ),
        ),
        array(
            'key'    => 'sku',
            'label'  => dv_theme_options_label( '&#1040;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083;' ),
            'hint'   => dv_theme_options_label( '&#1055;&#1091;&#1089;&#1090;&#1086;&#1081; SKU, &#1089;&#1083;&#1086;&#1078;&#1085;&#1077;&#1077; &#1089;&#1074;&#1103;&#1079;&#1072;&#1090;&#1100; &#1090;&#1086;&#1074;&#1072;&#1088; &#1089; &#1087;&#1088;&#1072;&#1081;&#1089;&#1086;&#1084;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'sku' ) ),
        ),
        array(
            'key'    => 'duplicate_sku',
            'label'  => dv_theme_options_label( '&#1044;&#1091;&#1073;&#1083;&#1080; SKU' ),
            'hint'   => dv_theme_options_label( '&#1054;&#1076;&#1080;&#1085; SKU &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1077;&#1090;&#1089;&#1103; &#1074; &#1085;&#1077;&#1089;&#1082;&#1086;&#1083;&#1100;&#1082;&#1080;&#1093; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;&#1093;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'duplicate_sku' ) ),
        ),
        array(
            'key'    => 'image_alt',
            'label'  => dv_theme_options_label( 'Alt &#1092;&#1086;&#1090;&#1086;' ),
            'hint'   => dv_theme_options_label( '&#1059; &#1086;&#1089;&#1085;&#1086;&#1074;&#1085;&#1086;&#1075;&#1086; &#1092;&#1086;&#1090;&#1086; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1085;&#1077;&#1090; alt-&#1090;&#1077;&#1082;&#1089;&#1090;&#1072;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'image_alt' ) ),
        ),
        array(
            'key'    => 'category',
            'label'  => dv_theme_options_label( '&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1103;' ),
            'hint'   => dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088; &#1085;&#1077; &#1087;&#1088;&#1080;&#1074;&#1103;&#1079;&#1072;&#1085; &#1082; product_cat.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'category' ) ),
        ),
        array(
            'key'    => 'description',
            'label'  => dv_theme_options_label( '&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;' ),
            'hint'   => dv_theme_options_label( '&#1055;&#1091;&#1089;&#1090;&#1099;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1080; &#1082;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;.' ),
            'result' => dv_theme_product_audit_empty_description_result(),
        ),
        array(
            'key'    => 'excerpt',
            'label'  => dv_theme_options_label( '&#1050;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;' ),
            'hint'   => dv_theme_options_label( '&#1055;&#1091;&#1089;&#1090;&#1086;&#1077; &#1082;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'excerpt' ) ),
        ),
        array(
            'key'    => 'stock',
            'label'  => dv_theme_options_label( '&#1053;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;' ),
            'hint'   => dv_theme_options_label( '&#1053;&#1077;&#1090; &#1089;&#1090;&#1072;&#1090;&#1091;&#1089;&#1072; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1103; WooCommerce.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'stock' ) ),
        ),
        array(
            'key'    => 'negative_stock',
            'label'  => dv_theme_options_label( '&#1054;&#1090;&#1088;&#1080;&#1094;&#1072;&#1090;&#1077;&#1083;&#1100;&#1085;&#1099;&#1081; &#1086;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082;' ),
            'hint'   => dv_theme_options_label( '&#1054;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1084;&#1077;&#1085;&#1100;&#1096;&#1077; 0; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1100;&#1090;&#1077; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090; &#1089;&#1082;&#1083;&#1072;&#1076;&#1072;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'negative_stock' ) ),
        ),
        array(
            'key'    => 'stock_mismatch',
            'label'  => dv_theme_options_label( '&#1054;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082; / &#1089;&#1090;&#1072;&#1090;&#1091;&#1089;' ),
            'hint'   => dv_theme_options_label( '&#1054;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082; &#1080; &#1089;&#1090;&#1072;&#1090;&#1091;&#1089; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1103; &#1087;&#1088;&#1086;&#1090;&#1080;&#1074;&#1086;&#1088;&#1077;&#1095;&#1072;&#1090; &#1076;&#1088;&#1091;&#1075; &#1076;&#1088;&#1091;&#1075;&#1091;.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'stock_mismatch' ) ),
        ),
        array(
            'key'    => 'weight',
            'label'  => dv_theme_options_label( '&#1042;&#1077;&#1089;' ),
            'hint'   => dv_theme_options_label( 'Нет веса товара; доставка и маркетплейсы могут считать стоимость неверно.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'weight' ) ),
        ),
        array(
            'key'    => 'dimensions',
            'label'  => dv_theme_options_label( '&#1043;&#1072;&#1073;&#1072;&#1088;&#1080;&#1090;&#1099;' ),
            'hint'   => dv_theme_options_label( 'Не заполнены длина, ширина или высота товара.' ),
            'result' => dv_theme_product_audit_query_result( dv_theme_product_audit_issue_query_args( 'dimensions' ) ),
        ),
    );

    $normalized_issues = array();
    $issue_count       = 0;

    foreach ( $issues as $issue ) {
        $result = isset( $issue['result'] ) && is_array( $issue['result'] ) ? $issue['result'] : array();
        $count  = absint( $result['count'] ?? 0 );

        $issue_count += $count;

        $normalized_issues[] = array(
            'key'        => sanitize_key( $issue['key'] ),
            'label'      => (string) $issue['label'],
            'hint'       => (string) $issue['hint'],
            'count'      => $count,
            'sample_id'  => absint( $result['sample_id'] ?? 0 ),
            'sample_url' => esc_url_raw( $result['sample_url'] ?? '' ),
            'list_url'   => esc_url_raw( dv_theme_product_audit_issue_list_url( $issue['key'] ) ),
        );
    }

    $report = array(
        'available'   => $available,
        'total'       => $total,
        'issue_count' => $issue_count,
        'issues'      => $normalized_issues,
        'generated_at' => time(),
        'generated_at_display' => date_i18n( 'd.m.Y H:i' ),
    );

    set_transient( dv_theme_product_audit_cache_key(), $report, 10 * MINUTE_IN_SECONDS );

    return $report;
}

function dv_theme_store_profile_health_report() {
    $profile = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
    $profile = is_array( $profile ) ? $profile : array();
    $checks  = array();

    $add_check = static function ( $key, $label, $status, $hint ) use ( &$checks ) {
        $checks[] = array(
            'key'    => $key,
            'label'  => $label,
            'status' => (bool) $status,
            'hint'   => $hint,
        );
    };

    $phone_digits = preg_replace( '/\D+/', '', (string) ( $profile['phone'] ?? '' ) );
    $email        = (string) ( $profile['email'] ?? '' );
    $ozon_url     = (string) ( $profile['ozon_url'] ?? '' );
    $ozon_icon_url = (string) ( $profile['ozon_icon_url'] ?? '' );
    $ozon_host    = $ozon_url ? (string) wp_parse_url( $ozon_url, PHP_URL_HOST ) : '';
    $opens        = (string) ( $profile['opens'] ?? '' );
    $closes       = (string) ( $profile['closes'] ?? '' );
    $hours_valid  = '' !== trim( (string) ( $profile['workdays'] ?? '' ) )
        && preg_match( '/^\d{2}:\d{2}$/', $opens )
        && preg_match( '/^\d{2}:\d{2}$/', $closes )
        && strtotime( $opens ) < strtotime( $closes );

    $add_check( 'name', '&#1053;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077;', '' !== trim( (string) ( $profile['name'] ?? '' ) ), '&#1053;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072; &#1076;&#1083;&#1103; schema, footer &#1080; SEO.' );
    $add_check( 'phone', '&#1058;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;', strlen( $phone_digits ) >= 10, '&#1053;&#1091;&#1078;&#1077;&#1085; &#1082;&#1086;&#1088;&#1088;&#1077;&#1082;&#1090;&#1085;&#1099;&#1081; tel-&#1085;&#1086;&#1084;&#1077;&#1088; &#1089; 10+ &#1094;&#1080;&#1092;&#1088;&#1072;&#1084;&#1080;.' );
    $add_check( 'phone_display', '&#1058;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085; &#1076;&#1083;&#1103; &#1074;&#1099;&#1074;&#1086;&#1076;&#1072;', '' !== trim( (string) ( $profile['phone_display'] ?? '' ) ), '&#1063;&#1080;&#1090;&#1072;&#1077;&#1084;&#1099;&#1081; &#1092;&#1086;&#1088;&#1084;&#1072;&#1090; &#1076;&#1083;&#1103; &#1096;&#1072;&#1087;&#1082;&#1080; &#1080; &#1092;&#1091;&#1090;&#1077;&#1088;&#1072;.' );
    $add_check( 'email', 'Email', '' !== $email && is_email( $email ), '&#1050;&#1086;&#1088;&#1088;&#1077;&#1082;&#1090;&#1085;&#1099;&#1081; email &#1076;&#1083;&#1103; &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1086;&#1074; &#1080; schema.' );
    $add_check( 'location', '&#1043;&#1086;&#1088;&#1086;&#1076; &#1080; &#1088;&#1077;&#1075;&#1080;&#1086;&#1085;', '' !== trim( (string) ( $profile['city'] ?? '' ) ) && '' !== trim( (string) ( $profile['region'] ?? '' ) ), '&#1051;&#1086;&#1082;&#1072;&#1083;&#1100;&#1085;&#1099;&#1077; &#1089;&#1080;&#1075;&#1085;&#1072;&#1083;&#1099; &#1076;&#1083;&#1103; &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1086;&#1074;, schema &#1080; SEO.' );
    $add_check( 'country', '&#1057;&#1090;&#1088;&#1072;&#1085;&#1072;', '' !== trim( (string) ( $profile['country_name'] ?? '' ) ) && '' !== trim( (string) ( $profile['country_code'] ?? '' ) ), '&#1057;&#1090;&#1088;&#1072;&#1085;&#1072; &#1080; ISO-&#1082;&#1086;&#1076; &#1076;&#1083;&#1103; Organization schema.' );
    $add_check( 'hours', '&#1043;&#1088;&#1072;&#1092;&#1080;&#1082;', $hours_valid, '&#1044;&#1085;&#1080; &#1088;&#1072;&#1073;&#1086;&#1090;&#1099;, &#1074;&#1088;&#1077;&#1084;&#1103; HH:MM, &#1079;&#1072;&#1082;&#1088;&#1099;&#1090;&#1080;&#1077; &#1087;&#1086;&#1079;&#1078;&#1077; &#1086;&#1090;&#1082;&#1088;&#1099;&#1090;&#1080;&#1103;.' );
    $add_check( 'logo_url', 'Logo URL', '' === trim( (string) ( $profile['logo_url'] ?? '' ) ) || filter_var( $profile['logo_url'], FILTER_VALIDATE_URL ), '&#1045;&#1089;&#1083;&#1080; URL &#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;, &#1086;&#1085; &#1076;&#1086;&#1083;&#1078;&#1077;&#1085; &#1073;&#1099;&#1090;&#1100; &#1074;&#1072;&#1083;&#1080;&#1076;&#1085;&#1099;&#1084;.' );
    $add_check( 'ozon_url', 'Ozon URL', '' !== $ozon_url && filter_var( $ozon_url, FILTER_VALIDATE_URL ) && false !== strpos( strtolower( $ozon_host ), 'ozon.' ), '&#1057;&#1089;&#1099;&#1083;&#1082;&#1072; &#1085;&#1072; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085; Ozon &#1076;&#1083;&#1103; &#1096;&#1072;&#1087;&#1082;&#1080;, &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080; &#1080; schema.' );
    $add_check( 'ozon_icon_url', 'Ozon icon URL', '' === trim( $ozon_icon_url ) || filter_var( $ozon_icon_url, FILTER_VALIDATE_URL ), '&#1055;&#1091;&#1089;&#1090;&#1086;&#1077; &#1087;&#1086;&#1083;&#1077; &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1077;&#1090; assets/ozon.png; URL &#1084;&#1077;&#1085;&#1103;&#1077;&#1090; &#1083;&#1086;&#1075;&#1086; Ozon.' );

    foreach ( array( 2, 3 ) as $index ) {
        $name = trim( (string) ( $profile[ 'marketplace_' . $index . '_name' ] ?? '' ) );
        $url  = trim( (string) ( $profile[ 'marketplace_' . $index . '_url' ] ?? '' ) );
        $icon = trim( (string) ( $profile[ 'marketplace_' . $index . '_icon' ] ?? '' ) );

        $add_check(
            'marketplace_' . $index,
            sprintf(
                /* translators: %d: marketplace number. */
                '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089; %d',
                $index
            ),
            ( '' === $name && '' === $url ) || ( '' !== $name && filter_var( $url, FILTER_VALIDATE_URL ) ),
            '&#1045;&#1089;&#1083;&#1080; &#1087;&#1083;&#1086;&#1097;&#1072;&#1076;&#1082;&#1072; &#1079;&#1072;&#1076;&#1072;&#1085;&#1072;, &#1085;&#1091;&#1078;&#1085;&#1099; &#1085;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077; &#1080; &#1074;&#1072;&#1083;&#1080;&#1076;&#1085;&#1099;&#1081; URL.'
        );
        $add_check(
            'marketplace_' . $index . '_icon',
            sprintf(
                /* translators: %d: marketplace number. */
                '&#1048;&#1082;&#1086;&#1085;&#1082;&#1072; %d',
                $index
            ),
            '' === $icon || filter_var( $icon, FILTER_VALIDATE_URL ),
            '&#1045;&#1089;&#1083;&#1080; &#1080;&#1082;&#1086;&#1085;&#1082;&#1072; &#1079;&#1072;&#1076;&#1072;&#1085;&#1072;, URL &#1076;&#1086;&#1083;&#1078;&#1077;&#1085; &#1073;&#1099;&#1090;&#1100; &#1074;&#1072;&#1083;&#1080;&#1076;&#1085;&#1099;&#1084;.'
        );
    }

    $issues = array_values(
        array_filter(
            $checks,
            static function ( $check ) {
                return empty( $check['status'] );
            }
        )
    );

    return array(
        'total'        => count( $checks ),
        'passed'       => count( $checks ) - count( $issues ),
        'issue_count'  => count( $issues ),
        'checks'       => $checks,
        'issues'       => $issues,
        'settings_url' => admin_url( 'admin.php?page=dv-store-settings' ),
    );
}

function dv_theme_template_contains_rel_tokens( $file, $class_name, $tokens ) {
    if ( ! is_readable( $file ) ) {
        return false;
    }

    $content = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
    if ( ! is_string( $content ) || false === strpos( $content, $class_name ) ) {
        return false;
    }

    $class_position = strpos( $content, $class_name );
    if ( false === $class_position ) {
        return false;
    }

    $search_window = substr( $content, $class_position, 900 );
    if ( ! is_string( $search_window ) || ! preg_match( '/\brel\s*=\s*["\']([^"\']+)["\']/', $search_window, $matches ) ) {
        return false;
    }

    $rel = strtolower( (string) $matches[1] );
    foreach ( $tokens as $token ) {
        if ( false === strpos( $rel, strtolower( $token ) ) ) {
            return false;
        }
    }

    return true;
}

function dv_theme_marketplace_diagnostics_report( $options ) {
    $profile = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
    $options = is_array( $options ) ? $options : array();

    $ozon_url             = trim( (string) ( $profile['ozon_url'] ?? '' ) );
    $ozon_icon_url        = trim( (string) ( $profile['ozon_icon_url'] ?? '' ) );
    $header_ozon_enabled = ! empty( $options['header_ozon_enabled'] );
    $product_ozon_enabled = ! empty( $options['product_ozon_enabled'] );
    $ozon_icon_file      = trailingslashit( get_template_directory() ) . 'assets/ozon.png';
    $single_product_file = trailingslashit( get_stylesheet_directory() ) . 'woocommerce/single-product.php';
    $header_file         = trailingslashit( get_stylesheet_directory() ) . 'header.php';
    $template_file       = trailingslashit( get_stylesheet_directory() ) . 'inc/template-functions.php';
    $ozon_host           = $ozon_url ? wp_parse_url( $ozon_url, PHP_URL_HOST ) : '';
    $ozon_icon_ready     = '' !== $ozon_icon_url ? false !== filter_var( $ozon_icon_url, FILTER_VALIDATE_URL ) : file_exists( $ozon_icon_file );

    $checks = array(
        array(
            'key'    => 'ozon_url',
            'label'  => 'Ozon URL',
            'status' => '' !== $ozon_url && false !== filter_var( $ozon_url, FILTER_VALIDATE_URL ),
            'hint'   => '' !== $ozon_url ? $ozon_url : 'URL не заполнен',
        ),
        array(
            'key'    => 'ozon_host',
            'label'  => 'Домен Ozon',
            'status' => '' !== $ozon_host && false !== stripos( $ozon_host, 'ozon.' ),
            'hint'   => '' !== $ozon_host ? $ozon_host : 'домен не определён',
        ),
        array(
            'key'    => 'ozon_icon',
            'label'  => 'Логотип Ozon',
            'status' => $ozon_icon_ready,
            'hint'   => '' !== $ozon_icon_url ? $ozon_icon_url : 'assets/ozon.png',
        ),
        array(
            'key'    => 'header_button',
            'label'  => 'Ozon в шапке',
            'status' => $header_ozon_enabled && '' !== $ozon_url,
            'hint'   => $header_ozon_enabled ? 'кнопка включена' : 'кнопка выключена',
        ),
        array(
            'key'    => 'product_button',
            'label'  => 'Ozon в товаре',
            'status' => $product_ozon_enabled && '' !== $ozon_url,
            'hint'   => $product_ozon_enabled ? 'кнопка включена' : 'кнопка выключена',
        ),
        array(
            'key'    => 'header_rel',
            'label'  => 'rel в шапке',
            'status' => dv_theme_template_contains_rel_tokens( $header_file, 'header-ozon-btn', array( 'nofollow', 'sponsored', 'noopener', 'noreferrer' ) ),
            'hint'   => 'nofollow sponsored noopener noreferrer',
        ),
        array(
            'key'    => 'product_rel',
            'label'  => 'rel в товаре',
            'status' => dv_theme_template_contains_rel_tokens( $single_product_file, 'product-marketplace-link--ozon', array( 'nofollow', 'sponsored', 'noopener', 'noreferrer' ) ),
            'hint'   => 'nofollow sponsored noopener noreferrer',
        ),
        array(
            'key'    => 'service_rel',
            'label'  => 'rel сервисных ссылок',
            'status' => dv_theme_template_contains_rel_tokens( $template_file, 'service-marketplace-note', array( 'nofollow', 'sponsored', 'noopener', 'noreferrer' ) ),
            'hint'   => 'nofollow sponsored noopener noreferrer',
        ),
    );

    foreach ( array( 2, 3 ) as $index ) {
        $name = trim( (string) ( $profile[ 'marketplace_' . $index . '_name' ] ?? '' ) );
        $url  = trim( (string) ( $profile[ 'marketplace_' . $index . '_url' ] ?? '' ) );
        $icon = trim( (string) ( $profile[ 'marketplace_' . $index . '_icon' ] ?? '' ) );

        if ( '' === $name && '' === $url && '' === $icon ) {
            continue;
        }

        $checks[] = array(
            'key'    => 'marketplace_' . $index,
            'label'  => 'Маркетплейс ' . $index,
            'status' => '' !== $name && false !== filter_var( $url, FILTER_VALIDATE_URL ),
            'hint'   => '' !== $name ? $name : 'не заполнено название',
        );
    }

    $issues = array_values(
        array_filter(
            $checks,
            static function ( $check ) {
                return empty( $check['status'] );
            }
        )
    );

    return array(
        'status' => empty( $issues ),
        'checks' => $checks,
        'issues' => $issues,
    );
}

function dv_theme_extract_template_version( $file ) {
    if ( ! is_readable( $file ) ) {
        return '';
    }

    $handle = fopen( $file, 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen
    if ( ! $handle ) {
        return '';
    }

    $version = '';
    $lines   = 0;

    while ( ! feof( $handle ) && $lines < 60 ) {
        $line = fgets( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fgets
        ++$lines;

        if ( is_string( $line ) && preg_match( '/@version\s+([0-9][0-9A-Za-z\.\-\+]*)/', $line, $matches ) ) {
            $version = $matches[1];
            break;
        }
    }

    fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose

    return $version;
}

function dv_theme_woocommerce_overrides_report() {
    $theme_templates_dir = trailingslashit( get_stylesheet_directory() ) . 'woocommerce';

    if ( ! is_dir( $theme_templates_dir ) ) {
        return array(
            'total'    => 0,
            'missing'  => array(),
            'outdated' => array(),
            'unknown'  => array(),
        );
    }

    $plugin_templates_dir = '';
    if ( function_exists( 'WC' ) && WC() && method_exists( WC(), 'plugin_path' ) ) {
        $plugin_templates_dir = trailingslashit( WC()->plugin_path() ) . 'templates';
    }

    $report = array(
        'total'    => 0,
        'missing'  => array(),
        'outdated' => array(),
        'unknown'  => array(),
    );

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator( $theme_templates_dir, FilesystemIterator::SKIP_DOTS )
    );

    foreach ( $iterator as $file_info ) {
        if ( ! $file_info->isFile() || 'php' !== strtolower( $file_info->getExtension() ) ) {
            continue;
        }

        ++$report['total'];

        $theme_file    = $file_info->getPathname();
        $relative_path = str_replace( '\\', '/', substr( $theme_file, strlen( trailingslashit( $theme_templates_dir ) ) ) );
        $theme_version = dv_theme_extract_template_version( $theme_file );

        if ( '' === $theme_version ) {
            $report['missing'][] = $relative_path;
            continue;
        }

        if ( '' === $plugin_templates_dir ) {
            continue;
        }

        $plugin_file = trailingslashit( $plugin_templates_dir ) . $relative_path;
        if ( ! file_exists( $plugin_file ) ) {
            $report['unknown'][] = $relative_path;
            continue;
        }

        $plugin_version = dv_theme_extract_template_version( $plugin_file );
        if ( '' !== $plugin_version && version_compare( $theme_version, $plugin_version, '<' ) ) {
            $report['outdated'][] = $relative_path . ' (' . $theme_version . ' < ' . $plugin_version . ')';
        }
    }

    return $report;
}

function dv_render_theme_options_number_field( $options, $key, $label, $description, $min, $max ) {
    ?>
    <label class="dv-admin-field" data-dv-option-key="<?php echo esc_attr( $key ); ?>" data-dv-option-type="number">
        <span><?php echo esc_html( $label ); ?></span>
        <input
            type="number"
            name="dv_theme_options[<?php echo esc_attr( $key ); ?>]"
            value="<?php echo esc_attr( $options[ $key ] ?? '' ); ?>"
            min="<?php echo esc_attr( $min ); ?>"
            max="<?php echo esc_attr( $max ); ?>"
            step="1"
        >
        <small><?php echo esc_html( $description ); ?></small>
    </label>
    <?php
}

function dv_render_theme_options_select_field( $options, $key, $label, $description, $choices ) {
    ?>
    <label class="dv-admin-field" data-dv-option-key="<?php echo esc_attr( $key ); ?>" data-dv-option-type="select">
        <span><?php echo esc_html( $label ); ?></span>
        <select name="dv_theme_options[<?php echo esc_attr( $key ); ?>]">
            <?php foreach ( $choices as $value => $choice_label ) : ?>
                <option value="<?php echo esc_attr( $value ); ?>" <?php selected( (string) ( $options[ $key ] ?? '' ), (string) $value ); ?>>
                    <?php echo esc_html( $choice_label ); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small><?php echo esc_html( $description ); ?></small>
    </label>
    <?php
}

function dv_render_theme_options_toggle_field( $options, $key, $label, $description ) {
    ?>
    <label class="dv-admin-check" data-dv-option-key="<?php echo esc_attr( $key ); ?>" data-dv-option-type="toggle">
        <input
            type="checkbox"
            name="dv_theme_options[<?php echo esc_attr( $key ); ?>]"
            value="1"
            <?php checked( '1', (string) ( $options[ $key ] ?? '1' ) ); ?>
        >
        <span>
            <strong><?php echo esc_html( $label ); ?></strong>
            <small><?php echo esc_html( $description ); ?></small>
        </span>
    </label>
    <?php
}

function dv_theme_options_visual_value( $options, $key, $allowed, $fallback ) {
    $value = sanitize_key( $options[ $key ] ?? $fallback );

    return in_array( $value, $allowed, true ) ? $value : $fallback;
}

function dv_theme_options_visual_recipes() {
    return array(
        'balanced' => array(
            'label'       => 'Сбалансировано',
            'description' => 'Ровная сетка, широкий контейнер, мягкие тени и три строки названия.',
            'settings'    => array(
                'theme_visual_preset'      => 'default',
                'theme_color_scheme'       => 'preset',
                'theme_layout_width'       => 'wide',
                'theme_radius_style'       => 'soft',
                'theme_density_style'      => 'balanced',
                'theme_shadow_style'       => 'soft',
                'theme_header_style'       => 'balanced',
                'theme_footer_style'       => 'standard',
                'theme_card_style'         => 'standard',
                'theme_card_image_ratio'   => 'square',
                'theme_card_image_padding' => 'balanced',
                'theme_card_hover_style'   => 'soft',
                'theme_card_title_lines'   => 'three',
            ),
        ),
        'compact'  => array(
            'label'       => 'Компактный каталог',
            'description' => 'Меньше вертикальных отступов, плотные фото и короткие карточки для больших списков.',
            'settings'    => array(
                'theme_visual_preset'      => 'default',
                'theme_color_scheme'       => 'preset',
                'theme_layout_width'       => 'wide',
                'theme_radius_style'       => 'soft',
                'theme_density_style'      => 'compact',
                'theme_shadow_style'       => 'none',
                'theme_header_style'       => 'compact',
                'theme_footer_style'       => 'compact',
                'theme_card_style'         => 'compact',
                'theme_card_image_ratio'   => 'wide',
                'theme_card_image_padding' => 'tight',
                'theme_card_hover_style'   => 'none',
                'theme_card_title_lines'   => 'two',
            ),
        ),
        'showcase' => array(
            'label'       => 'Витрина с фото',
            'description' => 'Больше воздуха, крупнее зона изображения, заметный hover и просторный футер.',
            'settings'    => array(
                'theme_visual_preset'      => 'soft',
                'theme_color_scheme'       => 'preset',
                'theme_layout_width'       => 'fluid',
                'theme_radius_style'       => 'round',
                'theme_density_style'      => 'air',
                'theme_shadow_style'       => 'deep',
                'theme_header_style'       => 'wide-search',
                'theme_footer_style'       => 'spacious',
                'theme_card_style'         => 'showcase',
                'theme_card_image_ratio'   => 'portrait',
                'theme_card_image_padding' => 'safe',
                'theme_card_hover_style'   => 'lift',
                'theme_card_title_lines'   => 'four',
            ),
        ),
        'strict'   => array(
            'label'       => 'Строгая сетка',
            'description' => 'Сдержанный графит, узкий контейнер, прямые углы и минимум теней.',
            'settings'    => array(
                'theme_visual_preset'      => 'graphite',
                'theme_color_scheme'       => 'preset',
                'theme_layout_width'       => 'contained',
                'theme_radius_style'       => 'sharp',
                'theme_density_style'      => 'compact',
                'theme_shadow_style'       => 'none',
                'theme_header_style'       => 'compact',
                'theme_footer_style'       => 'compact',
                'theme_card_style'         => 'compact',
                'theme_card_image_ratio'   => 'square',
                'theme_card_image_padding' => 'balanced',
                'theme_card_hover_style'   => 'soft',
                'theme_card_title_lines'   => 'two',
            ),
        ),
        'ozon'     => array(
            'label'       => 'Ozon-карточки',
            'description' => 'Яркий синий акцент, крупная зона фото, мягкие панели и заметная кнопка покупки.',
            'settings'    => array(
                'theme_visual_preset'      => 'ozon',
                'theme_color_scheme'       => 'preset',
                'theme_layout_width'       => 'fluid',
                'theme_radius_style'       => 'round',
                'theme_density_style'      => 'air',
                'theme_shadow_style'       => 'deep',
                'theme_header_style'       => 'wide-search',
                'theme_footer_style'       => 'standard',
                'theme_card_style'         => 'showcase',
                'theme_card_image_ratio'   => 'portrait',
                'theme_card_image_padding' => 'safe',
                'theme_card_hover_style'   => 'lift',
                'theme_card_title_lines'   => 'four',
            ),
        ),
        'market'   => array(
            'label'       => 'Яндекс Маркет',
            'description' => 'Жёлтый акцент, плотный каталог, ровные фото и собранные карточки.',
            'settings'    => array(
                'theme_visual_preset'      => 'market',
                'theme_color_scheme'       => 'preset',
                'theme_layout_width'       => 'wide',
                'theme_radius_style'       => 'soft',
                'theme_density_style'      => 'compact',
                'theme_shadow_style'       => 'soft',
                'theme_header_style'       => 'compact',
                'theme_footer_style'       => 'compact',
                'theme_card_style'         => 'compact',
                'theme_card_image_ratio'   => 'wide',
                'theme_card_image_padding' => 'balanced',
                'theme_card_hover_style'   => 'soft',
                'theme_card_title_lines'   => 'two',
            ),
        ),
        'wildberries' => array(
            'label'       => 'Wildberries',
            'description' => 'Фиолетовый акцент, округлые кнопки, лёгкий фон и витринные карточки.',
            'settings'    => array(
                'theme_visual_preset'      => 'wildberries',
                'theme_color_scheme'       => 'preset',
                'theme_layout_width'       => 'wide',
                'theme_radius_style'       => 'round',
                'theme_density_style'      => 'air',
                'theme_shadow_style'       => 'soft',
                'theme_header_style'       => 'wide-search',
                'theme_footer_style'       => 'spacious',
                'theme_card_style'         => 'showcase',
                'theme_card_image_ratio'   => 'portrait',
                'theme_card_image_padding' => 'safe',
                'theme_card_hover_style'   => 'lift',
                'theme_card_title_lines'   => 'three',
            ),
        ),
    );
}

function dv_render_theme_options_visual_preview( $options ) {
    $preset        = dv_theme_options_visual_value( $options, 'theme_visual_preset', array( 'default', 'contrast', 'soft', 'graphite', 'ozon', 'market', 'wildberries' ), 'default' );
    $color_scheme  = dv_theme_options_visual_value( $options, 'theme_color_scheme', array( 'preset', 'default', 'contrast', 'soft', 'graphite', 'ozon', 'market', 'wildberries' ), 'preset' );
    $layout_width  = dv_theme_options_visual_value( $options, 'theme_layout_width', array( 'contained', 'wide', 'fluid' ), 'wide' );
    $radius        = dv_theme_options_visual_value( $options, 'theme_radius_style', array( 'sharp', 'soft', 'round' ), 'soft' );
    $density       = dv_theme_options_visual_value( $options, 'theme_density_style', array( 'compact', 'balanced', 'air' ), 'balanced' );
    $shadow        = dv_theme_options_visual_value( $options, 'theme_shadow_style', array( 'none', 'soft', 'deep' ), 'soft' );
    $header        = dv_theme_options_visual_value( $options, 'theme_header_style', array( 'compact', 'balanced', 'wide-search' ), 'balanced' );
    $footer        = dv_theme_options_visual_value( $options, 'theme_footer_style', array( 'compact', 'standard', 'spacious' ), 'standard' );
    $card          = dv_theme_options_visual_value( $options, 'theme_card_style', array( 'standard', 'compact', 'showcase' ), 'standard' );
    $image_ratio   = dv_theme_options_visual_value( $options, 'theme_card_image_ratio', array( 'square', 'portrait', 'wide' ), 'square' );
    $image_padding = dv_theme_options_visual_value( $options, 'theme_card_image_padding', array( 'tight', 'balanced', 'safe' ), 'balanced' );
    $hover         = dv_theme_options_visual_value( $options, 'theme_card_hover_style', array( 'none', 'soft', 'lift' ), 'soft' );
    $title_lines   = dv_theme_options_visual_value( $options, 'theme_card_title_lines', array( 'two', 'three', 'four' ), 'three' );
    $recipes       = dv_theme_options_visual_recipes();

    $classes = array(
        'dv-visual-preview',
        'dv-preview-preset-' . $preset,
        'dv-preview-color-' . $color_scheme,
        'dv-preview-width-' . $layout_width,
        'dv-preview-radius-' . $radius,
        'dv-preview-density-' . $density,
        'dv-preview-shadow-' . $shadow,
        'dv-preview-header-' . $header,
        'dv-preview-footer-' . $footer,
        'dv-preview-card-' . $card,
        'dv-preview-image-' . $image_ratio,
        'dv-preview-padding-' . $image_padding,
        'dv-preview-hover-' . $hover,
        'dv-preview-title-' . $title_lines,
    );
    ?>
    <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <div class="dv-visual-preview-head">
            <div>
                <h3><?php echo esc_html( dv_theme_options_label( '&#1055;&#1088;&#1077;&#1076;&#1087;&#1088;&#1086;&#1089;&#1084;&#1086;&#1090;&#1088;' ) ); ?></h3>
                <p><?php echo esc_html( dv_theme_options_label( '&#1057;&#1080;&#1083;&#1091;&#1101;&#1090; &#1096;&#1072;&#1087;&#1082;&#1080;, &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080; &#1080; &#1092;&#1091;&#1090;&#1077;&#1088;&#1072; &#1087;&#1086; &#1090;&#1077;&#1082;&#1091;&#1097;&#1080;&#1084; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1105;&#1085;&#1085;&#1099;&#1084; &#1087;&#1072;&#1088;&#1072;&#1084;&#1077;&#1090;&#1088;&#1072;&#1084;.' ) ); ?></p>
            </div>
            <div class="dv-visual-preview-actions">
                <span
                    class="dv-visual-preview-state"
                    data-saved-label="<?php echo esc_attr( dv_theme_options_label( '&#1057;&#1086;&#1093;&#1088;&#1072;&#1085;&#1105;&#1085;&#1085;&#1099;&#1081; &#1074;&#1080;&#1076;' ) ); ?>"
                    data-live-label="<?php echo esc_attr( dv_theme_options_label( '&#1055;&#1088;&#1077;&#1076;&#1087;&#1088;&#1086;&#1089;&#1084;&#1086;&#1090;&#1088; &#1087;&#1088;&#1072;&#1074;&#1086;&#1082;' ) ); ?>"
                ><?php echo esc_html( dv_theme_options_label( '&#1057;&#1086;&#1093;&#1088;&#1072;&#1085;&#1105;&#1085;&#1085;&#1099;&#1081; &#1074;&#1080;&#1076;' ) ); ?></span>
                <div class="dv-preview-device-toggle" role="group" aria-label="<?php echo esc_attr( dv_theme_options_label( '&#1056;&#1072;&#1079;&#1084;&#1077;&#1088; &#1087;&#1088;&#1077;&#1076;&#1087;&#1088;&#1086;&#1089;&#1084;&#1086;&#1090;&#1088;&#1072;' ) ); ?>">
                    <button type="button" class="is-active" data-dv-preview-device="desktop" aria-pressed="true">
                        <?php echo esc_html( dv_theme_options_label( 'Desktop' ) ); ?>
                    </button>
                    <button type="button" data-dv-preview-device="mobile" aria-pressed="false">
                        <?php echo esc_html( dv_theme_options_label( 'Mobile' ) ); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="dv-visual-recipes" aria-label="<?php echo esc_attr( dv_theme_options_label( 'Готовые наборы' ) ); ?>">
            <div class="dv-visual-recipes-copy">
                <strong><?php echo esc_html( dv_theme_options_label( 'Готовые наборы' ) ); ?></strong>
                <small><?php echo esc_html( dv_theme_options_label( 'Быстро выставляют несколько параметров сразу. После выбора можно точечно поправить любой селект ниже.' ) ); ?></small>
            </div>
            <div class="dv-visual-recipes-list">
                <?php foreach ( $recipes as $recipe_key => $recipe ) : ?>
                    <button
                        type="button"
                        class="dv-visual-recipe"
                        data-dv-visual-recipe-key="<?php echo esc_attr( $recipe_key ); ?>"
                        data-dv-visual-recipe="<?php echo esc_attr( wp_json_encode( $recipe['settings'] ) ); ?>"
                        aria-pressed="false"
                    >
                        <span><?php echo esc_html( dv_theme_options_label( $recipe['label'] ) ); ?></span>
                        <small><?php echo esc_html( dv_theme_options_label( $recipe['description'] ) ); ?></small>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="dv-visual-preview-stage">
            <div class="dv-visual-preview-shell">
                <div class="dv-visual-preview-topbar"></div>
                <div class="dv-visual-preview-header">
                    <div class="dv-preview-logo"></div>
                    <div class="dv-preview-search"><?php echo esc_html( dv_theme_options_label( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1087;&#1086; &#1072;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083;&#1091;...' ) ); ?></div>
                    <div class="dv-preview-icons"><i></i><i></i><i></i></div>
                </div>
                <div class="dv-visual-preview-nav"><span></span><span></span><span></span></div>
                <div class="dv-visual-preview-body">
                    <aside class="dv-preview-sidebar"><span></span><span></span><span></span></aside>
                    <article class="dv-preview-card">
                        <div class="dv-preview-card-image"><span></span></div>
                        <div class="dv-preview-card-body">
                            <small><?php echo esc_html( dv_theme_options_label( '&#1050;&#1091;&#1079;&#1086;&#1074;&#1085;&#1099;&#1077;' ) ); ?></small>
                            <strong><?php echo esc_html( dv_theme_options_label( '&#1056;&#1077;&#1084;&#1086;&#1085;&#1090;&#1085;&#1072;&#1103; &#1076;&#1077;&#1090;&#1072;&#1083;&#1100; &#1087;&#1086;&#1083;&#1072; &#1076;&#1083;&#1103; &#1042;&#1040;&#1047; 2110, 2111, 2112' ) ); ?></strong>
                            <em><?php echo esc_html( dv_theme_options_label( '&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;' ) ); ?></em>
                        </div>
                        <div class="dv-preview-card-footer">
                            <b>2 262 ₽</b>
                            <span><?php echo esc_html( dv_theme_options_label( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;' ) ); ?></span>
                        </div>
                    </article>
                    <article class="dv-preview-card dv-preview-card-muted"></article>
                </div>
                <div class="dv-visual-preview-footer"><span></span><span></span><span></span></div>
            </div>
        </div>
    </div>
    <?php
}

function dv_render_theme_options_order_grid( $options, $items ) {
    ?>
    <div class="dv-admin-order-grid">
        <div class="dv-admin-order-grid-head">
            <h3><?php echo esc_html( dv_theme_options_label( '&#1055;&#1086;&#1088;&#1103;&#1076;&#1086;&#1082; &#1073;&#1083;&#1086;&#1082;&#1086;&#1074;' ) ); ?></h3>
            <p><?php echo esc_html( dv_theme_options_label( '&#1063;&#1077;&#1084; &#1084;&#1077;&#1085;&#1100;&#1096;&#1077; &#1095;&#1080;&#1089;&#1083;&#1086;, &#1090;&#1077;&#1084; &#1074;&#1099;&#1096;&#1077; &#1073;&#1083;&#1086;&#1082; &#1085;&#1072; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1077;.' ) ); ?></p>
        </div>
        <div class="dv-admin-order-grid-body">
            <?php foreach ( $items as $item ) : ?>
                <label class="dv-admin-order-item">
                    <span><?php echo esc_html( $item['label'] ); ?></span>
                    <input
                        type="number"
                        name="dv_theme_options[<?php echo esc_attr( $item['key'] ); ?>]"
                        value="<?php echo esc_attr( $options[ $item['key'] ] ?? $item['default'] ?? 10 ); ?>"
                        min="1"
                        max="99"
                        step="1"
                    >
                    <?php if ( ! empty( $item['description'] ) ) : ?>
                        <small><?php echo esc_html( $item['description'] ); ?></small>
                    <?php endif; ?>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function dv_theme_options_enabled_count( $options, $keys ) {
    $count = 0;

    foreach ( $keys as $key ) {
        if ( '1' === (string) ( $options[ $key ] ?? '0' ) ) {
            $count++;
        }
    }

    return $count;
}

function dv_render_theme_options_overview( $options ) {
    $service_keys = array(
        'service_about_enabled',
        'service_delivery_enabled',
        'service_contacts_enabled',
        'service_return_enabled',
        'service_privacy_enabled',
        'service_agreement_enabled',
    );

    $product_keys = array(
        'product_summary_description_enabled',
        'product_tab_description_enabled',
        'product_tab_specs_enabled',
        'product_tab_reviews_enabled',
        'product_actions_enabled',
        'product_wishlist_enabled',
        'product_compare_enabled',
        'product_ozon_enabled',
    );

    $cards = array(
        array(
            'label' => dv_theme_options_label( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;' ),
            'value' => absint( $options['catalog_per_page'] ?? 0 ) . ' / ' . absint( $options['catalog_columns'] ?? 0 ),
            'hint'  => dv_theme_options_label( '&#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1085;&#1072; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1091; / &#1082;&#1086;&#1083;&#1086;&#1085;&#1086;&#1082;' ),
        ),
        array(
            'label' => dv_theme_options_label( '&#1055;&#1086;&#1080;&#1089;&#1082;' ),
            'value' => absint( $options['search_live_limit'] ?? 0 ) . ' / ' . absint( $options['search_page_per_page'] ?? 0 ),
            'hint'  => dv_theme_options_label( 'live-search / &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1072; &#1088;&#1077;&#1079;&#1091;&#1083;&#1100;&#1090;&#1072;&#1090;&#1086;&#1074;' ),
        ),
        array(
            'label' => dv_theme_options_label( '&#1057;&#1077;&#1088;&#1074;&#1080;&#1089;&#1099;' ),
            'value' => dv_theme_options_enabled_count( $options, $service_keys ) . ' / ' . count( $service_keys ),
            'hint'  => dv_theme_options_label( '&#1074;&#1082;&#1083;&#1102;&#1095;&#1105;&#1085;&#1085;&#1099;&#1093; &#1089;&#1077;&#1088;&#1074;&#1080;&#1089;&#1085;&#1099;&#1093; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;' ),
        ),
        array(
            'label' => dv_theme_options_label( '&#1050;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1072;' ),
            'value' => dv_theme_options_enabled_count( $options, $product_keys ) . ' / ' . count( $product_keys ),
            'hint'  => dv_theme_options_label( '&#1074;&#1082;&#1083;&#1102;&#1095;&#1105;&#1085;&#1085;&#1099;&#1093; &#1073;&#1083;&#1086;&#1082;&#1086;&#1074; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;' ),
        ),
        array(
            'label' => dv_theme_options_label( '&#1057;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1077;' ),
            'value' => absint( $options['compare_limit'] ?? 0 ),
            'hint'  => dv_theme_options_label( '&#1084;&#1072;&#1082;&#1089;&#1080;&#1084;&#1091;&#1084; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1074; &#1089;&#1087;&#1080;&#1089;&#1082;&#1077;' ),
        ),
    );
    ?>
    <section class="dv-options-overview" aria-label="<?php echo esc_attr( dv_theme_options_label( '&#1057;&#1074;&#1086;&#1076;&#1082;&#1072; &#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1077;&#1082; &#1090;&#1077;&#1084;&#1099;' ) ); ?>">
        <?php foreach ( $cards as $card ) : ?>
            <article class="dv-options-overview-card">
                <span><?php echo esc_html( $card['label'] ); ?></span>
                <strong><?php echo esc_html( $card['value'] ); ?></strong>
                <small><?php echo esc_html( $card['hint'] ); ?></small>
            </article>
        <?php endforeach; ?>
    </section>
    <?php
}

function dv_theme_backup_notice_text( $status ) {
    $notices = array(
        'imported'            => array( 'success', '&#1056;&#1077;&#1079;&#1077;&#1088;&#1074;&#1085;&#1072;&#1103; &#1082;&#1086;&#1087;&#1080;&#1103; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;&#1072;. &#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1090;&#1077;&#1084;&#1099; &#1086;&#1073;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085;&#1099;.' ),
        'import-empty'        => array( 'error', '&#1060;&#1072;&#1081;&#1083; &#1088;&#1077;&#1079;&#1077;&#1088;&#1074;&#1085;&#1086;&#1081; &#1082;&#1086;&#1087;&#1080;&#1080; &#1085;&#1077; &#1074;&#1099;&#1073;&#1088;&#1072;&#1085; &#1080;&#1083;&#1080; &#1087;&#1091;&#1089;&#1090;.' ),
        'import-invalid'      => array( 'error', '&#1069;&#1090;&#1086; &#1085;&#1077; &#1092;&#1072;&#1081;&#1083; &#1088;&#1077;&#1079;&#1077;&#1088;&#1074;&#1085;&#1086;&#1081; &#1082;&#1086;&#1087;&#1080;&#1080; &#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;.' ),
        'import-upload-error' => array( 'error', '&#1060;&#1072;&#1081;&#1083; &#1085;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1079;&#1072;&#1075;&#1088;&#1091;&#1079;&#1080;&#1090;&#1100;. &#1055;&#1086;&#1087;&#1088;&#1086;&#1073;&#1091;&#1081;&#1090;&#1077; &#1077;&#1097;&#1105; &#1088;&#1072;&#1079;.' ),
        'export-error'        => array( 'error', '&#1053;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1089;&#1086;&#1073;&#1088;&#1072;&#1090;&#1100; JSON-&#1092;&#1072;&#1081;&#1083; &#1088;&#1077;&#1079;&#1077;&#1088;&#1074;&#1072;.' ),
        'restored'            => array( 'success', '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1074;&#1086;&#1089;&#1089;&#1090;&#1072;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085;&#1099; &#1080;&#1079; &#1089;&#1085;&#1080;&#1084;&#1082;&#1072;, &#1089;&#1086;&#1079;&#1076;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086; &#1087;&#1077;&#1088;&#1077;&#1076; &#1087;&#1086;&#1089;&#1083;&#1077;&#1076;&#1085;&#1080;&#1084; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1086;&#1084;.' ),
        'restore-empty'       => array( 'error', '&#1053;&#1077;&#1090; &#1089;&#1085;&#1080;&#1084;&#1082;&#1072; &#1076;&#1083;&#1103; &#1086;&#1090;&#1082;&#1072;&#1090;&#1072;. &#1054;&#1085; &#1087;&#1086;&#1103;&#1074;&#1080;&#1090;&#1089;&#1103; &#1087;&#1086;&#1089;&#1083;&#1077; &#1087;&#1077;&#1088;&#1074;&#1086;&#1075;&#1086; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1072; JSON-&#1088;&#1077;&#1079;&#1077;&#1088;&#1074;&#1072;.' ),
        'auto-restored'       => array( 'success', '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1074;&#1086;&#1089;&#1089;&#1090;&#1072;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085;&#1099; &#1080;&#1079; &#1087;&#1086;&#1089;&#1083;&#1077;&#1076;&#1085;&#1077;&#1075;&#1086; &#1072;&#1074;&#1090;&#1086;&#1073;&#1101;&#1082;&#1072;&#1087;&#1072;.' ),
        'auto-restore-empty'  => array( 'error', '&#1053;&#1077;&#1090; &#1072;&#1074;&#1090;&#1086;&#1073;&#1101;&#1082;&#1072;&#1087;&#1072; &#1076;&#1083;&#1103; &#1086;&#1090;&#1082;&#1072;&#1090;&#1072;. &#1054;&#1085; &#1087;&#1086;&#1103;&#1074;&#1080;&#1090;&#1089;&#1103; &#1087;&#1086;&#1089;&#1083;&#1077; &#1089;&#1083;&#1077;&#1076;&#1091;&#1102;&#1097;&#1077;&#1075;&#1086; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1077;&#1085;&#1080;&#1103;.' ),
    );

    return $notices[ $status ] ?? null;
}

function dv_theme_reset_notice_text( $status ) {
    if ( 'invalid' === $status ) {
        return array( 'error', '&#1043;&#1088;&#1091;&#1087;&#1087;&#1072; &#1076;&#1083;&#1103; &#1089;&#1073;&#1088;&#1086;&#1089;&#1072; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1072;.' );
    }

    $groups = dv_theme_options_reset_groups();

    if ( empty( $groups[ $status ] ) ) {
        return null;
    }

    return array(
        'success',
        sprintf(
            /* translators: %s: settings group label. */
            dv_theme_options_label( '&#1041;&#1083;&#1086;&#1082; "%s" &#1089;&#1073;&#1088;&#1086;&#1096;&#1077;&#1085; &#1082; &#1079;&#1085;&#1072;&#1095;&#1077;&#1085;&#1080;&#1103;&#1084; &#1087;&#1086; &#1091;&#1084;&#1086;&#1083;&#1095;&#1072;&#1085;&#1080;&#1102;.' ),
            dv_theme_options_label( $groups[ $status ]['label'] )
        ),
    );
}

function dv_render_theme_backup_card() {
    $option_names = dv_theme_backup_option_names();
    $last_backup  = get_option( dv_theme_backup_last_import_option_name(), array() );
    $has_restore  = dv_theme_backup_is_valid_payload( $last_backup );
    $restore_date = '';
    $history      = array_slice( dv_theme_settings_history_get(), 0, 6 );
    $reset_groups = dv_theme_options_reset_groups();
    $auto_backup  = dv_theme_auto_backup_state();

    if ( $has_restore && ! empty( $last_backup['exported_at'] ) ) {
        $timestamp    = strtotime( (string) $last_backup['exported_at'] );
        $restore_date = $timestamp ? date_i18n( 'd.m.Y H:i', $timestamp ) : '';
    }
    ?>
    <section class="dv-admin-card dv-admin-backup-card" id="dv-options-backup">
        <h2><?php echo esc_html( dv_theme_options_label( '&#1056;&#1077;&#1079;&#1077;&#1088;&#1074; &#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1077;&#1082;' ) ); ?></h2>
        <p><?php echo esc_html( dv_theme_options_label( '&#1057;&#1082;&#1072;&#1095;&#1072;&#1081;&#1090;&#1077; JSON-&#1089;&#1085;&#1080;&#1084;&#1086;&#1082; &#1087;&#1077;&#1088;&#1077;&#1076; &#1082;&#1088;&#1091;&#1087;&#1085;&#1099;&#1084;&#1080; &#1087;&#1088;&#1072;&#1074;&#1082;&#1072;&#1084;&#1080; &#1080;&#1083;&#1080; &#1079;&#1072;&#1075;&#1088;&#1091;&#1079;&#1080;&#1090;&#1077; &#1077;&#1075;&#1086; &#1086;&#1073;&#1088;&#1072;&#1090;&#1085;&#1086;, &#1095;&#1090;&#1086;&#1073;&#1099; &#1074;&#1077;&#1088;&#1085;&#1091;&#1090;&#1100; &#1072;&#1076;&#1084;&#1080;&#1085;&#1089;&#1082;&#1091;&#1102; &#1082;&#1086;&#1085;&#1092;&#1080;&#1075;&#1091;&#1088;&#1072;&#1094;&#1080;&#1102;.' ) ); ?></p>

        <div class="dv-admin-backup-grid">
            <article class="dv-admin-backup-panel">
                <strong><?php echo esc_html( dv_theme_options_label( '&#1069;&#1082;&#1089;&#1087;&#1086;&#1088;&#1090;' ) ); ?></strong>
                <span><?php echo esc_html( dv_theme_options_label( '&#1057;&#1086;&#1093;&#1088;&#1072;&#1085;&#1103;&#1077;&#1090; &#1074;&#1080;&#1090;&#1088;&#1080;&#1085;&#1091;, &#1082;&#1086;&#1085;&#1090;&#1077;&#1085;&#1090;, &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072; &#1080; SEO-&#1086;&#1087;&#1094;&#1080;&#1080; &#1074; &#1086;&#1076;&#1080;&#1085; JSON-&#1092;&#1072;&#1081;&#1083;.' ) ); ?></span>
                <button type="submit" class="button button-primary" form="dv-theme-backup-export">
                    <?php echo esc_html( dv_theme_options_label( '&#1057;&#1082;&#1072;&#1095;&#1072;&#1090;&#1100; &#1088;&#1077;&#1079;&#1077;&#1088;&#1074;' ) ); ?>
                </button>
            </article>

            <article class="dv-admin-backup-panel">
                <strong><?php echo esc_html( dv_theme_options_label( '&#1048;&#1084;&#1087;&#1086;&#1088;&#1090;' ) ); ?></strong>
                <span><?php echo esc_html( dv_theme_options_label( '&#1047;&#1072;&#1075;&#1088;&#1091;&#1079;&#1080;&#1090;&#1077; JSON-&#1092;&#1072;&#1081;&#1083;, &#1088;&#1072;&#1085;&#1077;&#1077; &#1089;&#1082;&#1072;&#1095;&#1072;&#1085;&#1085;&#1099;&#1081; &#1080;&#1079; &#1101;&#1090;&#1086;&#1075;&#1086; &#1073;&#1083;&#1086;&#1082;&#1072;. &#1058;&#1077;&#1082;&#1091;&#1097;&#1080;&#1077; &#1086;&#1087;&#1094;&#1080;&#1080; &#1073;&#1091;&#1076;&#1091;&#1090; &#1079;&#1072;&#1084;&#1077;&#1085;&#1077;&#1085;&#1099;.' ) ); ?></span>
                <input type="file" name="dv_theme_backup_file" accept="application/json,.json" form="dv-theme-backup-import">
                <button type="submit" class="button" form="dv-theme-backup-import">
                    <?php echo esc_html( dv_theme_options_label( '&#1047;&#1072;&#1075;&#1088;&#1091;&#1079;&#1080;&#1090;&#1100; &#1088;&#1077;&#1079;&#1077;&#1088;&#1074;' ) ); ?>
                </button>
            </article>

            <article class="dv-admin-backup-panel">
                <strong><?php echo esc_html( dv_theme_options_label( '&#1054;&#1090;&#1082;&#1072;&#1090; &#1087;&#1086;&#1089;&#1083;&#1077; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1072;' ) ); ?></strong>
                <span>
                    <?php
                    echo esc_html(
                        $has_restore
                            ? sprintf(
                                /* translators: %s: backup date. */
                                dv_theme_options_label( '&#1052;&#1086;&#1078;&#1085;&#1086; &#1074;&#1077;&#1088;&#1085;&#1091;&#1090;&#1100; &#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080;, &#1082;&#1086;&#1090;&#1086;&#1088;&#1099;&#1077; &#1073;&#1099;&#1083;&#1080; &#1076;&#1086; &#1087;&#1086;&#1089;&#1083;&#1077;&#1076;&#1085;&#1077;&#1075;&#1086; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1072;%s;.' ),
                                $restore_date ? ' (' . $restore_date . ')' : ''
                            )
                            : dv_theme_options_label( '&#1057;&#1085;&#1080;&#1084;&#1086;&#1082; &#1076;&#1083;&#1103; &#1086;&#1090;&#1082;&#1072;&#1090;&#1072; &#1087;&#1086;&#1103;&#1074;&#1080;&#1090;&#1089;&#1103; &#1072;&#1074;&#1090;&#1086;&#1084;&#1072;&#1090;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080; &#1087;&#1077;&#1088;&#1077;&#1076; &#1087;&#1077;&#1088;&#1074;&#1099;&#1084; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1086;&#1084;.' )
                    );
                    ?>
                </span>
                <button type="submit" class="button" form="dv-theme-backup-restore" <?php disabled( ! $has_restore ); ?>>
                    <?php echo esc_html( dv_theme_options_label( '&#1042;&#1077;&#1088;&#1085;&#1091;&#1090;&#1100; &#1076;&#1086; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1072;' ) ); ?>
                </button>
            </article>

            <article class="dv-admin-backup-panel">
                <strong><?php echo esc_html( dv_theme_options_label( '&#1040;&#1074;&#1090;&#1086;&#1073;&#1101;&#1082;&#1072;&#1087;' ) ); ?></strong>
                <span>
                    <?php
                    echo esc_html(
                        ! empty( $auto_backup['has_restore'] )
                            ? sprintf(
                                /* translators: 1: backup date, 2: source. */
                                dv_theme_options_label( '&#1055;&#1086;&#1089;&#1083;&#1077;&#1076;&#1085;&#1080;&#1081; &#1089;&#1085;&#1080;&#1084;&#1086;&#1082;: %1$s. &#1048;&#1089;&#1090;&#1086;&#1095;&#1085;&#1080;&#1082;: %2$s.' ),
                                $auto_backup['created_at_display'] ?: dv_theme_options_label( '&#1076;&#1072;&#1090;&#1072; &#1085;&#1077;&#1080;&#1079;&#1074;&#1077;&#1089;&#1090;&#1085;&#1072;' ),
                                $auto_backup['source'] ?: dv_theme_options_label( '&#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1077;&#1085;&#1080;&#1077;' )
                            )
                            : dv_theme_options_label( '&#1057;&#1085;&#1080;&#1084;&#1086;&#1082; &#1089;&#1086;&#1079;&#1076;&#1072;&#1089;&#1090;&#1089;&#1103; &#1072;&#1074;&#1090;&#1086;&#1084;&#1072;&#1090;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080; &#1087;&#1077;&#1088;&#1077;&#1076; &#1089;&#1083;&#1077;&#1076;&#1091;&#1102;&#1097;&#1080;&#1084; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1077;&#1085;&#1080;&#1077;&#1084; &#1080;&#1083;&#1080; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1086;&#1084;.' )
                    );
                    ?>
                </span>
                <button type="submit" class="button" form="dv-theme-auto-backup-restore" <?php disabled( empty( $auto_backup['has_restore'] ) ); ?>>
                    <?php echo esc_html( dv_theme_options_label( '&#1054;&#1090;&#1082;&#1072;&#1090;&#1080;&#1090;&#1100; &#1072;&#1074;&#1090;&#1086;&#1073;&#1101;&#1082;&#1072;&#1087;' ) ); ?>
                </button>
            </article>
        </div>

        <div class="dv-admin-settings-reset">
            <div class="dv-admin-settings-reset-head">
                <div>
                    <h3><?php echo esc_html( dv_theme_options_label( '&#1057;&#1073;&#1088;&#1086;&#1089; &#1086;&#1076;&#1085;&#1086;&#1075;&#1086; &#1073;&#1083;&#1086;&#1082;&#1072;' ) ); ?></h3>
                    <p><?php echo esc_html( dv_theme_options_label( '&#1042;&#1086;&#1079;&#1074;&#1088;&#1072;&#1097;&#1072;&#1077;&#1090; &#1082; &#1076;&#1077;&#1092;&#1086;&#1083;&#1090;&#1072;&#1084; &#1090;&#1086;&#1083;&#1100;&#1082;&#1086; &#1074;&#1099;&#1073;&#1088;&#1072;&#1085;&#1085;&#1091;&#1102; &#1075;&#1088;&#1091;&#1087;&#1087;&#1091; &#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1077;&#1082; &#1074;&#1080;&#1090;&#1088;&#1080;&#1085;&#1099;.' ) ); ?></p>
                </div>
            </div>
            <div class="dv-admin-settings-reset-grid">
                <?php foreach ( $reset_groups as $group_key => $group ) : ?>
                    <article class="dv-admin-settings-reset-item">
                        <div>
                            <strong><?php echo esc_html( dv_theme_options_label( $group['label'] ) ); ?></strong>
                            <span><?php echo esc_html( dv_theme_options_label( $group['description'] ) ); ?></span>
                        </div>
                        <button
                            type="submit"
                            class="button"
                            form="dv-theme-reset-<?php echo esc_attr( $group_key ); ?>"
                            data-dv-confirm="<?php echo esc_attr( sprintf( dv_theme_options_label( '&#1057;&#1073;&#1088;&#1086;&#1089;&#1080;&#1090;&#1100; "%s" &#1082; &#1076;&#1077;&#1092;&#1086;&#1083;&#1090;&#1072;&#1084;?' ), dv_theme_options_label( $group['label'] ) ) ); ?>"
                        >
                            <?php echo esc_html( dv_theme_options_label( '&#1057;&#1073;&#1088;&#1086;&#1089;&#1080;&#1090;&#1100;' ) ); ?>
                        </button>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="dv-admin-settings-history">
            <div class="dv-admin-settings-history-head">
                <div>
                    <h3><?php echo esc_html( dv_theme_options_label( '&#1048;&#1089;&#1090;&#1086;&#1088;&#1080;&#1103; &#1080;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1080;&#1081;' ) ); ?></h3>
                    <p><?php echo esc_html( dv_theme_options_label( '&#1055;&#1086;&#1089;&#1083;&#1077;&#1076;&#1085;&#1080;&#1077; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1077;&#1085;&#1080;&#1103;: &#1082;&#1090;&#1086;, &#1082;&#1086;&#1075;&#1076;&#1072; &#1080; &#1082;&#1072;&#1082;&#1080;&#1077; &#1075;&#1088;&#1091;&#1087;&#1087;&#1099; &#1079;&#1072;&#1090;&#1088;&#1086;&#1085;&#1091;&#1090;&#1099;.' ) ); ?></p>
                </div>
                <div class="dv-admin-settings-history-actions dv-suite-action-row">
                    <span><?php echo esc_html( count( $history ) ); ?></span>
                    <?php if ( ! empty( $history ) ) : ?>
                        <button type="submit" class="button button-secondary" form="dv-theme-settings-history-export">
                            <?php echo esc_html( dv_theme_options_label( '&#1057;&#1082;&#1072;&#1095;&#1072;&#1090;&#1100; CSV' ) ); ?>
                        </button>
                        <button
                            type="submit"
                            class="button"
                            form="dv-theme-settings-history-clear"
                            data-dv-confirm="<?php echo esc_attr( dv_theme_options_label( '&#1054;&#1095;&#1080;&#1089;&#1090;&#1080;&#1090;&#1100; &#1080;&#1089;&#1090;&#1086;&#1088;&#1080;&#1102; &#1080;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1080;&#1081;? &#1069;&#1090;&#1086; &#1085;&#1077; &#1086;&#1090;&#1082;&#1072;&#1090;&#1099;&#1074;&#1072;&#1077;&#1090; &#1089;&#1072;&#1084;&#1080; &#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080;.' ) ); ?>"
                        >
                            <?php echo esc_html( dv_theme_options_label( '&#1054;&#1095;&#1080;&#1089;&#1090;&#1080;&#1090;&#1100;' ) ); ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ( empty( $history ) ) : ?>
                <p class="dv-admin-settings-history-empty"><?php echo esc_html( dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072; &#1085;&#1077;&#1090; &#1079;&#1072;&#1087;&#1080;&#1089;&#1077;&#1081;. &#1048;&#1089;&#1090;&#1086;&#1088;&#1080;&#1103; &#1087;&#1086;&#1103;&#1074;&#1080;&#1090;&#1089;&#1103; &#1087;&#1086;&#1089;&#1083;&#1077; &#1089;&#1083;&#1077;&#1076;&#1091;&#1102;&#1097;&#1077;&#1075;&#1086; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1077;&#1085;&#1080;&#1103;.' ) ); ?></p>
            <?php else : ?>
                <div class="dv-admin-settings-history-list">
                    <?php foreach ( $history as $entry ) : ?>
                        <?php
                        $timestamp = ! empty( $entry['changed_at_gmt'] ) ? strtotime( (string) $entry['changed_at_gmt'] . ' UTC' ) : false;
                        $date      = $timestamp ? wp_date( 'd.m.Y H:i', $timestamp ) : '';
                        $keys      = ! empty( $entry['changed_keys'] ) && is_array( $entry['changed_keys'] ) ? $entry['changed_keys'] : array();
                        ?>
                        <article class="dv-admin-settings-history-item">
                            <div>
                                <strong><?php echo esc_html( dv_theme_options_label( (string) ( $entry['label'] ?? $entry['option'] ?? '' ) ) ); ?></strong>
                                <span>
                                    <?php
                                    echo esc_html(
                                        trim(
                                            implode(
                                                ' · ',
                                                array_filter(
                                                    array(
                                                        $date,
                                                        (string) ( $entry['user_name'] ?? '' ),
                                                    )
                                                )
                                            )
                                        )
                                    );
                                    ?>
                                </span>
                            </div>
                            <p>
                                <?php
                                echo esc_html(
                                    sprintf(
                                        /* translators: %d: changed fields count. */
                                        dv_theme_options_label( '&#1048;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1086; &#1087;&#1086;&#1083;&#1077;&#1081;: %d' ),
                                        absint( $entry['changed_count'] ?? count( $keys ) )
                                    )
                                );
                                ?>
                            </p>
                            <?php if ( ! empty( $keys ) ) : ?>
                                <ul>
                                    <?php foreach ( $keys as $key ) : ?>
                                        <li><code><?php echo esc_html( (string) $key ); ?></code></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <p class="description">
            <?php echo esc_html( dv_theme_options_label( '&#1042; &#1089;&#1085;&#1080;&#1084;&#1086;&#1082; &#1074;&#1093;&#1086;&#1076;&#1103;&#1090; &#1086;&#1087;&#1094;&#1080;&#1080;:' ) ); ?>
            <code><?php echo esc_html( implode( ', ', $option_names ) ); ?></code>
        </p>
    </section>
    <?php
}

function dv_theme_diagnostics_checks( $options ) {
    $theme_dir = get_stylesheet_directory();
    $overrides = dv_theme_woocommerce_overrides_report();
    $audit     = dv_theme_product_audit_report();
    $marketplaces = dv_theme_marketplace_diagnostics_report( $options );
    $profile_health = dv_theme_store_profile_health_report();
    $maintenance = dv_theme_maintenance_report();

    $required_files = array(
        'header.php',
        'footer.php',
        'inc/theme-core.php',
        'inc/seo.php',
        'inc/template-functions.php',
        'assets/css/main.css',
        'assets/js/main.js',
        'woocommerce/archive-product.php',
        'woocommerce/content-product.php',
        'woocommerce/single-product.php',
    );

    $missing_files = array();
    foreach ( $required_files as $file ) {
        if ( ! file_exists( $theme_dir . '/' . $file ) ) {
            $missing_files[] = $file;
        }
    }

    $preset = sanitize_key( $options['theme_visual_preset'] ?? 'default' );
    $override_issues = array_merge( $overrides['missing'], $overrides['outdated'] );
    $override_status = empty( $override_issues );
    $override_fail   = 'Проверьте: ' . implode( ', ', array_slice( $override_issues, 0, 4 ) );

    if ( count( $override_issues ) > 4 ) {
        $override_fail .= ' +' . ( count( $override_issues ) - 4 );
    }

    $audit_fail_parts = array();
    foreach ( $audit['issues'] as $issue ) {
        if ( ! empty( $issue['count'] ) ) {
            $audit_fail_parts[] = $issue['label'] . ': ' . absint( $issue['count'] );
        }
    }

    $audit_fail = ! empty( $audit['available'] )
        ? dv_theme_options_label( '&#1047;&#1072;&#1084;&#1077;&#1095;&#1072;&#1085;&#1080;&#1103;: ' ) . implode( ', ', array_slice( $audit_fail_parts, 0, 4 ) )
        : dv_theme_options_label( 'WooCommerce &#1080;&#1083;&#1080; product post type &#1085;&#1077; &#1076;&#1086;&#1089;&#1090;&#1091;&#1087;&#1085;&#1099;' );

    if ( count( $audit_fail_parts ) > 4 ) {
        $audit_fail .= ' +' . ( count( $audit_fail_parts ) - 4 );
    }

    return array(
        array(
            'label'  => 'WooCommerce',
            'status' => class_exists( 'WooCommerce' ),
            'ok'     => 'Плагин активен',
            'fail'   => 'Плагин не найден или выключен',
        ),
        array(
            'label'  => 'Ключевые файлы темы',
            'status' => empty( $missing_files ),
            'ok'     => 'Все основные шаблоны и assets на месте',
            'fail'   => 'Не найдены: ' . implode( ', ', $missing_files ),
        ),
        array(
            'label'  => 'WooCommerce шаблоны',
            'status' => $override_status,
            'ok'     => $overrides['total'] . ' overrides, версии указаны и не старее WooCommerce',
            'fail'   => $override_fail,
        ),
        array(
            'label'  => dv_theme_options_label( '&#1040;&#1091;&#1076;&#1080;&#1090; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;' ),
            'status' => ! empty( $audit['available'] ) && empty( $audit['issue_count'] ),
            'ok'     => sprintf(
                /* translators: %d: products count. */
                dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;: %d, &#1082;&#1088;&#1080;&#1090;&#1080;&#1095;&#1085;&#1099;&#1093; &#1087;&#1088;&#1086;&#1087;&#1091;&#1089;&#1082;&#1086;&#1074; &#1085;&#1077;&#1090;' ),
                absint( $audit['total'] )
            ),
            'fail'   => $audit_fail,
        ),
        array(
            'label'  => 'Ozon / marketplace',
            'status' => ! empty( $marketplaces['status'] ),
            'ok'     => 'Кнопки, URL, логотип и rel-атрибуты выглядят корректно',
            'fail'   => 'Проверьте: ' . implode( ', ', wp_list_pluck( array_slice( $marketplaces['issues'], 0, 4 ), 'label' ) ),
        ),
        array(
            'label'  => 'Sitemap',
            'status' => function_exists( 'dv_build_sitemap_urls' ) && function_exists( 'dv_get_sitemap_xml' ),
            'ok'     => 'Генератор sitemaps.xml подключен',
            'fail'   => 'Функции sitemap не подключены',
        ),
        array(
            'label'  => 'SEO head',
            'status' => function_exists( 'dv_output_seo_meta' ),
            'ok'     => 'SEO-мета слой темы подключен',
            'fail'   => 'SEO head не найден',
        ),
        array(
            'label'  => 'Профиль магазина',
            'status' => empty( $profile_health['issue_count'] ),
            'ok'     => 'Контакты, URL и marketplace-поля в порядке',
            'fail'   => 'Проверьте: ' . implode( ', ', array_map( 'dv_theme_options_label', wp_list_pluck( array_slice( $profile_health['issues'], 0, 4 ), 'label' ) ) ),
        ),
        array(
            'label'  => 'Визуальный пресет',
            'status' => in_array( $preset, array( 'default', 'contrast', 'soft', 'graphite', 'ozon', 'market', 'wildberries' ), true ),
            'ok'     => 'Активен: ' . $preset,
            'fail'   => 'Неизвестный пресет, будет использован default',
        ),
        array(
            'label'  => dv_theme_options_label( '&#1054;&#1073;&#1089;&#1083;&#1091;&#1078;&#1080;&#1074;&#1072;&#1085;&#1080;&#1077;' ),
            'status' => ! empty( $maintenance['status'] ),
            'ok'     => dv_theme_options_label( '&#1048;&#1089;&#1090;&#1086;&#1088;&#1080;&#1103;, &#1072;&#1074;&#1090;&#1086;&#1073;&#1101;&#1082;&#1072;&#1087;, &#1089;&#1073;&#1088;&#1086;&#1089; &#1080; mobile safety-pass &#1074; &#1087;&#1086;&#1088;&#1103;&#1076;&#1082;&#1077;' ),
            'fail'   => dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1100;&#1090;&#1077; &#1089;&#1074;&#1086;&#1076;&#1082;&#1091; &#1086;&#1073;&#1089;&#1083;&#1091;&#1078;&#1080;&#1074;&#1072;&#1085;&#1080;&#1103;' ),
        ),
    );
}

function dv_render_theme_product_audit_card( $audit ) {
    $available   = ! empty( $audit['available'] );
    $total       = absint( $audit['total'] ?? 0 );
    $issue_count = absint( $audit['issue_count'] ?? 0 );
    $issues      = isset( $audit['issues'] ) && is_array( $audit['issues'] ) ? $audit['issues'] : array();
    $image_alt_count = 0;
    $excerpt_fill_count = $available ? count( dv_theme_product_audit_excerpt_source_ids() ) : 0;

    foreach ( $issues as $issue ) {
        if ( 'image_alt' === (string) ( $issue['key'] ?? '' ) ) {
            $image_alt_count = absint( $issue['count'] ?? 0 );
            break;
        }
    }
    ?>
    <div class="dv-admin-product-audit">
        <div class="dv-admin-product-audit-head">
            <div>
                <h3><?php echo esc_html( dv_theme_options_label( '&#1040;&#1091;&#1076;&#1080;&#1090; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;' ) ); ?></h3>
                <p><?php echo esc_html( dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1103;&#1077;&#1090; &#1073;&#1072;&#1079;&#1086;&#1074;&#1091;&#1102; &#1075;&#1086;&#1090;&#1086;&#1074;&#1085;&#1086;&#1089;&#1090;&#1100; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1077;&#1082; &#1082; &#1074;&#1080;&#1090;&#1088;&#1080;&#1085;&#1077;: &#1092;&#1086;&#1090;&#1086;, &#1094;&#1077;&#1085;&#1091;, SKU, &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1102;, &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1080; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;.' ) ); ?></p>
                <?php if ( ! empty( $audit['generated_at_display'] ) ) : ?>
                    <small class="dv-admin-product-audit-updated">
                        <?php echo esc_html( dv_theme_options_label( '&#1054;&#1073;&#1085;&#1086;&#1074;&#1083;&#1077;&#1085;&#1086;: ' ) . (string) $audit['generated_at_display'] ); ?>
                    </small>
                <?php endif; ?>
            </div>
            <div class="dv-admin-product-audit-side">
                <div class="dv-admin-product-audit-totals">
                    <span>
                        <?php echo esc_html( dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;' ) ); ?>
                        <strong><?php echo esc_html( number_format_i18n( $total ) ); ?></strong>
                    </span>
                    <span class="<?php echo $issue_count > 0 ? 'has-issues' : 'is-clean'; ?>">
                        <?php echo esc_html( dv_theme_options_label( '&#1047;&#1072;&#1084;&#1077;&#1095;&#1072;&#1085;&#1080;&#1081;' ) ); ?>
                        <strong><?php echo esc_html( number_format_i18n( $issue_count ) ); ?></strong>
                    </span>
                </div>
                <?php if ( $available && $issue_count > 0 ) : ?>
                    <button type="submit" class="button button-secondary" form="dv-theme-product-audit-export">
                        <?php echo esc_html( dv_theme_options_label( '&#1057;&#1082;&#1072;&#1095;&#1072;&#1090;&#1100; CSV' ) ); ?>
                    </button>
                <?php endif; ?>
                <?php if ( $available ) : ?>
                    <button type="submit" class="button" form="dv-theme-product-audit-refresh">
                        <?php echo esc_html( dv_theme_options_label( '&#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1100; &#1072;&#1091;&#1076;&#1080;&#1090;' ) ); ?>
                    </button>
                <?php endif; ?>
                <?php if ( $available && $image_alt_count > 0 ) : ?>
                    <button
                        type="submit"
                        class="button"
                        form="dv-theme-product-audit-fill-image-alt"
                        data-dv-confirm="<?php echo esc_attr( dv_theme_options_label( '&#1047;&#1072;&#1087;&#1086;&#1083;&#1085;&#1080;&#1090;&#1100; &#1087;&#1091;&#1089;&#1090;&#1099;&#1077; alt &#1086;&#1089;&#1085;&#1086;&#1074;&#1085;&#1099;&#1093; &#1092;&#1086;&#1090;&#1086; &#1085;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077;&#1084; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;?' ) ); ?>"
                    >
                        <?php echo esc_html( dv_theme_options_label( '&#1047;&#1072;&#1087;&#1086;&#1083;&#1085;&#1080;&#1090;&#1100; alt' ) ); ?>
                    </button>
                <?php endif; ?>
                <?php if ( $available && $excerpt_fill_count > 0 ) : ?>
                    <button
                        type="submit"
                        class="button"
                        form="dv-theme-product-audit-fill-excerpt"
                        data-dv-confirm="<?php echo esc_attr( dv_theme_options_label( '&#1047;&#1072;&#1087;&#1086;&#1083;&#1085;&#1080;&#1090;&#1100; &#1087;&#1091;&#1089;&#1090;&#1099;&#1077; &#1082;&#1088;&#1072;&#1090;&#1082;&#1080;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1103; &#1080;&#1079; &#1085;&#1072;&#1095;&#1072;&#1083;&#1072; &#1087;&#1086;&#1083;&#1085;&#1086;&#1075;&#1086; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1103;?' ) ); ?>"
                    >
                        <?php echo esc_html( dv_theme_options_label( '&#1047;&#1072;&#1087;&#1086;&#1083;&#1085;&#1080;&#1090;&#1100; &#1082;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077;' ) ); ?>
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( ! $available ) : ?>
            <div class="dv-admin-product-audit-empty">
                <?php echo esc_html( dv_theme_options_label( 'WooCommerce &#1080;&#1083;&#1080; &#1090;&#1080;&#1087; &#1079;&#1072;&#1087;&#1080;&#1089;&#1080; product &#1085;&#1077; &#1076;&#1086;&#1089;&#1090;&#1091;&#1087;&#1085;&#1099;.' ) ); ?>
            </div>
        <?php else : ?>
            <div class="dv-admin-product-audit-grid">
                <?php foreach ( $issues as $issue ) : ?>
                    <?php $count = absint( $issue['count'] ?? 0 ); ?>
                    <article class="dv-admin-product-audit-item<?php echo $count > 0 ? ' has-issues' : ' is-clean'; ?>">
                        <span class="dv-admin-product-audit-count"><?php echo esc_html( number_format_i18n( $count ) ); ?></span>
                        <strong><?php echo esc_html( $issue['label'] ?? '' ); ?></strong>
                        <small><?php echo esc_html( $issue['hint'] ?? '' ); ?></small>
                        <?php if ( $count > 0 ) : ?>
                            <div class="dv-admin-product-audit-links">
                                <?php if ( ! empty( $issue['sample_url'] ) ) : ?>
                                    <a href="<?php echo esc_url( $issue['sample_url'] ); ?>">
                                        <?php echo esc_html( dv_theme_options_label( '&#1054;&#1090;&#1082;&#1088;&#1099;&#1090;&#1100; &#1087;&#1088;&#1080;&#1084;&#1077;&#1088;' ) ); ?>
                                    </a>
                                <?php endif; ?>
                                <?php if ( ! empty( $issue['list_url'] ) ) : ?>
                                    <a href="<?php echo esc_url( $issue['list_url'] ); ?>">
                                        <?php echo esc_html( dv_theme_options_label( '&#1042;&#1089;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1099;' ) ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

function dv_render_theme_marketplace_diagnostics_card( $report ) {
    $checks = isset( $report['checks'] ) && is_array( $report['checks'] ) ? $report['checks'] : array();
    ?>
    <div class="dv-admin-marketplace-audit">
        <div class="dv-admin-marketplace-audit-head">
            <div>
                <h3>Ozon / marketplace</h3>
                <p>Проверяет URL, включение кнопок, логотип Ozon и SEO-rel для внешних marketplace-ссылок.</p>
            </div>
            <a class="button button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=dv-store-settings#dv-store-marketplaces' ) ); ?>">
                Открыть профиль магазина
            </a>
        </div>
        <div class="dv-admin-marketplace-audit-grid">
            <?php foreach ( $checks as $check ) : ?>
                <article class="<?php echo ! empty( $check['status'] ) ? 'is-ok' : 'is-warning'; ?>">
                    <span><?php echo ! empty( $check['status'] ) ? 'OK' : 'Проверить'; ?></span>
                    <strong><?php echo esc_html( $check['label'] ?? '' ); ?></strong>
                    <small><?php echo esc_html( $check['hint'] ?? '' ); ?></small>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function dv_render_theme_store_profile_health_card( $report ) {
    $checks      = isset( $report['checks'] ) && is_array( $report['checks'] ) ? $report['checks'] : array();
    $issue_count = absint( $report['issue_count'] ?? 0 );
    ?>
    <div class="dv-admin-profile-health">
        <div class="dv-admin-profile-health-head">
            <div>
                <h3><?php echo esc_html( dv_theme_options_label( '&#1055;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;' ) ); ?></h3>
                <p><?php echo esc_html( dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1103;&#1077;&#1090; &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;, URL, Ozon, &#1072;&#1076;&#1088;&#1077;&#1089;&#1085;&#1099;&#1077; &#1080; marketplace-&#1087;&#1086;&#1083;&#1103;, &#1082;&#1086;&#1090;&#1086;&#1088;&#1099;&#1077; &#1080;&#1076;&#1091;&#1090; &#1074; &#1096;&#1072;&#1087;&#1082;&#1091;, footer, schema &#1080; SEO.' ) ); ?></p>
            </div>
            <a class="button button-secondary" href="<?php echo esc_url( $report['settings_url'] ?? admin_url( 'admin.php?page=dv-store-settings' ) ); ?>">
                <?php echo esc_html( dv_theme_options_label( '&#1054;&#1090;&#1082;&#1088;&#1099;&#1090;&#1100; &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100;' ) ); ?>
            </a>
        </div>
        <div class="dv-admin-profile-health-total<?php echo $issue_count > 0 ? ' has-issues' : ' is-clean'; ?>">
            <span><?php echo esc_html( dv_theme_options_label( '&#1055;&#1088;&#1086;&#1081;&#1076;&#1077;&#1085;&#1086;' ) ); ?></span>
            <strong><?php echo esc_html( absint( $report['passed'] ?? 0 ) ); ?> / <?php echo esc_html( absint( $report['total'] ?? 0 ) ); ?></strong>
            <small><?php echo esc_html( $issue_count > 0 ? dv_theme_options_label( '&#1045;&#1089;&#1090;&#1100; &#1095;&#1090;&#1086; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100;' ) : dv_theme_options_label( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099; &#1080; URL &#1074; &#1087;&#1086;&#1088;&#1103;&#1076;&#1082;&#1077;' ) ); ?></small>
        </div>
        <div class="dv-admin-profile-health-grid">
            <?php foreach ( $checks as $check ) : ?>
                <article class="<?php echo ! empty( $check['status'] ) ? 'is-ok' : 'is-warning'; ?>">
                    <span><?php echo ! empty( $check['status'] ) ? esc_html( dv_theme_options_label( '&#1054;&#1050;' ) ) : esc_html( dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100;' ) ); ?></span>
                    <strong><?php echo esc_html( dv_theme_options_label( $check['label'] ?? '' ) ); ?></strong>
                    <small><?php echo esc_html( dv_theme_options_label( $check['hint'] ?? '' ) ); ?></small>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function dv_render_theme_maintenance_card( $report ) {
    $checks      = isset( $report['checks'] ) && is_array( $report['checks'] ) ? $report['checks'] : array();
    $issue_count = absint( $report['issue_count'] ?? 0 );
    ?>
    <div class="dv-admin-maintenance-audit">
        <div class="dv-admin-maintenance-audit-head">
            <div>
                <h3><?php echo esc_html( dv_theme_options_label( '&#1054;&#1073;&#1089;&#1083;&#1091;&#1078;&#1080;&#1074;&#1072;&#1085;&#1080;&#1077;' ) ); ?></h3>
                <p><?php echo esc_html( dv_theme_options_label( '&#1050;&#1086;&#1085;&#1090;&#1088;&#1086;&#1083;&#1080;&#1088;&#1091;&#1077;&#1090;, &#1095;&#1090;&#1086; &#1080;&#1089;&#1090;&#1086;&#1088;&#1080;&#1103;, &#1072;&#1074;&#1090;&#1086;&#1073;&#1101;&#1082;&#1072;&#1087;, &#1090;&#1086;&#1095;&#1077;&#1095;&#1085;&#1099;&#1081; &#1089;&#1073;&#1088;&#1086;&#1089; &#1080; &#1084;&#1086;&#1073;&#1080;&#1083;&#1100;&#1085;&#1099;&#1081; CSS-&#1089;&#1083;&#1086;&#1081; &#1086;&#1089;&#1090;&#1072;&#1102;&#1090;&#1089;&#1103; &#1085;&#1072; &#1084;&#1077;&#1089;&#1090;&#1077;.' ) ); ?></p>
            </div>
            <div class="dv-admin-maintenance-audit-actions dv-suite-action-row">
                <span class="<?php echo $issue_count > 0 ? 'is-warning' : 'is-ok'; ?>">
                    <?php echo esc_html( $issue_count > 0 ? dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100;' ) : dv_theme_options_label( '&#1054;&#1050;' ) ); ?>
                </span>
                <button type="submit" class="button" form="dv-theme-service-cache-clear">
                    <?php echo esc_html( dv_theme_options_label( '&#1054;&#1095;&#1080;&#1089;&#1090;&#1080;&#1090;&#1100; &#1082;&#1101;&#1096;&#1080;' ) ); ?>
                </button>
            </div>
        </div>
        <div class="dv-admin-maintenance-audit-grid">
            <?php foreach ( $checks as $check ) : ?>
                <article class="<?php echo ! empty( $check['status'] ) ? 'is-ok' : 'is-warning'; ?>">
                    <span><?php echo ! empty( $check['status'] ) ? esc_html( dv_theme_options_label( '&#1054;&#1050;' ) ) : esc_html( dv_theme_options_label( '&#1055;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090;&#1100;' ) ); ?></span>
                    <strong><?php echo esc_html( dv_theme_options_label( $check['label'] ?? '' ) ); ?></strong>
                    <small><?php echo esc_html( dv_theme_options_label( $check['hint'] ?? '' ) ); ?></small>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function dv_render_theme_support_summary_card( $summary ) {
    ?>
    <div class="dv-admin-support-summary">
        <div>
            <h3><?php echo esc_html( dv_theme_options_label( '&#1057;&#1074;&#1086;&#1076;&#1082;&#1072; &#1076;&#1083;&#1103; &#1087;&#1086;&#1076;&#1076;&#1077;&#1088;&#1078;&#1082;&#1080;' ) ); ?></h3>
            <p><?php echo esc_html( dv_theme_options_label( '&#1050;&#1086;&#1088;&#1086;&#1090;&#1082;&#1080;&#1081; &#1090;&#1077;&#1082;&#1089;&#1090;&#1086;&#1074;&#1099;&#1081; &#1089;&#1085;&#1080;&#1084;&#1086;&#1082; &#1074;&#1072;&#1078;&#1085;&#1099;&#1093; &#1089;&#1090;&#1072;&#1090;&#1091;&#1089;&#1086;&#1074;. &#1045;&#1075;&#1086; &#1091;&#1076;&#1086;&#1073;&#1085;&#1086; &#1089;&#1082;&#1086;&#1087;&#1080;&#1088;&#1086;&#1074;&#1072;&#1090;&#1100; &#1074; &#1095;&#1072;&#1090; &#1080;&#1083;&#1080; &#1079;&#1072;&#1076;&#1072;&#1095;&#1091; &#1073;&#1077;&#1079; &#1087;&#1086;&#1083;&#1085;&#1086;&#1075;&#1086; JSON.' ) ); ?></p>
            <button
                type="button"
                class="button button-secondary dv-admin-support-summary-copy"
                data-dv-copy-target="dv-admin-support-summary-text"
                data-dv-copy-label="<?php echo esc_attr( dv_theme_options_label( '&#1057;&#1082;&#1086;&#1087;&#1080;&#1088;&#1086;&#1074;&#1072;&#1090;&#1100;' ) ); ?>"
                data-dv-copied-label="<?php echo esc_attr( dv_theme_options_label( '&#1057;&#1082;&#1086;&#1087;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;&#1086;' ) ); ?>"
            >
                <?php echo esc_html( dv_theme_options_label( '&#1057;&#1082;&#1086;&#1087;&#1080;&#1088;&#1086;&#1074;&#1072;&#1090;&#1100;' ) ); ?>
            </button>
        </div>
        <textarea id="dv-admin-support-summary-text" readonly rows="10"><?php echo esc_textarea( $summary ); ?></textarea>
    </div>
    <?php
}

function dv_render_theme_environment_card( $environment ) {
    $environment = is_array( $environment ) ? $environment : array();
    ?>
    <div class="dv-admin-environment">
        <div>
            <h3><?php echo esc_html( dv_theme_options_label( '&#1054;&#1082;&#1088;&#1091;&#1078;&#1077;&#1085;&#1080;&#1077;' ) ); ?></h3>
            <p><?php echo esc_html( dv_theme_options_label( '&#1050;&#1086;&#1088;&#1086;&#1090;&#1082;&#1080;&#1081; &#1089;&#1088;&#1077;&#1079; &#1074;&#1077;&#1088;&#1089;&#1080;&#1081; WordPress, PHP, WooCommerce, &#1090;&#1077;&#1084;&#1099; &#1080; debug-&#1088;&#1077;&#1078;&#1080;&#1084;&#1072;.' ) ); ?></p>
        </div>
        <div class="dv-admin-environment-grid">
            <?php foreach ( $environment as $item ) : ?>
                <article>
                    <span><?php echo esc_html( $item['label'] ?? '' ); ?></span>
                    <strong><?php echo esc_html( $item['value'] ?? '' ); ?></strong>
                    <small><?php echo esc_html( $item['hint'] ?? '' ); ?></small>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function dv_render_theme_options_diagnostics( $options ) {
    $checks   = dv_theme_diagnostics_checks( $options );
    $snapshot = dv_theme_diagnostics_settings_snapshot( $options );
    $environment = dv_theme_environment_report();
    $audit    = dv_theme_product_audit_report();
    $marketplaces = dv_theme_marketplace_diagnostics_report( $options );
    $profile_health = dv_theme_store_profile_health_report();
    $maintenance = dv_theme_maintenance_report();
    $support_summary = dv_theme_diagnostics_support_summary( $options );
    ?>
    <section class="dv-admin-card dv-admin-diagnostics-card" id="dv-options-diagnostics">
        <h2><?php echo esc_html( dv_theme_options_label( '&#1044;&#1080;&#1072;&#1075;&#1085;&#1086;&#1089;&#1090;&#1080;&#1082;&#1072;' ) ); ?></h2>
        <p><?php echo esc_html( dv_theme_options_label( '&#1041;&#1099;&#1089;&#1090;&#1088;&#1072;&#1103; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1082;&#1072; &#1082;&#1083;&#1102;&#1095;&#1077;&#1074;&#1099;&#1093; &#1091;&#1079;&#1083;&#1086;&#1074; &#1090;&#1077;&#1084;&#1099;: WooCommerce, sitemap, SEO, &#1092;&#1072;&#1081;&#1083;&#1099; &#1080; &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;.' ) ); ?></p>

        <div class="dv-admin-diagnostics-snapshot">
            <h3><?php echo esc_html( dv_theme_options_label( '&#1055;&#1088;&#1080;&#1084;&#1077;&#1085;&#1105;&#1085;&#1085;&#1099;&#1077; &#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080;' ) ); ?></h3>
            <div class="dv-admin-diagnostics-snapshot-grid">
                <?php foreach ( $snapshot as $item ) : ?>
                    <article class="dv-admin-diagnostics-snapshot-item">
                        <span><?php echo esc_html( $item['label'] ); ?></span>
                        <strong><?php echo esc_html( $item['value'] ); ?></strong>
                        <small><?php echo esc_html( $item['hint'] ); ?></small>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="dv-admin-diagnostics-actions dv-suite-action-row">
            <button type="submit" class="button button-primary" form="dv-theme-diagnostics-export">
                <?php echo esc_html( dv_theme_options_label( '&#1057;&#1082;&#1072;&#1095;&#1072;&#1090;&#1100; &#1086;&#1090;&#1095;&#1105;&#1090; &#1076;&#1080;&#1072;&#1075;&#1085;&#1086;&#1089;&#1090;&#1080;&#1082;&#1080;' ) ); ?>
            </button>
        </div>

        <?php dv_render_theme_environment_card( $environment ); ?>

        <?php dv_render_theme_support_summary_card( $support_summary ); ?>

        <?php dv_render_theme_product_audit_card( $audit ); ?>

        <?php dv_render_theme_store_profile_health_card( $profile_health ); ?>

        <?php dv_render_theme_marketplace_diagnostics_card( $marketplaces ); ?>

        <?php dv_render_theme_maintenance_card( $maintenance ); ?>

        <div class="dv-admin-diagnostics-grid">
            <?php foreach ( $checks as $check ) : ?>
                <article class="dv-admin-diagnostic-item<?php echo ! empty( $check['status'] ) ? ' is-ok' : ' is-fail'; ?>">
                    <span class="dv-admin-diagnostic-status">
                        <?php echo ! empty( $check['status'] ) ? esc_html( dv_theme_options_label( '&#1054;&#1050;' ) ) : esc_html( dv_theme_options_label( '&#1042;&#1085;&#1080;&#1084;&#1072;&#1085;&#1080;&#1077;' ) ); ?>
                    </span>
                    <strong><?php echo esc_html( $check['label'] ); ?></strong>
                    <small><?php echo esc_html( ! empty( $check['status'] ) ? $check['ok'] : $check['fail'] ); ?></small>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

function dv_render_theme_options_page() {
    $options = dv_get_theme_options();
    ?>
    <div class="wrap dv-suite-page dv-theme-options-page">
        <?php
        dv_render_admin_suite_header(
            'dv-theme-options',
            dv_theme_options_label( '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1090;&#1077;&#1084;&#1099;' ),
            dv_theme_options_label( '&#1041;&#1099;&#1089;&#1090;&#1088;&#1099;&#1077; &#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1074;&#1080;&#1090;&#1088;&#1080;&#1085;&#1099; &#1080; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1073;&#1077;&#1079; &#1087;&#1088;&#1072;&#1074;&#1082;&#1080; PHP-&#1082;&#1086;&#1076;&#1072;.' )
        );
        ?>

        <?php if ( ! empty( $_GET['settings-updated'] ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html( dv_theme_options_label( '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1077;&#1085;&#1099;.' ) ); ?></p>
            </div>
        <?php endif; ?>
        <?php
        $backup_status = isset( $_GET['theme-backup'] ) ? sanitize_key( wp_unslash( $_GET['theme-backup'] ) ) : '';
        $backup_notice = dv_theme_backup_notice_text( $backup_status );
        ?>
        <?php if ( $backup_notice ) : ?>
            <div class="notice notice-<?php echo esc_attr( $backup_notice[0] ); ?> is-dismissible">
                <p><?php echo esc_html( dv_theme_options_label( $backup_notice[1] ) ); ?></p>
            </div>
        <?php endif; ?>
        <?php
        $reset_status = isset( $_GET['theme-reset'] ) ? sanitize_key( wp_unslash( $_GET['theme-reset'] ) ) : '';
        $reset_notice = dv_theme_reset_notice_text( $reset_status );
        ?>
        <?php if ( $reset_notice ) : ?>
            <div class="notice notice-<?php echo esc_attr( $reset_notice[0] ); ?> is-dismissible">
                <p><?php echo esc_html( dv_theme_options_label( $reset_notice[1] ) ); ?></p>
            </div>
        <?php endif; ?>
        <?php if ( isset( $_GET['product-audit'] ) && 'refreshed' === sanitize_key( wp_unslash( $_GET['product-audit'] ) ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html( dv_theme_options_label( '&#1040;&#1091;&#1076;&#1080;&#1090; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1086;&#1073;&#1085;&#1086;&#1074;&#1083;&#1105;&#1085;.' ) ); ?></p>
            </div>
        <?php endif; ?>
        <?php if ( isset( $_GET['product-audit'] ) && 'image-alt-filled' === sanitize_key( wp_unslash( $_GET['product-audit'] ) ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <?php
                    echo esc_html(
                        sprintf(
                            /* translators: %d: updated images count. */
                            dv_theme_options_label( '&#1047;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085; alt &#1091; &#1092;&#1086;&#1090;&#1086;: %d.' ),
                            absint( $_GET['alt-updated'] ?? 0 )
                        )
                    );
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <?php if ( isset( $_GET['product-audit'] ) && 'excerpt-filled' === sanitize_key( wp_unslash( $_GET['product-audit'] ) ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <?php
                    echo esc_html(
                        sprintf(
                            /* translators: %d: updated products count. */
                            dv_theme_options_label( '&#1050;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;&#1086; &#1091; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;: %d.' ),
                            absint( $_GET['excerpt-updated'] ?? 0 )
                        )
                    );
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <?php if ( isset( $_GET['service-cache'] ) && 'cleared' === sanitize_key( wp_unslash( $_GET['service-cache'] ) ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html( dv_theme_options_label( '&#1057;&#1083;&#1091;&#1078;&#1077;&#1073;&#1085;&#1099;&#1077; &#1082;&#1101;&#1096;&#1080; &#1086;&#1095;&#1080;&#1097;&#1077;&#1085;&#1099;: dashboard, &#1072;&#1091;&#1076;&#1080;&#1090; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1080; sitemap.' ) ); ?></p>
            </div>
        <?php endif; ?>
        <?php if ( isset( $_GET['search-index'] ) && 'rebuilt' === sanitize_key( wp_unslash( $_GET['search-index'] ) ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html( dv_theme_options_label( '&#1048;&#1085;&#1076;&#1077;&#1082;&#1089; &#1087;&#1086;&#1080;&#1089;&#1082;&#1072; &#1087;&#1077;&#1088;&#1077;&#1089;&#1086;&#1073;&#1088;&#1072;&#1085;.' ) ); ?></p>
            </div>
        <?php endif; ?>
        <?php if ( isset( $_GET['settings-history'] ) && 'cleared' === sanitize_key( wp_unslash( $_GET['settings-history'] ) ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html( dv_theme_options_label( '&#1048;&#1089;&#1090;&#1086;&#1088;&#1080;&#1103; &#1080;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1080;&#1081; &#1086;&#1095;&#1080;&#1097;&#1077;&#1085;&#1072;.' ) ); ?></p>
            </div>
        <?php endif; ?>

        <?php dv_render_theme_options_overview( $options ); ?>

        <form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=dv-theme-options' ) ); ?>" data-dv-unsaved-form>
            <?php wp_nonce_field( 'dv_save_theme_options' ); ?>
            <input type="hidden" name="dv_theme_options_action" value="save">

            <div class="dv-admin-shell">
            <div class="dv-admin-toolbar">
                <div class="dv-admin-settings-search">
                    <label for="dv-theme-options-search"><?php echo esc_html( dv_theme_options_label( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1085;&#1072;&#1089;&#1090;&#1088;&#1086;&#1077;&#1082;' ) ); ?></label>
                    <div class="dv-admin-settings-search-row">
                        <input
                            type="search"
                            id="dv-theme-options-search"
                            placeholder="<?php echo esc_attr( dv_theme_options_label( '&#1053;&#1072;&#1081;&#1090;&#1080;: Ozon, &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1072;, 404...' ) ); ?>"
                            data-count-label="<?php echo esc_attr( dv_theme_options_label( '&#1053;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;' ) ); ?>"
                            data-empty-text="<?php echo esc_attr( dv_theme_options_label( '&#1053;&#1080;&#1095;&#1077;&#1075;&#1086; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;' ) ); ?>"
                        >
                        <button type="button" id="dv-theme-options-search-clear" aria-label="<?php echo esc_attr( dv_theme_options_label( '&#1054;&#1095;&#1080;&#1089;&#1090;&#1080;&#1090;&#1100; &#1087;&#1086;&#1080;&#1089;&#1082;' ) ); ?>">&times;</button>
                    </div>
                    <p class="dv-admin-settings-search-count" id="dv-theme-options-search-count"></p>
                </div>
                <div class="dv-admin-nav">
                    <a href="#dv-options-visual"><?php echo esc_html( dv_theme_options_label( '&#1042;&#1080;&#1079;&#1091;&#1072;&#1083;&#1100;&#1085;&#1099;&#1081; &#1089;&#1090;&#1080;&#1083;&#1100;' ) ); ?></a>
                    <a href="#dv-options-catalog"><?php echo esc_html( dv_theme_options_label( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;' ) ); ?></a>
                    <a href="#dv-options-catalog-card"><?php echo esc_html( dv_theme_options_label( '&#1050;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1072; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1077;' ) ); ?></a>
                    <a href="#dv-options-home"><?php echo esc_html( dv_theme_options_label( '&#1043;&#1083;&#1072;&#1074;&#1085;&#1072;&#1103;' ) ); ?></a>
                    <a href="#dv-options-search"><?php echo esc_html( dv_theme_options_label( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1080; 404' ) ); ?></a>
                    <a href="#dv-options-footer"><?php echo esc_html( dv_theme_options_label( '&#1060;&#1091;&#1090;&#1077;&#1088;' ) ); ?></a>
                    <a href="#dv-options-cart"><?php echo esc_html( dv_theme_options_label( '&#1050;&#1086;&#1088;&#1079;&#1080;&#1085;&#1072;' ) ); ?></a>
                    <a href="#dv-options-checkout">Checkout</a>
                    <a href="#dv-options-product"><?php echo esc_html( dv_theme_options_label( '&#1050;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1072; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;' ) ); ?></a>
                    <a href="#dv-options-service"><?php echo esc_html( dv_theme_options_label( '&#1057;&#1077;&#1088;&#1074;&#1080;&#1089;&#1085;&#1099;&#1077;' ) ); ?></a>
                    <a href="#dv-options-diagnostics"><?php echo esc_html( dv_theme_options_label( '&#1044;&#1080;&#1072;&#1075;&#1085;&#1086;&#1089;&#1090;&#1080;&#1082;&#1072;' ) ); ?></a>
                    <a href="#dv-options-backup"><?php echo esc_html( dv_theme_options_label( '&#1056;&#1077;&#1079;&#1077;&#1088;&#1074;' ) ); ?></a>
                </div>
                <div class="dv-admin-save-cluster">
                    <span class="dv-admin-unsaved-indicator" role="status" aria-live="polite" hidden>
                        <?php echo esc_html( dv_theme_options_label( '&#1045;&#1089;&#1090;&#1100; &#1085;&#1077;&#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1077;&#1085;&#1085;&#1099;&#1077; &#1080;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1080;&#1103;' ) ); ?>
                    </span>
                    <?php submit_button( dv_theme_options_label( '&#1057;&#1086;&#1093;&#1088;&#1072;&#1085;&#1080;&#1090;&#1100;' ), 'primary', 'submit', false ); ?>
                </div>
            </div>

            <div class="dv-admin-grid">
                <section class="dv-admin-card" id="dv-options-visual">
                    <h2><?php echo esc_html( dv_theme_options_label( '&#1042;&#1080;&#1079;&#1091;&#1072;&#1083;&#1100;&#1085;&#1099;&#1081; &#1089;&#1090;&#1080;&#1083;&#1100;' ) ); ?></h2>
                    <div class="dv-admin-visual-grid">
                    <?php
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_visual_preset',
                        dv_theme_options_label( '&#1055;&#1088;&#1077;&#1089;&#1077;&#1090; &#1090;&#1077;&#1084;&#1099;' ),
                        dv_theme_options_label( '&#1052;&#1077;&#1085;&#1103;&#1077;&#1090; &#1094;&#1074;&#1077;&#1090;&#1086;&#1074;&#1086;&#1081; &#1072;&#1082;&#1094;&#1077;&#1085;&#1090;, &#1092;&#1086;&#1085; &#1080; &#1082;&#1086;&#1085;&#1090;&#1088;&#1072;&#1089;&#1090; &#1095;&#1077;&#1088;&#1077;&#1079; CSS-&#1087;&#1077;&#1088;&#1077;&#1084;&#1077;&#1085;&#1085;&#1099;&#1077; &#1073;&#1077;&#1079; &#1087;&#1088;&#1072;&#1074;&#1082;&#1080; &#1096;&#1072;&#1073;&#1083;&#1086;&#1085;&#1086;&#1074;.' ),
                        array(
                            'default'  => dv_theme_options_label( '&#1060;&#1080;&#1088;&#1084;&#1077;&#1085;&#1085;&#1099;&#1081; &#1089;&#1080;&#1085;&#1080;&#1081;' ),
                            'contrast' => dv_theme_options_label( '&#1050;&#1086;&#1085;&#1090;&#1088;&#1072;&#1089;&#1090;&#1085;&#1099;&#1081;' ),
                            'soft'     => dv_theme_options_label( '&#1052;&#1103;&#1075;&#1082;&#1080;&#1081;' ),
                            'graphite' => dv_theme_options_label( '&#1043;&#1088;&#1072;&#1092;&#1080;&#1090;' ),
                            'ozon'     => 'Ozon-like',
                            'market'   => dv_theme_options_label( '&#1071;&#1085;&#1076;&#1077;&#1082;&#1089; &#1052;&#1072;&#1088;&#1082;&#1077;&#1090;' ),
                            'wildberries' => 'Wildberries-like',
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_color_scheme',
                        dv_theme_options_label( '&#1062;&#1074;&#1077;&#1090;&#1086;&#1074;&#1072;&#1103; &#1089;&#1093;&#1077;&#1084;&#1072;' ),
                        dv_theme_options_label( '&#1052;&#1077;&#1085;&#1103;&#1077;&#1090; &#1090;&#1086;&#1083;&#1100;&#1082;&#1086; &#1087;&#1072;&#1083;&#1080;&#1090;&#1088;&#1091;: &#1072;&#1082;&#1094;&#1077;&#1085;&#1090;, &#1092;&#1086;&#1085;, &#1082;&#1085;&#1086;&#1087;&#1082;&#1080; &#1080; &#1089;&#1086;&#1089;&#1090;&#1086;&#1103;&#1085;&#1080;&#1103;. &#1056;&#1072;&#1089;&#1082;&#1083;&#1072;&#1076;&#1082;&#1072; &#1086;&#1089;&#1090;&#1072;&#1105;&#1090;&#1089;&#1103; &#1086;&#1090; &#1087;&#1088;&#1077;&#1089;&#1077;&#1090;&#1072;.' ),
                        array(
                            'preset'   => dv_theme_options_label( '&#1050;&#1072;&#1082; &#1074; &#1087;&#1088;&#1077;&#1089;&#1077;&#1090;&#1077;' ),
                            'default'  => dv_theme_options_label( '&#1060;&#1080;&#1088;&#1084;&#1077;&#1085;&#1085;&#1099;&#1081; &#1089;&#1080;&#1085;&#1080;&#1081;' ),
                            'contrast' => dv_theme_options_label( '&#1050;&#1086;&#1085;&#1090;&#1088;&#1072;&#1089;&#1090;&#1085;&#1099;&#1081;' ),
                            'soft'     => dv_theme_options_label( '&#1052;&#1103;&#1075;&#1082;&#1080;&#1081;' ),
                            'graphite' => dv_theme_options_label( '&#1043;&#1088;&#1072;&#1092;&#1080;&#1090;' ),
                            'ozon'     => 'Ozon-like',
                            'market'   => dv_theme_options_label( '&#1071;&#1085;&#1076;&#1077;&#1082;&#1089; &#1052;&#1072;&#1088;&#1082;&#1077;&#1090;' ),
                            'wildberries' => 'Wildberries-like',
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_radius_style',
                        dv_theme_options_label( '&#1057;&#1082;&#1088;&#1091;&#1075;&#1083;&#1077;&#1085;&#1080;&#1103;' ),
                        dv_theme_options_label( '&#1052;&#1077;&#1085;&#1103;&#1077;&#1090; &#1088;&#1072;&#1076;&#1080;&#1091;&#1089;&#1099; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1077;&#1082;, &#1087;&#1086;&#1083;&#1077;&#1081;, &#1082;&#1085;&#1086;&#1087;&#1086;&#1082; &#1080; &#1087;&#1072;&#1085;&#1077;&#1083;&#1077;&#1081; &#1074;&#1080;&#1090;&#1088;&#1080;&#1085;&#1099;.' ),
                        array(
                            'sharp' => dv_theme_options_label( '&#1057;&#1090;&#1088;&#1086;&#1075;&#1080;&#1077;' ),
                            'soft'  => dv_theme_options_label( '&#1052;&#1103;&#1075;&#1082;&#1080;&#1077;' ),
                            'round' => dv_theme_options_label( '&#1054;&#1082;&#1088;&#1091;&#1075;&#1083;&#1099;&#1077;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_layout_width',
                        dv_theme_options_label( '&#1064;&#1080;&#1088;&#1080;&#1085;&#1072; &#1074;&#1080;&#1090;&#1088;&#1080;&#1085;&#1099;' ),
                        dv_theme_options_label( '&#1056;&#1072;&#1089;&#1096;&#1080;&#1088;&#1103;&#1077;&#1090; &#1082;&#1086;&#1085;&#1090;&#1077;&#1081;&#1085;&#1077;&#1088; &#1096;&#1072;&#1087;&#1082;&#1080;, &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072;, &#1092;&#1091;&#1090;&#1077;&#1088;&#1072; &#1080; &#1086;&#1089;&#1085;&#1086;&#1074;&#1085;&#1099;&#1093; &#1089;&#1077;&#1082;&#1094;&#1080;&#1081; &#1085;&#1072; &#1073;&#1086;&#1083;&#1100;&#1096;&#1080;&#1093; &#1084;&#1086;&#1085;&#1080;&#1090;&#1086;&#1088;&#1072;&#1093;.' ),
                        array(
                            'contained' => dv_theme_options_label( '&#1057;&#1090;&#1072;&#1085;&#1076;&#1072;&#1088;&#1090;&#1085;&#1072;&#1103;' ),
                            'wide'      => dv_theme_options_label( '&#1064;&#1080;&#1088;&#1086;&#1082;&#1072;&#1103;' ),
                            'fluid'     => dv_theme_options_label( '&#1055;&#1086;&#1095;&#1090;&#1080; &#1074;&#1086; &#1074;&#1089;&#1102; &#1096;&#1080;&#1088;&#1080;&#1085;&#1091;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_density_style',
                        dv_theme_options_label( '&#1055;&#1083;&#1086;&#1090;&#1085;&#1086;&#1089;&#1090;&#1100; &#1080;&#1085;&#1090;&#1077;&#1088;&#1092;&#1077;&#1081;&#1089;&#1072;' ),
                        dv_theme_options_label( '&#1059;&#1087;&#1088;&#1072;&#1074;&#1083;&#1103;&#1077;&#1090; &#1086;&#1090;&#1089;&#1090;&#1091;&#1087;&#1072;&#1084;&#1080; &#1074; &#1096;&#1072;&#1087;&#1082;&#1077;, &#1092;&#1091;&#1090;&#1077;&#1088;&#1077;, &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1072;&#1093; &#1080; &#1090;&#1086;&#1074;&#1072;&#1088;&#1085;&#1099;&#1093; &#1073;&#1083;&#1086;&#1082;&#1072;&#1093;.' ),
                        array(
                            'compact'  => dv_theme_options_label( '&#1050;&#1086;&#1084;&#1087;&#1072;&#1082;&#1090;&#1085;&#1072;&#1103;' ),
                            'balanced' => dv_theme_options_label( '&#1057;&#1073;&#1072;&#1083;&#1072;&#1085;&#1089;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;&#1085;&#1072;&#1103;' ),
                            'air'      => dv_theme_options_label( '&#1042;&#1086;&#1079;&#1076;&#1091;&#1096;&#1085;&#1072;&#1103;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_shadow_style',
                        dv_theme_options_label( '&#1058;&#1077;&#1085;&#1080;' ),
                        dv_theme_options_label( '&#1059;&#1089;&#1080;&#1083;&#1080;&#1074;&#1072;&#1077;&#1090; &#1080;&#1083;&#1080; &#1091;&#1073;&#1080;&#1088;&#1072;&#1077;&#1090; &#1090;&#1077;&#1085;&#1080; &#1091; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1077;&#1082;, &#1087;&#1072;&#1085;&#1077;&#1083;&#1077;&#1081; &#1080; &#1074;&#1099;&#1087;&#1072;&#1076;&#1072;&#1102;&#1097;&#1080;&#1093; &#1073;&#1083;&#1086;&#1082;&#1086;&#1074;.' ),
                        array(
                            'none' => dv_theme_options_label( '&#1041;&#1077;&#1079; &#1090;&#1077;&#1085;&#1077;&#1081;' ),
                            'soft' => dv_theme_options_label( '&#1052;&#1103;&#1075;&#1082;&#1080;&#1077;' ),
                            'deep' => dv_theme_options_label( '&#1043;&#1083;&#1091;&#1073;&#1086;&#1082;&#1080;&#1077;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_header_style',
                        dv_theme_options_label( '&#1064;&#1072;&#1087;&#1082;&#1072;' ),
                        dv_theme_options_label( '&#1052;&#1077;&#1085;&#1103;&#1077;&#1090; &#1074;&#1099;&#1089;&#1086;&#1090;&#1091; &#1096;&#1072;&#1087;&#1082;&#1080; &#1080; &#1087;&#1088;&#1080;&#1086;&#1088;&#1080;&#1090;&#1077;&#1090; &#1087;&#1086;&#1080;&#1089;&#1082;&#1086;&#1074;&#1086;&#1081; &#1089;&#1090;&#1088;&#1086;&#1082;&#1080; &#1085;&#1072; desktop.' ),
                        array(
                            'compact'     => dv_theme_options_label( '&#1050;&#1086;&#1084;&#1087;&#1072;&#1082;&#1090;&#1085;&#1072;&#1103;' ),
                            'balanced'    => dv_theme_options_label( '&#1057;&#1073;&#1072;&#1083;&#1072;&#1085;&#1089;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;&#1085;&#1072;&#1103;' ),
                            'wide-search' => dv_theme_options_label( '&#1064;&#1080;&#1088;&#1086;&#1082;&#1080;&#1081; &#1087;&#1086;&#1080;&#1089;&#1082;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_footer_style',
                        dv_theme_options_label( '&#1060;&#1091;&#1090;&#1077;&#1088;' ),
                        dv_theme_options_label( '&#1056;&#1077;&#1075;&#1091;&#1083;&#1080;&#1088;&#1091;&#1077;&#1090; &#1074;&#1077;&#1088;&#1090;&#1080;&#1082;&#1072;&#1083;&#1100;&#1085;&#1099;&#1077; &#1086;&#1090;&#1089;&#1090;&#1091;&#1087;&#1099; &#1080; &#1088;&#1072;&#1089;&#1089;&#1090;&#1086;&#1103;&#1085;&#1080;&#1103; &#1084;&#1077;&#1078;&#1076;&#1091; &#1082;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072;&#1084;&#1080; &#1092;&#1091;&#1090;&#1077;&#1088;&#1072;.' ),
                        array(
                            'compact'  => dv_theme_options_label( '&#1050;&#1086;&#1084;&#1087;&#1072;&#1082;&#1090;&#1085;&#1099;&#1081;' ),
                            'standard' => dv_theme_options_label( '&#1057;&#1090;&#1072;&#1085;&#1076;&#1072;&#1088;&#1090;&#1085;&#1099;&#1081;' ),
                            'spacious' => dv_theme_options_label( '&#1055;&#1088;&#1086;&#1089;&#1090;&#1086;&#1088;&#1085;&#1099;&#1081;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_card_style',
                        dv_theme_options_label( '&#1050;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;' ),
                        dv_theme_options_label( '&#1052;&#1077;&#1085;&#1103;&#1077;&#1090; &#1087;&#1083;&#1086;&#1090;&#1085;&#1086;&#1089;&#1090;&#1100; &#1080; &#1072;&#1082;&#1094;&#1077;&#1085;&#1090; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1077;&#1082; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1077; &#1080; &#1090;&#1086;&#1074;&#1072;&#1088;&#1085;&#1099;&#1093; &#1089;&#1077;&#1090;&#1082;&#1072;&#1093;.' ),
                        array(
                            'standard' => dv_theme_options_label( '&#1057;&#1090;&#1072;&#1085;&#1076;&#1072;&#1088;&#1090;&#1085;&#1099;&#1077;' ),
                            'compact'  => dv_theme_options_label( '&#1050;&#1086;&#1084;&#1087;&#1072;&#1082;&#1090;&#1085;&#1099;&#1077;' ),
                            'showcase' => dv_theme_options_label( '&#1042;&#1080;&#1090;&#1088;&#1080;&#1085;&#1085;&#1099;&#1077;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_card_image_ratio',
                        dv_theme_options_label( '&#1060;&#1086;&#1090;&#1086; &#1074; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1077;' ),
                        dv_theme_options_label( '&#1042;&#1099;&#1073;&#1080;&#1088;&#1072;&#1077;&#1090; &#1087;&#1088;&#1086;&#1087;&#1086;&#1088;&#1094;&#1080;&#1080; &#1079;&#1086;&#1085;&#1099; &#1080;&#1079;&#1086;&#1073;&#1088;&#1072;&#1078;&#1077;&#1085;&#1080;&#1103; &#1074; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' ),
                        array(
                            'square'   => dv_theme_options_label( '&#1050;&#1074;&#1072;&#1076;&#1088;&#1072;&#1090;&#1085;&#1086;&#1077;' ),
                            'portrait' => dv_theme_options_label( '&#1042;&#1077;&#1088;&#1090;&#1080;&#1082;&#1072;&#1083;&#1100;&#1085;&#1086;&#1077;' ),
                            'wide'     => dv_theme_options_label( '&#1064;&#1080;&#1088;&#1086;&#1082;&#1086;&#1077;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_card_image_padding',
                        dv_theme_options_label( '&#1054;&#1090;&#1089;&#1090;&#1091;&#1087; &#1092;&#1086;&#1090;&#1086;' ),
                        dv_theme_options_label( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1083;&#1103;&#1077;&#1090; &#1073;&#1077;&#1079;&#1086;&#1087;&#1072;&#1089;&#1085;&#1099;&#1081; &#1074;&#1085;&#1091;&#1090;&#1088;&#1077;&#1085;&#1085;&#1080;&#1081; &#1086;&#1090;&#1089;&#1090;&#1091;&#1087; &#1074;&#1086;&#1082;&#1088;&#1091;&#1075; &#1090;&#1086;&#1074;&#1072;&#1088;&#1085;&#1086;&#1075;&#1086; &#1092;&#1086;&#1090;&#1086;, &#1095;&#1090;&#1086;&#1073;&#1099; &#1087;&#1086;&#1076;&#1087;&#1080;&#1089;&#1080; &#1080; &#1088;&#1072;&#1079;&#1084;&#1077;&#1088;&#1099; &#1087;&#1086; &#1082;&#1088;&#1072;&#1103;&#1084; &#1085;&#1077; &#1087;&#1088;&#1080;&#1078;&#1080;&#1084;&#1072;&#1083;&#1080;&#1089;&#1100; &#1082; &#1088;&#1072;&#1084;&#1082;&#1077;.' ),
                        array(
                            'tight'    => dv_theme_options_label( '&#1055;&#1083;&#1086;&#1090;&#1085;&#1099;&#1081;' ),
                            'balanced' => dv_theme_options_label( '&#1057;&#1090;&#1072;&#1085;&#1076;&#1072;&#1088;&#1090;&#1085;&#1099;&#1081;' ),
                            'safe'     => dv_theme_options_label( '&#1041;&#1077;&#1088;&#1077;&#1078;&#1085;&#1099;&#1081;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_card_hover_style',
                        dv_theme_options_label( '&#1053;&#1072;&#1074;&#1077;&#1076;&#1077;&#1085;&#1080;&#1077; &#1085;&#1072; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1091;' ),
                        dv_theme_options_label( '&#1059;&#1087;&#1088;&#1072;&#1074;&#1083;&#1103;&#1077;&#1090; &#1087;&#1086;&#1076;&#1098;&#1105;&#1084;&#1086;&#1084; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080; &#1080; &#1079;&#1091;&#1084;&#1086;&#1084; &#1092;&#1086;&#1090;&#1086; &#1087;&#1088;&#1080; &#1085;&#1072;&#1074;&#1077;&#1076;&#1077;&#1085;&#1080;&#1080;.' ),
                        array(
                            'none' => dv_theme_options_label( '&#1041;&#1077;&#1079; &#1076;&#1074;&#1080;&#1078;&#1077;&#1085;&#1080;&#1103;' ),
                            'soft' => dv_theme_options_label( '&#1051;&#1105;&#1075;&#1082;&#1086;&#1077;' ),
                            'lift' => dv_theme_options_label( '&#1047;&#1072;&#1084;&#1077;&#1090;&#1085;&#1086;&#1077;' ),
                        )
                    );
                    dv_render_theme_options_select_field(
                        $options,
                        'theme_card_title_lines',
                        dv_theme_options_label( '&#1053;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077; &#1074; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1077;' ),
                        dv_theme_options_label( '&#1059;&#1087;&#1088;&#1072;&#1074;&#1083;&#1103;&#1077;&#1090; &#1082;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086;&#1084; &#1089;&#1090;&#1088;&#1086;&#1082; &#1085;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1103; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1076;&#1086; &#1086;&#1073;&#1088;&#1077;&#1079;&#1082;&#1080;. &#1041;&#1086;&#1083;&#1100;&#1096;&#1077; &#1089;&#1090;&#1088;&#1086;&#1082; &#8212; &#1084;&#1077;&#1085;&#1100;&#1096;&#1077; &#1087;&#1086;&#1090;&#1077;&#1088;&#1103;&#1085;&#1085;&#1086;&#1075;&#1086; &#1089;&#1084;&#1099;&#1089;&#1083;&#1072;, &#1084;&#1077;&#1085;&#1100;&#1096;&#1077; &#1089;&#1090;&#1088;&#1086;&#1082; &#8212; &#1088;&#1086;&#1074;&#1085;&#1077;&#1077; &#1080; &#1082;&#1086;&#1084;&#1087;&#1072;&#1082;&#1090;&#1085;&#1077;&#1077; &#1089;&#1077;&#1090;&#1082;&#1072;.' ),
                        array(
                            'two'   => dv_theme_options_label( '2 &#1089;&#1090;&#1088;&#1086;&#1082;&#1080;' ),
                            'three' => dv_theme_options_label( '3 &#1089;&#1090;&#1088;&#1086;&#1082;&#1080;' ),
                            'four'  => dv_theme_options_label( '4 &#1089;&#1090;&#1088;&#1086;&#1082;&#1080;' ),
                        )
                    );
                    ?>
                    </div>
                    <?php dv_render_theme_options_visual_preview( $options ); ?>
                </section>

                <section class="dv-admin-card" id="dv-options-catalog">
                    <h2><?php echo esc_html( dv_theme_options_label( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;' ) ); ?></h2>
                    <?php
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_topbar_enabled',
                        dv_theme_options_label( '&#1042;&#1077;&#1088;&#1093;&#1085;&#1103;&#1103; &#1087;&#1086;&#1083;&#1086;&#1089;&#1072; &#1096;&#1072;&#1087;&#1082;&#1080;' ),
                        dv_theme_options_label( '&#1043;&#1086;&#1088;&#1086;&#1076;, &#1089;&#1089;&#1099;&#1083;&#1082;&#1080; &#1080; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085; &#1074; &#1095;&#1105;&#1088;&#1085;&#1086;&#1084; topbar.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'topbar_city_enabled',
                        dv_theme_options_label( 'Topbar: &#1075;&#1086;&#1088;&#1086;&#1076;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1083;&#1086;&#1082;&#1072;&#1094;&#1080;&#1102; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072; &#1074; &#1074;&#1077;&#1088;&#1093;&#1085;&#1077;&#1081; &#1087;&#1086;&#1083;&#1086;&#1089;&#1077;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'topbar_phone_enabled',
                        dv_theme_options_label( 'Topbar: &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085; &#1089;&#1087;&#1088;&#1072;&#1074;&#1072; &#1074; &#1074;&#1077;&#1088;&#1093;&#1085;&#1077;&#1081; &#1087;&#1086;&#1083;&#1086;&#1089;&#1077;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'topbar_shop_enabled',
                        dv_theme_options_label( 'Topbar: &#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;' ),
                        dv_theme_options_label( '&#1054;&#1090;&#1076;&#1077;&#1083;&#1100;&#1085;&#1086; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1080;&#1083;&#1080; &#1089;&#1082;&#1088;&#1099;&#1074;&#1072;&#1077;&#1090; &#1089;&#1089;&#1099;&#1083;&#1082;&#1091; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072; &#1074; topbar.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'topbar_delivery_enabled',
                        dv_theme_options_label( 'Topbar: &#1044;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1089;&#1089;&#1099;&#1083;&#1082;&#1091; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1080;, &#1077;&#1089;&#1083;&#1080; &#1089;&#1072;&#1084;&#1072; &#1089;&#1077;&#1088;&#1074;&#1080;&#1089;&#1085;&#1072;&#1103; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1072; &#1074;&#1082;&#1083;&#1102;&#1095;&#1077;&#1085;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'topbar_about_enabled',
                        dv_theme_options_label( 'Topbar: &#1054; &#1082;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1080;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1089;&#1089;&#1099;&#1083;&#1082;&#1091; &#1085;&#1072; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1091; &#1086; &#1082;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1080;, &#1077;&#1089;&#1083;&#1080; &#1101;&#1090;&#1072; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1072; &#1072;&#1082;&#1090;&#1080;&#1074;&#1085;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'topbar_contacts_enabled',
                        dv_theme_options_label( 'Topbar: &#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1089;&#1089;&#1099;&#1083;&#1082;&#1091; &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1086;&#1074;, &#1077;&#1089;&#1083;&#1080; &#1089;&#1077;&#1088;&#1074;&#1080;&#1089;&#1085;&#1072;&#1103; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1072; &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1086;&#1074; &#1074;&#1082;&#1083;&#1102;&#1095;&#1077;&#1085;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_search_enabled',
                        dv_theme_options_label( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1074; &#1096;&#1072;&#1087;&#1082;&#1077;' ),
                        dv_theme_options_label( '&#1054;&#1089;&#1085;&#1086;&#1074;&#1085;&#1072;&#1103; &#1089;&#1090;&#1088;&#1086;&#1082;&#1072; live-search &#1088;&#1103;&#1076;&#1086;&#1084; &#1089; &#1083;&#1086;&#1075;&#1086;&#1090;&#1080;&#1087;&#1086;&#1084;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_actions_enabled',
                        dv_theme_options_label( '&#1048;&#1082;&#1086;&#1085;&#1082;&#1080; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103;, &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086;, &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1099; &#1080; &#1082;&#1072;&#1073;&#1080;&#1085;&#1077;&#1090;&#1072;' ),
                        dv_theme_options_label( '&#1055;&#1088;&#1072;&#1074;&#1099;&#1081; &#1073;&#1083;&#1086;&#1082; &#1073;&#1099;&#1089;&#1090;&#1088;&#1099;&#1093; &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1081; &#1074; &#1096;&#1072;&#1087;&#1082;&#1077;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_compare_enabled',
                        dv_theme_options_label( 'Иконка сравнения' ),
                        dv_theme_options_label( 'Показывает ссылку на сравнение и preview при наведении.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_wishlist_enabled',
                        dv_theme_options_label( 'Иконка избранного' ),
                        dv_theme_options_label( 'Показывает ссылку на избранное и preview при наведении.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_cart_enabled',
                        dv_theme_options_label( 'Иконка корзины' ),
                        dv_theme_options_label( 'Показывает корзину, сумму и mini-cart preview.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_ozon_enabled',
                        dv_theme_options_label( 'Иконка Ozon' ),
                        dv_theme_options_label( 'Показывает в шапке только иконку со ссылкой на магазин Ozon.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_account_enabled',
                        dv_theme_options_label( 'Иконка кабинета' ),
                        dv_theme_options_label( 'Показывает ссылку входа, регистрации или личного кабинета.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_catalog_dropdown_enabled',
                        dv_theme_options_label( '&#1050;&#1085;&#1086;&#1087;&#1082;&#1072; "&#1042;&#1089;&#1077; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;"' ),
                        dv_theme_options_label( '&#1042;&#1099;&#1087;&#1072;&#1076;&#1072;&#1102;&#1097;&#1077;&#1077; &#1076;&#1077;&#1088;&#1077;&#1074;&#1086; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1074; &#1096;&#1072;&#1087;&#1082;&#1077;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'header_nav_links_enabled',
                        dv_theme_options_label( '&#1057;&#1089;&#1099;&#1083;&#1082;&#1080; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1074; &#1085;&#1080;&#1078;&#1085;&#1077;&#1084; &#1084;&#1077;&#1085;&#1102;' ),
                        dv_theme_options_label( '&#1050;&#1086;&#1088;&#1085;&#1077;&#1074;&#1099;&#1077; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080; &#1088;&#1103;&#1076;&#1086;&#1084; &#1089; &#1082;&#1085;&#1086;&#1087;&#1082;&#1086;&#1081; "&#1042;&#1089;&#1077; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;".' )
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'catalog_per_page',
                        dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1085;&#1072; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1077;' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1077;&#1082; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1077; &#1080; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1103;&#1093;.' ),
                        1,
                        96
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'catalog_columns',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1086;&#1085;&#1086;&#1082; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072;' ),
                        dv_theme_options_label( '&#1059;&#1087;&#1088;&#1072;&#1074;&#1083;&#1103;&#1077;&#1090; CSS-&#1089;&#1077;&#1090;&#1082;&#1086;&#1081; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072; &#1085;&#1072; desktop. &#1053;&#1072; mobile &#1090;&#1077;&#1084;&#1072; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1103;&#1077;&#1090; &#1082;&#1086;&#1084;&#1087;&#1072;&#1082;&#1090;&#1085;&#1091;&#1102; &#1089;&#1077;&#1090;&#1082;&#1091;.' ),
                        2,
                        6
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'header_categories_limit',
                        dv_theme_options_label( '&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1074; &#1084;&#1077;&#1085;&#1102; &#1096;&#1072;&#1087;&#1082;&#1080;' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1082;&#1086;&#1088;&#1085;&#1077;&#1074;&#1099;&#1093; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; &#1088;&#1103;&#1076;&#1086;&#1084; &#1089; "&#1042;&#1089;&#1077; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;". 0 &#1089;&#1082;&#1088;&#1086;&#1077;&#1090; &#1101;&#1090;&#1080; &#1089;&#1089;&#1099;&#1083;&#1082;&#1080;.' ),
                        0,
                        16
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'footer_categories_limit',
                        dv_theme_options_label( '&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1074; &#1092;&#1091;&#1090;&#1077;&#1088;&#1077;' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1074;&#1099;&#1074;&#1086;&#1076;&#1080;&#1090;&#1100; &#1074; &#1082;&#1086;&#1083;&#1086;&#1085;&#1082;&#1077; "&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;". 0 &#1089;&#1082;&#1088;&#1086;&#1077;&#1090; &#1089;&#1087;&#1080;&#1089;&#1086;&#1082;.' ),
                        0,
                        16
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'catalog_marka_limit',
                        dv_theme_options_label( '&#1051;&#1080;&#1084;&#1080;&#1090; &#1074; &#1092;&#1080;&#1083;&#1100;&#1090;&#1088;&#1077; "&#1052;&#1072;&#1088;&#1082;&#1072; &#1058;&#1057;"' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1084;&#1072;&#1088;&#1086;&#1082; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; &#1074; sidebar &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072;.' ),
                        1,
                        80
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'catalog_category_limit',
                        dv_theme_options_label( '&#1051;&#1080;&#1084;&#1080;&#1090; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1074; sidebar' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1088;&#1072;&#1079;&#1076;&#1077;&#1083;&#1086;&#1074; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; &#1085;&#1072; &#1086;&#1073;&#1097;&#1077;&#1084; &#1101;&#1082;&#1088;&#1072;&#1085;&#1077; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072;.' ),
                        1,
                        40
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_path_enabled',
                        dv_theme_options_label( '&#1041;&#1083;&#1086;&#1082; "&#1042;&#1099; &#1079;&#1076;&#1077;&#1089;&#1100;"' ),
                        dv_theme_options_label( '&#1062;&#1077;&#1087;&#1086;&#1095;&#1082;&#1072; &#1090;&#1077;&#1082;&#1091;&#1097;&#1077;&#1075;&#1086; &#1088;&#1072;&#1079;&#1076;&#1077;&#1083;&#1072; &#1074; sidebar &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_marka_enabled',
                        dv_theme_options_label( '&#1060;&#1080;&#1083;&#1100;&#1090;&#1088; "&#1052;&#1072;&#1088;&#1082;&#1072; &#1058;&#1057;"' ),
                        dv_theme_options_label( '&#1041;&#1083;&#1086;&#1082; &#1074;&#1099;&#1073;&#1086;&#1088;&#1072; &#1084;&#1072;&#1088;&#1082;&#1080; &#1072;&#1074;&#1090;&#1086; &#1074; sidebar.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_categories_enabled',
                        dv_theme_options_label( '&#1041;&#1083;&#1086;&#1082; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; / &#1087;&#1086;&#1076;&#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081;' ),
                        dv_theme_options_label( '&#1057;&#1087;&#1080;&#1089;&#1086;&#1082; &#1088;&#1072;&#1079;&#1076;&#1077;&#1083;&#1086;&#1074;, &#1089;&#1086;&#1089;&#1077;&#1076;&#1085;&#1080;&#1093; &#1088;&#1072;&#1079;&#1076;&#1077;&#1083;&#1086;&#1074; &#1080;&#1083;&#1080; &#1087;&#1086;&#1076;&#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_price_enabled',
                        dv_theme_options_label( '&#1060;&#1080;&#1083;&#1100;&#1090;&#1088; &#1094;&#1077;&#1085;&#1099;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1083;&#1103; &#1084;&#1080;&#1085;&#1080;&#1084;&#1072;&#1083;&#1100;&#1085;&#1086;&#1081; &#1080; &#1084;&#1072;&#1082;&#1089;&#1080;&#1084;&#1072;&#1083;&#1100;&#1085;&#1086;&#1081; &#1094;&#1077;&#1085;&#1099;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_stock_enabled',
                        dv_theme_options_label( '&#1060;&#1080;&#1083;&#1100;&#1090;&#1088; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1103;' ),
                        dv_theme_options_label( '&#1063;&#1077;&#1082;&#1073;&#1086;&#1082;&#1089; "&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;" &#1074; sidebar.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_recs_enabled',
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; "&#1042;&#1072;&#1084; &#1084;&#1086;&#1078;&#1077;&#1090; &#1087;&#1086;&#1085;&#1088;&#1072;&#1074;&#1080;&#1090;&#1100;&#1089;&#1103;"' ),
                        dv_theme_options_label( '&#1053;&#1077;&#1073;&#1086;&#1083;&#1100;&#1096;&#1086;&#1081; &#1073;&#1083;&#1086;&#1082; &#1087;&#1086;&#1087;&#1091;&#1083;&#1103;&#1088;&#1085;&#1099;&#1093; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1074; sidebar &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1072;.' )
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'catalog_recs_limit',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1088;&#1077;&#1082;&#1086;&#1084;&#1077;&#1085;&#1076;&#1072;&#1094;&#1080;&#1081; &#1074; sidebar' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; &#1074; &#1085;&#1080;&#1078;&#1085;&#1077;&#1084; &#1073;&#1083;&#1086;&#1082;&#1077; sidebar.' ),
                        1,
                        12
                    );
                    dv_render_theme_options_order_grid(
                        $options,
                        array(
                            array(
                                'key'         => 'catalog_path_order',
                                'label'       => dv_theme_options_label( '&#1042;&#1099; &#1079;&#1076;&#1077;&#1089;&#1100;' ),
                                'description' => dv_theme_options_label( '&#1062;&#1077;&#1087;&#1086;&#1095;&#1082;&#1072; &#1090;&#1077;&#1082;&#1091;&#1097;&#1077;&#1075;&#1086; &#1088;&#1072;&#1079;&#1076;&#1077;&#1083;&#1072;.' ),
                                'default'     => 10,
                            ),
                            array(
                                'key'         => 'catalog_marka_order',
                                'label'       => dv_theme_options_label( '&#1052;&#1072;&#1088;&#1082;&#1072; &#1058;&#1057;' ),
                                'description' => dv_theme_options_label( '&#1060;&#1080;&#1083;&#1100;&#1090;&#1088; &#1087;&#1086; &#1084;&#1072;&#1088;&#1082;&#1077; &#1072;&#1074;&#1090;&#1086;.' ),
                                'default'     => 20,
                            ),
                            array(
                                'key'         => 'catalog_categories_order',
                                'label'       => dv_theme_options_label( '&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080; / &#1087;&#1086;&#1076;&#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;' ),
                                'description' => dv_theme_options_label( '&#1057;&#1086;&#1089;&#1077;&#1076;&#1085;&#1080;&#1077; &#1088;&#1072;&#1079;&#1076;&#1077;&#1083;&#1099; &#1080; &#1076;&#1086;&#1095;&#1077;&#1088;&#1085;&#1080;&#1077; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;.' ),
                                'default'     => 30,
                            ),
                            array(
                                'key'         => 'catalog_price_order',
                                'label'       => dv_theme_options_label( '&#1062;&#1077;&#1085;&#1072;' ),
                                'description' => dv_theme_options_label( '&#1052;&#1080;&#1085;&#1080;&#1084;&#1072;&#1083;&#1100;&#1085;&#1072;&#1103; &#1080; &#1084;&#1072;&#1082;&#1089;&#1080;&#1084;&#1072;&#1083;&#1100;&#1085;&#1072;&#1103; &#1094;&#1077;&#1085;&#1072;.' ),
                                'default'     => 40,
                            ),
                            array(
                                'key'         => 'catalog_stock_order',
                                'label'       => dv_theme_options_label( '&#1053;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;' ),
                                'description' => dv_theme_options_label( '&#1063;&#1077;&#1082;&#1073;&#1086;&#1082;&#1089; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;.' ),
                                'default'     => 50,
                            ),
                            array(
                                'key'         => 'catalog_recs_order',
                                'label'       => dv_theme_options_label( '&#1042;&#1072;&#1084; &#1084;&#1086;&#1078;&#1077;&#1090; &#1087;&#1086;&#1085;&#1088;&#1072;&#1074;&#1080;&#1090;&#1100;&#1089;&#1103;' ),
                                'description' => dv_theme_options_label( '&#1053;&#1080;&#1078;&#1085;&#1080;&#1081; &#1073;&#1083;&#1086;&#1082; &#1089; &#1088;&#1077;&#1082;&#1086;&#1084;&#1077;&#1085;&#1076;&#1072;&#1094;&#1080;&#1103;&#1084;&#1080;.' ),
                                'default'     => 60,
                            ),
                        )
                    );
                    ?>
                </section>

                <section class="dv-admin-card" id="dv-options-catalog-card">
                    <h2><?php echo esc_html( dv_theme_options_label( '&#1050;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1072; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1077;' ) ); ?></h2>
                    <?php
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_card_badges_enabled',
                        dv_theme_options_label( '&#1041;&#1077;&#1081;&#1076;&#1078;&#1080; &#1085;&#1072; &#1092;&#1086;&#1090;&#1086;' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1080;&#1076;&#1082;&#1072;, &#1052;&#1072;&#1083;&#1086; &#1080; &#1053;&#1086;&#1074;&#1080;&#1085;&#1082;&#1072; &#1074; &#1074;&#1077;&#1088;&#1093;&#1085;&#1077;&#1081; &#1095;&#1072;&#1089;&#1090;&#1080; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_card_actions_enabled',
                        dv_theme_options_label( '&#1041;&#1099;&#1089;&#1090;&#1088;&#1099;&#1077; &#1082;&#1085;&#1086;&#1087;&#1082;&#1080; &#1085;&#1072; &#1092;&#1086;&#1090;&#1086;' ),
                        dv_theme_options_label( '&#1050;&#1085;&#1086;&#1087;&#1082;&#1080; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103; &#1080; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086; &#1087;&#1086;&#1074;&#1077;&#1088;&#1093; &#1092;&#1086;&#1090;&#1086; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_card_compat_enabled',
                        dv_theme_options_label( '&#1063;&#1080;&#1087;&#1099; &#1089;&#1086;&#1074;&#1084;&#1077;&#1089;&#1090;&#1080;&#1084;&#1086;&#1089;&#1090;&#1080;' ),
                        dv_theme_options_label( '&#1052;&#1072;&#1088;&#1082;&#1072;, &#1089;&#1077;&#1084;&#1077;&#1081;&#1089;&#1090;&#1074;&#1086; &#1080; &#1084;&#1086;&#1076;&#1077;&#1083;&#1080; &#1072;&#1074;&#1090;&#1086; &#1087;&#1086;&#1076; &#1085;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077;&#1084; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_card_rating_enabled',
                        dv_theme_options_label( '&#1056;&#1077;&#1081;&#1090;&#1080;&#1085;&#1075; &#1080; &#1086;&#1090;&#1079;&#1099;&#1074;&#1099;' ),
                        dv_theme_options_label( '&#1047;&#1074;&#1105;&#1079;&#1076;&#1099; &#1080; &#1082;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1086;&#1090;&#1079;&#1099;&#1074;&#1086;&#1074;, &#1077;&#1089;&#1083;&#1080; &#1086;&#1085;&#1080; &#1077;&#1089;&#1090;&#1100; &#1091; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_card_sku_enabled',
                        dv_theme_options_label( '&#1040;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083; &#1074; &#1085;&#1080;&#1079;&#1091; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080;' ),
                        dv_theme_options_label( '&#1057;&#1090;&#1088;&#1086;&#1082;&#1072; &#1089; &#1072;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083;&#1086;&#1084; &#1087;&#1086;&#1076; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;&#1084;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'catalog_card_stock_qty_enabled',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1086;&#1089;&#1090;&#1072;&#1090;&#1082;&#1072;' ),
                        dv_theme_options_label( '&#1062;&#1080;&#1092;&#1088;&#1072; &#1086;&#1089;&#1090;&#1072;&#1090;&#1082;&#1072; &#1088;&#1103;&#1076;&#1086;&#1084; &#1089; "&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;" &#1080;&#1083;&#1080; "&#1052;&#1072;&#1083;&#1086;".' )
                    );
                    ?>
                </section>

                <section class="dv-admin-card" id="dv-options-home">
                    <h2><?php echo esc_html( dv_theme_options_label( '&#1043;&#1083;&#1072;&#1074;&#1085;&#1072;&#1103;' ) ); ?></h2>
                    <?php
                    dv_render_theme_options_number_field(
                        $options,
                        'home_product_columns',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1086;&#1085;&#1086;&#1082; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1085;&#1072; &#1075;&#1083;&#1072;&#1074;&#1085;&#1086;&#1081;' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1082;&#1086;&#1083;&#1086;&#1085;&#1086;&#1082; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; &#1074; &#1090;&#1086;&#1074;&#1072;&#1088;&#1085;&#1099;&#1093; &#1073;&#1083;&#1086;&#1082;&#1072;&#1093; &#1075;&#1083;&#1072;&#1074;&#1085;&#1086;&#1081; &#1085;&#1072; desktop. Mobile-&#1089;&#1077;&#1090;&#1082;&#1072; &#1086;&#1089;&#1090;&#1072;&#1105;&#1090;&#1089;&#1103; &#1082;&#1086;&#1084;&#1087;&#1072;&#1082;&#1090;&#1085;&#1086;&#1081;.' ),
                        2,
                        6
                    );
                    ?>
                </section>

                <section class="dv-admin-card" id="dv-options-search">
                    <h2><?php echo esc_html( dv_theme_options_label( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1080; 404' ) ); ?></h2>
                    <?php
                    dv_render_theme_options_number_field(
                        $options,
                        'search_live_limit',
                        dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1074; dropdown &#1087;&#1086;&#1080;&#1089;&#1082;&#1072;' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1087;&#1086;&#1079;&#1080;&#1094;&#1080;&#1081; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; &#1087;&#1086;&#1076; &#1089;&#1090;&#1088;&#1086;&#1082;&#1086;&#1081; live-search.' ),
                        1,
                        20
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'search_page_per_page',
                        dv_theme_options_label( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1085;&#1072; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1077; &#1087;&#1086;&#1080;&#1089;&#1082;&#1072;' ),
                        dv_theme_options_label( '&#1051;&#1080;&#1084;&#1080;&#1090; &#1087;&#1086;&#1083;&#1085;&#1086;&#1081; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1099; &#1088;&#1077;&#1079;&#1091;&#1083;&#1100;&#1090;&#1072;&#1090;&#1086;&#1074; &#1087;&#1086;&#1080;&#1089;&#1082;&#1072;.' ),
                        1,
                        96
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'not_found_categories_limit',
                        dv_theme_options_label( '&#1056;&#1072;&#1079;&#1076;&#1077;&#1083;&#1086;&#1074; &#1085;&#1072; 404' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1087;&#1086;&#1087;&#1091;&#1083;&#1103;&#1088;&#1085;&#1099;&#1093; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; &#1085;&#1072; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1077; 404. 0 &#1089;&#1082;&#1088;&#1086;&#1077;&#1090; &#1073;&#1083;&#1086;&#1082;.' ),
                        0,
                        20
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'not_found_search_enabled',
                        dv_theme_options_label( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1085;&#1072; 404' ),
                        dv_theme_options_label( '&#1060;&#1086;&#1088;&#1084;&#1072; &#1087;&#1086;&#1080;&#1089;&#1082;&#1072; &#1087;&#1086; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;&#1084; &#1085;&#1072; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1077; &#1086;&#1096;&#1080;&#1073;&#1082;&#1080;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'not_found_actions_enabled',
                        dv_theme_options_label( '&#1050;&#1085;&#1086;&#1087;&#1082;&#1080; &#1085;&#1072; 404' ),
                        dv_theme_options_label( '&#1041;&#1099;&#1089;&#1090;&#1088;&#1099;&#1077; &#1089;&#1089;&#1099;&#1083;&#1082;&#1080; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075; &#1080; &#1085;&#1072; &#1075;&#1083;&#1072;&#1074;&#1085;&#1091;&#1102;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'not_found_categories_enabled',
                        dv_theme_options_label( '&#1055;&#1086;&#1087;&#1091;&#1083;&#1103;&#1088;&#1085;&#1099;&#1077; &#1088;&#1072;&#1079;&#1076;&#1077;&#1083;&#1099; &#1085;&#1072; 404' ),
                        dv_theme_options_label( '&#1041;&#1083;&#1086;&#1082; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1087;&#1086;&#1076; &#1073;&#1099;&#1089;&#1090;&#1088;&#1099;&#1084;&#1080; &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1103;&#1084;&#1080;.' )
                    );
                    ?>
                    <div class="dv-admin-actions">
                        <button type="submit" class="button button-secondary" form="dv-live-search-index-rebuild">
                            <?php echo esc_html( dv_theme_options_label( '&#1055;&#1077;&#1088;&#1077;&#1089;&#1086;&#1073;&#1088;&#1072;&#1090;&#1100; &#1080;&#1085;&#1076;&#1077;&#1082;&#1089; &#1087;&#1086;&#1080;&#1089;&#1082;&#1072;' ) ); ?>
                        </button>
                        <p class="description"><?php echo esc_html( dv_theme_options_label( '&#1054;&#1073;&#1085;&#1086;&#1074;&#1083;&#1103;&#1077;&#1090; &#1073;&#1099;&#1089;&#1090;&#1088;&#1099;&#1081; live-search &#1087;&#1086;&#1089;&#1083;&#1077; &#1084;&#1072;&#1089;&#1089;&#1086;&#1074;&#1086;&#1075;&#1086; &#1080;&#1084;&#1087;&#1086;&#1088;&#1090;&#1072; &#1080;&#1083;&#1080; &#1087;&#1088;&#1072;&#1074;&#1086;&#1082; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;.' ) ); ?></p>
                    </div>
                </section>

                <section class="dv-admin-card" id="dv-options-footer">
                    <h2><?php echo esc_html( dv_theme_options_label( '&#1060;&#1091;&#1090;&#1077;&#1088;' ) ); ?></h2>
                    <?php
                    dv_render_theme_options_toggle_field(
                        $options,
                        'footer_brand_enabled',
                        dv_theme_options_label( '&#1041;&#1083;&#1086;&#1082; &#1073;&#1088;&#1077;&#1085;&#1076;&#1072; &#1089; &#1083;&#1086;&#1075;&#1086;&#1090;&#1080;&#1087;&#1086;&#1084;' ),
                        dv_theme_options_label( '&#1051;&#1077;&#1074;&#1072;&#1103; &#1082;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; &#1092;&#1091;&#1090;&#1077;&#1088;&#1072; &#1089; &#1083;&#1086;&#1075;&#1086;&#1090;&#1080;&#1087;&#1086;&#1084;, &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;&#1084; &#1080; &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1072;&#1084;&#1080;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'footer_description_enabled',
                        dv_theme_options_label( '&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072; &#1074; &#1092;&#1091;&#1090;&#1077;&#1088;&#1077;' ),
                        dv_theme_options_label( '&#1058;&#1077;&#1082;&#1089;&#1090; &#1087;&#1086;&#1076; &#1083;&#1086;&#1075;&#1086;&#1090;&#1080;&#1087;&#1086;&#1084; &#1074; &#1083;&#1077;&#1074;&#1086;&#1081; &#1082;&#1086;&#1083;&#1086;&#1085;&#1082;&#1077;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'footer_contacts_enabled',
                        dv_theme_options_label( '&#1058;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085; &#1080; &#1075;&#1088;&#1072;&#1092;&#1080;&#1082; &#1074; &#1092;&#1091;&#1090;&#1077;&#1088;&#1077;' ),
                        dv_theme_options_label( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099; &#1087;&#1086;&#1076; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;&#1084; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'footer_catalog_enabled',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; "&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;"' ),
                        dv_theme_options_label( '&#1057;&#1087;&#1080;&#1089;&#1086;&#1082; &#1090;&#1086;&#1074;&#1072;&#1088;&#1085;&#1099;&#1093; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081; &#1074; &#1092;&#1091;&#1090;&#1077;&#1088;&#1077;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'footer_customers_enabled',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; "&#1055;&#1086;&#1082;&#1091;&#1087;&#1072;&#1090;&#1077;&#1083;&#1103;&#1084;"' ),
                        dv_theme_options_label( '&#1057;&#1077;&#1088;&#1074;&#1080;&#1089;&#1085;&#1099;&#1077; &#1089;&#1089;&#1099;&#1083;&#1082;&#1080; &#1076;&#1083;&#1103; &#1087;&#1086;&#1082;&#1091;&#1087;&#1072;&#1090;&#1077;&#1083;&#1077;&#1081;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'footer_company_enabled',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; "&#1050;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1103;"' ),
                        dv_theme_options_label( '&#1057;&#1089;&#1099;&#1083;&#1082;&#1080; &#1085;&#1072; &#1086; &#1082;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1080;, &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;, &#1074;&#1072;&#1082;&#1072;&#1085;&#1089;&#1080;&#1080; &#1080; &#1073;&#1083;&#1086;&#1075;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'footer_bottom_enabled',
                        dv_theme_options_label( '&#1053;&#1080;&#1078;&#1085;&#1103;&#1103; &#1089;&#1090;&#1088;&#1086;&#1082;&#1072; &#1092;&#1091;&#1090;&#1077;&#1088;&#1072;' ),
                        dv_theme_options_label( '&#1050;&#1086;&#1087;&#1080;&#1088;&#1072;&#1081;&#1090;, &#1087;&#1083;&#1072;&#1090;&#1105;&#1078;&#1085;&#1099;&#1077; &#1073;&#1077;&#1081;&#1076;&#1078;&#1080; &#1080; &#1102;&#1088;&#1080;&#1076;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080;&#1077; &#1089;&#1089;&#1099;&#1083;&#1082;&#1080;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'footer_payment_icons_enabled',
                        dv_theme_options_label( '&#1055;&#1083;&#1072;&#1090;&#1105;&#1078;&#1085;&#1099;&#1077; &#1073;&#1077;&#1081;&#1076;&#1078;&#1080;' ),
                        dv_theme_options_label( '&#1041;&#1077;&#1081;&#1076;&#1078;&#1080; VISA, MIR, MC, &#1057;&#1044;&#1069;&#1050; &#1080;&#1083;&#1080; &#1089;&#1074;&#1086;&#1080; &#1079;&#1085;&#1072;&#1095;&#1077;&#1085;&#1080;&#1103; &#1080;&#1079; "&#1050;&#1086;&#1085;&#1090;&#1077;&#1085;&#1090; &#1090;&#1077;&#1084;&#1099;".' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'footer_legal_links_enabled',
                        dv_theme_options_label( '&#1057;&#1089;&#1099;&#1083;&#1082;&#1080; &#1085;&#1072; &#1087;&#1086;&#1083;&#1080;&#1090;&#1080;&#1082;&#1091; &#1080; &#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1077;&#1085;&#1080;&#1077;' ),
                        dv_theme_options_label( '&#1055;&#1088;&#1072;&#1074;&#1099;&#1077; &#1089;&#1089;&#1099;&#1083;&#1082;&#1080; &#1074; &#1085;&#1080;&#1078;&#1085;&#1077;&#1081; &#1089;&#1090;&#1088;&#1086;&#1082;&#1077; &#1092;&#1091;&#1090;&#1077;&#1088;&#1072;.' )
                    );
                    $footer_link_toggles = array(
                        'footer_customers_1_enabled' => '&#1055;&#1086;&#1082;&#1091;&#1087;&#1072;&#1090;&#1077;&#1083;&#1103;&#1084;: &#1089;&#1089;&#1099;&#1083;&#1082;&#1072; 1',
                        'footer_customers_2_enabled' => '&#1055;&#1086;&#1082;&#1091;&#1087;&#1072;&#1090;&#1077;&#1083;&#1103;&#1084;: &#1089;&#1089;&#1099;&#1083;&#1082;&#1072; 2',
                        'footer_customers_3_enabled' => '&#1055;&#1086;&#1082;&#1091;&#1087;&#1072;&#1090;&#1077;&#1083;&#1103;&#1084;: &#1089;&#1089;&#1099;&#1083;&#1082;&#1072; 3',
                        'footer_customers_4_enabled' => '&#1055;&#1086;&#1082;&#1091;&#1087;&#1072;&#1090;&#1077;&#1083;&#1103;&#1084;: &#1089;&#1089;&#1099;&#1083;&#1082;&#1072; 4',
                        'footer_customers_5_enabled' => '&#1055;&#1086;&#1082;&#1091;&#1087;&#1072;&#1090;&#1077;&#1083;&#1103;&#1084;: &#1089;&#1089;&#1099;&#1083;&#1082;&#1072; 5',
                        'footer_company_1_enabled' => '&#1050;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1103;: &#1089;&#1089;&#1099;&#1083;&#1082;&#1072; 1',
                        'footer_company_2_enabled' => '&#1050;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1103;: &#1089;&#1089;&#1099;&#1083;&#1082;&#1072; 2',
                        'footer_company_3_enabled' => '&#1050;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1103;: &#1089;&#1089;&#1099;&#1083;&#1082;&#1072; 3',
                        'footer_company_4_enabled' => '&#1050;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1103;: &#1089;&#1089;&#1099;&#1083;&#1082;&#1072; 4',
                        'footer_privacy_enabled' => '&#1053;&#1080;&#1079; &#1092;&#1091;&#1090;&#1077;&#1088;&#1072;: &#1087;&#1086;&#1083;&#1080;&#1090;&#1080;&#1082;&#1072;',
                        'footer_offer_enabled' => '&#1053;&#1080;&#1079; &#1092;&#1091;&#1090;&#1077;&#1088;&#1072;: &#1089;&#1086;&#1075;&#1083;&#1072;&#1096;&#1077;&#1085;&#1080;&#1077;',
                    );
                    foreach ( $footer_link_toggles as $footer_link_key => $footer_link_label ) {
                        dv_render_theme_options_toggle_field(
                            $options,
                            $footer_link_key,
                            dv_theme_options_label( $footer_link_label ),
                            dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1080;&#1083;&#1080; &#1089;&#1082;&#1088;&#1099;&#1074;&#1072;&#1077;&#1090; &#1101;&#1090;&#1091; &#1082;&#1086;&#1085;&#1082;&#1088;&#1077;&#1090;&#1085;&#1091;&#1102; &#1089;&#1089;&#1099;&#1083;&#1082;&#1091; &#1092;&#1091;&#1090;&#1077;&#1088;&#1072;.' )
                        );
                    }
                    ?>
                </section>

                <section class="dv-admin-card" id="dv-options-cart">
                    <h2><?php echo esc_html( dv_theme_options_label( '&#1050;&#1086;&#1088;&#1079;&#1080;&#1085;&#1072;' ) ); ?></h2>
                    <?php
                    dv_render_theme_options_toggle_field(
                        $options,
                        'cart_product_image_enabled',
                        dv_theme_options_label( '&#1060;&#1086;&#1090;&#1086; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;' ),
                        dv_theme_options_label( '&#1052;&#1080;&#1085;&#1080;&#1072;&#1090;&#1102;&#1088;&#1072; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1074; &#1089;&#1090;&#1088;&#1086;&#1082;&#1077; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1099;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'cart_price_enabled',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; "&#1062;&#1077;&#1085;&#1072;"' ),
                        dv_theme_options_label( '&#1062;&#1077;&#1085;&#1072; &#1079;&#1072; &#1077;&#1076;&#1080;&#1085;&#1080;&#1094;&#1091; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1074; &#1090;&#1072;&#1073;&#1083;&#1080;&#1094;&#1077; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1099;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'cart_subtotal_enabled',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1086;&#1085;&#1082;&#1072; "&#1057;&#1091;&#1084;&#1084;&#1072;"' ),
                        dv_theme_options_label( '&#1057;&#1091;&#1084;&#1084;&#1072; &#1087;&#1086; &#1089;&#1090;&#1088;&#1086;&#1082;&#1077; &#1089; &#1091;&#1095;&#1105;&#1090;&#1086;&#1084; &#1082;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'cart_coupon_enabled',
                        dv_theme_options_label( '&#1055;&#1088;&#1086;&#1084;&#1086;&#1082;&#1086;&#1076;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1083;&#1077; &#1074;&#1074;&#1086;&#1076;&#1072; &#1082;&#1091;&#1087;&#1086;&#1085;&#1072; &#1085;&#1080;&#1078;&#1077; &#1089;&#1087;&#1080;&#1089;&#1082;&#1072; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'cart_cross_sells_enabled',
                        dv_theme_options_label( '&#1041;&#1083;&#1086;&#1082; cross-sells' ),
                        dv_theme_options_label( '&#1056;&#1077;&#1082;&#1086;&#1084;&#1077;&#1085;&#1076;&#1072;&#1094;&#1080;&#1080; WooCommerce &#1085;&#1080;&#1078;&#1077; &#1086;&#1089;&#1085;&#1086;&#1074;&#1085;&#1086;&#1081; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1099;.' )
                    );
                    ?>
                </section>

                <section class="dv-admin-card" id="dv-options-checkout">
                    <h2><?php echo esc_html( dv_theme_options_label( 'Checkout' ) ); ?></h2>
                    <?php
                    dv_render_theme_options_toggle_field(
                        $options,
                        'checkout_coupon_enabled',
                        dv_theme_options_label( '&#1050;&#1091;&#1087;&#1086;&#1085; &#1085;&#1072; checkout' ),
                        dv_theme_options_label( '&#1064;&#1090;&#1072;&#1090;&#1085;&#1072;&#1103; WooCommerce-&#1092;&#1086;&#1088;&#1084;&#1072; &#1087;&#1088;&#1086;&#1084;&#1086;&#1082;&#1086;&#1076;&#1072; &#1085;&#1072; &#1101;&#1082;&#1088;&#1072;&#1085;&#1077; &#1086;&#1092;&#1086;&#1088;&#1084;&#1083;&#1077;&#1085;&#1080;&#1103;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'checkout_login_enabled',
                        dv_theme_options_label( '&#1060;&#1086;&#1088;&#1084;&#1072; &#1074;&#1093;&#1086;&#1076;&#1072; &#1076;&#1083;&#1103; &#1082;&#1083;&#1080;&#1077;&#1085;&#1090;&#1072;' ),
                        dv_theme_options_label( '&#1057;&#1090;&#1088;&#1086;&#1082;&#1072; "&#1059;&#1078;&#1077; &#1087;&#1086;&#1082;&#1091;&#1087;&#1072;&#1083;&#1080;?" &#1080; &#1092;&#1086;&#1088;&#1084;&#1072; &#1074;&#1093;&#1086;&#1076;&#1072; &#1085;&#1072; checkout.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'checkout_order_notes_enabled',
                        dv_theme_options_label( '&#1055;&#1088;&#1080;&#1084;&#1077;&#1095;&#1072;&#1085;&#1080;&#1077; &#1082; &#1079;&#1072;&#1082;&#1072;&#1079;&#1091;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1083;&#1077; &#1082;&#1086;&#1084;&#1084;&#1077;&#1085;&#1090;&#1072;&#1088;&#1080;&#1103; &#1082; &#1079;&#1072;&#1082;&#1072;&#1079;&#1091; &#1074; &#1076;&#1086;&#1087;&#1086;&#1083;&#1085;&#1080;&#1090;&#1077;&#1083;&#1100;&#1085;&#1086;&#1081; &#1080;&#1085;&#1092;&#1086;&#1088;&#1084;&#1072;&#1094;&#1080;&#1080; WooCommerce.' )
                    );
                    ?>
                </section>

                <section class="dv-admin-card" id="dv-options-product">
                    <h2><?php echo esc_html( dv_theme_options_label( '&#1050;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1072; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;' ) ); ?></h2>
                    <?php
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_gallery_hint_enabled',
                        dv_theme_options_label( '&#1055;&#1086;&#1076;&#1089;&#1082;&#1072;&#1079;&#1082;&#1072; &#1085;&#1072; &#1092;&#1086;&#1090;&#1086;' ),
                        dv_theme_options_label( '&#1053;&#1072;&#1076;&#1087;&#1080;&#1089;&#1100; "&#1053;&#1072;&#1078;&#1084;&#1080;&#1090;&#1077; &#1076;&#1083;&#1103; &#1091;&#1074;&#1077;&#1083;&#1080;&#1095;&#1077;&#1085;&#1080;&#1103;" &#1085;&#1072; &#1075;&#1072;&#1083;&#1077;&#1088;&#1077;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_meta_sku_enabled',
                        dv_theme_options_label( '&#1040;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083; &#1087;&#1086;&#1076; H1' ),
                        dv_theme_options_label( '&#1052;&#1077;&#1090;&#1072;-&#1095;&#1080;&#1087; &#1089; &#1072;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083;&#1086;&#1084; &#1074; &#1074;&#1077;&#1088;&#1093;&#1085;&#1077;&#1081; &#1095;&#1072;&#1089;&#1090;&#1080; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_actions_enabled',
                        dv_theme_options_label( '&#1050;&#1085;&#1086;&#1087;&#1082;&#1080; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086; &#1080; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103;' ),
                        dv_theme_options_label( '&#1053;&#1080;&#1078;&#1085;&#1080;&#1077; &#1082;&#1085;&#1086;&#1087;&#1082;&#1080; &#1087;&#1086;&#1076; &#1073;&#1083;&#1086;&#1082;&#1086;&#1084; &#1087;&#1086;&#1082;&#1091;&#1087;&#1082;&#1080; &#1074; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_wishlist_enabled',
                        dv_theme_options_label( '&#1050;&#1085;&#1086;&#1087;&#1082;&#1072; "&#1042; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1077;"' ),
                        dv_theme_options_label( '&#1054;&#1090;&#1076;&#1077;&#1083;&#1100;&#1085;&#1086; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1080;&#1083;&#1080; &#1089;&#1082;&#1088;&#1099;&#1074;&#1072;&#1077;&#1090; wishlist-&#1082;&#1085;&#1086;&#1087;&#1082;&#1091; &#1087;&#1086;&#1076; &#1073;&#1083;&#1086;&#1082;&#1086;&#1084; &#1087;&#1086;&#1082;&#1091;&#1087;&#1082;&#1080;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_compare_enabled',
                        dv_theme_options_label( '&#1050;&#1085;&#1086;&#1087;&#1082;&#1072; "&#1057;&#1088;&#1072;&#1074;&#1085;&#1080;&#1090;&#1100;"' ),
                        dv_theme_options_label( '&#1054;&#1090;&#1076;&#1077;&#1083;&#1100;&#1085;&#1086; &#1087;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1080;&#1083;&#1080; &#1089;&#1082;&#1088;&#1099;&#1074;&#1072;&#1077;&#1090; compare-&#1082;&#1085;&#1086;&#1087;&#1082;&#1091; &#1087;&#1086;&#1076; &#1073;&#1083;&#1086;&#1082;&#1086;&#1084; &#1087;&#1086;&#1082;&#1091;&#1087;&#1082;&#1080;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_ozon_enabled',
                        dv_theme_options_label( 'Ozon &#1074; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090; &#1079;&#1072;&#1084;&#1077;&#1090;&#1085;&#1091;&#1102; &#1089;&#1089;&#1099;&#1083;&#1082;&#1091; &#1085;&#1072; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085; Ozon &#1088;&#1103;&#1076;&#1086;&#1084; &#1089; &#1073;&#1083;&#1086;&#1082;&#1086;&#1084; &#1087;&#1086;&#1082;&#1091;&#1087;&#1082;&#1080;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_summary_description_enabled',
                        dv_theme_options_label( '&#1050;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1074; &#1074;&#1077;&#1088;&#1093;&#1085;&#1077;&#1084; &#1073;&#1083;&#1086;&#1082;&#1077;' ),
                        dv_theme_options_label( '&#1058;&#1077;&#1082;&#1089;&#1090; &#1087;&#1086;&#1076; &#1094;&#1077;&#1085;&#1086;&#1081; &#1080; &#1089;&#1086;&#1074;&#1084;&#1077;&#1089;&#1090;&#1080;&#1084;&#1086;&#1089;&#1090;&#1100;&#1102; &#1074; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_tab_description_enabled',
                        dv_theme_options_label( '&#1042;&#1082;&#1083;&#1072;&#1076;&#1082;&#1072; "&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;"' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1083;&#1085;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1085;&#1080;&#1078;&#1077; &#1074;&#1077;&#1088;&#1093;&#1085;&#1077;&#1075;&#1086; &#1101;&#1082;&#1088;&#1072;&#1085;&#1072; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_tab_specs_enabled',
                        dv_theme_options_label( '&#1042;&#1082;&#1083;&#1072;&#1076;&#1082;&#1072; "&#1061;&#1072;&#1088;&#1072;&#1082;&#1090;&#1077;&#1088;&#1080;&#1089;&#1090;&#1080;&#1082;&#1080;"' ),
                        dv_theme_options_label( '&#1058;&#1072;&#1073;&#1083;&#1080;&#1094;&#1072; &#1072;&#1090;&#1088;&#1080;&#1073;&#1091;&#1090;&#1086;&#1074; &#1080; &#1092;&#1072;&#1082;&#1090;&#1086;&#1074;, &#1086;&#1090;&#1076;&#1077;&#1083;&#1105;&#1085;&#1085;&#1099;&#1093; &#1086;&#1090; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1103;.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_tab_reviews_enabled',
                        dv_theme_options_label( '&#1042;&#1082;&#1083;&#1072;&#1076;&#1082;&#1072; "&#1054;&#1090;&#1079;&#1099;&#1074;&#1099;"' ),
                        dv_theme_options_label( '&#1054;&#1090;&#1079;&#1099;&#1074;&#1099; &#1080; &#1092;&#1086;&#1088;&#1084;&#1072; &#1086;&#1094;&#1077;&#1085;&#1082;&#1080; &#1074; &#1085;&#1080;&#1078;&#1085;&#1080;&#1093; tabs &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1080;.' )
                    );
                    dv_render_theme_options_order_grid(
                        $options,
                        array(
                            array(
                                'key'         => 'product_purchase_order',
                                'label'       => dv_theme_options_label( '&#1041;&#1083;&#1086;&#1082; &#1087;&#1086;&#1082;&#1091;&#1087;&#1082;&#1080;' ),
                                'description' => dv_theme_options_label( '&#1062;&#1077;&#1085;&#1072;, &#1082;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;, &#1086;&#1089;&#1090;&#1072;&#1090;&#1086;&#1082; &#1080; &#1082;&#1085;&#1086;&#1087;&#1082;&#1080; &#1087;&#1086;&#1082;&#1091;&#1087;&#1082;&#1080;.' ),
                                'default'     => 10,
                            ),
                            array(
                                'key'         => 'product_ozon_order',
                                'label'       => 'Ozon',
                                'description' => dv_theme_options_label( '&#1057;&#1089;&#1099;&#1083;&#1082;&#1072; &#1085;&#1072; &#1084;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089; &#1074; &#1082;&#1072;&#1088;&#1090;&#1086;&#1095;&#1082;&#1077;.' ),
                                'default'     => 20,
                            ),
                            array(
                                'key'         => 'product_actions_order',
                                'label'       => dv_theme_options_label( '&#1048;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1077; / &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1077;' ),
                                'description' => dv_theme_options_label( '&#1053;&#1080;&#1078;&#1085;&#1080;&#1077; &#1073;&#1099;&#1089;&#1090;&#1088;&#1099;&#1077; &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1103;.' ),
                                'default'     => 30,
                            ),
                            array(
                                'key'         => 'product_tabs_order',
                                'label'       => dv_theme_options_label( '&#1042;&#1082;&#1083;&#1072;&#1076;&#1082;&#1080;' ),
                                'description' => dv_theme_options_label( '&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;, &#1093;&#1072;&#1088;&#1072;&#1082;&#1090;&#1077;&#1088;&#1080;&#1089;&#1090;&#1080;&#1082;&#1080; &#1080; &#1086;&#1090;&#1079;&#1099;&#1074;&#1099;.' ),
                                'default'     => 40,
                            ),
                            array(
                                'key'         => 'product_related_order',
                                'label'       => dv_theme_options_label( '&#1057; &#1101;&#1090;&#1080;&#1084; &#1087;&#1086;&#1082;&#1091;&#1087;&#1072;&#1102;&#1090;' ),
                                'description' => dv_theme_options_label( '&#1056;&#1086;&#1076;&#1085;&#1086;&#1081; related-&#1073;&#1083;&#1086;&#1082; WooCommerce.' ),
                                'default'     => 50,
                            ),
                            array(
                                'key'         => 'product_similar_order',
                                'label'       => dv_theme_options_label( '&#1055;&#1086;&#1093;&#1086;&#1078;&#1080;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1099;' ),
                                'description' => dv_theme_options_label( '&#1055;&#1086;&#1076;&#1073;&#1086;&#1088;&#1082;&#1072; &#1087;&#1086; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080; &#1080; &#1084;&#1077;&#1090;&#1082;&#1072;&#1084;.' ),
                                'default'     => 60,
                            ),
                            array(
                                'key'         => 'product_recent_order',
                                'label'       => dv_theme_options_label( '&#1042;&#1099; &#1085;&#1077;&#1076;&#1072;&#1074;&#1085;&#1086; &#1089;&#1084;&#1086;&#1090;&#1088;&#1077;&#1083;&#1080;' ),
                                'description' => dv_theme_options_label( '&#1051;&#1086;&#1082;&#1072;&#1083;&#1100;&#1085;&#1072;&#1103; &#1080;&#1089;&#1090;&#1086;&#1088;&#1080;&#1103; &#1087;&#1088;&#1086;&#1089;&#1084;&#1086;&#1090;&#1088;&#1086;&#1074;.' ),
                                'default'     => 70,
                            ),
                        )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_related_enabled',
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; "&#1057; &#1101;&#1090;&#1080;&#1084; &#1087;&#1086;&#1082;&#1091;&#1087;&#1072;&#1102;&#1090;"' ),
                        dv_theme_options_label( '&#1056;&#1086;&#1076;&#1085;&#1086;&#1081; WooCommerce-&#1073;&#1083;&#1086;&#1082; &#1087;&#1086;&#1093;&#1086;&#1078;&#1080;&#1093;/&#1089;&#1074;&#1103;&#1079;&#1072;&#1085;&#1085;&#1099;&#1093; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;.' )
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'product_related_limit',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1074; "&#1057; &#1101;&#1090;&#1080;&#1084; &#1087;&#1086;&#1082;&#1091;&#1087;&#1072;&#1102;&#1090;"' ),
                        dv_theme_options_label( '&#1056;&#1077;&#1082;&#1086;&#1084;&#1077;&#1085;&#1076;&#1091;&#1077;&#1090;&#1089;&#1103; 4 &#1080;&#1083;&#1080; 8.' ),
                        1,
                        12
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_similar_enabled',
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; "&#1055;&#1086;&#1093;&#1086;&#1078;&#1080;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1099;"' ),
                        dv_theme_options_label( '&#1041;&#1083;&#1086;&#1082; &#1087;&#1086; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1103;&#1084; &#1080; &#1084;&#1077;&#1090;&#1082;&#1072;&#1084; &#1090;&#1077;&#1082;&#1091;&#1097;&#1077;&#1075;&#1086; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;.' )
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'product_similar_limit',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1087;&#1086;&#1093;&#1086;&#1078;&#1080;&#1093;' ),
                        dv_theme_options_label( '&#1057;&#1082;&#1086;&#1083;&#1100;&#1082;&#1086; &#1087;&#1086;&#1079;&#1080;&#1094;&#1080;&#1081; &#1074;&#1099;&#1074;&#1086;&#1076;&#1080;&#1090;&#1100; &#1074; &#1101;&#1090;&#1086;&#1084; &#1073;&#1083;&#1086;&#1082;&#1077;.' ),
                        1,
                        12
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'product_recent_enabled',
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; "&#1042;&#1099; &#1085;&#1077;&#1076;&#1072;&#1074;&#1085;&#1086; &#1089;&#1084;&#1086;&#1090;&#1088;&#1077;&#1083;&#1080;"' ),
                        dv_theme_options_label( '&#1051;&#1086;&#1082;&#1072;&#1083;&#1100;&#1085;&#1099;&#1081; cookie-&#1073;&#1083;&#1086;&#1082; &#1080;&#1089;&#1090;&#1086;&#1088;&#1080;&#1080; &#1087;&#1088;&#1086;&#1089;&#1084;&#1086;&#1090;&#1088;&#1086;&#1074;.' )
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'product_recent_limit',
                        dv_theme_options_label( '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1085;&#1077;&#1076;&#1072;&#1074;&#1085;&#1086; &#1087;&#1088;&#1086;&#1089;&#1084;&#1086;&#1090;&#1088;&#1077;&#1085;&#1085;&#1099;&#1093;' ),
                        dv_theme_options_label( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1077;&#1090;&#1089;&#1103; &#1090;&#1086;&#1083;&#1100;&#1082;&#1086; &#1077;&#1089;&#1083;&#1080; &#1077;&#1089;&#1090;&#1100; &#1080;&#1089;&#1090;&#1086;&#1088;&#1080;&#1103; &#1087;&#1088;&#1086;&#1089;&#1084;&#1086;&#1090;&#1088;&#1086;&#1074;.' ),
                        1,
                        12
                    );
                    dv_render_theme_options_number_field(
                        $options,
                        'compare_limit',
                        dv_theme_options_label( '&#1052;&#1072;&#1082;&#1089;&#1080;&#1084;&#1091;&#1084; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074; &#1074; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1080;' ),
                        dv_theme_options_label( '&#1051;&#1080;&#1084;&#1080;&#1090; &#1076;&#1083;&#1103; cookie-&#1089;&#1087;&#1080;&#1089;&#1082;&#1072; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103; &#1080; &#1089;&#1086;&#1086;&#1073;&#1097;&#1077;&#1085;&#1080;&#1103; &#1074; &#1096;&#1072;&#1087;&#1082;&#1077;.' ),
                        2,
                        8
                    );
                    ?>
                </section>

                <section class="dv-admin-card" id="dv-options-service">
                    <h2><?php echo esc_html( dv_theme_options_label( 'Сервисные страницы' ) ); ?></h2>
                    <?php
                    dv_render_theme_options_toggle_field(
                        $options,
                        'service_about_enabled',
                        dv_theme_options_label( 'О компании' ),
                        dv_theme_options_label( 'Виртуальная страница /o-kompanii и алиас /about.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'service_delivery_enabled',
                        dv_theme_options_label( 'Доставка' ),
                        dv_theme_options_label( 'Виртуальная страница /dostavka и алиас /delivery.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'service_contacts_enabled',
                        dv_theme_options_label( 'Контакты' ),
                        dv_theme_options_label( 'Виртуальная страница /kontakty и алиас /contacts.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'service_return_enabled',
                        dv_theme_options_label( 'Возврат' ),
                        dv_theme_options_label( 'Виртуальная страница /vozvrat и алиас /return.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'service_privacy_enabled',
                        dv_theme_options_label( 'Политика конфиденциальности' ),
                        dv_theme_options_label( 'Виртуальная страница /politika-konfidencialnosti и алиас /privacy-policy.' )
                    );
                    dv_render_theme_options_toggle_field(
                        $options,
                        'service_agreement_enabled',
                        dv_theme_options_label( 'Пользовательское соглашение' ),
                        dv_theme_options_label( 'Виртуальная страница /polzovatelskoe-soglashenie и старые алиасы.' )
                    );
                    ?>
                </section>

                <?php dv_render_theme_options_diagnostics( $options ); ?>

                <?php dv_render_theme_backup_card(); ?>
            </div>
            </div>

        </form>

        <form id="dv-theme-backup-export" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_backup_export' ); ?>
            <input type="hidden" name="action" value="dv_theme_backup_export">
        </form>

        <form id="dv-theme-backup-import" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
            <?php wp_nonce_field( 'dv_theme_backup_import' ); ?>
            <input type="hidden" name="action" value="dv_theme_backup_import">
        </form>

        <form id="dv-theme-backup-restore" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_backup_restore_last' ); ?>
            <input type="hidden" name="action" value="dv_theme_backup_restore_last">
        </form>

        <form id="dv-theme-auto-backup-restore" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_auto_backup_restore' ); ?>
            <input type="hidden" name="action" value="dv_theme_auto_backup_restore">
        </form>

        <?php foreach ( dv_theme_options_reset_groups() as $group_key => $group ) : ?>
            <form id="dv-theme-reset-<?php echo esc_attr( $group_key ); ?>" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <?php wp_nonce_field( 'dv_theme_options_reset_group' ); ?>
                <input type="hidden" name="action" value="dv_theme_options_reset_group">
                <input type="hidden" name="dv_theme_reset_group" value="<?php echo esc_attr( $group_key ); ?>">
            </form>
        <?php endforeach; ?>

        <form id="dv-theme-diagnostics-export" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_diagnostics_export' ); ?>
            <input type="hidden" name="action" value="dv_theme_diagnostics_export">
        </form>

        <form id="dv-theme-product-audit-export" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_product_audit_export' ); ?>
            <input type="hidden" name="action" value="dv_theme_product_audit_export">
        </form>

        <form id="dv-theme-product-audit-refresh" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_product_audit_refresh' ); ?>
            <input type="hidden" name="action" value="dv_theme_product_audit_refresh">
        </form>

        <form id="dv-theme-product-audit-fill-image-alt" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_product_audit_fill_image_alt' ); ?>
            <input type="hidden" name="action" value="dv_theme_product_audit_fill_image_alt">
        </form>

        <form id="dv-theme-product-audit-fill-excerpt" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_product_audit_fill_excerpt' ); ?>
            <input type="hidden" name="action" value="dv_theme_product_audit_fill_excerpt">
        </form>

        <form id="dv-theme-service-cache-clear" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_service_cache_clear' ); ?>
            <input type="hidden" name="action" value="dv_theme_service_cache_clear">
        </form>

        <form id="dv-live-search-index-rebuild" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_live_search_index_rebuild' ); ?>
            <input type="hidden" name="action" value="dv_live_search_index_rebuild">
        </form>

        <form id="dv-theme-settings-history-export" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_settings_history_export' ); ?>
            <input type="hidden" name="action" value="dv_theme_settings_history_export">
        </form>

        <form id="dv-theme-settings-history-clear" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <?php wp_nonce_field( 'dv_theme_settings_history_clear' ); ?>
            <input type="hidden" name="action" value="dv_theme_settings_history_clear">
        </form>
    </div>
    <?php
}
