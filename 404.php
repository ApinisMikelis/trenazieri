<?php
	
	wp_head();
	

    $yt_url = get_field('404_youtube_url','options');
    $yt_id = born_extract_youtube_id($yt_url);
?>

<body class="is-404">

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
                <a href="<?php echo get_home_url();?>"><img width="140" src="<?php echo get_template_directory_uri();?>/assets/img/logo-trenazieri-1.svg" alt="Trenažieri.lv"></a>
            </div>

            <div class="search">
                <button class="icon">Search</button>
                <div class="dropdown" style="opacity: 0; visibility: hidden; pointer-events: none;">
                    <form>
                        <button class="is-close">Close</button>
                        <div class="input-wrapper">
                            <input type="text">
                        </div>
                    </form>
                </div>
            </div>

            <div class="cart">
                <button class="icon">0</button>
            </div>

        </div>
    </header>

    <header class="tre-header">
        <div class="inner">

            <div class="top-bar">
                <div class="tre-container">
                    <div class="inner">

                        <div class="logo">
                            <a href="<?php echo get_home_url();?>"><img src="<?php echo get_template_directory_uri();?>/assets/img/logo-trenazieri-1.svg" alt="Trenažieri.lv"></a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </header>

    <main class="tre-main">
        <div class="inner">


<div class="tre-404">

    <div class="tre-container">
        <div class="inner">

            <div class="left">
                <h1>404</h1>
                <p><?php echo born_translation('404_title');?></p>
                <div class="cta">
                    <a href="<?php echo get_home_url();?>" class="tre-button-2"><?php echo get_the_title(get_option('page_on_front'));?></a>
                </div>
            </div>

        </div>
    </div>

    <?php if ($yt_id):?>
    
    <div class="bg">
        <iframe src="https://www.youtube.com/embed/<?php echo $yt_id;?>?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1&rel=0&iv_load_policy=3&fs=0&disablekb=1&loop=1&playlist=LSHZFSYCRM4" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
    <?php endif;?>

</div>


        </div>
    </main>

</div>
<?php wp_footer(); ?>