<?php

get_header();


$archive_permalink = born_get_archive_permalink('news');

if (has_post_thumbnail( get_the_ID() ) ) {
	$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'blog-single');
	$image_id = get_post_thumbnail_id();

	$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
}else{
	$image = false;
}

?>




<div class="tre-page-title">
    <div class="tre-container">
        <div class="inner">
            <div class="tre-breadcrumbs">
                <a href="<?php echo get_home_url();?>" class="home">Home</a>
                <a href="<?php echo $archive_permalink;?>"><?php echo born_translation('news_archive_title');?></a>
                <span><?php the_title();?></span>
            </div>
            <h1><?php the_title();?></h1>
        </div>
    </div>
</div>
    
<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	}
?>


    <div class="tre-blog-grid is-dark">
        <div class="tre-container">
            <div class="inner">

                <h2><?php echo born_translation('related_news');?></h2>

                <div class="items-grid">
		            
		            <?php
			            $args  = array(
				            'post_type'      => 'news',
				            'posts_per_page' => 2,
				            'post__not_in'   => array( get_the_ID() ),
			            );
			            $posts = new WP_Query( $args );
			            
			            while ( $posts->have_posts() ) : $posts->the_post();
				            if ( has_post_thumbnail() ) {
					            $image     = wp_get_attachment_image_src( get_post_thumbnail_id(), 'blog' );
					            $image_x2  = wp_get_attachment_image_src( get_post_thumbnail_id(), 'blog-x2' );
					            $image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
				            } else {
					            $image = false;
				            }
				            $description = get_field( 'short_description' );
				            ?>

                            <div class="item">
					            <?php if ( $image ): ?>
                                    <div class="image">
                                        <a href="<?php echo get_the_permalink(); ?>"><img
                                                    srcset="<?php echo $image[0]; ?>, <?php echo $image_x2[0]; ?>?v=2 2x"
                                                    alt="<?php echo $image_alt; ?>"></a>
                                    </div>
					            <?php endif; ?>
                                <div class="heading">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                </div>
					            <?php if ( $description ): ?>
                                    <div class="desc">
							            <?php echo $description; ?>
                                    </div>
					            <?php endif; ?>
                                <div class="cta">
                                    <a href="<?php echo get_the_permalink(); ?>"><?php echo born_translation( 'read_more' ); ?></a>
                                </div>
                            </div>
			            
			            <?php endwhile;
			            wp_reset_postdata(); ?>

                </div>

            </div>
        </div>
    </div>


	<?php
		get_footer();
	?>