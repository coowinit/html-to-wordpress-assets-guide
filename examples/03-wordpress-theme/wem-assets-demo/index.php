<?php get_header(); ?>
<main class="site-main">
  <section class="section">
    <div class="container">
      <h1 class="page-title">
        文章
      </h1>
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article class="card">
        <h2>
          <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
          </a>
        </h2>
        <?php the_excerpt(); ?>
      </article>
      <?php endwhile; else : ?>
      <p>
        暂无内容。
      </p>
      <?php endif; ?>
    </div>
  </section>
</main>
<?php get_footer(); ?>
