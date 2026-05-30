<?php
defined( 'ABSPATH' ) || exit;

function dv_lists_prepare_json_response() {
    while ( ob_get_level() > 0 ) {
        ob_end_clean();
    }
}

function dv_lists_security_error_message() {
    $labels = function_exists( 'dv_theme_labels' ) ? dv_theme_labels() : array();

    return $labels['security_error'] ?? html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1073;&#1077;&#1079;&#1086;&#1087;&#1072;&#1089;&#1085;&#1086;&#1089;&#1090;&#1080;. &#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1077; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1091;.', ENT_QUOTES, 'UTF-8' );
}

function dv_lists_verify_ajax_nonce() {
    if ( check_ajax_referer( 'dv_lists_action', 'nonce', false ) ) {
        return;
    }

    dv_lists_prepare_json_response();
    wp_send_json_error( array( 'message' => dv_lists_security_error_message() ), 403 );
}

function dv_lists_labels() {
    return array(
        'wishlist_empty'        => html_entity_decode( '&#1057;&#1087;&#1080;&#1089;&#1086;&#1082; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086; &#1087;&#1091;&#1089;&#1090;', ENT_QUOTES, 'UTF-8' ),
        'compare_loading'       => html_entity_decode( '&#1047;&#1072;&#1075;&#1088;&#1091;&#1079;&#1082;&#1072; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1103;...', ENT_QUOTES, 'UTF-8' ),
        'wishlist_loading'      => html_entity_decode( '&#1047;&#1072;&#1075;&#1088;&#1091;&#1079;&#1082;&#1072; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086;...', ENT_QUOTES, 'UTF-8' ),
        'wishlist_title'        => html_entity_decode( '&#1042; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1084;', ENT_QUOTES, 'UTF-8' ),
        'compare_short_title'   => html_entity_decode( '&#1050; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1102;', ENT_QUOTES, 'UTF-8' ),
        'go_catalog'            => html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1081;&#1090;&#1080; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;', ENT_QUOTES, 'UTF-8' ),
        'view_all'              => html_entity_decode( '&#1057;&#1084;&#1086;&#1090;&#1088;&#1077;&#1090;&#1100; &#1074;&#1089;&#1105;', ENT_QUOTES, 'UTF-8' ),
        'product_id_missing'    => html_entity_decode( '&#1053;&#1077; &#1087;&#1077;&#1088;&#1077;&#1076;&#1072;&#1085; product_id.', ENT_QUOTES, 'UTF-8' ),
        'products_not_found'    => html_entity_decode( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1099;', ENT_QUOTES, 'UTF-8' ),
        'compare_title'         => html_entity_decode( '&#1057;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;', ENT_QUOTES, 'UTF-8' ),
        'compare_positions'     => html_entity_decode( '&#1057;&#1088;&#1072;&#1074;&#1085;&#1080;&#1074;&#1072;&#1077;&#1084;&#1099;&#1093; &#1087;&#1086;&#1079;&#1080;&#1094;&#1080;&#1081;:', ENT_QUOTES, 'UTF-8' ),
        'only_diff'             => html_entity_decode( '&#1055;&#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1072;&#1090;&#1100; &#1090;&#1086;&#1083;&#1100;&#1082;&#1086; &#1088;&#1072;&#1079;&#1083;&#1080;&#1095;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'clear_all'             => html_entity_decode( '&#1054;&#1095;&#1080;&#1089;&#1090;&#1080;&#1090;&#1100; &#1074;&#1089;&#1105;', ENT_QUOTES, 'UTF-8' ),
        'param'                 => html_entity_decode( '&#1055;&#1072;&#1088;&#1072;&#1084;&#1077;&#1090;&#1088;', ENT_QUOTES, 'UTF-8' ),
        'price'                 => html_entity_decode( '&#1062;&#1077;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'stock'                 => html_entity_decode( '&#1053;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'article'               => html_entity_decode( '&#1040;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083;', ENT_QUOTES, 'UTF-8' ),
        'weight'                => html_entity_decode( '&#1042;&#1077;&#1089;', ENT_QUOTES, 'UTF-8' ),
        'price_request'         => html_entity_decode( '&#1062;&#1077;&#1085;&#1072; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'out_of_stock'          => html_entity_decode( '&#1053;&#1077;&#1090; &#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'in_stock'              => html_entity_decode( '&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'pcs_short'             => html_entity_decode( '&#1096;&#1090;.', ENT_QUOTES, 'UTF-8' ),
        'kg_short'              => html_entity_decode( '&#1082;&#1075;', ENT_QUOTES, 'UTF-8' ),
        'remove'                => html_entity_decode( '&#1059;&#1073;&#1088;&#1072;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
        'details'               => html_entity_decode( '&#1055;&#1086;&#1076;&#1088;&#1086;&#1073;&#1085;&#1077;&#1077;', ENT_QUOTES, 'UTF-8' ),
    );
}

function dv_get_list_preview_products( $ids, $limit = 4 ) {
    $products = array();

    foreach ( array_slice( (array) $ids, 0, $limit ) as $id ) {
        $product = wc_get_product( $id );

        if ( ! $product || ! $product->is_visible() ) {
            continue;
        }

        $products[] = $product;
    }

    return $products;
}

function dv_render_list_preview_html( $ids, $type = 'wishlist', $view_url = '' ) {
    $labels   = dv_lists_labels();
    $limit    = 'compare' === $type && function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'compare_limit', 4, 2, 8 ) : 4;
    $products = dv_get_list_preview_products( $ids, $limit );
    $title    = 'compare' === $type ? $labels['compare_short_title'] : $labels['wishlist_title'];

    if ( empty( $products ) ) {
        return '<div class="dv-header-preview-empty">' . esc_html( 'wishlist' === $type ? $labels['wishlist_empty'] : $labels['products_not_found'] ) . '</div>';
    }

    ob_start();
    ?>
    <div class="dv-header-preview-head">
      <div class="dv-header-preview-title"><?php echo esc_html( $title ); ?></div>
      <?php if ( $view_url ) : ?>
        <a href="<?php echo esc_url( $view_url ); ?>" class="dv-header-preview-all"><?php echo esc_html( $labels['view_all'] ); ?></a>
      <?php endif; ?>
    </div>
    <div class="dv-header-preview-list">
      <?php foreach ( $products as $product ) : ?>
        <?php
        $image_url = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' );
        if ( ! $image_url ) {
            $image_url = wc_placeholder_img_src( 'woocommerce_thumbnail' );
        }
        ?>
        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="dv-header-preview-item">
          <img src="<?php echo esc_url( $image_url ); ?>" alt="" class="dv-header-preview-thumb">
          <span class="dv-header-preview-main">
            <span class="dv-header-preview-name"><?php echo esc_html( wp_trim_words( function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name(), 8, '...' ) ); ?></span>
            <span class="dv-header-preview-price"><?php echo wp_kses_post( $product->get_price_html() ? $product->get_price_html() : esc_html( $labels['price_request'] ) ); ?></span>
          </span>
        </a>
      <?php endforeach; ?>
    </div>
    <?php

    return ob_get_clean();
}

function dv_parse_id_list( $raw ) {
    if ( is_array( $raw ) ) {
        $raw = implode( ',', $raw );
    }

    $raw = sanitize_text_field( wp_unslash( (string) $raw ) );
    if ( '' === $raw ) {
        return array();
    }

    return array_values( array_filter( array_map( 'absint', explode( ',', $raw ) ) ) );
}

function dv_get_cookie_id_list( $cookie_name ) {
    return dv_parse_id_list( $_COOKIE[ $cookie_name ] ?? '' );
}

function dv_ajax_toggle_wishlist() {
    $labels     = dv_lists_labels();
    dv_lists_verify_ajax_nonce();

    $product_id = absint( $_POST['product_id'] ?? 0 );

    if ( ! $product_id ) {
        dv_lists_prepare_json_response();
        wp_send_json_error( array( 'message' => $labels['product_id_missing'] ) );
    }

    $list = dv_get_cookie_id_list( 'dv_wishlist' );

    if ( in_array( $product_id, $list, true ) ) {
        $list  = array_values( array_diff( $list, array( $product_id ) ) );
        $added = false;
    } else {
        $list[] = $product_id;
        $added  = true;
    }

    $list    = array_values( array_unique( array_filter( $list ) ) );

    dv_lists_prepare_json_response();
    wp_send_json_success(
        array(
            'added' => $added,
            'count' => count( $list ),
            'items' => $list,
        )
    );
}
add_action( 'wp_ajax_dv_toggle_wishlist', 'dv_ajax_toggle_wishlist' );
add_action( 'wp_ajax_nopriv_dv_toggle_wishlist', 'dv_ajax_toggle_wishlist' );

function dv_wishlist_shortcode() {
    static $rendered = false;
    $labels          = dv_lists_labels();

    if ( $rendered ) {
        return '';
    }

    $rendered = true;

    ob_start();
    ?>
    <div id="dv-wishlist-wrap" class="dv-wishlist-shell" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-shop-url="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
      <div id="dv-wishlist-container" class="dv-wishlist-container is-hidden"></div>
      <div id="dv-wishlist-empty" class="dv-compare-empty is-hidden">
        <p class="dv-compare-empty-title"><?php echo esc_html( $labels['wishlist_empty'] ); ?></p>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="dv-compare-empty-link"><?php echo esc_html( $labels['go_catalog'] ); ?></a>
      </div>
      <div id="dv-wishlist-loading" class="dv-compare-loading"><?php echo esc_html( $labels['wishlist_loading'] ); ?></div>
    </div>
    <?php

    return ob_get_clean();
}
add_shortcode( 'dv_wishlist', 'dv_wishlist_shortcode' );

function dv_ajax_get_wishlist_products() {
    dv_lists_verify_ajax_nonce();

    $ids = dv_parse_id_list( $_POST['ids'] ?? '' );

    if ( empty( $ids ) ) {
        dv_lists_prepare_json_response();
        wp_send_json_success( array( 'html' => '' ) );
    }

    ob_start();
    echo '<div class="woocommerce"><ul class="products">';

    foreach ( $ids as $id ) {
        $wishlist_product = wc_get_product( $id );

        if ( ! $wishlist_product || ! $wishlist_product->is_visible() ) {
            continue;
        }

        global $post;
        $post = get_post( $id );
        if ( ! $post ) {
            continue;
        }

        setup_postdata( $post );
        wc_get_template_part( 'content', 'product' );
    }

    wp_reset_postdata();
    echo '</ul></div>';

    $html = ob_get_clean();

    dv_lists_prepare_json_response();
    wp_send_json_success(
        array(
            'html' => $html,
        )
    );
}
add_action( 'wp_ajax_dv_get_wishlist_products', 'dv_ajax_get_wishlist_products' );
add_action( 'wp_ajax_nopriv_dv_get_wishlist_products', 'dv_ajax_get_wishlist_products' );

function dv_ajax_get_header_list_preview() {
    dv_lists_verify_ajax_nonce();

    $type     = sanitize_key( $_POST['type'] ?? 'wishlist' );
    $ids      = dv_parse_id_list( $_POST['ids'] ?? '' );
    $view_url = '';

    if ( 'compare' === $type ) {
        $view_url = home_url( '/compare/' );
    } else {
        $type     = 'wishlist';
        $view_url = function_exists( 'wc_get_wishlist_url' ) ? wc_get_wishlist_url() : home_url( '/wishlist/' );
    }

    if ( 'compare' === $type && function_exists( 'dv_theme_option_int' ) ) {
        $ids = array_slice( $ids, 0, dv_theme_option_int( 'compare_limit', 4, 2, 8 ) );
    }

    dv_lists_prepare_json_response();
    wp_send_json_success(
        array(
            'html'  => dv_render_list_preview_html( $ids, $type, $view_url ),
            'count' => count( $ids ),
        )
    );
}
add_action( 'wp_ajax_dv_get_header_list_preview', 'dv_ajax_get_header_list_preview' );
add_action( 'wp_ajax_nopriv_dv_get_header_list_preview', 'dv_ajax_get_header_list_preview' );

function dv_compare_shortcode() {
    $labels = dv_lists_labels();
    ob_start();
    ?>
    <div id="dv-compare-container" class="dv-compare-shell" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-shop-url="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">
      <div class="dv-compare-loading"><?php echo esc_html( $labels['compare_loading'] ); ?></div>
    </div>
    <?php

    return ob_get_clean();
}
add_shortcode( 'dv_compare', 'dv_compare_shortcode' );

function dv_compare_normalize_value( $value ) {
    if ( is_array( $value ) ) {
        $value = implode( ', ', $value );
    }

    return trim( wp_strip_all_tags( (string) $value ) );
}

function dv_compare_has_diff( $values ) {
    $values = array_map( 'dv_compare_normalize_value', (array) $values );
    $values = array_values( array_unique( $values ) );

    if ( 1 === count( $values ) && '' === $values[0] ) {
        return false;
    }

    return count( $values ) > 1;
}

function dv_ajax_get_compare_table() {
    $labels = dv_lists_labels();
    dv_lists_verify_ajax_nonce();

    $ids    = dv_parse_id_list( $_POST['ids'] ?? '' );
    $limit  = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'compare_limit', 4, 2, 8 ) : 4;
    $ids    = array_slice( $ids, 0, $limit );

    if ( empty( $ids ) ) {
        dv_lists_prepare_json_response();
        wp_send_json_success( array( 'html' => '' ) );
    }

    $products = array();
    foreach ( $ids as $id ) {
        $product = wc_get_product( $id );
        if ( $product ) {
            $products[] = $product;
        }
    }

    if ( empty( $products ) ) {
        dv_lists_prepare_json_response();
        wp_send_json_success(
            array(
                'html' => '<div class="dv-compare-empty"><p class="dv-compare-empty-title">' . esc_html( $labels['products_not_found'] ) . '</p><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="dv-compare-empty-link">' . esc_html( $labels['go_catalog'] ) . '</a></div>',
            )
        );
    }

    $attribute_rows = array();
    foreach ( $products as $product ) {
        foreach ( $product->get_attributes() as $attribute ) {
            $key = $attribute->get_name();
            if ( ! isset( $attribute_rows[ $key ] ) ) {
                $attribute_rows[ $key ] = wc_attribute_label( $key );
            }
        }
    }

    $rows = array(
        array(
            'label' => $labels['price'],
            'diff'  => true,
            'raw'   => static function ( $product ) {
                return (string) $product->get_price();
            },
            'html'  => static function ( $product ) use ( $labels ) {
                $price = $product->get_price_html();
                return $price ? '<span class="dv-compare-value-price">' . wp_kses_post( $price ) . '</span>' : '<span class="dv-compare-empty-value">' . esc_html( $labels['price_request'] ) . '</span>';
            },
        ),
        array(
            'label' => $labels['stock'],
            'diff'  => true,
            'raw'   => static function ( $product ) {
                if ( ! $product->is_in_stock() ) {
                    return 'out';
                }
                $qty = $product->get_stock_quantity();
                return 'in:' . ( null === $qty ? '' : (string) $qty );
            },
            'html'  => static function ( $product ) use ( $labels ) {
                if ( ! $product->is_in_stock() ) {
                    return '<span class="dv-compare-stock is-out-stock">' . esc_html( $labels['out_of_stock'] ) . '</span>';
                }
                $qty   = $product->get_stock_quantity();
                $label = $labels['in_stock'];
                if ( null !== $qty && '' !== $qty ) {
                    $label .= ' ' . intval( $qty ) . ' ' . $labels['pcs_short'];
                }
                return '<span class="dv-compare-stock is-in-stock">&bull; ' . esc_html( $label ) . '</span>';
            },
        ),
        array(
            'label' => $labels['article'],
            'diff'  => false,
            'raw'   => static function ( $product ) {
                return (string) $product->get_sku();
            },
            'html'  => static function ( $product ) {
                $sku = $product->get_sku();
                return $sku ? '<span class="dv-compare-code">' . esc_html( $sku ) . '</span>' : '<span class="dv-compare-empty-value">&mdash;</span>';
            },
        ),
        array(
            'label' => $labels['weight'],
            'diff'  => true,
            'raw'   => static function ( $product ) {
                return (string) $product->get_weight();
            },
            'html'  => static function ( $product ) use ( $labels ) {
                $weight = $product->get_weight();
                return '' !== (string) $weight ? esc_html( wc_format_localized_decimal( $weight ) . ' ' . $labels['kg_short'] ) : '<span class="dv-compare-empty-value">&mdash;</span>';
            },
        ),
    );

    foreach ( $attribute_rows as $key => $label ) {
        $rows[] = array(
            'label' => $label,
            'diff'  => true,
            'raw'   => static function ( $product ) use ( $key ) {
                return (string) $product->get_attribute( $key );
            },
            'html'  => static function ( $product ) use ( $key ) {
                $value = $product->get_attribute( $key );
                return '' !== trim( wp_strip_all_tags( $value ) ) ? esc_html( $value ) : '<span class="dv-compare-empty-value">&mdash;</span>';
            },
        );
    }

    ob_start();
    ?>
    <div class="dv-compare-open">
      <div class="dv-compare-head">
        <div class="dv-compare-head-main">
          <h2 class="dv-compare-title"><?php echo esc_html( $labels['compare_title'] ); ?></h2>
          <div class="dv-compare-subtitle"><?php echo esc_html( $labels['compare_positions'] ); ?> <?php echo esc_html( count( $products ) ); ?></div>
        </div>
        <div class="dv-compare-head-actions">
          <label class="dv-compare-diff-toggle">
            <input type="checkbox" class="dv-compare-diff-checkbox">
            <span><?php echo esc_html( $labels['only_diff'] ); ?></span>
          </label>
          <button type="button" class="dv-compare-clear" data-compare-action="clear"><?php echo esc_html( $labels['clear_all'] ); ?></button>
        </div>
      </div>
      <div class="dv-compare-table-wrap">
        <table class="dv-compare-table">
          <thead>
            <tr>
              <th class="dv-compare-label-head"><?php echo esc_html( $labels['param'] ); ?></th>
              <?php foreach ( $products as $product ) : ?>
                <?php
                $image_url = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' );
                if ( ! $image_url ) {
                    $image_url = wc_placeholder_img_src( 'woocommerce_thumbnail' );
                }
                ?>
                <th class="dv-compare-product-head">
                  <div class="dv-compare-product-card">
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="" class="dv-compare-product-image">
                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="dv-compare-product-name"><?php echo esc_html( wp_trim_words( function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name(), 12, '...' ) ); ?></a>
                    <div class="dv-compare-product-price"><?php echo wp_kses_post( $product->get_price_html() ?: esc_html( $labels['price_request'] ) ); ?></div>
                    <button type="button" class="dv-compare-remove" data-compare-action="remove" data-product-id="<?php echo intval( $product->get_id() ); ?>"><?php echo esc_html( $labels['remove'] ); ?></button>
                  </div>
                </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ( $rows as $index => $row ) : ?>
              <?php
              $raw_values = array();
              foreach ( $products as $product ) {
                  $raw_values[] = call_user_func( $row['raw'], $product );
              }
              $has_diff = ! empty( $row['diff'] ) && dv_compare_has_diff( $raw_values );
              $classes  = array();
              if ( $index % 2 ) {
                  $classes[] = 'is-even';
              }
              if ( $has_diff ) {
                  $classes[] = 'has-diff';
              }
              ?>
              <tr class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
                <td class="dv-compare-label-cell"><?php echo esc_html( $row['label'] ); ?></td>
                <?php foreach ( $products as $product ) : ?>
                  <td class="dv-compare-value-cell"><?php echo wp_kses_post( call_user_func( $row['html'], $product ) ); ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
            <tr class="dv-compare-actions-row">
              <td class="dv-compare-label-cell"></td>
              <?php foreach ( $products as $product ) : ?>
                <td class="dv-compare-value-cell"><a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="dv-compare-remove"><?php echo esc_html( $labels['details'] ); ?></a></td>
              <?php endforeach; ?>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <?php

    $html = ob_get_clean();

    dv_lists_prepare_json_response();
    wp_send_json_success(
        array(
            'html' => $html,
        )
    );
}
add_action( 'wp_ajax_dv_get_compare_table', 'dv_ajax_get_compare_table' );
add_action( 'wp_ajax_nopriv_dv_get_compare_table', 'dv_ajax_get_compare_table' );

