<?php
defined( 'ABSPATH' ) || exit;

function dv_seo_labels() {
    return array(
        'price_range'             => html_entity_decode( '&#8381;&#8381;', ENT_QUOTES, 'UTF-8' ),
        'ellipsis'                => html_entity_decode( '&hellip;', ENT_QUOTES, 'UTF-8' ),
        'buy_in_store'            => html_entity_decode( '&#1050;&#1091;&#1087;&#1080;&#1090;&#1100; %1$s &#1074; %2$s &#1074; &#1080;&#1085;&#1090;&#1077;&#1088;&#1085;&#1077;&#1090;-&#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1077; %3$s', ENT_QUOTES, 'UTF-8' ),
        'product_sku'             => '%s',
        'price_from'              => html_entity_decode( '&#1094;&#1077;&#1085;&#1072; &#1086;&#1090; %s', ENT_QUOTES, 'UTF-8' ),
        'brand'                   => html_entity_decode( '&#1073;&#1088;&#1077;&#1085;&#1076; %s', ENT_QUOTES, 'UTF-8' ),
        'stock_in'                => html_entity_decode( '&#1090;&#1086;&#1074;&#1072;&#1088; &#1074; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'stock_order'             => html_entity_decode( '&#1076;&#1086;&#1089;&#1090;&#1091;&#1087;&#1077;&#1085; &#1087;&#1086;&#1076; &#1079;&#1072;&#1082;&#1072;&#1079;', ENT_QUOTES, 'UTF-8' ),
        'pickup_delivery_region'  => html_entity_decode( '&#1089;&#1072;&#1084;&#1086;&#1074;&#1099;&#1074;&#1086;&#1079; &#1080; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072; &#1087;&#1086; &#1056;&#1086;&#1089;&#1089;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'buy_city_pickup'         => html_entity_decode( '%1$s &#1050;&#1091;&#1087;&#1080;&#1090;&#1100; &#1074; %2$s &#1089; &#1089;&#1072;&#1084;&#1086;&#1074;&#1099;&#1074;&#1086;&#1079;&#1086;&#1084; &#1080; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1086;&#1081; &#1074; &#1080;&#1085;&#1090;&#1077;&#1088;&#1085;&#1077;&#1090;-&#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1077; %3$s.', ENT_QUOTES, 'UTF-8' ),
        'term_buy_city'           => html_entity_decode( '%1$s &#1082;&#1091;&#1087;&#1080;&#1090;&#1100; &#1074; %2$s &mdash; &#1094;&#1077;&#1085;&#1099;, &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077; &#1080; &#1087;&#1086;&#1076;&#1073;&#1086;&#1088; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1077; &#1080;&#1085;&#1090;&#1077;&#1088;&#1085;&#1077;&#1090;-&#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072; %3$s.', ENT_QUOTES, 'UTF-8' ),
        'catalog_city_desc'       => html_entity_decode( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; &#1074; %1$s: &#1082;&#1091;&#1079;&#1086;&#1074;&#1085;&#1099;&#1077; &#1076;&#1077;&#1090;&#1072;&#1083;&#1080;, &#1089;&#1080;&#1089;&#1090;&#1077;&#1084;&#1072; &#1074;&#1099;&#1087;&#1091;&#1089;&#1082;&#1072;, &#1087;&#1086;&#1076;&#1074;&#1077;&#1089;&#1082;&#1072; &#1080; &#1076;&#1074;&#1080;&#1075;&#1072;&#1090;&#1077;&#1083;&#1100;. &#1062;&#1077;&#1085;&#1099;, &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;, &#1089;&#1072;&#1084;&#1086;&#1074;&#1099;&#1074;&#1086;&#1079; &#1080; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072;.', ENT_QUOTES, 'UTF-8' ),
        'search_results_desc'     => html_entity_decode( '&#1056;&#1077;&#1079;&#1091;&#1083;&#1100;&#1090;&#1072;&#1090;&#1099; &#1087;&#1086;&#1080;&#1089;&#1082;&#1072; &#1087;&#1086; &#1079;&#1072;&#1087;&#1088;&#1086;&#1089;&#1091; &laquo;%1$s&raquo; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1077; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; %2$s. &#1062;&#1077;&#1085;&#1099;, &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077; &#1080; &#1087;&#1086;&#1076;&#1073;&#1086;&#1088; &#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; &#1074; %3$s.', ENT_QUOTES, 'UTF-8' ),
        'front_desc'              => html_entity_decode( '&#1048;&#1085;&#1090;&#1077;&#1088;&#1085;&#1077;&#1090;-&#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; %1$s: &#1082;&#1091;&#1087;&#1080;&#1090;&#1100; &#1082;&#1091;&#1079;&#1086;&#1074;&#1085;&#1099;&#1077; &#1076;&#1077;&#1090;&#1072;&#1083;&#1080; &#1080; &#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1080; &#1089;&#1080;&#1089;&#1090;&#1077;&#1084;&#1099; &#1074;&#1099;&#1087;&#1091;&#1089;&#1082;&#1072; &#1074; %2$s. &#1062;&#1077;&#1085;&#1099;, &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;, &#1089;&#1072;&#1084;&#1086;&#1074;&#1099;&#1074;&#1086;&#1079; &#1080; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072; &#1087;&#1086; &#1056;&#1086;&#1089;&#1089;&#1080;&#1080;.', ENT_QUOTES, 'UTF-8' ),
        'contacts_desc'           => html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099; &#1080;&#1085;&#1090;&#1077;&#1088;&#1085;&#1077;&#1090;-&#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; %1$s &#1074; %2$s: &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085; %3$s, &#1072;&#1076;&#1088;&#1077;&#1089;, &#1075;&#1088;&#1072;&#1092;&#1080;&#1082; &#1088;&#1072;&#1073;&#1086;&#1090;&#1099;, &#1089;&#1072;&#1084;&#1086;&#1074;&#1099;&#1074;&#1086;&#1079; &#1080; &#1082;&#1086;&#1085;&#1089;&#1091;&#1083;&#1100;&#1090;&#1072;&#1094;&#1080;&#1103; &#1087;&#1086; &#1087;&#1086;&#1076;&#1073;&#1086;&#1088;&#1091; &#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081;.', ENT_QUOTES, 'UTF-8' ),
        'about_desc'              => 'О компании %1$s: интернет-магазин автозапчастей в %2$s, подбор деталей, наличие, самовывоз и доставка по России.',
        'delivery_desc'           => 'Доставка автозапчастей %1$s по России: условия отправки, самовывоз в %2$s, согласование сроков и стоимости доставки с менеджером.',
        'return_desc'             => 'Возврат товара в интернет-магазине %1$s: условия обмена и возврата автозапчастей, порядок обращения и контакты магазина в %2$s.',
        'privacy_desc'            => 'Политика конфиденциальности %1$s: порядок обработки персональных данных пользователей сайта и контактная информация оператора.',
        'agreement_desc'          => 'Пользовательское соглашение %1$s: правила использования сайта, оформления заказов, доставки, оплаты и возврата товаров.',
        'default_desc'            => html_entity_decode( '&#1048;&#1085;&#1090;&#1077;&#1088;&#1085;&#1077;&#1090;-&#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; %1$s: &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;, &#1087;&#1086;&#1076;&#1073;&#1086;&#1088;, &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1077; &#1080; &#1079;&#1072;&#1082;&#1072;&#1079; &#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; &#1074; %2$s.', ENT_QUOTES, 'UTF-8' ),
        'paged_suffix'            => html_entity_decode( '&mdash; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1072; %d', ENT_QUOTES, 'UTF-8' ),
        'product_title'           => html_entity_decode( '%1$s &mdash; &#1082;&#1091;&#1087;&#1080;&#1090;&#1100; &#1086;&#1085;&#1083;&#1072;&#1081;&#1085;', ENT_QUOTES, 'UTF-8' ),
        'product_title_sku'       => '%1$s, %2$s — купить онлайн',
        'product_title_price'     => html_entity_decode( ', &#1094;&#1077;&#1085;&#1072; %s', ENT_QUOTES, 'UTF-8' ),
        'term_title'              => html_entity_decode( '%1$s &mdash; &#1082;&#1091;&#1087;&#1080;&#1090;&#1100; &#1074; %2$s, &#1094;&#1077;&#1085;&#1099; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;&#1077;%3$s | %4$s', ENT_QUOTES, 'UTF-8' ),
        'term_desc_no_count'      => '%1$s в %2$s: цены, наличие, подбор по марке авто, самовывоз и доставка по России в магазине %3$s.',
        'term_desc_with_intro'    => '%1$s В разделе %2$s: цены, наличие, подбор по марке авто и доставка по России.',
        'product_desc_category'   => 'раздел %s',
        'product_desc_compat'     => 'совместимость: %s',
        'catalog_title'           => html_entity_decode( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; &#1074; %1$s &mdash; &#1094;&#1077;&#1085;&#1099; &#1080; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077;%2$s | %3$s', ENT_QUOTES, 'UTF-8' ),
        'front_title'             => html_entity_decode( '&#1040;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1080; &#1080; &#1082;&#1091;&#1079;&#1086;&#1074;&#1085;&#1099;&#1077; &#1076;&#1077;&#1090;&#1072;&#1083;&#1080; &#1074; %1$s &mdash; &#1082;&#1091;&#1087;&#1080;&#1090;&#1100; &#1086;&#1085;&#1083;&#1072;&#1081;&#1085; | %2$s', ENT_QUOTES, 'UTF-8' ),
        'search_title'            => html_entity_decode( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081;: %1$s%2$s | %3$s', ENT_QUOTES, 'UTF-8' ),
        'contacts_title'          => html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1077;&#1081; &#1074; %1$s | %2$s', ENT_QUOTES, 'UTF-8' ),
        'about_title'             => html_entity_decode( '&#1054; &#1082;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1080; %1$s &mdash; &#1072;&#1074;&#1090;&#1086;&#1079;&#1072;&#1087;&#1095;&#1072;&#1089;&#1090;&#1080; &#1074; %2$s', ENT_QUOTES, 'UTF-8' ),
        'delivery_title'          => 'Доставка автозапчастей по России | %s',
        'return_title'            => 'Возврат товара | %s',
        'privacy_title'           => 'Политика конфиденциальности | %s',
        'agreement_title'         => 'Пользовательское соглашение | %s',
        'home'                    => html_entity_decode( '&#1043;&#1083;&#1072;&#1074;&#1085;&#1072;&#1103;', ENT_QUOTES, 'UTF-8' ),
        'catalog'                 => html_entity_decode( '&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;', ENT_QUOTES, 'UTF-8' ),
        'search_label'            => html_entity_decode( '&#1055;&#1086;&#1080;&#1089;&#1082;: %s', ENT_QUOTES, 'UTF-8' ),
    );
}

function dv_schema() {
    if ( is_admin() ) {
        return;
    }
    $labels  = dv_seo_labels();
    $store   = dv_get_store_profile();
    $logo    = dv_get_schema_logo_url();
    $same_as = array_values(
        array_filter(
            array(
                $store['ozon_url'] ?? '',
                $store['marketplace_2_url'] ?? '',
                $store['marketplace_3_url'] ?? '',
            )
        )
    );

    $store_schema = array(
        '@context'           => 'https://schema.org',
        '@type'              => 'AutoPartsStore',
        '@id'                => $store['site_url'] . '#store',
        'name'               => $store['name'],
        'url'                => $store['site_url'],
        'logo'               => $logo,
        'image'              => $logo,
        'telephone'          => $store['phone'],
        'email'              => $store['email'],
        'priceRange'         => $labels['price_range'],
        'currenciesAccepted' => $store['currency'],
        'paymentAccepted'    => array( 'cash', 'bank card', 'online payment' ),
        'areaServed'         => array(
            array(
                '@type' => 'City',
                'name'  => $store['city'],
            ),
            array(
                '@type' => 'AdministrativeArea',
                'name'  => $store['region'],
            ),
            array(
                '@type' => 'Country',
                'name'  => $store['country_name'],
            ),
        ),
        'address'            => array(
            '@type'           => 'PostalAddress',
            'addressLocality' => $store['city'],
            'addressRegion'   => $store['region'],
            'addressCountry'  => $store['country_code'],
        ),
        'contactPoint'       => array(
            '@type'             => 'ContactPoint',
            'telephone'         => $store['phone'],
            'contactType'       => 'customer support',
            'areaServed'        => $store['country_code'],
            'availableLanguage' => array( 'ru' ),
        ),
        'openingHoursSpecification' => array(
            array(
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
                'opens'     => $store['opens'],
                'closes'    => $store['closes'],
            ),
        ),
    );

    if ( ! empty( $same_as ) ) {
        $store_schema['sameAs'] = $same_as;
    }
    ?>
    <script type="application/ld+json"><?php echo wp_json_encode( $store_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
<?php
}
add_action( 'wp_head', 'dv_schema' );

function dv_output_website_schema() {
    if ( is_admin() || dv_has_seo_plugin() ) {
        return;
    }
    $store = dv_get_store_profile();
    ?>
    <script type="application/ld+json"><?php echo wp_json_encode( array(
        '@context'        => 'https://schema.org',
        '@type'           => 'WebSite',
        '@id'             => $store['site_url'] . '#website',
        'name'            => $store['name'],
        'url'             => $store['site_url'],
        'inLanguage'      => 'ru-RU',
        'publisher'       => array(
            '@id' => $store['site_url'] . '#store',
        ),
        'potentialAction' => array(
            '@type'       => 'SearchAction',
            'target'      => home_url( '/?s={search_term_string}&post_type=product' ),
            'query-input' => 'required name=search_term_string',
        ),
    ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>
    <?php
}
add_action( 'wp_head', 'dv_output_website_schema', 5 );

function dv_has_seo_plugin() {
    return defined( 'WPSEO_VERSION' )
        || defined( 'RANK_MATH_VERSION' )
        || defined( 'AIOSEO_VERSION' )
        || defined( 'SEOPRESS_VERSION' )
        || class_exists( 'The_SEO_Framework\\Load' );
}

function dv_get_schema_logo_url() {
    if ( function_exists( 'dv_get_theme_logo_url' ) ) {
        return dv_get_theme_logo_url();
    }

    $custom_logo_id = (int) get_theme_mod( 'custom_logo' );
    if ( $custom_logo_id ) {
        $logo = wp_get_attachment_image_url( $custom_logo_id, 'full' );
        if ( $logo ) {
            return $logo;
        }
    }

    return function_exists( 'dv_get_theme_logo_url' ) ? dv_get_theme_logo_url() : DV_URI . '/assets/logo.png';
}

function dv_seo_mb_strlen( $text ) {
    return function_exists( 'mb_strlen' ) ? mb_strlen( (string) $text, 'UTF-8' ) : strlen( (string) $text );
}

function dv_seo_mb_substr( $text, $start, $length = null ) {
    $text  = (string) $text;
    $start = (int) $start;

    if ( function_exists( 'mb_substr' ) ) {
        return null === $length ? mb_substr( $text, $start, null, 'UTF-8' ) : mb_substr( $text, $start, (int) $length, 'UTF-8' );
    }

    return null === $length ? substr( $text, $start ) : substr( $text, $start, (int) $length );
}

function dv_seo_mb_strtolower( $text ) {
    $text = (string) $text;

    if ( function_exists( 'mb_strtolower' ) ) {
        return mb_strtolower( $text, 'UTF-8' );
    }

    return strtolower( $text );
}

function dv_seo_mb_stripos( $haystack, $needle, $offset = 0 ) {
    $haystack = (string) $haystack;
    $needle   = (string) $needle;
    $offset   = (int) $offset;

    if ( function_exists( 'mb_stripos' ) ) {
        return mb_stripos( $haystack, $needle, $offset, 'UTF-8' );
    }

    return stripos( $haystack, $needle, $offset );
}

function dv_trim_seo_text( $text, $limit = 160 ) {
    $labels = dv_seo_labels();
    $text   = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $text ) ) );

    if ( '' === $text ) {
        return '';
    }

    if ( dv_seo_mb_strlen( $text ) <= $limit ) {
        return $text;
    }

    return rtrim( dv_seo_mb_substr( $text, 0, $limit - 1 ), " \t\n\r\0\x0B.,;:-" ) . $labels['ellipsis'];
}

function dv_get_current_request_url() {
    $request_uri = wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' );
    $request_uri = strtok( $request_uri, '#' );

    return home_url( $request_uri ?: '/' );
}

function dv_is_seo_tracking_query_key( $key ) {
    $key = strtolower( (string) $key );

    return 0 === strpos( $key, 'utm_' )
        || in_array( $key, array( 'yclid', 'ymclid', 'gclid', 'fbclid', 'openstat', 'from' ), true );
}

function dv_is_seo_indexing_noise_query_key( $key ) {
    $key = strtolower( (string) $key );

    if ( 0 === strpos( $key, 'filter_' ) || 0 === strpos( $key, 'pa_' ) || 0 === strpos( $key, 'wpf_' ) ) {
        return true;
    }

    return in_array(
        $key,
        array(
            'add-to-cart',
            'orderby',
            'product-page',
            'product_count',
            'product_order',
            'product_orderby',
            'rating_filter',
            'marka',
            'stock',
            'min_price',
            'max_price',
        ),
        true
    );
}

function dv_request_has_indexing_noise_params() {
    foreach ( array_keys( $_GET ) as $key ) {
        if ( dv_is_seo_indexing_noise_query_key( $key ) ) {
            return true;
        }
    }

    return false;
}

function dv_get_clean_current_request_url() {
    $request_uri = wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' );
    $request_uri = strtok( $request_uri, '#' );
    $path        = wp_parse_url( $request_uri, PHP_URL_PATH );
    $query       = wp_parse_url( $request_uri, PHP_URL_QUERY );
    $url         = home_url( $path ?: '/' );

    if ( ! $query ) {
        return $url;
    }

    $query_args = array();
    parse_str( $query, $query_args );

    foreach ( array_keys( $query_args ) as $key ) {
        if ( dv_is_seo_tracking_query_key( $key ) || dv_is_seo_indexing_noise_query_key( $key ) ) {
            unset( $query_args[ $key ] );
        }
    }

    return empty( $query_args ) ? $url : add_query_arg( $query_args, $url );
}

function dv_get_seo_canonical_url() {
    if ( function_exists( 'dv_is_wholesale_request' ) && dv_is_wholesale_request() && function_exists( 'dv_wholesale_page_url' ) ) {
        return dv_wholesale_page_url();
    }

    if ( is_front_page() || is_home() ) {
        return home_url( '/' );
    }

    $virtual_service_type = (string) get_query_var( 'dv_virtual_page' );
    if ( '' !== $virtual_service_type && function_exists( 'dv_service_page_url' ) ) {
        return dv_service_page_url( $virtual_service_type );
    }

    if ( is_singular() ) {
        return get_permalink();
    }

    if ( is_product_category() || is_tax() ) {
        $term = get_queried_object();
        if ( $term instanceof WP_Term ) {
            $paged     = max( 1, (int) get_query_var( 'paged' ) );
            $term_link = get_term_link( $term );

            if ( ! is_wp_error( $term_link ) ) {
                return $paged > 1 ? get_pagenum_link( $paged ) : $term_link;
            }
        }
    }

    if ( is_post_type_archive( 'product' ) ) {
        $paged = max( 1, (int) get_query_var( 'paged' ) );
        return $paged > 1 ? get_pagenum_link( $paged ) : wc_get_page_permalink( 'shop' );
    }

    return dv_get_clean_current_request_url();
}

function dv_get_seo_shop_name() {
    $store = dv_get_store_profile();
    return $store['name'];
}

function dv_get_seo_city_name() {
    $store = dv_get_store_profile();
    return $store['city'];
}

function dv_is_service_page_type( $type, $slugs = array() ) {
    $virtual_type = (string) get_query_var( 'dv_virtual_page' );

    return $type === $virtual_type || is_page( (array) $slugs );
}

function dv_is_contacts_page() {
    return dv_is_service_page_type( 'contacts', array( 'kontakty', 'contacts' ) );
}

function dv_is_about_page() {
    return dv_is_service_page_type( 'about', array( 'o-kompanii', 'about' ) );
}

function dv_is_delivery_page() {
    return dv_is_service_page_type( 'delivery', array( 'dostavka', 'delivery' ) );
}

function dv_is_return_page() {
    return dv_is_service_page_type( 'return', array( 'vozvrat', 'return' ) );
}

function dv_is_privacy_page() {
    return dv_is_service_page_type( 'privacy', array( 'politika-konfidencialnosti', 'privacy-policy' ) );
}

function dv_is_agreement_page() {
    return dv_is_service_page_type( 'agreement', array( 'polzovatelskoe-soglashenie', 'publichna-oferta', 'user-agreement' ) );
}

function dv_get_product_seo_title_override( $product_id ) {
    return trim( (string) get_post_meta( $product_id, '_dv_seo_title', true ) );
}

function dv_get_product_seo_description_override( $product_id ) {
    return trim( (string) get_post_meta( $product_id, '_dv_seo_description', true ) );
}

function dv_get_term_seo_title_override( $term_id ) {
    return trim( (string) get_term_meta( $term_id, '_dv_seo_title', true ) );
}

function dv_get_term_seo_description_override( $term_id ) {
    return trim( (string) get_term_meta( $term_id, '_dv_seo_description', true ) );
}

function dv_get_term_seo_h1_override( $term_id ) {
    return trim( (string) get_term_meta( $term_id, '_dv_seo_h1', true ) );
}

function dv_get_term_seo_intro( $term_id ) {
    return trim( (string) get_term_meta( $term_id, '_dv_seo_intro', true ) );
}

function dv_get_term_seo_text( $term_id ) {
    return trim( (string) get_term_meta( $term_id, '_dv_seo_text', true ) );
}

function dv_get_term_seo_faq( $term_id ) {
    $faq = get_term_meta( $term_id, '_dv_seo_faq', true );
    if ( ! is_array( $faq ) ) {
        return array();
    }

    $items = array();
    foreach ( $faq as $item ) {
        $question = trim( wp_strip_all_tags( (string) ( $item['question'] ?? '' ) ) );
        $answer   = trim( wp_strip_all_tags( (string) ( $item['answer'] ?? '' ) ) );

        if ( '' === $question || '' === $answer ) {
            continue;
        }

        $items[] = array(
            'question' => $question,
            'answer'   => $answer,
        );
    }

    return $items;
}

function dv_get_term_seo_display_name( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $name  = trim( (string) $term->name );
    $trail = function_exists( 'dv_get_term_trail' ) ? dv_get_term_trail( $term, 'product_cat' ) : array();

    if ( count( $trail ) < 2 ) {
        return $name;
    }

    $parent = $trail[ count( $trail ) - 2 ];
    if ( ! $parent instanceof WP_Term || '' === trim( (string) $parent->name ) ) {
        return $name;
    }

    $parent_name = trim( (string) $parent->name );
    if ( false !== dv_seo_mb_stripos( $name, $parent_name ) ) {
        return $name;
    }

    return $name . ' (' . $parent_name . ')';
}

function dv_get_term_seo_phrase( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $name        = trim( (string) $term->name );
    $trail       = function_exists( 'dv_get_term_trail' ) ? dv_get_term_trail( $term, 'product_cat' ) : array();
    $trail_names = array();

    foreach ( $trail as $trail_term ) {
        if ( $trail_term instanceof WP_Term ) {
            $trail_names[] = trim( (string) $trail_term->name );
        }
    }

    $context = dv_seo_mb_strtolower( trim( implode( ' ', array_filter( $trail_names ) ) . ' ' . $name ) );
    $name_lc = dv_seo_mb_strtolower( $name );
    $phrase  = $name;

    if ( false !== dv_seo_mb_stripos( $name_lc, 'двери панели дверей ремчасти' ) ) {
        $phrase = 'Двери, панели и ремчасти дверей ВАЗ';
    } elseif ( false !== dv_seo_mb_stripos( $name_lc, 'пороги и полы' ) ) {
        $phrase = 'Пороги и элементы пола ВАЗ';
    } elseif ( false !== dv_seo_mb_stripos( $name_lc, 'лонжероны брызговики стойки кронштейны опоры' ) ) {
        $phrase = 'Лонжероны, стойки и опоры кузова ВАЗ';
    } elseif ( false !== dv_seo_mb_stripos( $name_lc, 'крыло заднее арки' ) ) {
        $phrase = 'Задние крылья, арки и боковины ВАЗ';
    } elseif ( false !== dv_seo_mb_stripos( $name_lc, 'крыло переднее ремчасти' ) ) {
        $phrase = 'Передние крылья и ремчасти ВАЗ';
    } elseif ( false !== dv_seo_mb_stripos( $context, 'фланец глушителя трубы ремонтные' ) ) {
        $phrase = 'Фланцы глушителя и ремкомплекты системы выпуска ВАЗ';
    } elseif ( preg_match( '/ремкомплект/u', $context ) && preg_match( '/глушител/u', $context ) ) {
        $phrase = 'Ремкомплекты глушителя ВАЗ';
    } elseif ( preg_match( '/фланц/u', $context ) && preg_match( '/глушител/u', $context ) ) {
        $phrase = 'Фланцы глушителя ВАЗ';
    } elseif ( preg_match( '/гофр/u', $context ) && preg_match( '/глушител/u', $context ) ) {
        $phrase = 'Гофры глушителя ВАЗ';
    } elseif ( preg_match( '/хомут/u', $context ) && preg_match( '/глушител/u', $context ) ) {
        $phrase = 'Хомуты глушителя ВАЗ';
    } elseif ( preg_match( '/резонатор/u', $context ) ) {
        $phrase = 'Резонаторы глушителя ВАЗ';
    } elseif ( preg_match( '/труб/u', $context ) && preg_match( '/выхлоп|глушител|ремонтн/u', $context ) ) {
        $phrase = 'Ремонтные трубы глушителя ВАЗ';
    } elseif ( preg_match( '/двер/u', $context ) && preg_match( '/панел/u', $context ) ) {
        $phrase = 'Панели дверей ВАЗ';
    } elseif ( preg_match( '/двер/u', $context ) && preg_match( '/ремчаст|ремонт/u', $context ) ) {
        $phrase = 'Ремчасти дверей ВАЗ';
    } elseif ( preg_match( '/панел/u', $context ) && preg_match( '/радиатор/u', $context ) ) {
        $phrase = 'Панели радиатора ВАЗ';
    } elseif ( preg_match( '/кронштейн/u', $context ) && preg_match( '/бампер/u', $context ) ) {
        $phrase = 'Кронштейны бампера ВАЗ';
    } elseif ( preg_match( '/опор/u', $context ) ) {
        $phrase = 'Опоры кузова ВАЗ';
    } elseif ( false !== dv_seo_mb_stripos( $context, 'арки' ) && preg_match( '/задн/u', $context ) ) {
        $phrase = 'Арки задних крыльев ВАЗ';
    } elseif ( false !== dv_seo_mb_stripos( $context, 'арки' ) && preg_match( '/передн/u', $context ) ) {
        $phrase = 'Арки передних крыльев ВАЗ';
    } elseif ( preg_match( '/крыл[оья].*задн|задн.*крыл/u', $context ) ) {
        $phrase = 'Задние крылья ВАЗ';
    } elseif ( preg_match( '/крыл[оья].*передн|передн.*крыл/u', $context ) ) {
        $phrase = 'Передние крылья ВАЗ';
    } elseif ( preg_match( '/порог/u', $context ) ) {
        $phrase = 'Пороги кузова ВАЗ';
    } elseif ( preg_match( '/полы|пола|днищ/u', $context ) ) {
        $phrase = 'Панели пола и днища ВАЗ';
    } elseif ( preg_match( '/лонжерон/u', $context ) ) {
        $phrase = 'Лонжероны ВАЗ';
    } elseif ( preg_match( '/брызговик/u', $context ) ) {
        $phrase = 'Брызговики ВАЗ';
    } elseif ( preg_match( '/стойк/u', $context ) ) {
        $phrase = 'Стойки кузова ВАЗ';
    } elseif ( preg_match( '/глушител|резонатор|гофр|фланец|хомут|выхлоп|труб/u', $context ) ) {
        $phrase = preg_match( '/(^|[^\p{L}\p{N}])(ваз|lada|vaz)([^\p{L}\p{N}]|$)/ui', $name ) ? $name : $name . ' для ВАЗ';
    }

    if ( ! preg_match( '/(^|[^\p{L}\p{N}])(ваз|lada|vaz|газ|уаз|renault|chevrolet|hyundai|kia|nissan)([^\p{L}\p{N}]|$)/ui', $phrase ) ) {
        $phrase .= ' ВАЗ';
    }

    $phrase = preg_replace( '/\s+/u', ' ', $phrase );
    $phrase = preg_replace( '/\s+для\s+ВАЗ\s+ВАЗ$/u', ' для ВАЗ', $phrase );

    return trim( $phrase );
}

function dv_build_term_auto_seo_h1( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $phrase = dv_get_term_seo_phrase( $term );
    if ( '' === $phrase ) {
        return $term->name;
    }

    return $phrase;
}

function dv_build_term_seo_h1( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $custom_h1 = dv_get_term_seo_h1_override( $term->term_id );
    if ( '' !== $custom_h1 ) {
        return $custom_h1;
    }

    return dv_build_term_auto_seo_h1( $term );
}

function dv_build_term_seo_intro( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $phrase = dv_get_term_seo_phrase( $term );
    if ( '' === $phrase ) {
        $phrase = $term->name;
    }

    return sprintf(
        '%1$s: подбор по модели авто, стороне установки и артикулу. Есть наличие в %2$s, самовывоз и доставка по России.',
        $phrase,
        dv_get_seo_city_name()
    );
}

function dv_get_term_effective_seo_intro( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $manual_intro = dv_get_term_seo_intro( $term->term_id );
    if ( '' !== $manual_intro ) {
        return $manual_intro;
    }

    $description = trim( wp_strip_all_tags( term_description( $term, 'product_cat' ) ) );
    if ( '' !== $description ) {
        return term_description( $term, 'product_cat' );
    }

    return dv_build_term_seo_intro( $term );
}

function dv_build_term_seo_text( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $phrase = dv_get_term_seo_phrase( $term );
    if ( '' === $phrase ) {
        $phrase = $term->name;
    }

    return sprintf(
        '<p>В разделе «%1$s» собраны позиции для ремонта и восстановления автомобиля. Перед заказом проверьте модельный ряд, сторону установки, размеры, материал и номер детали — это снижает риск ошибки при подборе.</p><p>Если есть сомнения по совместимости, можно ориентироваться на фото, артикул, SKU и описание товара. Для сложных кузовных деталей особенно важно сверить левую и правую сторону, год выпуска и конструктивные отличия автомобиля.</p><p>Заказ можно забрать самовывозом в %2$s или оформить доставку по России. Мы стараемся держать актуальные остатки и помогать с подбором, чтобы покупатель быстрее нашёл подходящую деталь.</p>',
        esc_html( $phrase ),
        esc_html( dv_get_seo_city_name() )
    );
}

function dv_get_term_effective_seo_text( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $manual_text = dv_get_term_seo_text( $term->term_id );
    if ( '' !== $manual_text ) {
        return $manual_text;
    }

    return dv_build_term_seo_text( $term );
}

function dv_build_term_default_faq( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return array();
    }

    $phrase = dv_get_term_seo_phrase( $term );
    if ( '' === $phrase ) {
        $phrase = $term->name;
    }

    return array(
        array(
            'question' => 'Как выбрать подходящую деталь?',
            'answer'   => sprintf( 'Сверьте название, модель автомобиля, сторону установки, размеры, артикул и SKU. Если деталь кузовная или относится к системе выпуска, дополнительно проверьте фото и применяемость в карточке товара.' ),
        ),
        array(
            'question' => 'Чем отличается левая и правая деталь?',
            'answer'   => 'Левая и правая сторона обычно определяются по ходу движения автомобиля. Для арок, крыльев, порогов, лонжеронов и других кузовных деталей это критично: внешне похожие позиции могут не подойти на противоположную сторону.',
        ),
        array(
            'question' => 'Есть ли доставка по России?',
            'answer'   => sprintf( 'Да, товары из раздела «%1$s» можно заказать с доставкой по России. Также доступен самовывоз в %2$s, если товар есть в наличии на складе.', $phrase, dv_get_seo_city_name() ),
        ),
    );
}

function dv_get_term_effective_seo_faq( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return array();
    }

    $manual_faq = dv_get_term_seo_faq( $term->term_id );
    if ( ! empty( $manual_faq ) ) {
        return $manual_faq;
    }

    return dv_build_term_default_faq( $term );
}

function dv_get_term_products_count_for_seo( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return 0;
    }

    $query = new WP_Query(
        array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'posts_per_page' => 1,
            'tax_query'      => array(
                array(
                    'taxonomy'         => 'product_cat',
                    'field'            => 'term_id',
                    'terms'            => array( $term->term_id ),
                    'include_children' => true,
                ),
            ),
        )
    );

    $count = (int) $query->found_posts;
    wp_reset_postdata();

    return $count;
}

function dv_get_product_seo_compatibility( $product ) {
    if ( ! $product instanceof WC_Product || ! function_exists( 'dv_get_compat_tags' ) ) {
        return '';
    }

    $tags = array_slice( dv_get_compat_tags( $product ), 0, 4 );
    if ( empty( $tags ) ) {
        return '';
    }

    return implode( ', ', $tags );
}

function dv_get_product_seo_sku( $product ) {
    if ( ! $product instanceof WC_Product ) {
        return '';
    }

    $attribute_candidates = array( 'SKU', 'sku', 'pa_sku' );
    foreach ( $attribute_candidates as $attribute_name ) {
        $value = trim( wp_strip_all_tags( (string) $product->get_attribute( $attribute_name ) ) );
        if ( '' !== $value ) {
            $parts = array_filter( array_map( 'trim', explode( ',', $value ) ) );
            return $parts ? reset( $parts ) : $value;
        }
    }

    return trim( (string) $product->get_sku() );
}

function dv_build_product_seo_title( $product, $paged_suffix = '' ) {
    if ( ! $product instanceof WC_Product ) {
        return '';
    }

    $product_name = dv_trim_seo_text( function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name(), 78 );
    $sku          = dv_get_product_seo_sku( $product );

    if ( '' !== $sku ) {
        $title = $product_name . ', ' . $sku . ' — купить онлайн';
    } else {
        $title = $product_name . ' — купить онлайн';
    }

    if ( '' !== (string) $product->get_price() ) {
        $labels = dv_seo_labels();
        $title .= sprintf( $labels['product_title_price'], wp_strip_all_tags( wc_price( $product->get_price() ) ) );
    }

    return $title . $paged_suffix . ' | ' . dv_get_seo_shop_name();
}

function dv_build_term_seo_title( $term, $paged_suffix = '' ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $name = dv_get_term_seo_phrase( $term );

    return $name . ' — купить, цены в каталоге' . $paged_suffix . ' | ' . dv_get_seo_shop_name();
}

function dv_build_product_seo_description( $product ) {
    if ( ! $product instanceof WC_Product ) {
        return '';
    }

    $parts  = array(
        sprintf( 'Купить %1$s в интернет-магазине %2$s', function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name(), dv_get_seo_shop_name() ),
    );
    $labels = dv_seo_labels();

    $seo_sku = dv_get_product_seo_sku( $product );
    if ( '' !== $seo_sku ) {
        $parts[] = sprintf( $labels['product_sku'], $seo_sku );
    }

    $primary_cat = function_exists( 'dv_get_primary_product_cat' ) ? dv_get_primary_product_cat( $product->get_id() ) : null;
    if ( $primary_cat instanceof WP_Term ) {
        $parts[] = sprintf( $labels['product_desc_category'], dv_get_term_seo_display_name( $primary_cat ) );
    }

    $compatibility = dv_get_product_seo_compatibility( $product );
    if ( '' !== $compatibility ) {
        $parts[] = sprintf( $labels['product_desc_compat'], $compatibility );
    }

    if ( '' !== (string) $product->get_price() ) {
        $parts[] = sprintf( $labels['price_from'], wp_strip_all_tags( wc_price( $product->get_price() ) ) );
    }

    $brand = function_exists( 'dv_get_product_brand_name' ) ? dv_get_product_brand_name( $product ) : '';
    if ( $brand ) {
        $parts[] = sprintf( $labels['brand'], $brand );
    }

    $parts[] = $product->is_in_stock() ? $labels['stock_in'] : $labels['stock_order'];
    $parts[] = $labels['pickup_delivery_region'];

    return dv_trim_seo_text( implode( '. ', $parts ) . '.', 170 );
}

function dv_build_term_seo_description( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return '';
    }

    $labels      = dv_seo_labels();
    $name        = dv_get_term_seo_phrase( $term );
    $description = dv_trim_seo_text( dv_get_term_seo_intro( $term->term_id ), 120 );
    if ( ! $description ) {
        $description = dv_trim_seo_text( term_description( $term, 'product_cat' ), 120 );
    }

    if ( $description ) {
        return dv_trim_seo_text(
            sprintf( $labels['term_desc_with_intro'], $description, $name ),
            170
        );
    }

    return dv_trim_seo_text( sprintf( '%1$s: цены, наличие, подбор по марке авто, самовывоз и доставка по России в магазине %2$s.', $name, dv_get_seo_shop_name() ), 170 );
}

function dv_get_seo_description() {
    $labels = dv_seo_labels();

    if ( function_exists( 'dv_is_wholesale_request' ) && dv_is_wholesale_request() && function_exists( 'dv_wholesale_labels' ) ) {
        $wholesale_labels = dv_wholesale_labels();
        return dv_trim_seo_text( $wholesale_labels['page_desc'], 170 );
    }

    if ( is_singular( 'product' ) ) {
        $product = wc_get_product( get_queried_object_id() );
        if ( $product ) {
            $custom_description = dv_get_product_seo_description_override( $product->get_id() );
            if ( '' !== $custom_description ) {
                return dv_trim_seo_text( $custom_description, 170 );
            }

            return dv_build_product_seo_description( $product );
        }
    }

    if ( is_product_category() ) {
        $term = get_queried_object();
        if ( $term instanceof WP_Term ) {
            $custom_description = dv_get_term_seo_description_override( $term->term_id );
            if ( '' !== $custom_description ) {
                return dv_trim_seo_text( $custom_description, 170 );
            }

            return dv_build_term_seo_description( $term );
        }
    }

    if ( is_post_type_archive( 'product' ) ) {
        return 'Каталог автозапчастей: кузовные детали, система выпуска, подвеска и двигатель. Цены, наличие, самовывоз и доставка по России.';
    }

    if ( is_search() ) {
        return dv_trim_seo_text(
            sprintf( 'Результаты поиска по запросу «%1$s» в каталоге автозапчастей %2$s. Цены, наличие и подбор запчастей.', get_search_query(), dv_get_seo_shop_name() ),
            170
        );
    }

    if ( is_front_page() || is_home() ) {
        return sprintf( 'Интернет-магазин автозапчастей %1$s: купить кузовные детали и запчасти системы выпуска. Цены, наличие, самовывоз и доставка по России.', dv_get_seo_shop_name() );
    }

    if ( dv_is_contacts_page() ) {
        $store = dv_get_store_profile();
        return sprintf( $labels['contacts_desc'], dv_get_seo_shop_name(), dv_get_seo_city_name(), $store['phone'] );
    }

    if ( dv_is_about_page() ) {
        return sprintf( $labels['about_desc'], dv_get_seo_shop_name(), dv_get_seo_city_name() );
    }

    if ( dv_is_delivery_page() ) {
        return sprintf( $labels['delivery_desc'], dv_get_seo_shop_name(), dv_get_seo_city_name() );
    }

    if ( dv_is_return_page() ) {
        return sprintf( $labels['return_desc'], dv_get_seo_shop_name(), dv_get_seo_city_name() );
    }

    if ( dv_is_privacy_page() ) {
        return sprintf( $labels['privacy_desc'], dv_get_seo_shop_name() );
    }

    if ( dv_is_agreement_page() ) {
        return sprintf( $labels['agreement_desc'], dv_get_seo_shop_name() );
    }

    if ( function_exists( 'dv_get_current_custom_service_page' ) ) {
        $custom_page = dv_get_current_custom_service_page();
        if ( ! empty( $custom_page ) ) {
            if ( ! empty( $custom_page['seo_description'] ) ) {
                return dv_trim_seo_text( $custom_page['seo_description'], 170 );
            }

            $description = trim( (string) ( $custom_page['intro'] ?? '' ) . ' ' . ( $custom_page['body'] ?? '' ) );
            if ( '' !== $description ) {
                return dv_trim_seo_text( $description, 170 );
            }
        }
    }

    if ( is_page() ) {
        $description = dv_trim_seo_text( get_post_field( 'post_excerpt', get_queried_object_id() ), 170 );
        if ( $description ) {
            return $description;
        }
    }

    return sprintf( 'Интернет-магазин автозапчастей %1$s: каталог, подбор, сравнение и заказ запчастей.', dv_get_seo_shop_name() );
}

function dv_get_seo_image_url() {
    if ( is_singular( 'product' ) ) {
        $product  = function_exists( 'wc_get_product' ) ? wc_get_product( get_queried_object_id() ) : null;
        $image_id = get_post_thumbnail_id( get_queried_object_id() );

        if ( ! $image_id && $product instanceof WC_Product ) {
            $gallery_ids = $product->get_gallery_image_ids();
            $image_id    = ! empty( $gallery_ids[0] ) ? absint( $gallery_ids[0] ) : 0;
        }

        if ( $image_id ) {
            $image = wp_get_attachment_image_url( $image_id, 'dv-product-lg' );
            if ( $image ) {
                return $image;
            }
        }
    }

    if ( is_product_category() ) {
        $term = get_queried_object();
        if ( $term instanceof WP_Term ) {
            $thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
            if ( $thumbnail_id ) {
                $image = wp_get_attachment_image_url( $thumbnail_id, 'dv-product-lg' );
                if ( $image ) {
                    return $image;
                }
            }

            $products = new WP_Query(
                array(
                    'post_type'              => 'product',
                    'post_status'            => 'publish',
                    'fields'                 => 'ids',
                    'posts_per_page'         => 1,
                    'no_found_rows'          => true,
                    'update_post_meta_cache' => false,
                    'update_post_term_cache' => false,
                    'meta_query'             => array(
                        array(
                            'key'     => '_thumbnail_id',
                            'compare' => 'EXISTS',
                        ),
                    ),
                    'tax_query'              => array(
                        array(
                            'taxonomy'         => 'product_cat',
                            'field'            => 'term_id',
                            'terms'            => array( $term->term_id ),
                            'include_children' => true,
                        ),
                    ),
                )
            );

            $product_id = ! empty( $products->posts[0] ) ? absint( $products->posts[0] ) : 0;
            wp_reset_postdata();

            if ( $product_id ) {
                $image_id = get_post_thumbnail_id( $product_id );
                if ( $image_id ) {
                    $image = wp_get_attachment_image_url( $image_id, 'dv-product-lg' );
                    if ( $image ) {
                        return $image;
                    }
                }
            }
        }
    }

    $site_icon = get_site_icon_url( 512 );
    if ( $site_icon ) {
        return $site_icon;
    }

    return DV_URI . '/assets/logo.png';
}

function dv_get_seo_image_data() {
    $url = dv_get_seo_image_url();
    $data = array(
        'url'    => $url,
        'width'  => 0,
        'height' => 0,
        'type'   => '',
        'alt'    => '',
    );

    $attachment_id = attachment_url_to_postid( $url );
    if ( $attachment_id ) {
        $data['alt'] = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

        $meta = wp_get_attachment_metadata( $attachment_id );
        if ( is_array( $meta ) ) {
            $data['width']  = absint( $meta['width'] ?? 0 );
            $data['height'] = absint( $meta['height'] ?? 0 );
        }

        $mime = get_post_mime_type( $attachment_id );
        if ( $mime ) {
            $data['type'] = $mime;
        }
    }

    if ( ! $data['type'] ) {
        $path = (string) wp_parse_url( $url, PHP_URL_PATH );
        $ext  = strtolower( pathinfo( $path, PATHINFO_EXTENSION ) );
        if ( 'png' === $ext ) {
            $data['type'] = 'image/png';
        } elseif ( in_array( $ext, array( 'jpg', 'jpeg' ), true ) ) {
            $data['type'] = 'image/jpeg';
        } elseif ( 'webp' === $ext ) {
            $data['type'] = 'image/webp';
        }
    }

    if ( ( ! $data['width'] || ! $data['height'] ) && 0 === strpos( $url, DV_URI ) ) {
        $path = str_replace( DV_URI, DV_DIR, $url );
        if ( file_exists( $path ) ) {
            $size = getimagesize( $path );
            if ( is_array( $size ) ) {
                $data['width']  = absint( $size[0] ?? 0 );
                $data['height'] = absint( $size[1] ?? 0 );
            }
        }
    }

    if ( '' === $data['alt'] ) {
        $data['alt'] = dv_get_social_preview_title();
    }

    return $data;
}

function dv_get_clean_seo_title() {
    $title = wp_get_document_title();
    $shop  = dv_get_seo_shop_name();

    $title = html_entity_decode( wp_strip_all_tags( (string) $title ), ENT_QUOTES, 'UTF-8' );
    $title = preg_replace( '/\s+/u', ' ', $title );
    $title = preg_replace( '/\s*[|—-]\s*' . preg_quote( $shop, '/' ) . '\s*[—-]\s*' . preg_quote( $shop, '/' ) . '\s*$/u', ' | ' . $shop, $title );

    return trim( $title );
}

function dv_get_social_preview_title() {
    $shop = dv_get_seo_shop_name();

    if ( is_singular( 'product' ) ) {
        $product = wc_get_product( get_queried_object_id() );
        if ( $product ) {
            $name = function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name();
            return dv_trim_seo_text( $name, 96 ) . ' | ' . $shop;
        }
    }

    if ( is_product_category() ) {
        $term = get_queried_object();
        if ( $term instanceof WP_Term ) {
            $title = function_exists( 'dv_build_term_seo_h1' ) ? dv_build_term_seo_h1( $term ) : $term->name;
            return dv_trim_seo_text( $title, 86 ) . ' | ' . $shop;
        }
    }

    if ( is_post_type_archive( 'product' ) ) {
        return 'Каталог автозапчастей | ' . $shop;
    }

    if ( is_search() ) {
        return dv_trim_seo_text( sprintf( 'Поиск запчастей: %s', get_search_query() ), 86 ) . ' | ' . $shop;
    }

    return dv_trim_seo_text( dv_get_clean_seo_title(), 96 );
}

function dv_seo_title_has_trailing_shop_name( $title ) {
    $shop = trim( (string) dv_get_seo_shop_name() );
    if ( '' === $shop ) {
        return false;
    }

    $title = html_entity_decode( wp_strip_all_tags( (string) $title ), ENT_QUOTES, 'UTF-8' );
    $title = trim( preg_replace( '/\s+/u', ' ', $title ) );

    return (bool) preg_match( '/(?:\s*[|—-]\s*' . preg_quote( $shop, '/' ) . '|\s+' . preg_quote( $shop, '/' ) . ')\s*$/u', $title );
}

function dv_normalize_document_title_parts( $parts ) {
    if ( ! empty( $parts['title'] ) && dv_seo_title_has_trailing_shop_name( $parts['title'] ) ) {
        unset( $parts['site'], $parts['tagline'] );
    }

    return $parts;
}

function dv_filter_document_title_parts( $parts ) {
    $labels = dv_seo_labels();
    if ( dv_has_seo_plugin() ) {
        return $parts;
    }

    $paged_suffix = '';
    $paged        = max( 1, (int) get_query_var( 'paged' ) );
    if ( $paged > 1 ) {
        $paged_suffix = ' ' . sprintf( $labels['paged_suffix'], $paged );
    }

    if ( is_singular( 'product' ) ) {
        $product = wc_get_product( get_queried_object_id() );
        $custom_title = $product ? dv_get_product_seo_title_override( $product->get_id() ) : '';
        if ( '' !== $custom_title ) {
            $parts['title'] = $custom_title . $paged_suffix;
            return dv_normalize_document_title_parts( $parts );
        }

        $parts['title'] = $product ? dv_build_product_seo_title( $product, $paged_suffix ) : single_post_title( '', false );
    } elseif ( is_product_category() ) {
        $term = get_queried_object();
        if ( $term instanceof WP_Term ) {
            $custom_title = dv_get_term_seo_title_override( $term->term_id );
            if ( '' !== $custom_title ) {
                $parts['title'] = $custom_title . $paged_suffix;
                return dv_normalize_document_title_parts( $parts );
            }
        }

        $parts['title'] = $term instanceof WP_Term ? dv_build_term_seo_title( $term, $paged_suffix ) : single_term_title( '', false ) . ' — купить, цены в каталоге' . $paged_suffix . ' | ' . dv_get_seo_shop_name();
    } elseif ( is_front_page() || is_home() ) {
        $parts['title'] = 'Автозапчасти и кузовные детали — купить онлайн | ' . dv_get_seo_shop_name();
    } elseif ( is_post_type_archive( 'product' ) ) {
        $parts['title'] = 'Каталог автозапчастей — цены и наличие' . $paged_suffix . ' | ' . dv_get_seo_shop_name();
    } elseif ( is_search() ) {
        $parts['title'] = sprintf( $labels['search_title'], get_search_query(), $paged_suffix, dv_get_seo_shop_name() );
    } elseif ( dv_is_contacts_page() ) {
        $parts['title'] = sprintf( $labels['contacts_title'], dv_get_seo_city_name(), dv_get_seo_shop_name() );
    } elseif ( dv_is_about_page() ) {
        $parts['title'] = sprintf( $labels['about_title'], dv_get_seo_shop_name(), dv_get_seo_city_name() );
    } elseif ( dv_is_delivery_page() ) {
        $parts['title'] = sprintf( $labels['delivery_title'], dv_get_seo_shop_name() );
    } elseif ( dv_is_return_page() ) {
        $parts['title'] = sprintf( $labels['return_title'], dv_get_seo_shop_name() );
    } elseif ( dv_is_privacy_page() ) {
        $parts['title'] = sprintf( $labels['privacy_title'], dv_get_seo_shop_name() );
    } elseif ( dv_is_agreement_page() ) {
        $parts['title'] = sprintf( $labels['agreement_title'], dv_get_seo_shop_name() );
    } elseif ( function_exists( 'dv_get_current_custom_service_page' ) ) {
        $custom_page = dv_get_current_custom_service_page();
        if ( ! empty( $custom_page ) ) {
            $parts['title'] = ! empty( $custom_page['seo_title'] )
                ? $custom_page['seo_title']
                : $custom_page['title'] . ' | ' . dv_get_seo_shop_name();
        }
    }

    return dv_normalize_document_title_parts( $parts );
}
add_filter( 'document_title_parts', 'dv_filter_document_title_parts', 20 );

function dv_output_seo_meta() {
    if ( is_admin() || is_404() || dv_has_seo_plugin() ) {
        return;
    }

    $title       = dv_get_social_preview_title();
    $description = dv_get_seo_description();
    $canonical   = dv_get_seo_canonical_url();
    $image       = dv_get_seo_image_data();
    $type        = is_singular( 'product' ) ? 'product' : 'website';

    echo "\n" . '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
    echo '<meta property="og:locale" content="ru_RU">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr( $type ) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url( $canonical ) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( dv_get_seo_shop_name() ) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url( $image['url'] ) . '">' . "\n";
    echo '<meta property="og:image:secure_url" content="' . esc_url( $image['url'] ) . '">' . "\n";
    echo '<meta property="og:image:alt" content="' . esc_attr( $image['alt'] ) . '">' . "\n";
    if ( $image['type'] ) {
        echo '<meta property="og:image:type" content="' . esc_attr( $image['type'] ) . '">' . "\n";
    }
    if ( $image['width'] && $image['height'] ) {
        echo '<meta property="og:image:width" content="' . esc_attr( $image['width'] ) . '">' . "\n";
        echo '<meta property="og:image:height" content="' . esc_attr( $image['height'] ) . '">' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url( $image['url'] ) . '">' . "\n";
    echo '<meta name="twitter:image:alt" content="' . esc_attr( $image['alt'] ) . '">' . "\n";

    if ( is_singular( 'product' ) ) {
        $product = wc_get_product( get_queried_object_id() );
        if ( $product ) {
            $price = $product->get_price();
            if ( '' !== (string) $price ) {
                echo '<meta property="product:price:amount" content="' . esc_attr( wc_format_decimal( $price, 2 ) ) . '">' . "\n";
                echo '<meta property="product:price:currency" content="' . esc_attr( get_woocommerce_currency() ) . '">' . "\n";
            }

            echo '<meta property="product:availability" content="' . esc_attr( $product->is_in_stock() ? 'in stock' : 'out of stock' ) . '">' . "\n";
        }
    }

}
add_action( 'wp_head', 'dv_output_seo_meta', 6 );

function dv_output_seo_pagination_links() {
    if ( is_admin() || is_404() || dv_has_seo_plugin() ) {
        return;
    }

    if ( ! ( is_post_type_archive( 'product' ) || is_product_category() ) ) {
        return;
    }

    global $wp_query;

    $paged     = max( 1, (int) get_query_var( 'paged' ) );
    $max_pages = isset( $wp_query->max_num_pages ) ? (int) $wp_query->max_num_pages : 0;

    if ( $max_pages < 2 ) {
        return;
    }

    if ( $paged > 1 ) {
        echo '<link rel="prev" href="' . esc_url( get_pagenum_link( $paged - 1 ) ) . '">' . "\n";
    }

    if ( $paged < $max_pages ) {
        echo '<link rel="next" href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'dv_output_seo_pagination_links', 6 );

function dv_get_breadcrumb_schema_items() {
    $labels   = dv_seo_labels();
    $items    = array();
    $position = 1;

    $items[] = array(
        '@type'    => 'ListItem',
        'position' => $position++,
        'name'     => $labels['home'],
        'item'     => home_url( '/' ),
    );

    if ( is_front_page() || is_home() ) {
        return $items;
    }

    $shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );

    if ( is_post_type_archive( 'product' ) || is_product_category() || is_singular( 'product' ) || is_search() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => $labels['catalog'],
            'item'     => $shop_url,
        );
    }

    if ( is_product_category() ) {
        $term  = get_queried_object();
        $trail = $term instanceof WP_Term ? dv_get_term_trail( $term, 'product_cat' ) : array();

        foreach ( $trail as $trail_term ) {
            $items[] = array(
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $trail_term->name,
                'item'     => get_term_link( $trail_term ),
            );
        }
    } elseif ( is_singular( 'product' ) ) {
        $primary_cat = dv_get_primary_product_cat( get_queried_object_id() );
        $trail       = $primary_cat instanceof WP_Term ? dv_get_term_trail( $primary_cat, 'product_cat' ) : array();

        foreach ( $trail as $trail_term ) {
            $items[] = array(
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $trail_term->name,
                'item'     => get_term_link( $trail_term ),
            );
        }

        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( get_the_ID() ) : get_the_title(),
            'item'     => get_permalink(),
        );
    } elseif ( is_search() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => sprintf( $labels['search_label'], get_search_query() ),
            'item'     => dv_get_current_request_url(),
        );
    } elseif ( is_page() && ! is_front_page() ) {
        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( get_the_ID() ) : get_the_title(),
            'item'     => get_permalink(),
        );
    }

    return $items;
}

function dv_output_breadcrumb_schema() {
    if ( is_admin() || dv_has_seo_plugin() ) {
        return;
    }

    if ( ! ( is_post_type_archive( 'product' ) || is_product_category() || is_singular( 'product' ) || is_search() || is_page() ) ) {
        return;
    }

    $items = dv_get_breadcrumb_schema_items();
    if ( count( $items ) < 2 ) {
        return;
    }

    echo "\n" . '<script type="application/ld+json">' . wp_json_encode(
        array(
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ),
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    ) . '</script>' . "\n";
}
add_action( 'wp_head', 'dv_output_breadcrumb_schema', 7 );

function dv_output_product_list_schema() {
    if ( is_admin() || dv_has_seo_plugin() ) {
        return;
    }

    if ( ! ( is_post_type_archive( 'product' ) || is_product_category() || is_search() ) ) {
        return;
    }

    global $wp_query;

    if ( empty( $wp_query ) || empty( $wp_query->posts ) || ! is_array( $wp_query->posts ) ) {
        return;
    }

    $items    = array();
    $position = 1;

    foreach ( $wp_query->posts as $post ) {
        $product = wc_get_product( $post );
        if ( ! $product ) {
            continue;
        }

        $product_item = array(
            '@type' => 'Product',
            'name'  => function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name(),
            'url'   => get_permalink( $product->get_id() ),
        );

        if ( $product->get_sku() ) {
            $product_item['sku'] = $product->get_sku();
        }

        $brand = function_exists( 'dv_get_product_brand_name' ) ? dv_get_product_brand_name( $product ) : '';
        if ( '' !== $brand ) {
            $product_item['brand'] = array(
                '@type' => 'Brand',
                'name'  => $brand,
            );
        }

        $primary_cat = function_exists( 'dv_get_primary_product_cat' ) ? dv_get_primary_product_cat( $product->get_id() ) : null;
        if ( $primary_cat instanceof WP_Term ) {
            $product_item['category'] = $primary_cat->name;
        }

        $description = function_exists( 'dv_build_product_seo_description' ) ? dv_build_product_seo_description( $product ) : '';
        if ( '' !== $description ) {
            $product_item['description'] = $description;
        }

        $image_id = $product->get_image_id();
        if ( $image_id ) {
            $image_url = wp_get_attachment_image_url( $image_id, 'full' );
            if ( $image_url ) {
                $product_item['image'] = $image_url;
            }
        }

        if ( '' !== (string) $product->get_price() ) {
            $product_item['offers'] = array(
                '@type'         => 'Offer',
                'price'         => wc_format_decimal( $product->get_price(), wc_get_price_decimals() ),
                'priceCurrency' => get_woocommerce_currency(),
                'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'url'           => get_permalink( $product->get_id() ),
            );
        }

        $items[] = array(
            '@type'    => 'ListItem',
            'position' => $position++,
            'url'      => get_permalink( $product->get_id() ),
            'item'     => $product_item,
        );

        if ( count( $items ) >= 12 ) {
            break;
        }
    }

    if ( empty( $items ) ) {
        return;
    }

    echo "\n" . '<script type="application/ld+json">' . wp_json_encode(
        array(
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            'name'            => wp_get_document_title(),
            'url'             => dv_get_seo_canonical_url(),
            'numberOfItems'   => count( $items ),
            'itemListOrder'   => 'https://schema.org/ItemListOrderAscending',
            'itemListElement' => $items,
        ),
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    ) . '</script>' . "\n";
}
add_action( 'wp_head', 'dv_output_product_list_schema', 8 );

function dv_output_collection_page_schema() {
    if ( is_admin() || dv_has_seo_plugin() ) {
        return;
    }

    if ( ! ( is_post_type_archive( 'product' ) || is_product_category() || is_search() ) ) {
        return;
    }

    global $wp_query;

    $name        = wp_get_document_title();
    $description = dv_get_seo_description();
    $canonical   = dv_get_seo_canonical_url();
    $store       = dv_get_store_profile();
    $count       = $wp_query instanceof WP_Query ? (int) $wp_query->found_posts : 0;
    $modified    = '';

    if ( is_product_category() ) {
        $term = get_queried_object();
        if ( $term instanceof WP_Term ) {
            $modified = dv_sitemap_latest_product_date( $term->term_id );
        }
    } elseif ( is_post_type_archive( 'product' ) ) {
        $modified = dv_sitemap_latest_product_date();
    }

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'CollectionPage',
        'name'        => $name,
        'description' => $description,
        'url'         => $canonical,
        'inLanguage'  => 'ru-RU',
        'isPartOf'    => array(
            '@id' => $store['site_url'] . '#website',
        ),
    );

    if ( '' !== $modified ) {
        $schema['dateModified'] = $modified;
    }

    if ( $count > 0 ) {
        $schema['mainEntity'] = array(
            '@type'         => 'ItemList',
            'numberOfItems' => $count,
            'url'           => $canonical,
        );
    }

    echo "\n" . '<script type="application/ld+json">' . wp_json_encode(
        $schema,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    ) . '</script>' . "\n";
}
add_action( 'wp_head', 'dv_output_collection_page_schema', 9 );

function dv_get_service_page_schema_type() {
    if ( dv_is_contacts_page() ) {
        return 'ContactPage';
    }

    if ( dv_is_about_page() ) {
        return 'AboutPage';
    }

    if ( dv_is_delivery_page() || dv_is_return_page() || dv_is_privacy_page() || dv_is_agreement_page() ) {
        return 'WebPage';
    }

    if ( function_exists( 'dv_get_current_custom_service_page' ) && dv_get_current_custom_service_page() ) {
        return 'WebPage';
    }

    return '';
}

function dv_get_service_page_modified_date() {
    $virtual_type = (string) get_query_var( 'dv_virtual_page' );

    if ( '' === $virtual_type && is_page() ) {
        return get_post_modified_time( 'c', true, get_queried_object_id() );
    }

    if ( '' === $virtual_type ) {
        return '';
    }

    return dv_sitemap_service_page_date( $virtual_type );
}

function dv_output_service_page_schema() {
    if ( is_admin() || is_404() || dv_has_seo_plugin() ) {
        return;
    }

    $page_type = dv_get_service_page_schema_type();
    if ( '' === $page_type ) {
        return;
    }

    $store     = dv_get_store_profile();
    $canonical = dv_get_seo_canonical_url();
    $modified  = dv_get_service_page_modified_date();
    $schema    = array(
        '@context'    => 'https://schema.org',
        '@type'       => $page_type,
        '@id'         => $canonical . '#webpage',
        'name'        => dv_get_social_preview_title(),
        'description' => dv_get_seo_description(),
        'url'         => $canonical,
        'inLanguage'  => 'ru-RU',
        'isPartOf'    => array(
            '@id' => $store['site_url'] . '#website',
        ),
        'about'       => array(
            '@id' => $store['site_url'] . '#store',
        ),
    );

    if ( '' !== $modified ) {
        $schema['dateModified'] = $modified;
    }

    if ( dv_is_contacts_page() ) {
        $schema['mainEntity'] = array(
            '@id'       => $store['site_url'] . '#store',
            '@type'     => 'AutoPartsStore',
            'name'      => $store['name'],
            'telephone' => $store['phone'],
            'url'       => $store['site_url'],
            'address'   => array(
                '@type'           => 'PostalAddress',
                'addressLocality' => $store['city'],
                'addressRegion'   => $store['region'],
                'addressCountry'  => $store['country_code'],
            ),
        );

        if ( ! empty( $store['email'] ) ) {
            $schema['mainEntity']['email'] = $store['email'];
        }
    }

    echo "\n" . '<script type="application/ld+json">' . wp_json_encode(
        $schema,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    ) . '</script>' . "\n";
}
add_action( 'wp_head', 'dv_output_service_page_schema', 9 );

function dv_output_term_faq_schema() {
    if ( is_admin() || dv_has_seo_plugin() || ! is_product_category() ) {
        return;
    }

    $term = get_queried_object();
    if ( ! $term instanceof WP_Term ) {
        return;
    }

    $faq = dv_get_term_effective_seo_faq( $term );
    if ( empty( $faq ) ) {
        return;
    }

    $items = array();
    foreach ( $faq as $item ) {
        $items[] = array(
            '@type'          => 'Question',
            'name'           => $item['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => $item['answer'],
            ),
        );
    }

    echo "\n" . '<script type="application/ld+json">' . wp_json_encode(
        array(
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $items,
        ),
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    ) . '</script>' . "\n";
}
add_action( 'wp_head', 'dv_output_term_faq_schema', 10 );

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

function dv_clear_sitemap_cache( ...$unused ) {
    delete_transient( 'dv_sitemaps_xml_v1' );
    delete_transient( 'dv_sitemaps_xml_v2' );
    delete_transient( 'dv_sitemaps_xml_v3' );
    delete_transient( 'dv_sitemaps_xml_v4' );
    delete_transient( 'dv_sitemaps_xml_v5' );
    delete_transient( 'dv_sitemaps_xml_v6' );
    delete_transient( 'dv_sitemaps_xml_v7' );
    delete_transient( 'dv_sitemaps_xml_v8' );
    delete_transient( 'dv_sitemaps_xml_v9' );
    delete_transient( 'dv_sitemap_index_xml_v1' );
    delete_transient( 'dv_sitemap_products_xml_v1' );
    delete_transient( 'dv_sitemap_categories_xml_v1' );
    delete_transient( 'dv_sitemap_pages_xml_v1' );
    delete_transient( 'dv_sitemap_products_xml_v2' );
    delete_transient( 'dv_sitemap_categories_xml_v2' );
    delete_transient( 'dv_sitemap_pages_xml_v2' );
    delete_transient( 'dv_sitemap_products_xml_v3' );
    delete_transient( 'dv_sitemap_categories_xml_v3' );
    delete_transient( 'dv_sitemap_pages_xml_v3' );
}
add_action( 'save_post_product', 'dv_clear_sitemap_cache' );
add_action( 'save_post_page', 'dv_clear_sitemap_cache' );
add_action( 'created_product_cat', 'dv_clear_sitemap_cache' );
add_action( 'edited_product_cat', 'dv_clear_sitemap_cache' );
add_action( 'delete_product_cat', 'dv_clear_sitemap_cache' );
add_action( 'updated_option_dv_store_profile', 'dv_clear_sitemap_cache' );
add_action( 'updated_option_dv_seo_settings', 'dv_clear_sitemap_cache' );
add_action( 'updated_option_dv_theme_options', 'dv_clear_sitemap_cache' );
add_action( 'updated_option_dv_theme_content', 'dv_clear_sitemap_cache' );

function dv_maybe_output_sitemap_xml() {
    $request_uri  = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
    $request_path = trim( (string) wp_parse_url( $request_uri, PHP_URL_PATH ), '/' );

    $request_path = strtolower( $request_path );

    $group_paths = array_flip( dv_sitemap_group_paths() );

    if ( ! in_array( $request_path, array( 'sitemap.xml', 'sitemaps.xml' ), true ) && ! isset( $group_paths[ $request_path ] ) ) {
        return;
    }

    status_header( 200 );
    nocache_headers();
    header( 'Content-Type: application/xml; charset=UTF-8' );

    if ( 'sitemap.xml' === $request_path ) {
        echo dv_get_sitemap_index_xml(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } elseif ( isset( $group_paths[ $request_path ] ) ) {
        echo dv_get_sitemap_xml( $group_paths[ $request_path ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
        echo dv_get_sitemap_xml(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
    exit;
}
add_action( 'template_redirect', 'dv_maybe_output_sitemap_xml', 0 );

function dv_filter_robots_txt( $output, $public ) {
    $lines = array_filter(
        array_map(
            'trim',
            preg_split( '/\r\n|\r|\n/', (string) $output )
        )
    );

    if ( empty( $lines ) ) {
        $lines[] = 'User-agent: *';
    }

    $disallow_paths = array(
        '/wp-admin/',
        '/cart/',
        '/checkout/',
        '/my-account/',
        '/?s=',
        '/*?s=',
        '/*?add-to-cart=',
        '/*?orderby=',
        '/*?min_price=',
        '/*?max_price=',
        '/*?filter_',
        '/*?utm_',
        '/*?gclid=',
        '/*?yclid=',
        '/*?fbclid=',
    );

    foreach ( $disallow_paths as $path ) {
        $line = 'Disallow: ' . $path;
        if ( ! in_array( $line, $lines, true ) ) {
            $lines[] = $line;
        }
    }

    $ajax_line = 'Allow: /wp-admin/admin-ajax.php';
    if ( ! in_array( $ajax_line, $lines, true ) ) {
        $lines[] = $ajax_line;
    }

    if ( ! $public ) {
        $lines[] = 'Disallow: /';
    }

    $sitemap_line = 'Sitemap: ' . home_url( '/sitemap.xml' );
    $lines        = array_values(
        array_filter(
            $lines,
            static function ( $line ) {
                return 0 !== stripos( (string) $line, 'Sitemap:' );
            }
        )
    );
    $lines[]      = $sitemap_line;

    return implode( "\n", array_unique( $lines ) ) . "\n";
}
add_filter( 'robots_txt', 'dv_filter_robots_txt', 20, 2 );

function dv_filter_wp_robots( $robots ) {
    $filters = dv_get_request_filter_args();

    if ( is_404() || is_search() || is_cart() || is_checkout() || is_account_page() || dv_request_has_indexing_noise_params() ) {
        $robots['noindex'] = true;
        $robots['follow']  = true;
        unset( $robots['index'] );
    }

    if ( ( is_post_type_archive( 'product' ) || is_product_category() ) && ( $filters['marka'] || $filters['stock'] || '' !== $filters['min_price'] || '' !== $filters['max_price'] ) ) {
        $robots['noindex'] = true;
        $robots['follow']  = true;
        unset( $robots['index'] );
    }

    if ( empty( $robots['noindex'] ) ) {
        $robots['max-image-preview'] = 'large';
        $robots['max-snippet']       = '-1';
        $robots['max-video-preview'] = '-1';
    }

    return $robots;
}
add_filter( 'wp_robots', 'dv_filter_wp_robots', 20 );

