<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php get_header( 'shop' ); ?>
<div class="tre-product-single">
	<div class="tre-container">
		<div class="inner">
      <?php woocommerce_output_content_wrapper(); ?>
      <?php woocommerce_breadcrumb();?>
  
      <?php while ( have_posts() ) : ?>
        <?php the_post(); ?>
        <?php wc_get_template_part( 'content', 'single-product' ); ?>
      <?php endwhile; ?>
  
      <?php $items = wc_get_related_products( get_the_ID(), 7 ); ?>
      <?php do_action( 'woocommerce_sidebar' ); ?>
		</div>
	</div>
</div>

<?php if ( $product && ( $product->has_attributes() || $product->has_weight() || $product->has_dimensions() ) ) : ?>
  <div class="tre-description-table">
    <div class="tre-container">
      <div class="inner">
        <h2><?php echo born_translation('technical_information')?></h2>
        <?php do_action( 'woocommerce_product_additional_information', $product ); ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php the_content();?>

<?php if ($items):?>
<div class="tre-products-slider is-dark">
  <div class="tre-container">
    <div class="inner">
  
        <h2><?php echo born_translation('similar_products');?></h2>

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
                              <?php wc_get_template_part( 'content', 'product' ); ?>
                            </div>
                        </div>
                        <?php wp_reset_postdata();
                      endif; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>

                </div>

            </div>

        </div>

    </div>
  </div>
</div>
<?php endif;

get_footer( 'shop' ); ?>
