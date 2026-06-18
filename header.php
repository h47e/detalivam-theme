<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php function_exists( 'dv_body_class' ) ? dv_body_class() : body_class(); ?>>
<?php wp_body_open(); ?>
<?php $dv_store = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array(); ?>
<?php $dv_content = function_exists( 'dv_get_theme_header_footer_content_settings' ) ? dv_get_theme_header_footer_content_settings() : ( function_exists( 'dv_get_theme_content_settings' ) ? dv_get_theme_content_settings() : array() ); ?>
<?php
$dv_logo_url       = function_exists( 'dv_get_theme_logo_url' ) ? dv_get_theme_logo_url() : get_template_directory_uri() . '/assets/logo.png';
$dv_store_name     = function_exists( 'dv_string_value' ) ? dv_string_value( $dv_store['name'] ?? '', get_bloginfo( 'name' ) ) : ( is_scalar( $dv_store['name'] ?? null ) ? trim( (string) $dv_store['name'] ) : get_bloginfo( 'name' ) );
$dv_compare_count  = function_exists( 'dv_get_cookie_id_list' ) ? count( dv_get_cookie_id_list( 'dv_compare' ) ) : 0;
$dv_wishlist_count = function_exists( 'dv_get_cookie_id_list' ) ? count( dv_get_cookie_id_list( 'dv_wishlist' ) ) : 0;
$dv_header_topbar_enabled   = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_topbar_enabled' ) : true;
$dv_topbar_city_enabled     = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'topbar_city_enabled' ) : true;
$dv_topbar_phone_enabled    = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'topbar_phone_enabled' ) : true;
$dv_topbar_shop_enabled     = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'topbar_shop_enabled' ) : true;
$dv_topbar_delivery_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'topbar_delivery_enabled' ) : true;
$dv_topbar_about_enabled    = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'topbar_about_enabled' ) : true;
$dv_topbar_contacts_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'topbar_contacts_enabled' ) : true;
$dv_header_search_enabled   = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_search_enabled' ) : true;
$dv_header_actions_enabled  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_actions_enabled' ) : true;
$dv_header_compare_enabled  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_compare_enabled' ) : true;
$dv_header_wishlist_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_wishlist_enabled' ) : true;
$dv_header_cart_enabled     = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_cart_enabled' ) : true;
$dv_header_ozon_enabled     = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_ozon_enabled' ) : true;
$dv_header_account_enabled  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_account_enabled' ) : true;
$dv_header_dropdown_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_catalog_dropdown_enabled' ) : true;
$dv_header_nav_links_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'header_nav_links_enabled' ) : true;
$dv_ozon_url = esc_url( $dv_store['ozon_url'] ?? '' );
$dv_ozon_icon_url = function_exists( 'dv_get_ozon_icon_url' ) ? dv_get_ozon_icon_url() : get_template_directory_uri() . '/assets/ozon.png';
$dv_header_has_actions = $dv_header_actions_enabled && ( $dv_header_compare_enabled || $dv_header_wishlist_enabled || $dv_header_cart_enabled || ( $dv_header_ozon_enabled && $dv_ozon_url ) || $dv_header_account_enabled );
$dv_service_about_enabled = ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'about' );
$dv_service_delivery_enabled = ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'delivery' );
$dv_service_contacts_enabled = ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'contacts' );
$dv_cart_count = 0;
$dv_cart_total = '';
if ( class_exists( 'WooCommerce' ) && WC()->cart ) {
    $dv_cart_count = WC()->cart->get_cart_contents_count();
    $dv_cart_total = WC()->cart->get_cart_total();
}
$dv_topbar_shop_fallback = home_url( '/catalog/' );
if ( function_exists( 'wc_get_page_id' ) ) {
    $dv_shop_page_id = wc_get_page_id( 'shop' );
    if ( $dv_shop_page_id > 0 ) {
        $dv_topbar_shop_fallback = get_permalink( $dv_shop_page_id );
    }
}
?>

<header class="site-header" id="site-header">

  <?php if ( $dv_header_topbar_enabled ) : ?>
  <div class="header-topbar">
    <div class="container">
      <div class="header-topbar-inner">
        <div class="topbar-left topbar-left--spaced flex-center">
          <?php if ( $dv_topbar_city_enabled ) : ?>
          <div class="topbar-geo">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
            <?php echo esc_html( $dv_store['city'] ?? '' ); ?>
          </div>
          <?php endif; ?>
          <div class="topbar-links">
            <?php if ( $dv_topbar_shop_enabled ) : ?>
            <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['topbar_shop_url'] ?? '', $dv_topbar_shop_fallback ) : ( $dv_content['topbar_shop_url'] ?? $dv_topbar_shop_fallback ) ); ?>"><?php echo esc_html( $dv_content['topbar_shop_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_topbar_delivery_enabled && $dv_service_delivery_enabled ) : ?>
            <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['topbar_delivery_url'] ?? '', function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'delivery' ) : '/dostavka' ) : ( $dv_content['topbar_delivery_url'] ?? '/dostavka' ) ); ?>"><?php echo esc_html( $dv_content['topbar_delivery_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_topbar_about_enabled && $dv_service_about_enabled ) : ?>
            <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['topbar_about_url'] ?? '', function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'about' ) : '/o-kompanii' ) : ( $dv_content['topbar_about_url'] ?? '/o-kompanii' ) ); ?>"><?php echo esc_html( $dv_content['topbar_about_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_topbar_contacts_enabled && $dv_service_contacts_enabled ) : ?>
            <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['topbar_contacts_url'] ?? '', function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'contacts' ) : '/kontakty' ) : ( $dv_content['topbar_contacts_url'] ?? '/kontakty' ) ); ?>"><?php echo esc_html( $dv_content['topbar_contacts_label'] ?? '' ); ?></a>
            <?php endif; ?>
          </div>
        </div>
        <div class="topbar-right">
          <?php if ( $dv_topbar_phone_enabled ) : ?>
          <a href="tel:<?php echo esc_attr( $dv_store['phone_href'] ?? '' ); ?>" class="topbar-phone"><?php echo esc_html( $dv_store['phone_display'] ?? '' ); ?></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <div class="header-main">
    <div class="container">
      <div class="header-main-inner">

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
          <img src="<?php echo esc_url( $dv_logo_url ); ?>" alt="<?php echo esc_attr( $dv_store_name ); ?>" class="logo-img">
          <span class="sr-only"><?php echo esc_html( $dv_store_name ); ?></span>
        </a>

        <?php if ( $dv_header_search_enabled ) : ?>
        <div class="header-search">
          <?php get_search_form(); ?>
        </div>
        <?php endif; ?>

        <?php if ( $dv_header_has_actions ) : ?>
        <div class="header-icons">
          <?php if ( class_exists( 'WooCommerce' ) ) : ?>
          <?php if ( $dv_header_ozon_enabled && $dv_ozon_url ) : ?>
          <a href="<?php echo esc_url( $dv_ozon_url ); ?>" class="header-icon-btn header-ozon-btn" target="_blank" rel="noopener noreferrer nofollow sponsored" aria-label="<?php echo esc_attr( html_entity_decode( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084; &#1085;&#1072; Ozon', ENT_QUOTES, 'UTF-8' ) ); ?>">
            <span class="header-ozon-mark" aria-hidden="true">
              <img class="header-ozon-icon" src="<?php echo esc_url( $dv_ozon_icon_url ); ?>" alt="" width="18" height="18" loading="lazy" decoding="async">
            </span>
          </a>
          <?php endif; ?>
          <?php if ( $dv_header_compare_enabled ) : ?>
          <div class="header-action-wrap" data-header-preview="compare">
            <a href="<?php echo esc_url( home_url( '/compare/' ) ); ?>" class="header-icon-btn">
              <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
              <?php if ( $dv_compare_count > 0 ) : ?>
                <span class="cart-badge" id="dv-compare-badge"><?php echo esc_html( $dv_compare_count ); ?></span>
              <?php else : ?>
                <span class="cart-badge is-hidden" id="dv-compare-badge"></span>
              <?php endif; ?>
              &#1057;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1077;
            </a>
            <div class="dv-header-preview" id="dv-compare-preview" data-preview-type="compare" data-view-url="<?php echo esc_url( home_url( '/compare/' ) ); ?>">
              <div class="dv-header-preview-loading">&#1047;&#1072;&#1075;&#1088;&#1091;&#1079;&#1082;&#1072;...</div>
            </div>
          </div>
          <?php endif; ?>
          <?php if ( $dv_header_wishlist_enabled ) : ?>
          <div class="header-action-wrap" data-header-preview="wishlist">
            <a href="<?php echo esc_url( function_exists( 'wc_get_wishlist_url' ) ? wc_get_wishlist_url() : home_url( '/wishlist/' ) ); ?>" class="header-icon-btn">
              <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
              <?php if ( $dv_wishlist_count > 0 ) : ?>
                <span class="cart-badge" id="dv-wishlist-badge"><?php echo esc_html( $dv_wishlist_count ); ?></span>
              <?php else : ?>
                <span class="cart-badge is-hidden" id="dv-wishlist-badge"></span>
              <?php endif; ?>
              &#1048;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1077;
            </a>
            <div class="dv-header-preview" id="dv-wishlist-preview" data-preview-type="wishlist" data-view-url="<?php echo esc_url( function_exists( 'wc_get_wishlist_url' ) ? wc_get_wishlist_url() : home_url( '/wishlist/' ) ); ?>">
              <div class="dv-header-preview-loading">&#1047;&#1072;&#1075;&#1088;&#1091;&#1079;&#1082;&#1072;...</div>
            </div>
          </div>
          <?php endif; ?>
          <?php if ( $dv_header_cart_enabled ) : ?>
          <div class="header-action-wrap" data-header-preview="cart">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-icon-btn">
              <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
              <?php if ( $dv_cart_count > 0 ) : ?>
                <span class="cart-badge" id="dv-cart-badge"><?php echo esc_html( $dv_cart_count ); ?></span>
              <?php else : ?>
                <span class="cart-badge is-hidden" id="dv-cart-badge"></span>
              <?php endif; ?>
              <span class="cart-total" id="dv-cart-total"><?php echo wp_kses_post( $dv_cart_total ); ?></span>
            </a>
            <div class="dv-header-preview" id="dv-cart-preview" data-preview-type="cart" data-view-url="<?php echo esc_url( wc_get_cart_url() ); ?>">
              <div class="dv-header-preview-loading">&#1047;&#1072;&#1075;&#1088;&#1091;&#1079;&#1082;&#1072;...</div>
            </div>
          </div>
          <?php endif; ?>
          <?php if ( $dv_header_account_enabled ) : ?>
          <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="header-icon-btn header-account-btn">
            <svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 00-16 0"/><circle cx="12" cy="8" r="4"/></svg>
            <?php if ( is_user_logged_in() ) : ?>
              <span>&#1050;&#1072;&#1073;&#1080;&#1085;&#1077;&#1090;</span>
            <?php else : ?>
              <span>&#1042;&#1086;&#1081;&#1090;&#1080;</span>
              <small>&#1056;&#1077;&#1075;&#1080;&#1089;&#1090;&#1088;&#1072;&#1094;&#1080;&#1103;</small>
            <?php endif; ?>
          </a>
          <?php endif; ?>
          <?php endif; ?>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <?php if ( $dv_header_dropdown_enabled || $dv_header_nav_links_enabled ) : ?>
  <nav class="header-nav" aria-label="&#1054;&#1089;&#1085;&#1086;&#1074;&#1085;&#1072;&#1103; &#1085;&#1072;&#1074;&#1080;&#1075;&#1072;&#1094;&#1080;&#1103;">
    <div class="container">
      <div class="nav-inner">
        <?php if ( $dv_header_dropdown_enabled ) : ?>
        <div class="nav-cats-dropdown">
          <a href="<?php echo esc_url( $dv_topbar_shop_fallback ); ?>" class="nav-link all-cats">
            <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            &#1042;&#1089;&#1077; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;
          </a>
          <div class="nav-cats-panel" aria-label="&#1057;&#1087;&#1080;&#1089;&#1086;&#1082; &#1090;&#1086;&#1074;&#1072;&#1088;&#1085;&#1099;&#1093; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1081;">
            <?php echo function_exists( 'dv_render_product_category_dropdown' ) ? dv_render_product_category_dropdown() : ''; ?>
          </div>
        </div>
        <?php endif; ?>
        <?php if ( $dv_header_nav_links_enabled ) : ?>
        <?php
        $header_categories_limit = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'header_categories_limit', 8, 0, 16 ) : 8;
        $cats = array();
        if ( $header_categories_limit > 0 ) {
            $cats = function_exists( 'dv_get_top_product_categories' )
                ? dv_get_top_product_categories( $header_categories_limit )
                : get_terms(
                    array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => true,
                        'parent'     => 0,
                        'number'     => $header_categories_limit,
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                    )
                );
        }
        if ( $header_categories_limit > 0 && $cats && ! is_wp_error( $cats ) ) :
            foreach ( $cats as $cat ) :
                $active = is_product_category( $cat->slug ) ? 'active' : '';
                ?>
        <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="nav-link <?php echo esc_attr( $active ); ?>">
          <?php echo esc_html( $cat->name ); ?>
        </a>
        <?php endforeach; endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </nav>
  <?php endif; ?>

</header>

<div id="page-content">
