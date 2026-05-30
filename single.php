<?php get_header(); ?>
<div class="container page-shell page-shell--wide">
  <?php while (have_posts()) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <div class="tab-desc"><?php the_content(); ?></div>
  <?php endwhile; ?>
</div>
<?php get_footer(); ?>
