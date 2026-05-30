<?php
/**
 * Generic virtual service page created from theme content settings.
 */
defined( 'ABSPATH' ) || exit;

$page = function_exists( 'dv_get_current_custom_service_page' ) ? dv_get_current_custom_service_page() : null;

if ( empty( $page ) ) {
    status_header( 404 );
    get_template_part( '404' );
    return;
}

$catalog_url       = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/catalog/' );
$fallback_cta_url  = function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'contacts' ) : home_url( '/kontakty' );
$fallback_cta_text = html_entity_decode( '&#1057;&#1074;&#1103;&#1079;&#1072;&#1090;&#1100;&#1089;&#1103;', ENT_QUOTES, 'UTF-8' );
$cta_label         = trim( (string) ( $page['cta_label'] ?? '' ) );
$cta_label         = '' !== $cta_label ? $cta_label : $fallback_cta_text;
$cta_url           = ! empty( $page['cta_url'] ) && function_exists( 'dv_theme_content_url' )
    ? dv_theme_content_url( $page['cta_url'], $fallback_cta_url )
    : $fallback_cta_url;

if ( ! function_exists( 'dv_custom_service_icon' ) ) {
    function dv_custom_service_icon( $name ) {
        $icons = array(
            'request'  => '<path d="M7 4h10a2 2 0 012 2v14l-4-3H7a2 2 0 01-2-2V6a2 2 0 012-2z"/><path d="M8 8h8"/><path d="M8 12h5"/>',
            'check'    => '<path d="M20 6L9 17l-5-5"/>',
            'delivery' => '<path d="M3 7h11v8H3z"/><path d="M14 10h3l3 3v2h-6z"/><circle cx="7.5" cy="17.5" r="1.5"/><circle cx="17.5" cy="17.5" r="1.5"/>',
            'shield'   => '<path d="M12 3l7 3v5c0 4.2-2.8 8-7 10-4.2-2-7-5.8-7-10V6l7-3z"/><path d="M9 12l2 2 4-5"/>',
            'price'    => '<path d="M20 12V6a2 2 0 00-2-2h-6L4 12l8 8 8-8z"/><circle cx="15" cy="8" r="1"/><path d="M9 13h6"/>',
            'support'  => '<path d="M4 12a8 8 0 0116 0"/><path d="M4 12v3a2 2 0 002 2h1v-6H6a2 2 0 00-2 2z"/><path d="M20 12v3a2 2 0 01-2 2h-1v-6h1a2 2 0 012 2z"/><path d="M9 20h3a4 4 0 004-4"/>',
        );

        return $icons[ $name ] ?? $icons['request'];
    }
}

$custom_cards = ! empty( $page['cards'] ) && is_array( $page['cards'] ) ? $page['cards'] : array();

get_header();
?>

<div class="container page-shell page-shell--wide service-page-shell service-page-shell--custom">
  <h1><?php echo esc_html( $page['title'] ); ?></h1>

  <article class="service-card service-delivery-intro">
    <div class="service-section-head service-section-head--left">
      <h2 class="service-section-title"><?php echo esc_html( $page['title'] ); ?></h2>
    </div>

    <?php if ( ! empty( $page['intro'] ) ) : ?>
      <div class="service-copy-text"><?php echo wp_kses_post( wpautop( esc_html( $page['intro'] ) ) ); ?></div>
    <?php endif; ?>

    <?php if ( ! empty( $page['body'] ) ) : ?>
      <div class="service-copy-text"><?php echo wp_kses_post( wpautop( esc_html( $page['body'] ) ) ); ?></div>
    <?php endif; ?>

    <div class="service-actions">
      <?php if ( $cta_url && ! is_wp_error( $cta_url ) ) : ?>
        <a class="service-btn service-btn--primary" href="<?php echo esc_url( $cta_url ); ?>">
          <?php echo esc_html( $cta_label ); ?>
        </a>
      <?php endif; ?>

      <?php if ( $catalog_url && ! is_wp_error( $catalog_url ) ) : ?>
        <a class="service-btn service-btn--secondary" href="<?php echo esc_url( $catalog_url ); ?>">
          <?php echo esc_html( html_entity_decode( '&#1055;&#1077;&#1088;&#1077;&#1081;&#1090;&#1080; &#1074; &#1082;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;', ENT_QUOTES, 'UTF-8' ) ); ?>
        </a>
      <?php endif; ?>
    </div>
  </article>

  <?php if ( ! empty( $custom_cards ) ) : ?>
    <section class="service-features-grid service-features-grid--delivery service-custom-features">
      <?php foreach ( $custom_cards as $card ) : ?>
        <article class="service-feature-card service-feature-card--delivery">
          <div class="service-feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
              <?php echo dv_custom_service_icon( $card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </svg>
          </div>
          <h3><?php echo esc_html( $card['title'] ); ?></h3>
          <p><?php echo esc_html( $card['text'] ); ?></p>
        </article>
      <?php endforeach; ?>
    </section>
  <?php endif; ?>
</div>

<?php
get_footer();
