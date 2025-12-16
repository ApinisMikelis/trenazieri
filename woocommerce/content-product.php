<?php
	/**
	 * The template for displaying product content within loops
	 *
	 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
	 *
	 * HOWEVER, on occasion WooCommerce will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * the readme will list any important changes.
	 *
	 * @see     https://woocommerce.com/document/template-structure/
	 * @package WooCommerce\Templates
	 * @version 9.4.0
	 */
	
	defined( 'ABSPATH' ) || exit;
	
	global $product;
	
	// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
	if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
		return;
	}

    $shipping_class_id = $product->get_shipping_class_id();
  
    $in_shop = false;
    if('in_showroom' === $product->get_meta( '_stock_status' )):
        $in_shop = true;
    endif;

    $is_private = false;
    
    if ( 'private' === $product->get_status() ) {
        if ( current_user_can( 'manage_options' ) || current_user_can( 'edit_pages' ) ) {
            $is_private = true;
        }
    }
?>
<div <?php wc_product_class( '', $product ); ?>>
	<?php
		echo '<a href="' . esc_url( get_permalink( $product->get_id() ) ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link '.($is_private ? 'private' : '').'">';
    ?>
    <div class="top-bar">
	    <?php if ( $product->is_on_sale() ) : ?>
            <div class="tag">
			    <?php
				    if ( $product->is_type( 'variable' ) ) {
					    $regular_price_min = $product->get_variation_regular_price( 'min' );
					    $regular_price_max = $product->get_variation_regular_price( 'max' );
					    $sale_price_min    = $product->get_variation_sale_price( 'min' );
					    $sale_price_max    = $product->get_variation_sale_price( 'max' );
					    
					    $discount_min = round( ( ( $regular_price_min - $sale_price_min ) / $regular_price_min ) * 100 );
					    $discount_max = round( ( ( $regular_price_max - $sale_price_max ) / $regular_price_max ) * 100 );
					    
					    if ( $discount_min === $discount_max || $discount_max <= $discount_min ) {
						    echo '-' . $discount_min . '%';
					    } else {
						    echo '-' . $discount_min . '% - ' . $discount_max . '%';
					    }
				    } else {
					    $regular_price       = $product->get_regular_price();
					    $sale_price          = $product->get_sale_price();
					    $discount_percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
					    echo '-' . $discount_percentage . '%';
				    }
			    ?>
            </div>
	    <?php endif; ?>
        <div class="brand">
		    <?php
			    $brand = $product->get_attribute( 'brends' );
			    if ( $brand ) {
				    $term = get_term_by( 'slug', $brand, 'pa_brends' );
				    if ( $term ) {
					    $brand_logo = get_field( 'brand_logo', $term );
					    if ( $brand_logo ):?>
                            <img srcset="<?php echo born_acf_image($brand_logo,'brand-logo-small',false);?> 2x" alt="<?php echo born_img_alt($brand_logo);?>">
					    <?php endif;
				    }
			    }
		    ?>
        </div>

        <?php if ( empty($shipping_class_id) && is_user_logged_in() ): ?>
          <p class="no-shipping-class-notice" style="color:red; font-weight:bold;">
            <img src="https://www.omniva.lv/wp-content/themes/omniva/assets/dist/assets/img/logo/logo-sign.svg" width="25" height="25">
          </p>
        <?php endif; ?>
    
    </div>

    <div class="tre-product-img-wrap">
        <div>
            <?php echo woocommerce_template_loop_product_thumbnail();?>
        </div>
    </div>

    <h2 class="woocommerce-loop-product__title">
        <?php if($in_shop):?>
            <div class="tags">
                <span><?php echo born_translation('in_showroom');?></span>
            </div>
        <?php endif;?>

        <span><?php echo $product->get_title();?></span>
    </h2>
    <?php 
		  woocommerce_template_loop_rating();
      woocommerce_template_loop_price();
    ?>
	<?php if ( $product->is_in_stock() || $product->is_on_backorder() ): ?>
        <div class="stock">
        <span>
            <?php
                if ( $product->is_on_backorder() ) {
                    echo born_translation('on_backorder');
                } elseif ( $product->is_in_stock() ) {
                    echo born_translation('in_stock');
                }
            ?>
        </span>
        </div>
	<?php endif; ?>
        <?php
		
		woocommerce_template_loop_product_link_close();		
	?>

  <?php if (is_user_logged_in()) :
    $tags = get_the_terms($product->get_id(), 'product_tag');
    if ($tags && !is_wp_error($tags)) :
        ?>
        <div class="admin-product-tags">
            <?php foreach ($tags as $tag) : ?>
                <span class="tag">
                    <a href="<?php echo esc_url(get_term_link($tag)); ?>">
                        <?php echo esc_html($tag->name); ?>,
                    </a>
                </span>
            <?php endforeach; ?>
        </div>

    <?php
      $post_id = $product->get_id();

      // Pull Yoast's stored link counts
      $internal_links = (int) get_post_meta($post_id, '_yoast_wpseo_internal_links_count', true);
      $external_links = (int) get_post_meta($post_id, '_yoast_wpseo_outbound_links_count', true);
      // Note: Some Yoast versions use slightly different keys — fallback if needed
      if ($internal_links === 0) {
          $internal_links = (int) get_post_meta($post_id, '_yoast_wpseo_linkdex_internal_links_count', true);
      }
      if ($external_links === 0) {
          $external_links = (int) get_post_meta($post_id, '_yoast_wpseo_linkdex_outbound_links_count', true);
      }
  
      if ($internal_links > 0 || $external_links > 0) :
      ?>
          <div class="admin-link-info" style="font-size:11px; color:#666; margin:6px 0; font-style:italic;">
              Links: 
              <?php if ($internal_links > 0) : ?>
                  <strong>Internal: <?php echo $internal_links; ?></strong>
              <?php endif; ?>
              <?php if ($internal_links > 0 && $external_links > 0) echo ' | '; ?>
              <?php if ($external_links > 0) : ?>
                  <strong>External: <?php echo $external_links; ?></strong>
              <?php endif; ?>
          </div>
      <?php endif; ?>
      
    <?php endif; ?>

  <?php endif; ?>
</div>
