<?php get_header(); ?>
<main class="site-main">
  <section class="section">
    <div class="container">
      <?php while (have_posts()) : the_post(); ?>
      <h1 class="page-title">
        <?php the_title(); ?>
      </h1>
      <div class="page-content">
        <?php the_content(); ?>
      </div>
      <?php endwhile; ?>
    </div>
  </section>
</main>
<?php get_footer(); ?>
