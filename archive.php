<?php get_header(); ?>
<div class="container simple-page-shell">
  <h1><?php the_archive_title(); ?></h1>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div><?php the_title(); ?></div>
  <?php endwhile; else : ?>
    <p>Ничего не найдено.</p>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
