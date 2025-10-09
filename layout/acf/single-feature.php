<?php if (!defined('WPINC')) die; ?>

<?php
	// Fetch ACF fields
	$title              = get_field('title');
	$text               = get_field('text');
	$button             = get_field('button');
	$image              = get_field('image');
	$image_to_the_right = get_field('image_to_the_right');
	
	// Determine whether to add a "reversed" class
	$reversed_class = $image_to_the_right ? ' is-reversed' : '';
?>

<div class="tre-feature-block <?php echo esc_attr($reversed_class); ?>">
	<div class="tre-container">
		<div class="inner">
			
			<?php if ($image): ?>
				<div class="image">
					<img class="lazy" src="<?php echo born_acf_image($image, 'feature-block-x2', false); ?>" data-srcset="<?php echo born_acf_image($image, 'feature-block', false); ?>, <?php echo born_acf_image($image, 'feature-block-x2', false); ?>?v=2 2x" alt="<?php echo born_img_alt($image);?>">
				</div>
			<?php endif; ?>
			
			<div class="title">
				<?php if ($title): ?>
					<h2><?php echo esc_html($title); ?></h2>
				<?php endif; ?>
				
				<?php if ($text): ?>
					<div class="desc">
						<?php echo wp_kses_post($text); ?>
					</div>
				<?php endif; ?>
				
				<?php if ($button): ?>
					<div class="cta">
						<a <?php echo born_acf_link($button); ?> class="tre-button-2">
							<?php echo esc_html($button['title']); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		
		</div>
	</div>
</div>
