</div><!-- /#page-content -->
<?php $dv_store = function_exists( 'dv_get_store_profile' ) ? dv_get_store_profile() : array(); ?>
<?php $dv_content = function_exists( 'dv_get_theme_header_footer_content_settings' ) ? dv_get_theme_header_footer_content_settings() : ( function_exists( 'dv_get_theme_content_settings' ) ? dv_get_theme_content_settings() : array() ); ?>
<?php
$dv_logo_url = function_exists( 'dv_get_theme_logo_url' ) ? dv_get_theme_logo_url() : get_template_directory_uri() . '/assets/logo.png';
$dv_store_name = function_exists( 'dv_string_value' ) ? dv_string_value( $dv_store['name'] ?? '', get_bloginfo( 'name' ) ) : ( is_scalar( $dv_store['name'] ?? null ) ? trim( (string) $dv_store['name'] ) : get_bloginfo( 'name' ) );
$dv_footer_brand_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_brand_enabled' ) : true;
$dv_footer_description_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_description_enabled' ) : true;
$dv_footer_contacts_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_contacts_enabled' ) : true;
$dv_footer_catalog_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_catalog_enabled' ) : true;
$dv_footer_customers_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_customers_enabled' ) : true;
$dv_footer_company_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_company_enabled' ) : true;
$dv_footer_bottom_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_bottom_enabled' ) : true;
$dv_footer_payment_icons_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_payment_icons_enabled' ) : true;
$dv_footer_legal_links_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_legal_links_enabled' ) : true;
$dv_footer_customers_1_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_customers_1_enabled' ) : true;
$dv_footer_customers_2_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_customers_2_enabled' ) : true;
$dv_footer_customers_3_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_customers_3_enabled' ) : true;
$dv_footer_customers_4_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_customers_4_enabled' ) : true;
$dv_footer_customers_5_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_customers_5_enabled' ) : true;
$dv_footer_company_1_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_company_1_enabled' ) : true;
$dv_footer_company_2_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_company_2_enabled' ) : true;
$dv_footer_company_3_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_company_3_enabled' ) : true;
$dv_footer_company_4_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_company_4_enabled' ) : true;
$dv_footer_privacy_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_privacy_enabled' ) : true;
$dv_footer_offer_enabled = function_exists( 'dv_theme_option_enabled' ) ? dv_theme_option_enabled( 'footer_offer_enabled' ) : true;
$dv_service_about_enabled = ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'about' );
$dv_service_delivery_enabled = ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'delivery' );
$dv_service_contacts_enabled = ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'contacts' );
$dv_service_return_enabled = ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'return' );
$dv_service_privacy_enabled = ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'privacy' );
$dv_service_agreement_enabled = ! function_exists( 'dv_service_page_enabled' ) || dv_service_page_enabled( 'agreement' );
$dv_footer_copyright = trim( (string) ( $dv_content['footer_copyright_text'] ?? '' ) );
$dv_footer_copyright = '' !== $dv_footer_copyright
    ? str_replace( '{year}', date( 'Y' ), $dv_footer_copyright )
    : html_entity_decode( '&copy; ' . date( 'Y' ) . ' &#1044;&#1077;&#1090;&#1072;&#1083;&#1080;&#1042;&#1072;&#1084;. &#1042;&#1089;&#1077; &#1087;&#1088;&#1072;&#1074;&#1072; &#1079;&#1072;&#1097;&#1080;&#1097;&#1077;&#1085;&#1099;.', ENT_QUOTES, 'UTF-8' );
$dv_footer_payment_icons = preg_split( '/[\r\n,]+/', (string) ( $dv_content['footer_payment_icons'] ?? '' ) );
$dv_footer_payment_icons = array_values(
    array_filter(
        array_map( 'trim', is_array( $dv_footer_payment_icons ) ? $dv_footer_payment_icons : array() )
    )
);
$dv_footer_custom_service_pages = function_exists( 'dv_get_footer_custom_service_pages' ) ? dv_get_footer_custom_service_pages() : ( function_exists( 'dv_get_custom_service_pages' ) ? dv_get_custom_service_pages() : array() );
?>

<footer class="site-footer">
  <div class="footer-main">
    <div class="container">
      <div class="footer-grid">

        <?php if ( $dv_footer_brand_enabled ) : ?>
        <div class="footer-brand">
          <div class="footer-logo">
            <img src="<?php echo esc_url( $dv_logo_url ); ?>" alt="<?php echo esc_attr( $dv_store_name ); ?>" class="footer-logo-img">
            <span class="sr-only"><?php echo esc_html( $dv_store_name ); ?></span>
          </div>
          <?php if ( $dv_footer_description_enabled ) : ?>
            <p class="footer-desc"><?php echo esc_html( $dv_store['footer_description'] ?? '' ); ?></p>
          <?php endif; ?>
          <?php if ( $dv_footer_contacts_enabled ) : ?>
            <div class="footer-phone"><a href="tel:<?php echo esc_attr( $dv_store['phone_href'] ?? '' ); ?>"><?php echo esc_html( $dv_store['phone_display'] ?? '' ); ?></a></div>
            <div class="footer-schedule"><?php echo esc_html( trim( ( $dv_store['workdays'] ?? '' ) . ': ' . ( $dv_store['opens'] ?? '' ) . '-' . ( $dv_store['closes'] ?? '' ) ) ); ?></div>
          <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ( $dv_footer_catalog_enabled ) : ?>
        <div>
          <div class="footer-col-title"><?php echo esc_html( $dv_content['footer_catalog_title'] ?? '' ); ?></div>
          <div class="footer-links">
            <?php
            $footer_categories_limit = function_exists( 'dv_theme_option_int' ) ? dv_theme_option_int( 'footer_categories_limit', 6, 0, 16 ) : 6;
            $cats = array();
            if ( $footer_categories_limit > 0 ) {
                $cats = function_exists( 'dv_get_top_product_categories' )
                    ? dv_get_top_product_categories( $footer_categories_limit )
                    : get_terms(
                        array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,
                            'parent'     => 0,
                            'number'     => $footer_categories_limit,
                            'orderby'    => 'count',
                            'order'      => 'DESC',
                        )
                    );
            }
            if ( $footer_categories_limit > 0 && $cats && ! is_wp_error( $cats ) ) :
                foreach ( $cats as $c ) :
                    ?>
            <a href="<?php echo esc_url( get_term_link( $c ) ); ?>"><?php echo esc_html( $c->name ); ?></a>
            <?php endforeach; endif; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( $dv_footer_customers_enabled ) : ?>
        <div>
          <div class="footer-col-title"><?php echo esc_html( $dv_content['footer_customers_title'] ?? '' ); ?></div>
          <div class="footer-links">
            <?php $dv_footer_rendered_customer_urls = array(); ?>
            <?php if ( $dv_footer_customers_1_enabled && $dv_service_delivery_enabled ) : ?>
            <?php
            $dv_footer_customer_url             = function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_customers_1_url'] ?? '', function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'delivery' ) : '/dostavka' ) : ( $dv_content['footer_customers_1_url'] ?? '/dostavka' );
            $dv_footer_rendered_customer_urls[] = untrailingslashit( $dv_footer_customer_url );
            ?>
            <a href="<?php echo esc_url( $dv_footer_customer_url ); ?>"><?php echo esc_html( $dv_content['footer_customers_1_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_footer_customers_2_enabled && $dv_service_return_enabled ) : ?>
            <?php
            $dv_footer_customer_url             = function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_customers_2_url'] ?? '', function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'return' ) : '/vozvrat' ) : ( $dv_content['footer_customers_2_url'] ?? '/vozvrat' );
            $dv_footer_rendered_customer_urls[] = untrailingslashit( $dv_footer_customer_url );
            ?>
            <a href="<?php echo esc_url( $dv_footer_customer_url ); ?>"><?php echo esc_html( $dv_content['footer_customers_2_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_footer_customers_3_enabled ) : ?>
            <?php
            $dv_footer_customer_url             = function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_customers_3_url'] ?? '', '/garantiya' ) : ( $dv_content['footer_customers_3_url'] ?? '/garantiya' );
            $dv_footer_rendered_customer_urls[] = untrailingslashit( $dv_footer_customer_url );
            ?>
            <a href="<?php echo esc_url( $dv_footer_customer_url ); ?>"><?php echo esc_html( $dv_content['footer_customers_3_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_footer_customers_4_enabled ) : ?>
            <?php
            $dv_footer_customer_url             = function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_customers_4_url'] ?? '', '/kak-zakazat' ) : ( $dv_content['footer_customers_4_url'] ?? '/kak-zakazat' );
            $dv_footer_rendered_customer_urls[] = untrailingslashit( $dv_footer_customer_url );
            ?>
            <a href="<?php echo esc_url( $dv_footer_customer_url ); ?>"><?php echo esc_html( $dv_content['footer_customers_4_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_footer_customers_5_enabled ) : ?>
            <?php
            $dv_footer_customer_url             = function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_customers_5_url'] ?? '', '/optovikam' ) : ( $dv_content['footer_customers_5_url'] ?? '/optovikam' );
            $dv_footer_rendered_customer_urls[] = untrailingslashit( $dv_footer_customer_url );
            ?>
            <a href="<?php echo esc_url( $dv_footer_customer_url ); ?>"><?php echo esc_html( $dv_content['footer_customers_5_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( ! empty( $dv_footer_custom_service_pages ) ) : ?>
              <?php foreach ( $dv_footer_custom_service_pages as $dv_footer_custom_service_page ) : ?>
                <?php
                if ( '1' !== (string) ( $dv_footer_custom_service_page['footer_enabled'] ?? '1' ) ) {
                    continue;
                }

                $dv_footer_custom_label = trim( (string) ( $dv_footer_custom_service_page['title'] ?? '' ) );
                $dv_footer_custom_url   = home_url( '/' . ( $dv_footer_custom_service_page['slug'] ?? '' ) );
                $dv_footer_custom_key   = untrailingslashit( (string) $dv_footer_custom_url );

                if ( '' === $dv_footer_custom_label || '' === $dv_footer_custom_key || in_array( $dv_footer_custom_key, $dv_footer_rendered_customer_urls, true ) ) {
                    continue;
                }

                $dv_footer_rendered_customer_urls[] = $dv_footer_custom_key;
                ?>
                <a href="<?php echo esc_url( $dv_footer_custom_url ); ?>"><?php echo esc_html( $dv_footer_custom_label ); ?></a>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( $dv_footer_company_enabled ) : ?>
        <div>
          <div class="footer-col-title"><?php echo esc_html( $dv_content['footer_company_title'] ?? '' ); ?></div>
          <div class="footer-links">
            <?php if ( $dv_footer_company_1_enabled && $dv_service_about_enabled ) : ?>
            <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_company_1_url'] ?? '', function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'about' ) : '/o-kompanii' ) : ( $dv_content['footer_company_1_url'] ?? '/o-kompanii' ) ); ?>"><?php echo esc_html( $dv_content['footer_company_1_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_footer_company_2_enabled && $dv_service_contacts_enabled ) : ?>
            <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_company_2_url'] ?? '', function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'contacts' ) : '/kontakty' ) : ( $dv_content['footer_company_2_url'] ?? '/kontakty' ) ); ?>"><?php echo esc_html( $dv_content['footer_company_2_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_footer_company_3_enabled ) : ?>
            <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_company_3_url'] ?? '', '/vakansii' ) : ( $dv_content['footer_company_3_url'] ?? '/vakansii' ) ); ?>"><?php echo esc_html( $dv_content['footer_company_3_label'] ?? '' ); ?></a>
            <?php endif; ?>
            <?php if ( $dv_footer_company_4_enabled ) : ?>
            <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_company_4_url'] ?? '', '/blog' ) : ( $dv_content['footer_company_4_url'] ?? '/blog' ) ); ?>"><?php echo esc_html( $dv_content['footer_company_4_label'] ?? '' ); ?></a>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <?php if ( $dv_footer_bottom_enabled ) : ?>
  <div class="footer-bottom">
    <div class="container footer-bottom-row">
      <span><?php echo esc_html( $dv_footer_copyright ); ?></span>
      <?php if ( $dv_footer_payment_icons_enabled && ! empty( $dv_footer_payment_icons ) ) : ?>
        <div class="footer-pay-icons">
          <?php foreach ( $dv_footer_payment_icons as $dv_footer_payment_icon ) : ?>
            <span class="pay-icon"><?php echo esc_html( $dv_footer_payment_icon ); ?></span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if ( $dv_footer_legal_links_enabled && ( ( $dv_footer_privacy_enabled && $dv_service_privacy_enabled ) || ( $dv_footer_offer_enabled && $dv_service_agreement_enabled ) ) ) : ?>
      <div class="footer-bottom-links">
        <?php if ( $dv_footer_privacy_enabled && $dv_service_privacy_enabled ) : ?>
        <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_privacy_url'] ?? '', '/politika-konfidencialnosti' ) : ( $dv_content['footer_privacy_url'] ?? '/politika-konfidencialnosti' ) ); ?>"><?php echo esc_html( $dv_content['footer_privacy_label'] ?? '' ); ?></a>
        <?php endif; ?>
        <?php if ( $dv_footer_offer_enabled && $dv_service_agreement_enabled ) : ?>
        <a href="<?php echo esc_url( function_exists( 'dv_theme_content_url' ) ? dv_theme_content_url( $dv_content['footer_offer_url'] ?? '', function_exists( 'dv_service_page_url' ) ? dv_service_page_url( 'agreement' ) : '/polzovatelskoe-soglashenie' ) : ( $dv_content['footer_offer_url'] ?? '/polzovatelskoe-soglashenie' ) ); ?>"><?php echo esc_html( $dv_content['footer_offer_label'] ?? '' ); ?></a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>
</footer>

<!-- Toast -->
<div class="toast" id="dv-toast">
  <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
  <span id="dv-toast-msg">&#1043;&#1086;&#1090;&#1086;&#1074;&#1086;!</span>
</div>

<!-- Lightbox -->
<div class="lightbox" id="dv-lightbox">
  <span class="lightbox-close" id="lb-close">&times;</span>
  <span class="lightbox-prev" id="lb-prev">&#8249;</span>
  <img class="lightbox-img" id="lb-img" src="" alt="">
  <span class="lightbox-next" id="lb-next">&#8250;</span>
</div>

<?php wp_footer(); ?>
</body>
</html>
