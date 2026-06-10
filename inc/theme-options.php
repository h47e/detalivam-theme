<?php
/**
 * Lightweight theme display options used on frontend requests.
 */
defined( 'ABSPATH' ) || exit;

function dv_get_theme_options_defaults() {
    static $defaults_cache = null;

    if ( is_array( $defaults_cache ) ) {
        return $defaults_cache;
    }

    $defaults_cache = array(
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

    return $defaults_cache;
}

function dv_get_theme_options() {
    static $options_cache = null;

    if ( is_array( $options_cache ) ) {
        return $options_cache;
    }

    $saved = get_option( 'dv_theme_options', array() );
    if ( ! is_array( $saved ) ) {
        $saved = array();
    }

    $options_cache = wp_parse_args( $saved, dv_get_theme_options_defaults() );

    return $options_cache;
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
