<?php
/**
 * Cart Page
 *
 * Theme override for WooCommerce cart contents.
 *
 * @version 10.8.0
 */

defined( 'ABSPATH' ) || exit;

$labels = [
    'product'   => '&#1058;&#1086;&#1074;&#1072;&#1088;',
    'price'     => '&#1062;&#1077;&#1085;&#1072;',
    'qty'       => '&#1050;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086;',
    'total'     => '&#1057;&#1091;&#1084;&#1084;&#1072;',
    'backorder' => '&#1044;&#1086;&#1089;&#1090;&#1091;&#1087;&#1085;&#1086; &#1076;&#1083;&#1103; &#1087;&#1088;&#1077;&#1076;&#1079;&#1072;&#1082;&#1072;&#1079;&#1072;',
    'remove'    => '&#1059;&#1076;&#1072;&#1083;&#1080;&#1090;&#1100; &#1090;&#1086;&#1074;&#1072;&#1088;',
    'coupon'    => '&#1055;&#1088;&#1086;&#1084;&#1086;&#1082;&#1086;&#1076;',
    'apply'     => '&#1055;&#1088;&#1080;&#1084;&#1077;&#1085;&#1080;&#1090;&#1100;',
    'update'    => '&#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1100; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;',
];

$cart_coupon_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'cart_coupon_enabled' ) : true;
$cart_cross_sells_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'cart_cross_sells_enabled' ) : true;
$cart_product_image_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'cart_product_image_enabled' ) : true;
$cart_price_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'cart_price_enabled' ) : true;
$cart_subtotal_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'cart_subtotal_enabled' ) : true;
$cart_columns_classes = array( 'cart-columns' );

if ( ! $cart_price_enabled ) {
    $cart_columns_classes[] = 'cart-columns--no-price';
}

if ( ! $cart_subtotal_enabled ) {
    $cart_columns_classes[] = 'cart-columns--no-subtotal';
}

$cart_columns_class = implode( ' ', $cart_columns_classes );
?>

<?php do_action( 'woocommerce_before_cart' ); ?>

<?php if ( WC()->cart && WC()->cart->is_empty() ) : ?>
  <div class="cart-page">
    <?php do_action( 'woocommerce_cart_is_empty' ); ?>
  </div>
  <?php do_action( 'woocommerce_after_cart' ); ?>
  <?php return; ?>
<?php endif; ?>

<div class="cart-page">
  <?php $cross_sell_ids = WC()->cart ? WC()->cart->get_cross_sells() : []; ?>
  <div class="cart-layout">
    <div class="cart-items">
      <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php do_action( 'woocommerce_before_cart_table' ); ?>

        <div class="cart-header <?php echo esc_attr( $cart_columns_class ); ?>">
          <div><?php echo wp_kses_post( $labels['product'] ); ?></div>
          <?php if ( $cart_price_enabled ) : ?>
            <div><?php echo wp_kses_post( $labels['price'] ); ?></div>
          <?php endif; ?>
          <div><?php echo wp_kses_post( $labels['qty'] ); ?></div>
          <?php if ( $cart_subtotal_enabled ) : ?>
            <div><?php echo wp_kses_post( $labels['total'] ); ?></div>
          <?php endif; ?>
          <div></div>
        </div>

        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>
          <?php
          $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
          $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
          $visible    = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key );

          if ( ! ( $_product instanceof WC_Product ) || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! $visible ) {
              continue;
          }

          $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
          $product_permalink = apply_filters(
              'woocommerce_cart_item_permalink',
              $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '',
              $cart_item,
              $cart_item_key
          );

          $thumbnail = apply_filters(
              'woocommerce_cart_item_thumbnail',
              $_product->get_image( 'woocommerce_thumbnail' ),
              $cart_item,
              $cart_item_key
          );
          ?>
          <div <?php wc_product_class( apply_filters( 'woocommerce_cart_item_class', 'cart-item woocommerce-cart-form__cart-item cart_item ' . $cart_columns_class, $cart_item, $cart_item_key ), $_product ); ?>>
            <div class="cart-product" data-title="<?php echo esc_attr( html_entity_decode( $labels['product'], ENT_QUOTES, 'UTF-8' ) ); ?>">
              <?php if ( $cart_product_image_enabled ) : ?>
              <div class="cart-product-img">
                <?php if ( $product_permalink ) : ?>
                  <a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo wp_kses_post( $thumbnail ); ?></a>
                <?php else : ?>
                  <?php echo wp_kses_post( $thumbnail ); ?>
                <?php endif; ?>
              </div>
              <?php endif; ?>

              <div class="cart-product-info">
                <div class="cart-product-name">
                  <?php if ( $product_permalink ) : ?>
                    <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) ); ?>
                  <?php else : ?>
                    <?php echo wp_kses_post( $product_name . '&nbsp;' ); ?>
                  <?php endif; ?>
                </div>

                <?php do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key ); ?>
                <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>

                <?php if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) : ?>
                  <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . wp_kses_post( $labels['backorder'] ) . '</p>', $product_id ) ); ?>
                <?php endif; ?>
              </div>
            </div>

            <?php if ( $cart_price_enabled ) : ?>
              <div class="cart-price" data-title="<?php echo esc_attr( html_entity_decode( $labels['price'], ENT_QUOTES, 'UTF-8' ) ); ?>">
                <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) ); ?>
              </div>
            <?php endif; ?>

            <div data-title="<?php echo esc_attr( html_entity_decode( $labels['qty'], ENT_QUOTES, 'UTF-8' ) ); ?>">
              <?php
              if ( $_product->is_sold_individually() ) {
                  $min_quantity = 1;
                  $max_quantity = 1;
              } else {
                  $min_quantity = 0;
                  $max_quantity = $_product->get_max_purchase_quantity();
              }
              ?>
              <div class="cart-qty-wrap">
                <?php
                ob_start();
                ?>
                  <button type="button" class="cart-qty-btn" data-delta="-1" aria-label="<?php echo esc_attr( html_entity_decode( '&#1059;&#1084;&#1077;&#1085;&#1100;&#1096;&#1080;&#1090;&#1100; &#1082;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086;', ENT_QUOTES, 'UTF-8' ) ); ?>">-</button>
                  <input
                    class="cart-qty-input qty"
                    type="number"
                    name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
                    value="<?php echo esc_attr( $cart_item['quantity'] ); ?>"
                    min="<?php echo esc_attr( $min_quantity ); ?>"
                    max="<?php echo esc_attr( 0 < $max_quantity ? $max_quantity : 999 ); ?>"
                    step="1"
                    aria-label="<?php echo esc_attr( wp_strip_all_tags( $product_name ) ); ?>"
                  >
                  <button type="button" class="cart-qty-btn" data-delta="1" aria-label="<?php echo esc_attr( html_entity_decode( '&#1059;&#1074;&#1077;&#1083;&#1080;&#1095;&#1080;&#1090;&#1100; &#1082;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086;', ENT_QUOTES, 'UTF-8' ) ); ?>">+</button>
                <?php
                $product_quantity = ob_get_clean();
                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                ?>
              </div>
            </div>

            <?php if ( $cart_subtotal_enabled ) : ?>
              <div class="cart-total-price" data-title="<?php echo esc_attr( html_entity_decode( $labels['total'], ENT_QUOTES, 'UTF-8' ) ); ?>">
                <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) ); ?>
              </div>
            <?php endif; ?>

            <div class="cart-remove">
              <?php
              echo apply_filters(
                  'woocommerce_cart_item_remove_link',
                  sprintf(
                      '<a role="button" href="%s" class="cart-remove-btn remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg viewBox="0 0 24 24"><path d="M18 6L6 18"/><path d="M6 6l12 12"/></svg></a>',
                      esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                      esc_attr( sprintf( '%s: %s', html_entity_decode( $labels['remove'], ENT_QUOTES, 'UTF-8' ), wp_strip_all_tags( $product_name ) ) ),
                      esc_attr( $product_id ),
                      esc_attr( $_product->get_sku() )
                  ),
                  $cart_item_key
              );
              ?>
            </div>
          </div>
        <?php endforeach; ?>

        <?php do_action( 'woocommerce_cart_contents' ); ?>

        <input type="hidden" id="dv-update-cart-btn" name="update_cart" value="<?php echo esc_attr( html_entity_decode( $labels['update'], ENT_QUOTES, 'UTF-8' ) ); ?>">

        <?php if ( $cart_coupon_enabled && wc_coupons_enabled() ) : ?>
          <div class="cart-coupon">
            <div class="cart-actions-row">
              <div class="cart-coupon-row">
                <input type="text" name="coupon_code" id="coupon_code" value="" placeholder="<?php echo esc_attr( html_entity_decode( $labels['coupon'], ENT_QUOTES, 'UTF-8' ) ); ?>">
                <button type="submit" class="btn-coupon" name="apply_coupon" value="<?php echo esc_attr( html_entity_decode( $labels['apply'], ENT_QUOTES, 'UTF-8' ) ); ?>">
                  <?php echo wp_kses_post( $labels['apply'] ); ?>
                </button>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
        <?php do_action( 'woocommerce_after_cart_table' ); ?>
      </form>

    </div>

    <aside class="cart-sidebar">
      <div class="cart-collaterals">
        <?php do_action( 'woocommerce_cart_collaterals' ); ?>
      </div>
    </aside>
  </div>

  <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

  <?php if ( $cart_cross_sells_enabled && ! empty( $cross_sell_ids ) ) : ?>
    <div class="cross-sells-wrap">
      <?php woocommerce_cross_sell_display( 4, 4 ); ?>
    </div>
  <?php endif; ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
