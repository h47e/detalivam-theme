<?php
/**
 * Checkout form
 *
 * Theme wrapper around standard WooCommerce checkout hooks.
 *
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

$checkout_coupon_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'checkout_coupon_enabled' ) : true;
$checkout_login_enabled  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'checkout_login_enabled' ) : true;

if ( ! $checkout_coupon_enabled ) {
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}

if ( ! $checkout_login_enabled ) {
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
}

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}
?>

<div class="checkout-page">
  <form
    name="checkout"
    method="post"
    class="checkout woocommerce-checkout"
    action="<?php echo esc_url( wc_get_checkout_url() ); ?>"
    enctype="multipart/form-data"
    aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>"
  >
    <div class="checkout-layout">
      <div class="checkout-form">
        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

        <?php if ( $checkout->get_checkout_fields() ) : ?>
          <section class="checkout-section">
            <div class="checkout-section-head">
              <div class="checkout-section-title"><span>1</span>&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1085;&#1099;&#1077; &#1076;&#1072;&#1085;&#1085;&#1099;&#1077;</div>
            </div>
            <div class="checkout-section-body" id="customer_details">
              <?php do_action( 'woocommerce_checkout_billing' ); ?>
            </div>
          </section>

          <?php if ( WC()->cart->needs_shipping() ) : ?>
            <section class="checkout-section">
              <div class="checkout-section-head">
                <div class="checkout-section-title"><span>2</span>&#1044;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072;</div>
              </div>
              <div class="checkout-section-body">
                <?php do_action( 'woocommerce_checkout_shipping' ); ?>
              </div>
            </section>
          <?php endif; ?>
        <?php endif; ?>

        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
      </div>

      <aside class="checkout-sidebar">
        <div class="order-summary">
          <div class="order-summary-head">
            <h3>&#1042;&#1072;&#1096; &#1079;&#1072;&#1082;&#1072;&#1079;</h3>
          </div>
          <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
          <div id="order_review" class="woocommerce-checkout-review-order">
            <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
            <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
          </div>
        </div>
      </aside>
    </div>
  </form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
