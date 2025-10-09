<?php if (!defined('WPINC')) die; ?>

<?php
	$items = get_field('items'); // Get the title field
	$has_more = false;
?>


<div class="tre-brands-slider" style="opacity: 0; visibility: hidden; pointer-events: none;">
    <div class="tre-container">
        <div class="inner">

            <div class="slider">

                <div class="slider-item">
	                <?php foreach ($items as $index => $item):?>
                        <?php if ($index == 6){
                            $has_more = true;
                            break;
                        }?>
                        <a <?php echo born_acf_link($item['link']);?>><img srcset="<?php echo born_acf_image( $item['image'], 'brand-slider', false);?>?v=2 2x" alt="<?php echo born_img_alt($item['image']);?>"></a>
	                <?php endforeach;?>
                </div>

                <?php if ($has_more):?>
                <div class="slider-item">
	                <?php foreach ($items as $index => $term_id):?>
		                <?php if ($index < 6){
			                continue;
		                }?>
                        <a <?php echo born_acf_link($item['link']);?>><img srcset="<?php echo born_acf_image( $item['image'], 'brand-slider', false);?>?v=2 2x" alt="<?php echo born_img_alt($item['image']);?>"></a>
	                <?php endforeach;?>
                </div>
                <?php endif;?>

            </div>

        </div>
    </div>
</div>


