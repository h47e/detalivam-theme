<?php
/**
 * Product content within loops.
 *
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$product_id   = $product->get_id();
$permalink    = $product->get_permalink();
$display_name = function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name();
$img_id       = $product->get_image_id();
$img_html     = '';

if ( $img_id ) {
    $img_html = wp_get_attachment_image(
        $img_id,
        'large',
        false,
        array(
            'alt'           => $display_name,
            'loading'       => 'lazy',
            'decoding'      => 'async',
            'fetchpriority' => 'low',
            'class'         => 'dv-card-image',
        )
    );
}

if ( '' === $img_html ) {
    $img_html = sprintf(
        '<img src="%s" alt="%s" loading="lazy" decoding="async" fetchpriority="low" class="dv-card-image">',
        esc_url( wc_placeholder_img_src() ),
        esc_attr( $display_name )
    );
}

$is_sale      = $product->is_on_sale();
$is_new       = strtotime( (string) $product->get_date_created() ) > strtotime( '-30 days' );
$stock        = $product->get_stock_quantity();
$in_stock     = $product->is_in_stock();
$sku          = $product->get_sku();
$rating       = $product->get_average_rating();
$review_count = $product->get_review_count();
$is_in_cart   = function_exists( 'dv_is_product_in_cart' ) ? dv_is_product_in_cart( $product ) : false;
$show_badges  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_card_badges_enabled' ) : true;
$show_actions = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_card_actions_enabled' ) : true;
$show_compat  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_card_compat_enabled' ) : true;
$show_rating  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_card_rating_enabled' ) : true;
$show_sku     = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_card_sku_enabled' ) : true;
$show_stock_qty = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_card_stock_qty_enabled' ) : true;

$price        = (float) $product->get_price();
$reg_price    = (float) $product->get_regular_price();
$sale_price   = (float) $product->get_sale_price();
$discount_pct = ( $is_sale && $reg_price > 0 ) ? round( ( $reg_price - $sale_price ) / $reg_price * 100 ) : 0;
$compat_tags  = function_exists( 'dv_get_compat_tags' ) ? dv_get_compat_tags( $product ) : array();
$labels       = array(
    'low'              => html_entity_decode( '&#1052;&#1072;&#1083;&#1086;', ENT_QUOTES, 'UTF-8' ),
    'new'              => html_entity_decode( '&#1053;&#1086;&#1074;&#1080;&#1085;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ),
    'compare'          => html_entity_decode( '&#1057;&#1088;&#1072;&#1074;&#1085;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
    'wishlist'         => html_entity_decode( '&#1042; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1077;', ENT_QUOTES, 'UTF-8' ),
    'price_request'    => html_entity_decode( '&#1062;&#1077;&#1085;&#1072; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091;', ENT_QUOTES, 'UTF-8' ),
    'in_stock'         => html_entity_decode( '&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
    'out_of_stock'     => html_entity_decode( '&#1053;&#1077;&#1090; &#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
    'article'          => html_entity_decode( '&#1040;&#1088;&#1090;:', ENT_QUOTES, 'UTF-8' ),
    'to_cart'          => html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
    'in_cart'          => html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1077;', ENT_QUOTES, 'UTF-8' ),
    'details'          => html_entity_decode( '&#1055;&#1086;&#1076;&#1088;&#1086;&#1073;&#1085;&#1077;&#1077;', ENT_QUOTES, 'UTF-8' ),
    'stock_qty'        => html_entity_decode( '&#1096;&#1090;.', ENT_QUOTES, 'UTF-8' ),
);
?>

<li <?php wc_product_class( 'dv-card', $product ); ?>>
  <div class="dv-card-inner">
    <a href="<?php echo esc_url( $permalink ); ?>" class="dv-card-img-link">
      <div class="dv-card-img">
        <?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </div>

      <?php if ( $show_badges ) : ?>
      <div class="dv-card-badges">
        <?php if ( $is_sale && $discount_pct > 0 ) : ?>
          <span class="dv-badge dv-badge-sale">-<?php echo esc_html( $discount_pct ); ?>%</span>
        <?php elseif ( $in_stock && $stock && $stock <= 3 ) : ?>
          <span class="dv-badge dv-badge-low"><?php echo esc_html( $labels['low'] ); ?></span>
        <?php elseif ( $is_new ) : ?>
          <span class="dv-badge dv-badge-new"><?php echo esc_html( $labels['new'] ); ?></span>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <?php if ( $show_actions ) : ?>
      <div class="product-card-actions">
        <button class="product-action-btn dv-compare-btn" type="button" data-product-id="<?php echo esc_attr( $product_id ); ?>" title="<?php echo esc_attr( $labels['compare'] ); ?>" aria-label="<?php echo esc_attr( $labels['compare'] . ': ' . $display_name ); ?>">
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </button>
        <button class="product-action-btn dv-wishlist-btn" type="button" data-product-id="<?php echo esc_attr( $product_id ); ?>" title="<?php echo esc_attr( $labels['wishlist'] ); ?>" aria-label="<?php echo esc_attr( $labels['wishlist'] . ': ' . $display_name ); ?>">
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
        </button>
      </div>
      <?php endif; ?>
    </a>

    <div class="dv-card-body">
      <?php
      $terms = get_the_terms( $product_id, 'product_cat' );
      if ( $terms && ! is_wp_error( $terms ) ) :
          $cat = $terms[0];
      ?>
      <div class="dv-card-cat"><?php echo esc_html( $cat->name ); ?></div>
      <?php endif; ?>

      <a href="<?php echo esc_url( $permalink ); ?>" class="dv-card-name">
        <?php echo esc_html( $display_name ); ?>
      </a>

      <?php if ( $show_compat && ! empty( $compat_tags ) ) : ?>
      <div class="dv-card-compat">
        <?php foreach ( array_slice( $compat_tags, 0, 4 ) as $tag ) : ?>
          <span class="dv-compat-chip"><?php echo esc_html( $tag ); ?></span>
        <?php endforeach; ?>
        <?php if ( count( $compat_tags ) > 4 ) : ?>
          <span class="dv-compat-more">+<?php echo esc_html( count( $compat_tags ) - 4 ); ?></span>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <?php if ( $show_rating && $rating > 0 ) : ?>
      <div class="dv-card-rating">
        <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
          <svg width="11" height="11" viewBox="0 0 24 24">
            <path
              d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"
              fill="<?php echo $i <= round( $rating ) ? '#F59E0B' : 'none'; ?>"
              stroke="<?php echo $i <= round( $rating ) ? '#F59E0B' : '#D1D5DB'; ?>"
              stroke-width="1.5"
            />
          </svg>
        <?php endfor; ?>
        <span class="dv-card-rating-cnt">(<?php echo esc_html( $review_count ); ?>)</span>
      </div>
      <?php endif; ?>
    </div>

    <div class="dv-card-footer">
      <div class="dv-card-price-block">
        <?php if ( $is_sale && $reg_price > 0 ) : ?>
          <span class="dv-price-main"><?php echo esc_html( number_format( $sale_price, 0, '.', ' ' ) ); ?> ₽</span>
          <span class="dv-price-old"><?php echo esc_html( number_format( $reg_price, 0, '.', ' ' ) ); ?> ₽</span>
        <?php elseif ( $price > 0 ) : ?>
          <span class="dv-price-main"><?php echo esc_html( number_format( $price, 0, '.', ' ' ) ); ?> ₽</span>
        <?php else : ?>
          <span class="dv-price-req"><?php echo esc_html( $labels['price_request'] ); ?></span>
        <?php endif; ?>
      </div>

      <div class="dv-card-stock-row">
        <?php if ( $in_stock ) : ?>
          <?php
          $stock_cls = ( $stock && $stock <= 3 ) ? 'low' : 'in';
          $stock_lbl = ( 'low' === $stock_cls ) ? $labels['low'] : $labels['in_stock'];
          ?>
          <span class="dv-stock <?php echo esc_attr( $stock_cls ); ?>">
            <span class="dv-stock-dot"></span>
            <?php echo esc_html( $stock_lbl ); ?>
            <?php if ( $show_stock_qty && $stock ) : ?>
              <span class="dv-stock-qty"><?php echo esc_html( $stock ); ?> шт.</span>
            <?php endif; ?>
          </span>
        <?php else : ?>
          <span class="dv-stock out"><span class="dv-stock-dot"></span><?php echo esc_html( $labels['out_of_stock'] ); ?></span>
        <?php endif; ?>
      </div>

      <?php if ( $show_sku && $sku ) : ?>
        <div class="dv-card-sku-row">
          <span class="dv-card-sku"><?php echo esc_html( $labels['article'] ); ?> <?php echo esc_html( $sku ); ?></span>
        </div>
      <?php endif; ?>

      <div class="dv-card-btns">
        <?php if ( $in_stock ) : ?>
          <button
            class="dv-btn-cart<?php echo $is_in_cart ? ' is-in-cart' : ''; ?>"
            type="button"
            data-product-id="<?php echo esc_attr( $product_id ); ?>"
            data-label-default="<?php echo esc_attr( $labels['to_cart'] ); ?>"
            data-label-in-cart="<?php echo esc_attr( $labels['in_cart'] ); ?>"
            aria-label="<?php echo esc_attr( ( $is_in_cart ? $labels['in_cart'] : $labels['to_cart'] ) . ': ' . $display_name ); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
              <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
              <line x1="3" y1="6" x2="21" y2="6"/>
              <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
            <span><?php echo esc_html( $is_in_cart ? $labels['in_cart'] : $labels['to_cart'] ); ?></span>
          </button>
        <?php else : ?>
          <button class="dv-btn-cart dv-btn-cart--out" disabled><?php echo esc_html( $labels['out_of_stock'] ); ?></button>
        <?php endif; ?>

        <a href="<?php echo esc_url( $permalink ); ?>" class="dv-btn-view" title="<?php echo esc_attr( $labels['details'] ); ?>" aria-label="<?php echo esc_attr( $labels['details'] . ': ' . $display_name ); ?>">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
            <circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</li>
