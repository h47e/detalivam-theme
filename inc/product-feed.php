<?php
/**
 * YML feed for product marketplaces and aggregators.
 */
defined( 'ABSPATH' ) || exit;

function dv_product_feed_xml_escape( $value ) {
    return esc_xml( (string) $value );
}

function dv_product_feed_cache_key() {
    return 'dv_product_feed_xml_v2';
}

function dv_product_feed_report_cache_key() {
    return 'dv_product_feed_report_v6';
}

function dv_product_feed_report_version() {
    return 'v6';
}

function dv_product_feed_currency_id() {
    $currency = function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : 'RUB';
    $currency = strtoupper( sanitize_text_field( (string) $currency ) );

    return 'RUB' === $currency ? 'RUR' : $currency;
}

function dv_product_feed_url() {
    return home_url( '/yandex-market.xml' );
}

function dv_clear_product_feed_cache( ...$unused ) {
    delete_transient( dv_product_feed_cache_key() );
    delete_transient( dv_product_feed_report_cache_key() );
    delete_transient( 'dv_product_feed_xml_v1' );
    delete_transient( 'dv_product_feed_report_v1' );
    delete_transient( 'dv_product_feed_report_v2' );
    delete_transient( 'dv_product_feed_report_v3' );
    delete_transient( 'dv_product_feed_report_v4' );
    delete_transient( 'dv_product_feed_report_v5' );
}

function dv_product_feed_table_exists( $table_name ) {
    global $wpdb;

    if ( ! $wpdb || '' === (string) $table_name ) {
        return false;
    }

    $found = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( (string) $table_name ) ) );

    return (string) $found === (string) $table_name;
}

function dv_product_feed_database_snapshot() {
    global $wpdb;

    $snapshot = array(
        'posts_table'          => '',
        'posts_table_exists'   => false,
        'total_posts'          => 0,
        'product_statuses'     => array(),
        'product_like_types'   => array(),
        'top_post_types'       => array(),
        'lookup_table'         => '',
        'lookup_table_exists'  => false,
        'lookup_rows'          => 0,
        'lookup_priced_rows'   => 0,
        'last_error'           => '',
    );

    if ( ! $wpdb ) {
        $snapshot['last_error'] = 'wpdb is not available';

        return $snapshot;
    }

    $snapshot['posts_table'] = (string) $wpdb->posts;
    $snapshot['posts_table_exists'] = dv_product_feed_table_exists( $wpdb->posts );

    if ( ! $snapshot['posts_table_exists'] ) {
        $snapshot['last_error'] = 'posts table not found';

        return $snapshot;
    }

    $snapshot['total_posts'] = absint( $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts}" ) );

    $product_statuses = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT post_status, COUNT(*) AS total
            FROM {$wpdb->posts}
            WHERE post_type = %s
            GROUP BY post_status
            ORDER BY total DESC",
            'product'
        ),
        ARRAY_A
    );
    $snapshot['product_statuses'] = is_array( $product_statuses ) ? array_values( $product_statuses ) : array();

    $product_like_types = $wpdb->get_results(
        "SELECT post_type, post_status, COUNT(*) AS total
        FROM {$wpdb->posts}
        WHERE post_type LIKE '%product%'
        GROUP BY post_type, post_status
        ORDER BY total DESC
        LIMIT 20",
        ARRAY_A
    );
    $snapshot['product_like_types'] = is_array( $product_like_types ) ? array_values( $product_like_types ) : array();

    $top_post_types = $wpdb->get_results(
        "SELECT post_type, post_status, COUNT(*) AS total
        FROM {$wpdb->posts}
        GROUP BY post_type, post_status
        ORDER BY total DESC
        LIMIT 12",
        ARRAY_A
    );
    $snapshot['top_post_types'] = is_array( $top_post_types ) ? array_values( $top_post_types ) : array();

    $lookup_table = $wpdb->prefix . 'wc_product_meta_lookup';
    $snapshot['lookup_table'] = $lookup_table;
    $snapshot['lookup_table_exists'] = dv_product_feed_table_exists( $lookup_table );

    if ( $snapshot['lookup_table_exists'] ) {
        $snapshot['lookup_rows'] = absint( $wpdb->get_var( "SELECT COUNT(*) FROM {$lookup_table}" ) );
        $snapshot['lookup_priced_rows'] = absint(
            $wpdb->get_var(
                "SELECT COUNT(*)
                FROM {$lookup_table}
                WHERE COALESCE(min_price, 0) > 0 OR COALESCE(max_price, 0) > 0"
            )
        );
    }

    if ( '' !== (string) $wpdb->last_error ) {
        $snapshot['last_error'] = (string) $wpdb->last_error;
    }

    return $snapshot;
}

function dv_product_feed_get_product_ids_sql( $priced_only = false ) {
    global $wpdb;

    if ( ! $wpdb ) {
        return array();
    }

    if ( $priced_only ) {
        $ids = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT DISTINCT p.ID
                FROM {$wpdb->posts} p
                INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
                WHERE p.post_type = %s
                    AND p.post_status = %s
                    AND pm.meta_key IN ('_price', '_regular_price', '_sale_price')
                    AND TRIM(COALESCE(pm.meta_value, '')) <> ''
                    AND CAST(pm.meta_value AS DECIMAL(20,6)) > 0
                ORDER BY p.ID ASC",
                'product',
                'publish'
            )
        );
    } else {
        $ids = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT ID
                FROM {$wpdb->posts}
                WHERE post_type = %s
                    AND post_status = %s
                ORDER BY ID ASC",
                'product',
                'publish'
            )
        );
    }

    return array_values( array_unique( array_filter( array_map( 'absint', is_array( $ids ) ? $ids : array() ) ) ) );
}

function dv_product_feed_get_product_ids() {
    if ( function_exists( 'wc_get_products' ) ) {
        $wc_product_ids = wc_get_products(
            array(
                'status'  => 'publish',
                'limit'   => -1,
                'return'  => 'ids',
                'orderby' => 'ID',
                'order'   => 'ASC',
            )
        );

        if ( is_array( $wc_product_ids ) && ! empty( $wc_product_ids ) ) {
            return array_values( array_unique( array_filter( array_map( 'absint', $wc_product_ids ) ) ) );
        }
    }

    $product_ids = get_posts(
        array(
            'post_type'              => 'product',
            'post_status'            => 'publish',
            'fields'                 => 'ids',
            'numberposts'            => -1,
            'orderby'                => 'ID',
            'order'                  => 'ASC',
            'no_found_rows'          => true,
            'update_post_term_cache'  => false,
            'update_post_meta_cache'  => false,
            'suppress_filters'       => true,
        )
    );

    $product_ids = array_values( array_unique( array_filter( array_map( 'absint', is_array( $product_ids ) ? $product_ids : array() ) ) ) );

    if ( ! empty( $product_ids ) ) {
        return $product_ids;
    }

    return dv_product_feed_get_product_ids_sql();
}

function dv_product_feed_get_categories() {
    $terms = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'orderby'    => 'name',
            'order'      => 'ASC',
            'fields'     => 'all',
        )
    );

    if ( ! is_array( $terms ) || empty( $terms ) ) {
        return array();
    }

    return array_filter(
        $terms,
        static function ( $term ) {
            return $term instanceof WP_Term;
        }
    );
}

function dv_product_feed_get_product_category_id( $product_id ) {
    $primary_category = function_exists( 'dv_get_primary_product_cat' ) ? dv_get_primary_product_cat( $product_id ) : null;
    if ( $primary_category instanceof WP_Term && $primary_category->term_id > 0 ) {
        return (int) $primary_category->term_id;
    }

    $category_ids = wp_get_post_terms(
        (int) $product_id,
        'product_cat',
        array(
            'fields'                 => 'ids',
            'orderby'                => 'term_id',
            'order'                  => 'ASC',
            'update_term_meta_cache'  => false,
            'update_term_cache'       => false,
            'suppress_filters'       => true,
        )
    );

    if ( empty( $category_ids ) || ! is_array( $category_ids ) ) {
        return 0;
    }

    return (int) $category_ids[0];
}

function dv_product_feed_product_images( $product, $product_id = 0 ) {
    $image_ids = array();
    $product_id = absint( $product_id );

    if ( $product instanceof WC_Product ) {
        $image_id = $product->get_image_id();
        if ( $image_id ) {
            $image_ids[] = (int) $image_id;
        }

        $gallery_ids = $product->get_gallery_image_ids();
        if ( is_array( $gallery_ids ) ) {
            $image_ids = array_merge( $image_ids, array_map( 'absint', $gallery_ids ) );
        }
    } elseif ( $product_id > 0 ) {
        $thumbnail_id = get_post_thumbnail_id( $product_id );
        if ( $thumbnail_id ) {
            $image_ids[] = (int) $thumbnail_id;
        }

        $gallery = get_post_meta( $product_id, '_product_image_gallery', true );
        if ( '' !== (string) $gallery ) {
            $image_ids = array_merge( $image_ids, array_map( 'absint', explode( ',', (string) $gallery ) ) );
        }
    }

    $image_ids = array_values( array_unique( array_filter( $image_ids ) ) );
    $images    = array();

    foreach ( $image_ids as $image_id ) {
        $image_url = wp_get_attachment_image_url( $image_id, 'full' );
        if ( '' !== (string) $image_url ) {
            $images[] = (string) $image_url;
        }

        if ( count( $images ) >= 10 ) {
            break;
        }
    }

    if ( empty( $images ) && $product_id > 0 ) {
        $fallback = get_the_post_thumbnail_url( $product_id, 'full' );
        if ( '' !== (string) $fallback ) {
            $images[] = (string) $fallback;
        }
    }

    return $images;
}

function dv_product_feed_product_description( $product, $product_id = 0 ) {
    $description = '';
    $product_id  = absint( $product_id );

    if ( $product instanceof WC_Product && '' !== (string) $product->get_short_description() ) {
        $description = $product->get_short_description();
    } elseif ( $product instanceof WC_Product && '' !== (string) $product->get_description() ) {
        $description = $product->get_description();
    } elseif ( $product_id > 0 && '' !== (string) get_post_field( 'post_excerpt', $product_id ) ) {
        $description = get_post_field( 'post_excerpt', $product_id );
    } elseif ( $product_id > 0 && '' !== (string) get_post_field( 'post_content', $product_id ) ) {
        $description = get_post_field( 'post_content', $product_id );
    } elseif ( $product instanceof WC_Product && function_exists( 'dv_build_product_seo_description' ) ) {
        $description = dv_build_product_seo_description( $product );
    }

    $description = html_entity_decode( wp_strip_all_tags( (string) $description ), ENT_QUOTES, 'UTF-8' );

    return function_exists( 'dv_trim_seo_text' ) ? dv_trim_seo_text( $description, 900 ) : wp_trim_words( $description, 120, '' );
}

function dv_product_feed_normalize_price( $price ) {
    $price = trim( (string) $price );

    if ( '' === $price ) {
        return '';
    }

    $price = str_replace( ',', '.', preg_replace( '/[^\d,.]/', '', $price ) );

    if ( '' === $price || ! is_numeric( $price ) || (float) $price <= 0 ) {
        return '';
    }

    return $price;
}

function dv_product_feed_product_price( $product, $product_id = 0 ) {
    $product_id    = $product instanceof WC_Product ? $product->get_id() : absint( $product_id );
    $price_values  = array();

    if ( $product instanceof WC_Product ) {
        $price_values = array(
            $product->get_price(),
            $product->get_sale_price(),
            $product->get_regular_price(),
        );
    }

    if ( $product_id > 0 ) {
        $price_values[] = get_post_meta( $product_id, '_price', true );
        $price_values[] = get_post_meta( $product_id, '_sale_price', true );
        $price_values[] = get_post_meta( $product_id, '_regular_price', true );
    }

    if ( $product instanceof WC_Product && $product->is_type( 'variable' ) ) {
        $price_values[] = $product->get_variation_price( 'min', true );
        $price_values[] = $product->get_variation_sale_price( 'min', true );
        $price_values[] = $product->get_variation_regular_price( 'min', true );
    }

    foreach ( $price_values as $price ) {
        $price = dv_product_feed_normalize_price( $price );
        if ( '' !== $price ) {
            return $price;
        }
    }

    return '';
}

function dv_product_feed_product_url( $product, $product_id ) {
    if ( $product instanceof WC_Product ) {
        $url = $product->get_permalink();
        if ( '' !== (string) $url ) {
            return (string) $url;
        }
    }

    $url = get_permalink( (int) $product_id );

    return false === $url ? '' : (string) $url;
}

function dv_product_feed_product_diagnostics( $product_ids ) {
    $stats = array(
        'checked'       => 0,
        'ready'         => 0,
        'invalid'       => 0,
        'empty_price'   => 0,
        'empty_url'     => 0,
        'missing_image' => 0,
        'sample_skips'  => array(),
    );

    if ( empty( $product_ids ) ) {
        return $stats;
    }

    foreach ( $product_ids as $product_id ) {
        $product_id = absint( $product_id );
        if ( ! $product_id ) {
            continue;
        }

        $stats['checked']++;
        $product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : null;

        if ( ! $product instanceof WC_Product && 'product' !== get_post_type( $product_id ) ) {
            $stats['invalid']++;
            if ( count( $stats['sample_skips'] ) < 5 ) {
                $stats['sample_skips'][] = '#' . $product_id . ': товар не найден';
            }
            continue;
        }

        if ( '' === dv_product_feed_product_price( $product, $product_id ) ) {
            $stats['empty_price']++;
            if ( count( $stats['sample_skips'] ) < 5 ) {
                $stats['sample_skips'][] = '#' . $product_id . ': пустая цена';
            }
            continue;
        }

        if ( '' === dv_product_feed_product_url( $product, $product_id ) ) {
            $stats['empty_url']++;
            if ( count( $stats['sample_skips'] ) < 5 ) {
                $stats['sample_skips'][] = '#' . $product_id . ': пустая ссылка';
            }
            continue;
        }

        if ( empty( dv_product_feed_product_images( $product, $product_id ) ) ) {
            $stats['missing_image']++;
            if ( count( $stats['sample_skips'] ) < 5 ) {
                $stats['sample_skips'][] = '#' . $product_id . ': нет фото';
            }
            continue;
        }

        $stats['ready']++;
    }

    return $stats;
}

function dv_product_feed_problem_samples( $product_ids, $limit = 8 ) {
    $samples = array();
    $limit   = max( 1, absint( $limit ) );

    foreach ( (array) $product_ids as $product_id ) {
        $product_id = absint( $product_id );
        if ( ! $product_id ) {
            continue;
        }

        $product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : null;
        $price   = dv_product_feed_product_price( $product, $product_id );
        $url     = dv_product_feed_product_url( $product, $product_id );
        $images  = dv_product_feed_product_images( $product, $product_id );
        $issue   = '';

        if ( ! $product instanceof WC_Product && 'product' !== get_post_type( $product_id ) ) {
            $issue = 'Товар не найден';
        } elseif ( '' === $price ) {
            $issue = 'Нет цены';
        } elseif ( '' === $url ) {
            $issue = 'Нет ссылки';
        } elseif ( empty( $images ) ) {
            $issue = 'Нет фото';
        }

        if ( '' === $issue ) {
            continue;
        }

        $samples[] = array(
            'id'       => $product_id,
            'issue'    => $issue,
            'title'    => wp_strip_all_tags( get_the_title( $product_id ) ),
            'price'    => $price,
            'edit_url' => get_edit_post_link( $product_id, 'raw' ),
            'view_url' => $url,
        );

        if ( count( $samples ) >= $limit ) {
            break;
        }
    }

    return $samples;
}

function dv_product_feed_problem_summary( $report ) {
    $report = is_array( $report ) ? $report : array();

    if ( empty( $report['xml_valid'] ) && ! empty( $report['size_bytes'] ) ) {
        return array(
            'title' => 'XML собрался, но не валиден',
            'text'  => ! empty( $report['xml_error'] ) ? (string) $report['xml_error'] : 'Проверьте структуру XML.',
        );
    }

    if ( empty( $report['sql_product_count'] ) ) {
        return array(
            'title' => 'Товары не найдены в базе',
            'text'  => 'В таблице posts нет опубликованных записей post_type=product.',
        );
    }

    if ( empty( $report['sql_priced_count'] ) ) {
        return array(
            'title' => 'У товаров нет цены в meta',
            'text'  => 'Не найдено положительных значений в _price, _regular_price или _sale_price.',
        );
    }

    if ( empty( $report['ready_count'] ) ) {
        return array(
            'title' => 'Товары есть, но не проходят подготовку',
            'text'  => 'Проверьте примеры ниже: чаще всего не хватает цены, ссылки или фото.',
        );
    }

    if ( empty( $report['offers_count'] ) ) {
        return array(
            'title' => 'Товары готовы, но offer не попали в XML',
            'text'  => 'Значит ошибка находится внутри сборки блока offers.',
        );
    }

    return array(
        'title' => 'Фид выглядит рабочим',
        'text'  => 'Товары, offer и XML сформированы.',
    );
}

function dv_render_yml_product_feed_xml() {
    $store       = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
    $store_name  = function_exists( 'dv_string_value' ) ? dv_string_value( $store['name'] ?? '', get_bloginfo( 'name' ) ) : ( is_scalar( $store['name'] ?? null ) ? trim( (string) $store['name'] ) : get_bloginfo( 'name' ) );
    $store_url   = function_exists( 'dv_string_value' ) ? dv_string_value( $store['site_url'] ?? '', home_url( '/' ) ) : ( is_scalar( $store['site_url'] ?? null ) ? trim( (string) $store['site_url'] ) : home_url( '/' ) );
    $categories  = dv_product_feed_get_categories();
    $product_ids = dv_product_feed_get_product_ids();
    $currency_id = dv_product_feed_currency_id();
    $date        = date_i18n( 'Y-m-d H:i' );

    $offers = array();
    $seen   = array();

    foreach ( $product_ids as $product_id ) {
        if ( isset( $seen[ $product_id ] ) ) {
            continue;
        }

        $seen[ $product_id ] = true;

        $product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : null;
        if ( ! $product instanceof WC_Product && 'product' !== get_post_type( $product_id ) ) {
            continue;
        }

        $price = dv_product_feed_product_price( $product, $product_id );
        if ( '' === $price ) {
            continue;
        }

        $name         = $product instanceof WC_Product ? ( function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name() ) : get_the_title( $product_id );
        $description  = dv_product_feed_product_description( $product, $product_id );
        $brand        = $product instanceof WC_Product && function_exists( 'dv_get_product_brand_name' ) ? dv_get_product_brand_name( $product ) : '';
        $sku          = $product instanceof WC_Product ? ( function_exists( 'dv_get_product_seo_sku' ) ? dv_get_product_seo_sku( $product ) : $product->get_sku() ) : get_post_meta( $product_id, '_sku', true );
        $category_id  = dv_product_feed_get_product_category_id( $product_id );
        $images       = dv_product_feed_product_images( $product, $product_id );
        $stock_status = get_post_meta( $product_id, '_stock_status', true );
        $available    = $product instanceof WC_Product ? ( $product->is_in_stock() ? 'true' : 'false' ) : ( 'outofstock' === $stock_status ? 'false' : 'true' );
        $url          = dv_product_feed_product_url( $product, $product_id );
        $price_text   = function_exists( 'wc_format_decimal' ) ? wc_format_decimal( $price, 2 ) : number_format( (float) $price, 2, '.', '' );

        if ( '' === $url ) {
            continue;
        }

        if ( empty( $images ) ) {
            continue;
        }

        $offer = array(
            ' <offer id="' . esc_attr( $product_id ) . '" available="' . esc_attr( $available ) . '">',
            '   <url>' . dv_product_feed_xml_escape( $url ) . '</url>',
            '   <price>' . esc_html( $price_text ) . '</price>',
            '   <currencyId>' . esc_html( $currency_id ) . '</currencyId>',
            '   <name>' . dv_product_feed_xml_escape( $name ) . '</name>',
        );

        if ( $category_id > 0 ) {
            $offer[] = '   <categoryId>' . esc_html( (string) $category_id ) . '</categoryId>';
        }

        if ( '' !== $brand ) {
            $offer[] = '   <vendor>' . dv_product_feed_xml_escape( $brand ) . '</vendor>';
        }

        if ( '' !== $sku ) {
            $offer[] = '   <vendorCode>' . dv_product_feed_xml_escape( $sku ) . '</vendorCode>';
        }

        foreach ( $images as $image ) {
            $offer[] = '   <picture>' . dv_product_feed_xml_escape( $image ) . '</picture>';
        }

        if ( '' !== $description ) {
            $offer[] = '   <description>' . dv_product_feed_xml_escape( $description ) . '</description>';
        }

        $offer[] = '   <sales_notes>' . dv_product_feed_xml_escape( 'Цена и наличие актуальны на сайте. Доставка и самовывоз по согласованию с менеджером.' ) . '</sales_notes>';
        $offer[] = '</offer>';

        $offers[] = implode( "\n", $offer );
    }

    $offers_xml = implode( "\n", $offers );

    $output = array();
    $output[] = '<?xml version="1.0" encoding="UTF-8"?>';
    $output[] = '<yml_catalog date="' . esc_attr( $date ) . '">';
    $output[] = '  <shop>';
    $output[] = '    <name>' . dv_product_feed_xml_escape( $store_name ) . '</name>';
    $output[] = '    <company>' . dv_product_feed_xml_escape( $store_name ) . '</company>';
    $output[] = '    <url>' . dv_product_feed_xml_escape( $store_url ) . '</url>';
    $output[] = '    <currencies>';
    $output[] = '      <currency id="' . esc_attr( $currency_id ) . '" rate="1"/>';
    $output[] = '    </currencies>';
    $output[] = '    <categories>';
    foreach ( $categories as $category ) {
        $output[] = '      <category id="' . esc_attr( (string) $category->term_id ) . '"' . ( $category->parent > 0 ? ' parentId="' . esc_attr( (string) $category->parent ) . '"' : '' ) . '>' . dv_product_feed_xml_escape( $category->name ) . '</category>';
    }
    $output[] = '    </categories>';
    $output[] = '    <offers>';
    if ( '' !== $offers_xml ) {
        $output[] = $offers_xml;
    }
    $output[] = '    </offers>';
    $output[] = '  </shop>';
    $output[] = '</yml_catalog>';

    return implode( "\n", $output );
}

function dv_get_yml_product_feed_xml() {
    $cache_key = dv_product_feed_cache_key();
    $cached    = get_transient( $cache_key );

    if ( is_string( $cached ) && '' !== $cached ) {
        return $cached;
    }

    $feed = dv_render_yml_product_feed_xml();
    if ( is_string( $feed ) && '' !== trim( $feed ) ) {
        set_transient( $cache_key, $feed, 6 * HOUR_IN_SECONDS );
    } else {
        delete_transient( $cache_key );
    }

    return $feed;
}

function dv_product_feed_report( $force_refresh = false ) {
    $cache_key = dv_product_feed_report_cache_key();

    if ( $force_refresh ) {
        dv_clear_product_feed_cache();
    }

    if ( ! $force_refresh ) {
        $cached = get_transient( $cache_key );
        if ( is_array( $cached ) ) {
            return $cached;
        }
    }

    $product_ids        = dv_product_feed_get_product_ids();
    $product_count      = count( $product_ids );
    $sql_product_count  = count( dv_product_feed_get_product_ids_sql() );
    $sql_priced_count   = count( dv_product_feed_get_product_ids_sql( true ) );
    $feed_diag          = dv_product_feed_product_diagnostics( $product_ids );
    $xml            = dv_get_yml_product_feed_xml();
    $xml            = is_string( $xml ) ? $xml : '';
    $xml_valid      = false;
    $xml_error      = '';
    $offers_count   = substr_count( $xml, '<offer ' );
    $category_count = substr_count( $xml, '<category ' );
    $size_bytes     = strlen( $xml );

    if ( '' === trim( $xml ) ) {
        delete_transient( dv_product_feed_cache_key() );
    }

    if ( '' !== $xml && function_exists( 'simplexml_load_string' ) ) {
        $previous_errors = libxml_use_internal_errors( true );
        libxml_clear_errors();

        $parsed = simplexml_load_string( $xml );
        $errors = libxml_get_errors();
        $xml_valid = false !== $parsed;

        if ( ! $xml_valid && ! empty( $errors ) ) {
            $first_error = reset( $errors );
            if ( $first_error instanceof LibXMLError ) {
                $xml_error = trim( (string) $first_error->message );
            }
        }

        libxml_clear_errors();
        libxml_use_internal_errors( $previous_errors );
    } else {
        $xml_valid = '' !== $xml && false !== strpos( $xml, '<yml_catalog' ) && false !== strpos( $xml, '</yml_catalog>' );
        if ( '' === $xml ) {
            $xml_error = 'XML is empty.';
        }
    }

    if ( 0 === $product_count ) {
        $offers_hint = 'Нет опубликованных товаров';
    } elseif ( 0 === $offers_count ) {
        $offers_hint = sprintf(
            'Готово к фиду: %1$s из %2$s. Без цены: %3$s, без ссылки: %4$s, без фото: %5$s',
            number_format_i18n( absint( $feed_diag['ready'] ?? 0 ) ),
            number_format_i18n( $product_count ),
            number_format_i18n( absint( $feed_diag['empty_price'] ?? 0 ) ),
            number_format_i18n( absint( $feed_diag['empty_url'] ?? 0 ) ),
            number_format_i18n( absint( $feed_diag['missing_image'] ?? 0 ) )
        );
    } else {
        $offers_hint = number_format_i18n( $offers_count ) . ' офферов из ' . number_format_i18n( $product_count ) . ' товаров';
    }

    $checks = array(
        array(
            'key'    => 'available',
            'label'  => 'Фид доступен',
            'status' => '' !== $xml,
            'hint'   => '' !== $xml ? dv_product_feed_url() : 'Фид не сформирован',
        ),
        array(
            'key'    => 'xml_valid',
            'label'  => 'XML валиден',
            'status' => $xml_valid,
            'hint'   => $xml_valid ? 'Структура XML читается' : ( '' !== $xml_error ? $xml_error : 'XML не прошёл разбор' ),
        ),
        array(
            'key'    => 'offers',
            'label'  => 'Товары в фиде',
            'status' => $offers_count > 0,
            'hint'   => $offers_hint,
        ),
        array(
            'key'    => 'ready',
            'label'  => 'Готовы к выгрузке',
            'status' => absint( $feed_diag['ready'] ?? 0 ) > 0,
            'hint'   => sprintf(
                '%1$s готово, %2$s без цены, %3$s без фото, %4$s не читается',
                number_format_i18n( absint( $feed_diag['ready'] ?? 0 ) ),
                number_format_i18n( absint( $feed_diag['empty_price'] ?? 0 ) ),
                number_format_i18n( absint( $feed_diag['missing_image'] ?? 0 ) ),
                number_format_i18n( absint( $feed_diag['invalid'] ?? 0 ) )
            ),
        ),
        array(
            'key'    => 'database',
            'label'  => 'Товары в базе',
            'status' => $sql_product_count > 0,
            'hint'   => sprintf(
                '%1$s опубликовано, %2$s с ценой',
                number_format_i18n( $sql_product_count ),
                number_format_i18n( $sql_priced_count )
            ),
        ),
        array(
            'key'    => 'categories',
            'label'  => 'Категории',
            'status' => $category_count > 0,
            'hint'   => $category_count > 0 ? number_format_i18n( $category_count ) . ' категорий' : 'Нет категорий',
        ),
    );

    $flow = array(
        array(
            'key'     => 'database',
            'label'   => 'База',
            'value'   => $sql_product_count,
            'total'   => max( 1, $sql_product_count ),
            'status'  => $sql_product_count > 0,
            'caption' => 'Опубликованные product',
        ),
        array(
            'key'     => 'priced',
            'label'   => 'Цены',
            'value'   => $sql_priced_count,
            'total'   => max( 1, $sql_product_count ),
            'status'  => $sql_priced_count > 0,
            'caption' => '_price / _regular_price / _sale_price',
        ),
        array(
            'key'     => 'selected',
            'label'   => 'Отбор',
            'value'   => $product_count,
            'total'   => max( 1, $sql_product_count ),
            'status'  => $product_count > 0,
            'caption' => 'ID попали в сборщик',
        ),
        array(
            'key'     => 'ready',
            'label'   => 'Готово',
            'value'   => absint( $feed_diag['ready'] ?? 0 ),
            'total'   => max( 1, $product_count ),
            'status'  => absint( $feed_diag['ready'] ?? 0 ) > 0,
            'caption' => 'Есть цена, ссылка и фото',
        ),
        array(
            'key'     => 'offers',
            'label'   => 'Offer',
            'value'   => $offers_count,
            'total'   => max( 1, absint( $feed_diag['ready'] ?? 0 ) ),
            'status'  => $offers_count > 0,
            'caption' => 'Попали в XML',
        ),
        array(
            'key'     => 'xml',
            'label'   => 'XML',
            'value'   => $xml_valid && $size_bytes > 0 ? 1 : 0,
            'total'   => 1,
            'status'  => $xml_valid && $size_bytes > 0,
            'caption' => $size_bytes > 0 ? number_format_i18n( round( $size_bytes / 1024, 1 ), 1 ) . ' KB' : '0 KB',
        ),
    );

    $report = array(
        'report_version' => dv_product_feed_report_version(),
        'status'         => '' !== $xml && $xml_valid && $offers_count > 0 && $category_count > 0,
        'url'            => dv_product_feed_url(),
        'size_bytes'     => $size_bytes,
        'size_kb'        => $size_bytes > 0 ? round( $size_bytes / 1024, 1 ) : 0,
        'product_count'  => $product_count,
        'sql_product_count' => $sql_product_count,
        'sql_priced_count' => $sql_priced_count,
        'ready_count'    => absint( $feed_diag['ready'] ?? 0 ),
        'empty_price_count' => absint( $feed_diag['empty_price'] ?? 0 ),
        'invalid_product_count' => absint( $feed_diag['invalid'] ?? 0 ),
        'empty_url_count' => absint( $feed_diag['empty_url'] ?? 0 ),
        'missing_image_count' => absint( $feed_diag['missing_image'] ?? 0 ),
        'woocommerce_api' => function_exists( 'wc_get_product' ),
        'database_snapshot' => dv_product_feed_database_snapshot(),
        'sample_skips'   => isset( $feed_diag['sample_skips'] ) && is_array( $feed_diag['sample_skips'] ) ? $feed_diag['sample_skips'] : array(),
        'problem_samples' => dv_product_feed_problem_samples( $product_ids ),
        'offers_count'   => $offers_count,
        'category_count' => $category_count,
        'xml_valid'      => $xml_valid,
        'xml_error'      => $xml_error,
        'generated_at'   => time(),
        'generated_at_display' => date_i18n( 'd.m.Y H:i' ),
        'checks'         => $checks,
        'flow'           => $flow,
    );

    $report['problem_summary'] = dv_product_feed_problem_summary( $report );

    set_transient( $cache_key, $report, 10 * MINUTE_IN_SECONDS );

    return $report;
}

function dv_maybe_output_product_feed_xml() {
    if ( is_admin() ) {
        return;
    }

    $request_uri  = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
    $request_path = trim( (string) wp_parse_url( $request_uri, PHP_URL_PATH ), '/' );
    $request_path = strtolower( $request_path );

    if ( ! in_array( $request_path, array( 'yandex-market.xml', 'products.yml', 'yml.xml' ), true ) ) {
        return;
    }

    status_header( 200 );
    nocache_headers();
    header( 'Content-Type: application/xml; charset=UTF-8' );

    echo dv_get_yml_product_feed_xml(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    exit;
}
add_action( 'template_redirect', 'dv_maybe_output_product_feed_xml', 0 );

add_action( 'save_post_product', 'dv_clear_product_feed_cache' );
add_action( 'deleted_post', 'dv_clear_product_feed_cache' );
add_action( 'trashed_post', 'dv_clear_product_feed_cache' );
add_action( 'untrashed_post', 'dv_clear_product_feed_cache' );
add_action( 'updated_option_dv_store_profile', 'dv_clear_product_feed_cache' );
add_action( 'updated_option_dv_theme_options', 'dv_clear_product_feed_cache' );
add_action( 'updated_option_dv_theme_content', 'dv_clear_product_feed_cache' );
add_action( 'updated_option_dv_seo_settings', 'dv_clear_product_feed_cache' );
