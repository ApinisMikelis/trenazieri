<?php if (!get_field('hide_page_title')):?>
<div class="tre-page-title">
    <div class="tre-container">
        <div class="inner">
	        <?php if (is_order_received_page()):?>
                <h1><?php echo born_translation('thank_you_page_title');?></h1>
		        <?php if (born_translation('thank_you_page_description')):?>
                    <div class="desc">
				        <?php echo born_translation('thank_you_page_description');?>
                    </div>
		        <?php endif;?>
	        <?php else:?>
                <h1><?php the_title();?></h1>
	        <?php endif;?>
        </div>
    </div>
</div>
<?php endif;?>