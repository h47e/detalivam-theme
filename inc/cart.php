<?php
defined( 'ABSPATH' ) || exit;

function dv_cart_labels() {
    return array(
        'cart_short_title' => html_entity_decode( '&#1050;&#1086;&#1088;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'cart_empty'       => html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1077; &#1087;&#1086;&#1082;&#1072; &#1087;&#1091;&#1089;&#1090;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'subtotal'         => html_entity_decode( '&#1048;&#1090;&#1086;&#1075;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'go_cart'          => html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'go_cart_short'    => html_entity_decode( '&#1054;&#1090;&#1082;&#1088;&#1099;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
        'go_checkout'      => html_entity_decode( '&#1054;&#1092;&#1086;&#1088;&#1084;&#1080;&#1090;&#1100; &#1079;&#1072;&#1082;&#1072;&#1079;', ENT_QUOTES, 'UTF-8' ),
    );
}

function dv_cart_prepare_json_response() {
    while ( ob_get_level() ) {
        ob_end_clean();
    }
}

function dv_cart_security_error_message() {
    $labels = function_exists( 'dv_theme_labels' ) ? dv_theme_labels() : array();

    return $labels['security_error'] ?? html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1073;&#1077;&#1079;&#1086;&#1087;&#1072;&#1089;&#1085;&#1086;&#1089;&#1090;&#1080;. &#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1077; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1091;.', ENT_QUOTES, 'UTF-8' );
}

function dv_cart_verify_ajax_nonce() {
    if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ?? '' ) ), 'dv_add_cart' ) ) {
        return;
    }

    dv_cart_prepare_json_response();
    wp_send_json_error( array( 'message' => dv_cart_security_error_message() ), 403 );
}

function dv_render_cart_preview_html() {
    $labels = dv_cart_labels();

    if ( function_exists( 'wc_load_cart' ) ) {
        wc_load_cart();
    }

    $cart = WC()->cart;

    if ( ! $cart || $cart->is_empty() ) {
        return '<div class="dv-header-preview-empty">' . esc_html( $labels['cart_empty'] ) . '</div>';
    }

    $items = array_slice( $cart->get_cart(), 0, 4, true );

    ob_start();
    ?>
    <div class="dv-header-preview-head">
        <div class="dv-header-preview-title"><?php echo esc_html( $labels['cart_short_title'] ); ?></div>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="dv-header-preview-all"><?php echo esc_html( $labels['go_cart_short'] ); ?></a>
    </div>
    <div class="dv-header-preview-list">
        <?php foreach ( $items as $cart_item_key => $cart_item ) : ?>
            <?php
            $product = $cart_item['data'] ?? null;

            if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
                continue;
            }

            $product_id = $product->get_id();
            $permalink  = $product->is_visible() ? $product->get_permalink() : wc_get_cart_url();
            $name       = function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name();
            $thumb      = get_the_post_thumbnail_url( $product_id, 'thumbnail' );
            $qty        = (int) ( $cart_item['quantity'] ?? 1 );
            $price      = WC()->cart->get_product_price( $product );
            ?>
            <div class="dv-header-preview-item" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
                <a class="dv-header-preview-thumb-link" href="<?php echo esc_url( $permalink ); ?>">
                    <img
                        class="dv-header-preview-thumb"
                        src="<?php echo esc_url( $thumb ? $thumb : wc_placeholder_img_src( 'thumbnail' ) ); ?>"
                        alt="<?php echo esc_attr( $name ); ?>"
                    >
                </a>
                <div class="dv-header-preview-main">
                    <a class="dv-header-preview-name" href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $name ); ?></a>
                    <div class="dv-header-preview-meta">
                        <span class="dv-header-preview-qty"><?php echo esc_html( $qty ); ?> ×</span>
                        <span class="dv-header-preview-price"><?php echo wp_kses_post( $price ); ?></span>
                    </div>
                    <div class="dv-header-preview-qty-controls" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
                        <button
                            type="button"
                            class="dv-header-preview-qty-btn"
                            data-cart-qty-delta="-1"
                            data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>"
                            data-product-id="<?php echo esc_attr( $product_id ); ?>"
                        >−</button>
                        <span class="dv-header-preview-qty-value"><?php echo esc_html( $qty ); ?></span>
                        <button
                            type="button"
                            class="dv-header-preview-qty-btn"
                            data-cart-qty-delta="1"
                            data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>"
                            data-product-id="<?php echo esc_attr( $product_id ); ?>"
                        >+</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="dv-header-preview-foot">
        <div class="dv-header-preview-subtotal">
            <span><?php echo esc_html( $labels['subtotal'] ); ?></span>
            <strong><?php echo wp_kses_post( $cart->get_cart_total() ); ?></strong>
        </div>
        <div class="dv-header-preview-actions">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="dv-header-preview-btn is-light"><?php echo esc_html( $labels['go_cart'] ); ?></a>
            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="dv-header-preview-btn"><?php echo esc_html( $labels['go_checkout'] ); ?></a>
        </div>
    </div>
    <?php

    return trim( ob_get_clean() );
}

function dv_ajax_get_header_cart_preview() {
    dv_cart_prepare_json_response();
    dv_cart_verify_ajax_nonce();

    wp_send_json_success(
        array(
            'html' => dv_render_cart_preview_html(),
        )
    );
}
add_action( 'wp_ajax_dv_get_header_cart_preview', 'dv_ajax_get_header_cart_preview' );
add_action( 'wp_ajax_nopriv_dv_get_header_cart_preview', 'dv_ajax_get_header_cart_preview' );

function dv_ajax_update_header_cart_item_qty() {
    dv_cart_prepare_json_response();
    dv_cart_verify_ajax_nonce();

    if ( function_exists( 'wc_load_cart' ) ) {
        wc_load_cart();
    }

    $cart_item_key = sanitize_text_field( wp_unslash( $_POST['cart_item_key'] ?? '' ) );
    $product_id    = absint( $_POST['product_id'] ?? 0 );
    $delta         = (int) ( $_POST['delta'] ?? 0 );

    if ( '' === $cart_item_key || ! WC()->cart || 0 === $delta ) {
        wp_send_json_error();
    }

    $cart_item = WC()->cart->get_cart_item( $cart_item_key );

    if ( ! $cart_item ) {
        wp_send_json_error();
    }

    $current_qty = (int) ( $cart_item['quantity'] ?? 0 );
    $new_qty     = max( 0, $current_qty + $delta );

    if ( 0 === $new_qty ) {
        $updated = WC()->cart->remove_cart_item( $cart_item_key );
    } else {
        $updated = WC()->cart->set_quantity( $cart_item_key, $new_qty, true );
    }

    if ( false === $updated ) {
        wp_send_json_error();
    }

    WC()->cart->calculate_totals();

    wp_send_json_success(
        array(
            'count'      => WC()->cart->get_cart_contents_count(),
            'total'      => WC()->cart->get_cart_total(),
            'html'       => dv_render_cart_preview_html(),
            'product_id' => $product_id,
            'in_cart'    => $product_id ? function_exists( 'dv_is_product_in_cart' ) && dv_is_product_in_cart( $product_id ) : false,
        )
    );
}
add_action( 'wp_ajax_dv_update_header_cart_item_qty', 'dv_ajax_update_header_cart_item_qty' );
add_action( 'wp_ajax_nopriv_dv_update_header_cart_item_qty', 'dv_ajax_update_header_cart_item_qty' );

function dv_ajax_add_to_cart() {
    dv_cart_verify_ajax_nonce();

    $product_id   = absint( $_POST['product_id'] ?? 0 );
    $quantity     = max( 1, absint( $_POST['quantity'] ?? 1 ) );
    $variation_id = absint( $_POST['variation_id'] ?? 0 );
    $variation    = array();

    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => html_entity_decode( '&#1053;&#1077; &#1091;&#1082;&#1072;&#1079;&#1072;&#1085; &#1090;&#1086;&#1074;&#1072;&#1088;.', ENT_QUOTES, 'UTF-8' ) ) );
    }

    if ( function_exists( 'wc_load_cart' ) ) {
        wc_load_cart();
    }

    $product = function_exists( 'dv_get_product_cached' ) ? dv_get_product_cached( $product_id ) : wc_get_product( $product_id );
    if ( ! $product ) {
        wp_send_json_error( array( 'message' => html_entity_decode( '&#1058;&#1086;&#1074;&#1072;&#1088; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;.', ENT_QUOTES, 'UTF-8' ) ) );
    }

    if ( ! $product->is_purchasable() ) {
        wp_send_json_error( array( 'message' => html_entity_decode( '&#1058;&#1086;&#1074;&#1072;&#1088; &#1085;&#1077;&#1076;&#1086;&#1089;&#1090;&#1091;&#1087;&#1077;&#1085; &#1076;&#1083;&#1103; &#1087;&#1086;&#1082;&#1091;&#1087;&#1082;&#1080;.', ENT_QUOTES, 'UTF-8' ) ) );
    }

    if ( $product->is_type( 'variation' ) ) {
        $variation_id = $product_id;
        $product_id   = $product->get_parent_id();
    }

    if ( ! $product->is_type( 'variable' ) ) {
        $variation_id = 0;
    }

    if ( $variation_id > 0 ) {
        foreach ( $_POST as $key => $value ) {
            if ( 0 === strpos( $key, 'attribute_' ) ) {
                $variation[ sanitize_key( $key ) ] = sanitize_text_field( wp_unslash( $value ) );
            }
        }
    }

    $result = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation );

    if ( ! $result ) {
        wp_send_json_error( array( 'message' => html_entity_decode( '&#1053;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1076;&#1086;&#1073;&#1072;&#1074;&#1080;&#1090;&#1100; &#1090;&#1086;&#1074;&#1072;&#1088; &#1074; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;.', ENT_QUOTES, 'UTF-8' ) ) );
    }

    WC()->cart->calculate_totals();

    wp_send_json_success(
        array(
            'count' => WC()->cart->get_cart_contents_count(),
            'total' => WC()->cart->get_cart_total(),
        )
    );
}
add_action( 'wp_ajax_dv_add_to_cart', 'dv_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_dv_add_to_cart', 'dv_ajax_add_to_cart' );

function dv_cart_fragments( $fragments ) {
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    $total = WC()->cart ? WC()->cart->get_cart_total() : '';

    ob_start();
    ?>
    <span class="cart-badge<?php echo $count ? '' : ' is-hidden'; ?>" id="dv-cart-badge">
        <?php echo esc_html( $count ); ?>
    </span>
    <?php
    $fragments['#dv-cart-badge'] = ob_get_clean();

    ob_start();
    ?>
    <span class="cart-total" id="dv-cart-total"><?php echo wp_kses_post( $total ); ?></span>
    <?php
    $fragments['#dv-cart-total'] = ob_get_clean();

    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'dv_cart_fragments' );

function dv_ajax_get_cart_info() {
    if ( function_exists( 'wc_load_cart' ) ) {
        wc_load_cart();
    }

    wp_send_json_success(
        array(
            'count' => WC()->cart ? WC()->cart->get_cart_contents_count() : 0,
            'total' => WC()->cart ? WC()->cart->get_cart_total() : '',
        )
    );
}
add_action( 'wp_ajax_dv_get_cart_info', 'dv_ajax_get_cart_info' );
add_action( 'wp_ajax_nopriv_dv_get_cart_info', 'dv_ajax_get_cart_info' );
