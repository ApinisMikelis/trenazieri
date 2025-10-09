<?php if (!defined('WPINC')) die; ?>

<?php
	// Retrieve the repeater field data
	$title = get_field('title');
	$items = get_field('items');

    $archive_slug = get_field('portfolio_slug_'.born_get_current_language_code(),'options')
?>

<div class="tre-shortcuts">
	
	<div class="tre-container">
		<div class="inner">
			
            <?php if ($title) : ?>
			<h2><?php echo $title;?></h2>
			<?php endif; ?>
			<div class="items-grid">
				
                <?php foreach ($items as $item_id): ?>
                <?php
                $image = get_the_post_thumbnail_url( $item_id, 'portfolio' );
                $image_x2 = get_the_post_thumbnail_url( $item_id, 'portfolio-x2' );
                ?>
				<a href="<?php echo get_the_permalink($item_id);?>" class="item">
					<span><?php echo get_the_title($item_id);?></span>
                    <img class="lazy"
                         src="<?php echo $image;?>"
                         data-srcset="<?php echo $image;?>, <?php echo $image_x2;?>?v=2 2x"
                         alt="<?php echo get_the_title(); ?>">
				</a>
                <?php endforeach; ?>
			
			</div>
			
			<div class="cta">
				<a href="<?php echo get_home_url() . '/' .$archive_slug;?>" class="tre-button-1"><?php echo born_translation('learn_more');?></a>
			</div>
		
		</div>
	</div>
	
	<div class="bg lazy" data-bg="<?php echo get_template_directory_uri();?>/assets/tmp/bg-1.jpg"></div>

</div>
