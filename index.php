<?php
/**
 * Fallback index template
 */
get_header();
?>
<div class="container simple-page-shell simple-page-shell--loose">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
  <?php endwhile; else : ?>
    <p>Страница не найдена.</p>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
