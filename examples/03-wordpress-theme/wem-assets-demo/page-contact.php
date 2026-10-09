<?php /* Template Name: WEM Contact Demo */ get_header(); ?>
<main class="site-main">
  <section class="section">
    <div class="container">
      <h1 class="page-title">
        <?php the_title(); ?>
      </h1>
      <form class="contact-form" data-contact-form="">
        <label>
          称呼
          <input name="name" required=""/>
        </label>
        <label>
          留言
          <textarea name="message" required=""></textarea>
        </label>
        <button class="site-button" type="submit">
          本地验证
        </button>
        <p data-form-status="" role="status">
        </p>
      </form>
    </div>
  </section>
</main>
<?php get_footer(); ?>
