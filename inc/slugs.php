<?php
defined( 'ABSPATH' ) || exit;

function dv_has_cyrillic( $text ) {
    return (bool) preg_match( '/\p{Cyrillic}/u', (string) $text );
}

function dv_cyrillic_to_latin_slug( $text ) {
    $text = strtr(
        (string) $text,
        array(
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo',
            'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M',
            'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
            ' ' => '-', ',' => '', '.' => '', '/' => '-', '_' => '-', ':' => '', ';' => '',
        )
    );

    $text = preg_replace( '/[^a-z0-9\-]+/i', '', $text );
    $text = preg_replace( '/-+/', '-', $text );
    $text = trim( (string) $text, '-' );

    return strtolower( $text );
}

function dv_should_autogenerate_slug( $current_slug, $source_title ) {
    $current_slug = trim( (string) $current_slug );
    $decoded_slug = rawurldecode( $current_slug );

    if ( '' === trim( (string) $source_title ) || ! dv_has_cyrillic( $source_title ) ) {
        return false;
    }

    return '' === $current_slug || dv_has_cyrillic( $current_slug ) || dv_has_cyrillic( $decoded_slug );
}

function dv_slug_contains_cyrillic( $current_slug ) {
    $current_slug = trim( (string) $current_slug );
    $decoded_slug = rawurldecode( $current_slug );

    return dv_has_cyrillic( $current_slug ) || dv_has_cyrillic( $decoded_slug );
}

function dv_should_convert_existing_slug( $current_slug, $source_title ) {
    $source_title = trim( (string) $source_title );

    if ( '' === $source_title ) {
        return false;
    }

    return dv_slug_contains_cyrillic( $current_slug ) || dv_should_autogenerate_slug( $current_slug, $source_title );
}

function dv_convert_product_slug_on_save( $data, $postarr ) {
    if ( 'product' !== ( $data['post_type'] ?? '' ) ) {
        return $data;
    }

    if ( ! dv_should_autogenerate_slug( $data['post_name'] ?? '', $data['post_title'] ?? '' ) ) {
        return $data;
    }

    $new_slug = dv_cyrillic_to_latin_slug( $data['post_title'] );
    if ( '' !== $new_slug ) {
        $data['post_name'] = $new_slug;
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'dv_convert_product_slug_on_save', 10, 2 );

function dv_convert_product_category_slug( $term_id, $tt_id = 0, $taxonomy = '' ) {
    if ( 'product_cat' !== $taxonomy ) {
        return;
    }

    $term = get_term( $term_id, 'product_cat' );
    if ( ! $term instanceof WP_Term || ! dv_should_autogenerate_slug( $term->slug, $term->name ) ) {
        return;
    }

    $new_slug = dv_cyrillic_to_latin_slug( $term->name );
    if ( '' === $new_slug || $new_slug === $term->slug ) {
        return;
    }

    wp_update_term(
        $term_id,
        'product_cat',
        array(
            'slug' => $new_slug,
        )
    );
}
add_action( 'created_term', 'dv_convert_product_category_slug', 10, 3 );
add_action( 'edited_term', 'dv_convert_product_category_slug', 10, 3 );

function dv_slug_tools_report_cache_key() {
    return 'dv_slug_tools_report_v1';
}

function dv_slug_tools_clear_report_cache( ...$unused ) {
    delete_transient( dv_slug_tools_report_cache_key() );
}
add_action( 'save_post_product', 'dv_slug_tools_clear_report_cache' );
add_action( 'created_product_cat', 'dv_slug_tools_clear_report_cache' );
add_action( 'edited_product_cat', 'dv_slug_tools_clear_report_cache' );
add_action( 'delete_product_cat', 'dv_slug_tools_clear_report_cache' );

function dv_existing_product_slug_candidates() {
    $ids = get_posts(
        array(
            'post_type'              => 'product',
            'post_status'            => array( 'publish', 'draft', 'pending', 'private', 'future' ),
            'posts_per_page'         => -1,
            'fields'                 => 'ids',
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        )
    );

    $candidates = array();
    foreach ( $ids as $post_id ) {
        $post = get_post( $post_id );
        if ( ! $post instanceof WP_Post ) {
            continue;
        }

        if ( dv_should_convert_existing_slug( $post->post_name, $post->post_title ) ) {
            $candidates[] = $post;
        }
    }

    return $candidates;
}

function dv_existing_category_slug_candidates() {
    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return array();
    }

    $terms = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        )
    );

    if ( is_wp_error( $terms ) ) {
        return array();
    }

    $candidates = array();
    foreach ( $terms as $term ) {
        if ( $term instanceof WP_Term && dv_should_convert_existing_slug( $term->slug, $term->name ) ) {
            $candidates[] = $term;
        }
    }

    return $candidates;
}

function dv_convert_existing_product_slugs() {
    $updated = 0;
    $skipped = 0;

    foreach ( dv_existing_product_slug_candidates() as $post ) {
        $new_slug = dv_cyrillic_to_latin_slug( $post->post_title );
        if ( '' === $new_slug ) {
            $skipped++;
            continue;
        }

        $new_slug = wp_unique_post_slug( $new_slug, $post->ID, $post->post_status, $post->post_type, $post->post_parent );
        if ( '' === $new_slug || $new_slug === $post->post_name ) {
            $skipped++;
            continue;
        }

        $result = wp_update_post(
            array(
                'ID'        => $post->ID,
                'post_name' => $new_slug,
            ),
            true
        );

        if ( is_wp_error( $result ) ) {
            $skipped++;
            continue;
        }

        $updated++;
    }

    return array(
        'updated' => $updated,
        'skipped' => $skipped,
    );
}

function dv_convert_existing_category_slugs() {
    $updated = 0;
    $skipped = 0;

    foreach ( dv_existing_category_slug_candidates() as $term ) {
        $new_slug = dv_cyrillic_to_latin_slug( $term->name );
        if ( '' === $new_slug ) {
            $skipped++;
            continue;
        }

        $new_slug = wp_unique_term_slug( $new_slug, $term );
        if ( '' === $new_slug || $new_slug === $term->slug ) {
            $skipped++;
            continue;
        }

        $result = wp_update_term(
            $term->term_id,
            'product_cat',
            array(
                'slug' => $new_slug,
            )
        );

        if ( is_wp_error( $result ) ) {
            $skipped++;
            continue;
        }

        $updated++;
    }

    return array(
        'updated' => $updated,
        'skipped' => $skipped,
    );
}

function dv_convert_existing_slugs_report() {
    $products   = dv_existing_product_slug_candidates();
    $categories = dv_existing_category_slug_candidates();

    return array(
        'products'   => count( $products ),
        'categories' => count( $categories ),
        'total'      => count( $products ) + count( $categories ),
    );
}

function dv_slug_tools_get_cached_report() {
    $cached = get_transient( dv_slug_tools_report_cache_key() );

    if ( is_array( $cached ) ) {
        return $cached;
    }

    $products   = dv_existing_product_slug_candidates();
    $categories = dv_existing_category_slug_candidates();
    $report     = array(
        'products'   => $products,
        'categories' => $categories,
        'counts'     => array(
            'products'   => count( $products ),
            'categories' => count( $categories ),
            'total'      => count( $products ) + count( $categories ),
        ),
        'preview'    => dv_slug_tools_preview_items( $products, $categories ),
    );

    set_transient( dv_slug_tools_report_cache_key(), $report, 10 * MINUTE_IN_SECONDS );

    return $report;
}

function dv_slug_tools_preview_items( $products, $categories, $limit = 8 ) {
    $items = array();
    $limit = max( 1, absint( $limit ) );

    foreach ( $products as $post ) {
        if ( count( $items ) >= $limit ) {
            break;
        }

        if ( ! $post instanceof WP_Post ) {
            continue;
        }

        $new_slug = dv_cyrillic_to_latin_slug( $post->post_title );
        if ( '' === $new_slug ) {
            continue;
        }

        $items[] = array(
            'type'    => 'Товар',
            'title'   => $post->post_title,
            'current' => $post->post_name,
            'next'    => wp_unique_post_slug( $new_slug, $post->ID, $post->post_status, $post->post_type, $post->post_parent ),
        );
    }

    foreach ( $categories as $term ) {
        if ( count( $items ) >= $limit ) {
            break;
        }

        if ( ! $term instanceof WP_Term ) {
            continue;
        }

        $new_slug = dv_cyrillic_to_latin_slug( $term->name );
        if ( '' === $new_slug ) {
            continue;
        }

        $items[] = array(
            'type'    => 'Категория',
            'title'   => $term->name,
            'current' => $term->slug,
            'next'    => wp_unique_term_slug( $new_slug, $term ),
        );
    }

    return $items;
}

function dv_register_slug_tools_page() {
    add_submenu_page(
        'dv-theme-options',
        'Slug',
        'Slug',
        'manage_options',
        'dv-slug-tools',
        'dv_render_slug_tools_page'
    );
}
add_action( 'admin_menu', 'dv_register_slug_tools_page', 40 );

function dv_slug_tools_enqueue_assets() {
    $page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
    if ( 'dv-slug-tools' !== $page ) {
        return;
    }

    $css_path = DV_DIR . '/assets/css/theme-admin.css';
    wp_enqueue_style(
        'dv-theme-admin',
        DV_URI . '/assets/css/theme-admin.css',
        array(),
        file_exists( $css_path ) ? filemtime( $css_path ) : DV_VERSION
    );

    $js_path = DV_DIR . '/assets/js/theme-admin.js';
    wp_enqueue_script(
        'dv-theme-admin',
        DV_URI . '/assets/js/theme-admin.js',
        array(),
        file_exists( $js_path ) ? filemtime( $js_path ) : DV_VERSION,
        true
    );

    wp_localize_script(
        'dv-theme-admin',
        'dvThemeAdmin',
        array(
            'unsavedMessage' => function_exists( 'dv_theme_options_label' ) ? dv_theme_options_label( '&#1045;&#1089;&#1090;&#1100; &#1085;&#1077;&#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1105;&#1085;&#1085;&#1099;&#1077; &#1080;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1080;&#1103;' ) : 'Есть несохраненные изменения',
            'dirtyCount'     => function_exists( 'dv_theme_options_label' ) ? dv_theme_options_label( '&#1048;&#1079;&#1084;&#1077;&#1085;&#1077;&#1085;&#1086; &#1087;&#1086;&#1083;&#1077;&#1081;:' ) : 'Изменено полей:',
            'saveLabel'      => function_exists( 'dv_theme_options_label' ) ? dv_theme_options_label( '&#1057;&#1086;&#1093;&#1088;&#1072;&#1085;&#1080;&#1090;&#1100;' ) : 'Сохранить',
        )
    );
}
add_action( 'admin_enqueue_scripts', 'dv_slug_tools_enqueue_assets', 20 );

function dv_render_slug_tools_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to manage slug tools.', 'detalivam' ) );
    }

    $slug_report = dv_slug_tools_get_cached_report();
    $report      = isset( $slug_report['counts'] ) && is_array( $slug_report['counts'] ) ? $slug_report['counts'] : array( 'products' => 0, 'categories' => 0, 'total' => 0 );
    $preview     = isset( $slug_report['preview'] ) && is_array( $slug_report['preview'] ) ? $slug_report['preview'] : array();
    $last_run   = get_transient( 'dv_slug_tools_last_run' );
    $action_url = admin_url( 'admin-post.php' );
    ?>
    <div class="wrap dv-suite dv-suite-page">
        <?php
        if ( function_exists( 'dv_render_admin_suite_header' ) ) {
            dv_render_admin_suite_header(
                'dv-slug-tools',
                'Slug товаров и категорий',
                'Проверка старых URL: кириллические slug можно безопасно перевести в латиницу.'
            );
        } else {
            echo '<h1>Slug товаров и категорий</h1>';
        }
        ?>

        <?php
        if ( function_exists( 'dv_render_admin_suite_local_nav' ) ) {
            dv_render_admin_suite_local_nav(
                array(
                    array( 'href' => '#dv-slug-check', 'label' => 'Проверка slug', 'description' => 'Товары / категории' ),
                )
            );
        }
        ?>

        <?php if ( is_array( $last_run ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <?php
                    printf(
                        esc_html__( 'Готово: обновлено товаров %1$d, категорий %2$d. Пропущено: %3$d.', 'detalivam' ),
                        absint( $last_run['products_updated'] ?? 0 ),
                        absint( $last_run['categories_updated'] ?? 0 ),
                        absint( $last_run['skipped'] ?? 0 )
                    );
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <section class="dv-suite-card dv-slug-tools-card" id="dv-slug-check">
            <h2>Проверка существующих slug</h2>
            <p>Новые товары и категории уже конвертируются автоматически. Этот инструмент нужен для старых позиций, где URL остался на кириллице или в виде `%d0...`.</p>

            <div class="dv-slug-tools-stats">
                <div class="dv-slug-tools-stat">
                    <span>Товары</span>
                    <strong><?php echo esc_html( $report['products'] ); ?></strong>
                </div>
                <div class="dv-slug-tools-stat">
                    <span>Категории</span>
                    <strong><?php echo esc_html( $report['categories'] ); ?></strong>
                </div>
                <div class="dv-slug-tools-stat">
                    <span>Всего</span>
                    <strong><?php echo esc_html( $report['total'] ); ?></strong>
                </div>
            </div>

            <?php if ( empty( $preview ) ) : ?>
                <div class="dv-slug-tools-empty">
                    <strong>Кириллических slug не найдено</strong>
                    <span>Товары и категории `product_cat` уже используют безопасные латинские URL. Массовая конвертация сейчас не требуется.</span>
                </div>
            <?php else : ?>
                <div class="dv-slug-tools-preview">
                    <div class="dv-slug-tools-preview-row dv-slug-tools-preview-head">
                        <span>Тип</span>
                        <span>Название</span>
                        <span>Сейчас</span>
                        <span>Будет</span>
                    </div>
                    <?php foreach ( $preview as $item ) : ?>
                        <div class="dv-slug-tools-preview-row">
                            <span><?php echo esc_html( $item['type'] ); ?></span>
                            <strong><?php echo esc_html( $item['title'] ); ?></strong>
                            <code><?php echo esc_html( $item['current'] ); ?></code>
                            <code><?php echo esc_html( $item['next'] ); ?></code>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo esc_url( $action_url ); ?>">
                <?php wp_nonce_field( 'dv_convert_existing_slugs' ); ?>
                <input type="hidden" name="action" value="dv_convert_existing_slugs">
                <button type="submit" class="button button-primary" <?php disabled( 0, $report['total'] ); ?>>
                    Проверить и перевести старые slug
                </button>
            </form>
        </section>
        <?php
        if ( function_exists( 'dv_render_admin_suite_footer' ) ) {
            dv_render_admin_suite_footer( 'dv-slug-tools' );
        }
        ?>
    </div>
    <?php
}

function dv_handle_convert_existing_slugs() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Sorry, you are not allowed to convert slugs.', 'detalivam' ) );
    }

    check_admin_referer( 'dv_convert_existing_slugs' );

    $products   = dv_convert_existing_product_slugs();
    $categories = dv_convert_existing_category_slugs();
    dv_slug_tools_clear_report_cache();

    set_transient(
        'dv_slug_tools_last_run',
        array(
            'products_updated'   => absint( $products['updated'] ?? 0 ),
            'categories_updated' => absint( $categories['updated'] ?? 0 ),
            'skipped'            => absint( $products['skipped'] ?? 0 ) + absint( $categories['skipped'] ?? 0 ),
        ),
        5 * MINUTE_IN_SECONDS
    );

    if ( function_exists( 'dv_clear_sitemap_cache' ) ) {
        dv_clear_sitemap_cache();
    }

    wp_safe_redirect(
        add_query_arg(
            array(
                'page'            => 'dv-slug-tools',
                'slugs-converted' => '1',
            ),
            admin_url( 'admin.php' )
        )
    );
    exit;
}
add_action( 'admin_post_dv_convert_existing_slugs', 'dv_handle_convert_existing_slugs' );
