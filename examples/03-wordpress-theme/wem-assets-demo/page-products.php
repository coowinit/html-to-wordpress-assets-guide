<?php /* Template Name: WEM Products Demo */ get_header(); ?>
<main class="site-main">
  <section class="section">
    <div class="container">
      <h1 class="page-title">
        <?php the_title(); ?>
      </h1>
      <p class="products-note">
        产品页面专属资源。
      </p>
      <button aria-pressed="true" class="site-button" data-filter="all" type="button">
        全部
      </button>
      <button aria-pressed="false" class="site-button" data-filter="decking" type="button">
        地板
      </button>
      <button aria-pressed="false" class="site-button" data-filter="cladding" type="button">
        墙板
      </button>
      <div class="card-grid" data-product-grid="">
        <article class="card" data-category="decking">
          <h2>
            Decking A
          </h2>
        </article>
        <article class="card" data-category="cladding">
          <h2>
            Cladding B
          </h2>
        </article>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
