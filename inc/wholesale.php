<?php
defined( 'ABSPATH' ) || exit;

function dv_wholesale_labels() {
    static $labels_cache = null;

    if ( is_array( $labels_cache ) ) {
        return $labels_cache;
    }

    $labels_cache = array(
        'page_title'        => html_entity_decode( '&#1054;&#1087;&#1090;&#1086;&#1074;&#1099;&#1081; &#1079;&#1072;&#1082;&#1072;&#1079;', ENT_QUOTES, 'UTF-8' ),
        'page_desc'         => html_entity_decode( '&#1041;&#1099;&#1089;&#1090;&#1088;&#1099;&#1081; &#1087;&#1086;&#1076;&#1073;&#1086;&#1088; &#1076;&#1077;&#1090;&#1072;&#1083;&#1077;&#1081; &#1089;&#1087;&#1080;&#1089;&#1082;&#1086;&#1084;: &#1087;&#1086;&#1080;&#1089;&#1082;, &#1082;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1080; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1072; &#1073;&#1077;&#1079; &#1083;&#1080;&#1096;&#1085;&#1080;&#1093; &#1096;&#1072;&#1075;&#1086;&#1074;.', ENT_QUOTES, 'UTF-8' ),
        'search'            => html_entity_decode( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1087;&#1086; &#1072;&#1088;&#1090;&#1080;&#1082;&#1091;&#1083;&#1091;, &#1084;&#1072;&#1088;&#1082;&#1077;, &#1084;&#1086;&#1076;&#1077;&#1083;&#1080;...', ENT_QUOTES, 'UTF-8' ),
        'submit'            => html_entity_decode( '&#1053;&#1072;&#1081;&#1090;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'all_categories'    => html_entity_decode( '&#1042;&#1089;&#1077; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'categories'        => html_entity_decode( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;', ENT_QUOTES, 'UTF-8' ),
        'found'             => html_entity_decode( '&#1053;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'products'          => html_entity_decode( '&#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;', ENT_QUOTES, 'UTF-8' ),
        'sku'               => html_entity_decode( '&#1040;&#1088;&#1090;.', ENT_QUOTES, 'UTF-8' ),
        'price'             => html_entity_decode( '&#1062;&#1077;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'stock'             => html_entity_decode( '&#1053;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'qty'               => html_entity_decode( '&#1050;&#1086;&#1083;-&#1074;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'add'               => html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'added'             => html_entity_decode( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1083;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ),
        'adding'            => html_entity_decode( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1083;&#1103;&#1077;&#1084;...', ENT_QUOTES, 'UTF-8' ),
        'open'              => html_entity_decode( '&#1054;&#1090;&#1082;&#1088;&#1099;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
        'not_quick'         => html_entity_decode( '&#1053;&#1091;&#1078;&#1077;&#1085; &#1074;&#1099;&#1073;&#1086;&#1088;', ENT_QUOTES, 'UTF-8' ),
        'in_stock'          => html_entity_decode( '&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'out_stock'         => html_entity_decode( '&#1053;&#1077;&#1090; &#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'price_request'     => html_entity_decode( '&#1062;&#1077;&#1085;&#1072; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'cart'              => html_entity_decode( '&#1050;&#1086;&#1088;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'checkout'          => html_entity_decode( '&#1054;&#1092;&#1086;&#1088;&#1084;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
        'empty'             => html_entity_decode( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1099;. &#1059;&#1090;&#1086;&#1095;&#1085;&#1080;&#1090;&#1077; &#1087;&#1086;&#1080;&#1089;&#1082; &#1080;&#1083;&#1080; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1102;.', ENT_QUOTES, 'UTF-8' ),
        'clear'             => html_entity_decode( '&#1057;&#1073;&#1088;&#1086;&#1089;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
        'connection_error'  => html_entity_decode( '&#1054;&#1096;&#1080;&#1073;&#1082;&#1072; &#1089;&#1086;&#1077;&#1076;&#1080;&#1085;&#1077;&#1085;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'add_error'         => html_entity_decode( '&#1053;&#1077; &#1091;&#1076;&#1072;&#1083;&#1086;&#1089;&#1100; &#1076;&#1086;&#1073;&#1072;&#1074;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
    );

    return $labels_cache;
}

function dv_wholesale_page_url() {
    return home_url( '/optovik/' );
}

function dv_is_wholesale_request() {
    $request_path = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH );
    $home_path    = wp_parse_url( home_url( '/' ), PHP_URL_PATH );

    $request_path = '/' . trim( (string) $request_path, '/' );
    $home_path    = '/' . trim( (string) $home_path, '/' );

    if ( '/' !== $home_path && 0 === strpos( $request_path, $home_path . '/' ) ) {
        $request_path = substr( $request_path, strlen( $home_path ) );
    }

    return 'optovik' === trim( $request_path, '/' );
}

function dv_wholesale_body_class( $classes ) {
    if ( dv_is_wholesale_request() ) {
        $classes[] = 'dv-wholesale';
    }

    return $classes;
}
add_filter( 'body_class', 'dv_wholesale_body_class' );

function dv_wholesale_document_title( $parts ) {
    if ( dv_is_wholesale_request() ) {
        $labels         = dv_wholesale_labels();
        $parts['title'] = $labels['page_title'];
    }

    return $parts;
}
add_filter( 'document_title_parts', 'dv_wholesale_document_title' );

function dv_wholesale_enqueue_assets() {
    if ( ! dv_is_wholesale_request() ) {
        return;
    }

    $css_path = get_stylesheet_directory() . '/assets/css/wholesale.css';
    $js_path  = get_stylesheet_directory() . '/assets/js/wholesale.js';

    if ( file_exists( $css_path ) ) {
        wp_enqueue_style(
            'dv-wholesale',
            DV_URI . '/assets/css/wholesale.css',
            array( 'dv-main' ),
            dv_theme_asset_version( 'assets/css/wholesale.css' )
        );
    }

    if ( file_exists( $js_path ) ) {
        wp_enqueue_script(
            'dv-wholesale',
            DV_URI . '/assets/js/wholesale.js',
            array(),
            dv_theme_asset_version( 'assets/js/wholesale.js' ),
            true
        );
        wp_script_add_data( 'dv-wholesale', 'defer', true );

        $labels = dv_wholesale_labels();
        wp_localize_script(
            'dv-wholesale',
            'dvWholesale',
            array(
                'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
                'nonce'       => wp_create_nonce( 'dv_add_cart' ),
                'cartUrl'     => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' ),
                'checkoutUrl' => function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/' ),
                'i18n'        => array(
                    'add'              => $labels['add'],
                    'added'            => $labels['added'],
                    'adding'           => $labels['adding'],
                    'connection_error' => $labels['connection_error'],
                    'add_error'        => $labels['add_error'],
                ),
            )
        );
    }
}
add_action( 'wp_enqueue_scripts', 'dv_wholesale_enqueue_assets', 20 );

function dv_wholesale_template_redirect() {
    if ( ! dv_is_wholesale_request() ) {
        return;
    }

    status_header( 200 );
    nocache_headers();

    global $wp_query;
    if ( $wp_query ) {
        $wp_query->is_404 = false;
    }

    include get_stylesheet_directory() . '/wholesale.php';
    exit;
}
add_action( 'template_redirect', 'dv_wholesale_template_redirect', 1 );

function dv_wholesale_get_request_args() {
    return array(
        'q'        => sanitize_text_field( wp_unslash( $_GET['q'] ?? '' ) ),
        'cat'      => sanitize_title( wp_unslash( $_GET['cat'] ?? '' ) ),
        'paged'    => max( 1, absint( $_GET['opt_page'] ?? 1 ) ),
        'per_page' => 48,
    );
}

function dv_wholesale_get_categories() {
    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return array();
    }

    $cache_key = function_exists( 'dv_product_section_cache_key' ) ? dv_product_section_cache_key( 'wholesale_categories' ) : '';
    $terms     = $cache_key ? get_transient( $cache_key ) : false;

    if ( ! is_array( $terms ) ) {
        $terms = get_terms(
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'orderby'    => 'name',
                'order'      => 'ASC',
            )
        );

        if ( is_wp_error( $terms ) ) {
            $terms = array();
        }

        if ( $cache_key ) {
            set_transient( $cache_key, $terms, 6 * HOUR_IN_SECONDS );
        }
    }

    if ( empty( $terms ) ) {
        return array();
    }

    $children_map = array();
    foreach ( $terms as $term ) {
        if ( ! $term instanceof WP_Term ) {
            continue;
        }

        $parent = (int) $term->parent;
        if ( ! isset( $children_map[ $parent ] ) ) {
            $children_map[ $parent ] = array();
        }

        $children_map[ $parent ][] = $term;
    }

    return dv_wholesale_get_category_branch( 0, 0, $children_map );
}

function dv_wholesale_get_category_branch( $parent_id = 0, $depth = 0, $children_map = array() ) {
    $terms = $children_map[ absint( $parent_id ) ] ?? array();

    if ( empty( $terms ) ) {
        return array();
    }

    $branch = array();
    foreach ( $terms as $term ) {
        $term->dv_depth = $depth;
        $branch[]       = $term;
        $branch         = array_merge( $branch, dv_wholesale_get_category_branch( $term->term_id, $depth + 1, $children_map ) );
    }

    return $branch;
}

function dv_wholesale_get_products_query( $args ) {
    $query_args = array(
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'posts_per_page'      => $args['per_page'],
        'paged'               => $args['paged'],
        'ignore_sticky_posts' => true,
        'orderby'             => array(
            'menu_order' => 'ASC',
            'title'      => 'ASC',
        ),
    );

    if ( '' !== $args['cat'] ) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => array( $args['cat'] ),
            ),
        );
    }

    if ( '' !== $args['q'] && function_exists( 'dv_get_product_search_ids' ) ) {
        $search = dv_get_product_search_ids( $args['q'], 0, array() );
        $ids    = array_values( array_filter( array_map( 'absint', $search['ids'] ?? array() ) ) );

        if ( empty( $ids ) ) {
            $query_args['post__in'] = array( 0 );
        } elseif ( '' === $args['cat'] ) {
            $sliced_ids = array_slice( $ids, ( $args['paged'] - 1 ) * $args['per_page'], $args['per_page'] );
            if ( empty( $sliced_ids ) ) {
                $sliced_ids = array( 0 );
            }

            $query_args['post__in']            = $sliced_ids;
            $query_args['posts_per_page']      = count( $sliced_ids );
            $query_args['paged']               = 1;
            $query_args['orderby']             = 'post__in';
            $query_args['no_found_rows']       = true;
            $query_args['dv_wholesale_total']  = (int) ( $search['total'] ?? count( $ids ) );
            $query_args['dv_wholesale_pages']  = max( 1, (int) ceil( $query_args['dv_wholesale_total'] / $args['per_page'] ) );
        } else {
            $query_args['post__in'] = $ids;
            $query_args['orderby']  = 'post__in';
        }
    } elseif ( '' !== $args['q'] ) {
        $query_args['s'] = $args['q'];
    }

    return new WP_Query( $query_args );
}

function dv_wholesale_get_all_products_total( $args = array() ) {
    $search_query = trim( (string) ( $args['q'] ?? '' ) );

    if ( '' !== $search_query && function_exists( 'dv_get_product_search_ids' ) ) {
        $search = dv_get_product_search_ids( $search_query, 0, array() );
        return (int) ( $search['total'] ?? count( $search['ids'] ?? array() ) );
    }

    if ( '' !== $search_query ) {
        $query = new WP_Query(
            array(
                'post_type'           => 'product',
                'post_status'         => 'publish',
                'posts_per_page'      => 1,
                'paged'               => 1,
                'ignore_sticky_posts' => true,
                's'                   => $search_query,
            )
        );

        $total = (int) $query->found_posts;
        wp_reset_postdata();

        return $total;
    }

    $counts = wp_count_posts( 'product' );
    return isset( $counts->publish ) ? (int) $counts->publish : 0;
}

function dv_wholesale_query_total( $query ) {
    $manual_total = (int) $query->get( 'dv_wholesale_total' );

    return $manual_total > 0 ? $manual_total : (int) $query->found_posts;
}

function dv_wholesale_query_pages( $query ) {
    $manual_pages = (int) $query->get( 'dv_wholesale_pages' );

    return $manual_pages > 0 ? $manual_pages : max( 1, (int) $query->max_num_pages );
}

function dv_wholesale_product_stock_text( $product, $labels ) {
    if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
        return '';
    }

    if ( ! $product->is_in_stock() ) {
        return $labels['out_stock'];
    }

    $qty = $product->get_stock_quantity();
    if ( null !== $qty && '' !== $qty ) {
        return $labels['in_stock'] . ' ' . absint( $qty ) . ' ' . html_entity_decode( '&#1096;&#1090;.', ENT_QUOTES, 'UTF-8' );
    }

    return $labels['in_stock'];
}

function dv_wholesale_product_can_quick_add( $product ) {
    return $product
        && is_a( $product, 'WC_Product' )
        && $product->is_purchasable()
        && $product->is_in_stock()
        && ( $product->is_type( 'simple' ) || $product->is_type( 'variation' ) );
}
