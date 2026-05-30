<?php
defined( 'ABSPATH' ) || exit;

function dv_search_labels() {
    return array(
        'currency_symbol' => html_entity_decode( '&#8381;', ENT_QUOTES, 'UTF-8' ),
        'price_request'   => html_entity_decode( '&#1062;&#1077;&#1085;&#1072; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091;', ENT_QUOTES, 'UTF-8' ),
    );
}

function dv_search_variants( $query ) {
    $query = mb_strtolower( trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $query ) ) ), 'UTF-8' );

    if ( '' === $query ) {
        return array();
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

    return array_values( array_unique( array_filter( $variants ) ) );
}

function dv_cyr_to_lat( $text ) {
    return strtr(
        $text,
        array(
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        )
    );
}

function dv_lat_to_cyr( $text ) {
    $map = array(
        'sch' => 'щ', 'sh' => 'ш', 'ch' => 'ч', 'zh' => 'ж', 'ts' => 'ц', 'yu' => 'ю', 'ya' => 'я', 'yo' => 'ё', 'kh' => 'х',
        'a' => 'а', 'b' => 'б', 'v' => 'в', 'g' => 'г', 'd' => 'д', 'e' => 'е', 'z' => 'з', 'i' => 'и', 'y' => 'й', 'k' => 'к',
        'l' => 'л', 'm' => 'м', 'n' => 'н', 'o' => 'о', 'p' => 'п', 'r' => 'р', 's' => 'с', 't' => 'т', 'u' => 'у', 'f' => 'ф',
        'h' => 'х', 'w' => 'в', 'q' => 'к', 'x' => 'кс',
    );

    $result = '';
    $length = mb_strlen( $text );
    $index  = 0;

    while ( $index < $length ) {
        $matched = false;
        foreach ( array( 3, 2, 1 ) as $size ) {
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
    return array(
        'ваз' => 'vaz', 'vaz' => 'ваз', 'лада' => 'lada', 'lada' => 'лада', 'экрис' => 'ekris', 'ekris' => 'экрис',
        'стилл' => 'still', 'still' => 'стилл', 'тольятти' => 'tolyatti', 'tolyatti' => 'тольятти',
        'кия' => 'kia', 'kia' => 'кия', 'рено' => 'renault', 'renault' => 'рено', 'ниссан' => 'nissan', 'nissan' => 'ниссан',
        'тойота' => 'toyota', 'toyota' => 'тойота', 'хендай' => 'hyundai', 'hyundai' => 'хендай', 'форд' => 'ford', 'ford' => 'форд',
        'бмв' => 'bmw', 'bmw' => 'бмв', 'мерседес' => 'mercedes', 'mercedes' => 'мерседес',
        'фольксваген' => 'volkswagen', 'volkswagen' => 'фольксваген', 'шкода' => 'skoda', 'skoda' => 'шкода',
        'опель' => 'opel', 'opel' => 'опель', 'мазда' => 'mazda', 'mazda' => 'мазда', 'хонда' => 'honda', 'honda' => 'хонда',
        'ауди' => 'audi', 'audi' => 'ауди', 'субару' => 'subaru', 'subaru' => 'субару', 'митсубиси' => 'mitsubishi', 'mitsubishi' => 'митсубиси',
    );
}

function dv_lada_model_alias_groups() {
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

    return array_values(
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
            return $taxonomy;
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
                    return $taxonomy;
                }
            }
        }
    }

    return '';
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

function dv_get_product_search_ids( $raw_query, $limit = 0, $filter_args = array() ) {
    global $wpdb;

    $terms = dv_search_extract_terms( $raw_query );
    if ( empty( $terms ) ) {
        return array( 'ids' => array(), 'total' => 0 );
    }

    $full_query    = mb_strtolower( trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $raw_query ) ) ), 'UTF-8' );
    $compact_query = preg_replace( '/[^\p{L}\p{N}]+/u', '', $full_query );

    $where_parts = array();
    $score_parts = array();

    if ( '' !== $full_query ) {
        $full_prefix = $wpdb->esc_like( $full_query ) . '%';
        $full_like   = '%' . $wpdb->esc_like( $full_query ) . '%';

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

        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) = %s THEN 320 ELSE 0 END", $full_query );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) LIKE %s THEN 260 ELSE 0 END", $full_prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) LIKE %s THEN 190 ELSE 0 END", $full_like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) = %s THEN 220 ELSE 0 END", $full_query );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) LIKE %s THEN 170 ELSE 0 END", $full_prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) LIKE %s THEN 120 ELSE 0 END", $full_like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_full WHERE pm_sku_full.post_id = p.ID AND pm_sku_full.meta_key = '_sku' AND LOWER(pm_sku_full.meta_value) = %s) THEN 340 ELSE 0 END", $full_query );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_full WHERE pm_sku_full.post_id = p.ID AND pm_sku_full.meta_key = '_sku' AND LOWER(pm_sku_full.meta_value) LIKE %s) THEN 280 ELSE 0 END", $full_prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat_full WHERE pm_compat_full.post_id = p.ID AND pm_compat_full.meta_key = '_compatibility' AND LOWER(pm_compat_full.meta_value) LIKE %s) THEN 110 ELSE 0 END", $full_like );
    }

    if ( $compact_query && $compact_query !== $full_query && mb_strlen( $compact_query, 'UTF-8' ) >= 3 ) {
        $compact_like = '%' . $wpdb->esc_like( $compact_query ) . '%';

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

        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku_compact WHERE pm_sku_compact.post_id = p.ID AND pm_sku_compact.meta_key = '_sku' AND LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(pm_sku_compact.meta_value, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s) THEN 300 ELSE 0 END", $compact_like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat_compact WHERE pm_compat_compact.post_id = p.ID AND pm_compat_compact.meta_key = '_compatibility' AND LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(pm_compat_compact.meta_value, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s) THEN 140 ELSE 0 END", $compact_like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(p.post_title, '-', ''), ' ', ''), '/', ''), '(', ''), ')', ''), '.', '')) LIKE %s THEN 180 ELSE 0 END", $compact_like );
    }

    foreach ( $terms as $term ) {
        $exact  = mb_strtolower( $term, 'UTF-8' );
        $prefix = $wpdb->esc_like( $exact ) . '%';
        $like   = '%' . $wpdb->esc_like( $exact ) . '%';

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

        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku WHERE pm_sku.post_id = p.ID AND pm_sku.meta_key = '_sku' AND LOWER(pm_sku.meta_value) = %s) THEN 260 ELSE 0 END", $exact );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku WHERE pm_sku.post_id = p.ID AND pm_sku.meta_key = '_sku' AND LOWER(pm_sku.meta_value) LIKE %s) THEN 220 ELSE 0 END", $prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_sku WHERE pm_sku.post_id = p.ID AND pm_sku.meta_key = '_sku' AND LOWER(pm_sku.meta_value) LIKE %s) THEN 160 ELSE 0 END", $like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) = %s THEN 210 ELSE 0 END", $exact );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) LIKE %s THEN 170 ELSE 0 END", $prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_title) LIKE %s THEN 120 ELSE 0 END", $like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) = %s THEN 140 ELSE 0 END", $exact );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) LIKE %s THEN 110 ELSE 0 END", $prefix );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_name) LIKE %s THEN 80 ELSE 0 END", $like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_excerpt) LIKE %s THEN 40 ELSE 0 END", $like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN LOWER(p.post_content) LIKE %s THEN 25 ELSE 0 END", $like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->postmeta} pm_compat WHERE pm_compat.post_id = p.ID AND pm_compat.meta_key = '_compatibility' AND LOWER(pm_compat.meta_value) LIKE %s) THEN 55 ELSE 0 END", $like );
        $score_parts[] = $wpdb->prepare( "CASE WHEN EXISTS (SELECT 1 FROM {$wpdb->term_relationships} tr INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id = tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id WHERE tr.object_id = p.ID AND tt.taxonomy IN ('product_cat','product_tag','car_brand','pa_car_brand','pa_marka-tc','pa_marka_tc','pa_marka','pa_brand','pa_model') AND (LOWER(t.name) LIKE %s OR LOWER(t.slug) LIKE %s)) THEN 70 ELSE 0 END", $like, $like );
    }

    $filter_sql  = '';
    $filter_args = wp_parse_args( $filter_args, dv_get_request_filter_args() );
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

    $sql = "
        SELECT p.ID, (" . implode( ' + ', $score_parts ) . ") AS relevance
        FROM {$wpdb->posts} p
        WHERE p.post_type = 'product'
          AND p.post_status = 'publish'
          AND (" . implode( ' OR ', $where_parts ) . ")
          {$filter_sql}
        GROUP BY p.ID
        ORDER BY relevance DESC, p.menu_order ASC, p.post_title ASC
    ";

    $rows = $wpdb->get_results( $sql );
    if ( ! is_array( $rows ) ) {
        return array( 'ids' => array(), 'total' => 0 );
    }

    $ids = array();

    foreach ( $rows as $row ) {
        $product_id = (int) $row->ID;
        $product    = wc_get_product( $product_id );

        if ( ! $product || ! $product->is_visible() ) {
            continue;
        }

        $ids[] = $product_id;
    }

    $total = count( $ids );

    if ( $limit > 0 ) {
        $ids = array_slice( $ids, 0, $limit );
    }

    return array(
        'ids'   => $ids,
        'total' => $total,
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

    foreach ( $products_query->posts as $product_id ) {
        $product = wc_get_product( $product_id );

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

    $results = dv_get_product_search_ids( $search, 0, dv_get_request_filter_args() );
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
    $results    = dv_get_product_search_ids( $query, $live_limit, array() );
    $items   = array();

    foreach ( $results['ids'] as $product_id ) {
        $product = wc_get_product( $product_id );
        if ( ! $product || ! $product->is_visible() ) {
            continue;
        }

        $image_url = wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' );
        if ( ! $image_url ) {
            $image_url = wc_placeholder_img_src( 'thumbnail' );
        }

        $price   = $product->get_price();
        $items[] = array(
            'id'       => $product->get_id(),
            'name'     => function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name(),
            'url'      => $product->get_permalink(),
            'img'      => $image_url,
            'price'    => '' !== (string) $price ? number_format( (float) $price, 0, '.', ' ' ) . ' ₽' : 'Цена по запросу',
            'sku'      => $product->get_sku(),
            'in_stock' => $product->is_in_stock(),
            'stock_q'  => $product->get_stock_quantity(),
        );
    }

    wp_send_json_success(
        array(
            'items'      => $items,
            'total'      => (int) $results['total'],
            'query'      => $query,
            'search_url' => home_url( '/?s=' . rawurlencode( $query ) . '&post_type=product' ),
        )
    );
}
add_action( 'wp_ajax_dv_live_search', 'dv_ajax_live_search' );
add_action( 'wp_ajax_nopriv_dv_live_search', 'dv_ajax_live_search' );

