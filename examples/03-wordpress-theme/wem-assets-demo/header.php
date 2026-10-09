<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class="site-header">
    <div class="container site-header__inner">
      <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">WEM Demo</a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-nav">菜单</button>
      <nav id="site-nav" class="site-nav" aria-label="主导航">
        <a href="<?php echo esc_url(home_url('/')); ?>">首页</a>
        <a href="<?php echo esc_url(home_url('/about/')); ?>">关于</a>
        <a href="<?php echo esc_url(home_url('/products/')); ?>">产品</a>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>">联系</a>
      </nav>
    </div>
  </header>
