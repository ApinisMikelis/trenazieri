<?php if (!defined('WPINC')) die; ?>

<?php
	$items = get_field('items'); // Get the title field
	$background_image = get_field('background_image');
?>

<?php if (!empty($items)):?>
<div class="tre-container">
	<div class="inner">
		
		<div class="submenu">
			<ul class="tre-reset">
				
				
				<?php foreach ($items as $item):?>
					<li>
						<a href="<?php echo get_term_link($item['mega_category']);?>">
       
							<span class="icon">
								<span>
                                    <?php if(get_term_meta( $item['mega_category'], 'thumbnail_id', true )):?>
									<img srcset="<?php echo born_acf_image( get_term_meta( $item['mega_category'], 'thumbnail_id', true ), 'mega-thumb', false);?> 2x" alt="<?php echo get_term( $item['mega_category'] )->name;?>">
                                    <?php endif;?>
								</span>
							</span>
       
							<span class="title"><?php echo get_term( $item['mega_category'] )->name;?></span>
						</a>
					</li>
				<?php endforeach;?>
	
			</ul>
		</div>
		
        <?php if($background_image):?>
		<div class="deco">
			<img srcset="<?php echo born_acf_image($background_image,'mega-banner',false);?>, <?php echo born_acf_image($background_image,'mega-banner-x2',false);?>?v=2 2x" alt="<?php echo born_img_alt($background_image);?>">
		</div>
        <?php endif;?>
	
	</div>
</div>
<?php endif;?>
