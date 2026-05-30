<?php get_header(); ?>
<div class="container page-shell page-shell--wide">
  <?php while ( have_posts() ) : the_post(); ?>
    <?php
    global $post;

    $is_wide_page = false;
    $has_wishlist_shortcode = $post && has_shortcode( $post->post_content, 'dv_wishlist' );
    $has_compare_shortcode  = $post && has_shortcode( $post->post_content, 'dv_compare' );
    $is_wishlist_page       = $post && 'wishlist' === $post->post_name;
    $is_compare_page        = $post && 'compare' === $post->post_name;

    if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
        $is_wide_page = true;
    }

    if ( $post && ( $has_wishlist_shortcode || $has_compare_shortcode || $is_wishlist_page || $is_compare_page ) ) {
        $is_wide_page = true;
    }
    ?>
    <h1><?php the_title(); ?></h1>
    <?php if ( $is_wide_page ) : ?>
      <?php if ( $is_compare_page && ! $has_compare_shortcode ) : ?>
        <?php echo do_shortcode( '[dv_compare]' ); ?>
      <?php elseif ( $is_wishlist_page && ! $has_wishlist_shortcode ) : ?>
        <?php echo do_shortcode( '[dv_wishlist]' ); ?>
      <?php else : ?>
        <?php the_content(); ?>
      <?php endif; ?>
    <?php else : ?>
      <div class="page-content"><?php the_content(); ?></div>
    <?php endif; ?>
  <?php endwhile; ?>
</div>
<?php get_footer(); ?>
