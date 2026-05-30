<?php
get_header();

$is_virtual = 'about' === (string) get_query_var( 'dv_virtual_page' );
$page_id    = $is_virtual ? 0 : get_the_ID();
$page_title = $is_virtual ? (string) get_query_var( 'dv_virtual_page_title', html_entity_decode( '&#1054; &#1082;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1080;', ENT_QUOTES, 'UTF-8' ) ) : get_the_title();
$dv_store   = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
$dv_content = function_exists( 'dv_get_theme_content_settings' ) ? dv_get_theme_content_settings() : array();
$content_image_url = trim( (string) ( $dv_content['about_hero_image_url'] ?? '' ) );
$image_url  = '' !== $content_image_url ? $content_image_url : ( $page_id ? get_the_post_thumbnail_url( $page_id, 'large' ) : '' );
$raw_html   = $page_id ? get_post_field( 'post_content', $page_id ) : '';

if ( ! $image_url && $raw_html && preg_match( '/<img[^>]+src=["\']([^"\']+)["\']/i', $raw_html, $matches ) ) {
    $image_url = $matches[1];
}

$about_checks = array_filter(
    array(
        $dv_content['about_check_1'] ?? '',
        $dv_content['about_check_2'] ?? '',
        $dv_content['about_check_3'] ?? '',
        $dv_content['about_check_4'] ?? '',
        $dv_content['about_check_5'] ?? '',
        $dv_content['about_check_6'] ?? '',
    )
);

$about_cards = array(
    array(
        'icon'  => 'shield',
        'title' => $dv_content['about_card_1_title'] ?? '',
        'text'  => $dv_content['about_card_1_text'] ?? '',
    ),
    array(
        'icon'  => 'price',
        'title' => $dv_content['about_card_2_title'] ?? '',
        'text'  => $dv_content['about_card_2_text'] ?? '',
    ),
    array(
        'icon'  => 'hand',
        'title' => $dv_content['about_card_3_title'] ?? '',
        'text'  => $dv_content['about_card_3_text'] ?? '',
    ),
    array(
        'icon'  => 'truck',
        'title' => $dv_content['about_card_4_title'] ?? '',
        'text'  => $dv_content['about_card_4_text'] ?? '',
    ),
);

function dv_service_text( $text ) {
    return wpautop( esc_html( (string) $text ) );
}

function dv_service_icon( $name ) {
    $icons = array(
        'shield' => '<path d="M12 3l7 3v5c0 5-3.5 9.5-7 10-3.5-.5-7-5-7-10V6l7-3z"/>',
        'price'  => '<path d="M6 3h12l-1 5 3 4-3 9H7L4 12l3-4-1-5z"/><path d="M9 9h6"/><path d="M9 13h6"/><path d="M10 17h4"/>',
        'hand'   => '<path d="M8 12V7a1 1 0 112 0v5"/><path d="M10 12V6a1 1 0 112 0v6"/><path d="M12 12V8a1 1 0 112 0v4"/><path d="M14 12v-2a1 1 0 112 0v4c0 3-2 5-5 5H9c-2.5 0-4-1.2-5-3l-1-2a1 1 0 011.8-.9L6 14V9a1 1 0 112 0v3"/>',
        'truck'  => '<path d="M3 7h11v8H3z"/><path d="M14 10h3l3 3v2h-6z"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="17.5" cy="17.5" r="1.5"/>',
    );

    return $icons[ $name ] ?? $icons['shield'];
}
?>

<div class="container page-shell page-shell--wide service-page-shell">
  <h1><?php echo esc_html( $page_title ); ?></h1>

  <section class="service-card service-hero">
    <div class="service-hero-copy">
      <h2 class="service-hero-title"><?php echo esc_html( sprintf( html_entity_decode( '&#1054; &#1082;&#1086;&#1084;&#1087;&#1072;&#1085;&#1080;&#1080; %s', ENT_QUOTES, 'UTF-8' ), $dv_store['name'] ?? '' ) ); ?></h2>
      <div class="service-copy-text"><?php echo wp_kses_post( dv_service_text( $dv_content['about_intro_1'] ?? '' ) ); ?></div>
      <div class="service-copy-text"><?php echo wp_kses_post( dv_service_text( $dv_content['about_intro_2'] ?? '' ) ); ?></div>

      <?php if ( $about_checks ) : ?>
      <div class="service-checks">
        <?php foreach ( $about_checks as $item ) : ?>
          <div class="service-check-item">
            <span class="service-check-icon">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span><?php echo esc_html( $item ); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <?php
      if ( function_exists( 'dv_render_marketplaces_row' ) ) {
          dv_render_marketplaces_row(
              array(
                  'context' => 'about',
                  'class'   => 'service-marketplaces-row--hero',
              )
          );
      }
      ?>

    </div>

    <div class="service-hero-media">
      <?php if ( $image_url ) : ?>
        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $page_title ); ?>" loading="lazy" decoding="async">
      <?php else : ?>
        <div class="service-image-fallback"><?php echo esc_html( $dv_store['name'] ?? '' ); ?></div>
      <?php endif; ?>
    </div>
  </section>

  <section class="service-card">
    <div class="service-section-head">
      <h2 class="service-section-title"><?php echo esc_html( $dv_content['about_why_title'] ?? '' ); ?></h2>
      <p class="service-section-subtitle"><?php echo esc_html( $dv_content['about_why_subtitle'] ?? '' ); ?></p>
    </div>

    <div class="service-features-grid">
      <?php foreach ( $about_cards as $card ) : ?>
        <article class="service-feature-card">
          <div class="service-feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <?php echo dv_service_icon( $card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </svg>
          </div>
          <h3><?php echo esc_html( $card['title'] ); ?></h3>
          <p><?php echo esc_html( $card['text'] ); ?></p>
        </article>
      <?php endforeach; ?>
    </div>

  </section>
</div>

<?php get_footer(); ?>
