<?php
defined( 'ABSPATH' ) || exit;

$labels     = dv_wholesale_labels();
$args       = dv_wholesale_get_request_args();
$categories = dv_wholesale_get_categories();
$query      = class_exists( 'WooCommerce' ) ? dv_wholesale_get_products_query( $args ) : null;
$total      = $query ? dv_wholesale_query_total( $query ) : 0;
$all_total  = function_exists( 'dv_wholesale_get_all_products_total' ) ? dv_wholesale_get_all_products_total( $args ) : $total;
$pages      = $query ? dv_wholesale_query_pages( $query ) : 1;
$logo_url   = function_exists( 'dv_get_theme_logo_url' ) ? dv_get_theme_logo_url() : get_template_directory_uri() . '/assets/logo.png';
$store      = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
$store_name = function_exists( 'dv_string_value' ) ? dv_string_value( $store['name'] ?? '', get_bloginfo( 'name' ) ) : ( is_scalar( $store['name'] ?? null ) ? trim( (string) $store['name'] ) : get_bloginfo( 'name' ) );
$base_url   = function_exists( 'dv_wholesale_page_url' ) ? dv_wholesale_page_url() : home_url( '/optovik/' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php function_exists( 'dv_body_class' ) ? dv_body_class() : body_class(); ?>>
<?php wp_body_open(); ?>

<main class="dv-wholesale-shell">
    <header class="dv-wholesale-top">
        <a class="dv-wholesale-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $store_name ); ?>">
        </a>
        <div class="dv-wholesale-heading">
            <h1><?php echo esc_html( $labels['page_title'] ); ?></h1>
            <p><?php echo esc_html( $labels['page_desc'] ); ?></p>
        </div>
        <div class="dv-wholesale-cart" aria-live="polite">
            <span><?php echo esc_html( $labels['cart'] ); ?></span>
            <strong data-dv-wholesale-cart-count><?php echo function_exists( 'WC' ) && WC()->cart ? esc_html( WC()->cart->get_cart_contents_count() ) : '0'; ?></strong>
            <a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' ) ); ?>"><?php echo esc_html( $labels['cart'] ); ?></a>
            <a href="<?php echo esc_url( function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/' ) ); ?>"><?php echo esc_html( $labels['checkout'] ); ?></a>
        </div>
    </header>

    <form class="dv-wholesale-search" method="get" action="<?php echo esc_url( $base_url ); ?>">
        <label class="screen-reader-text" for="dv-wholesale-search-input"><?php echo esc_html( $labels['search'] ); ?></label>
        <input id="dv-wholesale-search-input" type="search" name="q" value="<?php echo esc_attr( $args['q'] ); ?>" placeholder="<?php echo esc_attr( $labels['search'] ); ?>" autocomplete="off">
        <?php if ( '' !== $args['cat'] ) : ?>
            <input type="hidden" name="cat" value="<?php echo esc_attr( $args['cat'] ); ?>">
        <?php endif; ?>
        <button type="submit"><?php echo esc_html( $labels['submit'] ); ?></button>
        <?php if ( '' !== $args['q'] || '' !== $args['cat'] ) : ?>
            <a class="dv-wholesale-reset" href="<?php echo esc_url( $base_url ); ?>"><?php echo esc_html( $labels['clear'] ); ?></a>
        <?php endif; ?>
    </form>

    <div class="dv-wholesale-layout">
        <aside class="dv-wholesale-nav" aria-label="<?php echo esc_attr( $labels['categories'] ); ?>">
            <div class="dv-wholesale-nav-title"><?php echo esc_html( $labels['categories'] ); ?></div>
            <a class="<?php echo '' === $args['cat'] ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( array_filter( array( 'q' => $args['q'] ) ), $base_url ) ); ?>">
                <span><?php echo esc_html( $labels['all_categories'] ); ?></span>
                <b><?php echo esc_html( $all_total ); ?></b>
            </a>
            <?php foreach ( $categories as $category ) : ?>
                <?php
                $category_url = add_query_arg(
                    array_filter(
                        array(
                            'q'   => $args['q'],
                            'cat' => $category->slug,
                        )
                    ),
                    $base_url
                );
                ?>
                <a class="<?php echo $args['cat'] === $category->slug ? 'is-active' : ''; ?>" style="--dv-depth: <?php echo esc_attr( min( 4, absint( $category->dv_depth ?? 0 ) ) ); ?>;" href="<?php echo esc_url( $category_url ); ?>">
                    <span><?php echo esc_html( $category->name ); ?></span>
                    <b><?php echo esc_html( (int) $category->count ); ?></b>
                </a>
            <?php endforeach; ?>
        </aside>

        <section class="dv-wholesale-products" aria-label="<?php echo esc_attr( $labels['products'] ); ?>">
            <div class="dv-wholesale-results">
                <span><?php echo esc_html( $labels['found'] ); ?></span>
                <strong><?php echo esc_html( $total ); ?></strong>
                <span><?php echo esc_html( $labels['products'] ); ?></span>
            </div>

            <div class="dv-wholesale-table" data-dv-wholesale-list>
                <div class="dv-wholesale-row dv-wholesale-row-head">
                    <span><?php echo esc_html( $labels['sku'] ); ?></span>
                    <span><?php echo esc_html( $labels['products'] ); ?></span>
                    <span><?php echo esc_html( $labels['price'] ); ?></span>
                    <span><?php echo esc_html( $labels['stock'] ); ?></span>
                    <span><?php echo esc_html( $labels['qty'] ); ?></span>
                    <span></span>
                </div>

                <?php if ( $query && $query->have_posts() ) : ?>
                    <?php
                    if ( function_exists( 'dv_prime_product_object_caches' ) ) {
                        dv_prime_product_object_caches( wp_list_pluck( $query->posts, 'ID' ) );
                    }
                    ?>
                    <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php
                        $product = function_exists( 'dv_get_product_cached' ) ? dv_get_product_cached( get_the_ID() ) : wc_get_product( get_the_ID() );
                        if ( ! $product || ! $product->is_visible() ) {
                            continue;
                        }

                        $product_id    = $product->get_id();
                        $name          = function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product ) : $product->get_name();
                        $sku           = $product->get_sku();
                        $price_html    = $product->get_price_html();
                        $can_quick_add = dv_wholesale_product_can_quick_add( $product );
                        $stock_text    = dv_wholesale_product_stock_text( $product, $labels );
                        $thumb         = get_the_post_thumbnail_url( $product_id, 'thumbnail' );
                        ?>
                        <article class="dv-wholesale-row" data-product-id="<?php echo esc_attr( $product_id ); ?>">
                            <div class="dv-wholesale-sku">
                                <span><?php echo esc_html( $sku ? $sku : $product_id ); ?></span>
                            </div>
                            <div class="dv-wholesale-product">
                                <img src="<?php echo esc_url( $thumb ? $thumb : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'thumbnail' ) : '' ) ); ?>" alt="" loading="lazy" decoding="async">
                                <div>
                                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $name ); ?></a>
                                </div>
                            </div>
                            <div class="dv-wholesale-price">
                                <?php echo wp_kses_post( $price_html ? $price_html : esc_html( $labels['price_request'] ) ); ?>
                            </div>
                            <div class="dv-wholesale-stock <?php echo $product->is_in_stock() ? 'is-in-stock' : 'is-out-stock'; ?>">
                                <?php echo esc_html( $stock_text ); ?>
                            </div>
                            <div class="dv-wholesale-qty">
                                <?php if ( $can_quick_add ) : ?>
                                    <button type="button" data-dv-qty="-1" aria-label="-">-</button>
                                    <input type="number" min="1" step="1" value="1" inputmode="numeric" aria-label="<?php echo esc_attr( $labels['qty'] ); ?>">
                                    <button type="button" data-dv-qty="1" aria-label="+">+</button>
                                <?php else : ?>
                                    <span class="dv-wholesale-no-qty"><?php echo esc_html( $labels['not_quick'] ); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="dv-wholesale-action">
                                <?php if ( $can_quick_add ) : ?>
                                    <button type="button" class="dv-wholesale-add" data-product-id="<?php echo esc_attr( $product_id ); ?>">
                                        <?php echo esc_html( $labels['add'] ); ?>
                                    </button>
                                <?php else : ?>
                                    <a class="dv-wholesale-open" href="<?php echo esc_url( $product->get_permalink() ); ?>">
                                        <?php echo esc_html( $labels['open'] ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <div class="dv-wholesale-empty"><?php echo esc_html( $labels['empty'] ); ?></div>
                <?php endif; ?>
            </div>

            <?php if ( $pages > 1 ) : ?>
                <nav class="dv-wholesale-pagination" aria-label="Pagination">
                    <?php for ( $page = 1; $page <= $pages; $page++ ) : ?>
                        <?php
                        $page_url = add_query_arg(
                            array_filter(
                                array(
                                    'q'        => $args['q'],
                                    'cat'      => $args['cat'],
                                    'opt_page' => $page > 1 ? $page : null,
                                )
                            ),
                            $base_url
                        );
                        ?>
                        <a class="<?php echo $page === $args['paged'] ? 'is-active' : ''; ?>" href="<?php echo esc_url( $page_url ); ?>"><?php echo esc_html( $page ); ?></a>
                    <?php endfor; ?>
                </nav>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php wp_footer(); ?>
</body>
</html>
