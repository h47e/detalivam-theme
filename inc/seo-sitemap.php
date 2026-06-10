<?php
/**
 * XML sitemap builders loaded only for sitemap/admin requests.
 */
defined( 'ABSPATH' ) || exit;

function dv_sitemap_xml_escape( $value ) {
    return esc_xml( (string) $value );
}

function dv_sitemap_date( $date = '' ) {
    $timestamp = $date ? strtotime( (string) $date ) : false;
    if ( ! $timestamp ) {
        $timestamp = current_time( 'timestamp' );
    }

    return gmdate( 'Y-m-d', $timestamp );
}

function dv_normalize_sitemap_images( $images ) {
    $normalized = array();

    foreach ( (array) $images as $image ) {
        if ( is_string( $image ) ) {
            $image = array( 'loc' => $image );
        }

        if ( ! is_array( $image ) ) {
            continue;
        }

        $loc = esc_url_raw( $image['loc'] ?? '' );
        if ( '' === $loc ) {
            continue;
        }

        $normalized_image = array( 'loc' => $loc );

        foreach ( array( 'title', 'caption' ) as $key ) {
            $value = trim( wp_strip_all_tags( (string) ( $image[ $key ] ?? '' ) ) );
            if ( '' !== $value ) {
                $normalized_image[ $key ] = $value;
            }
        }

        $normalized[] = $normalized_image;
    }

    return $normalized;
}

function dv_sitemap_add_url( &$urls, $loc, $lastmod = '', $changefreq = 'weekly', $priority = '0.7', $images = array(), $type = 'page' ) {
    $loc = esc_url_raw( $loc );
    if ( '' === $loc || isset( $urls[ $loc ] ) ) {
        return;
    }

    $urls[ $loc ] = array(
        'loc'        => $loc,
        'type'       => sanitize_key( (string) $type ),
        'lastmod'    => dv_sitemap_date( $lastmod ),
        'changefreq' => $changefreq,
        'priority'   => $priority,
        'images'     => dv_normalize_sitemap_images( $images ),
    );
}

function dv_get_sitemap_product_images( $product_id ) {
    $product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : null;
    $title   = $product && function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : get_the_title( $product_id );
    $ids     = array_filter( array( get_post_thumbnail_id( $product_id ) ) );

    if ( $product instanceof WC_Product ) {
        $ids = array_merge( $ids, $product->get_gallery_image_ids() );
    }

    $ids = array_slice( array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) ), 0, 6 );
    if ( empty( $ids ) ) {
        return array();
    }

    $images = array();
    foreach ( $ids as $image_id ) {
        $image = wp_get_attachment_image_url( $image_id, 'full' );
        if ( ! $image ) {
            continue;
        }

        $alt     = trim( (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true ) );
        $caption = wp_get_attachment_caption( $image_id );
        $images[] = array(
            'loc'     => $image,
            'title'   => '' !== $alt ? $alt : $title,
            'caption' => '' !== trim( (string) $caption ) ? $caption : $title,
        );
    }

    return $images;
}

function dv_sitemap_service_page_date( $service_type ) {
    if ( ! function_exists( 'dv_virtual_service_page_map' ) ) {
        return '';
    }

    $pages = dv_virtual_service_page_map();
    $slug  = '';
    $template = '';

    foreach ( $pages as $page_slug => $page_data ) {
        if ( $service_type !== ( $page_data['type'] ?? '' ) ) {
            continue;
        }

        $slug     = (string) $page_slug;
        $template = (string) ( $page_data['template'] ?? '' );
        break;
    }

    if ( '' !== $slug ) {
        $page = get_page_by_path( $slug );
        if ( $page instanceof WP_Post ) {
            return get_post_modified_time( 'c', true, $page );
        }
    }

    if ( '' !== $template && file_exists( $template ) ) {
        return gmdate( 'c', (int) filemtime( $template ) );
    }

    return '';
}

function dv_sitemap_latest_product_date( $term_id = 0 ) {
    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'posts_per_page' => 1,
        'orderby'        => 'modified',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    );

    if ( $term_id ) {
        $args['tax_query'] = array(
            array(
                'taxonomy'         => 'product_cat',
                'field'            => 'term_id',
                'terms'            => array( absint( $term_id ) ),
                'include_children' => true,
            ),
        );
    }

    $query = new WP_Query( $args );
    $date  = '';

    if ( ! empty( $query->posts[0] ) ) {
        $date = get_post_modified_time( 'c', true, (int) $query->posts[0] );
    }

    wp_reset_postdata();

    return $date ?: current_time( 'mysql', true );
}

function dv_sitemap_product_tax_query() {
    $visibility_term_ids = function_exists( 'wc_get_product_visibility_term_ids' ) ? wc_get_product_visibility_term_ids() : array();
    $tax_query           = array();

    if ( ! empty( $visibility_term_ids['exclude-from-catalog'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'term_taxonomy_id',
            'terms'    => array( (int) $visibility_term_ids['exclude-from-catalog'] ),
            'operator' => 'NOT IN',
        );
    }

    return $tax_query;
}

function dv_build_sitemap_page_urls() {
    $urls        = array();
    $latest_date = dv_sitemap_latest_product_date();

    dv_sitemap_add_url( $urls, home_url( '/' ), $latest_date, 'daily', '1.0', array(), 'front' );

    if ( function_exists( 'wc_get_page_permalink' ) ) {
        $shop_url = wc_get_page_permalink( 'shop' );
        if ( $shop_url && ! is_wp_error( $shop_url ) ) {
            dv_sitemap_add_url( $urls, $shop_url, $latest_date, 'daily', '0.9', array(), 'shop' );
        }
    }

    if ( function_exists( 'dv_wholesale_page_url' ) ) {
        dv_sitemap_add_url( $urls, dv_wholesale_page_url(), $latest_date, 'weekly', '0.7', array(), 'page' );
    }

    if ( function_exists( 'dv_service_page_url' ) ) {
        foreach ( array( 'about', 'delivery', 'contacts', 'return', 'privacy', 'agreement' ) as $service_type ) {
            if ( function_exists( 'dv_service_page_enabled' ) && ! dv_service_page_enabled( $service_type ) ) {
                continue;
            }

            dv_sitemap_add_url( $urls, dv_service_page_url( $service_type ), dv_sitemap_service_page_date( $service_type ), 'monthly', '0.6', array(), 'service' );
        }

        if ( function_exists( 'dv_get_custom_service_pages' ) ) {
            foreach ( dv_get_custom_service_pages() as $custom_page ) {
                if ( empty( $custom_page['type'] ) ) {
                    continue;
                }

                dv_sitemap_add_url( $urls, dv_service_page_url( $custom_page['type'] ), current_time( 'mysql', true ), 'monthly', '0.6', array(), 'service' );
            }
        }
    }

    $system_page_ids = array_filter(
        array_map(
            'absint',
            array(
                function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0,
                function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'cart' ) : 0,
                function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'checkout' ) : 0,
                function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'myaccount' ) : 0,
            )
        )
    );

    $pages = get_posts(
        array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page' => 200,
            'orderby'        => 'modified',
            'order'          => 'DESC',
            'post__not_in'   => $system_page_ids,
        )
    );

    foreach ( $pages as $page ) {
        dv_sitemap_add_url( $urls, get_permalink( $page ), get_post_modified_time( 'c', true, $page ), 'monthly', '0.6', array(), 'page' );
    }

    return array_values( $urls );
}

function dv_build_sitemap_category_urls() {
    $urls  = array();
    $terms = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'orderby'    => 'name',
            'order'      => 'ASC',
        )
    );

    if ( ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            $term_link = get_term_link( $term );
            if ( is_wp_error( $term_link ) ) {
                continue;
            }

            $depth    = count( get_ancestors( $term->term_id, 'product_cat' ) );
            $priority = $depth > 1 ? '0.6' : ( $depth > 0 ? '0.7' : '0.8' );

            dv_sitemap_add_url( $urls, $term_link, dv_sitemap_latest_product_date( $term->term_id ), 'weekly', $priority, array(), 'category' );
        }
    }

    return array_values( $urls );
}

function dv_build_sitemap_product_urls() {
    $urls      = array();
    $tax_query = dv_sitemap_product_tax_query();

    $products = new WP_Query(
        array(
            'post_type'              => 'product',
            'post_status'            => 'publish',
            'posts_per_page'         => 45000,
            'orderby'                => 'modified',
            'order'                  => 'DESC',
            'fields'                 => 'ids',
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'tax_query'              => $tax_query,
        )
    );

    foreach ( $products->posts as $product_id ) {
        dv_sitemap_add_url(
            $urls,
            get_permalink( $product_id ),
            get_post_modified_time( 'c', true, $product_id ),
            'weekly',
            '0.7',
            dv_get_sitemap_product_images( $product_id ),
            'product'
        );
    }

    wp_reset_postdata();

    return array_values( $urls );
}

function dv_build_sitemap_urls() {
    $urls = array();

    foreach ( array_merge( dv_build_sitemap_page_urls(), dv_build_sitemap_category_urls(), dv_build_sitemap_product_urls() ) as $url ) {
        dv_sitemap_add_url(
            $urls,
            $url['loc'] ?? '',
            $url['lastmod'] ?? '',
            $url['changefreq'] ?? 'weekly',
            $url['priority'] ?? '0.7',
            $url['images'] ?? array(),
            $url['type'] ?? 'page'
        );
    }

    return array_values( $urls );
}

function dv_sitemap_group_paths() {
    return array(
        'products'   => 'sitemap-products.xml',
        'categories' => 'sitemap-categories.xml',
        'pages'      => 'sitemap-pages.xml',
    );
}

function dv_sitemap_url_matches_group( $url, $group ) {
    $type  = sanitize_key( (string) ( $url['type'] ?? 'page' ) );
    $group = sanitize_key( (string) $group );

    if ( 'products' === $group ) {
        return 'product' === $type;
    }

    if ( 'categories' === $group ) {
        return 'category' === $type;
    }

    if ( 'pages' === $group ) {
        return ! in_array( $type, array( 'product', 'category' ), true );
    }

    return true;
}

function dv_get_sitemap_urls_for_group( $group = '' ) {
    $group = sanitize_key( (string) $group );

    if ( 'products' === $group ) {
        return dv_build_sitemap_product_urls();
    }

    if ( 'categories' === $group ) {
        return dv_build_sitemap_category_urls();
    }

    if ( 'pages' === $group ) {
        return dv_build_sitemap_page_urls();
    }

    return dv_build_sitemap_urls();
}

function dv_render_sitemap_xml( $group = '' ) {
    $urls = dv_get_sitemap_urls_for_group( $group );

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

    foreach ( $urls as $url ) {
        echo "  <url>\n";
        echo '    <loc>' . dv_sitemap_xml_escape( $url['loc'] ) . "</loc>\n";
        echo '    <lastmod>' . dv_sitemap_xml_escape( $url['lastmod'] ) . "</lastmod>\n";
        echo '    <changefreq>' . dv_sitemap_xml_escape( $url['changefreq'] ) . "</changefreq>\n";
        echo '    <priority>' . dv_sitemap_xml_escape( $url['priority'] ) . "</priority>\n";
        foreach ( $url['images'] as $image ) {
            echo "    <image:image>\n";
            echo '      <image:loc>' . dv_sitemap_xml_escape( $image['loc'] ) . "</image:loc>\n";
            if ( ! empty( $image['title'] ) ) {
                echo '      <image:title>' . dv_sitemap_xml_escape( $image['title'] ) . "</image:title>\n";
            }
            if ( ! empty( $image['caption'] ) ) {
                echo '      <image:caption>' . dv_sitemap_xml_escape( $image['caption'] ) . "</image:caption>\n";
            }
            echo "    </image:image>\n";
        }
        echo "  </url>\n";
    }

    echo '</urlset>' . "\n";
}

function dv_get_sitemap_xml( $group = '' ) {
    $group     = sanitize_key( (string) $group );
    $cache_key = $group ? 'dv_sitemap_' . $group . '_xml_v3' : 'dv_sitemaps_xml_v9';
    $xml       = get_transient( $cache_key );

    if ( false !== $xml ) {
        return (string) $xml;
    }

    ob_start();
    dv_render_sitemap_xml( $group );
    $xml = (string) ob_get_clean();

    set_transient( $cache_key, $xml, 6 * HOUR_IN_SECONDS );

    return $xml;
}

function dv_render_sitemap_index_xml() {
    $lastmod = dv_sitemap_date( dv_sitemap_latest_product_date() );

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ( dv_sitemap_group_paths() as $path ) {
        echo "  <sitemap>\n";
        echo '    <loc>' . dv_sitemap_xml_escape( home_url( '/' . $path ) ) . "</loc>\n";
        echo '    <lastmod>' . dv_sitemap_xml_escape( $lastmod ) . "</lastmod>\n";
        echo "  </sitemap>\n";
    }
    echo '</sitemapindex>' . "\n";
}

function dv_get_sitemap_index_xml() {
    $cache_key = 'dv_sitemap_index_xml_v1';
    $xml       = get_transient( $cache_key );

    if ( false !== $xml ) {
        return (string) $xml;
    }

    ob_start();
    dv_render_sitemap_index_xml();
    $xml = (string) ob_get_clean();

    set_transient( $cache_key, $xml, 6 * HOUR_IN_SECONDS );

    return $xml;
}
