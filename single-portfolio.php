<?php

get_header();


$archive_permalink = born_get_archive_permalink('portfolio');


$sidebar_desc = get_field('sidebar_description');
$specification = get_field('specification');
$gallery = get_field('gallery');
?>







    <div class="tre-portfolio-item">
        <div class="tre-container">

            <div class="tre-breadcrumbs">
                <a href="<?php echo get_home_url();?>" class="home">Home</a>
                <a href="<?php echo $archive_permalink;?>"><?php echo born_translation('portfolio_archive_title');?></a>
                <span><?php the_title();?></span>
            </div>

            <div class="inner">

                <div class="content">
                    <?php if ($gallery):?>
    
                        <?php foreach ($gallery as $image):?>
                            <div class="photo">
                                <img class="lazy" src="<?php echo born_acf_image($image,'portfolio-x2',false);?>" data-srcset="<?php echo born_acf_image($image,'portfolio-x2',false);?>" alt="<?php the_title();?>">
                            </div>
                        <?php endforeach;?>
                        
                    <?php endif;?>
                </div>

                <div class="sidebar">

                    <h1><?php the_title();?></h1>
	                
	                <?php if ( ! empty( $sidebar_desc ) ) : ?>
                    <div class="desc">
                        <?php echo $sidebar_desc; ?>
                    </div>
	                <?php endif; ?>

                    <?php if ($specification):?>
                    <div class="tre-description-table">
                        <div class="tre-container">
                            <div class="inner">

                                <table>
                                    <?php foreach ($specification as $spec):?>
                                        <tr>
                                            <td><?php echo $spec['title'];?></td>
                                            <td><?php echo $spec['text'];?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </table>

                            </div>
                        </div>
                    </div>
                    <?php endif;?>

                </div>

            </div>
	        
	        
         
        </div>
	    
	    
    </div>

<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	}
?>
    




	<?php
		get_footer();
	?>