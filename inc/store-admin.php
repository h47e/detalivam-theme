<?php
defined( 'ABSPATH' ) || exit;

function dv_store_admin_labels() {
    return array(
        'page_title'         => html_entity_decode( '&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1081;&#1082;&#1080; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'menu_title'         => html_entity_decode( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;: &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;', ENT_QUOTES, 'UTF-8' ),
        'section_title'      => html_entity_decode( '&#1055;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'section_desc'       => html_entity_decode( '&#1069;&#1090;&#1080; &#1076;&#1072;&#1085;&#1085;&#1099;&#1077; &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1102;&#1090;&#1089;&#1103; &#1074; &#1096;&#1072;&#1087;&#1082;&#1077;, &#1092;&#1091;&#1090;&#1077;&#1088;&#1077;, SEO, schema &#1080; &#1083;&#1086;&#1082;&#1072;&#1083;&#1100;&#1085;&#1099;&#1093; &#1089;&#1080;&#1075;&#1085;&#1072;&#1083;&#1072;&#1093; &#1089;&#1072;&#1081;&#1090;&#1072;.', ENT_QUOTES, 'UTF-8' ),
        'name'               => html_entity_decode( '&#1053;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'store_name'         => html_entity_decode( '&#1053;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'logo_url'           => html_entity_decode( 'Logo URL', ENT_QUOTES, 'UTF-8' ),
        'ozon_url'           => html_entity_decode( 'Ozon URL', ENT_QUOTES, 'UTF-8' ),
        'ozon_icon_url'      => html_entity_decode( 'Ozon: &#1080;&#1082;&#1086;&#1085;&#1082;&#1072; URL', ENT_QUOTES, 'UTF-8' ),
        'marketplaces'       => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089;&#1099;', ENT_QUOTES, 'UTF-8' ),
        'marketplace_2_name' => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089; 2: &#1085;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'marketplace_2_url'  => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089; 2: URL', ENT_QUOTES, 'UTF-8' ),
        'marketplace_2_icon' => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089; 2: &#1080;&#1082;&#1086;&#1085;&#1082;&#1072; URL', ENT_QUOTES, 'UTF-8' ),
        'marketplace_3_name' => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089; 3: &#1085;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'marketplace_3_url'  => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089; 3: URL', ENT_QUOTES, 'UTF-8' ),
        'marketplace_3_icon' => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089; 3: &#1080;&#1082;&#1086;&#1085;&#1082;&#1072; URL', ENT_QUOTES, 'UTF-8' ),
        'phone'              => html_entity_decode( '&#1058;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085; (tel)', ENT_QUOTES, 'UTF-8' ),
        'phone_display'      => html_entity_decode( '&#1058;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085; &#1076;&#1083;&#1103; &#1074;&#1099;&#1074;&#1086;&#1076;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'email'              => html_entity_decode( 'Email', ENT_QUOTES, 'UTF-8' ),
        'city'               => html_entity_decode( '&#1043;&#1086;&#1088;&#1086;&#1076;', ENT_QUOTES, 'UTF-8' ),
        'region'             => html_entity_decode( '&#1056;&#1077;&#1075;&#1080;&#1086;&#1085;', ENT_QUOTES, 'UTF-8' ),
        'country_name'       => html_entity_decode( '&#1057;&#1090;&#1088;&#1072;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'country_code'       => html_entity_decode( '&#1050;&#1086;&#1076; &#1089;&#1090;&#1088;&#1072;&#1085;&#1099;', ENT_QUOTES, 'UTF-8' ),
        'workdays'           => html_entity_decode( '&#1056;&#1072;&#1073;&#1086;&#1095;&#1080;&#1077; &#1076;&#1085;&#1080;', ENT_QUOTES, 'UTF-8' ),
        'opens'              => html_entity_decode( '&#1054;&#1090;&#1082;&#1088;&#1099;&#1090;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'closes'             => html_entity_decode( '&#1047;&#1072;&#1082;&#1088;&#1099;&#1090;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
        'footer_description' => html_entity_decode( '&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1074; &#1092;&#1091;&#1090;&#1077;&#1088;&#1077;', ENT_QUOTES, 'UTF-8' ),
    );
}

function dv_sanitize_store_profile( $input ) {
    $current = dv_get_store_profile();
    $input   = is_array( $input ) ? $input : array();

    return array(
        'name'               => sanitize_text_field( $input['name'] ?? ( $current['name'] ?? '' ) ),
        'logo_url'           => esc_url_raw( $input['logo_url'] ?? ( $current['logo_url'] ?? '' ) ),
        'ozon_url'           => esc_url_raw( $input['ozon_url'] ?? ( $current['ozon_url'] ?? '' ) ),
        'ozon_icon_url'      => esc_url_raw( $input['ozon_icon_url'] ?? ( $current['ozon_icon_url'] ?? '' ) ),
        'marketplace_2_name' => sanitize_text_field( $input['marketplace_2_name'] ?? ( $current['marketplace_2_name'] ?? '' ) ),
        'marketplace_2_url'  => esc_url_raw( $input['marketplace_2_url'] ?? ( $current['marketplace_2_url'] ?? '' ) ),
        'marketplace_2_icon' => esc_url_raw( $input['marketplace_2_icon'] ?? ( $current['marketplace_2_icon'] ?? '' ) ),
        'marketplace_3_name' => sanitize_text_field( $input['marketplace_3_name'] ?? ( $current['marketplace_3_name'] ?? '' ) ),
        'marketplace_3_url'  => esc_url_raw( $input['marketplace_3_url'] ?? ( $current['marketplace_3_url'] ?? '' ) ),
        'marketplace_3_icon' => esc_url_raw( $input['marketplace_3_icon'] ?? ( $current['marketplace_3_icon'] ?? '' ) ),
        'phone'              => sanitize_text_field( $input['phone'] ?? ( $current['phone'] ?? '' ) ),
        'phone_display'      => sanitize_text_field( $input['phone_display'] ?? ( $current['phone_display'] ?? '' ) ),
        'email'              => sanitize_email( $input['email'] ?? ( $current['email'] ?? '' ) ),
        'city'               => sanitize_text_field( $input['city'] ?? ( $current['city'] ?? '' ) ),
        'region'             => sanitize_text_field( $input['region'] ?? ( $current['region'] ?? '' ) ),
        'country_name'       => sanitize_text_field( $input['country_name'] ?? ( $current['country_name'] ?? '' ) ),
        'country_code'       => strtoupper( sanitize_text_field( $input['country_code'] ?? ( $current['country_code'] ?? '' ) ) ),
        'workdays'           => sanitize_text_field( $input['workdays'] ?? ( $current['workdays'] ?? '' ) ),
        'opens'              => preg_match( '/^\d{2}:\d{2}$/', (string) ( $input['opens'] ?? '' ) ) ? sanitize_text_field( $input['opens'] ) : sanitize_text_field( $current['opens'] ?? '' ),
        'closes'             => preg_match( '/^\d{2}:\d{2}$/', (string) ( $input['closes'] ?? '' ) ) ? sanitize_text_field( $input['closes'] ) : sanitize_text_field( $current['closes'] ?? '' ),
        'footer_description' => sanitize_textarea_field( $input['footer_description'] ?? ( $current['footer_description'] ?? '' ) ),
    );
}

function dv_register_store_settings() {
    register_setting( 'dv_store_profile_group', 'dv_store_profile', 'dv_sanitize_store_profile' );
}
add_action( 'admin_init', 'dv_register_store_settings' );

function dv_add_store_settings_page() {
    $labels = dv_store_admin_labels();

    add_submenu_page(
        'dv-theme-options',
        $labels['page_title'],
        html_entity_decode( '&#1052;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;', ENT_QUOTES, 'UTF-8' ),
        'manage_options',
        'dv-store-settings',
        'dv_render_store_settings_page'
    );
}
add_action( 'admin_menu', 'dv_add_store_settings_page' );

function dv_store_admin_enqueue_assets() {
    $page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

    if ( 'dv-store-settings' !== $page ) {
        return;
    }

    wp_enqueue_media();

    $css_path = DV_DIR . '/assets/css/store-admin.css';
    $js_path = DV_DIR . '/assets/js/store-admin.js';

    wp_enqueue_style(
        'dv-store-admin',
        DV_URI . '/assets/css/store-admin.css',
        array( 'dv-theme-admin' ),
        file_exists( $css_path ) ? DV_VERSION . '.' . filemtime( $css_path ) : DV_VERSION
    );

    wp_enqueue_script(
        'dv-store-admin',
        DV_URI . '/assets/js/store-admin.js',
        array(),
        file_exists( $js_path ) ? filemtime( $js_path ) : DV_VERSION,
        true
    );

    wp_localize_script(
        'dv-store-admin',
        'dvStoreAdmin',
        array(
            'storageKey'  => 'dvStoreProfileSectionState',
            'countLabel'  => html_entity_decode( '&#1053;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ),
            'emptyText'   => html_entity_decode( '&#1053;&#1080;&#1095;&#1077;&#1075;&#1086; &#1085;&#1077; &#1085;&#1072;&#1081;&#1076;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ),
            'searchLabel' => html_entity_decode( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1087;&#1086; &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1102;', ENT_QUOTES, 'UTF-8' ),
            'mediaTitle'  => html_entity_decode( '&#1042;&#1099;&#1073;&#1088;&#1072;&#1090;&#1100; &#1080;&#1079;&#1086;&#1073;&#1088;&#1072;&#1078;&#1077;&#1085;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
            'mediaButton' => html_entity_decode( '&#1048;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1086;&#1074;&#1072;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
        )
    );
}
add_action( 'admin_enqueue_scripts', 'dv_store_admin_enqueue_assets' );

function dv_store_profile_required_fields() {
    return array(
        'name',
        'phone',
        'phone_display',
        'email',
        'city',
        'region',
        'country_name',
        'country_code',
        'workdays',
        'opens',
        'closes',
        'ozon_url',
        'footer_description',
    );
}

function dv_render_store_profile_field( $profile, $key, $label, $type = 'text' ) {
    $field_id = 'dv-store-' . str_replace( '_', '-', $key );
    $required = in_array( $key, dv_store_profile_required_fields(), true );
    $marketplace_group = preg_match( '/^marketplace_([23])_/', $key, $matches ) ? 'marketplace_' . $matches[1] : '';
    ?>
    <tr
      class="dv-store-profile-field"
      data-dv-store-field="<?php echo esc_attr( $key ); ?>"
      data-dv-store-type="<?php echo esc_attr( $type ); ?>"
      data-dv-store-required="<?php echo $required ? '1' : '0'; ?>"
      <?php if ( '' !== $marketplace_group ) : ?>
        data-dv-store-marketplace-group="<?php echo esc_attr( $marketplace_group ); ?>"
      <?php endif; ?>
    >
      <th scope="row"><label for="<?php echo esc_attr( $field_id ); ?>"><?php echo esc_html( $label ); ?></label></th>
      <td>
        <?php if ( 'textarea' === $type ) : ?>
          <textarea class="large-text" rows="4" id="<?php echo esc_attr( $field_id ); ?>" name="dv_store_profile[<?php echo esc_attr( $key ); ?>]"><?php echo esc_textarea( $profile[ $key ] ?? '' ); ?></textarea>
        <?php elseif ( 'media' === $type ) : ?>
          <?php $value = esc_url( $profile[ $key ] ?? '' ); ?>
          <div class="dv-store-media-field" data-dv-store-media-field>
            <div class="dv-store-media-preview<?php echo '' === $value ? ' is-empty' : ''; ?>" data-dv-store-media-preview>
              <?php if ( '' !== $value ) : ?>
                <img src="<?php echo esc_url( $value ); ?>" alt="">
              <?php endif; ?>
            </div>
            <div class="dv-store-media-control">
              <input type="url" class="regular-text" id="<?php echo esc_attr( $field_id ); ?>" name="dv_store_profile[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $value ); ?>" data-dv-store-media-input>
              <div class="dv-store-media-actions dv-suite-action-row">
                <button type="button" class="button" data-dv-store-media-select>
                  <?php echo esc_html( html_entity_decode( '&#1042;&#1099;&#1073;&#1088;&#1072;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ) ); ?>
                </button>
                <button type="button" class="button" data-dv-store-media-clear>
                  <?php echo esc_html( html_entity_decode( '&#1054;&#1095;&#1080;&#1089;&#1090;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ) ); ?>
                </button>
              </div>
              <p class="description"><?php echo esc_html( html_entity_decode( '&#1054;&#1089;&#1090;&#1072;&#1074;&#1100;&#1090;&#1077; &#1087;&#1091;&#1089;&#1090;&#1099;&#1084;, &#1095;&#1090;&#1086;&#1073;&#1099; &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1086;&#1074;&#1072;&#1090;&#1100; &#1092;&#1072;&#1081;&#1083; &#1080;&#1079; &#1090;&#1077;&#1084;&#1099; &#1080;&#1083;&#1080; &#1072;&#1074;&#1090;&#1086;-fallback.', ENT_QUOTES, 'UTF-8' ) ); ?></p>
            </div>
          </div>
        <?php else : ?>
          <input type="<?php echo esc_attr( $type ); ?>" class="regular-text" id="<?php echo esc_attr( $field_id ); ?>" name="dv_store_profile[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $profile[ $key ] ?? '' ); ?>">
        <?php endif; ?>
      </td>
    </tr>
    <?php
}

function dv_render_store_profile_section( $profile, $labels, $id, $title, $description, $fields ) {
    ?>
    <section class="dv-store-settings-section" id="<?php echo esc_attr( $id ); ?>" data-dv-store-section>
      <header class="dv-store-settings-section-head">
        <div class="dv-store-settings-section-title">
          <div>
            <h2><?php echo esc_html( $title ); ?></h2>
            <?php if ( '' !== trim( (string) $description ) ) : ?>
              <p><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>
          </div>
          <button
            type="button"
            class="button dv-store-section-toggle"
            aria-expanded="true"
            data-open-label="<?php echo esc_attr( html_entity_decode( '&#1057;&#1074;&#1077;&#1088;&#1085;&#1091;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ) ); ?>"
            data-closed-label="<?php echo esc_attr( html_entity_decode( '&#1056;&#1072;&#1089;&#1082;&#1088;&#1099;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ) ); ?>"
          >
            <?php echo esc_html( html_entity_decode( '&#1057;&#1074;&#1077;&#1088;&#1085;&#1091;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ) ); ?>
          </button>
        </div>
      </header>
      <table class="form-table" role="presentation">
        <tbody>
          <?php
          foreach ( $fields as $field ) {
              if ( ! is_array( $field ) || empty( $field[0] ) ) {
                  continue;
              }

              $key  = $field[0];
              $type = $field[1] ?? 'text';

              $label = $labels[ $key ] ?? ucwords( str_replace( '_', ' ', $key ) );
              dv_render_store_profile_field( $profile, $key, $label, $type );
          }
          ?>
        </tbody>
      </table>
    </section>
    <?php
}

function dv_store_profile_count_filled_fields( $profile, $fields ) {
    $filled = 0;

    foreach ( $fields as $key ) {
        if ( '' !== trim( (string) ( $profile[ $key ] ?? '' ) ) ) {
            $filled++;
        }
    }

    return $filled;
}

function dv_render_store_profile_overview( $profile ) {
    $cards = array(
        array(
            'label'  => html_entity_decode( '&#1054;&#1089;&#1085;&#1086;&#1074;&#1085;&#1086;&#1077;', ENT_QUOTES, 'UTF-8' ),
            'hint'   => html_entity_decode( '&#1085;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077; &#1080; &#1083;&#1086;&#1075;&#1086;&#1090;&#1080;&#1087;', ENT_QUOTES, 'UTF-8' ),
            'target' => 'dv-store-main',
            'fields' => array( 'name' ),
        ),
        array(
            'label'  => html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;', ENT_QUOTES, 'UTF-8' ),
            'hint'   => html_entity_decode( '&#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;, email, &#1075;&#1086;&#1088;&#1086;&#1076; &#1080; &#1075;&#1088;&#1072;&#1092;&#1080;&#1082;', ENT_QUOTES, 'UTF-8' ),
            'target' => 'dv-store-contacts',
            'fields' => array( 'phone', 'phone_display', 'email', 'city', 'region', 'country_name', 'country_code', 'workdays', 'opens', 'closes' ),
        ),
        array(
            'label'  => html_entity_decode( '&#1052;&#1072;&#1088;&#1082;&#1077;&#1090;&#1087;&#1083;&#1077;&#1081;&#1089;&#1099;', ENT_QUOTES, 'UTF-8' ),
            'hint'   => html_entity_decode( 'Ozon &#1080; &#1076;&#1086;&#1087;. &#1087;&#1083;&#1086;&#1097;&#1072;&#1076;&#1082;&#1080;', ENT_QUOTES, 'UTF-8' ),
            'target' => 'dv-store-marketplaces',
            'fields' => array( 'ozon_url' ),
        ),
        array(
            'label'  => html_entity_decode( '&#1060;&#1091;&#1090;&#1077;&#1088;', ENT_QUOTES, 'UTF-8' ),
            'hint'   => html_entity_decode( '&#1082;&#1088;&#1072;&#1090;&#1082;&#1080;&#1081; &#1090;&#1077;&#1082;&#1089;&#1090; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ),
            'target' => 'dv-store-footer',
            'fields' => array( 'footer_description' ),
        ),
    );
    ?>
    <section class="dv-store-overview" aria-label="<?php echo esc_attr( html_entity_decode( '&#1057;&#1074;&#1086;&#1076;&#1082;&#1072; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ) ); ?>">
      <?php foreach ( $cards as $card ) : ?>
        <?php
        $total    = count( $card['fields'] );
        $filled   = dv_store_profile_count_filled_fields( $profile, $card['fields'] );
        $progress = $total ? max( 0, min( 100, (int) round( ( $filled / $total ) * 100 ) ) ) : 100;
        ?>
        <a
          class="dv-store-overview-card"
          href="#<?php echo esc_attr( $card['target'] ); ?>"
          data-dv-store-overview-target="<?php echo esc_attr( $card['target'] ); ?>"
        >
          <span><?php echo esc_html( $card['label'] ); ?></span>
          <strong><?php echo esc_html( $filled . ' / ' . $total ); ?></strong>
          <small><?php echo esc_html( $card['hint'] ); ?></small>
          <i aria-hidden="true"><b style="width: <?php echo esc_attr( (string) $progress ); ?>%;"></b></i>
        </a>
      <?php endforeach; ?>
    </section>
    <?php
}

function dv_render_store_profile_preview( $profile, $theme_options = array() ) {
    $name        = trim( (string) ( $profile['name'] ?? '' ) );
    $logo_url    = trim( (string) ( $profile['logo_url'] ?? '' ) );
    $ozon_url    = trim( (string) ( $profile['ozon_url'] ?? '' ) );
    $ozon_icon   = trim( (string) ( $profile['ozon_icon_url'] ?? '' ) );
    $footer_text = trim( (string) ( $profile['footer_description'] ?? '' ) );
    $phone       = trim( (string) ( $profile['phone_display'] ?? ( $profile['phone'] ?? '' ) ) );
    $email       = trim( (string) ( $profile['email'] ?? '' ) );

    if ( '' === $name ) {
        $name = html_entity_decode( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;', ENT_QUOTES, 'UTF-8' );
    }

    if ( '' === $footer_text ) {
        $footer_text = html_entity_decode( '&#1050;&#1088;&#1072;&#1090;&#1082;&#1086;&#1077; &#1086;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072; &#1087;&#1086;&#1103;&#1074;&#1080;&#1090;&#1089;&#1103; &#1074; &#1092;&#1091;&#1090;&#1077;&#1088;&#1077;.', ENT_QUOTES, 'UTF-8' );
    }

    $header_ozon_enabled  = ! empty( $theme_options['header_ozon_enabled'] );
    $product_ozon_enabled = ! empty( $theme_options['product_ozon_enabled'] );
    ?>
    <section class="dv-store-live-preview" aria-label="<?php echo esc_attr( html_entity_decode( '&#1055;&#1088;&#1077;&#1074;&#1100;&#1102; &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1103; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ) ); ?>">
      <div class="dv-store-live-preview-main">
        <div class="dv-store-live-preview-logo<?php echo '' === $logo_url ? ' is-empty' : ''; ?>">
          <?php if ( '' !== $logo_url ) : ?>
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="">
          <?php else : ?>
            <span><?php echo esc_html( $name ); ?></span>
          <?php endif; ?>
        </div>
        <div>
          <strong><?php echo esc_html( $name ); ?></strong>
          <p><?php echo esc_html( $footer_text ); ?></p>
          <div class="dv-store-live-preview-meta">
            <?php if ( '' !== $phone ) : ?>
              <span><?php echo esc_html( $phone ); ?></span>
            <?php endif; ?>
            <?php if ( '' !== $email ) : ?>
              <span><?php echo esc_html( $email ); ?></span>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="dv-store-live-preview-marketplace">
        <span><?php echo esc_html( html_entity_decode( 'Ozon', ENT_QUOTES, 'UTF-8' ) ); ?></span>
        <strong><?php echo esc_html( '' !== $ozon_url ? html_entity_decode( '&#1057;&#1089;&#1099;&#1083;&#1082;&#1072; &#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ) : html_entity_decode( '&#1053;&#1077; &#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ) ); ?></strong>
        <small>
          <?php
          echo esc_html(
              sprintf(
                  'Header: %1$s · Product: %2$s',
                  $header_ozon_enabled ? 'on' : 'off',
                  $product_ozon_enabled ? 'on' : 'off'
              )
          );
          ?>
        </small>
        <div class="dv-store-live-preview-ozon-icon<?php echo '' === $ozon_icon ? ' is-empty' : ''; ?>">
          <?php if ( '' !== $ozon_icon ) : ?>
            <img src="<?php echo esc_url( $ozon_icon ); ?>" alt="">
          <?php else : ?>
            <span>OZ</span>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <?php
}

function dv_render_store_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $labels  = dv_store_admin_labels();
    $profile = dv_get_store_profile();
    $health  = function_exists( 'dv_theme_store_profile_health_report' ) ? dv_theme_store_profile_health_report() : array();
    $theme_options = function_exists( 'dv_get_theme_options' ) ? dv_get_theme_options() : array();
    $ozon_url_filled = '' !== trim( (string) ( $profile['ozon_url'] ?? '' ) );
    $ozon_header_off = $ozon_url_filled && empty( $theme_options['header_ozon_enabled'] );
    $ozon_product_off = $ozon_url_filled && empty( $theme_options['product_ozon_enabled'] );
    ?>
    <div class="wrap dv-suite-page dv-store-settings-page">
      <?php dv_render_admin_suite_header( 'dv-store-settings', $labels['page_title'], $labels['section_desc'] ); ?>
      <?php dv_render_store_profile_overview( $profile ); ?>
      <?php dv_render_store_profile_preview( $profile, $theme_options ); ?>

      <?php
      if ( function_exists( 'dv_render_admin_suite_local_nav' ) ) {
          dv_render_admin_suite_local_nav(
              array(
                  array( 'href' => '#dv-store-brand', 'label' => html_entity_decode( '&#1041;&#1088;&#1077;&#1085;&#1076;', ENT_QUOTES, 'UTF-8' ), 'description' => html_entity_decode( '&#1051;&#1086;&#1075;&#1086;&#1090;&#1080;&#1087;', ENT_QUOTES, 'UTF-8' ) ),
                  array( 'href' => '#dv-store-contacts', 'label' => html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;', ENT_QUOTES, 'UTF-8' ), 'description' => 'SEO' ),
                  array( 'href' => '#dv-store-marketplaces', 'label' => $labels['marketplaces'], 'description' => 'Ozon' ),
                  array( 'href' => '#dv-store-footer', 'label' => html_entity_decode( '&#1060;&#1091;&#1090;&#1077;&#1088;', ENT_QUOTES, 'UTF-8' ), 'description' => html_entity_decode( '&#1058;&#1077;&#1082;&#1089;&#1090;', ENT_QUOTES, 'UTF-8' ) ),
              )
          );
      }
      ?>

      <form class="dv-suite-card dv-store-settings-form" method="post" action="options.php" data-dv-unsaved-form>
        <?php settings_fields( 'dv_store_profile_group' ); ?>

        <?php if ( ! empty( $health ) ) : ?>
          <div class="dv-store-profile-health<?php echo ! empty( $health['issue_count'] ) ? ' has-issues' : ' is-clean'; ?>">
            <div>
              <strong><?php echo esc_html( html_entity_decode( '&#1057;&#1090;&#1072;&#1090;&#1091;&#1089; &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1103;', ENT_QUOTES, 'UTF-8' ) ); ?></strong>
              <span>
                <?php
                echo esc_html(
                    sprintf(
                        /* translators: 1: passed checks, 2: total checks. */
                        html_entity_decode( '&#1055;&#1088;&#1086;&#1081;&#1076;&#1077;&#1085;&#1086; %1$d &#1080;&#1079; %2$d &#1087;&#1088;&#1086;&#1074;&#1077;&#1088;&#1086;&#1082;', ENT_QUOTES, 'UTF-8' ),
                        absint( $health['passed'] ?? 0 ),
                        absint( $health['total'] ?? 0 )
                    )
                );
                ?>
              </span>
            </div>
            <?php if ( ! empty( $health['issues'] ) && is_array( $health['issues'] ) ) : ?>
              <ul>
                <?php foreach ( array_slice( $health['issues'], 0, 4 ) as $issue ) : ?>
                  <li><?php echo esc_html( html_entity_decode( (string) ( $issue['label'] ?? '' ), ENT_QUOTES, 'UTF-8' ) ); ?></li>
                <?php endforeach; ?>
              </ul>
            <?php else : ?>
              <p><?php echo esc_html( html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;, URL &#1080; marketplace-&#1087;&#1086;&#1083;&#1103; &#1074; &#1087;&#1086;&#1088;&#1103;&#1076;&#1082;&#1077;.', ENT_QUOTES, 'UTF-8' ) ); ?></p>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php if ( $ozon_header_off || $ozon_product_off ) : ?>
          <div class="dv-store-profile-health has-issues">
            <div>
              <strong>Ozon</strong>
              <span><?php echo esc_html( html_entity_decode( 'Ozon URL &#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;, &#1085;&#1086; &#1085;&#1077; &#1074;&#1089;&#1077; &#1082;&#1085;&#1086;&#1087;&#1082;&#1080; &#1074;&#1082;&#1083;&#1102;&#1095;&#1077;&#1085;&#1099;.', ENT_QUOTES, 'UTF-8' ) ); ?></span>
            </div>
            <ul>
              <?php if ( $ozon_header_off ) : ?>
                <li><?php echo esc_html( html_entity_decode( 'Ozon &#1074; &#1096;&#1072;&#1087;&#1082;&#1077; &#1074;&#1099;&#1082;&#1083;&#1102;&#1095;&#1077;&#1085;', ENT_QUOTES, 'UTF-8' ) ); ?></li>
              <?php endif; ?>
              <?php if ( $ozon_product_off ) : ?>
                <li><?php echo esc_html( html_entity_decode( 'Ozon &#1074; &#1090;&#1086;&#1074;&#1072;&#1088;&#1077; &#1074;&#1099;&#1082;&#1083;&#1102;&#1095;&#1077;&#1085;', ENT_QUOTES, 'UTF-8' ) ); ?></li>
              <?php endif; ?>
            </ul>
          </div>
        <?php endif; ?>

        <div class="dv-store-settings-toolbar">
          <div class="dv-store-settings-search">
            <label for="dv-store-settings-search"><?php echo esc_html( html_entity_decode( '&#1055;&#1086;&#1080;&#1089;&#1082; &#1087;&#1086; &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1102;', ENT_QUOTES, 'UTF-8' ) ); ?></label>
            <div class="dv-store-settings-search-row">
              <input
                type="search"
                id="dv-store-settings-search"
                placeholder="<?php echo esc_attr( html_entity_decode( '&#1053;&#1072;&#1081;&#1090;&#1080;: Ozon, email, &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;...', ENT_QUOTES, 'UTF-8' ) ); ?>"
              >
              <button type="button" id="dv-store-settings-search-clear" aria-label="<?php echo esc_attr( html_entity_decode( '&#1054;&#1095;&#1080;&#1089;&#1090;&#1080;&#1090;&#1100; &#1087;&#1086;&#1080;&#1089;&#1082;', ENT_QUOTES, 'UTF-8' ) ); ?>">&times;</button>
            </div>
            <p class="dv-store-settings-search-count" id="dv-store-settings-search-count"></p>
            <div class="dv-store-settings-filters" aria-label="<?php echo esc_attr( html_entity_decode( '&#1060;&#1080;&#1083;&#1100;&#1090;&#1088; &#1087;&#1086;&#1083;&#1077;&#1081; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ) ); ?>">
              <button type="button" class="is-active" data-dv-store-filter="all">
                <?php echo esc_html( html_entity_decode( '&#1042;&#1089;&#1077;', ENT_QUOTES, 'UTF-8' ) ); ?>
              </button>
              <button type="button" data-dv-store-filter="empty">
                <?php echo esc_html( html_entity_decode( '&#1055;&#1091;&#1089;&#1090;&#1099;&#1077;', ENT_QUOTES, 'UTF-8' ) ); ?>
              </button>
              <button type="button" data-dv-store-filter="filled">
                <?php echo esc_html( html_entity_decode( '&#1047;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;&#1085;&#1099;&#1077;', ENT_QUOTES, 'UTF-8' ) ); ?>
              </button>
              <span class="dv-store-empty-summary" id="dv-store-empty-summary"></span>
              <button type="button" class="dv-store-empty-jump" id="dv-store-empty-jump">
                <?php echo esc_html( html_entity_decode( '&#1050; &#1087;&#1077;&#1088;&#1074;&#1086;&#1084;&#1091; &#1087;&#1091;&#1089;&#1090;&#1086;&#1084;&#1091;', ENT_QUOTES, 'UTF-8' ) ); ?>
              </button>
            </div>
          </div>
          <nav aria-label="<?php echo esc_attr( html_entity_decode( '&#1056;&#1072;&#1079;&#1076;&#1077;&#1083;&#1099; &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1103; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1072;', ENT_QUOTES, 'UTF-8' ) ); ?>">
            <a href="#dv-store-main"><?php echo esc_html( html_entity_decode( '&#1054;&#1089;&#1085;&#1086;&#1074;&#1085;&#1086;&#1077;', ENT_QUOTES, 'UTF-8' ) ); ?></a>
            <a href="#dv-store-contacts"><?php echo esc_html( html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;', ENT_QUOTES, 'UTF-8' ) ); ?></a>
            <a href="#dv-store-marketplaces"><?php echo esc_html( $labels['marketplaces'] ); ?></a>
            <a href="#dv-store-footer"><?php echo esc_html( html_entity_decode( '&#1060;&#1091;&#1090;&#1077;&#1088;', ENT_QUOTES, 'UTF-8' ) ); ?></a>
          </nav>
          <div class="dv-store-settings-actions dv-suite-action-row">
            <button type="button" class="button" id="dv-store-expand">
              <?php echo esc_html( html_entity_decode( '&#1056;&#1072;&#1089;&#1082;&#1088;&#1099;&#1090;&#1100; &#1074;&#1089;&#1105;', ENT_QUOTES, 'UTF-8' ) ); ?>
            </button>
            <button type="button" class="button" id="dv-store-collapse">
              <?php echo esc_html( html_entity_decode( '&#1057;&#1074;&#1077;&#1088;&#1085;&#1091;&#1090;&#1100; &#1074;&#1089;&#1105;', ENT_QUOTES, 'UTF-8' ) ); ?>
            </button>
            <?php submit_button( html_entity_decode( '&#1057;&#1086;&#1093;&#1088;&#1072;&#1085;&#1080;&#1090;&#1100; &#1087;&#1088;&#1086;&#1092;&#1080;&#1083;&#1100;', ENT_QUOTES, 'UTF-8' ), 'primary', 'submit', false ); ?>
          </div>
        </div>

        <div class="dv-store-settings-sections">
          <?php
          dv_render_store_profile_section(
              $profile,
              $labels,
              'dv-store-main',
              html_entity_decode( '&#1054;&#1089;&#1085;&#1086;&#1074;&#1085;&#1086;&#1077;', ENT_QUOTES, 'UTF-8' ),
              html_entity_decode( '&#1053;&#1072;&#1079;&#1074;&#1072;&#1085;&#1080;&#1077; &#1080; &#1083;&#1086;&#1075;&#1086;&#1090;&#1080;&#1087;, &#1082;&#1086;&#1090;&#1086;&#1088;&#1099;&#1077; &#1080;&#1089;&#1087;&#1086;&#1083;&#1100;&#1079;&#1091;&#1102;&#1090;&#1089;&#1103; &#1074; &#1096;&#1072;&#1087;&#1082;&#1077;, &#1092;&#1091;&#1090;&#1077;&#1088;&#1077; &#1080; schema.org.', ENT_QUOTES, 'UTF-8' ),
              array(
                  array( 'name' ),
                  array( 'logo_url', 'media' ),
              )
          );

          dv_render_store_profile_section(
              $profile,
              $labels,
              'dv-store-contacts',
              html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;', ENT_QUOTES, 'UTF-8' ),
              html_entity_decode( '&#1044;&#1072;&#1085;&#1085;&#1099;&#1077; &#1076;&#1083;&#1103; &#1096;&#1072;&#1087;&#1082;&#1080;, &#1092;&#1091;&#1090;&#1077;&#1088;&#1072;, &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1099; &#1082;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1086;&#1074; &#1080; &#1083;&#1086;&#1082;&#1072;&#1083;&#1100;&#1085;&#1086;&#1081; SEO-&#1088;&#1072;&#1079;&#1084;&#1077;&#1090;&#1082;&#1080;.', ENT_QUOTES, 'UTF-8' ),
              array(
                  array( 'phone' ),
                  array( 'phone_display' ),
                  array( 'email', 'email' ),
                  array( 'city' ),
                  array( 'region' ),
                  array( 'country_name' ),
                  array( 'country_code' ),
                  array( 'workdays' ),
                  array( 'opens', 'time' ),
                  array( 'closes', 'time' ),
              )
          );

          dv_render_store_profile_section(
              $profile,
              $labels,
              'dv-store-marketplaces',
              $labels['marketplaces'],
              html_entity_decode( 'Ozon &#1080; &#1076;&#1086;&#1087;&#1086;&#1083;&#1085;&#1080;&#1090;&#1077;&#1083;&#1100;&#1085;&#1099;&#1077; &#1087;&#1083;&#1086;&#1097;&#1072;&#1076;&#1082;&#1080;, &#1082;&#1086;&#1090;&#1086;&#1088;&#1099;&#1077; &#1074;&#1099;&#1074;&#1086;&#1076;&#1103;&#1090;&#1089;&#1103; &#1074; &#1096;&#1072;&#1087;&#1082;&#1077; &#1080; &#1085;&#1072; &#1089;&#1077;&#1088;&#1074;&#1080;&#1089;&#1085;&#1099;&#1093; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1072;&#1093;.', ENT_QUOTES, 'UTF-8' ),
              array(
                  array( 'ozon_url', 'url' ),
                  array( 'ozon_icon_url', 'media' ),
                  array( 'marketplace_2_name' ),
                  array( 'marketplace_2_url', 'url' ),
                  array( 'marketplace_2_icon', 'media' ),
                  array( 'marketplace_3_name' ),
                  array( 'marketplace_3_url', 'url' ),
                  array( 'marketplace_3_icon', 'media' ),
              )
          );

          dv_render_store_profile_section(
              $profile,
              $labels,
              'dv-store-footer',
              html_entity_decode( '&#1060;&#1091;&#1090;&#1077;&#1088;', ENT_QUOTES, 'UTF-8' ),
              html_entity_decode( '&#1050;&#1088;&#1072;&#1090;&#1082;&#1080;&#1081; &#1090;&#1077;&#1082;&#1089;&#1090; &#1086; &#1084;&#1072;&#1075;&#1072;&#1079;&#1080;&#1085;&#1077; &#1074; &#1085;&#1080;&#1078;&#1085;&#1077;&#1081; &#1095;&#1072;&#1089;&#1090;&#1080; &#1089;&#1072;&#1081;&#1090;&#1072;.', ENT_QUOTES, 'UTF-8' ),
              array(
                  array( 'footer_description', 'textarea' ),
              )
          );
          ?>
        </div>

      </form>
      <?php
      if ( function_exists( 'dv_render_admin_suite_footer' ) ) {
          dv_render_admin_suite_footer( 'dv-store-settings' );
      }
      ?>
    </div>
    <?php
}
