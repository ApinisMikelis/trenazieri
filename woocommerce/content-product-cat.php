<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
	
$video_file = get_field('video_file', $category);
?>
<!--<li --><?php /*wc_product_cat_class( '', $category ); */?>
	<?php
	/**
	 * The woocommerce_before_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_open - 10
	 */
	//do_action( 'woocommerce_before_subcategory', $category );
		
    born_template_loop_category_link_open($category);
    
    ?>
    <?php if ($video_file):?>
        <div class="bg-video">
            <script>
                function showVideo<?php echo $category->term_id;?>() {
                    var element = document.getElementById('tre-intro-banner-video-1');
                    element.classList.add('is-visible');
                }
            </script>
 
            <?php woocommerce_subcategory_thumbnail($category);?>

            <video width="100%" height="100%" autoplay loop muted playsinline oncanplaythrough="showVideo<?php echo $category->term_id;?>()" id="tre-intro-banner-video-1" style="opacity: 0;">
                <source src="<?php echo $video_file;?>" type="video/mp4">
                Sorry, your browser doesn't support embedded videos.
            </video>
        </div>
    <?php endif;?>
    <?php

	/**
	 * The woocommerce_before_subcategory_title hook.
	 *
	 * @hooked woocommerce_subcategory_thumbnail - 10
	 */
    echo '<span class="image">';
	do_action( 'woocommerce_before_subcategory_title', $category );
    echo '</span>';
	/**
	 * The woocommerce_shop_loop_subcategory_title hook.
	 *
	 * @hooked woocommerce_template_loop_category_title - 10
	 */
	//do_action( 'woocommerce_shop_loop_subcategory_title', $category );
    ?>
    <span class="heading"><?php echo $category->name;?></span>
    <?php
	/**
	 * The woocommerce_after_subcategory_title hook.
	 */
	do_action( 'woocommerce_after_subcategory_title', $category );

	/**
	 * The woocommerce_after_subcategory hook.
	 *
	 * @hooked woocommerce_template_loop_category_link_close - 10
	 */
	do_action( 'woocommerce_after_subcategory', $category );
	?>
<!--</li>-->
