<?php
/** Theme-owned fallback when a list URL has no published WordPress page. */
defined( 'ABSPATH' ) || exit;
$list_type = (string) get_query_var( 'dv_virtual_page' );
if ( ! in_array( $list_type, array( 'wishlist', 'compare' ), true ) ) {
    status_header( 404 );
    get_template_part( '404' );
    return;
}
get_header();
?>
<div class="container page-shell page-shell--wide">
  <h1><?php echo esc_html( get_query_var( 'dv_virtual_page_title' ) ); ?></h1>
  <?php echo do_shortcode( 'compare' === $list_type ? '[dv_compare]' : '[dv_wishlist]' ); ?>
</div>
<?php get_footer(); ?>
