<?php
/**
 * ДеталиВам — вспомогательные функции шаблонов и карточек товаров.
 */
defined( 'ABSPATH' ) || exit;

function dv_get_nav( $location = 'primary' ) {
    return wp_nav_menu(
        array(
            'theme_location' => $location,
            'echo'           => false,
            'container'      => false,
            'items_wrap'     => '%3$s',
            'fallback_cb'    => false,
        )
    );
}

function dv_stock_label( $product ) {
    if ( ! $product ) {
        return '';
    }

    $labels = function_exists( 'dv_theme_labels' ) ? dv_theme_labels() : array();
    $stock = $product->get_stock_quantity();

    if ( $product->is_in_stock() ) {
        $class = $stock && $stock <= 5 ? 'low' : 'in';
        $label = 'low' === $class
            ? ( $labels['low_stock_with_qty'] ?? html_entity_decode( '&#1052;&#1072;&#1083;&#1086; &mdash; %s &#1096;&#1090;.', ENT_QUOTES, 'UTF-8' ) )
            : ( $labels['stock_in'] ?? html_entity_decode( '&#1042; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ) );

        if ( 'low' === $class ) {
            $label = sprintf( $label, $stock );
        }

        if ( $stock && 'in' === $class ) {
            $label .= ' — ' . $stock . ' шт.';
        }
    } else {
        $class = 'out';
        $label = $labels['stock_out'] ?? html_entity_decode( '&#1053;&#1077;&#1090; &#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' );
    }

    return sprintf(
        '<span class="stock-status %1$s"><span class="stock-status-dot"></span>%2$s</span>',
        esc_attr( $class ),
        esc_html( $label )
    );
}

function dv_render_stars( $rating, $count = 0 ) {
    $output = '<div class="stars">';

    for ( $i = 1; $i <= 5; $i++ ) {
        $output .= $i <= round( $rating )
            ? '<svg class="star-full" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>'
            : '<svg class="star-empty" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
    }

    $output .= '</div>';

    if ( $count ) {
        $output .= '<span class="rating-count">(' . absint( $count ) . ')</span>';
    }

    return $output;
}

if ( ! function_exists( 'dv_get_marketplaces' ) ) {
    function dv_get_marketplaces( $context = 'default' ) {
        $store    = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
        $ozon_url = esc_url_raw( $store['ozon_url'] ?? '' );
        $items    = array();

        $copy = array(
            'title'       => html_entity_decode( '&#1052;&#1099; &#1090;&#1072;&#1082;&#1078;&#1077; &#1087;&#1088;&#1086;&#1076;&#1072;&#1105;&#1084; &#1090;&#1086;&#1074;&#1072;&#1088;&#1099; &#1085;&#1072; Ozon', ENT_QUOTES, 'UTF-8' ),
            'description' => html_entity_decode( '&#1063;&#1072;&#1089;&#1090;&#1100; &#1072;&#1089;&#1089;&#1086;&#1088;&#1090;&#1080;&#1084;&#1077;&#1085;&#1090;&#1072; &#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084; &#1076;&#1086;&#1089;&#1090;&#1091;&#1087;&#1085;&#1072; &#1085;&#1072; &#1084;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089;&#1077; Ozon.', ENT_QUOTES, 'UTF-8' ),
        );

        if ( 'contacts' === $context ) {
            $copy = array(
                'title'       => html_entity_decode( '&#1052;&#1099; &#1077;&#1089;&#1090;&#1100; &#1085;&#1072; Ozon', ENT_QUOTES, 'UTF-8' ),
                'description' => html_entity_decode( '&#1063;&#1072;&#1089;&#1090;&#1100; &#1072;&#1089;&#1089;&#1086;&#1088;&#1090;&#1080;&#1084;&#1077;&#1085;&#1090;&#1072; &#1076;&#1086;&#1089;&#1090;&#1091;&#1087;&#1085;&#1072; &#1085;&#1072; &#1084;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089;&#1077;.', ENT_QUOTES, 'UTF-8' ),
            );
        }

        if ( $ozon_url ) {
            $items[] = array(
                'name'        => 'Ozon',
                'url'         => $ozon_url,
                'icon'        => function_exists( 'dv_get_ozon_icon_url' ) ? dv_get_ozon_icon_url() : get_template_directory_uri() . '/assets/ozon.png',
                'title'       => $copy['title'],
                'description' => $copy['description'],
            );
        }

        for ( $i = 2; $i <= 3; $i++ ) {
            $name = trim( (string) ( $store[ 'marketplace_' . $i . '_name' ] ?? '' ) );
            $url  = esc_url_raw( $store[ 'marketplace_' . $i . '_url' ] ?? '' );

            if ( '' === $name || '' === $url ) {
                continue;
            }

            $items[] = array(
                'name'        => $name,
                'url'         => $url,
                'icon'        => esc_url_raw( $store[ 'marketplace_' . $i . '_icon' ] ?? '' ),
                'title'       => sprintf( html_entity_decode( '&#1052;&#1099; &#1090;&#1072;&#1082;&#1078;&#1077; &#1077;&#1089;&#1090;&#1100; &#1085;&#1072; %s', ENT_QUOTES, 'UTF-8' ), $name ),
                'description' => html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1081;&#1090;&#1080; &#1082; &#1074;&#1080;&#1090;&#1088;&#1080;&#1085;&#1077; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072; &#1085;&#1072; &#1084;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089;&#1077;.', ENT_QUOTES, 'UTF-8' ),
            );
        }

        return $items;
    }
}

if ( ! function_exists( 'dv_render_marketplaces_row' ) ) {
    function dv_render_marketplaces_row( $args = array() ) {
        $args = wp_parse_args(
            $args,
            array(
                'context' => 'default',
                'class'   => '',
            )
        );

        $marketplaces = dv_get_marketplaces( (string) $args['context'] );

        if ( ! $marketplaces ) {
            return;
        }

        $classes = trim( 'service-marketplaces-row ' . (string) $args['class'] );
        ?>
        <div class="<?php echo esc_attr( $classes ); ?>" aria-label="<?php echo esc_attr( html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089;&#1099;', ENT_QUOTES, 'UTF-8' ) ); ?>">
            <?php foreach ( $marketplaces as $marketplace ) : ?>
                <a class="service-marketplace-note service-marketplace-note--<?php echo esc_attr( sanitize_html_class( strtolower( $marketplace['name'] ) ) ); ?>" href="<?php echo esc_url( $marketplace['url'] ); ?>" target="_blank" rel="noopener noreferrer nofollow sponsored">
                    <?php if ( ! empty( $marketplace['icon'] ) ) : ?>
                        <img src="<?php echo esc_url( $marketplace['icon'] ); ?>" alt="" width="24" height="24" loading="lazy" decoding="async" aria-hidden="true">
                    <?php endif; ?>
                    <span>
                        <strong><?php echo esc_html( $marketplace['title'] ); ?></strong>
                        <small><?php echo esc_html( $marketplace['description'] ); ?></small>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }
}

function dv_price_html( $product ) {
    if ( ! $product ) {
        return '';
    }

    $labels  = function_exists( 'dv_theme_labels' ) ? dv_theme_labels() : array();
    $regular = $product->get_regular_price();
    $sale    = $product->get_sale_price();
    $current = $product->is_on_sale() ? $sale : $regular;

    if ( '' === (string) $current ) {
        return '<div class="product-card-price"><span class="price-main">' . esc_html( $labels['price_request'] ?? html_entity_decode( '&#1062;&#1077;&#1085;&#1072; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091;', ENT_QUOTES, 'UTF-8' ) ) . '</span></div>';
    }

    $output  = '<div class="product-card-price">';
    $output .= '<span class="price-main">' . number_format( (float) $current, 0, '.', ' ' ) . ' ₽</span>';

    if ( $product->is_on_sale() && $regular ) {
        $output .= '<span class="price-old">' . number_format( (float) $regular, 0, '.', ' ' ) . ' ₽</span>';
        $percent = round( ( (float) $regular - (float) $sale ) / (float) $regular * 100 );
        $output .= '<span class="price-save">−' . absint( $percent ) . '%</span>';
    }

    $output .= '</div>';

    return $output;
}

function dv_is_product_in_cart( $product ) {
    if ( ! class_exists( 'WooCommerce' ) || ! WC()->cart ) {
        return false;
    }

    $product_id = $product instanceof WC_Product ? $product->get_id() : absint( $product );

    if ( ! $product_id ) {
        return false;
    }

    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $cart_product_id   = absint( $cart_item['product_id'] ?? 0 );
        $cart_variation_id = absint( $cart_item['variation_id'] ?? 0 );

        if ( $cart_product_id === $product_id || $cart_variation_id === $product_id ) {
            return true;
        }
    }

    return false;
}

function dv_get_cart_button_labels() {
    $labels = function_exists( 'dv_theme_labels' ) ? dv_theme_labels() : array();

    return array(
        'to_cart' => $labels['to_cart'] ?? html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1091;', ENT_QUOTES, 'UTF-8' ),
        'in_cart' => $labels['in_cart'] ?? html_entity_decode( '&#1042; &#1082;&#1086;&#1088;&#1079;&#1080;&#1085;&#1077;', ENT_QUOTES, 'UTF-8' ),
    );
}

function dv_compat_normalize_text( $text ) {
    $text = trim( wp_strip_all_tags( (string) $text ) );
    $text = preg_replace( '/\s+/u', ' ', $text );

    if ( function_exists( 'dv_seo_mb_strtolower' ) ) {
        return dv_seo_mb_strtolower( $text );
    }

    return function_exists( 'mb_strtolower' ) ? mb_strtolower( $text, 'UTF-8' ) : strtolower( $text );
}

function dv_is_compat_attribute_name( $name, $label = '' ) {
    $name     = dv_compat_normalize_text( $name );
    $label    = dv_compat_normalize_text( $label );
    $haystack = str_replace( array( '_', '-' ), ' ', $name . ' ' . $label );

    $blocked = array(
        'material',
        'материал',
        'country',
        'страна',
        'warranty',
        'гарантия',
        'thickness',
        'толщина',
        'color',
        'цвет',
        'quantity',
        'количество',
        'кол во',
        'komplekt',
        'комплектность',
    );

    foreach ( $blocked as $needle ) {
        if ( false !== strpos( $haystack, $needle ) ) {
            return false;
        }
    }

    $allowed = array(
        'compatibility',
        'compatible',
        'primenyaemost',
        'применяемость',
        'совместимость',
        'car brand',
        'car model',
        'model',
        'модель',
        'modelnyy ryad',
        'modelnyi ryad',
        'модельный ряд',
        'marka tc',
        'marka ts',
        'marka t s',
        'marka',
        'марка',
        'avto',
        'auto',
        'авто',
        'автомобиль',
    );

    foreach ( $allowed as $needle ) {
        if ( false !== strpos( $haystack, $needle ) ) {
            return true;
        }
    }

    return false;
}

function dv_is_compat_tag_value( $value ) {
    $raw = trim( wp_strip_all_tags( (string) $value ) );
    if ( '' === $raw ) {
        return false;
    }

    $normalized = dv_compat_normalize_text( $raw );
    $exact_blocked = array(
        'россия',
        'рф',
        'китай',
        'холоднокатаная сталь',
        'оцинкованная сталь',
        'сталь',
        'металл',
        'черный',
        'белый',
        'серый',
        'седан',
        'хэтчбек',
        'универсал',
        'внедорожник',
        'лифтбек',
        'купе',
        'новые',
        'уцененные',
    );

    if ( in_array( $normalized, $exact_blocked, true ) ) {
        return false;
    }

    if ( preg_match( '/^\d+\s*(?:год|года|лет)$/u', $normalized ) ) {
        return false;
    }

    if ( preg_match( '/^\d+\s*(?:шт|штук|комплект|комплекта|комплектов)$/u', $normalized ) ) {
        return false;
    }

    if ( preg_match( '/^\d+(?:[.,]\d+)?\s*(?:мм|mm|см|cm)?$/u', $normalized ) && ! preg_match( '/^(?:11|21|22|23)\d{2,3}$/', $normalized ) ) {
        return false;
    }

    return true;
}

function dv_add_compat_tag( &$tags, $value ) {
    $value = trim( wp_strip_all_tags( (string) $value ) );
    if ( '' === $value || ! dv_is_compat_tag_value( $value ) ) {
        return;
    }

    $tags[ dv_compat_normalize_text( $value ) ] = $value;
}

function dv_get_compat_tags( $product ) {
    if ( ! $product ) {
        return array();
    }

    $tags  = array();
    $attrs = $product->get_attributes();

    foreach ( $attrs as $attr ) {
        if ( ! $attr instanceof WC_Product_Attribute ) {
            continue;
        }

        $attribute_name  = $attr->get_name();
        $attribute_label = wc_attribute_label( $attribute_name );

        if ( ! dv_is_compat_attribute_name( $attribute_name, $attribute_label ) ) {
            continue;
        }

        if ( $attr->is_taxonomy() ) {
            $terms = $attr->get_terms();
            if ( empty( $terms ) || is_wp_error( $terms ) ) {
                continue;
            }

            foreach ( $terms as $term ) {
                dv_add_compat_tag( $tags, $term->name );
            }
            continue;
        }

        foreach ( (array) $attr->get_options() as $option ) {
            foreach ( array_filter( array_map( 'trim', explode( ',', (string) $option ) ) ) as $item ) {
                dv_add_compat_tag( $tags, $item );
            }
        }
    }

    $custom = get_post_meta( $product->get_id(), '_compatibility', true );
    if ( $custom ) {
        foreach ( explode( ',', $custom ) as $item ) {
            dv_add_compat_tag( $tags, $item );
        }
    }

    return array_values( $tags );
}

function dv_cat_icon( $slug ) {
    $map = array(
        'sistema-vypuska' => '<path d="M5 3h14M5 9h14M5 15h14M5 21h14"/>',
        'kuzovnye'        => '<rect x="2" y="7" width="20" height="12" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>',
        'podveska'        => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/>',
        'tormoza'         => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/>',
        'dvigatel'        => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>',
        'elektrika'       => '<polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>',
        'raskhodni'       => '<circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/>',
        'instrument'      => '<path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>',
    );

    return $map[ $slug ] ?? '<circle cx="12" cy="12" r="10"/>';
}

function dv_get_primary_product_cat( $product_id ) {
    $product_id = absint( $product_id );
    if ( ! $product_id ) {
        return null;
    }

    if ( class_exists( 'WPSEO_Primary_Term' ) ) {
        $primary = new WPSEO_Primary_Term( 'product_cat', $product_id );
        $term_id = absint( $primary->get_primary_term() );

        if ( $term_id ) {
            $term = get_term( $term_id, 'product_cat' );
            if ( $term && ! is_wp_error( $term ) ) {
                return $term;
            }
        }
    }

    $terms = wp_get_post_terms( $product_id, 'product_cat' );
    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        return null;
    }

    usort(
        $terms,
        function( $a, $b ) {
            return count( get_ancestors( $b->term_id, 'product_cat' ) ) <=> count( get_ancestors( $a->term_id, 'product_cat' ) );
        }
    );

    return $terms[0];
}

function dv_get_current_product_cat_path_ids() {
    $term = null;

    if ( is_product_category() ) {
        $queried = get_queried_object();
        if ( $queried instanceof WP_Term && 'product_cat' === $queried->taxonomy ) {
            $term = $queried;
        }
    } elseif ( is_product() ) {
        $term = dv_get_primary_product_cat( get_the_ID() );
    }

    if ( ! $term instanceof WP_Term ) {
        return array();
    }

    $ids = array_merge( get_ancestors( $term->term_id, 'product_cat' ), array( $term->term_id ) );

    return array_map( 'absint', $ids );
}

function dv_render_product_category_dropdown_branch( $parent_id, $children_map, $active_ids = array(), $depth = 0 ) {
    if ( empty( $children_map[ $parent_id ] ) ) {
        return '';
    }

    $html = '<ul class="dv-cat-tree depth-' . absint( $depth ) . '">';

    foreach ( $children_map[ $parent_id ] as $term ) {
        $child_html   = dv_render_product_category_dropdown_branch( $term->term_id, $children_map, $active_ids, $depth + 1 );
        $item_classes = array( 'dv-cat-tree-item' );
        $link_classes = array( 'dv-cat-tree-link' );

        if ( in_array( (int) $term->term_id, $active_ids, true ) ) {
            $item_classes[] = 'is-active';
            $link_classes[] = 'is-active';
        }

        if ( '' !== $child_html ) {
            $item_classes[] = 'has-children';
        }

        $html .= '<li class="' . esc_attr( implode( ' ', $item_classes ) ) . '">';
        $html .= '<a class="' . esc_attr( implode( ' ', $link_classes ) ) . '" href="' . esc_url( get_term_link( $term ) ) . '">';
        $html .= '<span class="dv-cat-tree-main">';
        $html .= '<span class="dv-cat-tree-name">' . esc_html( $term->name ) . '</span>';
        if ( '' !== $child_html ) {
            $html .= '<span class="dv-cat-tree-arrow" aria-hidden="true">&rsaquo;</span>';
        }
        $html .= '</span>';
        if ( 0 === $depth ) {
            $html .= '<span class="dv-cat-tree-count">' . absint( $term->count ) . '</span>';
        }
        $html .= '</a>';
        $html .= $child_html;
        $html .= '</li>';
    }

    $html .= '</ul>';

    return $html;
}

function dv_render_product_category_dropdown_subpanel( $parent_term, $children_map, $active_ids = array() ) {
    $children = $children_map[ $parent_term->term_id ] ?? array();

    if ( empty( $children ) ) {
        return '';
    }

    $html  = '<div class="dv-cat-subpanel">';
    $html .= '<div class="dv-cat-subpanel-head">';
    $html .= '<a class="dv-cat-subpanel-title" href="' . esc_url( get_term_link( $parent_term ) ) . '">' . esc_html( $parent_term->name ) . '</a>';
    $html .= '</div>';
    $html .= '<div class="dv-cat-subgroups">';

    foreach ( $children as $child ) {
        $grandchildren = $children_map[ $child->term_id ] ?? array();
        $group_classes = array( 'dv-cat-subgroup' );

        if ( in_array( (int) $child->term_id, $active_ids, true ) ) {
            $group_classes[] = 'is-active';
        }

        $html .= '<div class="' . esc_attr( implode( ' ', $group_classes ) ) . '">';
        $html .= '<a class="dv-cat-subgroup-title" href="' . esc_url( get_term_link( $child ) ) . '">' . esc_html( $child->name ) . '</a>';

        if ( ! empty( $grandchildren ) ) {
            $html .= '<div class="dv-cat-subgroup-links">';

            foreach ( $grandchildren as $grandchild ) {
                $tag_classes = array( 'dv-cat-subgroup-link' );
                if ( in_array( (int) $grandchild->term_id, $active_ids, true ) ) {
                    $tag_classes[] = 'is-active';
                }

                $html .= '<a class="' . esc_attr( implode( ' ', $tag_classes ) ) . '" href="' . esc_url( get_term_link( $grandchild ) ) . '">' . esc_html( $grandchild->name ) . '</a>';
            }

            $html .= '</div>';
        }

        $html .= '</div>';
    }

    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

function dv_render_product_category_dropdown_root( $children_map, $active_ids = array() ) {
    if ( empty( $children_map[0] ) ) {
        return '';
    }

    $html = '<ul class="dv-cat-root">';

    foreach ( $children_map[0] as $index => $term ) {
        $child_html   = dv_render_product_category_dropdown_subpanel( $term, $children_map, $active_ids );
        $item_classes = array( 'dv-cat-tree-item', 'dv-cat-root-item' );
        $link_classes = array( 'dv-cat-tree-link', 'dv-cat-root-link' );

        if ( in_array( (int) $term->term_id, $active_ids, true ) ) {
            $item_classes[] = 'is-active';
            $link_classes[] = 'is-active';
        }

        if ( '' !== $child_html ) {
            $item_classes[] = 'has-children';
        }

        if ( 0 === $index ) {
            $item_classes[] = 'is-default-open';
        }

        $html .= '<li class="' . esc_attr( implode( ' ', $item_classes ) ) . '">';
        $html .= '<a class="' . esc_attr( implode( ' ', $link_classes ) ) . '" href="' . esc_url( get_term_link( $term ) ) . '">';
        $html .= '<span class="dv-cat-tree-main">';
        $html .= '<span class="dv-cat-tree-name">' . esc_html( $term->name ) . '</span>';
        if ( '' !== $child_html ) {
            $html .= '<span class="dv-cat-tree-arrow" aria-hidden="true">&rsaquo;</span>';
        }
        $html .= '</span>';
        $html .= '<span class="dv-cat-tree-count">' . absint( $term->count ) . '</span>';
        $html .= '</a>';

        $html .= $child_html;

        $html .= '</li>';
    }

    $html .= '</ul>';

    return $html;
}

function dv_render_product_category_dropdown() {
    $terms = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'orderby'    => 'name',
            'order'      => 'ASC',
        )
    );

    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        return '';
    }

    $children_map = array();
    foreach ( $terms as $term ) {
        $parent = (int) $term->parent;
        if ( ! isset( $children_map[ $parent ] ) ) {
            $children_map[ $parent ] = array();
        }
        $children_map[ $parent ][] = $term;
    }

    $active_ids = dv_get_current_product_cat_path_ids();
    $shop_url   = function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/catalog/' );
    $labels     = function_exists( 'dv_theme_labels' ) ? dv_theme_labels() : array();
    $all_label  = $labels['go_catalog'] ?? html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1081;&#1090;&#1080; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;', ENT_QUOTES, 'UTF-8' );

    $html  = '<div class="dv-cat-dropdown-inner">';
    $html .= '<div class="dv-cat-dropdown-head">';
    $html .= '<span class="dv-cat-dropdown-title">' . esc_html__( 'Категории товаров', 'dv' ) . '</span>';
    $html .= '<a class="dv-cat-dropdown-all" href="' . esc_url( $shop_url ) . '">' . esc_html( $all_label ) . '</a>';
    $html .= '</div>';
    $html .= dv_render_product_category_dropdown_branch( 0, $children_map, $active_ids, 0 );
    $html .= '</div>';

    return $html;
}

function dv_get_product_brand_name( $product ) {
    if ( ! $product instanceof WC_Product ) {
        return '';
    }

    $attribute_candidates = array(
        'car_brand',
        'pa_brand',
        'pa_brend',
        'pa_manufacturer',
        'pa_proizvoditel',
    );

    foreach ( $attribute_candidates as $taxonomy ) {
        $value = trim( wp_strip_all_tags( (string) $product->get_attribute( $taxonomy ) ) );
        if ( '' !== $value ) {
            $parts = array_filter( array_map( 'trim', explode( ',', $value ) ) );
            return $parts ? reset( $parts ) : $value;
        }
    }

    $meta_candidates = array( '_brand', '_manufacturer', 'brand', 'manufacturer' );
    foreach ( $meta_candidates as $meta_key ) {
        $value = trim( wp_strip_all_tags( (string) get_post_meta( $product->get_id(), $meta_key, true ) ) );
        if ( '' !== $value ) {
            return $value;
        }
    }

    return '';
}

function dv_is_marka_attribute_name( $name, $label = '' ) {
    $name  = function_exists( 'dv_seo_mb_strtolower' ) ? dv_seo_mb_strtolower( trim( wp_strip_all_tags( (string) $name ) ) ) : strtolower( trim( wp_strip_all_tags( (string) $name ) ) );
    $label = function_exists( 'dv_seo_mb_strtolower' ) ? dv_seo_mb_strtolower( trim( wp_strip_all_tags( (string) $label ) ) ) : strtolower( trim( wp_strip_all_tags( (string) $label ) ) );
    $haystack = $name . ' ' . $label;

    foreach ( array( 'car_brand', 'marka', 'марка', 'бренд', 'brand' ) as $needle ) {
        if ( false !== strpos( $haystack, $needle ) ) {
            return true;
        }
    }

    return false;
}

function dv_get_product_marka_values( $product, $preferred_taxonomy = '' ) {
    if ( ! $product instanceof WC_Product ) {
        return array();
    }

    $values = array();
    $add_value = static function ( $name, $slug = '' ) use ( &$values ) {
        $name = trim( wp_strip_all_tags( (string) $name ) );
        $slug = '' !== $slug ? sanitize_title( $slug ) : sanitize_title( $name );

        if ( '' === $name || '' === $slug ) {
            return;
        }

        $values[ $slug ] = array(
            'name' => $name,
            'slug' => $slug,
        );
    };

    if ( '' !== $preferred_taxonomy && taxonomy_exists( $preferred_taxonomy ) ) {
        $terms = wp_get_post_terms( $product->get_id(), $preferred_taxonomy );
        if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
            foreach ( $terms as $term ) {
                $add_value( $term->name, $term->slug );
            }
        }
    }

    foreach ( $product->get_attributes() as $attribute ) {
        if ( ! $attribute instanceof WC_Product_Attribute ) {
            continue;
        }

        $attribute_name  = $attribute->get_name();
        $attribute_label = wc_attribute_label( $attribute_name );

        if ( ! dv_is_marka_attribute_name( $attribute_name, $attribute_label ) ) {
            continue;
        }

        if ( $attribute->is_taxonomy() ) {
            $terms = $attribute->get_terms();
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                foreach ( $terms as $term ) {
                    $add_value( $term->name, $term->slug );
                }
            }
            continue;
        }

        foreach ( (array) $attribute->get_options() as $option ) {
            foreach ( array_filter( array_map( 'trim', explode( ',', (string) $option ) ) ) as $item ) {
                $add_value( $item );
            }
        }
    }

    if ( empty( $values ) ) {
        $candidate_names = array_filter(
            array_unique(
                array(
                    $preferred_taxonomy,
                    'car_brand',
                    'pa_marka-tc',
                    'pa_marka_tc',
                    'pa_marka',
                    'pa_brand',
                )
            )
        );

        foreach ( $candidate_names as $candidate_name ) {
            $raw_value = trim( wp_strip_all_tags( (string) $product->get_attribute( $candidate_name ) ) );
            foreach ( array_filter( array_map( 'trim', explode( ',', $raw_value ) ) ) as $item ) {
                $add_value( $item );
            }
        }
    }

    if ( empty( $values ) ) {
        $brand_pattern = '/\b(LADA|ВАЗ|Renault|Daewoo|Chevrolet|Hyundai|KIA|Ravon|Opel|Volkswagen|Ford|Dacia|ZAZ|ГАЗ|ЗИЛ|Москвич)\b/iu';

        foreach ( $product->get_attributes() as $attribute ) {
            if ( ! $attribute instanceof WC_Product_Attribute ) {
                continue;
            }

            $raw_value = trim( wp_strip_all_tags( (string) $product->get_attribute( $attribute->get_name() ) ) );
            foreach ( array_filter( array_map( 'trim', explode( ',', $raw_value ) ) ) as $item ) {
                if ( preg_match( $brand_pattern, $item ) ) {
                    $add_value( $item );
                }
            }
        }
    }

    return array_values( $values );
}

function dv_get_product_offer_shipping_schema() {
    $store = dv_get_store_profile();

    $schema = array(
        '@type'               => 'OfferShippingDetails',
        'shippingDestination' => array(
            '@type'          => 'DefinedRegion',
            'addressCountry' => $store['country_code'] ?: 'RU',
        ),
    );

    if ( function_exists( 'dv_service_page_url' ) ) {
        $schema['url'] = dv_service_page_url( 'delivery' );
    }

    return $schema;
}

function dv_get_product_offer_return_policy_schema() {
    $store = dv_get_store_profile();

    $schema = array(
        '@type'                => 'MerchantReturnPolicy',
        'applicableCountry'    => $store['country_code'] ?: 'RU',
        'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
        'merchantReturnDays'   => 7,
        'returnMethod'         => 'https://schema.org/ReturnByMail',
        'returnFees'           => 'https://schema.org/ReturnShippingFees',
    );

    if ( function_exists( 'dv_service_page_url' ) ) {
        $schema['merchantReturnLink'] = dv_service_page_url( 'return' );
    }

    return $schema;
}

function dv_enhance_product_offer_schema( &$offer, $product ) {
    if ( ! is_array( $offer ) || ! $product instanceof WC_Product ) {
        return;
    }

    $store = dv_get_store_profile();

    $offer['url']           = $product->get_permalink();
    $offer['priceCurrency'] = get_woocommerce_currency();
    $offer['availability']  = 'https://schema.org/' . ( $product->is_in_stock() ? 'InStock' : 'OutOfStock' );
    $offer['itemCondition'] = 'https://schema.org/NewCondition';
    $offer['seller']        = array(
        '@id'   => $store['site_url'] . '#store',
        '@type' => 'Organization',
        'name'  => $store['name'],
        'url'   => $store['site_url'],
    );
    $offer['availableDeliveryMethod'] = array(
        'https://schema.org/OnSitePickup',
        'https://schema.org/ParcelService',
    );
    $offer['shippingDetails']         = dv_get_product_offer_shipping_schema();
    $offer['hasMerchantReturnPolicy'] = dv_get_product_offer_return_policy_schema();

    $price = $product->get_price();
    if ( '' !== (string) $price ) {
        $offer['price'] = wc_format_decimal( $price, 2 );
    }
}

function dv_enhance_woocommerce_product_schema( $markup, $product = null ) {
    if ( ! is_array( $markup ) || ! class_exists( 'WC_Product' ) || ! $product instanceof WC_Product ) {
        return $markup;
    }

    $markup['name'] = function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name();
    $markup['@id']  = $product->get_permalink() . '#product';
    $markup['mainEntityOfPage'] = array(
        '@type' => 'WebPage',
        '@id'   => $product->get_permalink(),
    );

    $description = $product->get_short_description();
    if ( '' === trim( wp_strip_all_tags( $description ) ) ) {
        $description = $product->get_description();
    }

    $description = dv_trim_seo_text( $description, 500 );
    if ( ! $description && function_exists( 'dv_build_product_seo_description' ) ) {
        $description = dv_build_product_seo_description( $product );
    }

    if ( $description ) {
        $markup['description'] = $description;
    }

    $markup['url'] = $product->get_permalink();

    $sku = function_exists( 'dv_get_product_seo_sku' ) ? dv_get_product_seo_sku( $product ) : trim( (string) $product->get_sku() );
    if ( '' !== $sku ) {
        $markup['sku'] = $sku;
        if ( empty( $markup['mpn'] ) ) {
            $markup['mpn'] = $sku;
        }
    }

    $brand = dv_get_product_brand_name( $product );
    if ( '' !== $brand ) {
        $markup['brand'] = array(
            '@type' => 'Brand',
            'name'  => $brand,
        );
    }

    $primary_cat = dv_get_primary_product_cat( $product->get_id() );
    if ( $primary_cat instanceof WP_Term ) {
        $markup['category'] = function_exists( 'dv_get_term_seo_display_name' ) ? dv_get_term_seo_display_name( $primary_cat ) : $primary_cat->name;
    }

    $image_ids = array_filter(
        array_merge(
            array( $product->get_image_id() ),
            $product->get_gallery_image_ids()
        )
    );

    $images = array();
    foreach ( array_unique( array_map( 'intval', $image_ids ) ) as $image_id ) {
        $image_url = wp_get_attachment_image_url( $image_id, 'dv-product-lg' );
        if ( $image_url ) {
            $images[] = $image_url;
        }
    }

    if ( ! empty( $images ) ) {
        $markup['image'] = $images;
    }

    if ( ! empty( $markup['offers'] ) ) {
        if ( isset( $markup['offers'][0] ) && is_array( $markup['offers'][0] ) ) {
            foreach ( $markup['offers'] as &$offer ) {
                dv_enhance_product_offer_schema( $offer, $product );
            }
            unset( $offer );
        } elseif ( is_array( $markup['offers'] ) ) {
            dv_enhance_product_offer_schema( $markup['offers'], $product );
        }
    } elseif ( '' !== (string) $product->get_price() ) {
        $store = dv_get_store_profile();

        $markup['offers'] = array(
            '@type'         => 'Offer',
            'url'           => $product->get_permalink(),
            'price'         => wc_format_decimal( $product->get_price(), 2 ),
            'priceCurrency' => get_woocommerce_currency(),
            'availability'  => 'https://schema.org/' . ( $product->is_in_stock() ? 'InStock' : 'OutOfStock' ),
            'itemCondition' => 'https://schema.org/NewCondition',
            'seller'        => array(
                '@id'   => $store['site_url'] . '#store',
                '@type' => 'Organization',
                'name'  => $store['name'],
                'url'   => $store['site_url'],
            ),
        );
    }

    if ( $product->managing_stock() && ! empty( $markup['offers'] ) ) {
        $stock_quantity = $product->get_stock_quantity();
        if ( null !== $stock_quantity ) {
            $inventory_level = array(
                '@type' => 'QuantitativeValue',
                'value' => max( 0, (int) $stock_quantity ),
            );

            if ( isset( $markup['offers'][0] ) && is_array( $markup['offers'][0] ) ) {
                foreach ( $markup['offers'] as &$offer ) {
                    if ( is_array( $offer ) ) {
                        $offer['inventoryLevel'] = $inventory_level;
                    }
                }
                unset( $offer );
            } elseif ( is_array( $markup['offers'] ) ) {
                $markup['offers']['inventoryLevel'] = $inventory_level;
            }
        }
    }

    return $markup;
}
add_filter( 'woocommerce_structured_data_product', 'dv_enhance_woocommerce_product_schema', 20, 2 );

function dv_normalize_product_spec_label( $label ) {
    $label = trim( wp_strip_all_tags( (string) $label ) );
    $label = preg_replace( '/\s+/u', ' ', $label );
    $label = trim( $label, " \t\n\r\0\x0B:-—" );

    return function_exists( 'dv_seo_mb_strtolower' ) ? dv_seo_mb_strtolower( $label ) : strtolower( $label );
}

function dv_product_description_spec_labels() {
    return array(
        'категория'               => 'Категория',
        'бренд'                   => 'Бренд',
        'материал'                => 'Материал',
        'внутренний диаметр, мм'  => 'Внутренний диаметр, мм',
        'внутренний диаметр'      => 'Внутренний диаметр, мм',
        'наружный диаметр, мм'    => 'Наружный диаметр, мм',
        'наружный диаметр'        => 'Наружный диаметр, мм',
        'внешний диаметр, мм'     => 'Внешний диаметр, мм',
        'внешний диаметр'         => 'Внешний диаметр, мм',
        'вид техники'             => 'Вид техники',
        'цвет товара'             => 'Цвет товара',
        'страна-изготовитель'     => 'Страна-изготовитель',
        'гарантийный срок'        => 'Гарантийный срок',
        'количество, штук'        => 'Количество, штук',
        'количество'              => 'Количество, штук',
        'вес'                     => 'Вес',
        'sku'                     => 'SKU',
        'марка тс'                => 'Марка ТС',
        'модель'                  => 'Модель',
        'oem номер'               => 'OEM номер',
        'применяемость'           => 'Применяемость',
    );
}

function dv_extract_product_spec_from_html_node( $html, &$rows ) {
    $known = dv_product_description_spec_labels();
    $text  = trim( preg_replace( '/\s+/u', ' ', html_entity_decode( wp_strip_all_tags( (string) $html ), ENT_QUOTES, 'UTF-8' ) ) );

    if ( ! preg_match( '/^(.{2,80}?):\s*(.+)$/u', $text, $matches ) ) {
        return false;
    }

    $key = dv_normalize_product_spec_label( $matches[1] );
    if ( ! isset( $known[ $key ] ) ) {
        return false;
    }

    $value = trim( $matches[2] );
    if ( '' === $value ) {
        return false;
    }

    if ( ! isset( $rows[ $key ] ) ) {
        $rows[ $key ] = array(
            'label' => $known[ $key ],
            'value' => $value,
        );
    }

    return true;
}

function dv_split_product_description_specs( $description_html ) {
    $rows = array();
    $html = (string) $description_html;

    $html = preg_replace_callback(
        '/<li\b[^>]*>(.*?)<\/li>/isu',
        static function ( $matches ) use ( &$rows ) {
            return dv_extract_product_spec_from_html_node( $matches[1], $rows ) ? '' : $matches[0];
        },
        $html
    );

    $html = preg_replace_callback(
        '/<p\b[^>]*>(.*?)<\/p>/isu',
        static function ( $matches ) use ( &$rows ) {
            return dv_extract_product_spec_from_html_node( $matches[1], $rows ) ? '' : $matches[0];
        },
        $html
    );

    $html = preg_replace( '/<(ul|ol)\b[^>]*>\s*<\/\1>/isu', '', $html );
    $html = trim( (string) $html );

    return array(
        'description' => $html,
        'specs'       => array_values( $rows ),
    );
}

function dv_add_product_spec_row( &$rows, $label, $value ) {
    $label = trim( wp_strip_all_tags( (string) $label ) );
    $value = trim( wp_strip_all_tags( is_array( $value ) ? implode( ', ', $value ) : (string) $value ) );

    if ( '' === $label || '' === $value ) {
        return;
    }

    $key = dv_normalize_product_spec_label( $label );
    if ( isset( $rows[ $key ] ) ) {
        return;
    }

    $rows[ $key ] = array(
        'label' => $label,
        'value' => $value,
    );
}

function dv_get_product_specs_for_tabs( $product, $description_specs = array() ) {
    if ( ! $product instanceof WC_Product ) {
        return array();
    }

    $rows = array();

    foreach ( (array) $description_specs as $row ) {
        dv_add_product_spec_row( $rows, $row['label'] ?? '', $row['value'] ?? '' );
    }

    foreach ( $product->get_attributes() as $attribute ) {
        if ( ! $attribute instanceof WC_Product_Attribute ) {
            continue;
        }

        $label = wc_attribute_label( $attribute->get_name() );
        $value = trim( wp_strip_all_tags( (string) $product->get_attribute( $attribute->get_name() ) ) );

        if ( '' === $value ) {
            $options = $attribute->get_options();
            $value   = is_array( $options ) ? implode( ', ', array_map( 'strval', $options ) ) : (string) $options;
        }

        dv_add_product_spec_row( $rows, $label, $value );
    }

    if ( $product->get_weight() ) {
        dv_add_product_spec_row( $rows, 'Вес', $product->get_weight() . ' кг' );
    }

    if ( $product->get_dimensions() ) {
        dv_add_product_spec_row( $rows, 'Размеры (Д×Ш×В)', $product->get_dimensions() . ' см' );
    }

    return array_values( $rows );
}

function dv_normalize_product_title_text( $title ) {
    $title = html_entity_decode( wp_strip_all_tags( (string) $title ), ENT_QUOTES, 'UTF-8' );
    $title = str_replace( array( "\xc2\xa0", '&nbsp;' ), ' ', $title );
    $title = trim( preg_replace( '/\s+/u', ' ', $title ) );

    if ( '' === $title ) {
        return '';
    }

    $title = preg_replace( '/\s*;\s*/u', ', ', $title );
    $title = preg_replace( '/\(\s*(левая\s+и\s+правая|правая\s+и\s+левая|левый\s+и\s+правый|правый\s+и\s+левый)\s*\)/iu', '$1', $title );
    $title = preg_replace( '/\bдля\s+автомобил(?:ей|я)\s+/iu', 'для ', $title );

    if ( 0 !== mb_strpos( $title, 'КОМПЛЕКТ', 0, 'UTF-8' ) ) {
        $title = str_replace( 'КОМПЛЕКТ', 'комплект', $title );
    }

    $title = preg_replace( '/\s+([,.:])/u', '$1', $title );
    $title = preg_replace( '/,\s*/u', ', ', $title );
    $title = preg_replace( '/\s{2,}/u', ' ', $title );
    $title = preg_replace( '/(?<![,])\s+комплект$/u', ', комплект', $title );
    $title = preg_replace( '/,\s*комплект,\s*комплект$/u', ', комплект', $title );

    return trim( $title, " \t\n\r\0\x0B," );
}

function dv_get_product_display_name( $product_or_id, $fallback = '' ) {
    if ( $product_or_id instanceof WC_Product ) {
        return dv_normalize_product_title_text( $product_or_id->get_name() );
    }

    if ( is_numeric( $product_or_id ) ) {
        return dv_normalize_product_title_text( get_the_title( (int) $product_or_id ) );
    }

    if ( is_string( $product_or_id ) && '' !== $product_or_id ) {
        return dv_normalize_product_title_text( $product_or_id );
    }

    return dv_normalize_product_title_text( $fallback );
}

function dv_split_product_description_sentences( $text ) {
    $text = trim( preg_replace( '/\s+/u', ' ', (string) $text ) );

    if ( '' === $text ) {
        return array();
    }

    $sentences = preg_split( '/(?<=[.!?])\s+(?=[А-ЯA-ZЁ0-9])/u', $text, -1, PREG_SPLIT_NO_EMPTY );

    if ( empty( $sentences ) ) {
        return array( $text );
    }

    return array_values(
        array_filter(
            array_map( 'trim', $sentences ),
            static function ( $sentence ) {
                return '' !== $sentence;
            }
        )
    );
}

function dv_split_product_description_dash_points( $text ) {
    $text = trim( (string) $text );

    if ( '' === $text || ! preg_match( '/\s[—–-]\s/u', $text ) ) {
        return array(
            'intro' => $text,
            'items' => array(),
        );
    }

    $parts = preg_split( '/\s+[—–-]\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY );

    if ( false === $parts || count( $parts ) < 2 ) {
        return array(
            'intro' => $text,
            'items' => array(),
        );
    }

    $intro = trim( array_shift( $parts ) );
    $items = array();

    foreach ( $parts as $part ) {
        $item = trim( preg_replace( '/\s+/u', ' ', (string) $part ) );
        $item = trim( $item, " \t\n\r\0\x0B;.,-" );

        if ( '' !== $item ) {
            $items[] = $item;
        }
    }

    if ( count( $items ) < 2 ) {
        return array(
            'intro' => $text,
            'items' => array(),
        );
    }

    return array(
        'intro' => $intro,
        'items' => $items,
    );
}

function dv_format_product_description_html( $description_html, $context = 'full' ) {
    $description_html = (string) $description_html;

    if ( '' === trim( wp_strip_all_tags( $description_html ) ) ) {
        return '';
    }

    if ( false !== strpos( $description_html, 'dv-formatted-description' ) ) {
        return $description_html;
    }

    $prepared = preg_replace( '/<(br|\/p|\/li|\/h[1-6])\b[^>]*>/iu', "\n", $description_html );
    $text     = html_entity_decode( wp_strip_all_tags( (string) $prepared ), ENT_QUOTES, 'UTF-8' );
    $text     = trim( preg_replace( '/[ \t]+/u', ' ', preg_replace( '/\R+/u', "\n", $text ) ) );

    if ( '' === $text ) {
        return $description_html;
    }

    $important = '';
    if ( preg_match( '/(?:^|\s)(Важно):\s*(.+)$/ui', $text, $matches ) ) {
        $important = trim( $matches[2] );
        $text      = trim( str_replace( $matches[0], '', $text ) );
    }

    $facts      = array();
    $kit_items  = array();
    $points     = array();
    $paragraphs = array();

    foreach ( dv_split_product_description_sentences( $text ) as $sentence ) {
        $dash_points = dv_split_product_description_dash_points( $sentence );
        if ( ! empty( $dash_points['items'] ) ) {
            if ( '' !== $dash_points['intro'] ) {
                $paragraphs[] = $dash_points['intro'];
            }

            $points = array_merge( $points, $dash_points['items'] );
            continue;
        }

        if ( preg_match( '/^([^:]{3,56}):\s*(.+)$/u', $sentence, $matches ) ) {
            $label = trim( $matches[1] );
            $value = trim( $matches[2] );

            if ( preg_match( '/комплектац/iu', $label ) ) {
                $kit_items = array_merge(
                    $kit_items,
                    array_filter(
                        array_map( 'trim', preg_split( '/,\s*/u', $value ) ),
                        static function ( $item ) {
                            return '' !== $item;
                        }
                    )
                );
            } else {
                $facts[] = array(
                    'label' => $label,
                    'value' => $value,
                );
            }

            continue;
        }

        $paragraphs[] = $sentence;
    }

    if ( 'summary' === $context && count( $paragraphs ) > 2 ) {
        $paragraphs = array_slice( $paragraphs, 0, 2 );
    }

    if ( 'summary' === $context && count( $points ) > 4 ) {
        $points = array_slice( $points, 0, 4 );
    }

    ob_start();
    ?>
    <div class="dv-formatted-description dv-formatted-description--<?php echo esc_attr( $context ); ?>">
        <?php if ( ! empty( $paragraphs ) ) : ?>
            <div class="dv-formatted-copy">
                <?php foreach ( $paragraphs as $paragraph ) : ?>
                    <p><?php echo esc_html( $paragraph ); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $points ) ) : ?>
            <ul class="dv-formatted-points">
                <?php foreach ( $points as $point ) : ?>
                    <li><?php echo esc_html( $point ); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ( ! empty( $facts ) ) : ?>
            <dl class="dv-formatted-facts">
                <?php foreach ( $facts as $fact ) : ?>
                    <div>
                        <dt><?php echo esc_html( $fact['label'] ); ?></dt>
                        <dd><?php echo esc_html( $fact['value'] ); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        <?php endif; ?>

        <?php if ( ! empty( $kit_items ) && 'summary' !== $context ) : ?>
            <div class="dv-formatted-kit">
                <strong>Комплектация</strong>
                <ul>
                    <?php foreach ( $kit_items as $item ) : ?>
                        <li><?php echo esc_html( $item ); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ( '' !== $important ) : ?>
            <div class="dv-formatted-callout">
                <strong>Важно</strong>
                <p><?php echo esc_html( $important ); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php

    return trim( ob_get_clean() );
}

function dv_format_product_short_description( $description ) {
    if ( is_admin() || ! function_exists( 'is_product' ) || ! is_product() ) {
        return $description;
    }

    return dv_format_product_description_html( $description, 'summary' );
}
add_filter( 'woocommerce_short_description', 'dv_format_product_short_description', 20 );

function dv_get_term_trail( $term, $taxonomy ) {
    if ( is_numeric( $term ) ) {
        $term = get_term( (int) $term, $taxonomy );
    }

    if ( ! $term || is_wp_error( $term ) ) {
        return array();
    }

    $trail        = array();
    $ancestor_ids = array_reverse( get_ancestors( $term->term_id, $taxonomy ) );

    foreach ( $ancestor_ids as $ancestor_id ) {
        $ancestor = get_term( $ancestor_id, $taxonomy );
        if ( $ancestor && ! is_wp_error( $ancestor ) ) {
            $trail[] = $ancestor;
        }
    }

    $trail[] = $term;

    return $trail;
}

function dv_get_product_section_cache_version() {
    $version = (int) get_option( 'dv_product_section_cache_version', 1 );

    if ( $version < 1 ) {
        $version = 1;
        update_option( 'dv_product_section_cache_version', $version, false );
    }

    return $version;
}

function dv_product_section_cache_key( $suffix ) {
    return 'dv_product_section_' . dv_get_product_section_cache_version() . '_' . md5( (string) $suffix );
}

function dv_flush_product_section_cache() {
    update_option( 'dv_product_section_cache_version', time(), false );
}
add_action( 'save_post_product', 'dv_flush_product_section_cache' );
add_action( 'deleted_post', 'dv_flush_product_section_cache' );
add_action( 'created_product_cat', 'dv_flush_product_section_cache' );
add_action( 'edited_product_cat', 'dv_flush_product_section_cache' );
add_action( 'delete_product_cat', 'dv_flush_product_section_cache' );
add_action( 'woocommerce_update_product', 'dv_flush_product_section_cache' );

function dv_get_catalog_recommendation_products( $limit = 3 ) {
    if ( ! function_exists( 'wc_get_products' ) || ! function_exists( 'wc_get_product' ) ) {
        return array();
    }

    $limit     = max( 1, (int) $limit );
    $cache_key = dv_product_section_cache_key( 'catalog_recs|' . $limit );
    $ids       = get_transient( $cache_key );

    if ( ! is_array( $ids ) ) {
        $ids = wc_get_products(
            array(
                'limit'      => $limit,
                'status'     => 'publish',
                'visibility' => 'catalog',
                'orderby'    => 'popularity',
                'return'     => 'ids',
            )
        );

        $ids = array_values( array_filter( array_map( 'absint', (array) $ids ) ) );
        set_transient( $cache_key, $ids, 6 * HOUR_IN_SECONDS );
    }

    $products = array();

    foreach ( array_slice( $ids, 0, $limit ) as $product_id ) {
        $product = wc_get_product( $product_id );

        if ( $product && $product->is_visible() ) {
            $products[] = $product;
        }
    }

    return $products;
}

function dv_get_recently_viewed_product_ids( $exclude_id = 0, $limit = 8 ) {
    $raw = sanitize_text_field( wp_unslash( $_COOKIE['dv_recently_viewed'] ?? '' ) );
    $ids = array_values( array_filter( array_map( 'absint', explode( ',', $raw ) ) ) );

    if ( $exclude_id ) {
        $ids = array_values(
            array_filter(
                $ids,
                function( $product_id ) use ( $exclude_id ) {
                    return (int) $product_id !== (int) $exclude_id;
                }
            )
        );
    }

    $visible_ids = array();

    foreach ( $ids as $product_id ) {
        $product = wc_get_product( $product_id );
        if ( ! $product || ! $product->is_visible() ) {
            continue;
        }

        $visible_ids[] = $product_id;
    }

    return array_slice( array_values( array_unique( $visible_ids ) ), 0, max( 1, (int) $limit ) );
}

function dv_track_recently_viewed_product() {
    if ( is_admin() || ! function_exists( 'is_product' ) || ! is_product() ) {
        return;
    }

    $product_id = get_queried_object_id();
    if ( ! $product_id ) {
        return;
    }

    $existing = dv_get_recently_viewed_product_ids( 0, 12 );
    $updated  = array_values( array_unique( array_merge( array( (int) $product_id ), $existing ) ) );
    $updated  = array_slice( $updated, 0, 12 );

    if ( function_exists( 'wc_setcookie' ) ) {
        wc_setcookie( 'dv_recently_viewed', implode( ',', $updated ), time() + MONTH_IN_SECONDS );
    } else {
        setcookie( 'dv_recently_viewed', implode( ',', $updated ), time() + MONTH_IN_SECONDS, '/' );
    }
}
add_action( 'template_redirect', 'dv_track_recently_viewed_product' );

function dv_get_similar_product_ids( $product_id, $exclude_ids = array(), $limit = 4 ) {
    $product_id   = absint( $product_id );
    $limit        = max( 1, (int) $limit );
    $exclude_ids  = array_values( array_unique( array_filter( array_map( 'absint', (array) $exclude_ids ) ) ) );
    sort( $exclude_ids );
    $cache_key    = dv_product_section_cache_key( 'similar|' . $product_id . '|' . $limit . '|' . implode( ',', $exclude_ids ) );
    $cached_ids   = get_transient( $cache_key );

    if ( is_array( $cached_ids ) ) {
        return array_slice( array_values( array_filter( array_map( 'absint', $cached_ids ) ) ), 0, $limit );
    }

    $base_product = wc_get_product( $product_id );

    if ( ! $base_product ) {
        return array();
    }

    $similar_ids = array();
    $upsells     = array_values( array_filter( array_map( 'absint', (array) $base_product->get_upsell_ids() ) ) );

    foreach ( $upsells as $upsell_id ) {
        $upsell_product = wc_get_product( $upsell_id );
        if ( ! $upsell_product || ! $upsell_product->is_visible() || in_array( $upsell_id, $exclude_ids, true ) ) {
            continue;
        }

        $similar_ids[] = $upsell_id;
    }

    if ( count( $similar_ids ) >= $limit ) {
        $similar_ids = array_slice( array_values( array_unique( $similar_ids ) ), 0, $limit );
        set_transient( $cache_key, $similar_ids, 6 * HOUR_IN_SECONDS );

        return $similar_ids;
    }

    $term_ids = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'ids' ) );
    if ( empty( $term_ids ) || is_wp_error( $term_ids ) ) {
        $similar_ids = array_slice( array_values( array_unique( $similar_ids ) ), 0, $limit );
        set_transient( $cache_key, $similar_ids, 6 * HOUR_IN_SECONDS );

        return $similar_ids;
    }

    $query = new WP_Query(
        array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'posts_per_page'      => max( $limit * 2, 8 ),
            'post__not_in'        => array_merge( array( $product_id ), $exclude_ids, $similar_ids ),
            'fields'              => 'ids',
            'ignore_sticky_posts' => true,
            'tax_query'           => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                ),
            ),
        )
    );

    foreach ( (array) $query->posts as $candidate_id ) {
        $candidate = wc_get_product( $candidate_id );
        if ( ! $candidate || ! $candidate->is_visible() ) {
            continue;
        }

        $similar_ids[] = (int) $candidate_id;

        if ( count( $similar_ids ) >= $limit ) {
            break;
        }
    }

    $similar_ids = array_slice( array_values( array_unique( $similar_ids ) ), 0, $limit );
    set_transient( $cache_key, $similar_ids, 6 * HOUR_IN_SECONDS );

    return $similar_ids;
}

function dv_render_product_section( $title, $product_ids, $section_class = '' ) {
    $product_ids = array_values( array_filter( array_map( 'absint', (array) $product_ids ) ) );

    if ( empty( $product_ids ) ) {
        return;
    }

    $class_name = 'related-shell';
    if ( $section_class ) {
        $class_name .= ' ' . sanitize_html_class( $section_class );
    }
    ?>
    <div class="<?php echo esc_attr( $class_name ); ?>">
        <div class="related-head">
            <div class="related-title"><?php echo esc_html( $title ); ?></div>
        </div>
        <div class="related-body">
            <div class="woocommerce">
                <ul class="products">
                    <?php
                    foreach ( $product_ids as $product_id ) {
                        $loop_product = wc_get_product( $product_id );
                        if ( ! $loop_product || ! $loop_product->is_visible() ) {
                            continue;
                        }

                        global $post;
                        $post = get_post( $product_id );
                        if ( ! $post ) {
                            continue;
                        }

                        setup_postdata( $post );
                        wc_get_template_part( 'content', 'product' );
                    }
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
}
