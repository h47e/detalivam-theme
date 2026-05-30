<?php
get_header();

$is_virtual = 'delivery' === (string) get_query_var( 'dv_virtual_page' );
$page_title = $is_virtual ? (string) get_query_var( 'dv_virtual_page_title', html_entity_decode( '&#1044;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ) ) : get_the_title();
$dv_store   = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
$dv_content = function_exists( 'dv_get_theme_content_settings' ) ? dv_get_theme_content_settings() : array();
$contacts_url = function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'contacts' ) : home_url( '/kontakty' );
$catalog_url  = function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['topbar_catalog_url'] ?? '', '/catalog' ) : home_url( '/catalog' );
$schedule     = trim( ( $dv_store['workdays'] ?? '' ) . ': ' . ( $dv_store['opens'] ?? '' ) . '-' . ( $dv_store['closes'] ?? '' ) );
$city_line    = trim( implode( ', ', array_filter( array( $dv_store['city'] ?? '', $dv_store['region'] ?? '' ) ) ) );

$delivery_cards = array(
    array(
        'icon'  => 'pickup',
        'title' => $dv_content['delivery_card_1_title'] ?? '',
        'text'  => $dv_content['delivery_card_1_text'] ?? '',
    ),
    array(
        'icon'  => 'city',
        'title' => $dv_content['delivery_card_2_title'] ?? '',
        'text'  => $dv_content['delivery_card_2_text'] ?? '',
    ),
    array(
        'icon'  => 'russia',
        'title' => $dv_content['delivery_card_3_title'] ?? '',
        'text'  => $dv_content['delivery_card_3_text'] ?? '',
    ),
    array(
        'icon'  => 'payment',
        'title' => $dv_content['delivery_card_4_title'] ?? '',
        'text'  => $dv_content['delivery_card_4_text'] ?? '',
    ),
);

$quick_facts = array_filter(
    array(
        ! empty( $city_line ) ? array(
            'label' => html_entity_decode( '&#1054;&#1090;&#1082;&#1091;&#1076;&#1072;', ENT_QUOTES, 'UTF-8' ),
            'value' => $city_line,
        ) : null,
        ! empty( $schedule ) ? array(
            'label' => html_entity_decode( '&#1054;&#1073;&#1088;&#1072;&#1073;&#1086;&#1090;&#1082;&#1072; &#1079;&#1072;&#1103;&#1074;&#1086;&#1082;', ENT_QUOTES, 'UTF-8' ),
            'value' => $schedule,
        ) : null,
        array(
            'label' => html_entity_decode( '&#1043;&#1077;&#1086;&#1075;&#1088;&#1072;&#1092;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
            'value' => html_entity_decode( '&#1058;&#1086;&#1083;&#1100;&#1103;&#1090;&#1090;&#1080; / &#1056;&#1086;&#1089;&#1089;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ),
        ),
    )
);

function dv_delivery_icon( $name ) {
    $icons = array(
        'pickup'  => '<path d="M3 7h18"/><path d="M5 7V5a2 2 0 012-2h10a2 2 0 012 2v2"/><path d="M5 7v12h14V7"/><path d="M9 12h6"/>',
        'city'    => '<path d="M4 20h16"/><path d="M6 20V6l6-3v17"/><path d="M12 20v-8l6-2v10"/><path d="M9 9h.01"/><path d="M9 12h.01"/><path d="M9 15h.01"/><path d="M15 13h.01"/><path d="M15 16h.01"/>',
        'russia'  => '<path d="M3 7h11v8H3z"/><path d="M14 10h3l3 3v2h-6z"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="17.5" cy="17.5" r="1.5"/>',
        'payment' => '<rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/><path d="M7 15h3"/>',
    );

    return $icons[ $name ] ?? $icons['pickup'];
}
?>

<div class="container page-shell page-shell--wide service-page-shell">
  <h1><?php echo esc_html( $page_title ); ?></h1>

  <section class="service-card service-delivery-intro">
    <div class="service-section-head service-section-head--left">
      <h2 class="service-section-title"><?php echo esc_html( sprintf( html_entity_decode( '&#1044;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1072; &#1079;&#1072;&#1082;&#1072;&#1079;&#1086;&#1074; %s', ENT_QUOTES, 'UTF-8' ), $dv_store['name'] ?? '' ) ); ?></h2>
    </div>
    <div class="service-copy-text"><?php echo wp_kses_post( wpautop( esc_html( $dv_content['delivery_intro_1'] ?? '' ) ) ); ?></div>
    <div class="service-copy-text"><?php echo wp_kses_post( wpautop( esc_html( $dv_content['delivery_intro_2'] ?? '' ) ) ); ?></div>

    <?php if ( $quick_facts ) : ?>
      <div class="service-quick-facts">
        <?php foreach ( $quick_facts as $fact ) : ?>
          <div class="service-quick-fact">
            <span class="service-quick-fact-label"><?php echo esc_html( $fact['label'] ); ?></span>
            <span class="service-quick-fact-value"><?php echo esc_html( $fact['value'] ); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="service-actions">
      <a class="service-btn service-btn--primary" href="<?php echo esc_url( $contacts_url ); ?>">
        <?php echo esc_html( html_entity_decode( '&#1059;&#1090;&#1086;&#1095;&#1085;&#1080;&#1090;&#1100; &#1091;&#1089;&#1083;&#1086;&#1074;&#1080;&#1103;', ENT_QUOTES, 'UTF-8' ) ); ?>
      </a>
      <a class="service-btn service-btn--secondary" href="<?php echo esc_url( $catalog_url ); ?>">
        <?php echo esc_html( html_entity_decode( '&#1042;&#1099;&#1073;&#1088;&#1072;&#1090;&#1100; &#1090;&#1086;&#1074;&#1072;&#1088;', ENT_QUOTES, 'UTF-8' ) ); ?>
      </a>
    </div>
  </section>

  <section class="service-features-grid service-features-grid--delivery">
    <?php foreach ( $delivery_cards as $card ) : ?>
      <article class="service-feature-card service-feature-card--delivery">
        <div class="service-feature-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <?php echo dv_delivery_icon( $card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          </svg>
        </div>
        <h3><?php echo esc_html( $card['title'] ); ?></h3>
        <p><?php echo esc_html( $card['text'] ); ?></p>
      </article>
    <?php endforeach; ?>
  </section>
</div>

<?php get_footer(); ?>
