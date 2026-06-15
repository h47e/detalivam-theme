<?php
defined( 'ABSPATH' ) || exit;

function dv_seo_admin_labels() {
    $labels = array(
        'meta_box_title'         => html_entity_decode( 'SEO &#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;', ENT_QUOTES, 'UTF-8' ),
        'desc_auto_both'         => html_entity_decode( '&#1045;&#1089;&#1083;&#1080; &#1087;&#1086;&#1083;&#1103; &#1087;&#1091;&#1089;&#1090;&#1099;&#1077;, &#1090;&#1077;&#1084;&#1072; &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1077;&#1090; &#1072;&#1074;&#1090;&#1086;&#1084;&#1072;&#1090;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080;&#1077; SEO-&#1096;&#1072;&#1073;&#1083;&#1086;&#1085;&#1099;.', ENT_QUOTES, 'UTF-8' ),
        'desc_auto_title'        => html_entity_decode( '&#1045;&#1089;&#1083;&#1080; &#1087;&#1086;&#1083;&#1077; &#1087;&#1091;&#1089;&#1090;&#1086;&#1077;, &#1090;&#1077;&#1084;&#1072; &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1077;&#1090; &#1072;&#1074;&#1090;&#1086;&#1084;&#1072;&#1090;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080;&#1081; SEO-&#1079;&#1072;&#1075;&#1086;&#1083;&#1086;&#1074;&#1086;&#1082;.', ENT_QUOTES, 'UTF-8' ),
        'desc_auto_description'  => html_entity_decode( '&#1045;&#1089;&#1083;&#1080; &#1087;&#1086;&#1083;&#1077; &#1087;&#1091;&#1089;&#1090;&#1086;&#1077;, &#1090;&#1077;&#1084;&#1072; &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1077;&#1090; &#1072;&#1074;&#1090;&#1086;&#1084;&#1072;&#1090;&#1080;&#1095;&#1077;&#1089;&#1082;&#1086;&#1077; SEO-&#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;.', ENT_QUOTES, 'UTF-8' ),
        'auto_preview_title'     => 'Автоматический SEO-пример',
        'auto_preview_note'      => 'Если ручные поля оставить пустыми, на сайте будет использован этот вариант.',
        'auto_content_title'     => 'Автоматический контент категории',
        'auto_h1_label'          => 'H1',
        'auto_intro_label'       => 'Верхний текст',
        'auto_text_label'        => 'Нижний блок',
        'auto_faq_label'         => 'FAQ',
        'field_hint_title'       => 'Оптимально 50-70 символов: название + артикул или категория + город.',
        'field_hint_desc'        => 'Оптимально 140-170 символов: что продаём, наличие, цена/подбор, доставка. Без повторения ключей.',
        'content_title'          => 'SEO-контент категории',
        'h1_label'               => 'SEO H1',
        'h1_hint'                => 'Если пусто, тема сформирует посадочный H1 автоматически: категория + контекст + город. Поле нужно для ручной правки без переименования категории.',
        'intro_label'            => 'Короткий текст сверху',
        'intro_hint'             => '1-2 человеческие фразы под H1: что продается, для каких авто, наличие/подбор.',
        'text_label'             => 'SEO-текст снизу',
        'text_hint'              => 'Полезный текст после товаров: как выбрать, отличия, доставка, гарантия. Не переспамливать ключами.',
        'faq_title'              => 'FAQ категории',
        'faq_question'           => 'Вопрос',
        'faq_answer'             => 'Ответ',
    );

    return array_merge(
        $labels,
        array(
            'meta_box_title'        => 'SEO ДеталиВам',
            'desc_auto_both'        => 'Если поля пустые, тема использует автоматические SEO-шаблоны.',
            'desc_auto_title'       => 'Если поле пустое, тема использует автоматический SEO-заголовок.',
            'desc_auto_description' => 'Если поле пустое, тема использует автоматическое SEO-описание.',
            'auto_preview_title'    => 'Автоматический SEO-пример',
            'auto_preview_note'     => 'Если ручные поля оставить пустыми, на сайте будет использован этот вариант.',
            'auto_content_title'    => 'Автоматический контент категории',
            'auto_intro_label'      => 'Верхний текст',
            'auto_text_label'       => 'Нижний блок',
            'field_hint_title'      => 'Оптимально 50-70 символов: название + SKU или категория + город.',
            'field_hint_desc'       => 'Оптимально 140-170 символов: что продаём, наличие, цена/подбор, доставка. Без повторения ключей.',
            'content_title'         => 'SEO-контент категории',
            'h1_hint'               => 'Если пусто, тема сформирует посадочный H1 автоматически: категория + контекст + город. Поле нужно для ручной правки без переименования категории.',
            'intro_label'           => 'Короткий текст сверху',
            'intro_hint'            => '1-2 человеческие фразы под H1: что продаётся, для каких авто, наличие/подбор.',
            'text_label'            => 'SEO-текст снизу',
            'text_hint'             => 'Полезный текст после товаров: как выбрать, отличия, доставка, гарантия. Не переспамливать ключами.',
            'faq_title'             => 'FAQ категории',
            'faq_question'          => 'Вопрос',
            'faq_answer'            => 'Ответ',
        )
    );
}

function dv_seo_admin_enqueue_assets( $hook_suffix ) {
    if ( ! is_admin() ) {
        return;
    }

    $page   = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    if ( 'dv-seo-tools' !== $page && ( ! $screen || ! in_array( $screen->id, array( 'product', 'edit-product_cat', 'appearance_page_dv-seo-tools' ), true ) ) ) {
        return;
    }

    $css_path = DV_DIR . '/assets/css/seo-admin.css';
    $js_path  = DV_DIR . '/assets/js/seo-admin.js';

    wp_enqueue_style(
        'dv-seo-admin',
        DV_URI . '/assets/css/seo-admin.css',
        array(),
        file_exists( $css_path ) ? DV_VERSION . '.' . filemtime( $css_path ) : DV_VERSION
    );

    wp_enqueue_script(
        'dv-seo-admin',
        DV_URI . '/assets/js/seo-admin.js',
        array(),
        file_exists( $js_path ) ? DV_VERSION . '.' . filemtime( $js_path ) : DV_VERSION,
        true
    );

    if ( 'dv-seo-tools' === $page ) {
        wp_localize_script(
            'dv-seo-admin',
            'dvSeoTools',
            array(
                'ajaxUrl'                   => admin_url( 'admin-ajax.php' ),
                'productAuditNonce'         => wp_create_nonce( 'dv_seo_tools_product_audit_batch' ),
                'productAuditScheduleNonce' => wp_create_nonce( 'dv_seo_tools_schedule_product_audit' ),
                'productAuditStatusNonce'   => wp_create_nonce( 'dv_seo_tools_product_audit_status' ),
                'productAuditState'         => function_exists( 'dv_seo_tools_get_product_audit_state' ) ? dv_seo_tools_get_product_audit_state() : array(),
            )
        );
    }
}
add_action( 'admin_enqueue_scripts', 'dv_seo_admin_enqueue_assets' );

function dv_render_product_seo_metabox( $post ) {
    $labels = dv_seo_admin_labels();
    wp_nonce_field( 'dv_save_product_seo', 'dv_product_seo_nonce' );

    $seo_title       = get_post_meta( $post->ID, '_dv_seo_title', true );
    $seo_description = get_post_meta( $post->ID, '_dv_seo_description', true );
    $product         = function_exists( 'wc_get_product' ) ? wc_get_product( $post->ID ) : null;
    $auto_title      = $product && function_exists( 'dv_build_product_seo_title' ) ? dv_build_product_seo_title( $product ) : '';
    $auto_desc       = $product && function_exists( 'dv_build_product_seo_description' ) ? dv_build_product_seo_description( $product ) : '';
    ?>
    <p>
        <label for="dv-seo-title"><strong>SEO Title</strong></label>
        <input type="text" id="dv-seo-title" name="dv_seo_title" value="<?php echo esc_attr( $seo_title ); ?>" class="widefat" maxlength="255">
        <span class="description"><?php echo esc_html( $labels['field_hint_title'] ); ?></span>
    </p>
    <p>
        <label for="dv-seo-description"><strong>SEO Description</strong></label>
        <textarea id="dv-seo-description" name="dv_seo_description" rows="4" class="widefat" maxlength="320"><?php echo esc_textarea( $seo_description ); ?></textarea>
        <span class="description"><?php echo esc_html( $labels['field_hint_desc'] ); ?></span>
    </p>
    <p class="description"><?php echo esc_html( $labels['desc_auto_both'] ); ?></p>
    <?php if ( $auto_title || $auto_desc ) : ?>
        <div class="dv-seo-admin-preview">
            <strong><?php echo esc_html( $labels['auto_preview_title'] ); ?></strong>
            <?php if ( $auto_title ) : ?>
                <p><code><?php echo esc_html( $auto_title ); ?></code></p>
            <?php endif; ?>
            <?php if ( $auto_desc ) : ?>
                <p><?php echo esc_html( $auto_desc ); ?></p>
            <?php endif; ?>
            <p class="description"><?php echo esc_html( $labels['auto_preview_note'] ); ?></p>
        </div>
    <?php endif; ?>
    <?php
}

function dv_add_product_seo_metabox() {
    $labels = dv_seo_admin_labels();
    add_meta_box(
        'dv-product-seo',
        $labels['meta_box_title'],
        'dv_render_product_seo_metabox',
        'product',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'dv_add_product_seo_metabox' );

function dv_save_product_seo_meta( $post_id ) {
    if ( ! isset( $_POST['dv_product_seo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dv_product_seo_nonce'] ) ), 'dv_save_product_seo' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( 'product' !== get_post_type( $post_id ) ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $seo_title       = sanitize_text_field( wp_unslash( $_POST['dv_seo_title'] ?? '' ) );
    $seo_description = sanitize_textarea_field( wp_unslash( $_POST['dv_seo_description'] ?? '' ) );

    if ( '' !== $seo_title ) {
        update_post_meta( $post_id, '_dv_seo_title', $seo_title );
    } else {
        delete_post_meta( $post_id, '_dv_seo_title' );
    }

    if ( '' !== $seo_description ) {
        update_post_meta( $post_id, '_dv_seo_description', $seo_description );
    } else {
        delete_post_meta( $post_id, '_dv_seo_description' );
    }
}
add_action( 'save_post_product', 'dv_save_product_seo_meta' );

function dv_product_cat_seo_add_fields() {
    $labels = dv_seo_admin_labels();
    ?>
    <div class="form-field">
        <h2><?php echo esc_html( $labels['content_title'] ); ?></h2>
    </div>
    <div class="form-field">
        <label for="dv-term-seo-h1"><?php echo esc_html( $labels['h1_label'] ); ?></label>
        <input type="text" name="dv_term_seo_h1" id="dv-term-seo-h1" value="" maxlength="255">
        <p><?php echo esc_html( $labels['h1_hint'] ); ?></p>
    </div>
    <div class="form-field">
        <label for="dv-term-seo-intro"><?php echo esc_html( $labels['intro_label'] ); ?></label>
        <textarea name="dv_term_seo_intro" id="dv-term-seo-intro" rows="4" cols="40"></textarea>
        <p><?php echo esc_html( $labels['intro_hint'] ); ?></p>
    </div>
    <div class="form-field">
        <label for="dv-term-seo-title">SEO Title</label>
        <input type="text" name="dv_term_seo_title" id="dv-term-seo-title" value="" maxlength="255">
        <p><?php echo esc_html( $labels['desc_auto_title'] ); ?> <?php echo esc_html( $labels['field_hint_title'] ); ?></p>
    </div>
    <div class="form-field">
        <label for="dv-term-seo-description">SEO Description</label>
        <textarea name="dv_term_seo_description" id="dv-term-seo-description" rows="5" cols="40" maxlength="320"></textarea>
        <p><?php echo esc_html( $labels['desc_auto_description'] ); ?> <?php echo esc_html( $labels['field_hint_desc'] ); ?></p>
    </div>
    <div class="form-field">
        <label for="dv-term-seo-text"><?php echo esc_html( $labels['text_label'] ); ?></label>
        <textarea name="dv_term_seo_text" id="dv-term-seo-text" rows="7" cols="40"></textarea>
        <p><?php echo esc_html( $labels['text_hint'] ); ?></p>
    </div>
    <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
        <div class="form-field">
            <label for="dv-term-faq-question-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $labels['faq_title'] . ' ' . $i ); ?></label>
            <input type="text" name="dv_term_faq[<?php echo esc_attr( $i ); ?>][question]" id="dv-term-faq-question-<?php echo esc_attr( $i ); ?>" value="" placeholder="<?php echo esc_attr( $labels['faq_question'] ); ?>">
            <textarea name="dv_term_faq[<?php echo esc_attr( $i ); ?>][answer]" rows="3" cols="40" placeholder="<?php echo esc_attr( $labels['faq_answer'] ); ?>"></textarea>
        </div>
    <?php endfor; ?>
    <?php
}
add_action( 'product_cat_add_form_fields', 'dv_product_cat_seo_add_fields' );

function dv_product_cat_seo_edit_fields( $term ) {
    $labels          = dv_seo_admin_labels();
    $seo_title       = get_term_meta( $term->term_id, '_dv_seo_title', true );
    $seo_description = get_term_meta( $term->term_id, '_dv_seo_description', true );
    $seo_h1          = get_term_meta( $term->term_id, '_dv_seo_h1', true );
    $seo_intro       = get_term_meta( $term->term_id, '_dv_seo_intro', true );
    $seo_text        = get_term_meta( $term->term_id, '_dv_seo_text', true );
    $seo_faq         = get_term_meta( $term->term_id, '_dv_seo_faq', true );
    $seo_faq         = is_array( $seo_faq ) ? $seo_faq : array();
    $auto_title      = function_exists( 'dv_build_term_seo_title' ) ? dv_build_term_seo_title( $term ) : '';
    $auto_desc       = function_exists( 'dv_build_term_seo_description' ) ? dv_build_term_seo_description( $term ) : '';
    $auto_h1         = function_exists( 'dv_build_term_auto_seo_h1' ) ? dv_build_term_auto_seo_h1( $term ) : '';
    $auto_intro      = function_exists( 'dv_build_term_seo_intro' ) ? dv_build_term_seo_intro( $term ) : '';
    $auto_text       = function_exists( 'dv_build_term_seo_text' ) ? dv_build_term_seo_text( $term ) : '';
    $auto_faq        = function_exists( 'dv_build_term_default_faq' ) ? dv_build_term_default_faq( $term ) : array();
    ?>
    <tr class="form-field">
        <th colspan="2"><h2><?php echo esc_html( $labels['content_title'] ); ?></h2></th>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="dv-term-seo-h1"><?php echo esc_html( $labels['h1_label'] ); ?></label></th>
        <td>
            <input type="text" name="dv_term_seo_h1" id="dv-term-seo-h1" value="<?php echo esc_attr( $seo_h1 ); ?>" maxlength="255">
            <p class="description"><?php echo esc_html( $labels['h1_hint'] ); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="dv-term-seo-intro"><?php echo esc_html( $labels['intro_label'] ); ?></label></th>
        <td>
            <textarea name="dv_term_seo_intro" id="dv-term-seo-intro" rows="4" cols="50"><?php echo esc_textarea( $seo_intro ); ?></textarea>
            <p class="description"><?php echo esc_html( $labels['intro_hint'] ); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="dv-term-seo-title">SEO Title</label></th>
        <td>
            <input type="text" name="dv_term_seo_title" id="dv-term-seo-title" value="<?php echo esc_attr( $seo_title ); ?>" maxlength="255">
            <p class="description"><?php echo esc_html( $labels['desc_auto_title'] ); ?> <?php echo esc_html( $labels['field_hint_title'] ); ?></p>
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row"><label for="dv-term-seo-description">SEO Description</label></th>
        <td>
            <textarea name="dv_term_seo_description" id="dv-term-seo-description" rows="5" cols="50" maxlength="320"><?php echo esc_textarea( $seo_description ); ?></textarea>
            <p class="description"><?php echo esc_html( $labels['desc_auto_description'] ); ?> <?php echo esc_html( $labels['field_hint_desc'] ); ?></p>
        </td>
    </tr>
    <?php if ( $auto_title || $auto_desc ) : ?>
    <tr class="form-field">
        <th scope="row"><?php echo esc_html( $labels['auto_preview_title'] ); ?></th>
        <td>
            <?php if ( $auto_title ) : ?>
                <p><code><?php echo esc_html( $auto_title ); ?></code></p>
            <?php endif; ?>
            <?php if ( $auto_desc ) : ?>
                <p><?php echo esc_html( $auto_desc ); ?></p>
            <?php endif; ?>
            <p class="description"><?php echo esc_html( $labels['auto_preview_note'] ); ?></p>
        </td>
    </tr>
    <?php endif; ?>
    <?php if ( $auto_h1 || $auto_intro || $auto_text || ! empty( $auto_faq ) ) : ?>
    <tr class="form-field">
        <th scope="row"><?php echo esc_html( $labels['auto_content_title'] ); ?></th>
        <td>
            <div class="dv-seo-admin-preview dv-seo-admin-preview--content">
                <?php if ( $auto_h1 ) : ?>
                    <p><strong><?php echo esc_html( $labels['auto_h1_label'] ); ?>:</strong> <?php echo esc_html( $auto_h1 ); ?></p>
                <?php endif; ?>
                <?php if ( $auto_intro ) : ?>
                    <p><strong><?php echo esc_html( $labels['auto_intro_label'] ); ?>:</strong> <?php echo esc_html( $auto_intro ); ?></p>
                <?php endif; ?>
                <?php if ( $auto_text ) : ?>
                    <details>
                        <summary><?php echo esc_html( $labels['auto_text_label'] ); ?></summary>
                        <div class="dv-seo-admin-preview-text"><?php echo wp_kses_post( $auto_text ); ?></div>
                    </details>
                <?php endif; ?>
                <?php if ( ! empty( $auto_faq ) ) : ?>
                    <details>
                        <summary><?php echo esc_html( $labels['auto_faq_label'] ); ?></summary>
                        <ol class="dv-seo-admin-preview-faq">
                            <?php foreach ( $auto_faq as $faq_item ) : ?>
                                <li>
                                    <strong><?php echo esc_html( $faq_item['question'] ); ?></strong>
                                    <span><?php echo esc_html( $faq_item['answer'] ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </details>
                <?php endif; ?>
                <p class="description"><?php echo esc_html( $labels['auto_preview_note'] ); ?></p>
            </div>
        </td>
    </tr>
    <?php endif; ?>
    <tr class="form-field">
        <th scope="row"><label for="dv-term-seo-text"><?php echo esc_html( $labels['text_label'] ); ?></label></th>
        <td>
            <textarea name="dv_term_seo_text" id="dv-term-seo-text" rows="7" cols="50"><?php echo esc_textarea( $seo_text ); ?></textarea>
            <p class="description"><?php echo esc_html( $labels['text_hint'] ); ?></p>
        </td>
    </tr>
    <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
        <?php
        $faq_item = $seo_faq[ $i ] ?? array();
        $question = $faq_item['question'] ?? '';
        $answer   = $faq_item['answer'] ?? '';
        ?>
        <tr class="form-field">
            <th scope="row"><?php echo esc_html( $labels['faq_title'] . ' ' . $i ); ?></th>
            <td>
                <input type="text" name="dv_term_faq[<?php echo esc_attr( $i ); ?>][question]" value="<?php echo esc_attr( $question ); ?>" placeholder="<?php echo esc_attr( $labels['faq_question'] ); ?>">
                <textarea name="dv_term_faq[<?php echo esc_attr( $i ); ?>][answer]" rows="3" cols="50" placeholder="<?php echo esc_attr( $labels['faq_answer'] ); ?>"><?php echo esc_textarea( $answer ); ?></textarea>
            </td>
        </tr>
    <?php endfor; ?>
    <?php
}
add_action( 'product_cat_edit_form_fields', 'dv_product_cat_seo_edit_fields' );

function dv_save_product_cat_seo_meta( $term_id ) {
    if ( ! current_user_can( 'manage_product_terms' ) && ! current_user_can( 'manage_categories' ) ) {
        return;
    }

    $seo_title       = sanitize_text_field( wp_unslash( $_POST['dv_term_seo_title'] ?? '' ) );
    $seo_description = sanitize_textarea_field( wp_unslash( $_POST['dv_term_seo_description'] ?? '' ) );
    $seo_h1          = sanitize_text_field( wp_unslash( $_POST['dv_term_seo_h1'] ?? '' ) );
    $seo_intro       = wp_kses_post( wp_unslash( $_POST['dv_term_seo_intro'] ?? '' ) );
    $seo_text        = wp_kses_post( wp_unslash( $_POST['dv_term_seo_text'] ?? '' ) );
    $raw_faq         = isset( $_POST['dv_term_faq'] ) && is_array( $_POST['dv_term_faq'] ) ? wp_unslash( $_POST['dv_term_faq'] ) : array();
    $seo_faq         = array();

    foreach ( $raw_faq as $index => $faq_item ) {
        if ( ! is_array( $faq_item ) ) {
            continue;
        }

        $question = sanitize_text_field( $faq_item['question'] ?? '' );
        $answer   = sanitize_textarea_field( $faq_item['answer'] ?? '' );

        if ( '' === $question || '' === $answer ) {
            continue;
        }

        $seo_faq[ absint( $index ) ] = array(
            'question' => $question,
            'answer'   => $answer,
        );
    }

    if ( '' !== $seo_title ) {
        update_term_meta( $term_id, '_dv_seo_title', $seo_title );
    } else {
        delete_term_meta( $term_id, '_dv_seo_title' );
    }

    if ( '' !== $seo_description ) {
        update_term_meta( $term_id, '_dv_seo_description', $seo_description );
    } else {
        delete_term_meta( $term_id, '_dv_seo_description' );
    }

    if ( '' !== $seo_h1 ) {
        update_term_meta( $term_id, '_dv_seo_h1', $seo_h1 );
    } else {
        delete_term_meta( $term_id, '_dv_seo_h1' );
    }

    if ( '' !== trim( wp_strip_all_tags( $seo_intro ) ) ) {
        update_term_meta( $term_id, '_dv_seo_intro', $seo_intro );
    } else {
        delete_term_meta( $term_id, '_dv_seo_intro' );
    }

    if ( '' !== trim( wp_strip_all_tags( $seo_text ) ) ) {
        update_term_meta( $term_id, '_dv_seo_text', $seo_text );
    } else {
        delete_term_meta( $term_id, '_dv_seo_text' );
    }

    if ( ! empty( $seo_faq ) ) {
        update_term_meta( $term_id, '_dv_seo_faq', $seo_faq );
    } else {
        delete_term_meta( $term_id, '_dv_seo_faq' );
    }
}
add_action( 'created_product_cat', 'dv_save_product_cat_seo_meta' );
add_action( 'edited_product_cat', 'dv_save_product_cat_seo_meta' );

function dv_add_seo_tools_page() {
    add_submenu_page(
        'dv-theme-options',
        html_entity_decode( 'SEO-&#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'SEO',
        'manage_options',
        'dv-seo-tools',
        'dv_render_seo_tools_page'
    );
}
add_action( 'admin_menu', 'dv_add_seo_tools_page' );

function dv_seo_tools_handle_actions() {
    if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( empty( $_POST['dv_seo_tools_action'] ) ) {
        return;
    }

    $action = sanitize_key( wp_unslash( $_POST['dv_seo_tools_action'] ) );

    if ( 'export_seo_report' === $action ) {
        check_admin_referer( 'dv_seo_tools_export_report' );
        dv_seo_tools_export_report();
    }

    if ( 'refresh_product_seo_audit' === $action ) {
        check_admin_referer( 'dv_seo_tools_refresh_product_audit' );
        dv_seo_tools_schedule_product_audit();

        wp_safe_redirect(
            add_query_arg(
                array(
                    'page'          => 'dv-seo-tools',
                    'dv_seo_notice' => 'product_audit_scheduled',
                ),
                admin_url( 'admin.php' )
            )
        );
        exit;
    }

    if ( 'refresh_http_checks' === $action ) {
        check_admin_referer( 'dv_seo_tools_refresh_http_checks' );

        dv_seo_tools_clear_sitemap_http_report_cache();
        dv_seo_tools_clear_robots_report_cache();
        dv_seo_tools_clear_sitemap_stats_cache();
        $stats = dv_seo_tools_get_sitemap_stats( true );
        dv_seo_tools_get_sitemap_http_report( $stats, true );
        dv_seo_tools_get_robots_report( true );

        wp_safe_redirect(
            add_query_arg(
                array(
                    'page'          => 'dv-seo-tools',
                    'dv_seo_notice' => 'http_checks_refreshed',
                ),
                admin_url( 'admin.php' )
            )
        );
        exit;
    }

    if ( ! in_array( $action, array( 'clear_sitemap_cache', 'rebuild_sitemap' ), true ) ) {
        return;
    }

    check_admin_referer( 'dv_seo_tools_clear_sitemap' );

    if ( function_exists( 'dv_clear_sitemap_cache' ) ) {
        dv_clear_sitemap_cache();
    }
    dv_seo_tools_clear_sitemap_http_report_cache();
    dv_seo_tools_clear_robots_report_cache();
    dv_seo_tools_clear_sitemap_stats_cache();

    if ( 'rebuild_sitemap' === $action && function_exists( 'dv_get_sitemap_xml' ) ) {
        dv_get_sitemap_xml();
        dv_get_sitemap_xml( 'products' );
        dv_get_sitemap_xml( 'categories' );
        dv_get_sitemap_xml( 'pages' );

        if ( function_exists( 'dv_get_sitemap_index_xml' ) ) {
            dv_get_sitemap_index_xml();
        }
    }

    wp_safe_redirect(
        add_query_arg(
            array(
                'page'          => 'dv-seo-tools',
                'dv_seo_notice' => 'rebuild_sitemap' === $action ? 'sitemap_rebuilt' : 'sitemap_cleared',
            ),
            admin_url( 'admin.php' )
        )
    );
    exit;
}
add_action( 'admin_init', 'dv_seo_tools_handle_actions' );

function dv_seo_tools_title_status( $text ) {
    $length = function_exists( 'mb_strlen' ) ? mb_strlen( (string) $text, 'UTF-8' ) : strlen( (string) $text );

    if ( 0 === $length ) {
        return array( $length, 'empty', 'пусто' );
    }

    if ( $length < 45 ) {
        return array( $length, 'short', 'коротко' );
    }

    if ( $length > 75 ) {
        return array( $length, 'long', 'длинно' );
    }

    return array( $length, 'good', 'норма' );
}

function dv_seo_tools_description_status( $text ) {
    $length = function_exists( 'mb_strlen' ) ? mb_strlen( (string) $text, 'UTF-8' ) : strlen( (string) $text );

    if ( 0 === $length ) {
        return array( $length, 'empty', 'пусто' );
    }

    if ( $length < 120 ) {
        return array( $length, 'short', 'коротко' );
    }

    if ( $length > 180 ) {
        return array( $length, 'long', 'длинно' );
    }

    return array( $length, 'good', 'норма' );
}

function dv_seo_tools_catalog_url() {
    if ( function_exists( 'wc_get_page_id' ) ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id > 0 ) {
            return get_permalink( $shop_page_id );
        }
    }

    return home_url( '/catalog/' );
}

function dv_seo_tools_text_has_city( $text ) {
    $city = function_exists( 'dv_get_seo_city_name' ) ? trim( (string) dv_get_seo_city_name() ) : '';
    if ( '' === $city ) {
        return false;
    }

    return false !== dv_seo_mb_stripos( wp_strip_all_tags( (string) $text ), $city );
}

function dv_seo_tools_add_preview_row( &$rows, $type, $url, $title, $description, $source = 'Авто', $edit_url = '', $check_city = false ) {
    $title       = trim( wp_strip_all_tags( (string) $title ) );
    $description = trim( wp_strip_all_tags( (string) $description ) );

    $rows[] = array(
        'type'        => $type,
        'url'         => $url,
        'title'       => $title,
        'description' => $description,
        'canonical'   => $url,
        'robots'      => 'index, follow',
        'source'      => $source,
        'edit_url'    => $edit_url,
        'city_issue'  => $check_city && ( dv_seo_tools_text_has_city( $title ) || dv_seo_tools_text_has_city( $description ) ),
    );
}

function dv_seo_tools_get_preview_rows() {
    $rows    = array();
    $labels  = function_exists( 'dv_seo_labels' ) ? dv_seo_labels() : array();
    $shop    = function_exists( 'dv_get_seo_shop_name' ) ? dv_get_seo_shop_name() : get_bloginfo( 'name' );
    $city    = function_exists( 'dv_get_seo_city_name' ) ? dv_get_seo_city_name() : '';
    $phone   = function_exists( 'dv_get_store_profile' ) ? ( dv_get_store_profile()['phone_display'] ?? '' ) : '';
    $catalog = dv_seo_tools_catalog_url();

    if ( ! empty( $labels['front_title'] ) && ! empty( $labels['front_desc'] ) ) {
        dv_seo_tools_add_preview_row(
            $rows,
            'Главная',
            home_url( '/' ),
            'Автозапчасти и кузовные детали — купить онлайн | ' . $shop,
            sprintf( 'Интернет-магазин автозапчастей %1$s: купить кузовные детали и запчасти системы выпуска. Цены, наличие, самовывоз и доставка по России.', $shop ),
            'Авто',
            admin_url( 'admin.php?page=dv-theme-content' ),
            true
        );
    }

    if ( ! empty( $labels['catalog_title'] ) && ! empty( $labels['catalog_city_desc'] ) ) {
        dv_seo_tools_add_preview_row(
            $rows,
            'Каталог',
            $catalog,
            'Каталог автозапчастей — цены и наличие | ' . $shop,
            'Каталог автозапчастей: кузовные детали, система выпуска, подвеска и двигатель. Цены, наличие, самовывоз и доставка по России.',
            'Авто',
            admin_url( 'admin.php?page=dv-theme-content' ),
            true
        );
    }

    if ( function_exists( 'get_terms' ) && taxonomy_exists( 'product_cat' ) ) {
        $term  = null;
        $terms = get_terms(
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'number'     => 1,
                'orderby'    => 'count',
                'order'      => 'DESC',
            )
        );

        if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
            $terms = array_values( $terms );
            $term  = $terms[0] ?? null;
        }

        if ( $term instanceof WP_Term ) {
            $term_link  = get_term_link( $term );
            $term_title = function_exists( 'dv_get_term_seo_title_override' ) ? dv_get_term_seo_title_override( $term->term_id ) : '';
            $term_desc  = function_exists( 'dv_get_term_seo_description_override' ) ? dv_get_term_seo_description_override( $term->term_id ) : '';

            if ( '' === $term_title && function_exists( 'dv_build_term_seo_title' ) ) {
                $term_title = dv_build_term_seo_title( $term );
            }

            if ( '' === $term_desc && function_exists( 'dv_build_term_seo_description' ) ) {
                $term_desc = dv_build_term_seo_description( $term );
            }

            if ( ! is_wp_error( $term_link ) ) {
                dv_seo_tools_add_preview_row( $rows, 'Пример категории', $term_link, $term_title, $term_desc, 'Авто/ручные поля категории', get_edit_term_link( $term->term_id, 'product_cat' ), true );
            }
        }
    }

    if ( function_exists( 'wc_get_products' ) ) {
        $product  = null;
        $products = wc_get_products(
            array(
                'limit'   => 1,
                'status'  => 'publish',
                'orderby' => 'date',
                'order'   => 'DESC',
                'return'  => 'objects',
            )
        );

        if ( ! empty( $products ) ) {
            $products = array_values( $products );
            $product  = $products[0] ?? null;
        }

        if ( $product instanceof WC_Product ) {
            $product_title = function_exists( 'dv_get_product_seo_title_override' ) ? dv_get_product_seo_title_override( $product->get_id() ) : '';
            $product_desc  = function_exists( 'dv_get_product_seo_description_override' ) ? dv_get_product_seo_description_override( $product->get_id() ) : '';
            if ( '' === $product_title && function_exists( 'dv_build_product_seo_title' ) ) {
                $product_title = dv_build_product_seo_title( $product );
            }

            if ( '' === $product_desc && function_exists( 'dv_build_product_seo_description' ) ) {
                $product_desc = dv_build_product_seo_description( $product );
            }

            dv_seo_tools_add_preview_row( $rows, 'Пример товара', get_permalink( $product->get_id() ), $product_title, $product_desc, 'Авто/ручные поля товара', get_edit_post_link( $product->get_id(), '' ), true );
        }
    }

    $service_pages = array(
        'about'     => array( 'О компании', 'about_title', 'about_desc', array( $shop, $city ) ),
        'delivery'  => array( 'Доставка', 'delivery_title', 'delivery_desc', array( $shop, $city ) ),
        'contacts'  => array( 'Контакты', 'contacts_title', 'contacts_desc', array( $city, $shop ), array( $shop, $city, $phone ) ),
        'return'    => array( 'Возврат', 'return_title', 'return_desc', array( $shop ), array( $shop, $city ) ),
        'privacy'   => array( 'Политика', 'privacy_title', 'privacy_desc', array( $shop ), array( $shop ) ),
        'agreement' => array( 'Соглашение', 'agreement_title', 'agreement_desc', array( $shop ), array( $shop ) ),
    );

    foreach ( $service_pages as $service_type => $data ) {
        if ( empty( $labels[ $data[1] ] ) || empty( $labels[ $data[2] ] ) || ! function_exists( 'dv_service_page_url' ) ) {
            continue;
        }

        $title_args = $data[3];
        $desc_args  = $data[4] ?? $title_args;
        $title      = vsprintf( $labels[ $data[1] ], $title_args );
        $desc       = vsprintf( $labels[ $data[2] ], $desc_args );

        dv_seo_tools_add_preview_row( $rows, $data[0], dv_service_page_url( $service_type ), $title, $desc, 'Авто/контент темы', admin_url( 'admin.php?page=dv-theme-content' ) );
    }

    if ( function_exists( 'dv_get_custom_service_pages' ) && function_exists( 'dv_service_page_url' ) ) {
        foreach ( dv_get_custom_service_pages() as $custom_page ) {
            if ( empty( $custom_page['type'] ) || empty( $custom_page['title'] ) ) {
                continue;
            }

            $title = ! empty( $custom_page['seo_title'] )
                ? $custom_page['seo_title']
                : $custom_page['title'] . ' | ' . $shop;
            $desc = ! empty( $custom_page['seo_description'] )
                ? $custom_page['seo_description']
                : trim( (string) ( $custom_page['intro'] ?? '' ) . ' ' . ( $custom_page['body'] ?? '' ) );

            dv_seo_tools_add_preview_row(
                $rows,
                $custom_page['title'],
                dv_service_page_url( $custom_page['type'] ),
                $title,
                $desc,
                'Контент темы / своя страница',
                admin_url( 'admin.php?page=dv-theme-content' )
            );
        }
    }

    return $rows;
}

function dv_seo_tools_sitemap_stats_cache_key() {
    return 'dv_seo_sitemap_stats_v2';
}

function dv_seo_tools_clear_sitemap_stats_cache( ...$unused ) {
    delete_transient( dv_seo_tools_sitemap_stats_cache_key() );
}
add_action( 'save_post_product', 'dv_seo_tools_clear_sitemap_stats_cache' );
add_action( 'save_post_page', 'dv_seo_tools_clear_sitemap_stats_cache' );
add_action( 'created_product_cat', 'dv_seo_tools_clear_sitemap_stats_cache' );
add_action( 'edited_product_cat', 'dv_seo_tools_clear_sitemap_stats_cache' );
add_action( 'delete_product_cat', 'dv_seo_tools_clear_sitemap_stats_cache' );
add_action( 'updated_option_dv_store_profile', 'dv_seo_tools_clear_sitemap_stats_cache' );
add_action( 'updated_option_dv_seo_settings', 'dv_seo_tools_clear_sitemap_stats_cache' );
add_action( 'updated_option_dv_theme_options', 'dv_seo_tools_clear_sitemap_stats_cache' );
add_action( 'updated_option_dv_theme_content', 'dv_seo_tools_clear_sitemap_stats_cache' );

function dv_seo_tools_get_sitemap_stats( $force_refresh = false ) {
    if ( ! $force_refresh ) {
        $cached = get_transient( dv_seo_tools_sitemap_stats_cache_key() );

        if ( is_array( $cached ) ) {
            return $cached;
        }
    }

    $stats = array(
        'total'      => 0,
        'products'   => 0,
        'categories' => 0,
        'pages'      => 0,
        'images'     => 0,
        'xml_bytes'  => 0,
        'warnings'   => array(),
        'sitemaps'   => array(),
    );

    if ( ! function_exists( 'dv_build_sitemap_urls' ) ) {
        return $stats;
    }

    $group_urls = array(
        'pages'      => function_exists( 'dv_build_sitemap_page_urls' ) ? dv_build_sitemap_page_urls() : array(),
        'categories' => function_exists( 'dv_build_sitemap_category_urls' ) ? dv_build_sitemap_category_urls() : array(),
        'products'   => function_exists( 'dv_build_sitemap_product_urls' ) ? dv_build_sitemap_product_urls() : array(),
    );

    if ( empty( $group_urls['pages'] ) && empty( $group_urls['categories'] ) && empty( $group_urls['products'] ) ) {
        $urls = dv_build_sitemap_urls();
        foreach ( $urls as $url ) {
            $type = sanitize_key( (string) ( $url['type'] ?? 'page' ) );

            if ( 'product' === $type ) {
                $group_urls['products'][] = $url;
            } elseif ( 'category' === $type ) {
                $group_urls['categories'][] = $url;
            } else {
                $group_urls['pages'][] = $url;
            }
        }
    }

    $stats['pages']      = count( $group_urls['pages'] );
    $stats['categories'] = count( $group_urls['categories'] );
    $stats['products']   = count( $group_urls['products'] );
    $stats['total']      = $stats['pages'] + $stats['categories'] + $stats['products'];

    foreach ( $group_urls['products'] as $url ) {
        if ( ! empty( $url['images'] ) && is_array( $url['images'] ) ) {
            $stats['images'] += count( $url['images'] );
        }
    }

    if ( function_exists( 'dv_get_sitemap_index_xml' ) ) {
        $stats['xml_bytes'] = strlen( dv_get_sitemap_index_xml() );
    }

    if ( function_exists( 'dv_sitemap_group_paths' ) && function_exists( 'dv_get_sitemap_urls_for_group' ) ) {
        foreach ( dv_sitemap_group_paths() as $group => $path ) {
            $stats['sitemaps'][ $group ] = array(
                'path'  => $path,
                'url'   => home_url( '/' . $path ),
                'count' => isset( $group_urls[ $group ] ) ? count( $group_urls[ $group ] ) : count( dv_get_sitemap_urls_for_group( $group ) ),
            );
        }
    }

    if ( $stats['total'] >= 45000 ) {
        $stats['warnings'][] = 'Общий совместимый sitemap приближается к лимиту 50 000 URL. Для поисковиков уже доступен sitemap index с отдельными файлами.';
    }

    if ( $stats['xml_bytes'] >= 45 * MB_IN_BYTES ) {
        $stats['warnings'][] = 'Sitemap приближается к лимиту 50MB. Лучше заранее разделить sitemap на несколько файлов.';
    }

    set_transient( dv_seo_tools_sitemap_stats_cache_key(), $stats, 6 * HOUR_IN_SECONDS );

    return $stats;
}

function dv_seo_tools_format_bytes( $bytes ) {
    $bytes = max( 0, (int) $bytes );

    if ( $bytes >= MB_IN_BYTES ) {
        return size_format( $bytes, 1 );
    }

    return size_format( $bytes, 0 );
}

function dv_seo_tools_format_checked_at( $timestamp ) {
    $timestamp = (int) $timestamp;

    if ( $timestamp <= 0 ) {
        return 'не проверялось';
    }

    return date_i18n( 'd.m.Y H:i', $timestamp );
}

function dv_seo_tools_cache_status_label( $report ) {
    return ! empty( $report['cached'] ) ? 'из кеша' : 'свежая';
}

function dv_seo_tools_remember_transient_key( $option_name, $cache_key ) {
    $option_name = sanitize_key( $option_name );
    $cache_key   = sanitize_key( $cache_key );

    if ( '' === $option_name || '' === $cache_key ) {
        return;
    }

    $previous_key = (string) get_option( $option_name, '' );
    if ( '' !== $previous_key && $previous_key !== $cache_key ) {
        delete_transient( $previous_key );
    }

    if ( $previous_key !== $cache_key ) {
        update_option( $option_name, $cache_key, false );
    }
}

function dv_seo_tools_clear_remembered_transient_key( $option_name, $fallback_key = '' ) {
    $option_name = sanitize_key( $option_name );
    $fallback_key = sanitize_key( $fallback_key );

    if ( '' !== $fallback_key ) {
        delete_transient( $fallback_key );
    }

    if ( '' === $option_name ) {
        return;
    }

    $cache_key = (string) get_option( $option_name, '' );
    if ( '' !== $cache_key ) {
        delete_transient( $cache_key );
    }

    delete_option( $option_name );
}

function dv_seo_tools_sitemap_http_report_cache_key( $stats, $targets ) {
    $payload = array(
        'home'      => home_url( '/' ),
        'total'     => (int) ( $stats['total'] ?? 0 ),
        'products'  => (int) ( $stats['products'] ?? 0 ),
        'categories' => (int) ( $stats['categories'] ?? 0 ),
        'pages'     => (int) ( $stats['pages'] ?? 0 ),
        'images'    => (int) ( $stats['images'] ?? 0 ),
        'targets'   => array(),
    );

    foreach ( $targets as $key => $target ) {
        $payload['targets'][ $key ] = array(
            'url'            => $target['url'] ?? '',
            'expected'       => $target['expected'] ?? '',
            'expected_count' => (int) ( $target['expected_count'] ?? 0 ),
        );
    }

    return 'dv_seo_sitemap_http_' . substr( md5( wp_json_encode( $payload ) ), 0, 16 );
}

function dv_seo_tools_robots_report_cache_key() {
    $payload = array(
        'url'    => home_url( '/robots.txt' ),
        'public' => (bool) get_option( 'blog_public' ),
    );

    return 'dv_seo_robots_' . substr( md5( wp_json_encode( $payload ) ), 0, 16 );
}

function dv_seo_tools_clear_sitemap_http_report_cache() {
    dv_seo_tools_clear_remembered_transient_key( 'dv_seo_sitemap_http_report_cache_key', 'dv_seo_sitemap_http_report_v1' );
}

function dv_seo_tools_clear_robots_report_cache() {
    dv_seo_tools_clear_remembered_transient_key( 'dv_seo_robots_report_cache_key', 'dv_seo_robots_report_v1' );
}

function dv_seo_tools_get_sitemap_http_report( $stats, $force = false ) {
    $targets = array(
        'index'  => array(
            'label'    => 'sitemap.xml',
            'url'      => home_url( '/sitemap.xml' ),
            'expected' => 'sitemapindex',
            'expected_count' => ! empty( $stats['sitemaps'] ) && is_array( $stats['sitemaps'] ) ? count( $stats['sitemaps'] ) : 0,
        ),
        'urlset' => array(
            'label'    => 'sitemaps.xml',
            'url'      => home_url( '/sitemaps.xml' ),
            'expected' => 'urlset',
            'expected_count' => (int) ( $stats['total'] ?? 0 ),
        ),
    );

    if ( ! empty( $stats['sitemaps'] ) && is_array( $stats['sitemaps'] ) ) {
        foreach ( $stats['sitemaps'] as $group => $sitemap ) {
            if ( empty( $sitemap['url'] ) ) {
                continue;
            }

            $targets[ 'split_' . sanitize_key( $group ) ] = array(
                'label'    => ! empty( $sitemap['path'] ) ? $sitemap['path'] : $group,
                'url'      => $sitemap['url'],
                'expected' => 'urlset',
                'expected_count' => (int) ( $sitemap['count'] ?? 0 ),
            );
        }
    }

    $cache_key = dv_seo_tools_sitemap_http_report_cache_key( $stats, $targets );
    dv_seo_tools_remember_transient_key( 'dv_seo_sitemap_http_report_cache_key', $cache_key );

    if ( ! $force ) {
        $cached_report = get_transient( $cache_key );
        if ( is_array( $cached_report ) ) {
            $cached_report['cached'] = true;
            return $cached_report;
        }
    }

    $report = array(
        'ready'      => true,
        'cached'     => false,
        'checked_at' => current_time( 'timestamp' ),
        'items'      => array(),
        'issues'     => array(),
    );

    foreach ( $targets as $key => $target ) {
        $response = wp_remote_get(
            $target['url'],
            array(
                'timeout'     => 5,
                'redirection' => 2,
                'user-agent'  => 'Detalivam SEO Tools',
            )
        );

        $status = is_wp_error( $response ) ? 0 : (int) wp_remote_retrieve_response_code( $response );
        $body   = is_wp_error( $response ) ? '' : (string) wp_remote_retrieve_body( $response );
        $content_type = is_wp_error( $response ) ? '' : wp_remote_retrieve_header( $response, 'content-type' );
        if ( is_array( $content_type ) ) {
            $content_type = implode( ', ', array_map( 'strval', $content_type ) );
        }

        $content_type = strtolower( trim( (string) $content_type ) );
        $root   = '';
        $loc_count = 0;
        $loc_values = array();

        $xml_body = preg_replace( '/^\s*<\?xml[^>]*>\s*/i', '', $body );

        if ( preg_match( '/<([a-z0-9:_-]+)(?:\s|>)/i', ltrim( (string) $xml_body ), $matches ) ) {
            $root = strtolower( (string) $matches[1] );

            if ( false !== strpos( $root, ':' ) ) {
                $parts = explode( ':', $root );
                $root  = end( $parts );
            }
        }

        if ( preg_match_all( '/<loc>\s*([^<]+)\s*<\/loc>/i', $body, $loc_matches ) ) {
            $loc_values = array_map( 'trim', $loc_matches[1] );
            $loc_count  = count( $loc_values );
        }

        $item_ready = true;
        $issues     = array();

        if ( ! $status || $status < 200 || $status >= 300 ) {
            $item_ready = false;
            $issues[]   = 'HTTP ' . ( $status ? $status : 'нет ответа' );
        }

        if ( '' === trim( $body ) ) {
            $item_ready = false;
            $issues[]   = 'пустой ответ';
        } elseif ( $root !== $target['expected'] ) {
            $item_ready = false;
            $issues[]   = 'ожидался <' . $target['expected'] . '>, найден <' . ( $root ? $root : 'не распознан' ) . '>';
        }

        if ( '' !== $content_type && false === strpos( $content_type, 'xml' ) ) {
            $item_ready = false;
            $issues[]   = 'Content-Type ' . $content_type;
        }

        if ( 'sitemapindex' === $target['expected'] && ! empty( $stats['sitemaps'] ) && is_array( $stats['sitemaps'] ) ) {
            foreach ( $stats['sitemaps'] as $sitemap ) {
                if ( empty( $sitemap['url'] ) || in_array( $sitemap['url'], $loc_values, true ) ) {
                    continue;
                }

                $item_ready = false;
                $issues[]   = 'нет ссылки на ' . ( $sitemap['path'] ?? $sitemap['url'] );
            }
        }

        if ( 'urlset' === $target['expected'] && (int) ( $target['expected_count'] ?? 0 ) > 0 && $loc_count <= 0 ) {
            $item_ready = false;
            $issues[]   = 'нет URL в <loc>';
        }

        if ( ! $item_ready ) {
            $report['ready']    = false;
            $report['issues'][] = $target['label'] . ': ' . implode( ', ', $issues ) . '.';
        }

        $report['items'][ $key ] = array(
            'label'    => $target['label'],
            'url'      => $target['url'],
            'status'   => $status,
            'content_type' => $content_type,
            'root'     => $root,
            'expected' => $target['expected'],
            'loc_count' => $loc_count,
            'expected_count' => (int) ( $target['expected_count'] ?? 0 ),
            'bytes'    => strlen( $body ),
            'ready'    => $item_ready,
            'issues'   => $issues,
        );
    }

    set_transient( $cache_key, $report, 10 * MINUTE_IN_SECONDS );

    return $report;
}

function dv_seo_tools_get_robots_report( $force = false ) {
    $cache_key = dv_seo_tools_robots_report_cache_key();
    dv_seo_tools_remember_transient_key( 'dv_seo_robots_report_cache_key', $cache_key );

    if ( ! $force ) {
        $cached_report = get_transient( $cache_key );
        if ( is_array( $cached_report ) ) {
            $cached_report['cached'] = true;
            return $cached_report;
        }
    }

    $public   = (bool) get_option( 'blog_public' );
    $robots_url = home_url( '/robots.txt' );
    $response = wp_remote_get(
        $robots_url,
        array(
            'timeout'     => 5,
            'redirection' => 2,
            'user-agent'  => 'Detalivam SEO Tools',
        )
    );
    $status   = is_wp_error( $response ) ? 0 : (int) wp_remote_retrieve_response_code( $response );
    $content  = is_wp_error( $response ) ? '' : (string) wp_remote_retrieve_body( $response );
    $content_type = is_wp_error( $response ) ? '' : wp_remote_retrieve_header( $response, 'content-type' );
    if ( is_array( $content_type ) ) {
        $content_type = implode( ', ', array_map( 'strval', $content_type ) );
    }

    $content_type = strtolower( trim( (string) $content_type ) );
    $source   = 'HTTP';

    if ( '' === trim( $content ) ) {
        $content = apply_filters( 'robots_txt', '', $public );
        $source  = 'WordPress fallback';
        $content_type = '';
    }

    $lines   = array_values(
        array_filter(
            array_map(
                'trim',
                preg_split( '/\r\n|\r|\n/', (string) $content )
            )
        )
    );

    $service_disallows = array(
        '/cart/'       => false,
        '/checkout/'   => false,
        '/my-account/' => false,
    );

    $report = array(
        'public'                    => $public,
        'cached'                    => false,
        'status'                    => $status,
        'content_type'              => $content_type,
        'bytes'                     => strlen( $content ),
        'source'                    => $source,
        'checked_at'                => current_time( 'timestamp' ),
        'line_count'                => count( $lines ),
        'has_sitemap'               => false,
        'has_global_block'          => false,
        'has_ajax_allow'            => false,
        'has_service_disallow'      => false,
        'missing_service_disallows' => array_keys( $service_disallows ),
        'issues'                    => array(),
    );

    if ( $status && ( $status < 200 || $status >= 300 ) ) {
        $report['issues'][] = 'robots.txt отвечает HTTP ' . $status . '.';
    }

    if ( 'HTTP' === $source && '' !== $content_type && false === strpos( $content_type, 'text/plain' ) ) {
        $report['issues'][] = 'robots.txt отдаётся с Content-Type ' . $content_type . ', ожидается text/plain.';
    }

    foreach ( $lines as $line ) {
        $directive  = trim( preg_replace( '/\s*#.*$/u', '', $line ) );
        $normalized = strtolower( preg_replace( '/\s+/u', ' ', $directive ) );

        if ( 0 === strpos( $normalized, 'sitemap:' ) && false !== strpos( $normalized, '/sitemap.xml' ) ) {
            $report['has_sitemap'] = true;
        }

        if ( 0 === strpos( $normalized, 'allow:' ) && false !== strpos( $normalized, '/wp-admin/admin-ajax.php' ) ) {
            $report['has_ajax_allow'] = true;
        }

        if ( 0 === strpos( $normalized, 'disallow:' ) ) {
            $path = trim( substr( $normalized, 9 ) );

            if ( '/' === $path ) {
                $report['has_global_block'] = true;
            }

            foreach ( $service_disallows as $service_path => $found ) {
                $service_path_without_slash = untrailingslashit( $service_path );

                if ( $path === $service_path || $path === $service_path_without_slash ) {
                    $service_disallows[ $service_path ] = true;
                }
            }
        }
    }

    $report['missing_service_disallows'] = array_keys(
        array_filter(
            $service_disallows,
            static function ( $found ) {
                return ! $found;
            }
        )
    );
    $report['has_service_disallow']      = empty( $report['missing_service_disallows'] );

    if ( ! $report['has_sitemap'] ) {
        $report['issues'][] = 'Нет ссылки Sitemap на /sitemap.xml.';
    }

    if ( $public && $report['has_global_block'] ) {
        $report['issues'][] = 'Есть глобальный Disallow: / при включенной индексации сайта.';
    }

    if ( ! $public && ! $report['has_global_block'] ) {
        $report['issues'][] = 'Индексация сайта выключена, но robots.txt не содержит Disallow: /.';
    }

    if ( ! $report['has_ajax_allow'] ) {
        $report['issues'][] = 'Нет Allow для /wp-admin/admin-ajax.php.';
    }

    if ( ! $report['has_service_disallow'] ) {
        $report['issues'][] = 'Не найдены запреты для служебных WooCommerce-страниц: ' . implode( ', ', $report['missing_service_disallows'] ) . '.';
    }

    set_transient( $cache_key, $report, 10 * MINUTE_IN_SECONDS );

    return $report;
}

function dv_seo_tools_render_metric( $text, $type ) {
    $status = 'title' === $type ? dv_seo_tools_title_status( $text ) : dv_seo_tools_description_status( $text );
    ?>
    <span class="dv-seo-tools-badge dv-seo-tools-badge--<?php echo esc_attr( $status[1] ); ?>">
        <?php echo esc_html( $status[0] . ' символов, ' . $status[2] ); ?>
    </span>
    <?php
}

function dv_seo_tools_get_head_value( $head, $pattern ) {
    if ( preg_match( $pattern, $head, $matches ) ) {
        return trim( html_entity_decode( wp_strip_all_tags( $matches[1] ), ENT_QUOTES, 'UTF-8' ) );
    }

    return '';
}

function dv_seo_tools_get_head_attr_value( $head, $pattern ) {
    if ( preg_match( $pattern, $head, $matches ) ) {
        return trim( html_entity_decode( $matches[1], ENT_QUOTES, 'UTF-8' ) );
    }

    return '';
}

function dv_seo_tools_parse_tag_attrs( $tag ) {
    $attrs = array();

    if ( preg_match_all( '/([a-zA-Z_:][-a-zA-Z0-9_:.]*)\s*=\s*(["\'])(.*?)\2/s', $tag, $matches, PREG_SET_ORDER ) ) {
        foreach ( $matches as $match ) {
            $attrs[ strtolower( $match[1] ) ] = html_entity_decode( $match[3], ENT_QUOTES, 'UTF-8' );
        }
    }

    return $attrs;
}

function dv_seo_tools_find_meta_content( $head, $attr_name, $attr_value ) {
    if ( ! preg_match_all( '/<meta\b[^>]*>/is', $head, $matches ) ) {
        return '';
    }

    $attr_name  = strtolower( (string) $attr_name );
    $attr_value = strtolower( (string) $attr_value );

    foreach ( $matches[0] as $tag ) {
        $attrs = dv_seo_tools_parse_tag_attrs( $tag );

        if ( isset( $attrs[ $attr_name ], $attrs['content'] ) && strtolower( $attrs[ $attr_name ] ) === $attr_value ) {
            return trim( (string) $attrs['content'] );
        }
    }

    return '';
}

function dv_seo_tools_find_link_href( $head, $rel_value ) {
    if ( ! preg_match_all( '/<link\b[^>]*>/is', $head, $matches ) ) {
        return '';
    }

    $rel_value = strtolower( (string) $rel_value );

    foreach ( $matches[0] as $tag ) {
        $attrs = dv_seo_tools_parse_tag_attrs( $tag );

        if ( ! isset( $attrs['rel'], $attrs['href'] ) ) {
            continue;
        }

        $rels = preg_split( '/\s+/', strtolower( (string) $attrs['rel'] ) );
        if ( in_array( $rel_value, $rels, true ) ) {
            return trim( (string) $attrs['href'] );
        }
    }

    return '';
}

function dv_seo_tools_collect_json_ld_types_from_node( $node, &$types ) {
    if ( ! is_array( $node ) ) {
        return;
    }

    if ( isset( $node['@type'] ) ) {
        foreach ( (array) $node['@type'] as $type ) {
            $type = trim( (string) $type );
            if ( '' !== $type ) {
                $types[] = $type;
            }
        }
    }

    foreach ( array( '@graph', 'mainEntity', 'itemListElement', 'item', 'offers', 'acceptedAnswer' ) as $key ) {
        if ( empty( $node[ $key ] ) ) {
            continue;
        }

        $children = $node[ $key ];
        if ( ! is_array( $children ) ) {
            continue;
        }

        if ( isset( $children['@type'] ) || isset( $children['@graph'] ) ) {
            dv_seo_tools_collect_json_ld_types_from_node( $children, $types );
            continue;
        }

        foreach ( $children as $child ) {
            if ( is_array( $child ) ) {
                dv_seo_tools_collect_json_ld_types_from_node( $child, $types );
            }
        }
    }
}

function dv_seo_tools_collect_json_ld_types( $head ) {
    $types = array();

    if ( ! preg_match_all( '/<script\b[^>]*type=["\']application\/ld\+json["\'][^>]*>(.*?)<\/script>/is', (string) $head, $matches ) ) {
        return $types;
    }

    foreach ( $matches[1] as $json ) {
        $json = trim( html_entity_decode( (string) $json, ENT_QUOTES, 'UTF-8' ) );
        if ( '' === $json ) {
            continue;
        }

        $decoded = json_decode( $json, true );
        if ( ! is_array( $decoded ) ) {
            continue;
        }

        dv_seo_tools_collect_json_ld_types_from_node( $decoded, $types );
    }

    $types = array_values( array_unique( array_filter( $types ) ) );
    sort( $types );

    return $types;
}

function dv_seo_tools_normalize_check_url( $raw_url ) {
    $raw_url = trim( (string) $raw_url );

    if ( '' === $raw_url ) {
        return new WP_Error( 'empty_url', 'Укажите URL для проверки.' );
    }

    if ( 0 === strpos( $raw_url, '/' ) ) {
        $raw_url = home_url( $raw_url );
    }

    $url = esc_url_raw( $raw_url );
    if ( '' === $url ) {
        return new WP_Error( 'bad_url', 'URL выглядит некорректно.' );
    }

    $site_host = wp_parse_url( home_url( '/' ), PHP_URL_HOST );
    $url_host  = wp_parse_url( $url, PHP_URL_HOST );

    if ( ! $url_host || strtolower( $site_host ) !== strtolower( $url_host ) ) {
        return new WP_Error( 'external_url', 'Проверка разрешена только для URL текущего сайта.' );
    }

    return $url;
}

function dv_seo_tools_fetch_head_report( $raw_url ) {
    $url = dv_seo_tools_normalize_check_url( $raw_url );

    if ( is_wp_error( $url ) ) {
        return $url;
    }

    $response = wp_remote_get(
        $url,
        array(
            'timeout'     => 8,
            'redirection' => 3,
            'user-agent'  => 'Detalivam SEO Tools',
        )
    );

    if ( is_wp_error( $response ) ) {
        return $response;
    }

    $code = (int) wp_remote_retrieve_response_code( $response );
    $body = (string) wp_remote_retrieve_body( $response );
    $x_robots_tag = wp_remote_retrieve_header( $response, 'x-robots-tag' );

    if ( is_array( $x_robots_tag ) ) {
        $x_robots_tag = implode( ', ', array_map( 'strval', $x_robots_tag ) );
    }

    if ( '' === $body ) {
        return new WP_Error( 'empty_response', 'Сайт вернул пустой ответ.' );
    }

    $head = $body;
    if ( preg_match( '/<head\b[^>]*>(.*?)<\/head>/is', $body, $matches ) ) {
        $head = $matches[1];
    }

    $json_ld_count = preg_match_all( '/<script\b[^>]*type=["\']application\/ld\+json["\'][^>]*>/is', $head );

    return array(
        'url'         => $url,
        'status'      => $code,
        'x_robots_tag' => trim( (string) $x_robots_tag ),
        'title'       => dv_seo_tools_get_head_value( $head, '/<title\b[^>]*>(.*?)<\/title>/is' ),
        'description' => dv_seo_tools_find_meta_content( $head, 'name', 'description' ),
        'canonical'   => dv_seo_tools_find_link_href( $head, 'canonical' ),
        'robots'      => dv_seo_tools_find_meta_content( $head, 'name', 'robots' ),
        'og_title'    => dv_seo_tools_find_meta_content( $head, 'property', 'og:title' ),
        'og_image'    => dv_seo_tools_find_meta_content( $head, 'property', 'og:image' ),
        'og_image_alt' => dv_seo_tools_find_meta_content( $head, 'property', 'og:image:alt' ),
        'json_ld'     => $json_ld_count,
        'json_ld_types' => dv_seo_tools_collect_json_ld_types( $head ),
        'expected_schema_types' => dv_seo_tools_expected_schema_types_for_url( $url ),
    );
}

function dv_seo_tools_url_path( $url ) {
    $path = (string) wp_parse_url( (string) $url, PHP_URL_PATH );
    return '/' === $path ? '/' : untrailingslashit( $path );
}

function dv_seo_tools_is_shop_url( $url ) {
    $shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '';

    if ( ! $shop_url || is_wp_error( $shop_url ) ) {
        return false;
    }

    return dv_seo_tools_url_path( $url ) === dv_seo_tools_url_path( $shop_url );
}

function dv_seo_tools_url_matches_product_category( $url ) {
    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return false;
    }

    $checked_path = dv_seo_tools_url_path( $url );
    $terms        = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'fields'     => 'ids',
            'number'     => 500,
        )
    );

    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return false;
    }

    foreach ( $terms as $term_id ) {
        $term_link = get_term_link( (int) $term_id, 'product_cat' );
        if ( is_wp_error( $term_link ) ) {
            continue;
        }

        if ( $checked_path === dv_seo_tools_url_path( $term_link ) ) {
            return true;
        }
    }

    return false;
}

function dv_seo_tools_expected_schema_types_for_url( $url ) {
    $expected = array( 'AutoPartsStore', 'WebSite' );
    $post_id  = url_to_postid( $url );

    if ( $post_id && 'product' === get_post_type( $post_id ) ) {
        $expected[] = 'Product';
        $expected[] = 'BreadcrumbList';
        return array_values( array_unique( $expected ) );
    }

    if ( dv_seo_tools_is_shop_url( $url ) || dv_seo_tools_url_matches_product_category( $url ) ) {
        $expected[] = 'ItemList';
        $expected[] = 'CollectionPage';
        $expected[] = 'BreadcrumbList';
    } elseif ( $post_id || '/' !== dv_seo_tools_url_path( $url ) ) {
        $expected[] = 'BreadcrumbList';
    }

    return array_values( array_unique( $expected ) );
}

function dv_seo_tools_normalize_compare_url( $url ) {
    $url = trim( html_entity_decode( (string) $url, ENT_QUOTES, 'UTF-8' ) );
    if ( '' === $url ) {
        return '';
    }

    $parts = wp_parse_url( $url );
    if ( empty( $parts['host'] ) ) {
        return untrailingslashit( $url );
    }

    $scheme = strtolower( $parts['scheme'] ?? 'https' );
    $host   = strtolower( $parts['host'] );
    $path   = $parts['path'] ?? '/';
    $path   = '/' === $path ? '/' : untrailingslashit( $path );
    $query  = empty( $parts['query'] ) ? '' : '?' . $parts['query'];

    return $scheme . '://' . $host . $path . $query;
}

function dv_seo_tools_robots_has_directive( $robots, $name, $expected_value = null ) {
    $robots = strtolower( (string) $robots );
    $name   = strtolower( (string) $name );

    if ( '' === $robots || '' === $name ) {
        return false;
    }

    foreach ( array_map( 'trim', explode( ',', $robots ) ) as $directive ) {
        if ( '' === $directive ) {
            continue;
        }

        $parts = array_map( 'trim', explode( ':', $directive, 2 ) );
        if ( strtolower( $parts[0] ) !== $name ) {
            continue;
        }

        if ( null === $expected_value ) {
            return true;
        }

        return strtolower( (string) ( $parts[1] ?? '' ) ) === strtolower( (string) $expected_value );
    }

    return false;
}

function dv_seo_tools_get_head_issues( $report ) {
    $issues = array();

    if ( is_wp_error( $report ) ) {
        return $issues;
    }

    $title_status = dv_seo_tools_title_status( $report['title'] );
    $desc_status  = dv_seo_tools_description_status( $report['description'] );
    $http_status  = (int) ( $report['status'] ?? 0 );

    if ( $http_status >= 200 && $http_status < 300 ) {
        $issues[] = array(
            'level' => 'good',
            'text'  => 'HTTP статус индексируемой страницы: ' . $http_status,
        );
    } elseif ( $http_status >= 300 && $http_status < 400 ) {
        $issues[] = array(
            'level' => 'warning',
            'text'  => 'HTTP редирект: ' . $http_status,
        );
    } else {
        $issues[] = array(
            'level' => 'bad',
            'text'  => 'HTTP статус мешает индексации: ' . ( $http_status ?: 'не определён' ),
        );
    }

    $issues[] = array(
        'level' => 'good' === $title_status[1] ? 'good' : 'warning',
        'text'  => 'Title: ' . $title_status[2] . ' (' . $title_status[0] . ' символов)',
    );

    $issues[] = array(
        'level' => 'good' === $desc_status[1] ? 'good' : 'warning',
        'text'  => 'Description: ' . $desc_status[2] . ' (' . $desc_status[0] . ' символов)',
    );

    $issues[] = array(
        'level' => $report['canonical'] ? 'good' : 'bad',
        'text'  => $report['canonical'] ? 'Canonical найден' : 'Canonical не найден',
    );

    if ( ! empty( $report['canonical'] ) ) {
        $checked_url   = dv_seo_tools_normalize_compare_url( $report['url'] );
        $canonical_url = dv_seo_tools_normalize_compare_url( $report['canonical'] );
        $same_url      = $checked_url && $canonical_url && $checked_url === $canonical_url;

        $issues[] = array(
            'level' => $same_url ? 'good' : 'warning',
            'text'  => $same_url ? 'Canonical совпадает с URL' : 'Canonical отличается от проверяемого URL',
        );
    }

    $robots = strtolower( (string) $report['robots'] );
    $x_robots = strtolower( (string) ( $report['x_robots_tag'] ?? '' ) );

    if ( '' !== $x_robots ) {
        $issues[] = array(
            'level' => false !== strpos( $x_robots, 'noindex' ) ? 'bad' : 'good',
            'text'  => false !== strpos( $x_robots, 'noindex' )
                ? 'X-Robots-Tag содержит noindex: сервер запрещает индексацию'
                : 'X-Robots-Tag не запрещает индексацию',
        );
    }

    if ( '' === $robots ) {
        $issues[] = array(
            'level' => 'warning',
            'text'  => 'Meta robots не найден: будет использовано поведение WordPress/поисковика по умолчанию',
        );
    } elseif ( false !== strpos( $robots, 'noindex' ) ) {
        $issues[] = array(
            'level' => 'bad',
            'text'  => 'Robots содержит noindex: страница не должна попадать в индекс',
        );
    } else {
        $issues[] = array(
            'level' => 'good',
            'text'  => 'Robots не запрещает индексацию',
        );

        $preview_checks = array(
            array( 'max-image-preview', 'large' ),
            array( 'max-snippet', '-1' ),
            array( 'max-video-preview', '-1' ),
        );
        $missing_preview_directives = array();

        foreach ( $preview_checks as $check ) {
            if ( ! dv_seo_tools_robots_has_directive( $robots, $check[0], $check[1] ) ) {
                $missing_preview_directives[] = $check[0] . ':' . $check[1];
            }
        }

        $issues[] = array(
            'level' => empty( $missing_preview_directives ) ? 'good' : 'warning',
            'text'  => empty( $missing_preview_directives )
                ? 'Robots preview-директивы найдены'
                : 'Не найдены preview-директивы robots: ' . implode( ', ', $missing_preview_directives ),
        );
    }

    $issues[] = array(
        'level' => (int) $report['json_ld'] > 0 ? 'good' : 'warning',
        'text'  => (int) $report['json_ld'] > 0 ? 'JSON-LD найден: ' . (int) $report['json_ld'] : 'JSON-LD не найден',
    );

    if ( ! empty( $report['json_ld_types'] ) && is_array( $report['json_ld_types'] ) ) {
        $issues[] = array(
            'level' => 'good',
            'text'  => 'Schema-типы: ' . implode( ', ', array_slice( $report['json_ld_types'], 0, 10 ) ),
        );
    } elseif ( (int) $report['json_ld'] > 0 ) {
        $issues[] = array(
            'level' => 'warning',
            'text'  => 'JSON-LD есть, но типы schema не распознаны',
        );
    }

    if ( ! empty( $report['expected_schema_types'] ) && is_array( $report['expected_schema_types'] ) ) {
        $found_types    = array_map( 'strtolower', (array) ( $report['json_ld_types'] ?? array() ) );
        $missing_types  = array();
        $expected_types = array_values( array_unique( array_map( 'sanitize_text_field', $report['expected_schema_types'] ) ) );

        foreach ( $expected_types as $type ) {
            if ( ! in_array( strtolower( $type ), $found_types, true ) ) {
                $missing_types[] = $type;
            }
        }

        $issues[] = array(
            'level' => empty( $missing_types ) ? 'good' : 'warning',
            'text'  => empty( $missing_types )
                ? 'Ожидаемые schema-типы найдены: ' . implode( ', ', $expected_types )
                : 'Не найдены ожидаемые schema-типы: ' . implode( ', ', $missing_types ),
        );
    }

    if ( empty( $report['og_image'] ) ) {
        $issues[] = array(
            'level' => 'warning',
            'text'  => 'OG image не найден: превью в мессенджерах может быть без картинки',
        );
    }

    if ( ! empty( $report['og_image'] ) ) {
        $issues[] = array(
            'level' => ! empty( $report['og_image_alt'] ) ? 'good' : 'warning',
            'text'  => ! empty( $report['og_image_alt'] ) ? 'Alt для OG image найден' : 'Alt для OG image не найден',
        );
    }

    return $issues;
}

function dv_seo_tools_render_head_report( $report ) {
    if ( is_wp_error( $report ) ) {
        ?>
        <div class="notice notice-error inline"><p><?php echo esc_html( $report->get_error_message() ); ?></p></div>
        <?php
        return;
    }

    $fields = array(
        'HTTP статус'    => (string) $report['status'],
        'X-Robots-Tag'   => $report['x_robots_tag'] ?? '',
        'Title'          => $report['title'],
        'Description'    => $report['description'],
        'Canonical'      => $report['canonical'],
        'Robots'         => $report['robots'],
        'OG title'       => $report['og_title'],
        'OG image'       => $report['og_image'],
        'OG image alt'   => $report['og_image_alt'],
        'JSON-LD блоков' => (string) $report['json_ld'],
        'JSON-LD типы'   => ! empty( $report['json_ld_types'] ) && is_array( $report['json_ld_types'] ) ? implode( ', ', $report['json_ld_types'] ) : '',
        'Ожидаемые schema' => ! empty( $report['expected_schema_types'] ) && is_array( $report['expected_schema_types'] ) ? implode( ', ', $report['expected_schema_types'] ) : '',
    );
    ?>
    <div class="dv-seo-tools-live-result">
        <h3>Результат проверки</h3>
        <p><a href="<?php echo esc_url( $report['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $report['url'] ); ?></a></p>
        <ul class="dv-seo-tools-issues">
            <?php foreach ( dv_seo_tools_get_head_issues( $report ) as $issue ) : ?>
                <li class="dv-seo-tools-issue dv-seo-tools-issue--<?php echo esc_attr( $issue['level'] ); ?>"><?php echo esc_html( $issue['text'] ); ?></li>
            <?php endforeach; ?>
        </ul>
        <table class="widefat striped">
            <tbody>
                <?php foreach ( $fields as $label => $value ) : ?>
                    <tr>
                        <th scope="row"><?php echo esc_html( $label ); ?></th>
                        <td>
                            <?php if ( '' !== trim( $value ) ) : ?>
                                <?php echo esc_html( $value ); ?>
                            <?php else : ?>
                                <span class="dv-seo-tools-muted">не найдено</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function dv_seo_tools_count_products_with_meta( $meta_key ) {
    global $wpdb;

    return (int) $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(DISTINCT p.ID)
             FROM {$wpdb->posts} p
             INNER JOIN {$wpdb->postmeta} pm ON pm.post_id = p.ID
             WHERE p.post_type = %s
               AND p.post_status = %s
               AND pm.meta_key = %s
               AND pm.meta_value <> ''",
            'product',
            'publish',
            $meta_key
        )
    );
}

function dv_seo_tools_count_terms_with_meta( $meta_key ) {
    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return 0;
    }

    $term_ids = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'fields'     => 'ids',
        )
    );

    if ( is_wp_error( $term_ids ) || empty( $term_ids ) ) {
        return 0;
    }

    $count = 0;
    foreach ( $term_ids as $term_id ) {
        $value = get_term_meta( (int) $term_id, $meta_key, true );
        if ( is_array( $value ) ? ! empty( $value ) : '' !== trim( (string) $value ) ) {
            $count++;
        }
    }

    return $count;
}

function dv_seo_tools_get_manual_overview() {
    $product_counts = function_exists( 'wp_count_posts' ) ? wp_count_posts( 'product' ) : null;
    $total_products = $product_counts && isset( $product_counts->publish ) ? (int) $product_counts->publish : 0;
    $total_terms    = 0;

    if ( taxonomy_exists( 'product_cat' ) ) {
        $term_count = wp_count_terms(
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );

        $total_terms = is_wp_error( $term_count ) ? 0 : (int) $term_count;
    }

    $priority_terms = array();
    if ( taxonomy_exists( 'product_cat' ) ) {
        $terms = get_terms(
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'number'     => 8,
                'orderby'    => 'count',
                'order'      => 'DESC',
            )
        );

        if ( ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $field_statuses = dv_seo_tools_get_term_field_statuses( $term );

                $priority_terms[] = array(
                    'term'           => $term,
                    'field_statuses' => $field_statuses,
                    'h1'             => ! empty( $field_statuses['h1']['filled'] ),
                    'intro'          => ! empty( $field_statuses['intro']['filled'] ),
                    'text'           => ! empty( $field_statuses['text']['filled'] ),
                    'faq'            => ! empty( $field_statuses['faq']['filled'] ),
                    'edit_link'      => get_edit_term_link( $term->term_id, 'product_cat' ),
                );
            }
        }
    }

    $effective_term_counts = dv_seo_tools_count_effective_term_fields();

    return array(
        'total_products'           => $total_products,
        'products_with_title'      => dv_seo_tools_count_products_with_meta( '_dv_seo_title' ),
        'products_with_desc'       => dv_seo_tools_count_products_with_meta( '_dv_seo_description' ),
        'total_terms'              => $total_terms,
        'terms_with_title'         => dv_seo_tools_count_terms_with_meta( '_dv_seo_title' ),
        'terms_with_desc'          => dv_seo_tools_count_terms_with_meta( '_dv_seo_description' ),
        'terms_with_h1'            => dv_seo_tools_count_terms_with_meta( '_dv_seo_h1' ),
        'terms_with_intro'         => dv_seo_tools_count_terms_with_meta( '_dv_seo_intro' ),
        'terms_with_text'          => dv_seo_tools_count_terms_with_meta( '_dv_seo_text' ),
        'terms_with_faq'           => dv_seo_tools_count_terms_with_meta( '_dv_seo_faq' ),
        'terms_effective_title'    => $effective_term_counts['title'],
        'terms_effective_desc'     => $effective_term_counts['description'],
        'terms_effective_h1'       => $effective_term_counts['h1'],
        'terms_effective_intro'    => $effective_term_counts['intro'],
        'terms_effective_text'     => $effective_term_counts['text'],
        'terms_effective_faq'      => $effective_term_counts['faq'],
        'priority_terms'           => $priority_terms,
    );
}

function dv_seo_tools_render_fill_badge( $state ) {
    if ( is_array( $state ) ) {
        $status = (string) ( $state['status'] ?? 'none' );
    } else {
        $status = $state ? 'manual' : 'none';
    }

    $labels = array(
        'manual' => 'ручной',
        'auto'   => 'авто',
        'none'   => 'нет',
    );

    if ( ! isset( $labels[ $status ] ) ) {
        $status = 'none';
    }
    ?>
    <span class="dv-seo-tools-fill dv-seo-tools-fill--<?php echo esc_attr( $status ); ?>">
        <?php echo esc_html( $labels[ $status ] ); ?>
    </span>
    <?php
}

function dv_seo_tools_render_manual_overview( $overview ) {
    ?>
    <details id="dv-seo-manual" class="dv-seo-tools-card dv-seo-tools-card--wide dv-seo-tools-section">
        <summary>
            <span class="dv-seo-tools-section-heading">
                <span class="dv-seo-tools-section-title">SEO-поля и автоматика</span>
                <span class="dv-seo-tools-section-note">ручные overrides и автоматическое покрытие title/description, H1, текстов и FAQ</span>
            </span>
        </summary>
        <div class="dv-seo-tools-section-body">

        <div class="dv-seo-tools-manual-grid">
            <div>
                <h3>Товары: ручные overrides</h3>
                <dl class="dv-seo-tools-stats">
                    <dt>Всего товаров</dt><dd><?php echo esc_html( number_format_i18n( $overview['total_products'] ) ); ?></dd>
                    <dt>С ручным title</dt><dd><?php echo esc_html( number_format_i18n( $overview['products_with_title'] ) ); ?></dd>
                    <dt>С ручным description</dt><dd><?php echo esc_html( number_format_i18n( $overview['products_with_desc'] ) ); ?></dd>
                </dl>
            </div>
            <div>
                <h3>Категории</h3>
                <dl class="dv-seo-tools-stats">
                    <dt>Всего категорий</dt><dd><?php echo esc_html( number_format_i18n( $overview['total_terms'] ) ); ?></dd>
                    <dt>Title</dt><dd><?php echo esc_html( number_format_i18n( $overview['terms_with_title'] ) . ' ручн. / ' . number_format_i18n( max( 0, $overview['terms_effective_title'] - $overview['terms_with_title'] ) ) . ' авто' ); ?></dd>
                    <dt>Description</dt><dd><?php echo esc_html( number_format_i18n( $overview['terms_with_desc'] ) . ' ручн. / ' . number_format_i18n( max( 0, $overview['terms_effective_desc'] - $overview['terms_with_desc'] ) ) . ' авто' ); ?></dd>
                    <dt>SEO H1</dt><dd><?php echo esc_html( number_format_i18n( $overview['terms_with_h1'] ) . ' ручн. / ' . number_format_i18n( max( 0, $overview['terms_effective_h1'] - $overview['terms_with_h1'] ) ) . ' авто' ); ?></dd>
                    <dt>Верхний текст</dt><dd><?php echo esc_html( number_format_i18n( $overview['terms_with_intro'] ) . ' ручн. / ' . number_format_i18n( max( 0, $overview['terms_effective_intro'] - $overview['terms_with_intro'] ) ) . ' авто' ); ?></dd>
                    <dt>Нижний текст</dt><dd><?php echo esc_html( number_format_i18n( $overview['terms_with_text'] ) . ' ручн. / ' . number_format_i18n( max( 0, $overview['terms_effective_text'] - $overview['terms_with_text'] ) ) . ' авто' ); ?></dd>
                    <dt>FAQ</dt><dd><?php echo esc_html( number_format_i18n( $overview['terms_with_faq'] ) . ' ручн. / ' . number_format_i18n( max( 0, $overview['terms_effective_faq'] - $overview['terms_with_faq'] ) ) . ' авто' ); ?></dd>
                </dl>
            </div>
        </div>

        <?php if ( ! empty( $overview['priority_terms'] ) ) : ?>
            <h3>Крупные категории: ручное и авто-покрытие</h3>
            <div class="dv-seo-tools-table-controls" data-dv-seo-category-controls>
                <label>
                    <span>Поиск категории</span>
                    <input type="search" data-dv-seo-category-search placeholder="Например: арки">
                </label>
                <label>
                    <span>Готовность</span>
                    <select data-dv-seo-category-filter>
                        <option value="all">Все категории</option>
                        <option value="incomplete">Не готовые</option>
                        <option value="almost">Почти готовые 75%+</option>
                        <option value="ready">Готовые 100%</option>
                    </select>
                </label>
                <label>
                    <span>Сортировка</span>
                    <select data-dv-seo-category-sort>
                        <option value="products-desc">Больше товаров</option>
                        <option value="ready-asc">Сначала менее готовые</option>
                        <option value="ready-desc">Сначала более готовые</option>
                        <option value="name-asc">По названию</option>
                    </select>
                </label>
                <span class="dv-seo-tools-table-count" data-dv-seo-category-count></span>
            </div>
            <table class="widefat striped dv-seo-tools-fill-table" data-dv-seo-category-table>
                <thead>
                    <tr>
                        <th>Категория</th>
                        <th>Товаров</th>
                        <th>H1</th>
                        <th>Верхний текст</th>
                        <th>Нижний текст</th>
                        <th>FAQ</th>
                        <th>Готовность</th>
                        <th>Недостаёт</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $overview['priority_terms'] as $item ) : ?>
                        <?php
                        $missing_parts = array();
                        $field_labels  = array(
                            'h1'    => 'SEO H1',
                            'intro' => 'верхний текст',
                            'text'  => 'нижний текст',
                            'faq'   => 'FAQ',
                        );

                        foreach ( $field_labels as $field_key => $field_label ) {
                            if ( empty( $item['field_statuses'][ $field_key ]['filled'] ) ) {
                                $missing_parts[] = $field_label;
                            }
                        }

                        $ready_count = (int) ! empty( $item['field_statuses']['h1']['filled'] )
                            + (int) ! empty( $item['field_statuses']['intro']['filled'] )
                            + (int) ! empty( $item['field_statuses']['text']['filled'] )
                            + (int) ! empty( $item['field_statuses']['faq']['filled'] );
                        $ready_percent = dv_seo_tools_percent( $ready_count, 4 );
                        ?>
                        <tr data-name="<?php echo esc_attr( function_exists( 'dv_seo_mb_strtolower' ) ? dv_seo_mb_strtolower( $item['term']->name ) : strtolower( $item['term']->name ) ); ?>" data-products="<?php echo esc_attr( (int) $item['term']->count ); ?>" data-ready="<?php echo esc_attr( $ready_percent ); ?>">
                            <td><strong><?php echo esc_html( $item['term']->name ); ?></strong></td>
                            <td><?php echo esc_html( number_format_i18n( (int) $item['term']->count ) ); ?></td>
                            <td><?php dv_seo_tools_render_fill_badge( $item['field_statuses']['h1'] ?? array( 'status' => 'none' ) ); ?></td>
                            <td><?php dv_seo_tools_render_fill_badge( $item['field_statuses']['intro'] ?? array( 'status' => 'none' ) ); ?></td>
                            <td><?php dv_seo_tools_render_fill_badge( $item['field_statuses']['text'] ?? array( 'status' => 'none' ) ); ?></td>
                            <td><?php dv_seo_tools_render_fill_badge( $item['field_statuses']['faq'] ?? array( 'status' => 'none' ) ); ?></td>
                            <td>
                                <span class="dv-seo-tools-mini-progress">
                                    <i style="width: <?php echo esc_attr( $ready_percent ); ?>%;"></i>
                                    <b><?php echo esc_html( $ready_percent ); ?>%</b>
                                </span>
                            </td>
                            <td>
                                <?php if ( empty( $missing_parts ) ) : ?>
                                    <span class="dv-seo-tools-ready-note">покрыто</span>
                                <?php else : ?>
                                    <span class="dv-seo-tools-missing-note"><?php echo esc_html( implode( ', ', $missing_parts ) ); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ( $item['edit_link'] ) : ?>
                                    <a class="button button-small" href="<?php echo esc_url( $item['edit_link'] ); ?>">Редактировать</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="dv-seo-tools-empty-row" data-dv-seo-category-empty hidden>
                        <td colspan="9">По текущим условиям категории не найдены.</td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
        </div>
    </details>
    <?php
}

function dv_seo_tools_product_gaps_cache_key( $sample_limit = 8 ) {
    return 'dv_seo_product_gaps_v1_' . absint( $sample_limit );
}

function dv_seo_tools_product_gaps_snapshot_key( $sample_limit = 8 ) {
    return 'dv_seo_product_gaps_snapshot_v1_' . absint( $sample_limit );
}

function dv_seo_tools_product_gaps_batch_key( $sample_limit = 8 ) {
    return 'dv_seo_product_gaps_batch_v1_' . absint( $sample_limit );
}

function dv_seo_tools_product_audit_state_key() {
    return 'dv_seo_product_audit_state_v1';
}

function dv_seo_tools_product_audit_cron_hook() {
    return 'dv_seo_tools_product_audit_cron_step';
}

function dv_seo_tools_get_product_audit_state() {
    $state = get_option( dv_seo_tools_product_audit_state_key(), array() );

    if ( ! is_array( $state ) ) {
        $state = array();
    }

    return wp_parse_args(
        $state,
        array(
            'status'       => 'idle',
            'offset'       => 0,
            'processed'    => 0,
            'total'        => dv_seo_tools_get_product_total_light(),
            'percent'      => 0,
            'batch_size'   => 150,
            'sample_limit' => 8,
            'started_at'   => 0,
            'updated_at'   => 0,
            'completed_at' => 0,
            'message'      => '',
        )
    );
}

function dv_seo_tools_update_product_audit_state( $state ) {
    $state = wp_parse_args( (array) $state, dv_seo_tools_get_product_audit_state() );
    update_option( dv_seo_tools_product_audit_state_key(), $state, false );

    return $state;
}

function dv_seo_tools_schedule_product_audit_event( $delay = 5 ) {
    $hook = dv_seo_tools_product_audit_cron_hook();

    if ( ! wp_next_scheduled( $hook ) ) {
        wp_schedule_single_event( time() + max( 1, absint( $delay ) ), $hook );
    }
}

function dv_seo_tools_schedule_product_audit( $sample_limit = 8, $batch_size = 150 ) {
    $sample_limit = max( 1, absint( $sample_limit ) );
    $batch_size   = max( 20, min( 500, absint( $batch_size ) ) );

    dv_seo_tools_clear_product_gaps_cache();
    delete_option( dv_seo_tools_product_gaps_batch_key( $sample_limit ) );

    $state = array(
        'status'       => 'running',
        'offset'       => 0,
        'processed'    => 0,
        'total'        => dv_seo_tools_get_product_total_light(),
        'percent'      => 0,
        'batch_size'   => $batch_size,
        'sample_limit' => $sample_limit,
        'started_at'   => time(),
        'updated_at'   => time(),
        'completed_at' => 0,
        'message'      => 'Фоновый SEO-аудит товаров запущен.',
    );

    dv_seo_tools_update_product_audit_state( $state );
    dv_seo_tools_schedule_product_audit_event();

    return $state;
}

function dv_seo_tools_clear_product_gaps_cache() {
    global $wpdb;

    delete_transient( dv_seo_tools_product_gaps_cache_key() );

    if ( $wpdb ) {
        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
                $wpdb->esc_like( '_transient_dv_seo_product_gaps_v1_' ) . '%',
                $wpdb->esc_like( '_transient_timeout_dv_seo_product_gaps_v1_' ) . '%'
            )
        );
    }
}

function dv_seo_tools_clear_product_gaps_cache_for_post( $post_id ) {
    if ( 'product' === get_post_type( absint( $post_id ) ) ) {
        dv_seo_tools_clear_product_gaps_cache();
    }
}
add_action( 'save_post_product', 'dv_seo_tools_clear_product_gaps_cache_for_post', 10, 1 );
add_action( 'trashed_post', 'dv_seo_tools_clear_product_gaps_cache_for_post', 10, 1 );
add_action( 'untrashed_post', 'dv_seo_tools_clear_product_gaps_cache_for_post', 10, 1 );
add_action( 'deleted_post', 'dv_seo_tools_clear_product_gaps_cache_for_post', 10, 1 );

function dv_seo_tools_clear_product_gaps_cache_for_meta( $meta_id, $post_id, $meta_key = '' ) {
    $meta_key     = (string) $meta_key;
    $watched_keys = array( '_thumbnail_id', '_product_image_gallery', '_sku' );

    if ( '_wp_attachment_image_alt' === $meta_key ) {
        dv_seo_tools_clear_product_gaps_cache();
        return;
    }

    if ( in_array( $meta_key, $watched_keys, true ) ) {
        dv_seo_tools_clear_product_gaps_cache_for_post( $post_id );
    }
}
add_action( 'added_post_meta', 'dv_seo_tools_clear_product_gaps_cache_for_meta', 10, 3 );
add_action( 'updated_post_meta', 'dv_seo_tools_clear_product_gaps_cache_for_meta', 10, 3 );
add_action( 'deleted_post_meta', 'dv_seo_tools_clear_product_gaps_cache_for_meta', 10, 3 );

function dv_seo_tools_get_product_total_light() {
    $counts = wp_count_posts( 'product' );

    return $counts && isset( $counts->publish ) ? (int) $counts->publish : 0;
}

function dv_seo_tools_empty_product_gaps_result( $sample_limit = 8, $audit_pending = false ) {
    $sample_limit = max( 1, absint( $sample_limit ) );

    return array(
        'total'               => dv_seo_tools_get_product_total_light(),
        'missing_image'       => 0,
        'missing_image_alt'   => 0,
        'missing_gallery'     => 0,
        'missing_description' => 0,
        'missing_short_desc'  => 0,
        'missing_sku'         => 0,
        'audit_pending'       => (bool) $audit_pending,
        'is_stale'            => false,
        'checked_at'          => 0,
        'sample_limit'        => $sample_limit,
        'samples'             => array(
            'missing_image'       => array(),
            'missing_image_alt'   => array(),
            'missing_gallery'     => array(),
            'missing_description' => array(),
            'missing_short_desc'  => array(),
            'missing_sku'         => array(),
        ),
    );
}

function dv_seo_tools_add_product_gap_sample( &$result, $key, $sample_item, $sample_limit ) {
    if ( ! isset( $result[ $key ] ) ) {
        $result[ $key ] = 0;
    }

    $result[ $key ]++;

    if ( ! isset( $result['samples'][ $key ] ) || ! is_array( $result['samples'][ $key ] ) ) {
        $result['samples'][ $key ] = array();
    }

    if ( count( $result['samples'][ $key ] ) < $sample_limit ) {
        $result['samples'][ $key ][] = $sample_item;
    }
}

function dv_seo_tools_scan_product_gap_ids( &$result, $product_ids, $sample_limit = 8 ) {
    if ( ! function_exists( 'wc_get_product' ) || empty( $product_ids ) ) {
        return;
    }

    $sample_limit = max( 1, absint( $sample_limit ) );

    foreach ( $product_ids as $product_id ) {
        $product_id  = (int) $product_id;
        $product     = wc_get_product( $product_id );
        $title       = get_the_title( $product_id );
        $edit_link   = get_edit_post_link( $product_id, '' );
        $permalink   = get_permalink( $product_id );
        $content     = trim( wp_strip_all_tags( (string) get_post_field( 'post_content', $product_id ) ) );
        $excerpt     = trim( wp_strip_all_tags( (string) get_post_field( 'post_excerpt', $product_id ) ) );
        $seo_sku     = $product && function_exists( 'dv_get_product_seo_sku' ) ? dv_get_product_seo_sku( $product ) : '';
        $sample_item = array(
            'title'     => $title,
            'edit_link' => $edit_link,
            'url'       => $permalink,
        );

        $thumbnail_id = absint( get_post_thumbnail_id( $product_id ) );
        $gallery_ids  = $product ? $product->get_gallery_image_ids() : array();

        if ( ! $thumbnail_id ) {
            dv_seo_tools_add_product_gap_sample( $result, 'missing_image', $sample_item, $sample_limit );
        } else {
            $image_alt = trim( (string) get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) );

            if ( '' === $image_alt ) {
                dv_seo_tools_add_product_gap_sample( $result, 'missing_image_alt', $sample_item, $sample_limit );
            }
        }

        if ( empty( $gallery_ids ) ) {
            dv_seo_tools_add_product_gap_sample( $result, 'missing_gallery', $sample_item, $sample_limit );
        }

        if ( '' === $content ) {
            dv_seo_tools_add_product_gap_sample( $result, 'missing_description', $sample_item, $sample_limit );
        }

        if ( '' === $excerpt ) {
            dv_seo_tools_add_product_gap_sample( $result, 'missing_short_desc', $sample_item, $sample_limit );
        }

        if ( '' === trim( (string) $seo_sku ) ) {
            dv_seo_tools_add_product_gap_sample( $result, 'missing_sku', $sample_item, $sample_limit );
        }
    }
}

function dv_seo_tools_get_product_seo_gaps( $sample_limit = 8, $force_refresh = false ) {
    $sample_limit = max( 1, absint( $sample_limit ) );
    $cache_key    = dv_seo_tools_product_gaps_cache_key( $sample_limit );

    if ( ! $force_refresh ) {
        $cached = get_transient( $cache_key );

        if ( is_array( $cached ) ) {
            $cached['audit_pending'] = false;
            $cached['is_stale']      = false;
            return $cached;
        }

        $snapshot = get_option( dv_seo_tools_product_gaps_snapshot_key( $sample_limit ), array() );
        if ( is_array( $snapshot ) && ! empty( $snapshot ) ) {
            $snapshot['audit_pending'] = false;
            $snapshot['is_stale']      = true;
            return $snapshot;
        }

        return dv_seo_tools_empty_product_gaps_result( $sample_limit, true );
    }

    $result = dv_seo_tools_empty_product_gaps_result( $sample_limit, false );

    if ( ! function_exists( 'wc_get_product' ) ) {
        return $result;
    }

    $product_ids = get_posts(
        array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'fields'         => 'ids',
            'posts_per_page' => -1,
            'no_found_rows'  => true,
        )
    );

    $result['total'] = count( $product_ids );
    dv_seo_tools_scan_product_gap_ids( $result, $product_ids, $sample_limit );

    $result['audit_pending'] = false;
    $result['is_stale']      = false;
    $result['checked_at']    = time();

    set_transient( $cache_key, $result, 6 * HOUR_IN_SECONDS );
    update_option( dv_seo_tools_product_gaps_snapshot_key( $sample_limit ), $result, false );

    return $result;
}

function dv_seo_tools_run_product_audit_batch( $offset = 0, $limit = 150, $sample_limit = 8, $reset = false ) {
    $offset       = max( 0, absint( $offset ) );
    $limit        = max( 20, min( 500, absint( $limit ) ) );
    $sample_limit = max( 1, absint( $sample_limit ) );
    $total        = dv_seo_tools_get_product_total_light();
    $batch_key    = dv_seo_tools_product_gaps_batch_key( $sample_limit );

    if ( $reset || 0 === $offset ) {
        dv_seo_tools_clear_product_gaps_cache();
        $result = dv_seo_tools_empty_product_gaps_result( $sample_limit, false );
    } else {
        $result = get_option( $batch_key, array() );
        if ( ! is_array( $result ) || empty( $result ) ) {
            $result = dv_seo_tools_empty_product_gaps_result( $sample_limit, false );
        }
    }

    $result['total'] = $total;

    $product_ids = get_posts(
        array(
            'post_type'              => 'product',
            'post_status'            => 'publish',
            'fields'                 => 'ids',
            'posts_per_page'         => $limit,
            'offset'                 => $offset,
            'orderby'                => 'ID',
            'order'                  => 'ASC',
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        )
    );

    dv_seo_tools_scan_product_gap_ids( $result, $product_ids, $sample_limit );

    $processed  = count( $product_ids );
    $next       = min( $total, $offset + $processed );
    $is_done    = 0 === $processed || $next >= $total;
    $percentage = $total > 0 ? (int) round( ( $next / $total ) * 100 ) : 100;

    $result['audit_pending'] = false;
    $result['is_stale']      = false;
    $result['checked_at']    = $is_done ? time() : 0;

    if ( $is_done ) {
        delete_option( $batch_key );
        set_transient( dv_seo_tools_product_gaps_cache_key( $sample_limit ), $result, 6 * HOUR_IN_SECONDS );
        update_option( dv_seo_tools_product_gaps_snapshot_key( $sample_limit ), $result, false );
    } else {
        update_option( $batch_key, $result, false );
    }

    return array(
        'done'       => $is_done,
        'offset'     => $next,
        'processed'  => $next,
        'total'      => $total,
        'percent'    => max( 0, min( 100, $percentage ) ),
        'batch_size' => $limit,
    );
}

function dv_seo_tools_run_product_audit_cron_step() {
    $lock_key = 'dv_seo_product_audit_cron_lock';

    if ( get_transient( $lock_key ) ) {
        dv_seo_tools_schedule_product_audit_event( 60 );
        return;
    }

    set_transient( $lock_key, 1, 5 * MINUTE_IN_SECONDS );

    $state = dv_seo_tools_get_product_audit_state();

    if ( 'running' !== ( $state['status'] ?? '' ) ) {
        delete_transient( $lock_key );
        return;
    }

    $offset       = absint( $state['offset'] ?? 0 );
    $batch_size   = absint( $state['batch_size'] ?? 150 );
    $sample_limit = absint( $state['sample_limit'] ?? 8 );
    $result       = dv_seo_tools_run_product_audit_batch( $offset, $batch_size, $sample_limit, 0 === $offset );

    $next_state = array(
        'status'       => ! empty( $result['done'] ) ? 'completed' : 'running',
        'offset'       => absint( $result['offset'] ?? 0 ),
        'processed'    => absint( $result['processed'] ?? 0 ),
        'total'        => absint( $result['total'] ?? 0 ),
        'percent'      => absint( $result['percent'] ?? 0 ),
        'batch_size'   => absint( $result['batch_size'] ?? $batch_size ),
        'sample_limit' => max( 1, $sample_limit ),
        'started_at'   => absint( $state['started_at'] ?? time() ),
        'updated_at'   => time(),
        'completed_at' => ! empty( $result['done'] ) ? time() : 0,
        'message'      => ! empty( $result['done'] )
            ? 'Фоновый SEO-аудит товаров завершён.'
            : 'Фоновый SEO-аудит товаров выполняется.',
    );

    dv_seo_tools_update_product_audit_state( $next_state );
    delete_transient( $lock_key );

    if ( empty( $result['done'] ) ) {
        dv_seo_tools_schedule_product_audit_event( 30 );
    }
}
add_action( dv_seo_tools_product_audit_cron_hook(), 'dv_seo_tools_run_product_audit_cron_step' );

function dv_seo_tools_ajax_product_audit_batch() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( array( 'message' => 'Недостаточно прав.' ), 403 );
    }

    check_ajax_referer( 'dv_seo_tools_product_audit_batch', 'nonce' );

    $offset = isset( $_POST['offset'] ) ? absint( $_POST['offset'] ) : 0;
    $reset  = ! empty( $_POST['reset'] );
    $result = dv_seo_tools_run_product_audit_batch( $offset, 150, 8, $reset );

    wp_send_json_success( $result );
}
add_action( 'wp_ajax_dv_seo_tools_product_audit_batch', 'dv_seo_tools_ajax_product_audit_batch' );

function dv_seo_tools_ajax_schedule_product_audit() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( array( 'message' => 'Недостаточно прав.' ), 403 );
    }

    check_ajax_referer( 'dv_seo_tools_schedule_product_audit', 'nonce' );

    wp_send_json_success( dv_seo_tools_schedule_product_audit() );
}
add_action( 'wp_ajax_dv_seo_tools_schedule_product_audit', 'dv_seo_tools_ajax_schedule_product_audit' );

function dv_seo_tools_ajax_product_audit_status() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( array( 'message' => 'Недостаточно прав.' ), 403 );
    }

    check_ajax_referer( 'dv_seo_tools_product_audit_status', 'nonce' );

    wp_send_json_success( dv_seo_tools_get_product_audit_state() );
}
add_action( 'wp_ajax_dv_seo_tools_product_audit_status', 'dv_seo_tools_ajax_product_audit_status' );

function dv_seo_tools_render_product_gaps( $gaps ) {
    $cards = array(
        'missing_image'       => array( 'Товары без фото', 'Для Яндекса и карточек в выдаче лучше иметь основное изображение.' ),
        'missing_image_alt'   => array( 'Alt основного фото', 'Alt помогает поиску картинок и превью карточек.' ),
        'missing_gallery'     => array( 'Без галереи', 'Дополнительные фото усиливают карточку товара и image sitemap.' ),
        'missing_description' => array( 'Без полного описания', 'Описание помогает посадочной странице товара быть полезнее и уникальнее.' ),
        'missing_short_desc'  => array( 'Без краткого описания', 'Краткий текст используется в верхней части карточки товара.' ),
        'missing_sku'         => array( 'Без SEO SKU', 'SKU берётся из атрибута SKU или артикула товара и участвует в SEO title/description.' ),
    );
    ?>
    <details id="dv-seo-products" class="dv-seo-tools-card dv-seo-tools-card--wide dv-seo-tools-section">
        <summary>
            <span class="dv-seo-tools-section-heading">
                <span class="dv-seo-tools-section-title">SEO-качество товаров</span>
                <span class="dv-seo-tools-section-note">фото, alt, галерея, описания и SEO SKU</span>
            </span>
        </summary>
        <div class="dv-seo-tools-section-body">
        <?php if ( ! empty( $gaps['audit_pending'] ) ) : ?>
            <div class="dv-seo-tools-empty-state">
                SEO-аудит товаров ещё не запускался. Нажмите «Обновить SEO-аудит товаров» в технической сводке: проверка пройдёт каталог один раз и сохранит результат в кеш.
            </div>
        <?php elseif ( ! empty( $gaps['is_stale'] ) ) : ?>
            <div class="dv-seo-tools-empty-state">
                Показан последний сохранённый аудит товаров. После изменений каталога его лучше обновить кнопкой «Обновить SEO-аудит товаров».
            </div>
        <?php endif; ?>

        <div class="dv-seo-tools-gap-grid">
            <?php foreach ( $cards as $key => $card ) : ?>
                <div class="dv-seo-tools-gap-card">
                    <strong><?php echo esc_html( $card[0] ); ?></strong>
                    <span><?php echo esc_html( number_format_i18n( (int) ( $gaps[ $key ] ?? 0 ) ) ); ?></span>
                    <p><?php echo esc_html( $card[1] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <details class="dv-seo-tools-gap-details">
            <summary>Показать примеры проблемных товаров</summary>
            <?php foreach ( $cards as $key => $card ) : ?>
                <?php if ( empty( $gaps['samples'][ $key ] ) ) : ?>
                    <?php continue; ?>
                <?php endif; ?>
                <h3><?php echo esc_html( $card[0] ); ?></h3>
                <table class="widefat striped">
                    <tbody>
                        <?php foreach ( $gaps['samples'][ $key ] as $item ) : ?>
                            <tr>
                                <td>
                                    <strong><?php echo esc_html( $item['title'] ); ?></strong>
                                    <?php if ( ! empty( $item['url'] ) ) : ?>
                                        <br><a href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener">Открыть товар</a>
                                    <?php endif; ?>
                                </td>
                                <td class="dv-seo-tools-actions">
                                    <?php if ( ! empty( $item['edit_link'] ) ) : ?>
                                        <a class="button button-small" href="<?php echo esc_url( $item['edit_link'] ); ?>">Редактировать</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endforeach; ?>
        </details>
        </div>
    </details>
    <?php
}

function dv_seo_tools_find_first_priority_term_missing( $overview, $key ) {
    if ( empty( $overview['priority_terms'] ) || ! is_array( $overview['priority_terms'] ) ) {
        return '';
    }

    foreach ( $overview['priority_terms'] as $item ) {
        if ( empty( $item[ $key ] ) && ! empty( $item['edit_link'] ) ) {
            return $item['edit_link'];
        }
    }

    return '';
}

function dv_seo_tools_find_first_product_gap_link( $gaps, $key ) {
    if ( empty( $gaps['samples'][ $key ][0]['edit_link'] ) ) {
        return '';
    }

    return $gaps['samples'][ $key ][0]['edit_link'];
}

function dv_seo_tools_percent( $part, $total ) {
    $total = (int) $total;
    if ( $total <= 0 ) {
        return 0;
    }

    return max( 0, min( 100, (int) round( ( (int) $part / $total ) * 100 ) ) );
}

function dv_seo_tools_term_meta_filled( $term_id, $meta_key ) {
    $value = get_term_meta( $term_id, $meta_key, true );

    if ( is_array( $value ) ) {
        return ! empty( $value );
    }

    return '' !== trim( wp_strip_all_tags( (string) $value ) );
}

function dv_seo_tools_term_auto_value_filled( $term, $field ) {
    if ( ! $term instanceof WP_Term ) {
        return false;
    }

    switch ( $field ) {
        case 'title':
            return function_exists( 'dv_build_term_seo_title' ) && '' !== trim( (string) dv_build_term_seo_title( $term ) );
        case 'description':
            return function_exists( 'dv_build_term_seo_description' ) && '' !== trim( (string) dv_build_term_seo_description( $term ) );
        case 'h1':
            return function_exists( 'dv_build_term_auto_seo_h1' ) && '' !== trim( (string) dv_build_term_auto_seo_h1( $term ) );
        case 'intro':
            return function_exists( 'dv_get_term_effective_seo_intro' ) && '' !== trim( wp_strip_all_tags( (string) dv_get_term_effective_seo_intro( $term ) ) );
        case 'text':
            return function_exists( 'dv_get_term_effective_seo_text' ) && '' !== trim( wp_strip_all_tags( (string) dv_get_term_effective_seo_text( $term ) ) );
        case 'faq':
            return function_exists( 'dv_get_term_effective_seo_faq' ) && ! empty( dv_get_term_effective_seo_faq( $term ) );
    }

    return false;
}

function dv_seo_tools_get_term_field_statuses( $term ) {
    if ( ! $term instanceof WP_Term ) {
        return array();
    }

    $meta_keys = array(
        'title'       => '_dv_seo_title',
        'description' => '_dv_seo_description',
        'h1'          => '_dv_seo_h1',
        'intro'       => '_dv_seo_intro',
        'text'        => '_dv_seo_text',
        'faq'         => '_dv_seo_faq',
    );

    $statuses = array();
    foreach ( $meta_keys as $field => $meta_key ) {
        $manual = dv_seo_tools_term_meta_filled( $term->term_id, $meta_key );
        $auto   = ! $manual && dv_seo_tools_term_auto_value_filled( $term, $field );

        $statuses[ $field ] = array(
            'status' => $manual ? 'manual' : ( $auto ? 'auto' : 'none' ),
            'filled' => $manual || $auto,
            'manual' => $manual,
            'auto'   => $auto,
        );
    }

    return $statuses;
}

function dv_seo_tools_count_effective_term_fields() {
    $counts = array(
        'title'       => 0,
        'description' => 0,
        'h1'          => 0,
        'intro'       => 0,
        'text'        => 0,
        'faq'         => 0,
    );

    if ( ! taxonomy_exists( 'product_cat' ) ) {
        return $counts;
    }

    $terms = get_terms(
        array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        )
    );

    if ( is_wp_error( $terms ) ) {
        return $counts;
    }

    foreach ( $terms as $term ) {
        $statuses = dv_seo_tools_get_term_field_statuses( $term );
        foreach ( array_keys( $counts ) as $field ) {
            if ( ! empty( $statuses[ $field ]['filled'] ) ) {
                $counts[ $field ]++;
            }
        }
    }

    return $counts;
}

function dv_seo_tools_get_progress_summary( $overview, $gaps ) {
    $total_terms    = max( 0, (int) ( $overview['total_terms'] ?? 0 ) );
    $total_products = max( 0, (int) ( $gaps['total'] ?? 0 ) );
    $audit_pending  = ! empty( $gaps['audit_pending'] );

    $category_total = $total_terms * 4;
    $category_ready = (int) ( $overview['terms_effective_h1'] ?? 0 )
        + (int) ( $overview['terms_effective_intro'] ?? 0 )
        + (int) ( $overview['terms_effective_text'] ?? 0 )
        + (int) ( $overview['terms_effective_faq'] ?? 0 );

    $content_total = $total_products * 2;
    $content_ready = $audit_pending ? 0 : $content_total
        - (int) ( $gaps['missing_description'] ?? 0 )
        - (int) ( $gaps['missing_short_desc'] ?? 0 );

    $technical_total = $total_products * 4;
    $technical_ready = $audit_pending ? 0 : $technical_total
        - (int) ( $gaps['missing_image'] ?? 0 )
        - (int) ( $gaps['missing_image_alt'] ?? 0 )
        - (int) ( $gaps['missing_gallery'] ?? 0 )
        - (int) ( $gaps['missing_sku'] ?? 0 );

    return array(
        array(
            'title'   => 'Категории',
            'percent' => dv_seo_tools_percent( $category_ready, $category_total ),
            'text'    => 'Фактическое покрытие: ручные поля плюс автоматика H1, верхнего текста, нижнего блока и FAQ.',
        ),
        array(
            'title'   => 'Контент товаров',
            'percent' => dv_seo_tools_percent( $content_ready, $content_total ),
            'text'    => $audit_pending ? 'Нужно запустить аудит товаров для актуального среза.' : 'Полные и краткие описания карточек.',
        ),
        array(
            'title'   => 'Техническая готовность',
            'percent' => dv_seo_tools_percent( $technical_ready, $technical_total ),
            'text'    => $audit_pending ? 'Фото, alt, галерея и SEO SKU считаются ручным аудитом.' : 'Фото, alt, галерея и SEO SKU для товаров.',
        ),
    );
}

function dv_seo_tools_render_progress_summary( $summary ) {
    $progress_values = array_map(
        static function ( $item ) {
            return max( 0, min( 100, (int) ( $item['percent'] ?? 0 ) ) );
        },
        is_array( $summary ) ? $summary : array()
    );
    $average_progress = ! empty( $progress_values ) ? (int) round( array_sum( $progress_values ) / count( $progress_values ) ) : 0;
    ?>
    <details id="dv-seo-progress" class="dv-seo-tools-card dv-seo-tools-card--wide dv-seo-tools-section">
        <summary>
            <span class="dv-seo-tools-section-heading">
                <span class="dv-seo-tools-section-title">SEO-прогресс</span>
                <span class="dv-seo-tools-section-note">общий срез по категориям, карточкам и технической готовности</span>
            </span>
            <span class="dv-seo-tools-section-meta">
                <span><?php echo esc_html( $average_progress ); ?>% среднее</span>
            </span>
        </summary>
        <div class="dv-seo-tools-section-body">
        <div class="dv-seo-tools-progress-grid">
            <?php foreach ( $summary as $item ) : ?>
                <div class="dv-seo-tools-progress-card">
                    <div class="dv-seo-tools-progress-head">
                        <strong><?php echo esc_html( $item['title'] ); ?></strong>
                        <span><?php echo esc_html( (int) $item['percent'] ); ?>%</span>
                    </div>
                    <div class="dv-seo-tools-progress-bar" aria-hidden="true">
                        <i style="width: <?php echo esc_attr( (int) $item['percent'] ); ?>%;"></i>
                    </div>
                    <p><?php echo esc_html( $item['text'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
    </details>
    <?php
}

function dv_seo_tools_get_health_score( $summary, $actions, $stats, $robots_report = null, $sitemap_http_report = null ) {
    $percents = array();
    foreach ( $summary as $item ) {
        $percents[] = max( 0, min( 100, (int) ( $item['percent'] ?? 0 ) ) );
    }

    $base_score       = ! empty( $percents ) ? (int) round( array_sum( $percents ) / count( $percents ) ) : 0;
    $has_sitemap_http_report = is_array( $sitemap_http_report );
    $sitemap_ready    = ! empty( $stats['total'] ) && empty( $stats['warnings'] ) && ( ! $has_sitemap_http_report || ! empty( $sitemap_http_report['ready'] ) );
    $has_robots_report = is_array( $robots_report );
    $robots_ready     = ! $has_robots_report || empty( $robots_report['issues'] );
    $score            = max( 0, min( 100, (int) round( ( $base_score * 0.85 ) + ( $sitemap_ready ? 8 : 0 ) + ( $robots_ready ? 7 : 0 ) ) ) );
    $level         = 'bad';
    $label         = 'Требует внимания';
    $message       = 'Начните с критичных пропусков: фото, описания товаров и базовые тексты категорий.';

    if ( $score >= 85 ) {
        $level   = 'good';
        $label   = 'Хорошее состояние';
        $message = 'База SEO выглядит крепко. Дальше лучше точечно улучшать категории и проверять реальные HTML head.';
    } elseif ( $score >= 65 ) {
        $level   = 'warning';
        $label   = 'Нужно доработать';
        $message = 'Основные элементы есть, но часть посадочных страниц и товаров ещё просит ручной доработки.';
    }

    $action_counts = array(
        'bad'     => 0,
        'warning' => 0,
        'info'    => 0,
    );

    foreach ( $actions as $action ) {
        $action_level = sanitize_key( $action['level'] ?? 'info' );
        if ( ! isset( $action_counts[ $action_level ] ) ) {
            $action_level = 'info';
        }

        $action_counts[ $action_level ] += max( 0, (int) ( $action['count'] ?? 0 ) );
    }

    return array(
        'score'         => $score,
        'level'         => $level,
        'label'         => $label,
        'message'       => $message,
        'sitemap_ready' => $sitemap_ready,
        'robots_ready'  => $robots_ready,
        'action_counts' => $action_counts,
    );
}

function dv_seo_tools_render_health_score( $health ) {
    $score         = max( 0, min( 100, (int) ( $health['score'] ?? 0 ) ) );
    $level         = sanitize_key( $health['level'] ?? 'bad' );
    $action_counts = isset( $health['action_counts'] ) && is_array( $health['action_counts'] ) ? $health['action_counts'] : array();
    ?>
    <div id="dv-seo-health" class="dv-seo-tools-health dv-seo-tools-health--<?php echo esc_attr( $level ); ?>">
        <div class="dv-seo-tools-health-score" style="--dv-seo-health-score: <?php echo esc_attr( $score ); ?>%;">
            <span><?php echo esc_html( $score ); ?>%</span>
        </div>
        <div class="dv-seo-tools-health-copy">
            <span class="dv-seo-tools-health-label"><?php echo esc_html( $health['label'] ?? '' ); ?></span>
            <h2>SEO health score</h2>
            <p><?php echo esc_html( $health['message'] ?? '' ); ?></p>
        </div>
        <div class="dv-seo-tools-health-facts">
            <span>
                <strong><?php echo ! empty( $health['sitemap_ready'] ) ? esc_html__( 'OK', 'detalivam' ) : esc_html__( 'Нет', 'detalivam' ); ?></strong>
                sitemap
            </span>
            <span>
                <strong><?php echo ! empty( $health['robots_ready'] ) ? esc_html__( 'OK', 'detalivam' ) : esc_html__( 'Проверить', 'detalivam' ); ?></strong>
                robots
            </span>
            <span>
                <strong><?php echo esc_html( number_format_i18n( (int) ( $action_counts['bad'] ?? 0 ) ) ); ?></strong>
                критичных
            </span>
            <span>
                <strong><?php echo esc_html( number_format_i18n( (int) ( $action_counts['warning'] ?? 0 ) ) ); ?></strong>
                важных
            </span>
            <span>
                <strong><?php echo esc_html( number_format_i18n( (int) ( $action_counts['info'] ?? 0 ) ) ); ?></strong>
                мягких
            </span>
        </div>
    </div>
    <?php
}

function dv_seo_tools_template_generator_presets() {
    return array(
        'product'  => array(
            'label'    => 'Товар',
            'defaults' => array(
                'entity'   => 'Арка внутренняя задняя ВАЗ 2108',
                'sku'      => '2108-5101240',
                'category' => 'кузовные детали',
            ),
            'variants' => array(
                'commercial' => array(
                    'label'       => 'Коммерческий',
                    'title'       => '{entity}, {sku} - купить онлайн | {shop}',
                    'description' => '{entity} в разделе {category}: цена, наличие, подбор по марке авто, самовывоз и доставка по России.',
                ),
                'availability' => array(
                    'label'       => 'Наличие',
                    'title'       => '{entity} - в наличии, артикул {sku}',
                    'description' => 'Купить {entity}: артикул {sku}, наличие на складе, консультация по совместимости и доставка по России.',
                ),
                'fitment' => array(
                    'label'       => 'Совместимость',
                    'title'       => '{entity} для ВАЗ - цена и подбор | {shop}',
                    'description' => '{entity} для ремонта кузова. Поможем проверить совместимость, оформить заказ и подобрать замену по артикулу {sku}.',
                ),
            ),
        ),
        'category' => array(
            'label'    => 'Категория',
            'defaults' => array(
                'entity'   => 'Кузовные детали ВАЗ',
                'sku'      => '',
                'category' => 'кузовные детали',
            ),
            'variants' => array(
                'commercial' => array(
                    'label'       => 'Коммерческий',
                    'title'       => '{entity} - купить, цены в каталоге | {shop}',
                    'description' => '{entity}: цены, наличие, подбор по модели авто, самовывоз и доставка по России в интернет-магазине {shop}.',
                ),
                'landing' => array(
                    'label'       => 'Посадочный',
                    'title'       => '{entity} - каталог, наличие и доставка',
                    'description' => 'Раздел {category}: подбор деталей по авто, актуальное наличие, консультация менеджера и отправка заказов по России.',
                ),
                'local' => array(
                    'label'       => 'Локальный',
                    'title'       => '{entity} | {shop}',
                    'description' => 'Купить {entity}: самовывоз, проверка наличия, помощь с подбором и доставка транспортными компаниями.',
                ),
            ),
        ),
    );
}

function dv_seo_tools_render_template_generator() {
    $store   = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
    $presets = dv_seo_tools_template_generator_presets();
    $variant_count = 0;
    foreach ( $presets as $preset ) {
        $variant_count += isset( $preset['variants'] ) && is_array( $preset['variants'] ) ? count( $preset['variants'] ) : 0;
    }
    $payload = array(
        'presets' => $presets,
        'tokens'  => array(
            'city' => (string) ( $store['city'] ?? 'Тольятти' ),
            'shop' => (string) ( $store['name'] ?? get_bloginfo( 'name' ) ),
        ),
    );
    ?>
    <details id="dv-seo-templates" class="dv-seo-tools-card dv-seo-tools-card--wide dv-seo-tools-section">
        <summary>
            <span class="dv-seo-tools-section-heading">
                <span class="dv-seo-tools-section-title">Генератор SEO-шаблонов</span>
                <span class="dv-seo-tools-section-note">быстрые заготовки title и description для товаров и категорий</span>
            </span>
            <span class="dv-seo-tools-section-meta">
                <span><?php echo esc_html( number_format_i18n( count( $presets ) ) ); ?> типа</span>
                <span><?php echo esc_html( number_format_i18n( $variant_count ) ); ?> сценариев</span>
            </span>
        </summary>
        <div class="dv-seo-tools-section-body">
            <div class="dv-seo-template-generator" data-dv-seo-template-generator="<?php echo esc_attr( wp_json_encode( $payload ) ); ?>">
                <div class="dv-seo-template-controls">
                    <label>
                        <span>Тип</span>
                        <select data-dv-template-type>
                            <?php foreach ( $presets as $type => $preset ) : ?>
                                <option value="<?php echo esc_attr( $type ); ?>"><?php echo esc_html( $preset['label'] ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>
                        <span>Сценарий</span>
                        <select data-dv-template-variant></select>
                    </label>
                    <label>
                        <span>Название</span>
                        <input type="text" data-dv-template-entity>
                    </label>
                    <label>
                        <span>Артикул / SKU</span>
                        <input type="text" data-dv-template-sku>
                    </label>
                    <label>
                        <span>Категория</span>
                        <input type="text" data-dv-template-category>
                    </label>
                    <label>
                        <span>Город</span>
                        <input type="text" data-dv-template-city value="<?php echo esc_attr( $payload['tokens']['city'] ); ?>">
                    </label>
                    <label>
                        <span>Магазин</span>
                        <input type="text" data-dv-template-shop value="<?php echo esc_attr( $payload['tokens']['shop'] ); ?>">
                    </label>
                </div>
                <div class="dv-seo-template-result">
                    <article>
                        <div>
                            <strong>SEO Title</strong>
                            <span data-dv-template-title-count></span>
                        </div>
                        <p data-dv-template-title></p>
                        <button type="button" class="button button-secondary" data-dv-template-copy="title">Скопировать title</button>
                    </article>
                    <article>
                        <div>
                            <strong>SEO Description</strong>
                            <span data-dv-template-description-count></span>
                        </div>
                        <p data-dv-template-description></p>
                        <button type="button" class="button button-secondary" data-dv-template-copy="description">Скопировать description</button>
                    </article>
                </div>
                <p class="description">Поддерживаемые токены: <code>{entity}</code>, <code>{sku}</code>, <code>{category}</code>, <code>{city}</code>, <code>{shop}</code>. Заготовки можно вставлять в SEO-поля товара или категории и затем подправлять вручную.</p>
            </div>
        </div>
    </details>
    <?php
}

function dv_seo_tools_duplicate_sample_links( $ids, $type ) {
    $links = array();
    $ids   = array_slice(
        array_filter(
            array_map( 'absint', explode( ',', (string) $ids ) )
        ),
        0,
        4
    );

    foreach ( $ids as $id ) {
        if ( 'term' === $type ) {
            $url = get_edit_term_link( $id, 'product_cat' );
        } else {
            $url = get_edit_post_link( $id, '' );
        }

        if ( is_string( $url ) && '' !== $url ) {
            $links[] = array(
                'id'  => $id,
                'url' => $url,
            );
        }
    }

    return $links;
}

function dv_seo_tools_query_duplicate_meta_groups( $object_type, $meta_key, $limit = 6 ) {
    global $wpdb;

    $limit = max( 1, min( 20, absint( $limit ) ) );

    if ( 'term' === $object_type ) {
        $rows = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT tm.meta_value AS value, COUNT(*) AS total, GROUP_CONCAT(tm.term_id ORDER BY tm.term_id DESC SEPARATOR ',') AS ids
                FROM {$wpdb->termmeta} tm
                INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_id = tm.term_id
                WHERE tm.meta_key = %s AND tt.taxonomy = %s AND TRIM(tm.meta_value) <> ''
                GROUP BY tm.meta_value
                HAVING COUNT(*) > 1
                ORDER BY total DESC
                LIMIT %d",
                $meta_key,
                'product_cat',
                $limit
            ),
            ARRAY_A
        ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
    } else {
        $rows = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT pm.meta_value AS value, COUNT(*) AS total, GROUP_CONCAT(pm.post_id ORDER BY pm.post_id DESC SEPARATOR ',') AS ids
                FROM {$wpdb->postmeta} pm
                INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                WHERE pm.meta_key = %s AND p.post_type = %s AND p.post_status = %s AND TRIM(pm.meta_value) <> ''
                GROUP BY pm.meta_value
                HAVING COUNT(*) > 1
                ORDER BY total DESC
                LIMIT %d",
                $meta_key,
                'product',
                'publish',
                $limit
            ),
            ARRAY_A
        ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
    }

    return array_map(
        static function ( $row ) use ( $object_type ) {
            return array(
                'value' => (string) ( $row['value'] ?? '' ),
                'total' => absint( $row['total'] ?? 0 ),
                'links' => dv_seo_tools_duplicate_sample_links( $row['ids'] ?? '', $object_type ),
            );
        },
        is_array( $rows ) ? $rows : array()
    );
}

function dv_seo_tools_get_duplicate_report( $overview ) {
    $total_products = absint( $overview['total_products'] ?? 0 );
    $total_terms    = absint( $overview['total_terms'] ?? 0 );

    return array(
        'empty'      => array(
            array(
                'label' => 'Title товаров',
                'count' => max( 0, $total_products - absint( $overview['products_with_title'] ?? 0 ) ),
            ),
            array(
                'label' => 'Description товаров',
                'count' => max( 0, $total_products - absint( $overview['products_with_desc'] ?? 0 ) ),
            ),
            array(
                'label' => 'Title категорий',
                'count' => max( 0, $total_terms - absint( $overview['terms_with_title'] ?? 0 ) ),
            ),
            array(
                'label' => 'Description категорий',
                'count' => max( 0, $total_terms - absint( $overview['terms_with_desc'] ?? 0 ) ),
            ),
        ),
        'duplicates' => array(
            array(
                'label'  => 'Title товаров',
                'groups' => dv_seo_tools_query_duplicate_meta_groups( 'post', '_dv_seo_title' ),
            ),
            array(
                'label'  => 'Description товаров',
                'groups' => dv_seo_tools_query_duplicate_meta_groups( 'post', '_dv_seo_description' ),
            ),
            array(
                'label'  => 'Title категорий',
                'groups' => dv_seo_tools_query_duplicate_meta_groups( 'term', '_dv_seo_title' ),
            ),
            array(
                'label'  => 'Description категорий',
                'groups' => dv_seo_tools_query_duplicate_meta_groups( 'term', '_dv_seo_description' ),
            ),
        ),
    );
}

function dv_seo_tools_render_duplicate_report( $report ) {
    $duplicate_total = 0;
    $empty_total     = 0;
    foreach ( $report['empty'] as $item ) {
        $empty_total += absint( $item['count'] ?? 0 );
    }
    foreach ( $report['duplicates'] as $section ) {
        $duplicate_total += count( $section['groups'] );
    }
    ?>
    <details id="dv-seo-duplicates" class="dv-seo-tools-card dv-seo-tools-card--wide dv-seo-tools-section">
        <summary>
            <span class="dv-seo-tools-section-heading">
                <span class="dv-seo-tools-section-title">Ручные SEO-поля и дубли</span>
                <span class="dv-seo-tools-section-note">пустые ручные title/description не ошибка: тема подставляет автоматический вариант</span>
            </span>
            <span class="dv-seo-tools-section-meta">
                <span class="is-ok"><?php echo esc_html( number_format_i18n( $empty_total ) ); ?> авто-вместо-ручных</span>
                <span class="<?php echo $duplicate_total > 0 ? 'is-warning' : 'is-ok'; ?>"><?php echo esc_html( number_format_i18n( $duplicate_total ) ); ?> дублей</span>
            </span>
        </summary>
        <div class="dv-seo-tools-section-body">
            <div class="dv-seo-empty-grid">
                <?php foreach ( $report['empty'] as $item ) : ?>
                    <article>
                        <span><?php echo esc_html( $item['label'] ); ?></span>
                        <strong><?php echo esc_html( number_format_i18n( absint( $item['count'] ) ) ); ?></strong>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ( 0 === $duplicate_total ) : ?>
                <div class="dv-seo-tools-empty-state">Дубли ручных SEO title/description не найдены.</div>
            <?php else : ?>
                <div class="dv-seo-duplicate-list">
                    <?php foreach ( $report['duplicates'] as $section ) : ?>
                        <?php if ( empty( $section['groups'] ) ) : ?>
                            <?php continue; ?>
                        <?php endif; ?>
                        <article class="dv-seo-duplicate-section">
                            <h3><?php echo esc_html( $section['label'] ); ?></h3>
                            <?php foreach ( $section['groups'] as $group ) : ?>
                                <div class="dv-seo-duplicate-group">
                                    <span><?php echo esc_html( number_format_i18n( absint( $group['total'] ) ) ); ?> совпад.</span>
                                    <p><?php echo esc_html( dv_trim_seo_text( $group['value'], 180 ) ); ?></p>
                                    <?php if ( ! empty( $group['links'] ) ) : ?>
                                        <div>
                                            <?php foreach ( $group['links'] as $link ) : ?>
                                                <a href="<?php echo esc_url( $link['url'] ); ?>">#<?php echo esc_html( absint( $link['id'] ) ); ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </details>
    <?php
}

function dv_seo_tools_get_action_queue( $overview, $gaps, $stats = null, $robots_report = null, $sitemap_http_report = null ) {
    $actions = array();

    if ( is_array( $stats ) && ! empty( $stats['warnings'] ) ) {
        $actions[] = array(
            'level' => 'warning',
            'title' => 'Sitemap: лимиты и размер',
            'text'  => implode( ' ', array_map( 'wp_strip_all_tags', $stats['warnings'] ) ),
            'count' => count( $stats['warnings'] ),
            'link'  => admin_url( 'admin.php?page=dv-seo-tools#dv-seo-overview' ),
        );
    }

    if ( is_array( $sitemap_http_report ) && ! empty( $sitemap_http_report['issues'] ) ) {
        $actions[] = array(
            'level' => 'bad',
            'title' => 'Sitemap HTTP',
            'text'  => implode( ' ', array_map( 'wp_strip_all_tags', $sitemap_http_report['issues'] ) ),
            'count' => count( $sitemap_http_report['issues'] ),
            'link'  => admin_url( 'admin.php?page=dv-seo-tools#dv-seo-overview' ),
        );
    }

    if ( is_array( $robots_report ) && ! empty( $robots_report['issues'] ) ) {
        $actions[] = array(
            'level' => 'bad',
            'title' => 'Robots.txt',
            'text'  => implode( ' ', array_map( 'wp_strip_all_tags', $robots_report['issues'] ) ),
            'count' => count( $robots_report['issues'] ),
            'link'  => admin_url( 'admin.php?page=dv-seo-tools#dv-seo-overview' ),
        );
    }

    $term_checks = array(
        array( 'intro', 'terms_effective_intro', 'Верхний текст категорий', 'Проверить категории без ручного или автоматического верхнего текста.', 'warning' ),
        array( 'text', 'terms_effective_text', 'Нижний SEO-текст категорий', 'Проверить категории без нижнего SEO-блока.', 'warning' ),
        array( 'faq', 'terms_effective_faq', 'FAQ категорий', 'Проверить категории без FAQ.', 'warning' ),
        array( 'h1', 'terms_effective_h1', 'SEO H1 категорий', 'Проверить категории без H1.', 'info' ),
    );

    foreach ( $term_checks as $check ) {
        $missing = max( 0, (int) $overview['total_terms'] - (int) ( $overview[ $check[1] ] ?? 0 ) );
        if ( $missing <= 0 ) {
            continue;
        }

        $actions[] = array(
            'level' => $check[4],
            'title' => $check[2],
            'text'  => $check[3],
            'count' => $missing,
            'link'  => dv_seo_tools_find_first_priority_term_missing( $overview, $check[0] ),
        );
    }

    if ( ! empty( $gaps['audit_pending'] ) ) {
        $actions[] = array(
            'level' => 'warning',
            'title' => 'SEO-аудит товаров',
            'text'  => 'Запустите ручное обновление аудита товаров, чтобы получить актуальные проблемы по фото, alt, галерее, описаниям и SEO SKU без замедления обычной загрузки страницы.',
            'count' => max( 1, (int) ( $gaps['total'] ?? 0 ) ),
            'link'  => admin_url( 'admin.php?page=dv-seo-tools#dv-seo-products' ),
        );
    } else {
        if ( ! empty( $gaps['is_stale'] ) ) {
            $actions[] = array(
                'level' => 'info',
                'title' => 'Обновить аудит товаров',
                'text'  => 'Показан последний сохранённый снимок. После изменений каталога стоит обновить SEO-аудит товаров вручную.',
                'count' => 1,
                'link'  => admin_url( 'admin.php?page=dv-seo-tools#dv-seo-overview' ),
            );
        }

        $product_checks = array(
            array( 'missing_image', 'Фото товаров', 'Добавить основное изображение: это влияет на карточку, sitemap images и превью.', 'bad' ),
            array( 'missing_image_alt', 'Alt основного фото', 'Заполнить alt у основного фото: это помогает поиску картинок и карточкам в выдаче.', 'warning' ),
            array( 'missing_gallery', 'Галерея товаров', 'Добавить дополнительные фото: галерея усиливает карточку и image sitemap.', 'info' ),
            array( 'missing_description', 'Полные описания товаров', 'Заполнить уникальные описания для товаров без текста.', 'warning' ),
            array( 'missing_short_desc', 'Краткие описания товаров', 'Добавить короткое описание в верхнюю часть карточки товара.', 'info' ),
            array( 'missing_sku', 'SEO SKU товаров', 'Заполнить атрибут SKU или артикул, чтобы SEO title/description были точнее.', 'warning' ),
        );

        foreach ( $product_checks as $check ) {
            $count = (int) ( $gaps[ $check[0] ] ?? 0 );
            if ( $count <= 0 ) {
                continue;
            }

            $actions[] = array(
                'level' => $check[3],
                'title' => $check[1],
                'text'  => $check[2],
                'count' => $count,
                'link'  => dv_seo_tools_find_first_product_gap_link( $gaps, $check[0] ),
            );
        }
    }

    return array_slice( $actions, 0, 8 );
}

function dv_seo_tools_render_action_queue( $actions ) {
    $action_count = count( $actions );
    $level_counts = array(
        'bad'     => 0,
        'warning' => 0,
        'info'    => 0,
    );
    foreach ( $actions as $action ) {
        $level = sanitize_key( $action['level'] ?? '' );
        if ( isset( $level_counts[ $level ] ) ) {
            $level_counts[ $level ]++;
        }
    }
    ?>
    <div id="dv-seo-actions" class="dv-seo-tools-card dv-seo-tools-card--wide">
        <h2>Очередь SEO-задач</h2>
        <p class="description">Короткий список следующих действий по данным товаров и категорий. Начинайте сверху: там обычно самые заметные пробелы.</p>

        <?php if ( empty( $actions ) ) : ?>
            <div class="dv-seo-tools-empty-state">Критичных SEO-пробелов в текущей проверке не найдено.</div>
        <?php else : ?>
            <div class="dv-seo-tools-action-filters" role="group" aria-label="Фильтр SEO-задач">
                <button type="button" class="is-active" data-dv-seo-action-filter="all">
                    Все <span><?php echo esc_html( number_format_i18n( $action_count ) ); ?></span>
                </button>
                <button type="button" data-dv-seo-action-filter="bad">
                    Критично <span><?php echo esc_html( number_format_i18n( $level_counts['bad'] ) ); ?></span>
                </button>
                <button type="button" data-dv-seo-action-filter="warning">
                    Важно <span><?php echo esc_html( number_format_i18n( $level_counts['warning'] ) ); ?></span>
                </button>
                <button type="button" data-dv-seo-action-filter="info">
                    Планово <span><?php echo esc_html( number_format_i18n( $level_counts['info'] ) ); ?></span>
                </button>
            </div>
            <div class="dv-seo-tools-action-list">
                <?php foreach ( $actions as $action ) : ?>
                    <div class="dv-seo-tools-action dv-seo-tools-action--<?php echo esc_attr( $action['level'] ); ?>" data-dv-seo-action-level="<?php echo esc_attr( $action['level'] ); ?>">
                        <div>
                            <span class="dv-seo-tools-action-level"><?php echo esc_html( dv_seo_tools_action_level_label( $action['level'] ) ); ?></span>
                            <strong><?php echo esc_html( $action['title'] ); ?></strong>
                            <p><?php echo esc_html( $action['text'] ); ?></p>
                        </div>
                        <span class="dv-seo-tools-action-count"><?php echo esc_html( number_format_i18n( (int) $action['count'] ) ); ?></span>
                        <?php if ( ! empty( $action['link'] ) ) : ?>
                            <a class="button button-small" href="<?php echo esc_url( $action['link'] ); ?>">Открыть</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if ( $action_count > 5 ) : ?>
                <button
                    type="button"
                    class="button dv-seo-tools-action-toggle"
                    data-dv-seo-actions-toggle
                    data-open-label="<?php echo esc_attr( sprintf( 'Показать все задачи: %s', number_format_i18n( $action_count ) ) ); ?>"
                    data-close-label="<?php echo esc_attr( 'Свернуть до приоритетов' ); ?>"
                >
                    <?php echo esc_html( sprintf( 'Показать все задачи: %s', number_format_i18n( $action_count ) ) ); ?>
                </button>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php
}

function dv_seo_tools_action_level_label( $level ) {
    $labels = array(
        'bad'     => 'Критично',
        'warning' => 'Важно',
        'info'    => 'Планово',
    );

    return $labels[ $level ] ?? 'Задача';
}

function dv_seo_tools_csv_row( $handle, $row ) {
    fputcsv( $handle, array_map( 'wp_strip_all_tags', $row ), ';' );
}

function dv_seo_tools_export_report() {
    $overview = dv_seo_tools_get_manual_overview();
    $gaps     = dv_seo_tools_get_product_seo_gaps();
    $stats    = dv_seo_tools_get_sitemap_stats();
    $progress = dv_seo_tools_get_progress_summary( $overview, $gaps );
    $duplicates = dv_seo_tools_get_duplicate_report( $overview );
    $robots_report = dv_seo_tools_get_robots_report();
    $sitemap_http_report = dv_seo_tools_get_sitemap_http_report( $stats );
    $actions  = dv_seo_tools_get_action_queue( $overview, $gaps, $stats, $robots_report, $sitemap_http_report );
    $health   = dv_seo_tools_get_health_score( $progress, $actions, $stats, $robots_report, $sitemap_http_report );

    if ( function_exists( 'nocache_headers' ) ) {
        nocache_headers();
    }

    $filename = 'detalivam-seo-report-' . gmdate( 'Y-m-d' ) . '.csv';

    header( 'Content-Type: text/csv; charset=UTF-8' );
    header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
    header( 'Pragma: no-cache' );
    header( 'Expires: 0' );

    $handle = fopen( 'php://output', 'w' );

    dv_seo_tools_csv_row( $handle, array( 'Раздел', 'Показатель', 'Значение', 'Комментарий', 'Ссылка' ) );

    dv_seo_tools_csv_row(
        $handle,
        array(
            'SEO health score',
            $health['label'],
            (int) $health['score'] . '%',
            $health['message'],
            admin_url( 'admin.php?page=dv-seo-tools#dv-seo-health' ),
        )
    );

    dv_seo_tools_csv_row(
        $handle,
        array(
            'Sitemap',
            'Индекс',
            (int) ( $stats['total'] ?? 0 ) . ' URL',
            'Товары: ' . (int) ( $stats['products'] ?? 0 ) . '; категории: ' . (int) ( $stats['categories'] ?? 0 ) . '; страницы: ' . (int) ( $stats['pages'] ?? 0 ) . '; изображения: ' . (int) ( $stats['images'] ?? 0 ) . '.',
            home_url( '/sitemap.xml' ),
        )
    );

    dv_seo_tools_csv_row(
        $handle,
        array(
            'Sitemap',
            'Совместимый urlset',
            dv_seo_tools_format_bytes( $stats['xml_bytes'] ?? 0 ),
            'Полный urlset для совместимости со старыми ссылками.',
            home_url( '/sitemaps.xml' ),
        )
    );

    if ( ! empty( $stats['sitemaps'] ) && is_array( $stats['sitemaps'] ) ) {
        foreach ( $stats['sitemaps'] as $group => $sitemap ) {
            dv_seo_tools_csv_row(
                $handle,
                array(
                    'Sitemap',
                    'Файл ' . $group,
                    (int) ( $sitemap['count'] ?? 0 ) . ' URL',
                    $sitemap['path'] ?? '',
                    $sitemap['url'] ?? '',
                )
            );
        }
    }

    if ( ! empty( $stats['warnings'] ) && is_array( $stats['warnings'] ) ) {
        foreach ( $stats['warnings'] as $warning ) {
            dv_seo_tools_csv_row(
                $handle,
                array(
                    'Sitemap',
                    'Предупреждение',
                    'проверить',
                    $warning,
                    home_url( '/sitemap.xml' ),
                )
            );
        }
    } else {
        dv_seo_tools_csv_row(
            $handle,
            array(
                'Sitemap',
                'Предупреждения',
                'OK',
                'Лимиты URL и размера XML не превышены.',
                home_url( '/sitemap.xml' ),
            )
        );
    }

    if ( ! empty( $sitemap_http_report['items'] ) && is_array( $sitemap_http_report['items'] ) ) {
        foreach ( $sitemap_http_report['items'] as $item ) {
            dv_seo_tools_csv_row(
                $handle,
                array(
                    'Sitemap HTTP',
                    $item['label'],
                    $item['status'] ? 'HTTP ' . $item['status'] : 'нет ответа',
                    'Проверено: ' . dv_seo_tools_format_checked_at( $sitemap_http_report['checked_at'] ?? 0 ) . '. Кеш: ' . dv_seo_tools_cache_status_label( $sitemap_http_report ) . '. XML: ' . ( $item['root'] ? '<' . $item['root'] . '>' : 'не распознан' ) . '; ожидается <' . $item['expected'] . '>. LOC: ' . (int) ( $item['loc_count'] ?? 0 ) . '/' . (int) ( $item['expected_count'] ?? 0 ) . '. Content-Type: ' . ( $item['content_type'] ?: 'не указан' ) . '. Размер: ' . dv_seo_tools_format_bytes( $item['bytes'] ?? 0 ) . '.',
                    $item['url'],
                )
            );
        }
    }

    if ( ! empty( $sitemap_http_report['issues'] ) && is_array( $sitemap_http_report['issues'] ) ) {
        foreach ( $sitemap_http_report['issues'] as $issue ) {
            dv_seo_tools_csv_row(
                $handle,
                array(
                    'Sitemap HTTP',
                    'Предупреждение',
                    'проверить',
                    $issue,
                    home_url( '/sitemap.xml' ),
                )
            );
        }
    } else {
        dv_seo_tools_csv_row(
            $handle,
            array(
                'Sitemap HTTP',
                'Предупреждения',
                'OK',
                'Sitemap-файлы отвечают по HTTP и имеют ожидаемый XML-корень.',
                home_url( '/sitemap.xml' ),
            )
        );
    }

    dv_seo_tools_csv_row(
        $handle,
        array(
            'Robots',
            'HTTP',
            $robots_report['status'] ? (string) $robots_report['status'] : 'fallback',
            'Проверено: ' . dv_seo_tools_format_checked_at( $robots_report['checked_at'] ?? 0 ) . '. Кеш: ' . dv_seo_tools_cache_status_label( $robots_report ) . '. Источник: ' . $robots_report['source'] . '. Индексация: ' . ( $robots_report['public'] ? 'включена' : 'выключена' ) . '. Content-Type: ' . ( $robots_report['content_type'] ?: 'не указан' ) . '. Размер: ' . dv_seo_tools_format_bytes( $robots_report['bytes'] ?? 0 ) . '.',
            home_url( '/robots.txt' ),
        )
    );

    dv_seo_tools_csv_row(
        $handle,
        array(
            'Robots',
            'Sitemap',
            $robots_report['has_sitemap'] ? 'OK' : 'нет',
            'Ожидается ссылка Sitemap на /sitemap.xml.',
            home_url( '/sitemap.xml' ),
        )
    );

    if ( ! empty( $robots_report['issues'] ) ) {
        foreach ( $robots_report['issues'] as $issue ) {
            dv_seo_tools_csv_row(
                $handle,
                array(
                    'Robots',
                    'Предупреждение',
                    'проверить',
                    $issue,
                    home_url( '/robots.txt' ),
                )
            );
        }
    } else {
        dv_seo_tools_csv_row(
            $handle,
            array(
                'Robots',
                'Предупреждения',
                'OK',
                'Критичных проблем robots.txt не найдено.',
                home_url( '/robots.txt' ),
            )
        );
    }

    foreach ( $progress as $item ) {
        dv_seo_tools_csv_row(
            $handle,
            array(
                'SEO-прогресс',
                $item['title'],
                (int) $item['percent'] . '%',
                $item['text'],
                '',
            )
        );
    }

    foreach ( $actions as $action ) {
        dv_seo_tools_csv_row(
            $handle,
            array(
                'Очередь SEO-задач',
                $action['title'],
                (int) $action['count'],
                $action['text'],
                $action['link'],
            )
        );
    }

    foreach ( $duplicates['empty'] as $item ) {
        dv_seo_tools_csv_row(
            $handle,
            array(
                'Пустые SEO-поля',
                $item['label'],
                (int) $item['count'],
                'Ручное поле пустое, будет использована автоматика темы.',
                '',
            )
        );
    }

    foreach ( $duplicates['duplicates'] as $section ) {
        foreach ( $section['groups'] as $group ) {
            dv_seo_tools_csv_row(
                $handle,
                array(
                    'Дубли SEO',
                    $section['label'],
                    (int) $group['total'],
                    $group['value'],
                    ! empty( $group['links'][0]['url'] ) ? $group['links'][0]['url'] : '',
                )
            );
        }
    }

    if ( ! empty( $overview['priority_terms'] ) ) {
        foreach ( $overview['priority_terms'] as $item ) {
            $term = $item['term'];
            $missing = array();

            foreach ( array( 'h1' => 'SEO H1', 'intro' => 'верхний текст', 'text' => 'нижний текст', 'faq' => 'FAQ' ) as $key => $label ) {
                if ( empty( $item[ $key ] ) ) {
                    $missing[] = $label;
                }
            }

            dv_seo_tools_csv_row(
                $handle,
                array(
                    'Крупные категории',
                    $term->name,
                    $term->count . ' товаров',
                    empty( $missing ) ? 'Заполнено' : 'Заполнить: ' . implode( ', ', $missing ),
                    $item['edit_link'],
                )
            );
        }
    }

    $gap_labels = array(
        'missing_image'       => 'Нет основного фото',
        'missing_image_alt'   => 'Нет alt основного фото',
        'missing_gallery'     => 'Нет галереи товара',
        'missing_description' => 'Нет полного описания',
        'missing_short_desc'  => 'Нет краткого описания',
        'missing_sku'         => 'Нет SEO SKU',
    );

    foreach ( $gap_labels as $key => $label ) {
        if ( empty( $gaps['samples'][ $key ] ) ) {
            continue;
        }

        foreach ( $gaps['samples'][ $key ] as $sample ) {
            dv_seo_tools_csv_row(
                $handle,
                array(
                    'Примеры товаров',
                    $sample['title'],
                    $label,
                    $sample['url'],
                    $sample['edit_link'],
                )
            );
        }
    }

    fclose( $handle );
    exit;
}

function dv_render_seo_tools_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $rows       = dv_seo_tools_get_preview_rows();
    $stats      = dv_seo_tools_get_sitemap_stats();
    $overview   = dv_seo_tools_get_manual_overview();
    $gaps       = dv_seo_tools_get_product_seo_gaps();
    $progress   = dv_seo_tools_get_progress_summary( $overview, $gaps );
    $duplicates = dv_seo_tools_get_duplicate_report( $overview );
    $sitemap    = home_url( '/sitemap.xml' );
    $urlset     = home_url( '/sitemaps.xml' );
    $notice     = isset( $_GET['dv_seo_notice'] ) ? sanitize_key( wp_unslash( $_GET['dv_seo_notice'] ) ) : '';
    $robots_url = home_url( '/robots.txt' );
    $robots_report = dv_seo_tools_get_robots_report();
    $sitemap_http_report = dv_seo_tools_get_sitemap_http_report( $stats );
    $actions    = dv_seo_tools_get_action_queue( $overview, $gaps, $stats, $robots_report, $sitemap_http_report );
    $health     = dv_seo_tools_get_health_score( $progress, $actions, $stats, $robots_report, $sitemap_http_report );
    $product_audit_state = dv_seo_tools_get_product_audit_state();
    $check_url  = isset( $_GET['dv_seo_check_url'] ) ? esc_url_raw( wp_unslash( $_GET['dv_seo_check_url'] ) ) : '';
    $head_report = null;

    if ( '' !== $check_url && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'dv_seo_tools_check_url' ) ) {
        $head_report = dv_seo_tools_fetch_head_report( $check_url );
    }
    ?>
    <div class="wrap dv-suite-page dv-seo-tools">
        <?php
        dv_render_admin_suite_header(
            'dv-seo-tools',
            html_entity_decode( 'SEO-&#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ),
            html_entity_decode( '&#1041;&#1099;&#1089;&#1090;&#1088;&#1099;&#1081; &#1087;&#1088;&#1086;&#1089;&#1084;&#1086;&#1090;&#1088; &#1072;&#1074;&#1090;&#1086;&#1084;&#1072;&#1090;&#1080;&#1095;&#1077;&#1089;&#1082;&#1080;&#1093; SEO-&#1076;&#1072;&#1085;&#1085;&#1099;&#1093; &#1090;&#1077;&#1084;&#1099;: title, description, canonical, robots &#1080; sitemap. &#1056;&#1091;&#1095;&#1085;&#1099;&#1077; &#1087;&#1086;&#1083;&#1103; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072; &#1080;&#1083;&#1080; &#1082;&#1072;&#1090;&#1077;&#1075;&#1086;&#1088;&#1080;&#1080; &#1080;&#1084;&#1077;&#1102;&#1090; &#1087;&#1088;&#1080;&#1086;&#1088;&#1080;&#1090;&#1077;&#1090; &#1085;&#1072;&#1076; &#1072;&#1074;&#1090;&#1086;&#1084;&#1072;&#1090;&#1080;&#1082;&#1086;&#1081;.', ENT_QUOTES, 'UTF-8' )
        );
        ?>

        <?php if ( 'sitemap_cleared' === $notice ) : ?>
            <div class="notice notice-success is-dismissible"><p>Кеш sitemap очищен. При следующем открытии файл будет собран заново.</p></div>
        <?php elseif ( 'sitemap_rebuilt' === $notice ) : ?>
            <div class="notice notice-success is-dismissible"><p>Sitemap пересобран. Новый XML уже сохранён в кеше.</p></div>
        <?php elseif ( 'product_audit_refreshed' === $notice ) : ?>
            <div class="notice notice-success is-dismissible"><p>SEO-аудит товаров обновлён.</p></div>
        <?php elseif ( 'product_audit_scheduled' === $notice ) : ?>
            <div class="notice notice-success is-dismissible"><p>Фоновый SEO-аудит товаров запущен. Можно закрыть страницу: задача продолжит выполняться через WP-Cron.</p></div>
        <?php elseif ( 'http_checks_refreshed' === $notice ) : ?>
            <div class="notice notice-success is-dismissible"><p>HTTP-проверки robots.txt и sitemap-файлов обновлены.</p></div>
        <?php endif; ?>

        <?php
        if ( function_exists( 'dv_render_admin_suite_local_nav' ) ) {
            dv_render_admin_suite_local_nav(
                array(
                    array( 'href' => '#dv-seo-health', 'label' => 'Health score', 'description' => 'Оценка' ),
                    array( 'href' => '#dv-seo-actions', 'label' => 'Задачи', 'description' => 'Очередь' ),
                    array( 'href' => '#dv-seo-overview', 'label' => 'Сводка', 'description' => 'sitemap / robots' ),
                    array( 'href' => '#dv-seo-manual', 'label' => 'Ручные поля', 'description' => 'Title / Description' ),
                    array( 'href' => '#dv-seo-products', 'label' => 'Товары', 'description' => 'Аудит' ),
                    array( 'href' => '#dv-seo-head', 'label' => 'Проверить URL', 'description' => 'head' ),
                    array( 'href' => '#dv-seo-preview', 'label' => 'Превью', 'description' => 'SEO' ),
                ),
                'Разделы SEO-проверки'
            );
        }
        ?>

        <div class="dv-seo-tools-command-center">
            <?php dv_seo_tools_render_health_score( $health ); ?>

            <?php dv_seo_tools_render_action_queue( $actions ); ?>
        </div>

        <details id="dv-seo-overview" class="dv-seo-tools-card dv-seo-tools-card--wide dv-seo-tools-section dv-seo-tools-overview-section">
            <summary>
                <span class="dv-seo-tools-section-heading">
                    <span class="dv-seo-tools-section-title">Техническая сводка</span>
                    <span class="dv-seo-tools-section-note">sitemap, robots, CSV-отчёт и быстрые переходы к правкам</span>
                </span>
                <span class="dv-seo-tools-section-meta">
                    <span><?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?> URL</span>
                    <span class="<?php echo empty( $sitemap_http_report['issues'] ) ? 'is-ok' : 'is-warning'; ?>">sitemap <?php echo empty( $sitemap_http_report['issues'] ) ? 'OK' : 'проверить'; ?></span>
                    <span class="<?php echo empty( $robots_report['issues'] ) ? 'is-ok' : 'is-warning'; ?>">robots <?php echo empty( $robots_report['issues'] ) ? 'OK' : 'проверить'; ?></span>
                </span>
            </summary>
            <div class="dv-seo-tools-section-body">
        <div class="dv-seo-tools-grid">
            <div class="dv-seo-tools-card">
                <h2>Sitemap</h2>
                <p><a href="<?php echo esc_url( $sitemap ); ?>" target="_blank" rel="noopener">Открыть sitemap.xml</a></p>
                <p><a href="<?php echo esc_url( $urlset ); ?>" target="_blank" rel="noopener">Открыть основной urlset</a></p>
                <dl class="dv-seo-tools-stats">
                    <dt>Всего URL</dt><dd><?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?></dd>
                    <dt>Товары</dt><dd><?php echo esc_html( number_format_i18n( $stats['products'] ) ); ?></dd>
                    <dt>Категории</dt><dd><?php echo esc_html( number_format_i18n( $stats['categories'] ) ); ?></dd>
                    <dt>Страницы</dt><dd><?php echo esc_html( number_format_i18n( $stats['pages'] ) ); ?></dd>
                    <dt>Картинки</dt><dd><?php echo esc_html( number_format_i18n( $stats['images'] ) ); ?></dd>
                    <dt>Размер XML</dt><dd><?php echo esc_html( dv_seo_tools_format_bytes( $stats['xml_bytes'] ?? 0 ) ); ?></dd>
                </dl>
                <?php if ( ! empty( $stats['warnings'] ) ) : ?>
                    <?php foreach ( $stats['warnings'] as $warning ) : ?>
                        <p class="description"><?php echo esc_html( $warning ); ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ( ! empty( $sitemap_http_report['items'] ) ) : ?>
                    <dl class="dv-seo-tools-stats">
                        <dt>HTTP проверка</dt><dd><?php echo esc_html( dv_seo_tools_format_checked_at( $sitemap_http_report['checked_at'] ?? 0 ) ); ?></dd>
                        <dt>Кеш</dt><dd><?php echo esc_html( dv_seo_tools_cache_status_label( $sitemap_http_report ) ); ?></dd>
                        <?php foreach ( $sitemap_http_report['items'] as $sitemap_http_item ) : ?>
                            <dt><?php echo esc_html( $sitemap_http_item['label'] ); ?></dt>
                            <dd>
                                <?php
                                echo esc_html(
                                    ( $sitemap_http_item['status'] ? 'HTTP ' . $sitemap_http_item['status'] : 'нет ответа' )
                                    . ', '
                                    . ( $sitemap_http_item['root'] ? '<' . $sitemap_http_item['root'] . '>' : 'XML не распознан' )
                                    . ', loc '
                                    . (int) ( $sitemap_http_item['loc_count'] ?? 0 )
                                    . '/'
                                    . (int) ( $sitemap_http_item['expected_count'] ?? 0 )
                                    . ', '
                                    . ( $sitemap_http_item['content_type'] ? $sitemap_http_item['content_type'] : 'Content-Type не указан' )
                                );
                                ?>
                            </dd>
                        <?php endforeach; ?>
                    </dl>
                <?php endif; ?>
                <?php if ( ! empty( $sitemap_http_report['issues'] ) ) : ?>
                    <ul class="dv-seo-tools-mini-list">
                        <?php foreach ( $sitemap_http_report['issues'] as $issue ) : ?>
                            <li><?php echo esc_html( $issue ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="description">Sitemap-файлы отвечают по HTTP и имеют ожидаемый XML-корень.</p>
                <?php endif; ?>
                <?php if ( ! empty( $stats['sitemaps'] ) ) : ?>
                    <div class="dv-seo-tools-link-grid">
                        <?php foreach ( $stats['sitemaps'] as $sitemap_item ) : ?>
                            <a href="<?php echo esc_url( $sitemap_item['url'] ); ?>" target="_blank" rel="noopener">
                                <?php echo esc_html( $sitemap_item['path'] ); ?>
                                <span><?php echo esc_html( number_format_i18n( (int) $sitemap_item['count'] ) ); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <div class="dv-seo-tools-card-actions dv-suite-action-row" aria-label="Действия Sitemap">
                    <form method="post">
                        <?php wp_nonce_field( 'dv_seo_tools_clear_sitemap' ); ?>
                        <input type="hidden" name="dv_seo_tools_action" value="rebuild_sitemap">
                        <?php submit_button( 'Пересобрать sitemap', 'secondary', 'submit', false ); ?>
                    </form>
                    <form method="post">
                        <?php wp_nonce_field( 'dv_seo_tools_refresh_http_checks' ); ?>
                        <input type="hidden" name="dv_seo_tools_action" value="refresh_http_checks">
                        <?php submit_button( 'Обновить HTTP-проверки', 'secondary', 'submit', false ); ?>
                    </form>
                </div>
            </div>

            <div class="dv-seo-tools-card">
                <h2>Robots</h2>
                <p><a href="<?php echo esc_url( $robots_url ); ?>" target="_blank" rel="noopener">Открыть robots.txt</a></p>
                <p class="description">Тема добавляет meta robots для служебных и фильтрованных страниц, а физический robots.txt остаётся главным файлом для Яндекса.</p>
                <dl class="dv-seo-tools-stats">
                    <dt>Индексация</dt><dd><?php echo $robots_report['public'] ? 'включена' : 'выключена'; ?></dd>
                    <dt>HTTP</dt><dd><?php echo $robots_report['status'] ? esc_html( (string) $robots_report['status'] ) : 'fallback'; ?></dd>
                    <dt>Sitemap</dt><dd><?php echo $robots_report['has_sitemap'] ? 'OK' : 'нет'; ?></dd>
                    <dt>Глобальный запрет</dt><dd><?php echo $robots_report['has_global_block'] ? 'есть' : 'нет'; ?></dd>
                    <dt>Источник</dt><dd><?php echo esc_html( $robots_report['source'] ); ?></dd>
                    <dt>Проверено</dt><dd><?php echo esc_html( dv_seo_tools_format_checked_at( $robots_report['checked_at'] ?? 0 ) ); ?></dd>
                    <dt>Кеш</dt><dd><?php echo esc_html( dv_seo_tools_cache_status_label( $robots_report ) ); ?></dd>
                    <dt>Строк</dt><dd><?php echo esc_html( number_format_i18n( (int) $robots_report['line_count'] ) ); ?></dd>
                    <dt>Content-Type</dt><dd><?php echo esc_html( ! empty( $robots_report['content_type'] ) ? $robots_report['content_type'] : 'не указан' ); ?></dd>
                    <dt>Размер</dt><dd><?php echo esc_html( dv_seo_tools_format_bytes( $robots_report['bytes'] ?? 0 ) ); ?></dd>
                </dl>
                <?php if ( ! empty( $robots_report['issues'] ) ) : ?>
                    <ul class="dv-seo-tools-mini-list">
                        <?php foreach ( $robots_report['issues'] as $issue ) : ?>
                            <li><?php echo esc_html( $issue ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="description">robots.txt выглядит корректно: sitemap указан, служебные зоны закрыты, глобального запрета нет.</p>
                <?php endif; ?>
            </div>

            <div class="dv-seo-tools-card">
                <h2>SEO-отчёт</h2>
                <p class="description">Скачать текущий срез прогресса, задач, крупных категорий и примеров проблемных товаров в CSV.</p>
                <div class="dv-seo-tools-card-actions dv-suite-action-row" aria-label="Действия SEO-отчёта">
                    <form method="post">
                        <?php wp_nonce_field( 'dv_seo_tools_export_report' ); ?>
                        <input type="hidden" name="dv_seo_tools_action" value="export_seo_report">
                        <?php submit_button( 'Скачать CSV-отчёт', 'secondary', 'submit', false ); ?>
                    </form>
                    <form method="post" data-dv-seo-product-audit-form>
                        <?php wp_nonce_field( 'dv_seo_tools_refresh_product_audit' ); ?>
                        <input type="hidden" name="dv_seo_tools_action" value="refresh_product_seo_audit">
                        <?php submit_button( 'Запустить фоновый SEO-аудит', 'secondary', 'submit', false ); ?>
                        <?php
                        $audit_running = 'running' === ( $product_audit_state['status'] ?? '' );
                        $audit_percent = max( 0, min( 100, absint( $product_audit_state['percent'] ?? 0 ) ) );
                        ?>
                        <div class="dv-seo-tools-audit-progress" data-dv-seo-product-audit-progress <?php echo $audit_running ? '' : 'hidden'; ?>>
                            <span data-dv-seo-product-audit-status>
                                <?php
                                echo esc_html(
                                    $audit_running
                                        ? sprintf(
                                            'Фоновый аудит выполняется: проверено %1$s из %2$s товаров.',
                                            number_format_i18n( absint( $product_audit_state['processed'] ?? 0 ) ),
                                            number_format_i18n( absint( $product_audit_state['total'] ?? 0 ) )
                                        )
                                        : 'Подготовка аудита...'
                                );
                                ?>
                            </span>
                            <div aria-hidden="true"><i style="width: <?php echo esc_attr( (string) $audit_percent ); ?>%;"></i></div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dv-seo-tools-card">
                <h2>Быстрые правки</h2>
                <p class="description">Основные места, где администратор правит SEO-данные и контент сайта.</p>
                <div class="dv-seo-tools-link-grid">
                    <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=product' ) ); ?>">Товары</a>
                    <a href="<?php echo esc_url( admin_url( 'edit-tags.php?taxonomy=product_cat&post_type=product' ) ); ?>">Категории</a>
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=dv-theme-content' ) ); ?>">Контент темы</a>
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=dv-store-settings' ) ); ?>">Профиль магазина</a>
                </div>
            </div>
        </div>
            </div>
        </details>

        <?php dv_seo_tools_render_template_generator(); ?>

        <?php dv_seo_tools_render_duplicate_report( $duplicates ); ?>

        <?php dv_seo_tools_render_progress_summary( $progress ); ?>

        <?php dv_seo_tools_render_manual_overview( $overview ); ?>

        <?php dv_seo_tools_render_product_gaps( $gaps ); ?>

        <details id="dv-seo-head" class="dv-seo-tools-card dv-seo-tools-card--wide dv-seo-tools-section" <?php echo null !== $head_report ? 'open' : ''; ?>>
            <summary>
                <span class="dv-seo-tools-section-heading">
                    <span class="dv-seo-tools-section-title">Проверить реальный HTML head</span>
                    <span class="dv-seo-tools-section-note">фактические title, description, canonical, robots, OG и JSON-LD</span>
                </span>
            </summary>
            <div class="dv-seo-tools-section-body">
            <form method="get" class="dv-seo-tools-check-form">
                <input type="hidden" name="page" value="dv-seo-tools">
                <?php wp_nonce_field( 'dv_seo_tools_check_url' ); ?>
                <input type="url" class="regular-text" name="dv_seo_check_url" value="<?php echo esc_attr( $check_url ); ?>" placeholder="<?php echo esc_attr( home_url( '/product/example/' ) ); ?>">
                <?php submit_button( 'Проверить URL', 'primary', 'submit', false ); ?>
            </form>
            <?php
            if ( null !== $head_report ) {
                dv_seo_tools_render_head_report( $head_report );
            }
            ?>
            </div>
        </details>

        <details id="dv-seo-preview" class="dv-seo-tools-card dv-seo-tools-card--wide dv-seo-tools-section">
            <summary>
                <span class="dv-seo-tools-section-heading">
                    <span class="dv-seo-tools-section-title">Предпросмотр SEO</span>
                    <span class="dv-seo-tools-section-note">ожидаемые title, description, canonical и источник данных</span>
                </span>
            </summary>
            <div class="dv-seo-tools-section-body">
        <table class="widefat fixed striped dv-seo-tools-table">
            <thead>
                <tr>
                    <th>Страница</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Canonical / robots</th>
                    <th>Источник</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $rows as $row ) : ?>
                    <?php
                    $head_check_url = wp_nonce_url(
                        add_query_arg(
                            array(
                                'page'             => 'dv-seo-tools',
                                'dv_seo_check_url' => $row['url'],
                            ),
                            admin_url( 'admin.php' )
                        ),
                        'dv_seo_tools_check_url'
                    );
                    ?>
                    <tr>
                        <td>
                            <strong><?php echo esc_html( $row['type'] ); ?></strong>
                            <br>
                            <a href="<?php echo esc_url( $row['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $row['url'] ); ?></a>
                            <div class="dv-seo-tools-row-actions">
                                <a class="button button-small" href="<?php echo esc_url( $head_check_url ); ?>">Проверить head</a>
                            </div>
                        </td>
                        <td>
                            <?php dv_seo_tools_render_metric( $row['title'], 'title' ); ?>
                            <div class="dv-seo-tools-text"><?php echo esc_html( $row['title'] ); ?></div>
                        </td>
                        <td>
                            <?php dv_seo_tools_render_metric( $row['description'], 'description' ); ?>
                            <div class="dv-seo-tools-text"><?php echo esc_html( $row['description'] ); ?></div>
                        </td>
                        <td>
                            <code><?php echo esc_html( $row['canonical'] ); ?></code>
                            <br>
                            <span><?php echo esc_html( $row['robots'] ); ?></span>
                        </td>
                        <td>
                            <?php echo esc_html( $row['source'] ); ?>
                            <?php if ( ! empty( $row['city_issue'] ) ) : ?>
                                <br><span class="dv-seo-tools-issue dv-seo-tools-issue--warning">город в авто-SEO</span>
                            <?php endif; ?>
                            <?php if ( ! empty( $row['edit_url'] ) ) : ?>
                                <br>
                                <a class="button button-small" href="<?php echo esc_url( $row['edit_url'] ); ?>">Управлять</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            </div>
        </details>
        <?php
        if ( function_exists( 'dv_render_admin_suite_footer' ) ) {
            dv_render_admin_suite_footer( 'dv-seo-tools' );
        }
        ?>
    </div>
    <?php
}
