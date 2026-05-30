<?php
/**
 * Single product page.
 *
 * @version 1.6.4
 */

get_header();
?>

<?php
$product_page_id   = get_queried_object_id();
$product_preview   = wc_get_product( $product_page_id );
$product_page_name = function_exists( 'dv_get_product_display_name' ) ? dv_get_product_display_name( $product_preview ?: $product_page_id ) : get_the_title( $product_page_id );
$primary_cat       = $product_preview ? dv_get_primary_product_cat( $product_page_id ) : null;
$product_cat_trail = $primary_cat ? dv_get_term_trail( $primary_cat, 'product_cat' ) : array();
?>

<div class="container">
  <div class="breadcrumbs-wrap">
    <nav class="breadcrumbs">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">&#1043;&#1083;&#1072;&#1074;&#1085;&#1072;&#1103;</a>
      <span class="sep">/</span>
      <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">&#1050;&#1072;&#1090;&#1072;&#1083;&#1086;&#1075;</a>
      <?php foreach ( $product_cat_trail as $trail_term ) : ?>
        <span class="sep">/</span>
        <a href="<?php echo esc_url( get_term_link( $trail_term ) ); ?>"><?php echo esc_html( $trail_term->name ); ?></a>
      <?php endforeach; ?>
      <span class="sep">/</span>
      <span class="current"><?php echo esc_html( $product_page_name ); ?></span>
    </nav>
  </div>
</div>

<div class="container product-page-shell">
<?php while ( have_posts() ) : the_post(); global $product; ?>

<?php
$images   = $product->get_gallery_image_ids();
$main_id  = $product->get_image_id();
$all_imgs = $main_id ? array_merge( array( $main_id ), $images ) : $images;

$main_src = $main_id
  ? wp_get_attachment_image_url( $main_id, 'dv-product-lg' )
  : wc_placeholder_img_src( 'dv-product-lg' );
$main_img_html = $main_id
  ? wp_get_attachment_image(
      $main_id,
      'dv-product-lg',
      false,
      array(
          'class'         => 'gallery-main-img',
          'id'            => 'dv-main-img',
          'alt'           => $product_page_name,
          'loading'       => 'eager',
          'decoding'      => 'async',
          'fetchpriority' => 'high',
      )
  )
  : sprintf(
      '<img class="gallery-main-img" id="dv-main-img" src="%s" alt="%s" loading="eager" decoding="async" fetchpriority="high">',
      esc_url( $main_src ),
      esc_attr( $product_page_name )
  );

$gallery_urls = array_values(
    array_filter(
        array_map(
            function( $id ) {
                return wp_get_attachment_image_url( $id, 'dv-product-lg' );
            },
            $all_imgs
        )
    )
);

if ( empty( $gallery_urls ) ) {
    $gallery_urls = array( $main_src );
}

$raw_description_html = apply_filters( 'the_content', get_the_content() );
$description_parts    = function_exists( 'dv_split_product_description_specs' )
    ? dv_split_product_description_specs( $raw_description_html )
    : array( 'description' => $raw_description_html, 'specs' => array() );
$product_specs        = function_exists( 'dv_get_product_specs_for_tabs' )
    ? dv_get_product_specs_for_tabs( $product, $description_parts['specs'] ?? array() )
    : array();
$formatted_description = function_exists( 'dv_format_product_description_html' )
    ? dv_format_product_description_html( $description_parts['description'] ?? '', 'full' )
    : ( $description_parts['description'] ?? '' );

$product_related_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_related_enabled' ) : true;
$product_related_limit   = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_related_limit', 4, 1, 12 ) : 4;
$product_similar_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_similar_enabled' ) : true;
$product_similar_limit   = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_similar_limit', 4, 1, 12 ) : 4;
$product_recent_enabled  = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_recent_enabled' ) : true;
$product_recent_limit    = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_recent_limit', 4, 1, 12 ) : 4;
$product_gallery_hint_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_gallery_hint_enabled' ) : true;
$product_meta_sku_enabled     = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_meta_sku_enabled' ) : true;
$product_actions_enabled      = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_actions_enabled' ) : true;
$product_wishlist_enabled     = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_wishlist_enabled' ) : true;
$product_compare_enabled      = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_compare_enabled' ) : true;
$product_ozon_enabled         = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_ozon_enabled' ) : true;
$product_summary_description_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_summary_description_enabled' ) : true;
$product_tab_description_enabled     = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_tab_description_enabled' ) : true;
$product_tab_specs_enabled           = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_tab_specs_enabled' ) : true;
$product_tab_reviews_enabled         = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'product_tab_reviews_enabled' ) : true;
$product_tabs                        = array();

if ( $product_tab_description_enabled ) {
    $product_tabs['description'] = array(
        'label' => html_entity_decode( '&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077;', ENT_QUOTES, 'UTF-8' ),
    );
}

if ( $product_tab_specs_enabled ) {
    $product_tabs['specs'] = array(
        'label' => html_entity_decode( '&#1061;&#1072;&#1088;&#1072;&#1082;&#1090;&#1077;&#1088;&#1080;&#1089;&#1090;&#1080;&#1082;&#1080;', ENT_QUOTES, 'UTF-8' ),
    );
}

if ( $product_tab_reviews_enabled ) {
    $product_tabs['reviews'] = array(
        'label' => sprintf(
            '%s (%d)',
            html_entity_decode( '&#1054;&#1090;&#1079;&#1099;&#1074;&#1099;', ENT_QUOTES, 'UTF-8' ),
            (int) $product->get_review_count()
        ),
    );
}

$product_first_tab = key( $product_tabs );

if ( ! $product_summary_description_enabled ) {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
}

$dv_store_profile = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array();
$dv_ozon_url      = esc_url( $dv_store_profile['ozon_url'] ?? '' );
$dv_ozon_icon_url = function_exists( 'dv_get_ozon_icon_url' ) ? dv_get_ozon_icon_url() : get_template_directory_uri() . '/assets/ozon.png';
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'product-page' ); ?>>
  <div class="product-layout">

    <div class="product-gallery">
      <div class="product-gallery-frame">
        <div class="gallery-main-wrap" id="dv-gallery-main" data-images='<?php echo esc_attr( wp_json_encode( $gallery_urls ) ); ?>'>
          <?php if ( $product->is_on_sale() && floatval( $product->get_regular_price() ) > 0 ) : ?>
            <span class="gallery-sale-badge">-<?php echo round( ( floatval( $product->get_regular_price() ) - floatval( $product->get_sale_price() ) ) / floatval( $product->get_regular_price() ) * 100 ); ?>%</span>
          <?php endif; ?>

          <?php echo $main_img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          <?php if ( $product_gallery_hint_enabled ) : ?>
            <span class="gallery-zoom-hint">&#1053;&#1072;&#1078;&#1084;&#1080;&#1090;&#1077; &#1076;&#1083;&#1103; &#1091;&#1074;&#1077;&#1083;&#1080;&#1095;&#1077;&#1085;&#1080;&#1103;</span>
          <?php endif; ?>
        </div>

        <?php if ( count( $all_imgs ) > 1 ) : ?>
        <div class="gallery-thumbs-shell">
          <div class="gallery-thumbs" id="dv-thumbs">
            <?php foreach ( $all_imgs as $i => $img_id ) :
                $src = wp_get_attachment_image_url( $img_id, 'dv-product-sm' );
                ?>
            <div class="gallery-thumb <?php echo 0 === $i ? 'active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>">
              <img src="<?php echo esc_url( $src ); ?>" alt="&#1060;&#1086;&#1090;&#1086; <?php echo esc_attr( $i + 1 ); ?>" loading="lazy" decoding="async" fetchpriority="low">
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <div class="lightbox" id="dv-lightbox" aria-hidden="true">
        <button type="button" class="lightbox-close" id="lb-close" aria-label="&#1047;&#1072;&#1082;&#1088;&#1099;&#1090;&#1100;">&times;</button>
        <?php if ( count( $gallery_urls ) > 1 ) : ?>
          <button type="button" class="lightbox-prev" id="lb-prev" aria-label="&#1055;&#1088;&#1077;&#1076;&#1099;&#1076;&#1091;&#1097;&#1077;&#1077; &#1092;&#1086;&#1090;&#1086;">&#8249;</button>
          <button type="button" class="lightbox-next" id="lb-next" aria-label="&#1057;&#1083;&#1077;&#1076;&#1091;&#1102;&#1097;&#1077;&#1077; &#1092;&#1086;&#1090;&#1086;">&#8250;</button>
        <?php endif; ?>
        <img src="" alt="<?php echo esc_attr( $product_page_name ); ?>" class="lightbox-img" id="lb-img" loading="lazy" decoding="async">
      </div>
    </div>

    <div class="product-summary">
      <div class="product-summary-card">

        <div class="product-summary-head">
          <div class="product-cat-tag">
            <?php if ( ! empty( $product_cat_trail ) ) : ?>
              <?php foreach ( $product_cat_trail as $index => $trail_term ) : ?>
                <?php if ( $index > 0 ) : ?><span class="product-cat-sep">/</span><?php endif; ?>
                <a href="<?php echo esc_url( get_term_link( $trail_term ) ); ?>"><?php echo esc_html( $trail_term->name ); ?></a>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

        </div>

        <h1 class="product-title"><?php echo esc_html( $product_page_name ); ?></h1>

        <div class="product-meta-row">
          <?php if ( $product_meta_sku_enabled && $product->get_sku() ) : ?>
            <span class="product-sku">&#1040;&#1088;&#1090;.: <?php echo esc_html( $product->get_sku() ); ?></span>
          <?php endif; ?>

          <?php
          $brand       = get_post_meta( $product->get_id(), '_brand', true );
          $brand_ru    = html_entity_decode( '&#1073;&#1088;&#1077;&#1085;&#1076;', ENT_QUOTES, 'UTF-8' );
          $maker_ru    = html_entity_decode( '&#1087;&#1088;&#1086;&#1080;&#1079;&#1074;&#1086;&#1076;&#1080;&#1090;&#1077;&#1083;&#1100;', ENT_QUOTES, 'UTF-8' );

          if ( ! $brand ) {
              $attrs = $product->get_attributes();
              foreach ( $attrs as $a ) {
                  $attr_name = strtolower( $a->get_name() );
                  if (
                      false !== strpos( $attr_name, 'brand' ) ||
                      false !== strpos( $attr_name, $brand_ru ) ||
                      false !== strpos( $attr_name, $maker_ru )
                  ) {
                      $terms = $a->get_terms();
                      if ( $terms ) {
                          $brand = $terms[0]->name;
                      }
                      break;
                  }
              }
          }

          if ( $brand ) :
              ?>
            <span class="product-brand"><?php echo esc_html( $brand ); ?></span>
          <?php endif; ?>

          <?php if ( $product_tab_reviews_enabled && $product->get_average_rating() > 0 ) : ?>
          <div class="product-rating-row">
            <?php echo dv_render_stars( $product->get_average_rating(), $product->get_review_count() ); ?>
            <a href="#tab-reviews" class="rating-link js-open-reviews-tab"><?php echo esc_html( $product->get_review_count() ); ?> &#1086;&#1090;&#1079;&#1099;&#1074;&#1086;&#1074;</a>
          </div>
          <?php endif; ?>
        </div>

        <?php
        $product_summary_blocks = array();
        $product_buy_blocks     = array();

        ob_start();
        if ( function_exists( 'dv_compat_block' ) ) {
            dv_compat_block();
        }

        if ( $product_summary_description_enabled && function_exists( 'woocommerce_template_single_excerpt' ) ) {
            woocommerce_template_single_excerpt();
        }
        $product_summary_blocks[] = array(
            'order' => 10,
            'index' => 10,
            'html'  => ob_get_clean(),
        );

        ob_start();
        if ( function_exists( 'dv_economy_badge' ) ) {
            dv_economy_badge();
        }

        if ( function_exists( 'woocommerce_template_single_price' ) ) {
            woocommerce_template_single_price();
        }

        if ( function_exists( 'woocommerce_template_single_add_to_cart' ) ) {
            woocommerce_template_single_add_to_cart();
        }
        $product_buy_blocks[] = array(
            'order' => function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_purchase_order', 10, 1, 99 ) : 10,
            'index' => 10,
            'html'  => ob_get_clean(),
        );

        if ( $product_ozon_enabled && $dv_ozon_url ) {
            ob_start();
            ?>
            <a class="product-marketplace-link product-marketplace-link--ozon" href="<?php echo esc_url( $dv_ozon_url ); ?>" target="_blank" rel="noopener noreferrer nofollow sponsored">
              <img class="marketplace-ozon-icon" src="<?php echo esc_url( $dv_ozon_icon_url ); ?>" alt="" width="22" height="22" loading="lazy" decoding="async" aria-hidden="true">
              <span class="product-marketplace-text"><?php echo esc_html( html_entity_decode( '&#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084; &#1085;&#1072; Ozon', ENT_QUOTES, 'UTF-8' ) ); ?></span>
              <span class="product-marketplace-arrow" aria-hidden="true">&#8594;</span>
            </a>
            <?php
            $product_buy_blocks[] = array(
                'order' => function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_ozon_order', 20, 1, 99 ) : 20,
                'index' => 20,
                'html'  => ob_get_clean(),
            );
        }

        if ( $product_actions_enabled && ( $product_wishlist_enabled || $product_compare_enabled ) ) {
            ob_start();
            ?>
            <div class="product-actions">
              <?php if ( $product_wishlist_enabled ) : ?>
              <button
                type="button"
                class="product-action-link dv-wishlist-btn"
                data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
                data-label-default="&#1042; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1077;"
                data-label-active="&#1042; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1084;"
                title="&#1044;&#1086;&#1073;&#1072;&#1074;&#1080;&#1090;&#1100; &#1074; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1077;">
                <svg viewBox="0 0 24 24">
                  <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                </svg>
                <span>&#1042; &#1080;&#1079;&#1073;&#1088;&#1072;&#1085;&#1085;&#1086;&#1077;</span>
              </button>
              <?php endif; ?>

              <?php if ( $product_compare_enabled ) : ?>
              <button
                type="button"
                class="product-action-link dv-compare-btn"
                data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
                data-label-default="&#1057;&#1088;&#1072;&#1074;&#1085;&#1080;&#1090;&#1100;"
                data-label-active="&#1042; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1080;"
                title="&#1044;&#1086;&#1073;&#1072;&#1074;&#1080;&#1090;&#1100; &#1082; &#1089;&#1088;&#1072;&#1074;&#1085;&#1077;&#1085;&#1080;&#1102;">
                <svg viewBox="0 0 24 24">
                  <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
                <span>&#1057;&#1088;&#1072;&#1074;&#1085;&#1080;&#1090;&#1100;</span>
              </button>
              <?php endif; ?>
            </div>
            <?php
            $product_buy_blocks[] = array(
                'order' => function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_actions_order', 30, 1, 99 ) : 30,
                'index' => 30,
                'html'  => ob_get_clean(),
            );
        }

        usort(
            $product_summary_blocks,
            static function ( $a, $b ) {
                if ( (int) $a['order'] === (int) $b['order'] ) {
                    return (int) $a['index'] <=> (int) $b['index'];
                }

                return (int) $a['order'] <=> (int) $b['order'];
            }
        );

        foreach ( $product_summary_blocks as $summary_block ) {
            echo $summary_block['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }

        usort(
            $product_buy_blocks,
            static function ( $a, $b ) {
                if ( (int) $a['order'] === (int) $b['order'] ) {
                    return (int) $a['index'] <=> (int) $b['index'];
                }

                return (int) $a['order'] <=> (int) $b['order'];
            }
        );
        ?>

        <div class="product-buy-rail">
          <div class="product-purchase-panel">
            <?php
            foreach ( $product_buy_blocks as $buy_block ) {
                echo $buy_block['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            }
            ?>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php
  $product_page_blocks = array();
  $related             = $product_related_enabled ? wc_get_related_products( $product->get_id(), $product_related_limit ) : array();
  $similar             = function_exists( 'dv_get_similar_product_ids' )
    ? ( $product_similar_enabled ? dv_get_similar_product_ids( $product->get_id(), $related ?? array(), $product_similar_limit ) : array() )
    : array();
  $recently_viewed     = function_exists( 'dv_get_recently_viewed_product_ids' )
    ? ( $product_recent_enabled ? dv_get_recently_viewed_product_ids( $product->get_id(), $product_recent_limit ) : array() )
    : array();

  if ( ! empty( $product_tabs ) ) {
      ob_start();
      ?>
      <div class="product-tabs-shell">
        <div class="product-tabs-wrap">
          <div class="tabs-nav">
            <?php foreach ( $product_tabs as $tab_key => $tab_data ) : ?>
              <button class="tab-nav-btn <?php echo $product_first_tab === $tab_key ? 'active' : ''; ?>" data-tab="<?php echo esc_attr( $tab_key ); ?>"><?php echo esc_html( $tab_data['label'] ); ?></button>
            <?php endforeach; ?>
          </div>

          <?php if ( $product_tab_description_enabled ) : ?>
          <div class="tab-pane <?php echo 'description' === $product_first_tab ? 'active' : ''; ?>" id="tab-description">
            <div class="tab-desc">
              <?php if ( '' !== trim( wp_strip_all_tags( $formatted_description ) ) ) : ?>
                <?php echo wp_kses_post( $formatted_description ); ?>
              <?php else : ?>
                <p class="tab-empty-note">&#1054;&#1087;&#1080;&#1089;&#1072;&#1085;&#1080;&#1077; &#1085;&#1077; &#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;&#1086;</p>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>

          <?php if ( $product_tab_specs_enabled ) : ?>
          <div class="tab-pane <?php echo 'specs' === $product_first_tab ? 'active' : ''; ?>" id="tab-specs">
            <?php if ( ! empty( $product_specs ) ) : ?>
              <table class="spec-table">
                <?php foreach ( $product_specs as $spec ) : ?>
                <tr>
                  <td><?php echo esc_html( $spec['label'] ?? '' ); ?></td>
                  <td><?php echo esc_html( $spec['value'] ?? '' ); ?></td>
                </tr>
                <?php endforeach; ?>
              </table>
            <?php else : ?>
              <p class="tab-empty-note">&#1061;&#1072;&#1088;&#1072;&#1082;&#1090;&#1077;&#1088;&#1080;&#1089;&#1090;&#1080;&#1082;&#1080; &#1085;&#1077; &#1079;&#1072;&#1087;&#1086;&#1083;&#1085;&#1077;&#1085;&#1099;</p>
            <?php endif; ?>
          </div>
          <?php endif; ?>

          <?php if ( $product_tab_reviews_enabled ) : ?>
          <div class="tab-pane <?php echo 'reviews' === $product_first_tab ? 'active' : ''; ?>" id="tab-reviews">
            <?php comments_template(); ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php
      $product_page_blocks[] = array(
          'order' => function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_tabs_order', 40, 1, 99 ) : 40,
          'index' => 40,
          'html'  => ob_get_clean(),
      );
  }

  if ( $product_related_enabled && $related ) {
      ob_start();
      ?>
      <div class="related-shell">
        <div class="related-head">
          <div class="related-title">&#1057; &#1101;&#1090;&#1080;&#1084; &#1087;&#1086;&#1082;&#1091;&#1087;&#1072;&#1102;&#1090;</div>
        </div>

        <div class="related-body">
          <div class="woocommerce">
            <ul class="products">
              <?php foreach ( $related as $rel_id ) :
                    $rel_product = wc_get_product( $rel_id );
                    if ( ! $rel_product || ! $rel_product->is_visible() ) {
                        continue;
                    }

                    global $post;
                    $post = get_post( $rel_id );
                    if ( ! $post ) {
                        continue;
                    }

                    setup_postdata( $post );
                    wc_get_template_part( 'content', 'product' );
                endforeach; ?>
            </ul>
          </div>
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
      <?php
      $product_page_blocks[] = array(
          'order' => function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_related_order', 50, 1, 99 ) : 50,
          'index' => 50,
          'html'  => ob_get_clean(),
      );
  }

  if ( ! empty( $similar ) && function_exists( 'dv_render_product_section' ) ) {
      ob_start();
      dv_render_product_section( html_entity_decode( '&#1055;&#1086;&#1093;&#1086;&#1078;&#1080;&#1077; &#1090;&#1086;&#1074;&#1072;&#1088;&#1099;', ENT_QUOTES, 'UTF-8' ), $similar, 'related-shell--similar' );
      $product_page_blocks[] = array(
          'order' => function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_similar_order', 60, 1, 99 ) : 60,
          'index' => 60,
          'html'  => ob_get_clean(),
      );
  }

  if ( ! empty( $recently_viewed ) && function_exists( 'dv_render_product_section' ) ) {
      ob_start();
      dv_render_product_section( html_entity_decode( '&#1042;&#1099; &#1085;&#1077;&#1076;&#1072;&#1074;&#1085;&#1086; &#1089;&#1084;&#1086;&#1090;&#1088;&#1077;&#1083;&#1080;', ENT_QUOTES, 'UTF-8' ), $recently_viewed, 'related-shell--recent' );
      $product_page_blocks[] = array(
          'order' => function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'product_recent_order', 70, 1, 99 ) : 70,
          'index' => 70,
          'html'  => ob_get_clean(),
      );
  }

  usort(
      $product_page_blocks,
      static function ( $a, $b ) {
          if ( (int) $a['order'] === (int) $b['order'] ) {
              return (int) $a['index'] <=> (int) $b['index'];
          }

          return (int) $a['order'] <=> (int) $b['order'];
      }
  );

  foreach ( $product_page_blocks as $page_block ) {
      echo $page_block['html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
  }
  ?>

</div>

<?php endwhile; ?>
</div>

<?php get_footer(); ?>
