<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
	
	// Get the current category ID;
	$tag_id = get_queried_object_id();
	
	// Get the meta data using the ID;
	$term_vals = get_term_meta( $tag_id );
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
//do_action( 'woocommerce_before_main_content' );
	
	//WC_Structured_Data::generate_website_data();

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action( 'woocommerce_shop_loop_header' );
	



?>
<?php if ( $term_vals[ 'display_type' ][ 0 ] != 'subcategories'  && !is_shop()):?>
    <div class="tre-products">
    <div class="tre-container">
    <div class="inner">
    
    <div class="filters">

     
            <?php woocommerce_breadcrumb();?>
 

        <div class="sorting">
        

        <?php echo do_shortcode('[facetwp facet="kartosana"]');?>

        </div>

    </div>

    <div class="sidebar">

        <button class="filters-trigger"><span>Filtrēt</span></button>

        <style>
            .tre-products .sidebar .facet-wrap .facetwp-slider-label:after {
                content: "€";
                margin-left: 8px;
            }
        </style>

        <div class="filters-wrapper">

            <button class="is-close">Hide filters</button>
            
            <?php
	            if ( is_active_sidebar( 'tags-sidebar' ) ) {
		            dynamic_sidebar( 'tags-sidebar' );
	            }
            ?>
  
        </div>

    </div>
    
    <div class="tre-products-wrapper">
      <h1><?php echo get_term( $tag_id )->name;?></h1>
      <?php echo wpautop( get_term( $tag_id )->description ); ?>
      <div class="active-filters">
          <?php echo facetwp_display( 'selections' );?>
      </div>
      <div class="woocommerce">
        <div class="products">
<?php else:?>
    <?php woocommerce_output_content_wrapper();?>
        <div class="tre-categories">
            <div class="tre-container">
                <div class="inner">
                    <div class="items-grid">

                    <?php endif;?>
    
     
					<?php
					
					if ( woocommerce_product_loop() ) {
					

						woocommerce_output_all_notices();
					
						woocommerce_product_loop_start();
					
						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();
					
								/**
								 * Hook: woocommerce_shop_loop.
								 */
								do_action( 'woocommerce_shop_loop' );
					
								wc_get_template_part( 'content', 'product' );
							}
						}
					
						woocommerce_product_loop_end();
					
						/**
						 * Hook: woocommerce_after_shop_loop.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						
						//do_action( 'woocommerce_after_shop_loop' );
      
					} else {
						/**
						 * Hook: woocommerce_no_products_found.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );
					}
					
					?>

    <?php
    $category_faq = get_field('category_faq',get_queried_object());
	$category_faq_title = get_field('category_faq_title',get_queried_object());
	
    ?>
    </div>
        <?php echo do_shortcode('[facetwp facet="pagination"]');?>
    </div>
    <?php do_action( 'woocommerce_after_shop_loop' );?>
    <?php if ($category_faq):?>
        <div class="tre-faq">
            <div class="tre-container">
                <div class="inner">
                    <?php if ($category_faq_title):?>
                    <h2><?php echo $category_faq_title;?></h2>
                    <?php endif;?>
                    
                    <?php foreach ($category_faq as $faq):?>
                        <div class="tre-accordion">
                            <div class="inner">
                                <button class="accordion-trigger"><span><?php echo $faq['title'];?></span></button>
                                <div class="accordion-content">
                                    <div class="inner">
	                                    <?php echo $faq['text'];?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>

                </div>
            </div>
        </div>
        
    
    <?php endif;?>
    </div>
    </div>
    </div>
    </div>



<?php

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );

?>
<script>
    jQuery(document).ready(function ($) {
        // Target the specific facet
        const facet = $('.facetwp-facet-kartosana .fs-wrap');

        if (facet.length) {
            // Check if the label is already added
            if (!facet.find('.fs-custom-label').length) {
                facet.find('.fs-label-wrap').prepend('<div class="fs-custom-label"><?php echo born_translation('orderby_title');?></div>');
            }
        }
    });
</script>

<script>
    (function($) {

        document.addEventListener('facetwp-loaded', function() {
            $.each(FWP.settings.num_choices, function(key, val) {

               
                // this may need to change depending on your setup, for example:
                // change ".facet-wrap" to ".widget" if using WP text widgets

                var $facet = $('.facetwp-facet-' + key);
                

                var $wrap = $facet.closest('.facet-wrap');
                $wrap.show();
                
                var $flyout = $facet.closest('.flyout-row');
                if ($wrap.length || $flyout.length) {
                    var $which = $wrap.length ? $wrap : $flyout;
                    (0 === val) ? $which.hide() : $which.show();
                }
                
            });
        });
    })(jQuery);
</script>
