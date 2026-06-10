<?php
/**
 * ДеталиВам — WooCommerce helper-функции темы.
 */
defined( 'ABSPATH' ) || exit;

function dv_woocommerce_labels() {
    static $labels_cache = null;

    if ( is_array( $labels_cache ) ) {
        return $labels_cache;
    }

    $labels_cache = array(
        'View cart'                    => html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1081;&#1090;&#1080; &#1074; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'Update cart'                  => html_entity_decode( '&#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1100; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'Proceed to checkout'          => html_entity_decode( '&#1054;&#1092;&#1086;&#1088;&#1084;&#1080;&#1090;&#1100; &#1079;&#1072;&#1082;&#1072;&#1079;', ENT_QUOTES, 'UTF-8' ),
        'Apply coupon'                 => html_entity_decode( '&#1055;&#1088;&#1080;&#1084;&#1077;&#1085;&#1080;&#1090;&#1100; &#1082;&#1091;&#1087;&#1086;&#1085;', ENT_QUOTES, 'UTF-8' ),
        'Coupon code'                  => html_entity_decode( '&#1055;&#1088;&#1086;&#1084;&#1086;&#1082;&#1086;&#1076;', ENT_QUOTES, 'UTF-8' ),
        'Billing details'              => html_entity_decode( '&#1055;&#1083;&#1072;&#1090;&#1105;&#1078;&#1085;&#1099;&#1077; &#1076;&#1072;&#1085;&#1085;&#1099;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'Additional information'       => html_entity_decode( '&#1044;&#1086;&#1087;&#1086;&#1083;&#1085;&#1080;&#1090;&#1077;&#1083;&#1100;&#1085;&#1072;&#1103; &#1080;&#1085;&#1092;&#1086;&#1088;&#1084;&#1072;&#1094;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'Ship to a different address?' => html_entity_decode( '&#1044;&#1086;&#1089;&#1090;&#1072;&#1074;&#1080;&#1090;&#1100; &#1085;&#1072; &#1076;&#1088;&#1091;&#1075;&#1086;&#1081; &#1072;&#1076;&#1088;&#1077;&#1089;?', ENT_QUOTES, 'UTF-8' ),
        'Your order'                   => html_entity_decode( '&#1042;&#1072;&#1096; &#1079;&#1072;&#1082;&#1072;&#1079;', ENT_QUOTES, 'UTF-8' ),
        'Place order'                  => html_entity_decode( '&#1054;&#1092;&#1086;&#1088;&#1084;&#1080;&#1090;&#1100; &#1079;&#1072;&#1082;&#1072;&#1079;', ENT_QUOTES, 'UTF-8' ),
    );

    return $labels_cache;
}

function dv_loop_shop_per_page() {
    return function_exists( 'dv_theme_option_int' )
        ? dv_theme_option_int( 'catalog_per_page', 24, 1, 96 )
        : 24;
}

function dv_loop_shop_columns() {
    return function_exists( 'dv_theme_option_int' )
        ? dv_theme_option_int( 'catalog_columns', 4, 2, 6 )
        : 4;
}

function dv_add_to_cart_label() {
    $labels = function_exists( 'dv_get_cart_button_labels' ) ? dv_get_cart_button_labels() : dv_theme_labels();
    global $product;

    if ( $product instanceof WC_Product && function_exists( 'dv_is_product_in_cart' ) && dv_is_product_in_cart( $product ) ) {
        return $labels['in_cart'] ?? $labels['to_cart'];
    }

    return $labels['to_cart'];
}

function dv_related_products_args( $args ) {
    $args['posts_per_page'] = function_exists( 'dv_theme_option_int' )
        ? dv_theme_option_int( 'product_related_limit', 4, 1, 12 )
        : 4;
    $args['columns']        = function_exists( 'dv_theme_option_int' )
        ? dv_theme_option_int( 'catalog_columns', 4, 2, 6 )
        : 4;

    return $args;
}

function dv_related_products_heading() {
    $labels = dv_theme_labels();
    return $labels['related_heading'];
}

function dv_upsells_products_heading() {
    $labels = dv_theme_labels();
    return $labels['upsells_heading'];
}

function dv_breadcrumb_defaults( $defaults ) {
    $defaults['delimiter']   = ' <span class="sep">/</span> ';
    $defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb">';
    $defaults['wrap_after']  = '</nav>';
    return $defaults;
}

function dv_product_tabs( $tabs ) {
    $labels = dv_theme_labels();
    if ( isset( $tabs['description'] ) ) {
        $tabs['description']['title'] = $labels['description'];
    }

    if ( isset( $tabs['additional_information'] ) ) {
        $tabs['additional_information']['title'] = $labels['specs'];
    }

    if ( isset( $tabs['reviews'] ) ) {
        $tabs['reviews']['title'] = $labels['reviews'];
    }

    return $tabs;
}

function dv_checkout_order_notes_enabled( $enabled ) {
    if ( function_exists( 'dv_theme_option_enabled' ) && ! dv_theme_option_enabled( 'checkout_order_notes_enabled' ) ) {
        return false;
    }

    return $enabled;
}

function dv_order_item_totals_without_subtotal( $total_rows ) {
    if (
        ( function_exists( 'is_order_received_page' ) && is_order_received_page() )
        || ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'view-order' ) )
        || dv_is_order_pay_request()
    ) {
        unset( $total_rows['cart_subtotal'] );
    }

    return $total_rows;
}

function dv_deferred_payment_gateway_id() {
    return 'dv_manager_approval';
}

if ( class_exists( 'WC_Payment_Gateway' ) && ! class_exists( 'DV_Manager_Approval_Gateway' ) ) {
    class DV_Manager_Approval_Gateway extends WC_Payment_Gateway {
        public function __construct() {
            $this->id                 = dv_deferred_payment_gateway_id();
            $this->method_title       = html_entity_decode( '&#1054;&#1087;&#1083;&#1072;&#1090;&#1072; &#1087;&#1086;&#1089;&#1083;&#1077; &#1087;&#1086;&#1076;&#1090;&#1074;&#1077;&#1088;&#1078;&#1076;&#1077;&#1085;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' );
            $this->method_description = html_entity_decode( '&#1057;&#1083;&#1091;&#1078;&#1077;&#1073;&#1085;&#1099;&#1081; &#1084;&#1077;&#1090;&#1086;&#1076;: &#1082;&#1083;&#1080;&#1077;&#1085;&#1090; &#1086;&#1092;&#1086;&#1088;&#1084;&#1083;&#1103;&#1077;&#1090; &#1079;&#1072;&#1103;&#1074;&#1082;&#1091;, &#1072; &#1086;&#1087;&#1083;&#1072;&#1090;&#1072; &#1086;&#1090;&#1082;&#1088;&#1099;&#1074;&#1072;&#1077;&#1090;&#1089;&#1103; &#1084;&#1077;&#1085;&#1077;&#1076;&#1078;&#1077;&#1088;&#1086;&#1084;.', ENT_QUOTES, 'UTF-8' );
            $this->title              = html_entity_decode( '&#1054;&#1087;&#1083;&#1072;&#1090;&#1072; &#1087;&#1086;&#1089;&#1083;&#1077; &#1087;&#1086;&#1076;&#1090;&#1074;&#1077;&#1088;&#1078;&#1076;&#1077;&#1085;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' );
            $this->description        = html_entity_decode( '&#1052;&#1077;&#1085;&#1077;&#1076;&#1078;&#1077;&#1088; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090; &#1079;&#1072;&#1082;&#1072;&#1079; &#1080; &#1086;&#1090;&#1082;&#1088;&#1086;&#1077;&#1090; &#1086;&#1087;&#1083;&#1072;&#1090;&#1091;.', ENT_QUOTES, 'UTF-8' );
            $this->enabled            = 'yes';
            $this->has_fields         = false;
            $this->supports           = array( 'products' );
        }

        public function process_payment( $order_id ) {
            $order = wc_get_order( $order_id );

            if ( ! $order ) {
                return array( 'result' => 'failure' );
            }

            $order->update_meta_data( '_dv_payment_allowed', 'no' );
            dv_mark_deferred_order_unpaid( $order );
            $order->save();

            if ( WC()->cart ) {
                WC()->cart->empty_cart();
            }

            return array(
                'result'   => 'success',
                'redirect' => $this->get_return_url( $order ),
            );
        }
    }
}

function dv_register_deferred_payment_gateway( $gateways ) {
    if ( class_exists( 'DV_Manager_Approval_Gateway' ) ) {
        $gateways[] = 'DV_Manager_Approval_Gateway';
    }

    return $gateways;
}

function dv_is_order_pay_request() {
    if ( function_exists( 'is_checkout_pay_page' ) && is_checkout_pay_page() ) {
        return true;
    }

    if ( function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'order-pay' ) ) {
        return true;
    }

    return ! empty( $_GET['pay_for_order'] ) || false !== get_query_var( 'order-pay', false );
}

function dv_order_pay_critical_styles() {
    if ( ! dv_is_order_pay_request() ) {
        return;
    }
    ?>
    <style id="dv-order-pay-critical">
        body.woocommerce-order-pay form#order_review table.shop_table td.product-name,
        body.woocommerce-order-pay form#order_review table.shop_table td.product-name a {
            color: #0072E8 !important;
            font-weight: 800 !important;
        }
        body.woocommerce-order-pay form#order_review table.shop_table td.product-name a {
            text-decoration: none !important;
        }
        body.woocommerce-order-pay #payment #place_order,
        body.woocommerce-order-pay #payment button#place_order,
        body.woocommerce-order-pay #payment .place-order button,
        body.woocommerce-order-pay form#order_review .place-order .button.alt,
        form#order_review #payment #place_order,
        form#order_review #payment button#place_order,
        form#order_review #payment .place-order button,
        form#order_review #payment .place-order .button.alt {
            -webkit-appearance: none !important;
            appearance: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            min-height: 54px !important;
            border: 0 !important;
            border-radius: 12px !important;
            background: #0072E8 !important;
            background-color: #0072E8 !important;
            color: #FFFFFF !important;
            -webkit-text-fill-color: #FFFFFF !important;
            font-size: 16px !important;
            font-weight: 800 !important;
            line-height: 1.2 !important;
            opacity: 1 !important;
            visibility: visible !important;
            text-align: center !important;
            text-indent: 0 !important;
            box-shadow: 0 16px 30px rgba(0, 114, 232, .18) !important;
        }
        body.woocommerce-order-pay #payment #place_order:disabled,
        body.woocommerce-order-pay #payment button#place_order:disabled,
        body.woocommerce-order-pay #payment .place-order button:disabled,
        body.woocommerce-order-pay form#order_review .place-order .button.alt:disabled,
        body.woocommerce-order-pay form#order_review .place-order .button.alt.disabled,
        form#order_review #payment #place_order:disabled,
        form#order_review #payment button#place_order:disabled,
        form#order_review #payment .place-order button:disabled,
        form#order_review #payment .place-order .button.alt:disabled,
        form#order_review #payment .place-order .button.alt.disabled {
            background: #0A84FF !important;
            background-color: #0A84FF !important;
            color: #FFFFFF !important;
            -webkit-text-fill-color: #FFFFFF !important;
            opacity: 1 !important;
            cursor: not-allowed !important;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'dv_order_pay_critical_styles', 99 );

function dv_is_view_order_request() {
    return function_exists( 'is_wc_endpoint_url' ) && is_wc_endpoint_url( 'view-order' );
}

function dv_view_order_critical_styles() {
    if ( ! dv_is_view_order_request() ) {
        return;
    }
    ?>
    <style id="dv-view-order-critical">
        body.woocommerce-view-order .woocommerce-MyAccount-content > p:first-child mark,
        body.woocommerce-view-order .woocommerce-MyAccount-content .order-number,
        body.woocommerce-view-order .woocommerce-MyAccount-content .order-date,
        body.woocommerce-view-order .woocommerce-MyAccount-content .order-status,
        body.woocommerce-account .woocommerce-MyAccount-content > p:first-child mark,
        body.woocommerce-account .woocommerce-MyAccount-content .order-number,
        body.woocommerce-account .woocommerce-MyAccount-content .order-date,
        body.woocommerce-account .woocommerce-MyAccount-content .order-status {
            padding: 0 !important;
            background: transparent !important;
            background-color: transparent !important;
            color: #0072E8 !important;
            font-weight: 800 !important;
        }
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tbody tr,
        body.woocommerce-account .woocommerce-order-details table.shop_table tbody tr {
            background: linear-gradient(180deg, #FFFFFF, #F4FAFF) !important;
        }
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tbody td.product-name,
        body.woocommerce-account .woocommerce-order-details table.shop_table tbody td.product-name,
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name,
        body.woocommerce-account .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name {
            position: relative !important;
            padding-left: 22px !important;
            color: #0072E8 !important;
            font-size: 15px !important;
            font-weight: 900 !important;
            line-height: 1.55 !important;
        }
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tbody td.product-name::before,
        body.woocommerce-account .woocommerce-order-details table.shop_table tbody td.product-name::before,
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name::before,
        body.woocommerce-account .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name::before {
            content: "" !important;
            position: absolute !important;
            left: 0 !important;
            top: 16px !important;
            bottom: 16px !important;
            width: 4px !important;
            border-radius: 999px !important;
            background: #0072E8 !important;
        }
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tbody td.product-name a,
        body.woocommerce-account .woocommerce-order-details table.shop_table tbody td.product-name a,
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name a,
        body.woocommerce-account .woocommerce-order-details table.shop_table tbody td.woocommerce-table__product-name a {
            color: #0072E8 !important;
            font-weight: 900 !important;
            text-decoration: none !important;
        }
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tbody td.product-name strong,
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tbody td.product-name .product-quantity,
        body.woocommerce-account .woocommerce-order-details table.shop_table tbody td.product-name strong,
        body.woocommerce-account .woocommerce-order-details table.shop_table tbody td.product-name .product-quantity {
            display: inline-flex !important;
            align-items: center !important;
            min-height: 22px !important;
            margin-left: 6px !important;
            padding: 2px 8px !important;
            border-radius: 999px !important;
            background: #EAF4FF !important;
            color: #0057B8 !important;
            font-size: 12px !important;
            font-weight: 900 !important;
            vertical-align: middle !important;
        }
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tfoot tr.order-total th,
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tfoot tr.order-total td,
        body.woocommerce-account .woocommerce-order-details table.shop_table tfoot tr.order-total th,
        body.woocommerce-account .woocommerce-order-details table.shop_table tfoot tr.order-total td,
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tfoot tr:last-child th,
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tfoot tr:last-child td,
        body.woocommerce-account .woocommerce-order-details table.shop_table tfoot tr:last-child th,
        body.woocommerce-account .woocommerce-order-details table.shop_table tfoot tr:last-child td {
            padding-top: 12px !important;
            padding-bottom: 12px !important;
            font-size: 13px !important;
            line-height: 1.35 !important;
        }
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tfoot tr.order-total td .woocommerce-Price-amount,
        body.woocommerce-account .woocommerce-order-details table.shop_table tfoot tr.order-total td .woocommerce-Price-amount {
            color: #0057B8 !important;
            font-size: 16px !important;
            line-height: 1.1 !important;
        }
        body.woocommerce-view-order .woocommerce-order-details table.shop_table tfoot td .button,
        body.woocommerce-account .woocommerce-order-details table.shop_table tfoot td .button {
            min-width: 76px !important;
            min-height: 36px !important;
            padding: 0 14px !important;
            border-radius: 9px !important;
            font-size: 12px !important;
            line-height: 1 !important;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'dv_view_order_critical_styles', 99 );

function dv_get_order_pay_request_order() {
    $order_id = absint( get_query_var( 'order-pay' ) );

    if ( ! $order_id && ! empty( $_GET['key'] ) ) {
        $order_id = wc_get_order_id_by_order_key( wc_clean( wp_unslash( $_GET['key'] ) ) );
    }

    return $order_id ? wc_get_order( $order_id ) : false;
}

function dv_is_order_payment_allowed( $order ) {
    return $order instanceof WC_Order && 'yes' === $order->get_meta( '_dv_payment_allowed' );
}

function dv_is_order_payment_controlled( $order ) {
    return $order instanceof WC_Order
        && ( '' !== (string) $order->get_meta( '_dv_payment_allowed' ) || dv_deferred_payment_gateway_id() === $order->get_payment_method() );
}

function dv_mark_deferred_order_unpaid( $order ) {
    if ( ! $order instanceof WC_Order ) {
        return;
    }

    $order->set_date_paid( null );
    $order->set_transaction_id( '' );

    if ( 'on-hold' !== $order->get_status() ) {
        $order->set_status(
            'on-hold',
            html_entity_decode( '&#1047;&#1072;&#1082;&#1072;&#1079; &#1086;&#1092;&#1086;&#1088;&#1084;&#1083;&#1077;&#1085; &#1073;&#1077;&#1079; &#1086;&#1087;&#1083;&#1072;&#1090;&#1099;. &#1054;&#1087;&#1083;&#1072;&#1090;&#1072; &#1073;&#1091;&#1076;&#1077;&#1090; &#1086;&#1090;&#1082;&#1088;&#1099;&#1090;&#1072; &#1087;&#1086;&#1089;&#1083;&#1077; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1082;&#1080; &#1084;&#1077;&#1085;&#1077;&#1076;&#1078;&#1077;&#1088;&#1086;&#1084;.', ENT_QUOTES, 'UTF-8' ),
            true
        );
    }
}

function dv_allow_order_payment( $order, $add_note = true ) {
    if ( ! $order instanceof WC_Order ) {
        return;
    }

    $order->update_meta_data( '_dv_payment_allowed', 'yes' );

    if ( ! $order->is_paid() && 'pending' !== $order->get_status() ) {
        $order->update_status( 'pending', html_entity_decode( '&#1054;&#1087;&#1083;&#1072;&#1090;&#1072; &#1088;&#1072;&#1079;&#1088;&#1077;&#1096;&#1077;&#1085;&#1072; &#1084;&#1077;&#1085;&#1077;&#1076;&#1078;&#1077;&#1088;&#1086;&#1084;.', ENT_QUOTES, 'UTF-8' ) );
    }

    if ( dv_deferred_payment_gateway_id() === $order->get_payment_method() ) {
        $order->set_payment_method( '' );
        $order->set_payment_method_title( '' );
    }

    if ( $add_note ) {
        $order->add_order_note(
            html_entity_decode( '&#1054;&#1087;&#1083;&#1072;&#1090;&#1072; &#1082;&#1083;&#1080;&#1077;&#1085;&#1090;&#1091; &#1088;&#1072;&#1079;&#1088;&#1077;&#1096;&#1077;&#1085;&#1072;. &#1057;&#1089;&#1099;&#1083;&#1082;&#1072;: ', ENT_QUOTES, 'UTF-8' ) . $order->get_checkout_payment_url()
        );
    }

    $order->save();
}

function dv_limit_checkout_payment_gateways( $gateways ) {
    $deferred_id = dv_deferred_payment_gateway_id();

    if ( is_admin() && ! wp_doing_ajax() ) {
        return $gateways;
    }

    if ( dv_is_order_pay_request() ) {
        unset( $gateways[ $deferred_id ] );

        $order = dv_get_order_pay_request_order();
        if ( $order && dv_is_order_payment_controlled( $order ) && ! dv_is_order_payment_allowed( $order ) ) {
            return array();
        }

        return $gateways;
    }

    if ( isset( $gateways[ $deferred_id ] ) && function_exists( 'WC' ) && WC()->cart && WC()->cart->needs_payment() ) {
        return array( $deferred_id => $gateways[ $deferred_id ] );
    }

    return $gateways;
}

function dv_deferred_payment_checkout_notice() {
    if ( dv_is_order_pay_request() ) {
        return;
    }

    echo '<div class="dv-deferred-payment-notice"><strong>' . esc_html( html_entity_decode( '&#1054;&#1087;&#1083;&#1072;&#1090;&#1072; &#1087;&#1086;&#1089;&#1083;&#1077; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1082;&#1080;.', ENT_QUOTES, 'UTF-8' ) ) . '</strong> ' . esc_html( html_entity_decode( '&#1057;&#1077;&#1081;&#1095;&#1072;&#1089; &#1087;&#1083;&#1072;&#1090;&#1080;&#1090;&#1100; &#1085;&#1077; &#1085;&#1091;&#1078;&#1085;&#1086;: &#1084;&#1077;&#1085;&#1077;&#1076;&#1078;&#1077;&#1088; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1080;&#1090; &#1079;&#1072;&#1082;&#1072;&#1079; &#1080; &#1086;&#1090;&#1082;&#1088;&#1086;&#1077;&#1090; &#1082;&#1085;&#1086;&#1087;&#1082;&#1091; &#1086;&#1087;&#1083;&#1072;&#1090;&#1099;.', ENT_QUOTES, 'UTF-8' ) ) . '</div>';
}

function dv_hide_pay_action_until_allowed( $actions, $order ) {
    if ( isset( $actions['pay'] ) && dv_is_order_payment_controlled( $order ) && ! dv_is_order_payment_allowed( $order ) ) {
        unset( $actions['pay'] );
    }

    if ( dv_customer_can_cancel_order( $order ) && ! isset( $actions['cancel'] ) ) {
        $actions['cancel'] = array(
            'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
            'name' => html_entity_decode( '&#1054;&#1090;&#1084;&#1077;&#1085;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
        );
    }

    return $actions;
}

function dv_customer_can_cancel_order( $order ) {
    if ( ! $order instanceof WC_Order ) {
        return false;
    }

    return ! $order->has_status( array( 'cancelled', 'refunded', 'completed' ) );
}

function dv_allow_customer_cancel_statuses( $statuses, $order = null ) {
    $statuses = is_array( $statuses ) ? $statuses : array();

    foreach ( array( 'pending', 'failed', 'on-hold', 'processing' ) as $status ) {
        if ( ! in_array( $status, $statuses, true ) ) {
            $statuses[] = $status;
        }
    }

    return $statuses;
}

function dv_order_needs_payment_gate( $needs_payment, $order ) {
    if ( $needs_payment && ! is_admin() && dv_is_order_payment_controlled( $order ) && ! dv_is_order_payment_allowed( $order ) ) {
        return false;
    }

    return $needs_payment;
}

function dv_keep_deferred_order_unpaid( $order_id, $old_status, $new_status, $order ) {
    if (
        ! $order instanceof WC_Order
        || ! dv_is_order_payment_controlled( $order )
        || dv_is_order_payment_allowed( $order )
        || ! in_array( $new_status, array( 'processing', 'completed' ), true )
    ) {
        return;
    }

    dv_mark_deferred_order_unpaid( $order );
    $order->save();
}

function dv_normalize_deferred_order_on_admin_view() {
    if ( ! is_admin() || wp_doing_ajax() || ! function_exists( 'wc_get_order' ) ) {
        return;
    }

    $order_id = 0;

    if ( ! empty( $_GET['post'] ) ) {
        $order_id = absint( $_GET['post'] );
    } elseif ( ! empty( $_GET['id'] ) ) {
        $order_id = absint( $_GET['id'] );
    }

    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );

    if (
        $order instanceof WC_Order
        && dv_is_order_payment_controlled( $order )
        && ! dv_is_order_payment_allowed( $order )
        && ( $order->is_paid() || in_array( $order->get_status(), array( 'processing', 'completed' ), true ) )
    ) {
        dv_mark_deferred_order_unpaid( $order );
        $order->save();
    }
}

function dv_auto_allow_payment_on_pending_status( $order_id, $old_status, $new_status, $order ) {
    if ( 'pending' !== $new_status || ! $order instanceof WC_Order || $order->is_paid() ) {
        return;
    }

    if ( ! dv_is_order_payment_allowed( $order ) ) {
        dv_allow_order_payment( $order, false );
        $order->add_order_note( html_entity_decode( '&#1054;&#1087;&#1083;&#1072;&#1090;&#1072; &#1072;&#1074;&#1090;&#1086;&#1084;&#1072;&#1090;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080; &#1088;&#1072;&#1079;&#1088;&#1077;&#1096;&#1077;&#1085;&#1072; &#1087;&#1088;&#1080; &#1087;&#1077;&#1088;&#1077;&#1074;&#1086;&#1076;&#1077; &#1079;&#1072;&#1082;&#1072;&#1079;&#1072; &#1074; &#1089;&#1090;&#1072;&#1090;&#1091;&#1089; \"&#1054;&#1078;&#1080;&#1076;&#1072;&#1077;&#1090; &#1086;&#1087;&#1083;&#1072;&#1090;&#1099;\".', ENT_QUOTES, 'UTF-8' ) );
    }
}

function dv_add_allow_payment_order_action( $actions ) {
    $actions['dv_allow_customer_payment'] = html_entity_decode( '&#1056;&#1072;&#1079;&#1088;&#1077;&#1096;&#1080;&#1090;&#1100; &#1086;&#1087;&#1083;&#1072;&#1090;&#1091; &#1082;&#1083;&#1080;&#1077;&#1085;&#1090;&#1091;', ENT_QUOTES, 'UTF-8' );
    return $actions;
}

function dv_handle_allow_payment_order_action( $order ) {
    dv_allow_order_payment( $order, true );
}

function dv_render_order_payment_gate_status( $order ) {
    if ( ! $order instanceof WC_Order || ! dv_is_order_payment_controlled( $order ) ) {
        return;
    }

    $allowed = dv_is_order_payment_allowed( $order );

    if ( ! $allowed && ( $order->is_paid() || in_array( $order->get_status(), array( 'processing', 'completed' ), true ) ) ) {
        dv_mark_deferred_order_unpaid( $order );
        $order->save();
    }

    ?>
    <div class="dv-admin-payment-gate-status">
        <strong><?php echo esc_html( html_entity_decode( '&#1054;&#1087;&#1083;&#1072;&#1090;&#1072; &#1082;&#1083;&#1080;&#1077;&#1085;&#1090;&#1091;', ENT_QUOTES, 'UTF-8' ) ); ?>:</strong>
        <span><?php echo esc_html( $allowed ? html_entity_decode( '&#1088;&#1072;&#1079;&#1088;&#1077;&#1096;&#1077;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ) : html_entity_decode( '&#1079;&#1072;&#1082;&#1088;&#1099;&#1090;&#1072; &#1076;&#1086; &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1082;&#1080;', ENT_QUOTES, 'UTF-8' ) ); ?></span>
        <?php if ( $allowed ) : ?>
            <br><a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( html_entity_decode( '&#1054;&#1090;&#1082;&#1088;&#1099;&#1090;&#1100; &#1089;&#1089;&#1099;&#1083;&#1082;&#1091; &#1085;&#1072; &#1086;&#1087;&#1083;&#1072;&#1090;&#1091;', ENT_QUOTES, 'UTF-8' ) ); ?></a>
        <?php endif; ?>
    </div>
    <?php
}

function dv_woo_wrapper_open() {
    echo '<div class="dv-woo-main">';
}

function dv_woo_wrapper_close() {
    echo '</div>';
}

function dv_render_buy_now_button() {
    $labels = dv_theme_labels();
    echo '<input type="hidden" name="dv_buy_now" value="0" class="dv-buy-now-flag">';
    echo '<button type="button" class="button alt dv-buy-now-button">' . esc_html( $labels['buy_now'] ) . '</button>';
}

function dv_buy_now_redirect( $url ) {
    if ( empty( $_REQUEST['dv_buy_now'] ) ) {
        return $url;
    }

    return function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : $url;
}

function dv_single_stock_summary() {
    $labels = dv_theme_labels();
    global $product;

    if ( ! $product instanceof WC_Product ) {
        return;
    }

    if ( $product->is_in_stock() ) {
        $qty   = $product->get_stock_quantity();
        $label = $qty ? $qty . ' ' . $labels['stock_suffix'] : $labels['stock_in'];
        echo '<div class="product-stock-inline">' . esc_html( $label ) . '</div>';
        return;
    }

    echo '<div class="product-stock-inline is-out">' . esc_html( $labels['stock_out'] ) . '</div>';
}

function dv_compat_block() {
    $labels = dv_theme_labels();
    global $product;

    if ( ! $product instanceof WC_Product ) {
        return;
    }

    $tags = function_exists( 'dv_get_compat_tags' ) ? dv_get_compat_tags( $product ) : array();

    if ( empty( $tags ) ) {
        return;
    }

    echo '<div class="compat-block"><div class="compat-label">' . esc_html( $labels['compatibility'] ) . '</div><div class="compat-tags">';
    foreach ( $tags as $index => $tag ) {
        printf(
            '<span class="compat-tag-item%s">%s</span>',
            $index < 2 ? ' primary' : '',
            esc_html( $tag )
        );
    }
    echo '</div></div>';
}

function dv_economy_badge() {
    $labels = dv_theme_labels();
    global $product;

    if ( ! $product instanceof WC_Product || ! $product->is_on_sale() ) {
        return;
    }

    $regular = (float) $product->get_regular_price();
    $sale    = (float) $product->get_sale_price();

    if ( $regular <= 0 || $sale <= 0 || $sale >= $regular ) {
        return;
    }

    $percent = round( ( $regular - $sale ) / $regular * 100 );
    $saved   = number_format( $regular - $sale, 0, '.', ' ' );

    printf(
        '<div class="dv-economy-badge"><span class="price-badge">-%d%%</span><span class="price-economy">%s</span></div>',
        $percent,
        esc_html( sprintf( $labels['economy_html'], $saved ) )
    );
}

function dv_translate_strings( $translated, $text, $domain ) {
    if ( 'woocommerce' !== $domain && 'default' !== $domain ) {
        return $translated;
    }

    $map = dv_woocommerce_labels();

    return $map[ $text ] ?? $translated;
}
add_filter( 'gettext', 'dv_translate_strings', 20, 3 );

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
add_filter( 'loop_shop_per_page', 'dv_loop_shop_per_page', 20 );
add_filter( 'loop_shop_columns', 'dv_loop_shop_columns' );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'dv_add_to_cart_label' );
add_filter( 'woocommerce_product_add_to_cart_text', 'dv_add_to_cart_label' );
add_filter( 'woocommerce_output_related_products_args', 'dv_related_products_args' );
add_filter( 'woocommerce_product_related_products_heading', 'dv_related_products_heading' );
add_filter( 'woocommerce_product_upsells_products_heading', 'dv_upsells_products_heading' );
add_filter( 'woocommerce_breadcrumb_defaults', 'dv_breadcrumb_defaults' );
add_filter( 'woocommerce_product_tabs', 'dv_product_tabs', 98 );
add_filter( 'woocommerce_enable_order_notes_field', 'dv_checkout_order_notes_enabled' );
add_filter( 'woocommerce_get_order_item_totals', 'dv_order_item_totals_without_subtotal', 20 );
add_filter( 'woocommerce_payment_gateways', 'dv_register_deferred_payment_gateway' );
add_filter( 'woocommerce_available_payment_gateways', 'dv_limit_checkout_payment_gateways', 100 );
add_filter( 'woocommerce_my_account_my_orders_actions', 'dv_hide_pay_action_until_allowed', 20, 2 );
add_filter( 'woocommerce_valid_order_statuses_for_cancel', 'dv_allow_customer_cancel_statuses', 20, 2 );
add_filter( 'woocommerce_order_needs_payment', 'dv_order_needs_payment_gate', 20, 2 );
add_action( 'woocommerce_review_order_before_payment', 'dv_deferred_payment_checkout_notice', 5 );
add_action( 'woocommerce_order_status_changed', 'dv_keep_deferred_order_unpaid', 5, 4 );
add_action( 'admin_init', 'dv_normalize_deferred_order_on_admin_view' );
add_action( 'woocommerce_order_status_changed', 'dv_auto_allow_payment_on_pending_status', 20, 4 );
add_filter( 'woocommerce_order_actions', 'dv_add_allow_payment_order_action' );
add_action( 'woocommerce_order_action_dv_allow_customer_payment', 'dv_handle_allow_payment_order_action' );
add_action( 'woocommerce_admin_order_data_after_order_details', 'dv_render_order_payment_gate_status' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 10 );

add_action( 'woocommerce_before_main_content', 'dv_woo_wrapper_open', 10 );
add_action( 'woocommerce_after_main_content', 'dv_woo_wrapper_close', 10 );
add_action( 'woocommerce_after_add_to_cart_button', 'dv_render_buy_now_button', 20 );
add_filter( 'woocommerce_add_to_cart_redirect', 'dv_buy_now_redirect', 20 );
add_action( 'woocommerce_single_product_summary', 'dv_compat_block', 8 );
add_action( 'woocommerce_single_product_summary', 'dv_economy_badge', 9 );

function dv_cross_sells_shortcode() {
    if ( ! function_exists( 'woocommerce_cross_sell_display' ) ) {
        return '';
    }

    ob_start();
    echo '<div class="woocommerce dv-cross-sells-shortcode">';
    woocommerce_cross_sell_display( 4, 4 );
    echo '</div>';
    return ob_get_clean();
}
add_shortcode( 'dv_cross_sells', 'dv_cross_sells_shortcode' );
