<?php if (!defined('WPINC')) die; ?>

<?php
	// Retrieve the repeater field data
	
	$items = get_field('items');

?>

<?php foreach ($items as $item): ?>
<div class="facet-wrap <?php if ($item['is_price_filter']):?>is-price<?php endif;?>" style="display: none;">
	<div class="title accordion-trigger"><?php echo $item['title'];?></div>
	<div class="accordion-content">
		<?php echo do_shortcode($item['shortcode']);?>
	</div>
</div>
<?php endforeach; ?>


