<?php if (!defined('WPINC')) die; ?>

<?php
	// Retrieve the repeater field data

	$items = get_field('items');

?>


<div class="tre-contacts">
	<div class="tre-container">
		<div class="inner">
			
			<div class="items-grid">
				
                <?php foreach ($items as $item): ?>
                
				<div class="item">
					<div class="icon">
						<?php echo born_acf_image($item['icon'],'contacts-icon',true);?>
					</div>
					<div class="heading">
						<h2><?php echo $item['title'];?></h2>
					</div>
					<div class="data">
						<?php echo $item['text'];?>
					</div>
				</div>
                
                <?php endforeach; ?>
			
			</div>
		
		</div>
	</div>
</div>

