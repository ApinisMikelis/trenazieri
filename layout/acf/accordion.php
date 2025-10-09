<?php if (!defined('WPINC')) die; ?>

<?php
	// Retrieve the repeater field data
	$main_title = get_field('main_title');
	$items = get_field('items');
    $is_dark = get_field('is_dark');
?>




<div class="tre-faq <?php if ($is_dark):?>is-dark<?php endif;?>">
    <div class="tre-container">
        <div class="inner">
	        
	        <?php if ($main_title):?>
                <h2><?php echo $main_title;?></h2>
	        <?php endif;?>
	        
	        
	        <?php foreach ($items as $item):?>

                <div class="tre-accordion">
                    <button class="accordion-trigger"><?php echo $item['title'];?></button>
                    <div class="accordion-content">
                        <div class="inner">
					        <?php echo $item['text'];?>
                        </div>
                    </div>
                </div>
	        
	        <?php endforeach;?>
    

        </div>
    </div>
</div>