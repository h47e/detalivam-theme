<?php
get_header();

$is_virtual = 'return' === (string) get_query_var( 'dv_virtual_page' );
$page_title = $is_virtual ? (string) get_query_var( 'dv_virtual_page_title', html_entity_decode( '&#1042;&#1086;&#1079;&#1074;&#1088;&#1072;&#1090; &#1090;&#1086;&#1074;&#1072;&#1088;&#1072;', ENT_QUOTES, 'UTF-8' ) ) : get_the_title();
$dv_content = function_exists( 'dv_get_theme_content_settings' ) ? dv_get_theme_content_settings() : array();

$cards = array(
    array(
        'icon'  => 'inspect',
        'title' => $dv_content['return_card_1_title'] ?? '',
        'text'  => $dv_content['return_card_1_text'] ?? '',
    ),
    array(
        'icon'  => 'chat',
        'title' => $dv_content['return_card_2_title'] ?? '',
        'text'  => $dv_content['return_card_2_text'] ?? '',
    ),
    array(
        'icon'  => 'box',
        'title' => $dv_content['return_card_3_title'] ?? '',
        'text'  => $dv_content['return_card_3_text'] ?? '',
    ),
    array(
        'icon'  => 'check',
        'title' => $dv_content['return_card_4_title'] ?? '',
        'text'  => $dv_content['return_card_4_text'] ?? '',
    ),
);

function dv_return_icon( $name ) {
    $icons = array(
        'inspect' => '<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/>',
        'chat'    => '<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>',
        'box'     => '<path d="M21 8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><path d="M3.3 7l8.7 5 8.7-5"/><path d="M12 22V12"/>',
        'check'   => '<path d="M20 6L9 17l-5-5"/>',
    );

    return $icons[ $name ] ?? $icons['inspect'];
}
?>

<div class="container page-shell page-shell--wide service-page-shell">
  <h1><?php echo esc_html( $page_title ); ?></h1>

  <section class="service-card service-delivery-intro">
    <div class="service-section-head service-section-head--left">
      <h2 class="service-section-title"><?php echo esc_html( $page_title ); ?></h2>
    </div>
    <div class="service-copy-text"><?php echo wp_kses_post( wpautop( esc_html( $dv_content['return_intro_1'] ?? '' ) ) ); ?></div>
    <div class="service-copy-text"><?php echo wp_kses_post( wpautop( esc_html( $dv_content['return_intro_2'] ?? '' ) ) ); ?></div>
  </section>

  <section class="service-features-grid service-features-grid--delivery">
    <?php foreach ( $cards as $card ) : ?>
      <article class="service-feature-card service-feature-card--delivery">
        <div class="service-feature-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <?php echo dv_return_icon( $card['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          </svg>
        </div>
        <h3><?php echo esc_html( $card['title'] ); ?></h3>
        <p><?php echo esc_html( $card['text'] ); ?></p>
      </article>
    <?php endforeach; ?>
  </section>
</div>

<?php get_footer(); ?>
