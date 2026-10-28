<?php
/** Persistent mobile destinations. Ordinary links also work without JavaScript. */
defined( 'ABSPATH' ) || exit;
$dv_mobile_catalog_active = is_shop() || is_product_taxonomy() || is_product() || ( is_search() && 'product' === get_query_var( 'post_type' ) );
$dv_mobile_items = array(
    array( 'key' => 'home', 'label' => 'Главная', 'url' => home_url( '/' ), 'active' => is_front_page(), 'icon' => '<path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/>' ),
    array( 'key' => 'catalog', 'label' => 'Каталог', 'url' => $args['shop_url'], 'active' => $dv_mobile_catalog_active, 'icon' => '<line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>' ),
);
if ( $args['wishlist'] ) {
    $dv_mobile_items[] = array( 'key' => 'wishlist', 'label' => 'Избранное', 'url' => function_exists( 'wc_get_wishlist_url' ) ? wc_get_wishlist_url() : home_url( '/wishlist/' ), 'active' => is_page( 'wishlist' ), 'count' => $args['wishlist_count'], 'icon' => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>' );
}
if ( $args['cart'] ) {
    $dv_mobile_items[] = array( 'key' => 'cart', 'label' => 'Корзина', 'url' => wc_get_cart_url(), 'active' => is_cart(), 'count' => $args['cart_count'], 'icon' => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>' );
}
if ( $args['account'] ) {
    $dv_mobile_items[] = array( 'key' => 'account', 'label' => 'Кабинет', 'url' => wc_get_page_permalink( 'myaccount' ), 'active' => is_account_page(), 'icon' => '<path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="8" r="4"/>' );
}
?>
<nav class="dv-mobile-nav" aria-label="Навигация магазина">
  <?php foreach ( $dv_mobile_items as $dv_mobile_item ) : ?>
    <a class="dv-mobile-nav-link" href="<?php echo esc_url( $dv_mobile_item['url'] ); ?>" data-dv-mobile-destination="<?php echo esc_attr( $dv_mobile_item['key'] ); ?>"<?php if ( $dv_mobile_item['active'] ) : ?> aria-current="page"<?php endif; ?>>
      <span class="dv-mobile-nav-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $dv_mobile_item['icon']; // Static theme-owned SVG paths. ?></svg>
        <?php if ( isset( $dv_mobile_item['count'] ) ) : ?>
          <span class="dv-mobile-nav-badge" data-dv-mobile-count="<?php echo esc_attr( $dv_mobile_item['key'] ); ?>"<?php if ( ! $dv_mobile_item['count'] ) : ?> hidden<?php endif; ?>><?php echo esc_html( $dv_mobile_item['count'] ); ?></span>
        <?php endif; ?>
      </span>
      <span><?php echo esc_html( $dv_mobile_item['label'] ); ?></span>
    </a>
  <?php endforeach; ?>
</nav>
