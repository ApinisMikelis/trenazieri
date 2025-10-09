<?php if (!defined('WPINC')) die; ?>

<?php
	// Retrieve the repeater field data
	$title = get_field('title');
	$items = get_field('items');

?>


<div class="tre-legal">
	<div class="tre-container">
		<div class="inner">
			
            <?php if ($title):?>
			<h2><?php echo $title;?></h2>
            <?php endif;?>
			
			<table>
				<tbody>
                
                <?php foreach ($items as $item):?>
                    <tr>
                        <td><?php echo $item['title'];?></td>
                        <td><?php echo $item['text'];?></td>
                    </tr>
                <?php endforeach;?>
           
				</tbody></table>
		
		</div>
	</div>
</div>

