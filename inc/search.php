<?php
defined( 'ABSPATH' ) || exit;

function dv_search_labels() {
    static $labels_cache = null;

    if ( is_array( $labels_cache ) ) {
        return $labels_cache;
    }

    $labels_cache = array(
        'currency_symbol' => html_entity_decode( '&#8381;', ENT_QUOTES, 'UTF-8' ),
        'price_request'   => html_entity_decode( '&#1062;&#1077;&#1085;&#1072; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091;', ENT_QUOTES, 'UTF-8' ),
    );

    return $labels_cache;
}

function dv_search_variants( $query ) {
    $query = mb_strtolower( trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $query ) ) ), 'UTF-8' );

    if ( '' === $query ) {
        return array();
    }

    static $variants_cache = array();

    if ( array_key_exists( $query, $variants_cache ) ) {
        return $variants_cache[ $query ];
    }

    $variants = array( $query );
    $lat      = dv_cyr_to_lat( $query );
    $cyr      = dv_lat_to_cyr( $query );

    if ( $lat && $lat !== $query ) {
        $variants[] = $lat;
    }

    if ( $cyr && $cyr !== $query ) {
        $variants[] = $cyr;
    }

    foreach ( dv_brand_pairs() as $from => $to ) {
        if ( false !== mb_strpos( $query, $from ) ) {
            $variants[] = str_replace( $from, $to, $query );
        }
    }

    $variants_cache[ $query ] = array_values( array_unique( array_filter( $variants ) ) );

    return $variants_cache[ $query ];
}

function dv_cyr_to_lat( $text ) {
    static $map = null;

    if ( null === $map ) {
        $map = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        );
    }

    return strtr( $text, $map );
}

function dv_lat_to_cyr( $text ) {
    static $map = null;

    if ( null === $map ) {
        $map = array(
            'sch' => 'щ', 'sh' => 'ш', 'ch' => 'ч', 'zh' => 'ж', 'ts' => 'ц', 'yu' => 'ю', 'ya' => 'я', 'yo' => 'ё', 'kh' => 'х',
            'a' => 'а', 'b' => 'б', 'v' => 'в', 'g' => 'г', 'd' => 'д', 'e' => 'е', 'z' => 'з', 'i' => 'и', 'y' => 'й', 'k' => 'к',
            'l' => 'л', 'm' => 'м', 'n' => 'н', 'o' => 'о', 'p' => 'п', 'r' => 'р', 's' => 'с', 't' => 'т', 'u' => 'у', 'f' => 'ф',
            'h' => 'х', 'w' => 'в', 'q' => 'к', 'x' => 'кс',
        );
    }

    $chunk_sizes = array( 3, 2, 1 );
    $result = '';
    $length = mb_strlen( $text );
    $index  = 0;

    while ( $index < $length ) {
        $matched = false;
        foreach ( $chunk_sizes as $size ) {
            if ( $index + $size > $length ) {
                continue;
            }
            $chunk = mb_substr( $text, $index, $size );
            if ( isset( $map[ $chunk ] ) ) {
                $result .= $map[ $chunk ];
                $index  += $size;
                $matched = true;
                break;
            }
        }
        if ( ! $matched ) {
            $result .= mb_substr( $text, $index, 1 );
            ++$index;
        }
    }

    return $result;
}

function dv_brand_pairs() {
    static $pairs = null;

    if ( is_array( $pairs ) ) {
        return $pairs;
    }

    $pairs = array(
        'ваз' => 'vaz', 'vaz' => 'ваз', 'лада' => 'lada', 'lada' => 'лада', 'экрис' => 'ekris', 'ekris' => 'экрис',
        'стилл' => 'still', 'still' => 'стилл', 'тольятти' => 'tolyatti', 'tolyatti' => 'тольятти',
        'кия' => 'kia', 'kia' => 'кия', 'рено' => 'renault', 'renault' => 'рено', 'ниссан' => 'nissan', 'nissan' => 'ниссан',
        'тойота' => 'toyota', 'toyota' => 'тойота', 'хендай' => 'hyundai', 'hyundai' => 'хендай', 'форд' => 'ford', 'ford' => 'форд',
        'бмв' => 'bmw', 'bmw' => 'бмв', 'мерседес' => 'mercedes', 'mercedes' => 'мерседес',
        'фольксваген' => 'volkswagen', 'volkswagen' => 'фольксваген', 'шкода' => 'skoda', 'skoda' => 'шкода',
        'опель' => 'opel', 'opel' => 'опель', 'мазда' => 'mazda', 'mazda' => 'мазда', 'хонда' => 'honda', 'honda' => 'хонда',
        'ауди' => 'audi', 'audi' => 'ауди', 'субару' => 'subaru', 'subaru' => 'субару', 'митсубиси' => 'mitsubishi', 'mitsubishi' => 'митсубиси',
    );

    return $pairs;
}

function dv_lada_model_alias_groups() {
    static $groups = null;

    if ( is_array( $groups ) ) {
        return $groups;
    }

    $numeric_models = array(
        '1111',
        '2101',
        '2102',
        '2103',
        '2104',
        '2105',
        '2106',
        '2107',
        '2108',
        '2109',
        '21099',
        '2110',
        '2111',
        '2112',
        '2113',
        '2114',
        '2115',
        '2120',
        '2121',
        '2123',
        '2131',
    );

    $groups = array();

    foreach ( $numeric_models as $model ) {
        $groups[] = array(
            $model,
            'ваз ' . $model,
            'vaz ' . $model,
            'lada ' . $model,
            'лада ' . $model,
        );
    }

    $groups[] = array( 'ока', 'oka', '1111', 'ваз 1111', 'семейство ока' );
    $groups[] = array( 'классика', 'classic', 'семейство классика', '2101', '2102', '2103', '2104', '2105', '2106', '2107' );
    $groups[] = array( 'самара', 'samara', '2108', '2109', '21099', 'семейство 2108-2115', '2108-21099' );
    $groups[] = array( 'самара 2', 'samara 2', 'samara ii', '2113', '2114', '2115', '2113-2115', 'семейство 2113-2115' );
    $groups[] = array( 'нива', 'niva', '2121', '21213', '21214', '2131', 'семейство 2121-2131' );
    $groups[] = array( 'шевроле нива', 'chevrolet niva', 'chevy niva', '2123', 'ваз 2123', 'семейство 2123' );
    $groups[] = array( 'надежда', 'nadezhda', '2120', 'ваз 2120' );
    $groups[] = array( 'калина', 'kalina', '1117', '1118', '1119', '1117-1119', 'семейство калина' );
    $groups[] = array( 'гранта', 'granta', '2190', '21900', '21901', '2191', '2192', 'лада гранта' );
    $groups[] = array( 'приора', 'priora', '2170', '2171', '2172', '21720', '2170-2172', 'семейство приора' );
    $groups[] = array( 'ларгус', 'largus', 'lrs', 'ваз lrs', 'лада ларгус' );

    return $groups;
}

function dv_lada_model_terms_for_query( $query ) {
    $query = mb_strtolower( trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $query ) ) ), 'UTF-8' );

    if ( '' === $query ) {
        return array();
    }

    static $terms_cache = array();

    if ( array_key_exists( $query, $terms_cache ) ) {
        return $terms_cache[ $query ];
    }

    $terms = array();
    $is_samara2_query = (bool) preg_match( '/(?<![\p{L}\p{N}])(самара\s*2|samara\s*2|samara\s*ii)(?![\p{L}\p{N}])/u', $query );

    foreach ( dv_lada_model_alias_groups() as $aliases ) {
        foreach ( $aliases as $alias ) {
            $alias = mb_strtolower( trim( (string) $alias ), 'UTF-8' );
            if ( '' === $alias ) {
                continue;
            }

            if ( $is_samara2_query && in_array( $alias, array( 'самара', 'samara' ), true ) ) {
                continue;
            }

            if ( preg_match( '/(?<![\p{L}\p{N}])' . preg_quote( $alias, '/' ) . '(?![\p{L}\p{N}])/u', $query ) ) {
                $terms = array_merge( $terms, $aliases );
                break;
            }
        }
    }

    $terms_cache[ $query ] = array_values(
        array_unique(
            array_filter(
                array_map(
                    static function ( $term ) {
                        return mb_strtolower( trim( (string) $term ), 'UTF-8' );
                    },
                    $terms
                )
            )
        )
    );

    return $terms_cache[ $query ];
}

function dv_search_extract_terms( $query ) {
    $terms       = array();
    $brand_pairs = dv_brand_pairs();

    foreach ( dv_search_variants( $query ) as $variant ) {
        $terms[] = $variant;

        $normalized = preg_replace( '/[^\p{L}\p{N}]+/u', ' ', $variant );
        if ( $normalized && $normalized !== $variant ) {
            $terms[] = trim( preg_replace( '/\s+/u', ' ', $normalized ) );
        }

        foreach ( preg_split( '/[^\p{L}\p{N}]+/u', $variant, -1, PREG_SPLIT_NO_EMPTY ) as $word ) {
            if ( mb_strlen( $word ) >= 2 ) {
                $terms[] = $word;

                $word_lat = dv_cyr_to_lat( $word );
                $word_cyr = dv_lat_to_cyr( $word );

                if ( $word_lat && $word_lat !== $word ) {
                    $terms[] = $word_lat;
                }

                if ( $word_cyr && $word_cyr !== $word ) {
                    $terms[] = $word_cyr;
                }

                if ( isset( $brand_pairs[ $word ] ) && $brand_pairs[ $word ] !== $word ) {
                    $terms[] = $brand_pairs[ $word ];
                }
            }
        }
    }

    foreach ( dv_lada_model_terms_for_query( $query ) as $model_term ) {
        $terms[] = $model_term;

        $model_lat = dv_cyr_to_lat( $model_term );
        $model_cyr = dv_lat_to_cyr( $model_term );

        if ( $model_lat && $model_lat !== $model_term ) {
            $terms[] = $model_lat;
        }

        if ( $model_cyr && $model_cyr !== $model_term ) {
            $terms[] = $model_cyr;
        }
    }

    return array_values( array_unique( array_filter( $terms ) ) );
}

function dv_get_marka_taxonomy() {
    static $resolved_taxonomy = null;

    if ( null !== $resolved_taxonomy ) {
        return $resolved_taxonomy;
    }

    $candidates = array(
        'car_brand',
        'pa_car_brand',
        'pa_marka-tc',
        'pa_marka_tc',
        'pa_marka-ts',
        'pa_marka_ts',
        'pa_marka-t-s',
        'pa_marka_t_s',
        'pa_marka',
        'pa_brand',
        'pa_marka_tc_avto',
    );

    foreach ( $candidates as $taxonomy ) {
        if ( taxonomy_exists( $taxonomy ) ) {
            $resolved_taxonomy = $taxonomy;

            return $resolved_taxonomy;
        }
    }

    if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
        foreach ( wc_get_attribute_taxonomies() as $attribute ) {
            $name  = mb_strtolower( (string) ( $attribute->attribute_name ?? '' ), 'UTF-8' );
            $label = mb_strtolower( (string) ( $attribute->attribute_label ?? '' ), 'UTF-8' );

            if (
                false !== strpos( $name, 'car_brand' ) ||
                false !== strpos( $name, 'marka' ) ||
                false !== strpos( $name, 'brand' ) ||
                false !== strpos( $label, 'марка' ) ||
                false !== strpos( $label, 'бренд' )
            ) {
                $taxonomy = wc_attribute_taxonomy_name( $attribute->attribute_name );
                if ( taxonomy_exists( $taxonomy ) ) {
                    $resolved_taxonomy = $taxonomy;

                    return $resolved_taxonomy;
                }
            }
        }
    }

    $resolved_taxonomy = '';

    return $resolved_taxonomy;
}

function dv_register_query_vars( $vars ) {
    $vars[] = 'dv_search_total';
    $vars[] = 'dv_search_ids';
    return $vars;
}
add_filter( 'query_vars', 'dv_register_query_vars' );

function dv_get_request_filter_args() {
    $min_price = sanitize_text_field( wp_unslash( $_GET['min_price'] ?? '' ) );
    $max_price = sanitize_text_field( wp_unslash( $_GET['max_price'] ?? '' ) );

    return array(
        'marka'     => sanitize_title( wp_unslash( $_GET['marka'] ?? '' ) ),
        'stock'     => isset( $_GET['stock'] ) && 'instock' === $_GET['stock'] ? 'instock' : '',
        'min_price' => is_numeric( $min_price ) ? (float) $min_price : '',
        'max_price' => is_numeric( $max_price ) ? (float) $max_price : '',
    );
}

function dv_search_explicit_query_tokens( $query ) {
    $cache_key = mb_strtolower( trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $query ) ) ), 'UTF-8' );

    if ( '' === $cache_key ) {
        return array();
    }

    static $tokens_cache = array();

    if ( array_key_exists( $cache_key, $tokens_cache ) ) {
        return $tokens_cache[ $cache_key ];
    }

    $tokens = array();

    foreach ( dv_search_variants( $cache_key ) as $variant ) {
        foreach ( preg_split( '/[^\p{L}\p{N}]+/u', $variant, -1, PREG_SPLIT_NO_EMPTY ) as $token ) {
            $token = mb_strtolower( trim( (string) $token ), 'UTF-8' );

            if ( mb_strlen( $token, 'UTF-8' ) >= 2 ) {
                $tokens[] = $token;
            }
        }
    }

    $tokens_cache[ $cache_key ] = array_values( array_unique( array_filter( $tokens ) ) );

    return $tokens_cache[ $cache_key ];
}

function dv_search_required_query_tokens( $query ) {
    $query = mb_strtolower( trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $query ) ) ), 'UTF-8' );

    if ( '' === $query ) {
        return array();
    }

    static $tokens_cache = array();

    if ( array_key_exists( $query, $tokens_cache ) ) {
        return $tokens_cache[ $query ];
    }

    $tokens = array();

    foreach ( preg_split( '/[^\p{L}\p{N}]+/u', $query, -1, PREG_SPLIT_NO_EMPTY ) as $token ) {
        $token = mb_strtolower( trim( (string) $token ), 'UTF-8' );

        if ( mb_strlen( $token, 'UTF-8' ) >= 2 ) {
            $tokens[] = $token;
        }
    }

    $tokens_cache[ $query ] = array_values( array_unique( array_filter( $tokens ) ) );

    return $tokens_cache[ $query ];
}

function dv_search_title_priority_terms( $query ) {
    $cache_key = mb_strtolower( trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $query ) ) ), 'UTF-8' );

    if ( '' === $cache_key ) {
        return array(
            'text'   => array(),
            'number' => array(),
        );
    }

    static $terms_cache = array();

    if ( array_key_exists( $cache_key, $terms_cache ) ) {
        return $terms_cache[ $cache_key ];
    }

    $text_terms   = array();
    $number_terms = array();

    foreach ( dv_search_explicit_query_tokens( $cache_key ) as $token ) {
        if ( preg_match( '/\p{L}/u', $token ) ) {
            $text_terms[] = $token;
        } elseif ( preg_match( '/^\d{3,}$/u', $token ) ) {
            $number_terms[] = $token;
        }
    }

    $terms_cache[ $cache_key ] = array(
        'text'   => array_values( array_unique( $text_terms ) ),
        'number' => array_values( array_unique( $number_terms ) ),
    );

    return $terms_cache[ $cache_key ];
}

function dv_search_numeric_boundary_pattern( $number ) {
    return '(^|[^[:digit:]])' . preg_replace( '/\D+/', '', (string) $number ) . '([^[:digit:]]|$)';
}

function dv_search_live_terms( $query ) {
    $terms = dv_search_explicit_query_tokens( $query );

    return array_slice( array_values( array_unique( array_filter( $terms ) ) ), 0, 8 );
}

function dv_search_normalize_index_text( $text ) {
    $text = mb_strtolower( wp_strip_all_tags( (string) $text ), 'UTF-8' );
    $text = str_replace( 'ё', 'е', $text );
    $text = preg_replace( '/[^\p{L}\p{N}]+/u', ' ', $text );

    return trim( preg_replace( '/\s+/u', ' ', (string) $text ) );
}

function dv_search_index_cache_key() {
    return 'dv_live_product_search_index_v2';
}

function dv_search_index_version() {
    $version = (int) get_option( 'dv_live_product_search_index_version', 1 );

    return $version > 0 ? $version : 1;
}

function dv_live_search_results_cache_key( $query, $limit ) {
    return 'dv_live_product_search_results_v2_' . dv_search_index_version() . '_' . md5( dv_search_normalize_index_text( $query ) . '|' . (int) $limit );
}

function dv_flush_live_search_index() {
    delete_transient( dv_search_index_cache_key() );
    update_option( 'dv_live_product_search_index_version', time(), false );
    dv_schedule_live_search_index_rebuild();
}

function dv_schedule_live_search_index_rebuild() {
    if ( ! function_exists( 'wp_next_scheduled' ) || ! function_exists( 'wp_schedule_single_event' ) ) {
        return;
    }

    if ( ! wp_next_scheduled( 'dv_rebuild_live_search_index' ) ) {
        wp_schedule_single_event( time() + MINUTE_IN_SECONDS, 'dv_rebuild_live_search_index' );
    }
}

function dv_rebuild_live_search_index() {
    delete_transient( dv_search_index_cache_key() );
    dv_get_live_search_index();
}

add_action( 'dv_rebuild_live_search_index', 'dv_rebuild_live_search_index' );
add_action( 'after_switch_theme', 'dv_schedule_live_search_index_rebuild' );

function dv_handle_live_search_index_rebuild() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Insufficient permissions.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_live_search_index_rebuild' );
    dv_rebuild_live_search_index();

    $redirect = add_query_arg(
        'search-index',
        'rebuilt',
        admin_url( 'admin.php?page=dv-theme-options' )
    );

    wp_safe_redirect( $redirect . '#dv-options-search' );
    exit;
}
add_action( 'admin_post_dv_live_search_index_rebuild', 'dv_handle_live_search_index_rebuild' );

function dv_search_index_token_map_keys( $text ) {
    $keys = array();
    $text = dv_search_normalize_index_text( $text );

    if ( '' === $text ) {
        return array();
    }

    foreach ( preg_split( '/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY ) as $token ) {
        $length = mb_strlen( $token, 'UTF-8' );

        if ( $length < 2 ) {
            continue;
        }

        $prefix_limit = min( $length, 16 );

        for ( $size = 2; $size <= $prefix_limit; $size++ ) {
            $keys[] = 'p:' . mb_substr( $token, 0, $size, 'UTF-8' );
        }

        if ( preg_match( '/^\d+$/', $token ) ) {
            $keys[] = 'n:' . $token;
        }
    }

    return array_values( array_unique( array_filter( $keys ) ) );
}

function dv_search_query_candidate_key( $token ) {
    $token = dv_search_normalize_index_text( $token );

    if ( '' === $token ) {
        return '';
    }

    if ( preg_match( '/^\d{4,}$/', $token ) ) {
        return 'n:' . $token;
    }

    return 'p:' . $token;
}

function dv_flush_live_search_index_for_post( $post_id ) {
    if ( $post_id && 'product' !== get_post_type( $post_id ) ) {
        return;
    }

    dv_flush_live_search_index();
}

function dv_flush_live_search_index_for_meta( $meta_id, $object_id, $meta_key = '' ) {
    $watched_keys = array(
        '_sku',
        '_price',
        '_regular_price',
        '_sale_price',
        '_stock',
        '_stock_status',
        '_thumbnail_id',
        '_compatibility',
    );

    if ( ! in_array( (string) $meta_key, $watched_keys, true ) || 'product' !== get_post_type( $object_id ) ) {
        return;
    }

    dv_flush_live_search_index();
}

add_action( 'save_post_product', 'dv_flush_live_search_index_for_post' );
add_action( 'before_delete_post', 'dv_flush_live_search_index_for_post' );
add_action( 'deleted_post', 'dv_flush_live_search_index_for_post' );
add_action( 'trashed_post', 'dv_flush_live_search_index_for_post' );
add_action( 'untrashed_post', 'dv_flush_live_search_index_for_post' );
add_action( 'added_post_meta', 'dv_flush_live_search_index_for_meta', 10, 3 );
add_action( 'updated_post_meta', 'dv_flush_live_search_index_for_meta', 10, 3 );
add_action( 'deleted_post_meta', 'dv_flush_live_search_index_for_meta', 10, 3 );

function dv_get_live_search_index() {
    global $wpdb;

    $cache_key = dv_search_index_cache_key();
    $cached    = get_transient( $cache_key );

    if ( is_array( $cached ) ) {
        return $cached;
    }

    $rows = $wpdb->get_results(
        "
        SELECT
            p.ID,
            p.post_title,
            p.post_name,
            p.menu_order,
            sku.meta_value AS sku,
            price.meta_value AS price,
            stock_status.meta_value AS stock_status,
            stock_qty.meta_value AS stock_quantity,
            thumb.meta_value AS thumbnail_id,
            compat.meta_value AS compatibility
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->postmeta} sku ON sku.post_id = p.ID AND sku.meta_key = '_sku'
        LEFT JOIN {$wpdb->postmeta} price ON price.post_id = p.ID AND price.meta_key = '_price'
        LEFT JOIN {$wpdb->postmeta} stock_status ON stock_status.post_id = p.ID AND stock_status.meta_key = '_stock_status'
        LEFT JOIN {$wpdb->postmeta} stock_qty ON stock_qty.post_id = p.ID AND stock_qty.meta_key = '_stock'
        LEFT JOIN {$wpdb->postmeta} thumb ON thumb.post_id = p.ID AND thumb.meta_key = '_thumbnail_id'
        LEFT JOIN {$wpdb->postmeta} compat ON compat.post_id = p.ID AND compat.meta_key = '_compatibility'
        WHERE p.post_type = 'product'
          AND p.post_status = 'publish'
          AND NOT EXISTS (
              SELECT 1
              FROM {$wpdb->term_relationships} tr_visibility
              INNER JOIN {$wpdb->term_taxonomy} tt_visibility ON tt_visibility.term_taxonomy_id = tr_visibility.term_taxonomy_id
              INNER JOIN {$wpdb->terms} t_visibility ON t_visibility.term_id = tt_visibility.term_id
              WHERE tr_visibility.object_id = p.ID
                AND tt_visibility.taxonomy = 'product_visibility'
                AND t_visibility.slug IN ('exclude-from-search','exclude-from-catalog')
          )
        ORDER BY p.menu_order ASC, p.post_title ASC
        ",
        ARRAY_A
    );

    if ( ! is_array( $rows ) ) {
        return array();
    }

    $index     = array(
        'rows'      => array(),
        'token_map' => array(),
    );
    $labels    = dv_search_labels();

    foreach ( $rows as $row ) {
        $product_id     = (int) ( $row['ID'] ?? 0 );
        $title         = (string) ( $row['post_title'] ?? '' );
        $slug          = (string) ( $row['post_name'] ?? '' );
        $sku           = (string) ( $row['sku'] ?? '' );
        $compatibility = (string) ( $row['compatibility'] ?? '' );
        $search_text   = dv_search_normalize_index_text( $title . ' ' . $slug . ' ' . $sku . ' ' . $compatibility );
        $price         = (string) ( $row['price'] ?? '' );
        $thumbnail_id  = (int) ( $row['thumbnail_id'] ?? 0 );

        if ( ! $product_id || '' === $search_text ) {
            continue;
        }

        $indexed_row = array(
            'id'             => $product_id,
            'title'          => $title,
            'title_text'     => dv_search_normalize_index_text( $title ),
            'slug_text'      => dv_search_normalize_index_text( $slug ),
            'sku_text'       => dv_search_normalize_index_text( $sku ),
            'compat_text'    => dv_search_normalize_index_text( $compatibility ),
            'search_text'    => $search_text,
            'sku'            => $sku,
            'price'          => $price,
            'price_label'    => '' !== $price ? number_format( (float) $price, 0, '.', ' ' ) . ' ' . $labels['currency_symbol'] : $labels['price_request'],
            'stock_status'   => (string) ( $row['stock_status'] ?? '' ),
            'stock_quantity' => (string) ( $row['stock_quantity'] ?? '' ),
            'in_stock'       => 'instock' === (string) ( $row['stock_status'] ?? '' ),
            'stock_q'        => '' !== (string) ( $row['stock_quantity'] ?? '' ) ? (int) $row['stock_quantity'] : '',
            'thumbnail_id'   => $thumbnail_id,
            'menu_order'     => (int) ( $row['menu_order'] ?? 0 ),
        );

        $index['rows'][ $product_id ] = $indexed_row;

        foreach ( dv_search_index_token_map_keys( $search_text ) as $token_key ) {
            if ( ! isset( $index['token_map'][ $token_key ] ) ) {
                $index['token_map'][ $token_key ] = array();
            }

            $index['token_map'][ $token_key ][] = $product_id;
        }
    }

    foreach ( $index['token_map'] as $token_key => $product_ids ) {
        $index['token_map'][ $token_key ] = array_values( array_unique( array_map( 'absint', $product_ids ) ) );
    }

    set_transient( $cache_key, $index, 12 * HOUR_IN_SECONDS );

    return $index;
}

function dv_search_index_contains_number( $text, $number ) {
    $number = preg_replace( '/\D+/', '', (string) $number );

    if ( '' === $number ) {
        return false;
    }

    return (bool) preg_match( '/(^|[^\d])' . preg_quote( $number, '/' ) . '([^\d]|$)/u', (string) $text );
}

function dv_live_search_score_row( $row, $full_query, $required_tokens, $priority_terms ) {
    $score       = 0;
    $search_text = (string) ( $row['search_text'] ?? '' );
    $title_text  = (string) ( $row['title_text'] ?? '' );
    $slug_text   = (string) ( $row['slug_text'] ?? '' );
    $sku_text    = (string) ( $row['sku_text'] ?? '' );
    $compat_text = (string) ( $row['compat_text'] ?? '' );

    foreach ( $required_tokens as $token ) {
        if ( '' === $token || false === strpos( $search_text, $token ) ) {
            return null;
        }
    }

    if ( '' !== $full_query ) {
        if ( $title_text === $full_query ) {
            $score += 1000;
        } elseif ( 0 === strpos( $title_text, $full_query ) ) {
            $score += 820;
        } elseif ( false !== strpos( $title_text, $full_query ) ) {
            $score += 620;
        }

        if ( $sku_text === $full_query ) {
            $score += 1100;
        } elseif ( 0 === strpos( $sku_text, $full_query ) ) {
            $score += 900;
        }
    }

    $all_title_text_terms = true;
    foreach ( $priority_terms['text'] as $text_term ) {
        if ( '' === $text_term || false === strpos( $title_text, $text_term ) ) {
            $all_title_text_terms = false;
        } else {
            $score += 260;
        }

        if ( false !== strpos( $sku_text, $text_term ) ) {
            $score += 80;
        }

        if ( false !== strpos( $compat_text, $text_term ) ) {
            $score += 35;
        }
    }

    $all_title_number_terms = true;
    foreach ( $priority_terms['number'] as $number_term ) {
        if ( ! dv_search_index_contains_number( $title_text, $number_term ) ) {
            $all_title_number_terms = false;
        } else {
            $score += 160;
        }

        if ( false !== strpos( $sku_text, (string) $number_term ) ) {
            $score += 180;
        }

        if ( false !== strpos( $compat_text, (string) $number_term ) ) {
            $score += 45;
        }
    }

    if ( ! empty( $priority_terms['text'] ) && $all_title_text_terms ) {
        $score += 520;
    }

    if ( ! empty( $priority_terms['number'] ) && $all_title_number_terms ) {
        $score += 260;
    }

    if ( ! empty( $priority_terms['text'] ) && ! empty( $priority_terms['number'] ) && $all_title_text_terms && $all_title_number_terms ) {
        $score += 900;
    }

    foreach ( $required_tokens as $token ) {
        if ( false !== strpos( $title_text, $token ) ) {
            $score += 120;
        } elseif ( false !== strpos( $slug_text, $token ) ) {
            $score += 80;
        } elseif ( false !== strpos( $sku_text, $token ) ) {
            $score += 70;
        } elseif ( false !== strpos( $compat_text, $token ) ) {
            $score += 25;
        }
    }

    return $score;
}

function dv_get_live_search_candidate_rows( $index, $required_tokens ) {
    if ( empty( $index['rows'] ) || empty( $index['token_map'] ) || ! is_array( $index['rows'] ) || ! is_array( $index['token_map'] ) ) {
        return array();
    }

    $candidate_ids = null;

    foreach ( $required_tokens as $token ) {
        $candidate_key = dv_search_query_candidate_key( $token );

        if ( '' === $candidate_key || empty( $index['token_map'][ $candidate_key ] ) ) {
            return array();
        }

        $ids = array_map( 'absint', (array) $index['token_map'][ $candidate_key ] );

        if ( null === $candidate_ids ) {
            $candidate_ids = $ids;
        } else {
            $candidate_ids = array_values( array_intersect( $candidate_ids, $ids ) );
        }

        if ( empty( $candidate_ids ) ) {
            return array();
        }
    }

    if ( null === $candidate_ids ) {
        return array_values( $index['rows'] );
    }

    $rows = array();

    foreach ( $candidate_ids as $product_id ) {
        if ( isset( $index['rows'][ $product_id ] ) ) {
            $rows[] = $index['rows'][ $product_id ];
        }
    }

    return $rows;
}

function dv_get_search_index_matches( $raw_query ) {
    $cache_key = 'dv_product_search_index_matches_v1_' . dv_search_index_version() . '_' . md5( dv_search_normalize_index_text( $raw_query ) );
    $cached    = get_transient( $cache_key );

    if ( is_array( $cached ) ) {
        return $cached;
    }

    $required_tokens = array_values(
        array_filter(
            array_map( 'dv_search_normalize_index_text', dv_search_required_query_tokens( $raw_query ) )
        )
    );

    if ( empty( $required_tokens ) ) {
        return array();
    }

    $priority_terms = dv_search_title_priority_terms( $raw_query );
    $priority_terms = array(
        'text'   => array_values( array_filter( array_map( 'dv_search_normalize_index_text', $priority_terms['text'] ) ) ),
        'number' => $priority_terms['number'],
    );
    $full_query     = dv_search_normalize_index_text( $raw_query );
    $matches        = array();
    $index          = dv_get_live_search_index();
    $candidate_rows = dv_get_live_search_candidate_rows( $index, $required_tokens );

    if ( empty( $candidate_rows ) && ! empty( $index['rows'] ) && is_array( $index['rows'] ) ) {
        $candidate_rows = array_values( $index['rows'] );
    }

    foreach ( $candidate_rows as $row ) {
        $score = dv_live_search_score_row( $row, $full_query, $required_tokens, $priority_terms );

        if ( null === $score ) {
            continue;
        }

        $row['score'] = $score;
        $matches[]    = $row;
    }

    usort(
        $matches,
        static function ( $a, $b ) {
            if ( (int) $a['score'] !== (int) $b['score'] ) {
                return (int) $b['score'] <=> (int) $a['score'];
            }

            if ( (int) $a['menu_order'] !== (int) $b['menu_order'] ) {
                return (int) $a['menu_order'] <=> (int) $b['menu_order'];
            }

            return strnatcasecmp( (string) $a['title'], (string) $b['title'] );
        }
    );

    set_transient( $cache_key, $matches, 10 * MINUTE_IN_SECONDS );

    return $matches;
}

function dv_get_live_search_results( $raw_query, $limit = 8 ) {
    $limit     = max( 1, min( 20, absint( $limit ) ) );
    $cache_key = dv_live_search_results_cache_key( $raw_query, $limit );
    $cached          = get_transient( $cache_key );

    if ( is_array( $cached ) ) {
        return $cached;
    }

    $matches = dv_get_search_index_matches( $raw_query );

    $results = array(
        'items' => array_slice( $matches, 0, $limit ),
        'total' => count( $matches ),
    );

    set_transient( $cache_key, $results, 10 * MINUTE_IN_SECONDS );

    return $results;
}

function dv_search_filters_are_empty( $filter_args ) {
    $filter_args = wp_parse_args( $filter_args, dv_get_request_filter_args() );

    return '' === (string) ( $filter_args['marka'] ?? '' )
        && '' === (string) ( $filter_args['stock'] ?? '' )
        && '' === (string) ( $filter_args['min_price'] ?? '' )
        && '' === (string) ( $filter_args['max_price'] ?? '' );
}

function dv_get_product_search_ids_from_index( $raw_query, $limit = 0 ) {
    $matches = dv_get_search_index_matches( $raw_query );
    $ids     = array();

    foreach ( $matches as $row ) {
        if ( ! empty( $row['id'] ) ) {
            $ids[] = (int) $row['id'];
        }
    }

    $ids   = array_values( array_unique( array_filter( $ids ) ) );
    $total = count( $ids );

    if ( $limit > 0 ) {
        $ids = array_slice( $ids, 0, $limit );
    }

    return array(
        'ids'   => $ids,
        'total' => $total,
    );
}

function dv_get_product_search_ids( $raw_query, $limit = 0, $filter_args = array() ) {
    global $wpdb;

    $filter_args = wp_parse_args( $filter_args, dv_get_request_filter_args() );
    $fast_live   = $limit > 0 && ! empty( $filter_args['fast_live'] );
    if ( ! $fast_live && dv_search_filters_are_empty( $filter_args ) ) {
        $index_results = dv_get_product_search_ids_from_index( $raw_query, $limit );

        if ( ! empty( $index_results['ids'] ) ) {
            return $index_results;
        }
    }

    $terms       = $fast_live ? dv_search_live_terms( $raw_query ) : dv_search_extract_terms( $raw_query );

    if ( empty( $terms ) ) {
        return array( 'ids' => array(), 'total' => 0 );
    }

    $full_query    = mb_strtolower( trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $raw_query ) ) ), 'UTF-8' );
    $compact_query = preg_replace( '/[^\p{L}\p{N}]+/u', '', $full_query );
    $priority_terms = dv_search_title_priority_terms( $raw_query );

    $where_parts               = array();
    $required_where_parts      = array();
    $score_parts               = array();
    $title_text_conditions     = array();
    $title_number_conditions   = array();
    $title_all_query_priority  = '0';
    $title_text_priority       = '0';
    $title_number_priority     = '0';

    foreach ( $priority_terms['text'] as $text_term ) {
        $title_text_conditions[] = $wpdb->prepare( 'LOWER(p.post_title) LIKE %s', '%' . $wpdb->esc_like( $text_term ) . '%' );
        $score_parts[]           = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) LIKE %s THEN 240 ELSE 0 END", '%' . $wpdb->esc_like( $text_term ) . '%' );
    }

    foreach ( $priority_terms['number'] as $number_term ) {
        $title_number_conditions[] = $wpdb->prepare( 'LOWER(p.post_title) REGEXP %s', dv_search_numeric_boundary_pattern( $number_term ) );
        $score_parts[]             = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) REGEXP %s THEN 90 ELSE 0 END", dv_search_numeric_boundary_pattern( $number_term ) );
    }

    if ( ! empty( $title_text_conditions ) ) {
        $title_text_priority = 'CASE WHEN (' . implode( ' AND ', $title_text_conditions ) . ') THEN 1 ELSE 0 END';
        $score_parts[]       = 'CASE WHEN (' . implode( ' AND ', $title_text_conditions ) . ') THEN 420 ELSE 0 END';
    }

    if ( ! empty( $title_number_conditions ) ) {
        $title_number_priority = 'CASE WHEN (' . implode( ' AND ', $title_number_conditions ) . ') THEN 1 ELSE 0 END';
        $score_parts[]         = 'CASE WHEN (' . implode( ' AND ', $title_number_conditions ) . ') THEN 160 ELSE 0 END';
    }

    if ( ! empty( $title_text_conditions ) && ! empty( $title_number_conditions ) ) {
        $title_all_conditions     = array_merge( $title_text_conditions, $title_number_conditions );
        $title_all_query_priority = 'CASE WHEN (' . implode( ' AND ', $title_all_conditions ) . ') THEN 1 ELSE 0 END';
        $score_parts[]            = 'CASE WHEN (' . implode( ' AND ', $title_all_conditions ) . ') THEN 700 ELSE 0 END';
    }

    foreach ( dv_search_required_query_tokens( $raw_query ) as $required_term ) {
        $required_like = '%' . $wpdb->esc_like( $required_term ) . '%';

        if ( $fast_live ) {
            $required_where_parts[] = $wpdb->prepare(
                "(
                    LOWER(p.post_title) LIKE %s
                    OR LOWER(p.post_name) LIKE %s
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_required WHERE pm_sku_required.post_id = p.ID AND pm_sku_required.meta_key = '_sku' AND LOWER(pm_sku_required.meta_value) LIKE %s)
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat_required WHERE pm_compat_required.post_id = p.ID AND pm_compat_required.meta_key = '_compatibility' AND LOWER(pm_compat_required.meta_value) LIKE %s)
                )",
                $required_like,
                $required_like,
                $required_like,
                $required_like
            );
        } else {
            $required_where_parts[] = $wpdb->prepare(
                "(
                    LOWER(p.post_title) LIKE %s
                    OR LOWER(p.post_name) LIKE %s
                    OR LOWER(p.post_excerpt) LIKE %s
                    OR LOWER(p.post_content) LIKE %s
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_required WHERE pm_sku_required.post_id = p.ID AND pm_sku_required.meta_key = '_sku' AND LOWER(pm_sku_required.meta_value) LIKE %s)
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat_required WHERE pm_compat_required.post_id = p.ID AND pm_compat_required.meta_key = '_compatibility' AND LOWER(pm_compat_required.meta_value) LIKE %s)
                    OR EXISTS (
                        SELECT 1 FROM {$wpdb->term_relationships} tr_required
                        INNER JOIN {$wpdb->term_taxonomy} tt_required ON tt_required.term_taxonomy_id = tr_required.term_taxonomy_id
                        INNER JOIN {$wpdb->terms} t_required ON t_required.term_id = tt_required.term_id
                        WHERE tr_required.object_id = p.ID
                          AND tt_required.taxonomy IN ('product_cat','product_tag','car_brand','pa_car_brand','pa_marka-tc','pa_marka_tc','pa_marka','pa_brand','pa_model')
                          AND (LOWER(t_required.name) LIKE %s OR LOWER(t_required.slug) LIKE %s)
                    )
                )",
                $required_like,
                $required_like,
                $required_like,
                $required_like,
                $required_like,
                $required_like,
                $required_like,
                $required_like
            );
        }
    }

    if ( '' !== $full_query ) {
        $full_prefix = $wpdb->esc_like( $full_query ) . '%';
        $full_like   = '%' . $wpdb->esc_like( $full_query ) . '%';

        if ( $fast_live ) {
            $where_parts[] = $wpdb->prepare(
                "(
                    LOWER(p.post_title) LIKE %s
                    OR LOWER(p.post_name) LIKE %s
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_full WHERE pm_sku_full.post_id = p.ID AND pm_sku_full.meta_key = '_sku' AND LOWER(pm_sku_full.meta_value) LIKE %s)
                )",
                $full_like,
                $full_like,
                $full_like
            );
        } else {
            $where_parts[] = $wpdb->prepare(
                "(
                    LOWER(p.post_title) LIKE %s
                    OR LOWER(p.post_name) LIKE %s
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_full WHERE pm_sku_full.post_id = p.ID AND pm_sku_full.meta_key = '_sku' AND LOWER(pm_sku_full.meta_value) LIKE %s)
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat_full WHERE pm_compat_full.post_id = p.ID AND pm_compat_full.meta_key = '_compatibility' AND LOWER(pm_compat_full.meta_value) LIKE %s)
                )",
                $full_like,
                $full_like,
                $full_like,
                $full_like
            );
        }

        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) = %s THEN 320 ELSE 0 END", $full_query );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) LIKE %s THEN 260 ELSE 0 END", $full_prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) LIKE %s THEN 190 ELSE 0 END", $full_like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) = %s THEN 220 ELSE 0 END", $full_query );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) LIKE %s THEN 170 ELSE 0 END", $full_prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) LIKE %s THEN 120 ELSE 0 END", $full_like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_full WHERE pm_sku_full.post_id = p.ID AND pm_sku_full.meta_key = '_sku' AND LOWER(pm_sku_full.meta_value) = %s) THEN 340 ELSE 0 END", $full_query );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_full WHERE pm_sku_full.post_id = p.ID AND pm_sku_full.meta_key = '_sku' AND LOWER(pm_sku_full.meta_value) LIKE %s) THEN 280 ELSE 0 END", $full_prefix );
        if ( ! $fast_live ) {
            $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat_full WHERE pm_compat_full.post_id = p.ID AND pm_compat_full.meta_key = '_compatibility' AND LOWER(pm_compat_full.meta_value) LIKE %s) THEN 110 ELSE 0 END", $full_like );
        }
    }

    if ( $compact_query && $compact_query !== $full_query && mb_strlen( $compact_query, 'UTF-8' ) >= 3 ) {
        $compact_like = '%' . $wpdb->esc_like( $compact_query ) . '%';

        if ( $fast_live ) {
            $where_parts[] = $wpdb->prepare(
                "(
                    EXISTS (
                        SELECT 1 FROM {$wpdb->postmeta} pm_sku_compact
                        WHERE pm_sku_compact.post_id = p.ID
                          AND pm_sku_compact.meta_key = '_sku'
                          AND LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(pm_sku_compact.meta_value, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s
                    )
                    OR LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.post_title, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s
                )",
                $compact_like,
                $compact_like
            );
        } else {
            $where_parts[] = $wpdb->prepare(
                "(
                    EXISTS (
                        SELECT 1 FROM {$wpdb->postmeta} pm_sku_compact
                        WHERE pm_sku_compact.post_id = p.ID
                          AND pm_sku_compact.meta_key = '_sku'
                          AND LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(pm_sku_compact.meta_value, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s
                    )
                    OR EXISTS (
                        SELECT 1 FROM {$wpdb->postmeta} pm_compat_compact
                        WHERE pm_compat_compact.post_id = p.ID
                          AND pm_compat_compact.meta_key = '_compatibility'
                          AND LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(pm_compat_compact.meta_value, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s
                    )
                    OR LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.post_title, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s
                )",
                $compact_like,
                $compact_like,
                $compact_like
            );
        }

        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_compact WHERE pm_sku_compact.post_id = p.ID AND pm_sku_compact.meta_key = '_sku' AND LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(pm_sku_compact.meta_value, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s) THEN 300 ELSE 0 END", $compact_like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.post_title, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s THEN 180 ELSE 0 END", $compact_like );

        if ( ! $fast_live ) {
            $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat_compact WHERE pm_compat_compact.post_id = p.ID AND pm_compat_compact.meta_key = '_compatibility' AND LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(pm_compat_compact.meta_value, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s) THEN 140 ELSE 0 END", $compact_like );
        }
    }

    foreach ( $terms as $term ) {
        $exact  = mb_strtolower( $term, 'UTF-8' );
        $prefix = $wpdb->esc_like( $exact ) . '%';
        $like   = '%' . $wpdb->esc_like( $exact ) . '%';

        if ( $fast_live ) {
            $where_parts[] = $wpdb->prepare(
                "(
                    LOWER(p.post_title) LIKE %s
                    OR LOWER(p.post_name) LIKE %s
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku WHERE pm_sku.post_id = p.ID AND pm_sku.meta_key = '_sku' AND LOWER(pm_sku.meta_value) LIKE %s)
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat WHERE pm_compat.post_id = p.ID AND pm_compat.meta_key = '_compatibility' AND LOWER(pm_compat.meta_value) LIKE %s)
                )",
                $like,
                $like,
                $like,
                $like
            );
        } else {
            $where_parts[] = $wpdb->prepare(
                "(
                    LOWER(p.post_title) LIKE %s
                    OR LOWER(p.post_name) LIKE %s
                    OR LOWER(p.post_excerpt) LIKE %s
                    OR LOWER(p.post_content) LIKE %s
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku WHERE pm_sku.post_id = p.ID AND pm_sku.meta_key = '_sku' AND LOWER(pm_sku.meta_value) LIKE %s)
                    OR EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat WHERE pm_compat.post_id = p.ID AND pm_compat.meta_key = '_compatibility' AND LOWER(pm_compat.meta_value) LIKE %s)
                    OR EXISTS (
                        SELECT 1 FROM {$wpdb->term_relationships} tr
                        INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
                        INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id
                        WHERE tr.object_id = p.ID
                          AND tt.taxonomy IN ('product_cat','product_tag','car_brand','pa_car_brand','pa_marka-tc','pa_marka_tc','pa_marka','pa_brand','pa_model')
                          AND (LOWER(t.name) LIKE %s OR LOWER(t.slug) LIKE %s)
                    )
                )",
                $like,
                $like,
                $like,
                $like,
                $like,
                $like,
                $like,
                $like
            );
        }

        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku WHERE pm_sku.post_id = p.ID AND pm_sku.meta_key = '_sku' AND LOWER(pm_sku.meta_value) = %s) THEN 260 ELSE 0 END", $exact );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku WHERE pm_sku.post_id = p.ID AND pm_sku.meta_key = '_sku' AND LOWER(pm_sku.meta_value) LIKE %s) THEN 220 ELSE 0 END", $prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku WHERE pm_sku.post_id = p.ID AND pm_sku.meta_key = '_sku' AND LOWER(pm_sku.meta_value) LIKE %s) THEN 160 ELSE 0 END", $like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) = %s THEN 210 ELSE 0 END", $exact );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) LIKE %s THEN 170 ELSE 0 END", $prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) LIKE %s THEN 120 ELSE 0 END", $like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) = %s THEN 140 ELSE 0 END", $exact );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) LIKE %s THEN 110 ELSE 0 END", $prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) LIKE %s THEN 80 ELSE 0 END", $like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat WHERE pm_compat.post_id = p.ID AND pm_compat.meta_key = '_compatibility' AND LOWER(pm_compat.meta_value) LIKE %s) THEN 55 ELSE 0 END", $like );

        if ( ! $fast_live ) {
            $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_excerpt) LIKE %s THEN 40 ELSE 0 END", $like );
            $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_content) LIKE %s THEN 25 ELSE 0 END", $like );
            $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->term_relationships} tr INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id WHERE tr.object_id = p.ID AND tt.taxonomy IN ('product_cat','product_tag','car_brand','pa_car_brand','pa_marka-tc','pa_marka_tc','pa_marka','pa_brand','pa_model') AND (LOWER(t.name) LIKE %s OR LOWER(t.slug) LIKE %s)) THEN 70 ELSE 0 END", $like, $like );
        }
    }

    $filter_sql  = '';
    $marka_tax   = dv_get_marka_taxonomy();

    if ( $marka_tax && '' !== $filter_args['marka'] ) {
        $filter_sql .= $wpdb->prepare(
            " AND (
                EXISTS (
                    SELECT 1 FROM {$wpdb->term_relationships} tr_m
                    INNER JOIN {$wpdb->term_taxonomy} tt_m ON tt_m.term_taxonomy_id = tr_m.term_taxonomy_id
                    INNER JOIN {$wpdb->terms} t_m ON t_m.term_id = tt_m.term_id
                    WHERE tr_m.object_id = p.ID
                      AND tt_m.taxonomy = %s
                      AND t_m.slug = %s
                )
                OR EXISTS (
                    SELECT 1 FROM {$wpdb->postmeta} pm_attr
                    WHERE pm_attr.post_id = p.ID
                      AND pm_attr.meta_key = '_product_attributes'
                      AND pm_attr.meta_value LIKE %s
                      AND pm_attr.meta_value LIKE %s
                )
            )",
            $marka_tax,
            $filter_args['marka'],
            '%' . $wpdb->esc_like( $marka_tax ) . '%',
            '%' . $wpdb->esc_like( $filter_args['marka'] ) . '%'
        );
    }

    if ( 'instock' === $filter_args['stock'] ) {
        $filter_sql .= " AND EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_stock WHERE pm_stock.post_id = p.ID AND pm_stock.meta_key = '_stock_status' AND pm_stock.meta_value = 'instock')";
    }

    if ( '' !== $filter_args['min_price'] || '' !== $filter_args['max_price'] ) {
        $price_conditions = array();
        if ( '' !== $filter_args['min_price'] ) {
            $price_conditions[] = $wpdb->prepare( 'CAST(pm_price.meta_value AS DECIMAL(18,2)) >= %f', $filter_args['min_price'] );
        }
        if ( '' !== $filter_args['max_price'] ) {
            $price_conditions[] = $wpdb->prepare( 'CAST(pm_price.meta_value AS DECIMAL(18,2)) <= %f', $filter_args['max_price'] );
        }
        if ( ! empty( $price_conditions ) ) {
            $filter_sql .= " AND EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_price WHERE pm_price.post_id = p.ID AND pm_price.meta_key = '_price' AND " . implode( ' AND ', $price_conditions ) . ')';
        }
    }

    $query_limit = '';
    if ( $fast_live ) {
        $query_limit = $wpdb->prepare( ' LIMIT %d', max( 40, min( 160, $limit * 12 ) ) );
    }

    $required_sql = '';
    if ( count( $required_where_parts ) > 1 ) {
        $required_sql = ' AND (' . implode( ' AND ', $required_where_parts ) . ')';
    }

    $sql = "
        SELECT p.ID,
               (" . implode( ' + ', $score_parts ) . ") AS relevance,
               {$title_all_query_priority} AS title_all_query_priority,
               {$title_text_priority} AS title_text_priority,
               {$title_number_priority} AS title_number_priority
        FROM {$wpdb->posts} p
        WHERE p.post_type = 'product'
          AND p.post_status = 'publish'
          AND (" . implode( ' OR ', $where_parts ) . ")
          {$filter_sql}
          {$required_sql}
        GROUP BY p.ID
        ORDER BY title_all_query_priority DESC, title_text_priority DESC, title_number_priority DESC, relevance DESC, p.menu_order ASC, p.post_title ASC
        {$query_limit}
    ";

    $rows = $wpdb->get_results( $sql );
    if ( ! is_array( $rows ) ) {
        return array( 'ids' => array(), 'total' => 0 );
    }

    $ids = array();
    $row_ids = array_map(
        static function ( $row ) {
            return (int) $row->ID;
        },
        $rows
    );

    if ( function_exists( 'dv_prime_product_object_caches' ) ) {
        dv_prime_product_object_caches( $row_ids );
    }

    foreach ( $rows as $row ) {
        $product_id = (int) $row->ID;
        $product    = function_exists( 'dv_get_product_cached' ) ? dv_get_product_cached( $product_id ) : wc_get_product( $product_id );

        if ( ! $product || ! $product->is_visible() ) {
            continue;
        }

        $ids[] = $product_id;
    }

    $has_more = false;
    $total    = count( $ids );

    if ( $limit > 0 ) {
        $has_more = count( $ids ) > $limit || ( $fast_live && count( $rows ) >= max( 40, min( 160, $limit * 12 ) ) );
        $ids = array_slice( $ids, 0, $limit );

        if ( $fast_live && count( $ids ) >= $limit ) {
            $has_more = true;
        }
    }

    return array(
        'ids'      => $ids,
        'total'    => $fast_live && $has_more ? $limit : $total,
        'has_more' => $has_more,
    );
}

function dv_get_product_ids_for_marka_filter( $marka_slug, $query, $tax_query = array(), $meta_query = array() ) {
    $marka_slug = sanitize_title( $marka_slug );

    if ( '' === $marka_slug || ! $query instanceof WP_Query || ! function_exists( 'wc_get_product' ) || ! function_exists( 'dv_get_product_marka_values' ) ) {
        return array();
    }

    $args = (array) $query->query_vars;

    $args['post_type']           = 'product';
    $args['fields']              = 'ids';
    $args['posts_per_page']      = -1;
    $args['no_found_rows']       = true;
    $args['ignore_sticky_posts'] = true;
    $args['suppress_filters']    = true;

    unset(
        $args['paged'],
        $args['page'],
        $args['offset'],
        $args['posts_per_archive_page'],
        $args['marka']
    );

    if ( ! empty( $tax_query ) ) {
        $args['tax_query'] = $tax_query;
    }

    if ( ! empty( $meta_query ) ) {
        $args['meta_query'] = $meta_query;
    }

    $products_query = new WP_Query( $args );
    $matched_ids    = array();
    $marka_taxonomy = dv_get_marka_taxonomy();

    if ( function_exists( 'dv_prime_product_object_caches' ) ) {
        dv_prime_product_object_caches( $products_query->posts );
    }

    foreach ( $products_query->posts as $product_id ) {
        $product = function_exists( 'dv_get_product_cached' ) ? dv_get_product_cached( $product_id ) : wc_get_product( $product_id );

        if ( ! $product || ! $product->is_visible() ) {
            continue;
        }

        foreach ( dv_get_product_marka_values( $product, $marka_taxonomy ) as $brand_data ) {
            if ( ! empty( $brand_data['slug'] ) && $marka_slug === $brand_data['slug'] ) {
                $matched_ids[] = (int) $product_id;
                break;
            }
        }
    }

    wp_reset_postdata();

    return array_values( array_unique( array_filter( $matched_ids ) ) );
}

function dv_apply_catalog_filters( $query ) {
    if ( ! $query instanceof WP_Query ) {
        return;
    }

    $filters    = dv_get_request_filter_args();
    $tax_query  = (array) $query->get( 'tax_query' );
    $meta_query = (array) $query->get( 'meta_query' );

    if ( $filters['marka'] ) {
        $taxonomy = dv_get_marka_taxonomy();
        if ( $taxonomy ) {
            $tax_query[] = array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => array( $filters['marka'] ),
            );
        }
    }

    if ( 'instock' === $filters['stock'] ) {
        $meta_query[] = array(
            'key'   => '_stock_status',
            'value' => 'instock',
        );
    }

    if ( '' !== $filters['min_price'] || '' !== $filters['max_price'] ) {
        $price_clause = array(
            'key'     => '_price',
            'type'    => 'NUMERIC',
            'compare' => 'BETWEEN',
            'value'   => array(
                '' !== $filters['min_price'] ? (float) $filters['min_price'] : 0,
                '' !== $filters['max_price'] ? (float) $filters['max_price'] : 999999999,
            ),
        );
        if ( '' === $filters['min_price'] ) {
            $price_clause['compare'] = '<=';
            $price_clause['value']   = (float) $filters['max_price'];
        } elseif ( '' === $filters['max_price'] ) {
            $price_clause['compare'] = '>=';
            $price_clause['value']   = (float) $filters['min_price'];
        }
        $meta_query[] = $price_clause;
    }

    if ( ! empty( $tax_query ) ) {
        $query->set( 'tax_query', $tax_query );
    }
    if ( ! empty( $meta_query ) ) {
        $query->set( 'meta_query', $meta_query );
    }
}

function dv_apply_product_search_to_main_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
        return;
    }

    $query->set( 'post_type', 'product' );
    $query->set( 'post_status', 'publish' );

    $search = trim( (string) $query->get( 's' ) );
    if ( mb_strlen( $search ) < 2 ) {
        return;
    }

    $filter_args = dv_get_request_filter_args();
    $results     = dv_search_filters_are_empty( $filter_args )
        ? dv_get_product_search_ids_from_index( $search, 0 )
        : dv_get_product_search_ids( $search, 0, $filter_args );
    $ids     = ! empty( $results['ids'] ) ? $results['ids'] : array( 0 );

    $query->set( 'post__in', $ids );
    $query->set( 'orderby', 'post__in' );
    $query->set( 'ignore_sticky_posts', true );
    $query->set( 'dv_search_total', (int) $results['total'] );
    $query->set( 'dv_search_ids', $ids );
    $query->set( 'dv_custom_product_search', true );

    if ( ! $query->get( 'posts_per_page' ) ) {
        $query->set( 'posts_per_page', function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'search_page_per_page', 24, 1, 96 ) : 24 );
    }
}
add_action( 'pre_get_posts', 'dv_apply_product_search_to_main_query', 5 );

function dv_force_custom_product_search_ids( $clauses, $query ) {
    global $wpdb;

    if ( ! $query instanceof WP_Query || ! $query->get( 'dv_custom_product_search' ) ) {
        return $clauses;
    }

    $ids = array_filter( array_map( 'absint', (array) $query->get( 'dv_search_ids' ) ) );
    if ( empty( $ids ) ) {
        $ids = array( 0 );
    }

    $ids_sql = implode( ',', $ids );
    $clauses['where'] .= " AND {$wpdb->posts}.ID IN ({$ids_sql})";

    if ( count( $ids ) > 1 ) {
        $clauses['orderby'] = 'FIELD(' . $wpdb->posts . '.ID,' . $ids_sql . ')';
    }

    return $clauses;
}
add_filter( 'posts_clauses', 'dv_force_custom_product_search_ids', 999, 2 );

function dv_apply_catalog_filters_to_archive( $query ) {
    if ( is_admin() || ! $query->is_main_query() || $query->is_search() ) {
        return;
    }

    if ( ! $query->is_post_type_archive( 'product' ) && ! $query->is_tax( get_object_taxonomies( 'product' ) ) ) {
        return;
    }

    $query->set( 'post_type', 'product' );
    dv_apply_catalog_filters( $query );
}
add_action( 'pre_get_posts', 'dv_apply_catalog_filters_to_archive', 20 );

function dv_disable_native_search_for_custom( $search, $wp_query ) {
    if ( $wp_query->get( 'dv_custom_product_search' ) ) {
        return '';
    }
    return $search;
}
add_filter( 'posts_search', 'dv_disable_native_search_for_custom', 999, 2 );

function dv_ajax_live_search() {
    $query = sanitize_text_field( wp_unslash( $_GET['q'] ?? '' ) );

    if ( mb_strlen( trim( $query ) ) < 2 ) {
        wp_send_json_success( array( 'items' => array(), 'total' => 0, 'query' => $query, 'search_url' => home_url( '/?s=' . rawurlencode( $query ) . '&post_type=product' ) ) );
    }

    $live_limit = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'search_live_limit', 8, 1, 20 ) : 8;
    $fast_results = dv_get_live_search_results( $query, $live_limit );
    $fast_items   = array();

    foreach ( $fast_results['items'] as $item ) {
        $product_id = (int) ( $item['id'] ?? 0 );

        if ( ! $product_id ) {
            continue;
        }

        $image_url = ! empty( $item['thumbnail_id'] ) ? wp_get_attachment_image_url( (int) $item['thumbnail_id'], 'thumbnail' ) : '';
        if ( ! $image_url ) {
            $image_url = wc_placeholder_img_src( 'thumbnail' );
        }

        $fast_items[] = array(
            'id'       => $product_id,
            'name'     => (string) ( $item['title'] ?? '' ),
            'url'      => get_permalink( $product_id ),
            'img'      => $image_url,
            'price'    => (string) ( $item['price_label'] ?? '' ),
            'sku'      => (string) ( $item['sku'] ?? '' ),
            'in_stock' => ! empty( $item['in_stock'] ),
            'stock_q'  => $item['stock_q'] ?? '',
        );
    }

    wp_send_json_success(
        array(
            'items'       => $fast_items,
            'total'       => (int) $fast_results['total'],
            'total_label' => (string) (int) $fast_results['total'],
            'query'       => $query,
            'search_url'  => home_url( '/?s=' . rawurlencode( $query ) . '&post_type=product' ),
        )
    );

}
add_action( 'wp_ajax_dv_live_search', 'dv_ajax_live_search' );
add_action( 'wp_ajax_nopriv_dv_live_search', 'dv_ajax_live_search' );

