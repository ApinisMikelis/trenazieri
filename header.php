<?php if (!defined('ABSPATH')) exit; ?>

<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>

	<?php if (is_post_type_archive('news')):?>
       <title><?php echo born_translation('news_archive_title');?> - <?php echo get_bloginfo();?></title>
	<?php elseif(is_post_type_archive('certificates')):?>
       <title><?php echo born_translation('certificates_archive_title');?> - <?php echo get_bloginfo();?></title>
	<?php else:?>
       <title><?php wp_title();?></title>
	<?php endif;?>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=no">
    <meta name="theme-color" content="#000000">
    <link rel="shortcut icon" href="<?= BORN_IMAGES ?>favicon.ico">
    <link rel="preload" as="font" href="<?= BORN_FONT ?>HelveticaTrenazieri-Regular.woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="<?= BORN_FONT ?>HelveticaTrenazieri-Bold.woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="<?= BORN_FONT ?>Antonio-Regular.woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="<?= BORN_FONT ?>Antonio-SemiBold.woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="<?= BORN_FONT ?>HelveticaNeueLTProTrenazieri-Medium.woff2" crossorigin="anonymous">
    <link rel="preload" as="font" href="<?= BORN_FONT ?>HelveticaNeueLTProTrenazieri-Extended.woff2" crossorigin="anonymous">
    <link rel="preload" as="style" href="<?= BORN_CSS ?>app.min.css?ver=<?= BORN_VERSION ?>">
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17647817134"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'AW-17647817134');
    </script>

	<?php wp_head(); ?>
 
</head>

<?php

$body_class = '';

if(is_front_page()) {
  $body_class = 'home';
}

if(is_404()) {
  $body_class = 'is-404';
}

?>

<body <?php body_class($body_class); ?>>

<?php

$top_menu_left = born_render_menu([
	'theme_location' => 'top-menu-left',
	'depth' => 1,
	'items_wrap' => '<ul class="tre-reset">%3$s</ul>',
	'walker' => 'Born\Core\Walkers\Born_Main_Menu_Walker',
]);
	
$top_menu_right = born_render_menu([
    'theme_location' => 'top-menu-right',
    'depth' => 1,
    'items_wrap' => '<ul class="tre-reset">%3$s</ul>',
    'walker' => 'Born\Core\Walkers\Born_Main_Menu_Walker',
]);
	
$main_menu = born_render_menu([
    'theme_location' => 'main-menu',
    'depth' => 1,
    'items_wrap' => '<ul class="tre-reset">%3$s</ul>',
    'walker' => 'Born\Core\Walkers\Born_Main_Menu_Walker',
]);

$main_menu_mobile = born_render_menu([
    'theme_location' => 'main-menu-mobile',
    'depth' => 3,
    'items_wrap' => '<ul class="slinky-list">%3$s</ul>',
    'walker' => new Slinky_Walker_Nav_Menu(),
]);

$current_language = apply_filters('wpml_current_language', null);
$languages = apply_filters('wpml_active_languages', []);
$born_phone = get_field('born_phone', 'option');
$video = get_field('header_video','options');
$header_type = get_field('header_type');
$placeholder_image = get_field('header_video_placeholder','options');
$lang_switcher = born_get_language_switcher(false);
$lang_switcher_popup = born_get_language_switcher_popup(false);
$language_switcher_items = get_field('language_switcher_items','options');

if (is_404()){
	$header_type = 'advanced';
}

?>

<div class="tre-menu-mobile" style="transform: translateX(-100%); opacity: 0;">
  <div class="inner">
    <div class="menu">
      <?php echo $main_menu_mobile;?>
    </div>
    <div class="top-bar">
      <div class="menu">
        <?php echo $top_menu_left;?>
      </div>
      <div class="menu">
        <?php echo $top_menu_right;?>
      </div>
    </div>
  </div>
</div>

<div class="tre-page-wrapper">
  <header class="tre-header-mobile">
    <div class="inner">
      <button class="tre-mobile-menu-trigger">
        Menu
        <span></span>
        <span></span>
        <span></span>
      </button>

      <div class="logo">
        <a href="<?php echo get_home_url();?>">
          <img width="140" src="<?php echo BORN_IMG;?>logo-trenazieri-1.svg" alt="Trenažieri.lv">
        </a>
      </div>

      <div class="search">
        <button class="icon">Search</button>
        <div class="dropdown" style="opacity: 0; visibility: hidden; pointer-events: none;">
          <?php aws_get_search_form( true ); ?>
        </div>
      </div>

      <a href="<?php echo wc_get_cart_url();?>" class="cart">
        <button class="icon"><?php echo WC()->cart->get_cart_contents_count();?></button>
      </a>
    </div>
  </header>

  <header class="tre-header">
    <div class="inner">
      <div class="top-bar">
        <div class="tre-container">
          <div class="inner">

            <div class="logo">
              <a href="<?php echo get_home_url();?>">
                <img src="<?php echo BORN_IMG;?>logo-trenazieri-1.svg" alt="Trenažieri.lv">
              </a>
            </div>

            <?php if ($top_menu_left):?>
              <div class="menu">
                <?php echo $top_menu_left;?>
              </div>
            <?php endif;?>
          
            <?php if ($top_menu_right):?>
              <div class="menu">
                <?php echo $top_menu_right;?>
              </div>
            <?php endif;?>

            <div class="cta">
              <div class="lang">
                <ul class="tre-reset">
                  <?php echo $lang_switcher;?>
                </ul>
              </div>
              <div class="search">
                <button class="icon">Search</button>
                <div class="dropdown" style="opacity: 0; visibility: hidden; pointer-events: none;">
                  <?php aws_get_search_form( true ); ?>
                </div>
              </div>
              <a href="<?php echo wc_get_cart_url();?>" class="cart">
                  <button class="icon"><?php echo WC()->cart->get_cart_contents_count();?></button>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="menu">
          <div class="tre-container">
              <div class="inner">

                  <?php echo $main_menu;?>

              </div>

          </div>
      </div>
    </div>
  </header>

  <main class="tre-main">
      <div class="inner">