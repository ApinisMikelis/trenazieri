<?php
	/**
	 * Grouped product add to cart
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
	 *
	 * HOWEVER, on occasion WooCommerce will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * the readme will list any important changes.
	 *
	 * @see     https://woocommerce.com/document/template-structure/
	 * @package WooCommerce\Templates
	 * @version 7.0.1
	 */
	
	defined( 'ABSPATH' ) || exit;
	
	global $product, $post;
	
	do_action( 'woocommerce_before_add_to_cart_form' ); ?>


<div class="tre-product-variations">



    <form class="cart grouped_form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
        <!--<table cellspacing="0" class="woocommerce-grouped-product-list group_table">
			<tbody>-->
		
		<?php
			$quantites_required      = false;
			$previous_post           = $post;
			$grouped_product_columns = apply_filters(
				'woocommerce_grouped_product_columns',
				array(
					'checkbox',
					'image',
					'label',
					'price',
					'quantity',
				),
				$product
			);
			$show_add_to_cart_button = false;
			
			
			
			do_action( 'woocommerce_grouped_product_list_before', $grouped_product_columns, $quantites_required, $product );
			
			foreach ( $grouped_products as $grouped_product_child ) {
				$post_object        = get_post( $grouped_product_child->get_id() );
				$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );
				$post               = $post_object; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				setup_postdata( $post );
    
				?>
				
				<?php
				
				
				
				
				if ( $grouped_product_child->is_in_stock() ) {
					$show_add_to_cart_button = true;
				}
				
				//echo '<tr id="product-' . esc_attr( $grouped_product_child->get_id() ) . '" class="woocommerce-grouped-product-list-item ' . esc_attr( implode( ' ', wc_get_product_class( '', $grouped_product_child ) ) ) . '">';
				
				echo '<div class="item '.$grouped_product_child->get_meta( '_stock_status' ).'"><div class="data">';
				
				// Output columns for each product.
				foreach ( $grouped_product_columns as $column_id ) {
					// Initialize $value to ensure no accumulation from previous iterations
					$value = '';
					
					switch ( $column_id ) {
						case 'checkbox':
							$value = '<div class="input">';
							$value .= '<input type="checkbox" id="quant-cb-'.$grouped_product_child->get_id().'" name="' . esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox" id="' . esc_attr( 'quantity-' . $grouped_product_child->get_id() ) . '" />';
							$value .= '<label for="quant-cb-'.$grouped_product_child->get_id().'"></label></div>';
							break;
						case 'image':
							$thumbnail_id = $grouped_product_child->get_image_id();
							if ($thumbnail_id) {
								$value = '<div class="image"><img src="'.wp_get_attachment_image_src($thumbnail_id,'grouped-img')[0].'" alt="'.$grouped_product_child->get_name().'"></div>';
							} else {
								$value = '<div class="image"><img src="'.wc_placeholder_img_src().'" alt="'.$grouped_product_child->get_name().'"></div>';
							}
							break;
						case 'quantity':
							// Start capturing the output buffer for quantity input
							ob_start();
							
							if ( ! $grouped_product_child->is_purchasable() || $grouped_product_child->has_options() || ! $grouped_product_child->is_in_stock() ) {
								woocommerce_template_loop_add_to_cart();
							} elseif ( $grouped_product_child->is_sold_individually() ) {
								echo '<input type="checkbox" name="' . esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox" id="' . esc_attr( 'quantity-' . $grouped_product_child->get_id() ) . '" />';
								echo '<label for="' . esc_attr( 'quantity-' . $grouped_product_child->get_id() ) . '" class="screen-reader-text">' . esc_html__( 'Buy one of this item', 'woocommerce' ) . '</label>';
							} else {
								//do_action( 'woocommerce_before_add_to_cart_quantity' );
								
								woocommerce_quantity_input(
									array(
										'input_name'  => 'quantity[' . $grouped_product_child->get_id() . ']',
										'input_value' => isset( $_POST['quantity'][ $grouped_product_child->get_id() ] )
											? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ) )
											: 1, // Set default value to 1
										'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product_child ),
										'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product_child->get_max_purchase_quantity(), $grouped_product_child ),
										'placeholder' => '1', // Optional, for visual indication
									)
								);
								
								//do_action( 'woocommerce_after_add_to_cart_quantity' );
							}
							
							$value = '<div class="tre-quantity">' . ob_get_clean();
							$value .= '</div>';
							break;
						case 'label':
							//$value  = '<label for="product-' . esc_attr( $grouped_product_child->get_id() ) . '">';
							//$value .= $grouped_product_child->is_visible() ? $grouped_product_child->get_name() : $grouped_product_child->get_name();
							//$value .= '</label>';
							$value  = '<div class="title">';
							
							if (get_field('grouped_product_title',$grouped_product_child->get_id())){
								$title = get_field('grouped_product_title',$grouped_product_child->get_id());
							}else{
								$title = $grouped_product_child->get_name();
							}
							
							$value .= '<a href="'.get_the_permalink($grouped_product_child->ID).'">'.$title.'</a>';
							$value  .= '<div class="cost">';
							$value  .= $grouped_product_child->get_price_html() . wc_get_stock_html( $grouped_product_child );
							$value  .= '</div>';
                            //$value  .= display_stock_status($grouped_product_child);
                            
                            $value .= '<div class="stock"><span>'.born_translation('in_stock').'</span></div>';
							
							$value .= '</div>';
							break;
						//case 'price':
							// Ensure this is the only place where price is set, not appended
							//$value  = '<div class="cost">';
							//$value  .= $grouped_product_child->get_price_html() . wc_get_stock_html( $grouped_product_child );
							//$value  .= '</div>';
							//$value = $grouped_product_child->get_price_html() . wc_get_stock_html( $grouped_product_child );
							break;
						default:
							$value = '';
							break;
					}
					
					// Output the column value
					echo $value;
				}
				
				echo '</div>';
				if (get_field('delivery_time_text',$grouped_product_child->get_id())){echo '<div class="notes">'.get_field('delivery_time_text',$grouped_product_child->get_id()).'</div>';}
				echo '</div>';
				
				
				//echo '</tr>';
			}
			$post = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			setup_postdata( $post );
			
			do_action( 'woocommerce_grouped_product_list_after', $grouped_product_columns, $quantites_required, $product );
		
		
		?>
        <!--</tbody>
	</table>-->
        <div class="submit-wrapper">
        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
		
		<?php if ( $quantites_required && $show_add_to_cart_button ) : ?>
			
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
            
               
                    <button type="submit" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
                    <?php echo output_consultation_cta();?>
               
            
            
			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
        </div>
		<?php endif; ?>
    </form>

</div>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>


<script>

    // Product variation lightbox

    jQuery(document).ready(function() {
        jQuery('.ufloat-product-variations .data .title button.info').click(function(e) {
            e.preventDefault();

            console.log(jQuery(this).attr('data-popupid'),'aa');

            jQuery('body, html').css('overflow', 'hidden');
            jQuery('.lightbox-'+jQuery(this).attr('data-popupid')).addClass('is-visible');
            galleryResize();
        });

        jQuery('.ufloat-product-variations-lightbox .is-close').click(function(e) {
            e.preventDefault();
            jQuery('body, html').css('overflow', 'auto');
            jQuery('.ufloat-product-variations-lightbox').removeClass('is-visible');
            galleryResize();
        });

        jQuery(document).on('keydown', function(event) {
            if (event.key == "Escape") {
                jQuery('body, html').css('overflow', 'auto');
                jQuery('.ufloat-product-variations-lightbox').removeClass('is-visible');
                galleryResize();
            }
        });

    });

</script>


<script>
    jQuery(document).ready(function($) {
        // Function to handle adding multiple products to cart via AJAX
        function multiAddToCart(productsData) {

            $.ajax({
                url: wc_add_to_cart_params.ajax_url, // Use the WooCommerce AJAX URL
                type: 'POST',
                dataType: 'json',
                data: {
                    'action': 'multi_add_to_cart', // Custom AJAX action
                    'items': productsData // Pass the products data
                },
                success: function(response) {
                    // Check the response for success
                    if (response && response.length > 0) {
                        // Redirect the user to the cart page
                        window.location.href = wc_add_to_cart_params.cart_url; // Redirect to WooCommerce cart page
                    } else {
                        alert('Failed to add products to the cart.');
                    }
                },
                error: function(error) {
                    console.error('Error adding products to cart:', error);
                    alert('There was an error adding products to the cart. Please try again.');
                }
            });
        }

        // Handle click event for adding selected products
        $('.single_add_to_cart_button').on('click', function(e) {
            e.preventDefault(); // Prevent default button behavior

            var productsData = []; // Initialize products data array

            // Iterate over each product item
            $('.item').each(function() {
                const $item = $(this);
                const $checkbox = $item.find('.wc-grouped-product-add-to-cart-checkbox');
                const $quantityInput = $item.find('.qty');
                const quantity = parseInt($quantityInput.val(), 10);

                // Check if the checkbox is checked and quantity is greater than zero
                if ($checkbox.prop('checked') && quantity > 0) {
                    // Add this product to the list of products to add to cart
                    productsData.push({
                        id: $checkbox.attr('id').match(/\d+/)[0], // Extract product ID from checkbox id
                        qty: quantity
                    });
                }
            });

            // Check if any products are selected
            if (productsData.length > 0) {

                multiAddToCart(productsData); // Call the AJAX function
            } else {
                alert('<?php echo born_translation('grouped_product_select_error');?>');
            }
        });
    });
</script>
