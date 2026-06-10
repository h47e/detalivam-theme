<?php
/**
 * Product archive.
 *
 * @version 8.6.0
 */

get_header();

global $wp, $wp_query;

$current_cat    = is_product_category() ? get_queried_object() : null;
$cat_trail      = $current_cat && function_exists( 'dv_get_term_trail' ) ? dv_get_term_trail( $current_cat, 'product_cat' ) : [];
$search_term    = is_search() ? get_search_query() : '';
$selected_marka = sanitize_title( wp_unslash( $_GET['marka'] ?? '' ) );
$selected_stock = isset( $_GET['stock'] ) && 'instock' === $_GET['stock'];
$selected_min   = sanitize_text_field( wp_unslash( $_GET['min_price'] ?? '' ) );
$selected_max   = sanitize_text_field( wp_unslash( $_GET['max_price'] ?? '' ) );
$current_url    = home_url( add_query_arg( [], $wp->request ?? '' ) );
$reset_args     = $_GET;

unset( $reset_args['marka'], $reset_args['stock'], $reset_args['min_price'], $reset_args['max_price'], $reset_args['paged'] );

$active_filters = [];
$labels         = array(
    'home'             => html_entity_decode( '&#1043;&#1083;&#1072;&#1074;&#1085;&#1072;&#1103;', ENT_QUOTES, 'UTF-8' ),
    'catalog'          => html_entity_decode( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;', ENT_QUOTES, 'UTF-8' ),
    'search_results'   => html_entity_decode( '&#1056;&#1077;&#1079;&#1091;&#1083;&#1100;&#1090;&#1072;&#1090;&#1099; &#1087;&#1086;&#1080;&#1089;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ),
    'query'            => html_entity_decode( '&#1047;&#1072;&#1087;&#1088;&#1086;&#1089;:', ENT_QUOTES, 'UTF-8' ),
    'catalog_title'    => html_entity_decode( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081;', ENT_QUOTES, 'UTF-8' ),
    'path_here'        => html_entity_decode( '&#1042;&#1099; &#1079;&#1076;&#1077;&#1089;&#1100;', ENT_QUOTES, 'UTF-8' ),
    'marka'            => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1072; &#1058;&#1057;', ENT_QUOTES, 'UTF-8' ),
    'marka_empty'      => html_entity_decode( '&#1044;&#1086;&#1073;&#1072;&#1074;&#1100;&#1090;&#1077; &#1072;&#1090;&#1088;&#1080;&#1073;&#1091;&#1090; &laquo;&#1052;&#1072;&#1088;&#1082;&#1072; &#1058;&#1057;&raquo; &#1082; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;&#1084;', ENT_QUOTES, 'UTF-8' ),
    'categories'       => html_entity_decode( '&#1050;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
    'subcategories'    => html_entity_decode( '&#1055;&#1086;&#1076;&#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
    'neighbor_sections'=> html_entity_decode( '&#1057;&#1086;&#1089;&#1077;&#1076;&#1085;&#1080;&#1077; &#1088;&#1072;&#1079;&#1076;&#1077;&#1083;&#1099;', ENT_QUOTES, 'UTF-8' ),
    'price'            => html_entity_decode( '&#1062;&#1077;&#1085;&#1072;, &#8381;', ENT_QUOTES, 'UTF-8' ),
    'from'             => html_entity_decode( '&#1086;&#1090;', ENT_QUOTES, 'UTF-8' ),
    'to'               => html_entity_decode( '&#1076;&#1086;', ENT_QUOTES, 'UTF-8' ),
    'apply'            => html_entity_decode( '&#1055;&#1088;&#1080;&#1084;&#1077;&#1085;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
    'stock'            => html_entity_decode( '&#1053;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
    'in_stock'         => html_entity_decode( '&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
    'you_may_like'     => html_entity_decode( '&#1042;&#1072;&#1084; &#1084;&#1086;&#1078;&#1077;&#1090; &#1087;&#1086;&#1085;&#1088;&#1072;&#1074;&#1080;&#1090;&#1100;&#1089;&#1103;', ENT_QUOTES, 'UTF-8' ),
    'price_on_request' => html_entity_decode( '&#1062;&#1077;&#1085;&#1072; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091;', ENT_QUOTES, 'UTF-8' ),
    'found'            => html_entity_decode( '&#1053;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ),
    'products'         => html_entity_decode( '&#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;', ENT_QUOTES, 'UTF-8' ),
    'reset'            => html_entity_decode( '&#1057;&#1073;&#1088;&#1086;&#1089;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
    'sort'             => html_entity_decode( '&#1057;&#1086;&#1088;&#1090;&#1080;&#1088;&#1086;&#1074;&#1082;&#1072;:', ENT_QUOTES, 'UTF-8' ),
    'search'           => html_entity_decode( '&#1055;&#1086;&#1080;&#1089;&#1082;:', ENT_QUOTES, 'UTF-8' ),
    'not_found'        => html_entity_decode( '&#1058;&#1086;&#1074;&#1072;&#1088;&#1099; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1099;', ENT_QUOTES, 'UTF-8' ),
    'empty_text'       => html_entity_decode( '&#1055;&#1086;&#1087;&#1088;&#1086;&#1073;&#1091;&#1081;&#1090;&#1077; &#1080;&#1079;&#1084;&#1077;&#1085;&#1080;&#1090;&#1100; &#1092;&#1080;&#1083;&#1100;&#1090;&#1088;&#1099; &#1080;&#1083;&#1080;', ENT_QUOTES, 'UTF-8' ),
    'reset_search'     => html_entity_decode( '&#1089;&#1073;&#1088;&#1086;&#1089;&#1080;&#1090;&#1100; &#1087;&#1086;&#1080;&#1089;&#1082;', ENT_QUOTES, 'UTF-8' ),
    'label_brand'      => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1072;:', ENT_QUOTES, 'UTF-8' ),
    'label_price'      => html_entity_decode( '&#1062;&#1077;&#1085;&#1072;:', ENT_QUOTES, 'UTF-8' ),
    'current_section'  => html_entity_decode( '&#1056;&#1072;&#1079;&#1076;&#1077;&#1083;', ENT_QUOTES, 'UTF-8' ),
    'active_filters'   => html_entity_decode( '&#1040;&#1082;&#1090;&#1080;&#1074;&#1085;&#1099;&#1077; &#1092;&#1080;&#1083;&#1100;&#1090;&#1088;&#1099;', ENT_QUOTES, 'UTF-8' ),
    'search_note'      => html_entity_decode( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091;', ENT_QUOTES, 'UTF-8' ),
);

$has_active_marka = false;

if ( '' !== $selected_marka ) {
    $marka_taxonomy = function_exists( 'dv_get_marka_taxonomy' ) ? dv_get_marka_taxonomy() : '';
    $marka_term     = $marka_taxonomy ? get_term_by( 'slug', $selected_marka, $marka_taxonomy ) : false;

    if ( $marka_term && ! is_wp_error( $marka_term ) ) {
        $has_active_marka = true;
        $args = $reset_args;
        if ( $selected_stock ) {
            $args['stock'] = 'instock';
        }
        if ( '' !== $selected_min ) {
            $args['min_price'] = $selected_min;
        }
        if ( '' !== $selected_max ) {
            $args['max_price'] = $selected_max;
        }

        $active_filters[] = [
            'label' => $labels['label_brand'] . ' ' . $marka_term->name,
            'url'   => add_query_arg(
                array_filter(
                    $args,
                    static function ( $value ) {
                        return null !== $value && '' !== $value;
                    }
                ),
                $current_url
            ),
        ];
    }
}

if ( $selected_stock ) {
    $args = $_GET;
    unset( $args['stock'], $args['paged'] );

    $active_filters[] = [
        'label' => $labels['in_stock'],
        'url'   => add_query_arg( $args, $current_url ),
    ];
}

if ( '' !== $selected_min || '' !== $selected_max ) {
    $parts = [];
    if ( '' !== $selected_min ) {
        $parts[] = $labels['from'] . ' ' . $selected_min;
    }
    if ( '' !== $selected_max ) {
        $parts[] = $labels['to'] . ' ' . $selected_max;
    }

    $args = $_GET;
    unset( $args['min_price'], $args['max_price'], $args['paged'] );

    $active_filters[] = [
        'label' => $labels['label_price'] . ' ' . implode( ' ', $parts ),
        'url'   => add_query_arg( $args, $current_url ),
    ];
}

$reset_url = add_query_arg(
    array_filter(
        $reset_args,
        static function ( $value ) {
            return '' !== $value && null !== $value;
        }
    ),
    $current_url
);

$catalog_total = (int) wc_get_loop_prop( 'total' );
$active_count  = count( $active_filters );
$marka_limit   = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_marka_limit', 30, 1, 80 ) : 30;
$cats_limit    = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_category_limit', 10, 1, 40 ) : 10;
$path_enabled  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_path_enabled' ) : true;
$marka_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_marka_enabled' ) : true;
$cats_enabled  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_categories_enabled' ) : true;
$price_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_price_enabled' ) : true;
$stock_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_stock_enabled' ) : true;
$recs_enabled  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'catalog_recs_enabled' ) : true;
$recs_limit    = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_recs_limit', 3, 1, 12 ) : 3;
$path_order    = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_path_order', 10, 1, 99 ) : 10;
$marka_order   = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_marka_order', 20, 1, 99 ) : 20;
$cats_order    = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_categories_order', 30, 1, 99 ) : 30;
$price_order   = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_price_order', 40, 1, 99 ) : 40;
$stock_order   = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_stock_order', 50, 1, 99 ) : 50;
$recs_order    = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_recs_order', 60, 1, 99 ) : 60;
$catalog_columns = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'catalog_columns', 4, 2, 6 ) : 4;
if ( $search_term ) {
    $custom_search_total = $wp_query instanceof WP_Query ? (int) $wp_query->get( 'dv_search_total', 0 ) : 0;
    if ( $custom_search_total >= 0 ) {
        $catalog_total = $custom_search_total;
    }
}

$marka_taxonomy = function_exists( 'dv_get_marka_taxonomy' ) ? dv_get_marka_taxonomy() : '';
$marka_terms    = array();

if ( $marka_taxonomy ) {
    $marka_cache_key = function_exists( 'dv_product_section_cache_key' )
        ? dv_product_section_cache_key( 'catalog_marka_terms|' . $marka_taxonomy . '|' . $marka_limit )
        : '';
    $marka_terms     = $marka_cache_key ? get_transient( $marka_cache_key ) : false;

    if ( ! is_array( $marka_terms ) ) {
        $marka_terms = get_terms(
            array(
                'taxonomy'   => $marka_taxonomy,
                'hide_empty' => true,
                'orderby'    => 'count',
                'order'      => 'DESC',
                'number'     => $marka_limit,
            )
        );

        if ( $marka_cache_key && ! is_wp_error( $marka_terms ) ) {
            set_transient( $marka_cache_key, $marka_terms, 6 * HOUR_IN_SECONDS );
        }
    }

    if ( is_wp_error( $marka_terms ) ) {
        $marka_terms = array();
    }
}

if ( empty( $marka_terms ) && function_exists( 'wc_get_product' ) && $wp_query instanceof WP_Query && ! empty( $wp_query->posts ) ) {
    $brand_map = array();

        foreach ( $wp_query->posts as $query_product_post ) {
            $fallback_product_id = $query_product_post instanceof WP_Post ? $query_product_post->ID : absint( $query_product_post );
            $fallback_product    = function_exists( 'dv_get_product_cached' ) ? dv_get_product_cached( $fallback_product_id ) : wc_get_product( $fallback_product_id );

            if ( ! $fallback_product || ! $fallback_product->is_visible() ) {
                continue;
            }

            $product_brands = function_exists( 'dv_get_product_marka_values' )
                ? dv_get_product_marka_values( $fallback_product, $marka_taxonomy )
                : array();

            foreach ( $product_brands as $brand_data ) {
                if ( empty( $brand_data['slug'] ) || empty( $brand_data['name'] ) ) {
                    continue;
                }

                if ( empty( $brand_map[ $brand_data['slug'] ] ) ) {
                    $brand_map[ $brand_data['slug'] ] = (object) array(
                        'name'  => $brand_data['name'],
                        'slug'  => $brand_data['slug'],
                        'count' => 0,
                    );
                }

                $brand_map[ $brand_data['slug'] ]->count++;
            }
        }

    $marka_terms = array_values( $brand_map );
    usort(
        $marka_terms,
        static function ( $a, $b ) {
            return strnatcasecmp( $a->name, $b->name );
        }
    );
}

if ( '' !== $selected_marka && ! $has_active_marka ) {
    $marka_label = '';

    foreach ( $marka_terms as $term ) {
        if ( isset( $term->slug, $term->name ) && $selected_marka === $term->slug ) {
            $marka_label = $term->name;
            break;
        }
    }

    if ( '' === $marka_label ) {
        $marka_label = str_replace( '-', ' ', $selected_marka );
    }

    $args = $reset_args;
    if ( $selected_stock ) {
        $args['stock'] = 'instock';
    }
    if ( '' !== $selected_min ) {
        $args['min_price'] = $selected_min;
    }
    if ( '' !== $selected_max ) {
        $args['max_price'] = $selected_max;
    }

    $active_filters[] = [
        'label' => $labels['label_brand'] . ' ' . $marka_label,
        'url'   => add_query_arg(
            array_filter(
                $args,
                static function ( $value ) {
                    return null !== $value && '' !== $value;
                }
            ),
            $current_url
        ),
    ];
}

$filter_title = $labels['categories'];
$cats         = function_exists( 'dv_get_top_product_categories' )
    ? dv_get_top_product_categories( $cats_limit )
    : get_terms(
        [
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'parent'     => 0,
            'orderby'    => 'count',
            'order'      => 'DESC',
            'number'     => $cats_limit,
        ]
    );

if ( $current_cat ) {
    $filter_title = $labels['subcategories'];
    $cats         = function_exists( 'dv_get_top_product_categories' )
        ? dv_get_top_product_categories( 0, $current_cat->term_id, 'name', 'ASC' )
        : get_terms(
            [
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'parent'     => $current_cat->term_id,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ]
        );

    if ( empty( $cats ) && ! empty( $current_cat->parent ) ) {
        $filter_title = $labels['neighbor_sections'];
        $cats         = function_exists( 'dv_get_top_product_categories' )
            ? dv_get_top_product_categories( 0, $current_cat->parent, 'name', 'ASC' )
            : get_terms(
                [
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'parent'     => $current_cat->parent,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                ]
            );
    }

    if ( empty( $cats ) ) {
        $filter_title = $labels['categories'];
        $cats         = function_exists( 'dv_get_top_product_categories' )
            ? dv_get_top_product_categories( $cats_limit )
            : get_terms(
                [
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'parent'     => 0,
                    'orderby'    => 'count',
                    'order'      => 'DESC',
                    'number'     => $cats_limit,
                ]
            );
    }
}

$recs = $recs_enabled && function_exists( 'dv_get_catalog_recommendation_products' )
    ? dv_get_catalog_recommendation_products( $recs_limit )
    : array();

$seo_h1     = '';
$seo_intro  = '';
$seo_text   = '';
$seo_faq    = array();

if ( $current_cat ) {
    $seo_h1    = function_exists( 'dv_build_term_seo_h1' ) ? dv_build_term_seo_h1( $current_cat ) : '';
    $seo_intro = function_exists( 'dv_get_term_effective_seo_intro' ) ? dv_get_term_effective_seo_intro( $current_cat ) : '';
    $seo_text  = function_exists( 'dv_get_term_effective_seo_text' ) ? dv_get_term_effective_seo_text( $current_cat ) : '';
    $seo_faq   = function_exists( 'dv_get_term_effective_seo_faq' ) ? dv_get_term_effective_seo_faq( $current_cat ) : array();
}
?>

<div class="container">
  <div class="breadcrumbs-wrap">
    <nav class="breadcrumbs">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $labels['home'] ); ?></a>
      <span class="sep">/</span>
      <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php echo esc_html( $labels['catalog'] ); ?></a>

      <?php if ( $search_term ) : ?>
        <span class="sep">/</span>
        <span class="current"><?php echo esc_html( $labels['search'] ); ?> <?php echo esc_html( $search_term ); ?></span>
      <?php endif; ?>

      <?php if ( $current_cat ) : ?>
        <?php foreach ( $cat_trail as $index => $trail_term ) : ?>
          <span class="sep">/</span>
          <?php if ( $index === count( $cat_trail ) - 1 ) : ?>
            <span class="current"><?php echo esc_html( $trail_term->name ); ?></span>
          <?php else : ?>
            <a href="<?php echo esc_url( get_term_link( $trail_term ) ); ?>"><?php echo esc_html( $trail_term->name ); ?></a>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </nav>
  </div>
</div>

<div class="container catalog-page-shell">
  <?php if ( $search_term ) : ?>
    <div class="catalog-heading">
      <h1 class="catalog-heading-title"><?php echo esc_html( $labels['search_results'] ); ?></h1>
      <p class="catalog-heading-desc"><?php echo esc_html( $labels['query'] ); ?> <?php echo esc_html( $search_term ); ?></p>
    </div>
  <?php elseif ( $current_cat ) : ?>
    <div class="catalog-heading">
      <h1 class="catalog-heading-title"><?php echo esc_html( $seo_h1 ?: $current_cat->name ); ?></h1>
      <?php if ( $seo_intro ) : ?>
        <div class="catalog-heading-desc"><?php echo wp_kses_post( wpautop( $seo_intro ) ); ?></div>
      <?php endif; ?>
    </div>
  <?php else : ?>
    <h1 class="catalog-heading-title"><?php echo esc_html( $labels['catalog_title'] ); ?></h1>
  <?php endif; ?>

  <div class="catalog-layout">
    <aside class="catalog-sidebar">
      <?php
      $sidebar_blocks = array();

      if ( $path_enabled && $current_cat && ! empty( $cat_trail ) ) :
        ob_start();
        ?>
        <div class="filter-widget filter-widget--path filter-widget--mobile-accordion is-open" data-filter-widget>
          <button type="button" class="filter-widget-toggle" data-filter-toggle aria-expanded="true">
            <span class="filter-title"><?php echo esc_html( $labels['path_here'] ); ?></span>
            <span class="filter-widget-toggle-icon" aria-hidden="true"></span>
          </button>
          <div class="filter-widget-body" data-filter-body>
            <div class="filter-path">
            <?php foreach ( $cat_trail as $index => $trail_term ) : ?>
              <?php $is_last = $index === count( $cat_trail ) - 1; ?>
              <a href="<?php echo esc_url( get_term_link( $trail_term ) ); ?>" class="filter-path-item<?php echo $is_last ? ' is-current' : ''; ?>">
                <span class="filter-path-step"><?php echo esc_html( $index + 1 ); ?></span>
                <span class="filter-path-name"><?php echo esc_html( $trail_term->name ); ?></span>
              </a>
            <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php
        $sidebar_blocks[] = array(
            'order' => $path_order,
            'key'   => 'path',
            'html'  => ob_get_clean(),
        );
      endif;

      if ( $marka_enabled ) :
        ob_start();
        ?>
      <div class="filter-widget filter-widget--marka filter-widget--mobile-accordion<?php echo '' !== $selected_marka ? ' is-open' : ''; ?>" data-filter-widget>
        <button type="button" class="filter-widget-toggle" data-filter-toggle aria-expanded="<?php echo '' !== $selected_marka ? 'true' : 'false'; ?>">
          <span class="filter-title"><?php echo esc_html( $labels['marka'] ); ?></span>
          <span class="filter-widget-toggle-icon" aria-hidden="true"></span>
        </button>
        <div class="filter-widget-body" data-filter-body<?php echo '' !== $selected_marka ? '' : ' hidden'; ?>>
        <?php if ( $marka_terms && ! is_wp_error( $marka_terms ) ) : ?>
          <div class="filter-list">
            <?php foreach ( $marka_terms as $term ) : ?>
              <div class="filter-item filter-item--check<?php echo $selected_marka === $term->slug ? ' is-selected' : ''; ?>">
                <label class="filter-checkbox-label">
                  <input type="checkbox" class="filter-checkbox-input js-filter-marka" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( $selected_marka === $term->slug ); ?>>
                  <?php echo esc_html( $term->name ); ?>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else : ?>
          <p class="filter-empty-note"><?php echo esc_html( $labels['marka_empty'] ); ?></p>
        <?php endif; ?>
        </div>
      </div>
        <?php
        $sidebar_blocks[] = array(
            'order' => $marka_order,
            'key'   => 'marka',
            'html'  => ob_get_clean(),
        );
      endif;

      if ( $cats_enabled && ! empty( $cats ) && ! is_wp_error( $cats ) ) :
        ob_start();
        ?>
        <div class="filter-widget filter-widget--categories filter-widget--mobile-accordion<?php echo $current_cat ? ' is-open' : ''; ?>" data-filter-widget>
          <button type="button" class="filter-widget-toggle" data-filter-toggle aria-expanded="<?php echo $current_cat ? 'true' : 'false'; ?>">
            <span class="filter-title"><?php echo esc_html( $filter_title ); ?></span>
            <span class="filter-widget-toggle-icon" aria-hidden="true"></span>
          </button>
          <div class="filter-widget-body" data-filter-body<?php echo $current_cat ? '' : ' hidden'; ?>>
          <div class="filter-list">
            <?php foreach ( $cats as $c ) : ?>
              <?php $is_current = $current_cat && (int) $current_cat->term_id === (int) $c->term_id; ?>
              <a href="<?php echo esc_url( get_term_link( $c ) ); ?>" class="filter-item filter-item-link<?php echo $is_current ? ' active is-current' : ''; ?>">
                <span class="filter-item-name"><?php echo esc_html( $c->name ); ?></span>
                <span class="filter-item-count"><?php echo esc_html( $c->count ); ?></span>
              </a>
            <?php endforeach; ?>
          </div>
          </div>
        </div>
        <?php
        $sidebar_blocks[] = array(
            'order' => $cats_order,
            'key'   => 'categories',
            'html'  => ob_get_clean(),
        );
      endif;

      if ( $price_enabled ) :
        ob_start();
        ?>
      <div class="filter-widget filter-widget--price filter-widget--mobile-accordion<?php echo ( '' !== $selected_min || '' !== $selected_max ) ? ' is-open' : ''; ?>" data-filter-widget>
        <button type="button" class="filter-widget-toggle" data-filter-toggle aria-expanded="<?php echo ( '' !== $selected_min || '' !== $selected_max ) ? 'true' : 'false'; ?>">
          <span class="filter-title"><?php echo esc_html( $labels['price'] ); ?></span>
          <span class="filter-widget-toggle-icon" aria-hidden="true"></span>
        </button>
        <div class="filter-widget-body" data-filter-body<?php echo ( '' !== $selected_min || '' !== $selected_max ) ? '' : ' hidden'; ?>>
        <div class="price-range-inputs">
          <input type="number" placeholder="<?php echo esc_attr( $labels['from'] ); ?>" id="price-min" value="<?php echo esc_attr( $selected_min ); ?>">
          <input type="number" placeholder="<?php echo esc_attr( $labels['to'] ); ?>" id="price-max" value="<?php echo esc_attr( $selected_max ); ?>">
        </div>
        <button class="filter-apply js-filter-price" type="button"><?php echo esc_html( $labels['apply'] ); ?></button>
        </div>
      </div>
        <?php
        $sidebar_blocks[] = array(
            'order' => $price_order,
            'key'   => 'price',
            'html'  => ob_get_clean(),
        );
      endif;

      if ( $stock_enabled ) :
        ob_start();
        ?>
      <div class="filter-widget filter-widget--stock filter-widget--mobile-accordion<?php echo $selected_stock ? ' is-open' : ''; ?>" data-filter-widget>
        <button type="button" class="filter-widget-toggle" data-filter-toggle aria-expanded="<?php echo $selected_stock ? 'true' : 'false'; ?>">
          <span class="filter-title"><?php echo esc_html( $labels['stock'] ); ?></span>
          <span class="filter-widget-toggle-icon" aria-hidden="true"></span>
        </button>
        <div class="filter-widget-body" data-filter-body<?php echo $selected_stock ? '' : ' hidden'; ?>>
        <div class="filter-check<?php echo $selected_stock ? ' is-active' : ''; ?>">
          <label>
            <input type="checkbox" class="js-filter-stock" <?php checked( $selected_stock ); ?>>
            <?php echo esc_html( $labels['in_stock'] ); ?>
          </label>
        </div>
        </div>
      </div>
        <?php
        $sidebar_blocks[] = array(
            'order' => $stock_order,
            'key'   => 'stock',
            'html'  => ob_get_clean(),
        );
      endif;

      if ( $recs ) :
        ob_start();
        ?>
      <div class="filter-widget filter-widget--mobile-accordion" data-filter-widget>
        <button type="button" class="filter-widget-toggle filter-widget-toggle--subtitle" data-filter-toggle aria-expanded="false">
          <span class="filter-widget-subtitle"><?php echo esc_html( $labels['you_may_like'] ); ?></span>
          <span class="filter-widget-toggle-icon" aria-hidden="true"></span>
        </button>
        <div class="filter-widget-body" data-filter-body hidden>
        <?php foreach ( $recs as $rec ) : ?>
          <?php $img = wp_get_attachment_image_url( $rec->get_image_id(), 'dv-product-sm' ); ?>
          <a href="<?php echo esc_url( $rec->get_permalink() ); ?>" class="filter-reco-link">
            <?php if ( $img ) : ?>
              <img src="<?php echo esc_url( $img ); ?>" alt="" class="filter-reco-thumb">
            <?php endif; ?>
            <div class="filter-reco-content">
              <div class="filter-reco-name"><?php echo esc_html( wp_trim_words( function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $rec ) : $rec->get_name(), 4, '' ) ); ?></div>
              <div class="filter-reco-price">
                <?php if ( $rec->get_price() ) : ?>
                  <?php echo esc_html( number_format( (float) $rec->get_price(), 0, '.', ' ' ) ); ?> ₽
                <?php else : ?>
                  <?php echo esc_html( $labels['price_on_request'] ); ?>
                <?php endif; ?>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
        </div>
      </div>
        <?php
        $sidebar_blocks[] = array(
            'order' => $recs_order,
            'key'   => 'recs',
            'html'  => ob_get_clean(),
        );
      endif;

      usort(
          $sidebar_blocks,
          static function ( $a, $b ) {
              if ( (int) $a['order'] === (int) $b['order'] ) {
                  return strcmp( (string) $a['key'], (string) $b['key'] );
              }

              return (int) $a['order'] <=> (int) $b['order'];
          }
      );

      foreach ( $sidebar_blocks as $sidebar_block ) {
          echo $sidebar_block['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
      }
      ?>
    </aside>

    <div class="catalog-main">
      <div class="catalog-toolbar">
        <div class="catalog-toolbar-main">
          <div class="catalog-results-panel">
            <?php if ( $search_term ) : ?>
              <div class="catalog-results-kicker"><?php echo esc_html( $labels['search_note'] ); ?></div>
              <div class="catalog-results-context"><?php echo esc_html( $search_term ); ?></div>
            <?php endif; ?>

            <div class="catalog-count"><?php echo esc_html( $labels['found'] ); ?> <strong><?php echo esc_html( $catalog_total ); ?></strong> <?php echo esc_html( $labels['products'] ); ?></div>
          </div>
          <?php if ( ! empty( $active_filters ) ) : ?>
            <div class="catalog-active-filters">
              <span class="catalog-active-filters-label"><?php echo esc_html( $labels['active_filters'] ); ?>: <?php echo esc_html( $active_count ); ?></span>
              <?php foreach ( $active_filters as $active_filter ) : ?>
                <a href="<?php echo esc_url( $active_filter['url'] ); ?>" class="catalog-filter-chip">
                  <span><?php echo esc_html( $active_filter['label'] ); ?></span>
                  <span class="catalog-filter-chip-remove">×</span>
                </a>
              <?php endforeach; ?>
              <a href="<?php echo esc_url( $reset_url ); ?>" class="catalog-reset-filters"><?php echo esc_html( $labels['reset'] ); ?></a>
            </div>
          <?php endif; ?>
        </div>

        <div class="catalog-sort">
          <span class="catalog-sort-label"><?php echo esc_html( $labels['sort'] ); ?></span>
          <?php woocommerce_catalog_ordering(); ?>
        </div>
      </div>

      <?php if ( woocommerce_product_loop() ) : ?>
        <div class="woocommerce">
          <ul class="products" style="--dv-catalog-columns: <?php echo esc_attr( $catalog_columns ); ?>;">
            <?php while ( have_posts() ) : the_post(); ?>
              <?php wc_get_template_part( 'content', 'product' ); ?>
            <?php endwhile; ?>
          </ul>
        </div>

        <div class="pagination">
          <?php
          echo paginate_links(
              [
                  'total'     => wc_get_loop_prop( 'total_pages' ),
                  'current'   => max( 1, get_query_var( 'paged' ) ),
                  'prev_text' => '‹',
                  'next_text' => '›',
                  'type'      => 'list',
              ]
          );
          ?>
        </div>
      <?php else : ?>
        <div class="catalog-empty-state">
          <svg width="64" height="64" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1" class="catalog-empty-icon">
            <rect x="4" y="4" width="40" height="40" rx="6"></rect>
            <path d="M16 24h16M24 16v16"></path>
          </svg>
          <p class="catalog-empty-title"><?php echo esc_html( $labels['not_found'] ); ?></p>
          <p class="catalog-empty-text"><?php echo esc_html( $labels['empty_text'] ); ?> <a href="<?php echo esc_url( $reset_url ); ?>" class="catalog-empty-link"><?php echo esc_html( $labels['reset_search'] ); ?></a></p>
        </div>
      <?php endif; ?>

      <?php if ( $current_cat && ( $seo_text || ! empty( $seo_faq ) ) ) : ?>
        <section class="catalog-seo-content">
          <?php if ( $seo_text ) : ?>
            <div class="catalog-seo-text"><?php echo wp_kses_post( wpautop( $seo_text ) ); ?></div>
          <?php endif; ?>

          <?php if ( ! empty( $seo_faq ) ) : ?>
            <div class="catalog-seo-faq">
              <h2 class="catalog-seo-faq-title">Вопросы по разделу</h2>
              <?php foreach ( $seo_faq as $faq_item ) : ?>
                <details class="catalog-seo-faq-item">
                  <summary><?php echo esc_html( $faq_item['question'] ); ?></summary>
                  <div><?php echo wp_kses_post( wpautop( $faq_item['answer'] ) ); ?></div>
                </details>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
