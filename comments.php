<?php
/**
 * Theme comments template.
 *
 * Handles WooCommerce product reviews and provides a simple fallback
 * for regular WordPress comments.
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
    return;
}

if ( 'product' === get_post_type() && function_exists( 'wc_review_ratings_enabled' ) ) {
    global $product;

    if ( ! $product instanceof WC_Product ) {
        $product = wc_get_product( get_the_ID() );
    }

    $review_count = get_comments_number();
    $title_text   = 0 === $review_count
        ? html_entity_decode( '&#1054;&#1090;&#1079;&#1099;&#1074;&#1099;', ENT_QUOTES, 'UTF-8' )
        : sprintf(
            /* translators: %d: review count. */
            _n( 'Отзыв (%d)', 'Отзывы (%d)', $review_count, 'dv' ),
            $review_count
        );
    ?>
    <div id="reviews" class="woocommerce-Reviews">
      <div id="comments">
        <h2 class="woocommerce-Reviews-title"><?php echo esc_html( $title_text ); ?></h2>

        <?php if ( have_comments() ) : ?>
          <ol class="commentlist">
            <?php
            wp_list_comments(
                apply_filters(
                    'woocommerce_product_review_list_args',
                    array(
                        'callback' => 'woocommerce_comments',
                        'style'    => 'ol',
                        'short_ping' => true,
                    )
                )
            );
            ?>
          </ol>

          <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav class="woocommerce-pagination">
              <?php paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array( 'prev_text' => '&larr;', 'next_text' => '&rarr;', 'type' => 'list' ) ) ); ?>
            </nav>
          <?php endif; ?>
        <?php else : ?>
          <p class="woocommerce-noreviews"><?php echo esc_html( html_entity_decode( '&#1054;&#1090;&#1079;&#1099;&#1074;&#1086;&#1074; &#1087;&#1086;&#1082;&#1072; &#1085;&#1077;&#1090;.', ENT_QUOTES, 'UTF-8' ) ); ?></p>
        <?php endif; ?>
      </div>

      <?php if ( comments_open() ) : ?>
        <div id="review_form_wrapper">
          <div id="review_form">
            <?php
            $commenter = wp_get_current_commenter();
            $req       = get_option( 'require_name_email' );
            $fields    = array(
                'author' => sprintf(
                    '<p class="comment-form-author"><label for="author">%1$s %2$s</label><input id="author" name="author" type="text" value="%3$s" size="30" autocomplete="name" %4$s /></p>',
                    esc_html( html_entity_decode( '&#1048;&#1084;&#1103;', ENT_QUOTES, 'UTF-8' ) ),
                    $req ? '<span class="required">*</span>' : '',
                    esc_attr( $commenter['comment_author'] ?? '' ),
                    $req ? 'required' : ''
                ),
                'email'  => sprintf(
                    '<p class="comment-form-email"><label for="email">%1$s %2$s</label><input id="email" name="email" type="email" value="%3$s" size="30" autocomplete="email" %4$s /></p>',
                    esc_html( html_entity_decode( 'E-mail', ENT_QUOTES, 'UTF-8' ) ),
                    $req ? '<span class="required">*</span>' : '',
                    esc_attr( $commenter['comment_author_email'] ?? '' ),
                    $req ? 'required' : ''
                ),
            );

            $comment_field = '';

            if ( wc_review_ratings_enabled() ) {
                $rating_required = wc_review_rating_required();
                $comment_field  .= '<p class="comment-form-rating"><label for="rating">' . esc_html( html_entity_decode( '&#1042;&#1072;&#1096;&#1072; &#1086;&#1094;&#1077;&#1085;&#1082;&#1072;', ENT_QUOTES, 'UTF-8' ) ) . ( $rating_required ? ' <span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" ' . ( $rating_required ? 'required' : '' ) . '>
                    <option value="">' . esc_html( html_entity_decode( '&#1042;&#1099;&#1073;&#1077;&#1088;&#1080;&#1090;&#1077; &#1086;&#1094;&#1077;&#1085;&#1082;&#1091;', ENT_QUOTES, 'UTF-8' ) ) . '</option>
                    <option value="5">' . esc_html( html_entity_decode( '&#1054;&#1090;&#1083;&#1080;&#1095;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ) ) . '</option>
                    <option value="4">' . esc_html( html_entity_decode( '&#1061;&#1086;&#1088;&#1086;&#1096;&#1086;', ENT_QUOTES, 'UTF-8' ) ) . '</option>
                    <option value="3">' . esc_html( html_entity_decode( '&#1053;&#1086;&#1088;&#1084;&#1072;&#1083;&#1100;&#1085;&#1086;', ENT_QUOTES, 'UTF-8' ) ) . '</option>
                    <option value="2">' . esc_html( html_entity_decode( '&#1055;&#1083;&#1086;&#1093;&#1086;', ENT_QUOTES, 'UTF-8' ) ) . '</option>
                    <option value="1">' . esc_html( html_entity_decode( '&#1054;&#1095;&#1077;&#1085;&#1100; &#1087;&#1083;&#1086;&#1093;&#1086;', ENT_QUOTES, 'UTF-8' ) ) . '</option>
                </select></p>';
            }

            $comment_field .= '<p class="comment-form-comment"><label for="comment">' . esc_html( html_entity_decode( '&#1042;&#1072;&#1096; &#1086;&#1090;&#1079;&#1099;&#1074;', ENT_QUOTES, 'UTF-8' ) ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>';

            comment_form(
                apply_filters(
                    'woocommerce_product_review_comment_form_args',
                    array(
                        'title_reply'          => have_comments()
                            ? html_entity_decode( '&#1054;&#1089;&#1090;&#1072;&#1074;&#1080;&#1090;&#1100; &#1086;&#1090;&#1079;&#1099;&#1074;', ENT_QUOTES, 'UTF-8' )
                            : sprintf(
                                /* translators: %s: product title. */
                                html_entity_decode( '&#1041;&#1091;&#1076;&#1100;&#1090;&#1077; &#1087;&#1077;&#1088;&#1074;&#1099;&#1084;, &#1082;&#1090;&#1086; &#1086;&#1089;&#1090;&#1072;&#1074;&#1080;&#1090; &#1086;&#1090;&#1079;&#1099;&#1074; &#1085;&#1072; &laquo;%s&raquo;', ENT_QUOTES, 'UTF-8' ),
                                get_the_title()
                            ),
                        'title_reply_to'       => esc_html( html_entity_decode( '&#1054;&#1090;&#1074;&#1077;&#1090;&#1080;&#1090;&#1100; %s', ENT_QUOTES, 'UTF-8' ) ),
                        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
                        'title_reply_after'    => '</h3>',
                        'comment_notes_before' => '',
                        'comment_notes_after'  => '',
                        'label_submit'         => html_entity_decode( '&#1054;&#1090;&#1087;&#1088;&#1072;&#1074;&#1080;&#1090;&#1100;', ENT_QUOTES, 'UTF-8' ),
                        'logged_in_as'         => '',
                        'fields'               => $fields,
                        'comment_field'        => $comment_field,
                        'class_submit'         => 'submit',
                    )
                )
            );
            ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <?php
    return;
}
?>

<div id="comments" class="comments-area">
  <?php if ( have_comments() ) : ?>
    <h2 class="comments-title">
      <?php
      printf(
          /* translators: %s: comment count. */
          esc_html__( 'Комментарии (%s)', 'dv' ),
          number_format_i18n( get_comments_number() )
      );
      ?>
    </h2>

    <ol class="comment-list">
      <?php
      wp_list_comments(
          array(
              'style'      => 'ol',
              'short_ping' => true,
          )
      );
      ?>
    </ol>

    <?php the_comments_pagination(); ?>
  <?php endif; ?>

  <?php comment_form(); ?>
</div>
