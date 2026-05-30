<?php
get_header();

$is_virtual = 'contacts' === (string) get_query_var( 'dv_virtual_page' );
$page_title = $is_virtual ? (string) get_query_var( 'dv_virtual_page_title', html_entity_decode( '&#1050;&#1086;&#1085;&#1090;&#1072;&#1082;&#1090;&#1099;', ENT_QUOTES, 'UTF-8' ) ) : get_the_title();
$dv_store   = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
$dv_content = function_exists( 'dv_get_theme_content_settings' ) ? dv_get_theme_content_settings() : array();
$delivery_url = function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'delivery' ) : home_url( '/dostavka' );
$catalog_url  = function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['topbar_catalog_url'] ?? '', '/catalog' ) : home_url( '/catalog' );
$phone_href   = ! empty( $dv_store['phone_href'] ) ? $dv_store['phone_href'] : '';
$email_href   = ! empty( $dv_store['email_href'] ) ? $dv_store['email_href'] : '';
$city_line    = trim( implode( ', ', array_filter( array( $dv_store['city'] ?? '', $dv_store['region'] ?? '' ) ) ) );
$schedule     = trim( ( $dv_store['workdays'] ?? '' ) . ': ' . ( $dv_store['opens'] ?? '' ) . '-' . ( $dv_store['closes'] ?? '' ) );
$marketplaces = function_exists( 'dv_get_marketplaces' ) ? dv_get_marketplaces( 'contacts' ) : array();

$cards = array(
    array(
        'icon'  => 'phone',
        'title' => $dv_content['contacts_card_1_title'] ?? '',
        'text'  => $dv_content['contacts_card_1_text'] ?? '',
        'meta'  => $dv_store['phone_display'] ?? '',
    ),
    array(
        'icon'  => 'pin',
        'title' => $dv_content['contacts_card_2_title'] ?? '',
        'text'  => $dv_content['contacts_card_2_text'] ?? '',
        'meta'  => trim( ( $dv_store['city'] ?? '' ) . ', ' . ( $dv_store['region'] ?? '' ) ),
    ),
    array(
        'icon'  => 'clock',
        'title' => $dv_content['contacts_card_3_title'] ?? '',
        'text'  => $dv_content['contacts_card_3_text'] ?? '',
        'meta'  => trim( ( $dv_store['workdays'] ?? '' ) . ': ' . ( $dv_store['opens'] ?? '' ) . '-' . ( $dv_store['closes'] ?? '' ) ),
    ),
    array(
        'icon'  => 'mail',
        'title' => html_entity_decode( '&#1069;&#1083;&#1077;&#1082;&#1090;&#1088;&#1086;&#1085;&#1085;&#1072;&#1103; &#1087;&#1086;&#1095;&#1090;&#1072;', ENT_QUOTES, 'UTF-8' ),
        'text'  => html_entity_decode( '&#1053;&#1072;&#1087;&#1080;&#1096;&#1080;&#1090;&#1077; &#1085;&#1072;&#1084;, &#1077;&#1089;&#1083;&#1080; &#1085;&#1091;&#1078;&#1085;&#1072; &#1082;&#1086;&#1085;&#1089;&#1091;&#1083;&#1100;&#1090;&#1072;&#1094;&#1080;&#1103; &#1080;&#1083;&#1080; &#1087;&#1086;&#1076;&#1073;&#1086;&#1088; &#1076;&#1077;&#1090;&#1072;&#1083;&#1080;.', ENT_QUOTES, 'UTF-8' ),
        'meta'  => $dv_store['email'] ?? '',
    ),
    array(
        'icon'  => 'truck',
        'title' => $dv_content['contacts_card_4_title'] ?? '',
        'text'  => $dv_content['contacts_card_4_text'] ?? '',
        'meta'  => html_entity_decode( '&#1057;&#1072;&#1084;&#1086;&#1074;&#1099;&#1074;&#1086;&#1079; / &#1086;&#1090;&#1087;&#1088;&#1072;&#1074;&#1082;&#1072; &#1087;&#1086; &#1056;&#1086;&#1089;&#1089;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ),
    ),
);

$quick_facts = array_filter(
    array(
        ! empty( $dv_store['phone_display'] ) ? array(
            'label' => html_entity_decode( '&#1058;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;', ENT_QUOTES, 'UTF-8' ),
            'value' => $dv_store['phone_display'],
        ) : null,
        ! empty( $city_line ) ? array(
            'label' => html_entity_decode( '&#1056;&#1077;&#1075;&#1080;&#1086;&#1085;', ENT_QUOTES, 'UTF-8' ),
            'value' => $city_line,
        ) : null,
        ! empty( $schedule ) ? array(
            'label' => html_entity_decode( '&#1043;&#1088;&#1072;&#1092;&#1080;&#1082;', ENT_QUOTES, 'UTF-8' ),
            'value' => $schedule,
        ) : null,
        ! empty( $dv_store['email'] ) ? array(
            'label' => html_entity_decode( 'Email', ENT_QUOTES, 'UTF-8' ),
            'value' => $dv_store['email'],
        ) : null,
    )
);

function dv_contacts_icon( $name ) {
    $icons = array(
        'phone' => '<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.08 4.18 2 2 0 014.06 2h3a2 2 0 012 1.72c.12.9.33 1.78.62 2.62a2 2 0 01-.45 2.11L8.1 9.91a16 16 0 006 6l1.46-1.15a2 2 0 012.11-.45c.84.29 1.72.5 2.62.62A2 2 0 0122 16.92z"/>',
        'pin'   => '<path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1118 0z"/><circle cx="12" cy="10" r="3"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>',
        'mail'  => '<path d="M4 6h16v12H4z"/><path d="M4 8l8 6 8-6"/>',
        'truck' => '<path d="M3 7h11v8H3z"/><path d="M14 10h3l3 3v2h-6z"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="17.5" cy="17.5" r="1.5"/>',
    );

    return $icons[ $name ] ?? $icons['phone'];
}
?>

<div class="container page-shell page-shell--wide service-page-shell">
  <h1><?php echo esc_html( $page_title ); ?></h1>

  <section class="service-card service-delivery-intro">
    <div class="service-section-head service-section-head--left">
      <h2 class="service-section-title"><?php echo esc_html( $page_title ); ?></h2>
    </div>
    <div class="service-copy-text"><?php echo wp_kses_post( wpautop( esc_html( $dv_content['contacts_intro_1'] ?? '' ) ) ); ?></div>
    <div class="service-copy-text"><?php echo wp_kses_post( wpautop( esc_html( $dv_content['contacts_intro_2'] ?? '' ) ) ); ?></div>

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
      <?php if ( $phone_href ) : ?>
        <a class="service-btn service-btn--primary" href="<?php echo esc_url( $phone_href ); ?>">
          <?php echo esc_html( html_entity_decode( '&#1055;&#1086;&#1079;&#1074;&#1086;&#1085;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ) ); ?>
        </a>
      <?php endif; ?>
      <?php if ( $email_href ) : ?>
        <a class="service-btn service-btn--secondary" href="<?php echo esc_url( $email_href ); ?>">
          <?php echo esc_html( html_entity_decode( '&#1053;&#1072;&#1087;&#1080;&#1089;&#1072;&#1090;&#1100; &#1085;&#1072; email', ENT_QUOTES, 'UTF-8' ) ); ?>
        </a>
      <?php endif; ?>
      <a class="service-btn service-btn--secondary" href="<?php echo esc_url( $delivery_url ); ?>">
          <?php echo esc_html( html_entity_decode( '&#1059;&#1089;&#1083;&#1086;&#1074;&#1080;&#1103; &#1076;&#1086;&#1089;&#1090;&#1072;&#1074;&#1082;&#1080;', ENT_QUOTES, 'UTF-8' ) ); ?>
      </a>
      <a class="service-btn service-btn--ghost" href="<?php echo esc_url( $catalog_url ); ?>">
        <?php echo esc_html( html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1081;&#1090;&#1080; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;', ENT_QUOTES, 'UTF-8' ) ); ?>
      </a>
      <?php foreach ( $marketplaces as $marketplace ) : ?>
        <a class="service-btn service-btn--marketplace" href="<?php echo esc_url( $marketplace['url'] ); ?>" target="_blank" rel="noopener noreferrer nofollow">
          <?php if ( ! empty( $marketplace['icon'] ) ) : ?>
            <img src="<?php echo esc_url( $marketplace['icon'] ); ?>" alt="" width="18" height="18" loading="lazy" decoding="async" aria-hidden="true">
          <?php endif; ?>
          <span><?php echo esc_html( $marketplace['name'] ); ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="service-features-grid service-features-grid--delivery">
    <?php foreach ( $cards as $card ) : ?>
      <article class="service-feature-card service-feature-card--delivery">
        <div class="service-feature-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <?php echo dv_contacts_icon( $card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          </svg>
        </div>
        <h3><?php echo esc_html( $card['title'] ); ?></h3>
        <p><?php echo esc_html( $card['text'] ); ?></p>
        <?php if ( ! empty( $card['meta'] ) ) : ?>
          <div class="service-feature-meta">
            <?php if ( 'phone' === $card['icon'] && $phone_href ) : ?>
              <a href="<?php echo esc_url( $phone_href ); ?>"><?php echo esc_html( $card['meta'] ); ?></a>
            <?php elseif ( 'mail' === $card['icon'] && $email_href ) : ?>
              <a href="<?php echo esc_url( $email_href ); ?>"><?php echo esc_html( $card['meta'] ); ?></a>
            <?php else : ?>
              <?php echo esc_html( $card['meta'] ); ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </article>
    <?php endforeach; ?>
  </section>
</div>

<?php get_footer(); ?>
