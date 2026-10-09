<?php
defined( 'ABSPATH' ) || exit;

function dv_cart_selection_keys( $posted, $contents ) {
    if ( ! is_array( $posted ) ) {
        return array();
    }
    return array_values( array_intersect( array_keys( $contents ), array_filter( $posted, 'is_string' ) ) );
}

function dv_cart_selection_partition( $cart, $keys ) {
    $contents = $cart->get_cart();
    $selected = array_intersect_key( $contents, array_fill_keys( $keys, true ) );
    if ( ! $selected ) {
        return false;
    }
    $held = (array) WC()->session->get( 'dv_cart_held_items', array() );
    foreach ( array_diff_key( $contents, $selected ) as $key => $item ) {
        unset( $item['data'] );
        $held[ $key ] = $item;
    }
    // Store deferred lines before changing the active cart, including variation/add-on data.
    WC()->session->set( 'dv_cart_held_items', $held );
    WC()->session->set( 'dv_cart_unselected_keys', array_keys( array_diff_key( $contents, $selected ) ) );
    $cart->set_cart_contents( $selected );
    $cart->calculate_totals();
    return true;
}

function dv_cart_selection_restore( $cart ) {
    $held = (array) WC()->session->get( 'dv_cart_held_items', array() );
    if ( ! $held ) {
        return;
    }
    foreach ( $held as $key => $item ) {
        $extra = $item;
        foreach ( array( 'key', 'product_id', 'variation_id', 'variation', 'quantity', 'data', 'data_hash', 'line_tax_data', 'line_subtotal', 'line_subtotal_tax', 'line_total', 'line_tax' ) as $field ) {
            unset( $extra[ $field ] );
        }
        $restored = $cart->add_to_cart(
            absint( $item['product_id'] ?? 0 ),
            $item['quantity'] ?? 1,
            absint( $item['variation_id'] ?? 0 ),
            (array) ( $item['variation'] ?? array() ),
            $extra
        );
        if ( $restored ) {
            unset( $held[ $key ] );
            // Persist after each successful addition, preventing duplicate restoration.
            WC()->session->set( 'dv_cart_held_items', $held );
        }
    }
}

function dv_cart_selection_request() {
    if ( ! function_exists( 'WC' ) || ! WC()->cart || ! WC()->session ) {
        return;
    }
    if ( is_cart() ) {
        dv_cart_selection_restore( WC()->cart );
    }
    if ( empty( $_POST['dv_selected_checkout'] ) ) {
        return;
    }
    $nonce = isset( $_POST['dv_selection_nonce'] ) && is_string( $_POST['dv_selection_nonce'] ) ? wp_unslash( $_POST['dv_selection_nonce'] ) : '';
    if ( ! wp_verify_nonce( $nonce, 'dv_cart_selection' ) ) {
        wc_add_notice( 'Не удалось подтвердить выбор. Обновите корзину и попробуйте снова.', 'error' );
        wp_safe_redirect( wc_get_cart_url() );
        exit;
    }
    $keys = dv_cart_selection_keys( wp_unslash( $_POST['dv_cart_selected'] ?? array() ), WC()->cart->get_cart() );
    if ( ! dv_cart_selection_partition( WC()->cart, $keys ) ) {
        wc_add_notice( 'Выберите хотя бы один товар для заказа.', 'error' );
        wp_safe_redirect( wc_get_cart_url() );
        exit;
    }
    wp_safe_redirect( wc_get_checkout_url() );
    exit;
}
add_action( 'template_redirect', 'dv_cart_selection_request', 1 );

function dv_cart_selection_button() {
    if ( ! is_cart() ) {
        woocommerce_button_proceed_to_checkout();
        return;
    }
    ?>
    <div class="dv-cart-selected-summary" data-dv-selected-summary hidden aria-live="polite"></div>
    <span class="dv-cart-selection-status" data-dv-selection-status aria-live="polite"></span>
    <button type="submit" form="dv-cart-selection-form" class="checkout-button button alt wc-forward" data-dv-selected-checkout>Оформить выбранные</button>
    <?php
}

function dv_cart_selection_setup_button() {
    if ( ! function_exists( 'WC' ) ) {
        return;
    }
    remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
    add_action( 'woocommerce_proceed_to_checkout', 'dv_cart_selection_button', 20 );
}
add_action( 'wp', 'dv_cart_selection_setup_button' );

function dv_cart_selection_preview( $keys ) {
    $wc = WC();
    $original_cart = $wc->cart;
    $original_session = $wc->session;
    $original_customer = $wc->customer;
    $original_shipping = $wc->shipping();
    $selected = array_intersect_key( $original_cart->get_cart(), array_fill_keys( $keys, true ) );
    $no_persistence = static function () { return false; };
    $preview = clone $original_cart;
    foreach ( $selected as &$item ) {
        $item['data'] = clone $item['data'];
    }
    unset( $item );
    $preview->set_cart_contents( $selected );
    $temporary_session = clone $original_session;
    $temporary_customer = clone $original_customer;
    $temporary_shipping = clone $original_shipping;
    // Native totals run against temporary objects, never the buyer's stored cart/session.
    $wc->cart = $preview;
    $wc->session = $temporary_session;
    $wc->customer = $temporary_customer;
    $wc->shipping = $temporary_shipping;
    add_filter( 'woocommerce_persistent_cart_enabled', $no_persistence, PHP_INT_MAX );
    try {
        $preview->calculate_totals();
        $base = 0.0;
        $quantity = 0;
        foreach ( $preview->get_cart() as $item ) {
            $product = $item['data'];
            $regular = $product->get_regular_price();
            $base += wc_get_price_to_display( $product, array(
                'price' => max( (float) $product->get_price(), '' === $regular ? (float) $product->get_price() : (float) $regular ),
                'qty' => $item['quantity'],
                'display_context' => 'cart',
            ) );
            $quantity += $item['quantity'];
        }
        $goods = $preview->get_cart_contents_total();
        if ( $preview->display_prices_including_tax() ) {
            $goods += $preview->get_cart_contents_tax();
        }
        $shipping = 'При оформлении';
        $shipping_cost = $preview->get_shipping_total() + ( $preview->display_prices_including_tax() ? $preview->get_shipping_tax() : 0 );
        if ( $shipping_cost > 0 ) {
            $shipping = wc_price( $shipping_cost );
        } else {
            $methods = $preview->get_shipping_methods();
            if ( $methods ) {
                $shipping = esc_html( implode( ', ', array_map( static function ( $method ) { return $method->get_label(); }, $methods ) ) );
            }
        }
        return array(
            'quantity' => $quantity,
            'base' => wc_price( $base ),
            'discount' => wc_price( max( 0, $base - $goods ) ),
            'has_discount' => $base - $goods > 0.005,
            'shipping' => $selected && $preview->needs_shipping() ? $shipping : '',
            'fees' => $preview->get_fee_total() > 0 ? wc_price( $preview->get_fee_total() + ( $preview->display_prices_including_tax() ? $preview->get_fee_tax() : 0 ) ) : '',
            'tax' => ! $preview->display_prices_including_tax() && $preview->get_total_tax() > 0 ? wc_price( $preview->get_total_tax() ) : '',
            'total' => wc_price( $preview->get_total( 'edit' ) ),
        );
    } finally {
        remove_filter( 'woocommerce_persistent_cart_enabled', $no_persistence, PHP_INT_MAX );
        $wc->cart = $original_cart;
        $wc->session = $original_session;
        $wc->customer = $original_customer;
        $wc->shipping = $original_shipping;
    }
}

function dv_ajax_cart_selection_preview() {
    $nonce = isset( $_POST['nonce'] ) && is_string( $_POST['nonce'] ) ? wp_unslash( $_POST['nonce'] ) : '';
    if ( ! wp_verify_nonce( $nonce, 'dv_cart_selection' ) ) {
        wp_send_json_error( array( 'message' => 'Обновите корзину и попробуйте снова.' ), 403 );
    }
    if ( function_exists( 'wc_load_cart' ) ) {
        wc_load_cart();
    }
    if ( ! WC()->cart || ! WC()->session ) {
        wp_send_json_error( array( 'message' => 'Корзина недоступна.' ), 400 );
    }
    $keys = dv_cart_selection_keys( wp_unslash( $_POST['keys'] ?? array() ), WC()->cart->get_cart() );
    try {
        $summary = dv_cart_selection_preview( $keys );
    } catch ( Throwable $error ) {
        wp_send_json_error( array( 'message' => 'Не удалось пересчитать корзину. Попробуйте ещё раз.' ), 500 );
    }
    ob_start();
    ?>
    <dl class="dv-cart-summary-lines">
        <div><dt>Товары (<?php echo esc_html( $summary['quantity'] ); ?>)</dt><dd><?php echo wp_kses_post( $summary['base'] ); ?></dd></div>
        <?php if ( $summary['has_discount'] ) : ?>
            <div><dt>Скидка</dt><dd class="dv-cart-summary-discount">−<?php echo wp_kses_post( $summary['discount'] ); ?></dd></div>
        <?php endif; ?>
        <?php if ( $summary['shipping'] ) : ?>
            <div><dt>Доставка</dt><dd><?php echo wp_kses_post( $summary['shipping'] ); ?></dd></div>
        <?php endif; ?>
        <?php if ( $summary['fees'] ) : ?>
            <div><dt>Дополнительные начисления</dt><dd><?php echo wp_kses_post( $summary['fees'] ); ?></dd></div>
        <?php endif; ?>
        <?php if ( $summary['tax'] ) : ?>
            <div><dt>Налог</dt><dd><?php echo wp_kses_post( $summary['tax'] ); ?></dd></div>
        <?php endif; ?>
        <div class="dv-cart-summary-total"><dt>Итого</dt><dd><?php echo wp_kses_post( $summary['total'] ); ?></dd></div>
    </dl>
    <?php
    wp_send_json_success( array( 'html' => trim( ob_get_clean() ) ) );
}
add_action( 'wp_ajax_dv_cart_selection_preview', 'dv_ajax_cart_selection_preview' );
add_action( 'wp_ajax_nopriv_dv_cart_selection_preview', 'dv_ajax_cart_selection_preview' );
