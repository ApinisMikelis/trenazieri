<?php if (!defined('WPINC')) die; ?>

<?php
	$items = get_field('items');
    $dark_background = get_field('dark_background');
	$title = get_field('title');
?>


<div class="tre-products-slider <?php if ($dark_background):?>is-dark<?php endif;?>">
    <div class="tre-container">
        <div class="inner">

            <?php if ($title):?>
                <h2><?php echo $title;?></h2>
            <?php endif;?>

            <div class="tre-products-wrapper">

                <div class="woocommerce">

                    <div class="products slider">
	                    
	                    <?php if ( $items && is_array( $items ) ) : ?>
		                    <?php foreach ( $items as $product_id ) : ?>
			                    <?php
			                    $product = wc_get_product( $product_id );
			                    if ( $product ) :
				                    $post_object = get_post( $product->get_id() );
				                    setup_postdata( $post_object );
				                    ?>
                                    <div class="slider-item">
                                        <div class="inner">
						                    <?php
							                    // Use WooCommerce product loop template part
							                    wc_get_template_part( 'content', 'product' );
						                    ?>
                                        </div>
                                    </div>
				                    <?php
				                    wp_reset_postdata();
			                    endif;
			                    ?>
		                    <?php endforeach; ?>
	                    <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

