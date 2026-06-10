<?php
get_header();

$shop_url = home_url( '/catalog/' );

$search_enabled     = ! function_exists( 'dv_theme_option_enabled' ) || dv_theme_option_enabled( 'not_found_search_enabled' );
$actions_enabled    = ! function_exists( 'dv_theme_option_enabled' ) || dv_theme_option_enabled( 'not_found_actions_enabled' );
$categories_enabled = ! function_exists( 'dv_theme_option_enabled' ) || dv_theme_option_enabled( 'not_found_categories_enabled' );

$popular_terms = array();
$not_found_categories_limit = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'not_found_categories_limit', 6, 0, 20 ) : 6;
if ( $categories_enabled && taxonomy_exists( 'product_cat' ) && $not_found_categories_limit > 0 ) {
    $terms = function_exists( 'dv_get_top_product_categories' )
        ? dv_get_top_product_categories( $not_found_categories_limit )
        : get_terms(
            array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
                'parent'     => 0,
                'number'     => $not_found_categories_limit,
                'orderby'    => 'count',
                'order'      => 'DESC',
            )
        );

    if ( ! is_wp_error( $terms ) && is_array( $terms ) ) {
        $popular_terms = $terms;
    }
}

$quick_links = array(
    array(
        'label' => 'Каталог',
        'url'   => $shop_url,
        'text'  => 'Вернуться ко всем товарам и подобрать запчасть вручную.',
    ),
    array(
        'label' => 'Доставка',
        'url'   => function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'delivery' ) : home_url( '/delivery/' ),
        'text'  => 'Посмотреть условия отправки по России и самовывоза.',
    ),
    array(
        'label' => 'Контакты',
        'url'   => function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'contacts' ) : home_url( '/contacts/' ),
        'text'  => 'Написать или позвонить, если нужна помощь с подбором.',
    ),
);
?>

<main class="container not-found-page">
  <section class="not-found-hero">
    <div class="not-found-hero__content">
      <div class="not-found-kicker">Ошибка 404</div>
      <h1>Страница не найдена, но запчасть всё ещё можно найти</h1>
      <p>Адрес мог измениться, товар могли перенести в другой раздел или ссылка устарела. Попробуйте поиск по артикулу, модели или названию детали.</p>

      <?php if ( $search_enabled ) : ?>
        <form class="not-found-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
          <input type="hidden" name="post_type" value="product">
          <label class="screen-reader-text" for="not-found-search-input">Поиск по каталогу</label>
          <input id="not-found-search-input" type="search" name="s" placeholder="Например: крыло 2107, порог, артикул..." autocomplete="off">
          <button type="submit">
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
            Найти
          </button>
        </form>
      <?php endif; ?>

      <?php if ( $actions_enabled ) : ?>
        <div class="not-found-actions">
          <a class="not-found-btn not-found-btn--primary" href="<?php echo esc_url( $shop_url ); ?>">Перейти в каталог</a>
          <a class="not-found-btn not-found-btn--ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>">На главную</a>
        </div>
      <?php endif; ?>
    </div>

    <div class="not-found-hero__panel" aria-hidden="true">
      <div class="not-found-code">404</div>
      <div class="not-found-panel-card">
        <span>Маршрут сбился</span>
        <strong>Подберём другой путь</strong>
      </div>
      <div class="not-found-line"></div>
    </div>
  </section>

  <?php if ( $actions_enabled ) : ?>
    <section class="not-found-grid" aria-label="Быстрые действия">
      <?php foreach ( $quick_links as $link ) : ?>
        <a class="not-found-card" href="<?php echo esc_url( $link['url'] ); ?>">
          <span><?php echo esc_html( $link['label'] ); ?></span>
          <p><?php echo esc_html( $link['text'] ); ?></p>
        </a>
      <?php endforeach; ?>
    </section>
  <?php endif; ?>

  <?php if ( ! empty( $popular_terms ) ) : ?>
    <section class="not-found-categories">
      <div class="section-head">
        <h2 class="section-title">Популярные разделы</h2>
        <a class="section-link" href="<?php echo esc_url( $shop_url ); ?>">Смотреть все →</a>
      </div>
      <div class="not-found-category-list">
        <?php foreach ( $popular_terms as $term ) : ?>
          <?php $term_link = get_term_link( $term ); ?>
          <?php if ( is_wp_error( $term_link ) ) : ?>
            <?php continue; ?>
          <?php endif; ?>
          <a href="<?php echo esc_url( $term_link ); ?>">
            <span><?php echo esc_html( $term->name ); ?></span>
            <em><?php echo esc_html( (string) $term->count ); ?> товаров</em>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
