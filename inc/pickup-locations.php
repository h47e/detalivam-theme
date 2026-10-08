<?php
defined( 'ABSPATH' ) || exit;

function dv_pickup_text( $value, $multiline = false ) {
    if ( ! is_scalar( $value ) ) {
        return '';
    }
    return $multiline ? sanitize_textarea_field( (string) $value ) : sanitize_text_field( (string) $value );
}

function dv_sanitize_pickup_locations( $input, $report_errors = true ) {
    if ( ! is_array( $input ) || empty( $input['present'] ) ) {
        $saved = get_option( 'dv_pickup_locations', array() );
        return is_array( $saved ) ? $saved : array();
    }
    $result = array();
    $invalid = false;
    foreach ( array_slice( is_array( $input['items'] ?? null ) ? $input['items'] : array(), 0, 100 ) as $item ) {
        if ( ! is_array( $item ) ) continue;
        $row = array();
        foreach ( array( 'name', 'city', 'address', 'hours', 'phone' ) as $field ) {
            $row[ $field ] = dv_pickup_text( $item[ $field ] ?? '' );
        }
        $row['note'] = dv_pickup_text( $item['note'] ?? '', true );
        $row['map_url'] = esc_url_raw( dv_pickup_text( $item['map_url'] ?? '' ), array( 'http', 'https' ) );
        $complete = '' !== $row['city'] && '' !== $row['address'];
        $row['enabled'] = ! empty( $item['enabled'] ) && $complete ? '1' : '0';
        $invalid = $invalid || ( ! empty( $item['enabled'] ) && ! $complete );
        if ( '' === implode( '', array_values( array_diff_key( $row, array( 'enabled' => true ) ) ) ) ) continue;
        $result[] = $row;
    }
    if ( $invalid && $report_errors && function_exists( 'add_settings_error' ) ) {
        add_settings_error( 'dv_pickup_locations', 'incomplete_location', 'Пункты без города или адреса сохранены выключенными. Заполните оба поля и включите пункт.', 'warning' );
    }
    return $result;
}

function dv_get_pickup_locations( $active_only = true ) {
    $saved = get_option( 'dv_pickup_locations', array() );
    $rows = dv_sanitize_pickup_locations( array( 'present' => '1', 'items' => is_array( $saved ) ? $saved : array() ), false );
    return $active_only ? array_values( array_filter( $rows, static function ( $row ) { return '1' === $row['enabled']; } ) ) : $rows;
}

function dv_render_pickup_locations() {
    $locations = dv_get_pickup_locations();
    if ( empty( $locations ) ) return;
    ?>
    <section class="pickup-locations" id="dv-pickup-locations" aria-labelledby="dv-pickup-title">
      <h2 id="dv-pickup-title">Пункты самовывоза</h2>
      <div class="pickup-locations-grid">
        <?php foreach ( $locations as $location ) : ?>
          <article class="pickup-location">
            <h3><?php echo esc_html( $location['city'] ); ?></h3>
            <?php if ( '' !== $location['name'] ) : ?><strong><?php echo esc_html( $location['name'] ); ?></strong><?php endif; ?>
            <p class="pickup-location-address"><?php echo esc_html( $location['address'] ); ?></p>
            <?php if ( '' !== $location['hours'] ) : ?><p><?php echo esc_html( $location['hours'] ); ?></p><?php endif; ?>
            <?php if ( '' !== $location['phone'] ) : ?>
              <?php $phone = preg_replace( '/[^0-9+]/', '', $location['phone'] ); ?>
              <?php if ( preg_match( '/^\+?[0-9]{5,15}$/', $phone ) ) : ?>
                <a href="<?php echo esc_url( 'tel:' . $phone ); ?>"><?php echo esc_html( $location['phone'] ); ?></a>
              <?php else : ?><p><?php echo esc_html( $location['phone'] ); ?></p><?php endif; ?>
            <?php endif; ?>
            <?php if ( '' !== $location['note'] ) : ?><p class="pickup-location-note"><?php echo nl2br( esc_html( $location['note'] ) ); ?></p><?php endif; ?>
            <?php if ( '' !== $location['map_url'] ) : ?><a href="<?php echo esc_url( $location['map_url'] ); ?>" target="_blank" rel="noopener noreferrer">На карте</a><?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
    <?php
}

function dv_render_pickup_admin_row( $index, $location = array() ) {
    $fields = array( 'city' => 'Город', 'address' => 'Адрес', 'name' => 'Название филиала', 'hours' => 'График работы', 'phone' => 'Телефон', 'map_url' => 'Ссылка на карту', 'note' => 'Примечание' );
    ?>
    <div class="dv-pickup-editor-row" data-pickup-row>
      <label><input type="checkbox" name="dv_pickup_locations[items][<?php echo esc_attr( $index ); ?>][enabled]" value="1" <?php checked( $location['enabled'] ?? '1', '1' ); ?>> Показывать на сайте</label>
      <div class="dv-pickup-editor-fields">
        <?php foreach ( $fields as $field => $label ) : ?>
          <label><span><?php echo esc_html( $label ); ?></span>
          <?php if ( 'note' === $field ) : ?>
            <textarea name="dv_pickup_locations[items][<?php echo esc_attr( $index ); ?>][<?php echo esc_attr( $field ); ?>]" rows="2"><?php echo esc_textarea( $location[ $field ] ?? '' ); ?></textarea>
          <?php else : ?>
            <input type="<?php echo 'map_url' === $field ? 'url' : 'text'; ?>" name="dv_pickup_locations[items][<?php echo esc_attr( $index ); ?>][<?php echo esc_attr( $field ); ?>]" value="<?php echo esc_attr( $location[ $field ] ?? '' ); ?>">
          <?php endif; ?></label>
        <?php endforeach; ?>
      </div>
      <button class="button" type="button" data-pickup-remove>Убрать пункт</button>
    </div>
    <?php
}

function dv_render_pickup_admin_editor() {
    $locations = dv_get_pickup_locations( false );
    ?>
    <section class="dv-store-settings-section" id="dv-store-pickup" data-dv-store-section>
      <header class="dv-store-settings-section-head"><div class="dv-store-settings-section-title">
        <h2>Пункты самовывоза</h2>
        <button type="button" class="button dv-store-section-toggle" aria-expanded="true" data-open-label="Свернуть" data-closed-label="Раскрыть">Свернуть</button>
      </div></header>
      <table class="form-table" role="presentation"><tbody><tr data-dv-store-field="pickup_locations"><th>Филиалы и адреса</th><td>
        <input type="hidden" name="dv_pickup_locations[present]" value="1">
        <div data-pickup-editor data-next-index="<?php echo esc_attr( count( $locations ) ); ?>">
          <div data-pickup-rows><?php foreach ( $locations as $index => $location ) { dv_render_pickup_admin_row( $index, $location ); } ?></div>
          <template data-pickup-template><?php dv_render_pickup_admin_row( '__INDEX__' ); ?></template>
          <button class="button" type="button" data-pickup-add>Добавить пункт самовывоза</button>
        </div>
      </td></tr></tbody></table>
    </section>
    <?php
}
