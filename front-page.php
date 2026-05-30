<?php
/**
 * Template Name: Главная страница
 */

get_header();

$dv_content          = function_exists( 'dv_get_theme_content_settings' ) ? dv_get_theme_content_settings() : array();
$dv_shop_url         = function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0 ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/catalog/' );
$dv_popular_limit    = max( 1, absint( $dv_content['home_popular_limit'] ?? 8 ) );
$dv_sale_limit       = max( 1, absint( $dv_content['home_sale_limit'] ?? 4 ) );
$dv_categories_limit = max( 1, absint( $dv_content['home_categories_limit'] ?? 8 ) );
$dv_home_columns     = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'home_product_columns', 4, 2, 6 ) : 4;
$dv_products_label   = html_entity_decode( '&#1090;&#1086;&#1074;&#1072;&#1088;&#1086;&#1074;', ENT_QUOTES, 'UTF-8' );

$dv_home_sections = array(
    'popular'    => array(
        'index'     => 1,
        'enabled'   => ! empty( $dv_content['home_popular_enabled'] ),
        'order'     => max( 1, absint( $dv_content['home_popular_order'] ?? 10 ) ),
        'title'     => $dv_content['home_popular_title'] ?? '',
        'link_text' => $dv_content['home_popular_link_text'] ?? '',
        'link_url'  => function_exists( 'dv_theme_content_url' )
            ? dv_theme_content_url( $dv_content['home_popular_link_url'] ?? '', add_query_arg( 'orderby', 'popularity', $dv_shop_url ) )
            : ( $dv_content['home_popular_link_url'] ?? add_query_arg( 'orderby', 'popularity', $dv_shop_url ) ),
        'classes'   => array( 'home-section', 'home-section--surface', 'home-section--compact', 'home-section--bordered' ),
        'shortcode'  => sprintf( '[products limit="%d" columns="%d" orderby="popularity" order="DESC"]', $dv_popular_limit, $dv_home_columns ),
    ),
    'sale'       => array(
        'index'     => 2,
        'enabled'   => ! empty( $dv_content['home_sale_enabled'] ),
        'order'     => max( 1, absint( $dv_content['home_sale_order'] ?? 20 ) ),
        'title'     => $dv_content['home_sale_title'] ?? '',
        'link_text' => $dv_content['home_sale_link_text'] ?? '',
        'link_url'  => function_exists( 'dv_theme_content_url' )
            ? dv_theme_content_url( $dv_content['home_sale_link_url'] ?? '', add_query_arg( 'orderby', 'date', $dv_shop_url ) )
            : ( $dv_content['home_sale_link_url'] ?? add_query_arg( 'orderby', 'date', $dv_shop_url ) ),
        'classes'   => array( 'home-section', 'home-section--surface', 'home-section--compact', 'home-section--bordered' ),
        'shortcode'  => sprintf( '[sale_products limit="%d" columns="%d"]', $dv_sale_limit, $dv_home_columns ),
    ),
    'categories' => array(
        'index'     => 3,
        'enabled'   => ! empty( $dv_content['home_categories_enabled'] ),
        'order'     => max( 1, absint( $dv_content['home_categories_order'] ?? 30 ) ),
        'title'     => $dv_content['home_categories_title'] ?? '',
        'link_text' => $dv_content['home_categories_link_text'] ?? '',
        'link_url'  => function_exists( 'dv_theme_content_url' )
            ? dv_theme_content_url( $dv_content['home_categories_link_url'] ?? '', $dv_shop_url )
            : ( $dv_content['home_categories_link_url'] ?? $dv_shop_url ),
        'classes'   => array( 'home-section' ),
    ),
);

uasort(
    $dv_home_sections,
    static function ( $a, $b ) {
        if ( (int) $a['order'] === (int) $b['order'] ) {
            return (int) $a['index'] <=> (int) $b['index'];
        }

        return (int) $a['order'] <=> (int) $b['order'];
    }
);

$dv_visible_section_number = 0;
?>

<?php foreach ( $dv_home_sections as $dv_section_key => $dv_section ) : ?>
    <?php
    if ( empty( $dv_section['enabled'] ) ) {
        continue;
    }

    $dv_visible_section_number++;
    $dv_is_first_section = 1 === $dv_visible_section_number;
    $dv_heading_tag      = $dv_is_first_section ? 'h1' : 'h2';
    $dv_section_classes  = $dv_section['classes'];

    if ( $dv_is_first_section ) {
        $dv_section_classes[] = 'home-section-first';

        if ( ! empty( $dv_section['shortcode'] ) ) {
            $dv_section_classes[] = 'home-section--first-compact';
        }
    }
    ?>

    <div class="<?php echo esc_attr( implode( ' ', array_unique( $dv_section_classes ) ) ); ?>">
      <div class="container">
        <div class="section-head">
          <<?php echo tag_escape( $dv_heading_tag ); ?> class="section-title"><?php echo esc_html( $dv_section['title'] ); ?></<?php echo tag_escape( $dv_heading_tag ); ?>>
          <?php if ( '' !== trim( (string) $dv_section['link_text'] ) ) : ?>
            <a href="<?php echo esc_url( $dv_section['link_url'] ); ?>" class="section-link"><?php echo esc_html( $dv_section['link_text'] ); ?></a>
          <?php endif; ?>
        </div>

        <?php if ( ! empty( $dv_section['shortcode'] ) ) : ?>
          <div class="home-products-grid" style="--dv-home-product-columns: <?php echo esc_attr( $dv_home_columns ); ?>;">
            <?php echo do_shortcode( $dv_section['shortcode'] ); ?>
          </div>
        <?php elseif ( 'categories' === $dv_section_key ) : ?>
          <div class="cats-grid">
            <?php
            $cats = get_terms(
                array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                    'parent'     => 0,
                    'number'     => $dv_categories_limit,
                    'orderby'    => 'count',
                    'order'      => 'DESC',
                )
            );
            if ( $cats && ! is_wp_error( $cats ) ) :
                foreach ( $cats as $cat ) :
                    $icon = dv_cat_icon( $cat->slug );
                    ?>
                <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>" class="cat-card">
                  <div class="cat-card-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                      <?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </svg>
                  </div>
                  <span class="cat-card-name"><?php echo esc_html( $cat->name ); ?></span>
                  <span class="cat-card-count"><?php echo esc_html( $cat->count ); ?> <?php echo esc_html( $dv_products_label ); ?></span>
                </a>
                    <?php
                endforeach;
            endif;
            ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
<?php endforeach; ?>

<?php get_footer(); ?>
