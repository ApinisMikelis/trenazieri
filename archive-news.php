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
?>




    <div class="tre-page-title">
        <div class="tre-container">
            <div class="inner">
                <h1><?php echo born_translation('news_archive_title');?></h1>
            </div>
        </div>
    </div>

    <div class="tre-blog-grid">
        <div class="tre-container">
            <div class="inner">

                <div class="items-grid">
	
	
	                <?php while ($posts->have_posts()) : $posts->the_post(); ?>
		                <?php
		                if (has_post_thumbnail() ) {
			                $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog');
			                $image_x2 = wp_get_attachment_image_src(get_post_thumbnail_id(), 'blog-x2');
                            $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
		                }else{
			                $image = false;
		                }
		                $description = get_field('short_description');
		                ?>


                        <div class="item">
	                        <?php if ($image):?>
                            <div class="image">
                                <a href="<?php echo get_the_permalink();?>"><img srcset="<?php echo $image[0];?>, <?php echo $image_x2[0];?>?v=2 2x" alt="<?php echo $image_alt;?>"></a>
                            </div>
	                         <?php endif;?>
                            <div class="heading">
                                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                            </div>
	                        <?php if ($description):?>
                               <div class="desc">
			                         <?php echo $description;?>
                               </div>
	                        <?php endif;?>
                            <div class="cta">
                                <a href="<?php echo get_the_permalink();?>"><?php echo born_translation('read_more');?></a>
                            </div>
                        </div>
                       
	                <?php endwhile; ?>
                 

                 


                </div>

            </div>
        </div>
    </div>


<?php if ($pagination):?>

    <div class="tre-pagination">
        <div class="tre-container">
            <div class="inner">
                <ul class="tre-reset">
	                <?php echo $pagination;?>
                </ul>
            </div>
        </div>
    </div>

<?php endif;?>


<?php get_footer();?>