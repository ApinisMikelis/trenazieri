<?php get_header();?>

<?php
global $BORN_FRAMEWORK;
global $wp_query;
$paged = (get_query_var('page')) ? get_query_var('page') : 1;
$lang_code = born_get_current_language_code();


$args = array(
	'post_type'      => 'news',
	'post_status'    => 'publish',
	'suppress_filters' => false,
	'paged'          => $paged,
	'posts_per_page' => get_option( 'posts_per_page' ),
);

$posts = new WP_Query($args);


$pagination = born_get_archive_pagination('news',0, $paged, $posts->max_num_pages, get_home_url() .'/'. get_field('news_slug_'.$lang_code, 'options'));

$portfolio_content = get_field('portfolio_archive_content','options');
?>




    <div class="tre-page-title">
        <div class="tre-container">
            <div class="inner">
                <h1><?php echo born_translation('portfolio_archive_title');?></h1>
            </div>
        </div>
    </div>


    <?php if ($portfolio_content):?>
	<?php
    foreach ($portfolio_content as $key => $id) {
	    echo apply_filters( 'the_content', get_post_field( 'post_content', $id ) );
    }
	
	?>
    <?php endif;?>
    


    <div class="tre-shortcuts">

        <div class="tre-container">
            <div class="inner">

                <h2><?php echo born_translation('portfolio_projects_title');?></h2>

                <div class="items-grid">
		            <?php
			            $portfolio_args  = array(
				            'post_type'      => 'portfolio',
				            'post_status'    => 'publish',
				            'posts_per_page' => - 1,
			            );
			            $portfolio_query = new WP_Query( $portfolio_args );
			            
			            if ( $portfolio_query->have_posts() ) :
				            while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
					            $image = get_the_post_thumbnail_url( get_the_ID(), 'portfolio' );
					            $image_x2 = get_the_post_thumbnail_url( get_the_ID(), 'portfolio-x2' );
					            ?>
                                <a href="<?php the_permalink(); ?>" class="item">
                                    <span><?php the_title(); ?></span>
                                    <?php if ($image):?>
                                    <img class="lazy"
                                         src="<?php echo $image;?>"
                                         data-srcset="<?php echo $image;?>, <?php echo $image_x2;?>?v=2 2x"
                                         alt="<?php echo get_the_title(); ?>">
                                    <?php endif;?>
                                </a>
				            <?php
				            endwhile;
				            wp_reset_postdata();
			            endif;
		            ?>
                </div>
                

            </div>
        </div>

        <div class="bg lazy" data-bg="<?php echo get_template_directory_uri();?>/assets/tmp/bg-1.jpg"></div>

    </div>

<?php get_footer();?>