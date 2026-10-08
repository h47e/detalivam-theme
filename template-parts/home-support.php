<?php
/** Compact purchase information, sourced from the existing store and delivery settings. */
defined( 'ABSPATH' ) || exit;
$support_content = function_exists( 'dv_get_theme_content_settings' ) ? dv_get_theme_content_settings() : array();
if ( '1' !== (string) ( $support_content['home_support_enabled'] ?? '1' ) ) {
    return;
}
$support_items = array();
if ( ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'delivery' ) ) {
    $delivery_url = function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'delivery' ) : home_url( '/dostavka/' );
    foreach ( array( 1, 3 ) as $slot ) {
        $title = trim( (string) ( $support_content[ 'delivery_card_' . $slot . '_title' ] ?? '' ) );
        $text = trim( (string) ( $support_content[ 'delivery_card_' . $slot . '_text' ] ?? '' ) );
        if ( '' !== $title && '' !== $text ) {
            $pickup_url = $delivery_url;
            if ( 1 === $slot && function_exists( 'dv_get_pickup_locations' ) && dv_get_pickup_locations() ) {
                $pickup_url .= '#dv-pickup-locations';
            }
            $support_items[] = array( 'title' => $title, 'text' => $text, 'url' => $pickup_url );
        }
    }
}
$support_store = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
$support_phone = trim( (string) ( $support_store['phone_display'] ?? '' ) );
$support_phone_href = preg_replace( '/[^0-9+]/', '', (string) ( $support_store['phone_href'] ?? ( $support_store['phone'] ?? '' ) ) );
if ( '' !== $support_phone && preg_match( '/^\+?[0-9]{5,15}$/', $support_phone_href ) ) {
    $hours = array_filter( array( trim( (string) ( $support_store['workdays'] ?? '' ) ) ), 'strlen' );
    $opens = trim( (string) ( $support_store['opens'] ?? '' ) );
    $closes = trim( (string) ( $support_store['closes'] ?? '' ) );
    if ( '' !== $opens && '' !== $closes ) {
        $hours[] = $opens . '-' . $closes;
    }
    $support_items[] = array( 'title' => $support_phone, 'text' => implode( ' · ', $hours ), 'url' => 'tel:' . $support_phone_href );
}
if ( empty( $support_items ) ) {
    return;
}
?>
<section class="home-support-band" aria-label="Самовывоз, доставка и связь с магазином">
  <div class="container home-support-links">
    <?php foreach ( $support_items as $support_item ) : ?>
      <a class="home-support-link" href="<?php echo esc_url( $support_item['url'] ); ?>">
        <strong><?php echo esc_html( $support_item['title'] ); ?></strong>
        <?php if ( '' !== $support_item['text'] ) : ?><span><?php echo esc_html( $support_item['text'] ); ?></span><?php endif; ?>
      </a>
    <?php endforeach; ?>
  </div>
</section>
