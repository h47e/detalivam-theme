<?php
defined( 'ABSPATH' ) || exit;

function dv_checkout_pickup_options() {
    $options = array();
    foreach ( dv_get_pickup_locations() as $row ) {
        $key = 'pickup_' . substr( hash( 'sha256', $row['city'] . "\0" . $row['address'] . "\0" . $row['name'] ), 0, 20 );
        $options[ $key ] = $row;
    }
    return $options;
}

function dv_checkout_pickup_choice( $posted = null ) {
    if ( null === $posted ) {
        $posted = $_POST;
        if ( isset( $_POST['post_data'] ) && is_string( $_POST['post_data'] ) ) {
            parse_str( wp_unslash( $_POST['post_data'] ), $posted );
        }
    } elseif ( is_string( $posted ) ) {
        parse_str( wp_unslash( $posted ), $posted );
    }
    $posted = is_array( $posted ) ? $posted : array();
    $session = function_exists( 'WC' ) ? WC()->session : null;
    $mode = $posted['dv_fulfilment'] ?? ( $session ? $session->get( 'dv_checkout_fulfilment', 'delivery' ) : 'delivery' );
    $key = $posted['dv_pickup_key'] ?? ( $session ? $session->get( 'dv_checkout_pickup_key', '' ) : '' );
    if ( ! isset( $posted['dv_fulfilment'] ) && ! dv_checkout_pickup_options() ) $mode = 'delivery';
    return array( 'mode' => 'pickup' === $mode ? 'pickup' : 'delivery', 'key' => is_string( $key ) ? sanitize_text_field( $key ) : '' );
}

function dv_checkout_pickup_session( $posted = null ) {
    if ( ! WC()->session ) return;
    $choice = dv_checkout_pickup_choice( $posted );
    WC()->session->set( 'dv_checkout_fulfilment', $choice['mode'] );
    WC()->session->set( 'dv_checkout_pickup_key', $choice['key'] );
}
add_action( 'woocommerce_checkout_update_order_review', 'dv_checkout_pickup_session' );
add_action( 'woocommerce_checkout_process', 'dv_checkout_pickup_session' );

function dv_render_checkout_pickup_choice() {
    $locations = dv_checkout_pickup_options();
    if ( ! $locations || ! WC()->cart || ! WC()->cart->needs_shipping() ) return;
    $choice = dv_checkout_pickup_choice();
    ?>
    <section class="checkout-section dv-checkout-fulfilment" data-dv-fulfilment>
      <div class="checkout-section-head"><div class="checkout-section-title">Получение заказа</div></div>
      <div class="checkout-section-body">
        <fieldset class="dv-fulfilment-modes"><legend class="screen-reader-text">Способ получения</legend>
          <label><input type="radio" name="dv_fulfilment" value="delivery" <?php checked( $choice['mode'], 'delivery' ); ?>> Доставка</label>
          <label><input type="radio" name="dv_fulfilment" value="pickup" <?php checked( $choice['mode'], 'pickup' ); ?>> Самовывоз</label>
        </fieldset>
        <div data-dv-pickup-fields>
          <label for="dv-pickup-key">Пункт самовывоза <span class="required">*</span></label>
          <select name="dv_pickup_key" id="dv-pickup-key" <?php echo 'pickup' === $choice['mode'] ? 'required' : ''; ?>>
            <option value="">Выберите город и адрес</option>
            <?php foreach ( $locations as $key => $row ) : ?>
              <option value="<?php echo esc_attr( $key ); ?>" data-hours="<?php echo esc_attr( $row['hours'] ); ?>" data-phone="<?php echo esc_attr( $row['phone'] ); ?>" <?php selected( $choice['key'], $key ); ?>><?php echo esc_html( $row['city'] . ' — ' . $row['address'] . ( $row['name'] ? ' (' . $row['name'] . ')' : '' ) ); ?></option>
            <?php endforeach; ?>
          </select>
          <p class="dv-checkout-pickup-details" data-dv-pickup-details></p>
        </div>
      </div>
    </section>
    <?php
}
add_action( 'woocommerce_checkout_before_customer_details', 'dv_render_checkout_pickup_choice', 5 );

function dv_checkout_pickup_fields( $fields ) {
    $pickup = 'pickup' === dv_checkout_pickup_choice()['mode'];
    foreach ( array( 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode', 'billing_country' ) as $name ) {
        if ( isset( $fields['billing'][ $name ] ) ) {
            $fields['billing'][ $name ]['custom_attributes']['data-dv-delivery-required'] = ! empty( $fields['billing'][ $name ]['required'] ) ? '1' : '0';
            if ( $pickup ) $fields['billing'][ $name ]['required'] = false;
        }
    }
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'dv_checkout_pickup_fields', 100 );
add_filter( 'woocommerce_cart_needs_shipping_address', static function ( $needed ) { return 'pickup' === dv_checkout_pickup_choice()['mode'] ? false : $needed; } );

function dv_checkout_pickup_packages( $packages ) {
    $choice = dv_checkout_pickup_choice();
    foreach ( $packages as &$package ) {
        $package['dv_pickup_selection'] = $choice;
        $package['dv_fulfilment_rates_version'] = 3;
    }
    unset( $package );
    return $packages;
}
add_filter( 'woocommerce_cart_shipping_packages', 'dv_checkout_pickup_packages' );

function dv_checkout_pickup_rates( $rates, $package ) {
    $choice = dv_checkout_pickup_choice();
    $locations = dv_checkout_pickup_options();
    if ( 'pickup' !== $choice['mode'] ) {
        // Zero is provisional: the manager confirms delivery cost before payment.
        return array( 'dv_manager_delivery' => new WC_Shipping_Rate( 'dv_manager_delivery', 'Уточнит менеджер', 0, array(), 'dv_manager_delivery' ) );
    }
    if ( ! isset( $locations[ $choice['key'] ] ) ) {
        // Keep delivery options out of pickup mode; checkout validation requires a branch.
        return array( 'dv_branch_pickup' => new WC_Shipping_Rate( 'dv_branch_pickup', 'Выберите пункт самовывоза', 0, array(), 'local_pickup' ) );
    }
    $row = $locations[ $choice['key'] ];
    return array( 'dv_branch_pickup' => new WC_Shipping_Rate( 'dv_branch_pickup', 'Самовывоз: ' . $row['city'], 0, array(), 'local_pickup' ) );
}
add_filter( 'woocommerce_package_rates', 'dv_checkout_pickup_rates', 100, 2 );

function dv_checkout_pickup_posted_data( $data ) {
    $choice = dv_checkout_pickup_choice();
    if ( 'pickup' === $choice['mode'] ) {
        $data['ship_to_different_address'] = false;
        if ( isset( dv_checkout_pickup_options()[ $choice['key'] ] ) && WC()->cart ) {
            $data['shipping_method'] = array_fill( 0, count( WC()->cart->get_shipping_packages() ), 'dv_branch_pickup' );
        }
    } elseif ( WC()->cart ) {
        $data['shipping_method'] = array_fill( 0, count( WC()->cart->get_shipping_packages() ), 'dv_manager_delivery' );
    }
    return $data;
}
add_filter( 'woocommerce_checkout_posted_data', 'dv_checkout_pickup_posted_data' );

function dv_checkout_pickup_validate( $data, $errors ) {
    $choice = dv_checkout_pickup_choice();
    if ( 'pickup' === $choice['mode'] && ! isset( dv_checkout_pickup_options()[ $choice['key'] ] ) ) {
        $errors->add( 'dv_pickup_key', 'Выберите действующий пункт самовывоза.', array( 'id' => 'dv-pickup-key' ) );
    }
}
add_action( 'woocommerce_after_checkout_validation', 'dv_checkout_pickup_validate', 10, 2 );

function dv_checkout_pickup_save_order( $order, $data ) {
    $choice = dv_checkout_pickup_choice();
    $order->update_meta_data( '_dv_fulfilment', $choice['mode'] );
    $order->update_meta_data( '_dv_delivery_quote_required', 'pickup' === $choice['mode'] ? 'no' : 'yes' );
    if ( 'pickup' !== $choice['mode'] ) {
        $order->delete_meta_data( '_dv_pickup_location' );
        return;
    }
    $row = dv_checkout_pickup_options()[ $choice['key'] ] ?? null;
    if ( ! $row ) throw new Exception( 'Пункт самовывоза недоступен. Выберите другой пункт.' );
    $order->update_meta_data( '_dv_pickup_location', $row );
    $order->set_shipping_address_1( $row['address'] );
    $order->set_shipping_address_2( $row['name'] );
    $order->set_shipping_city( $row['city'] );
    $order->set_shipping_state( '' );
    $order->set_shipping_postcode( '' );
    $order->set_shipping_country( 'RU' );
}
add_action( 'woocommerce_checkout_create_order', 'dv_checkout_pickup_save_order', 20, 2 );

function dv_order_pickup_text( $order ) {
    if ( 'pickup' !== $order->get_meta( '_dv_fulfilment' ) ) return '';
    $row = $order->get_meta( '_dv_pickup_location' );
    if ( ! is_array( $row ) ) return '';
    return implode( ', ', array_filter( array( $row['city'] ?? '', $row['address'] ?? '', $row['name'] ?? '', $row['hours'] ?? '', $row['phone'] ?? '' ) ) );
}

function dv_render_order_pickup( $order ) {
    $text = dv_order_pickup_text( $order );
    if ( $text ) echo '<p class="dv-order-pickup"><strong>Пункт самовывоза:</strong> ' . esc_html( $text ) . '</p>';
}
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'dv_render_order_pickup' );
add_action( 'woocommerce_order_details_after_customer_details', 'dv_render_order_pickup' );
add_filter( 'woocommerce_email_order_meta_fields', static function ( $fields, $sent_to_admin, $order ) {
    $text = dv_order_pickup_text( $order );
    if ( $text ) $fields['dv_pickup_location'] = array( 'label' => 'Пункт самовывоза', 'value' => $text );
    return $fields;
}, 10, 3 );
