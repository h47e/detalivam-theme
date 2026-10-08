<?php
defined( 'ABSPATH' ) || exit;

function dv_customer_discount_meta_key() {
    return '_dv_customer_discount_percent';
}

function dv_customer_discount_percent( $user_id = 0 ) {
    $user_id = absint( $user_id ?: get_current_user_id() );

    if ( ! $user_id ) {
        return 0;
    }

    $discount = (float) get_user_meta( $user_id, dv_customer_discount_meta_key(), true );

    return max( 0, min( 90, $discount ) );
}

function dv_customer_discount_can_apply() {
    if ( ! is_user_logged_in() || dv_customer_discount_percent() <= 0 ) {
        return false;
    }

    if ( is_admin() && ( ! function_exists( 'wp_doing_ajax' ) || ! wp_doing_ajax() ) ) {
        return false;
    }

    if ( function_exists( 'dv_is_product_feed_request' ) && dv_is_product_feed_request() ) {
        return false;
    }

    return true;
}

function dv_customer_discount_is_payment_context() {
    if ( function_exists( 'dv_is_order_pay_request' ) && dv_is_order_pay_request() ) {
        return true;
    }

    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return true;
    }

    if ( function_exists( 'is_checkout_pay_page' ) && is_checkout_pay_page() ) {
        return true;
    }

    if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-pay' ) ) {
        return true;
    }

    if ( ! empty( $_GET['pay_for_order'] ) || false !== get_query_var( 'order-pay', false ) ) {
        return true;
    }

    if ( ! empty( $_REQUEST['woocommerce_pay'] ) ) {
        return true;
    }

    if ( isset( $_REQUEST['wc-ajax'] ) ) {
        $wc_ajax_action = sanitize_key( wp_unslash( $_REQUEST['wc-ajax'] ) );
        $payment_actions = array(
            'checkout',
            'update_order_review',
            'apply_coupon',
            'remove_coupon',
        );

        if ( in_array( $wc_ajax_action, $payment_actions, true ) ) {
            return true;
        }
    }

    return false;
}

function dv_customer_discount_is_active_context() {
    if ( ! dv_customer_discount_can_apply() ) {
        return false;
    }

    if ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) {
        return false;
    }

    if ( function_exists( 'is_cart' ) && is_cart() ) {
        return false;
    }

    if ( function_exists( 'is_checkout' ) && is_checkout() ) {
        return false;
    }

    if ( dv_customer_discount_is_payment_context() ) {
        return false;
    }

    return true;
}

function dv_customer_discount_apply_to_price( $price, $discount = null ) {
    if ( '' === (string) $price || ! is_numeric( $price ) || (float) $price <= 0 ) {
        return $price;
    }

    $discount = null === $discount ? dv_customer_discount_percent() : (float) $discount;
    if ( $discount <= 0 ) {
        return $price;
    }

    return max( 0, (float) $price * ( 100 - min( 90, $discount ) ) / 100 );
}

function dv_customer_discount_base_product_price( $product ) {
    if ( ! $product instanceof WC_Product ) {
        return 0;
    }

    $base_price = (float) get_post_meta( $product->get_id(), '_price', true );

    if ( $base_price <= 0 && $product->is_type( 'variation' ) ) {
        $base_price = (float) get_post_meta( $product->get_parent_id(), '_price', true );
    }

    if ( $base_price <= 0 && method_exists( $product, 'get_price' ) ) {
        $base_price = (float) $product->get_price( 'edit' );
    }

    return $base_price;
}

function dv_customer_discount_product_price( $price, $product ) {
    if ( ! dv_customer_discount_is_active_context() ) {
        return $price;
    }

    return dv_customer_discount_apply_to_price( $price );
}
add_filter( 'woocommerce_product_get_price', 'dv_customer_discount_product_price', 20, 2 );
add_filter( 'woocommerce_product_variation_get_price', 'dv_customer_discount_product_price', 20, 2 );
add_filter( 'woocommerce_variation_prices_price', 'dv_customer_discount_product_price', 20, 2 );

function dv_customer_discount_price_html( $price_html, $product ) {
    if ( ! dv_customer_discount_is_active_context() || ! $product instanceof WC_Product ) {
        return $price_html;
    }

    $discount = dv_customer_discount_percent();
    if ( $discount <= 0 ) {
        return $price_html;
    }

    $base_price = dv_customer_discount_base_product_price( $product );
    if ( $base_price <= 0 && $product->is_type( 'variable' ) ) {
        return $price_html;
    }

    $discounted = dv_customer_discount_apply_to_price( $base_price, $discount );
    if ( $base_price <= 0 || $discounted <= 0 || $discounted >= $base_price ) {
        return $price_html;
    }

    return '<span class="price dv-customer-discount-price"><span class="dv-customer-discount-label">Ваша цена с учетом скидки</span><del>' . wc_price( $base_price ) . '</del> <ins>' . wc_price( $discounted ) . '</ins> <small>-' . esc_html( rtrim( rtrim( number_format( $discount, 2, '.', '' ), '0' ), '.' ) ) . '%</small></span>';
}
add_filter( 'woocommerce_get_price_html', 'dv_customer_discount_price_html', 20, 2 );

function dv_customer_discount_cart_prices( $cart ) {
    if ( ! $cart instanceof WC_Cart || $cart->is_empty() || ! dv_customer_discount_can_apply() ) {
        return;
    }

    $discount = dv_customer_discount_percent();
    if ( $discount <= 0 ) {
        return;
    }

    foreach ( $cart->get_cart() as $cart_item ) {
        $product = isset( $cart_item['data'] ) ? $cart_item['data'] : null;
        if ( ! $product instanceof WC_Product ) {
            continue;
        }

        $base_price = dv_customer_discount_base_product_price( $product );
        if ( $base_price <= 0 && method_exists( $product, 'get_price' ) ) {
            $base_price = (float) $product->get_price( 'edit' );
        }

        if ( $base_price <= 0 ) {
            continue;
        }

        $discounted_price = dv_customer_discount_apply_to_price( $base_price, $discount );
        if ( $discounted_price <= 0 || $discounted_price >= $base_price ) {
            continue;
        }

        $product->set_price( wc_format_decimal( $discounted_price, wc_get_price_decimals() + 2 ) );
    }
}
add_action( 'woocommerce_before_calculate_totals', 'dv_customer_discount_cart_prices', 20 );

function dv_customer_discount_store_order_percent( $order, $data ) {
    if ( ! $order instanceof WC_Order || ! dv_customer_discount_can_apply() ) {
        return;
    }

    $discount = dv_customer_discount_percent();
    if ( $discount > 0 ) {
        $order->update_meta_data( dv_customer_discount_meta_key(), $discount );
    }
}
add_action( 'woocommerce_checkout_create_order', 'dv_customer_discount_store_order_percent', 20, 2 );

function dv_customer_discount_profile_field( $user ) {
    if ( ! current_user_can( 'edit_users' ) || ! $user instanceof WP_User ) {
        return;
    }

    $discount = dv_customer_discount_percent( $user->ID );
    ?>
    <h2><?php echo esc_html( 'Персональная скидка' ); ?></h2>
    <table class="form-table" role="presentation">
        <tr>
            <th><label for="dv_customer_discount_percent"><?php echo esc_html( 'Скидка клиента, %' ); ?></label></th>
            <td>
                <input
                    type="number"
                    class="small-text"
                    min="0"
                    max="90"
                    step="0.1"
                    id="dv_customer_discount_percent"
                    name="dv_customer_discount_percent"
                    value="<?php echo esc_attr( (string) $discount ); ?>"
                >
                <p class="description"><?php echo esc_html( 'Применяется к ценам на сайте и в корзине для этого залогиненного клиента. 0 - скидка выключена.' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'dv_customer_discount_profile_field' );
add_action( 'edit_user_profile', 'dv_customer_discount_profile_field' );

function dv_customer_discount_save_profile_field( $user_id ) {
    $user_id = absint( $user_id );
    if ( ! $user_id || ! current_user_can( 'edit_user', $user_id ) ) {
        return;
    }

    $raw      = isset( $_POST['dv_customer_discount_percent'] ) ? wp_unslash( $_POST['dv_customer_discount_percent'] ) : '0';
    $discount = max( 0, min( 90, (float) str_replace( ',', '.', (string) $raw ) ) );

    if ( $discount > 0 ) {
        update_user_meta( $user_id, dv_customer_discount_meta_key(), $discount );
    } else {
        delete_user_meta( $user_id, dv_customer_discount_meta_key() );
    }
}
add_action( 'personal_options_update', 'dv_customer_discount_save_profile_field' );
add_action( 'edit_user_profile_update', 'dv_customer_discount_save_profile_field' );
