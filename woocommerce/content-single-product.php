<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$price = $product->get_price();
$token = 'LVddhkuihgfd0VPZT3';

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

$brand = $product->get_attribute( 'brends' );

$in_shop = false;
if('in_showroom' === $product->get_meta( '_stock_status' )):
  $in_shop = true;
endif;


$prod_delivery_time = get_the_terms($product->get_id(),'delivery-times');

$description_tab = get_field('description_tab',$product->get_id());
$instructions = get_field('instructions',$product->get_id());
$faq = get_field('faq',$product->get_id());
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
    woocommerce_show_product_images();
	?>

	<div class="summary entry-summary">

    <?php
      if ( $brand ) {
        $term = get_term_by( 'slug', $brand, 'pa_brends' );
        if ( $term ) {
          $brand_logo = get_field( 'brand_logo', $term );
          if ( $brand_logo ):?>
            <div class="brand">
              <img srcset="<?php echo born_acf_image($brand_logo,'brand-logo-small',false);?> 2x" alt="<?php echo born_img_alt($brand_logo);?>">
            </div>
          <?php endif;
        }
      }

      woocommerce_template_single_title();
      woocommerce_template_single_excerpt();
    ?>

    <div class="price-wrapper">

      <div class="left">

        <?php woocommerce_template_single_price();?>
        
        <?php if($in_shop):?>
          <div class="tags">
              <span>In Showroom</span>
          </div>
        <?php endif;?>

      </div>
        
      <?php if ($prod_delivery_time):?>
        <?php
          $delivery_text = get_field('frontend_text', $prod_delivery_time[0]);
          $days_from = get_field('days_from',$prod_delivery_time[0]);
          $days_to = get_field('days_to',$prod_delivery_time[0]);
          
          $delivery_text = str_replace('%from%', $days_from, $delivery_text);
          $delivery_text = str_replace('%to%', $days_to, $delivery_text);
        ?>
        <div class="right">
          <div class="delivery">
            <?php echo $delivery_text;?>
          </div>
        </div>
      <?php endif;?>

    </div>
		
    <?php if ( $product->is_on_backorder() ): ?>
        <div class="submit-wrapper">

            <button type="submit" name="add-to-cart" value="" class="single_add_to_cart_button button alt is-to-order" data-lightbox="tre-lightbox-order">
              <?php echo born_translation('on_backorder');?>
            </button>

            <?php echo output_consultation_cta();?>

        </div>

        <div class="tre-lightbox" id="tre-lightbox-order" style="opacity: 0; visibility: hidden; pointer-events: none;">
            <div class="inner">

                <div class="tre-lightbox-popup">

                    <button class="is-close">Close</button>

                    <div class="heading">

                        <h2><?php echo born_translation('backorder_popup_title');?></h2>
                      
                      <?php echo born_translation('backorder_popup_text');?>
                    </div>

                    <?php echo do_shortcode('[ninja_form id=2]');?>

                </div>

            </div>
        </div>
    <?php else:?>
      <?php woocommerce_template_single_add_to_cart();?>
		<?php endif; ?>
        
    <?php
    $sku = $product->get_sku();
    if ( empty( $sku ) && $product->is_type( 'variable' ) ) {
      $variations = $product->get_available_variations();
      if ( ! empty( $variations ) ) {
        foreach ( $variations as $variation ) {
          $variation_obj = wc_get_product( $variation['variation_id'] );
          if ( $variation_obj && $variation_obj->get_sku() ) {
            $sku = $variation_obj->get_sku();
            break;
          }
        }
      }
    }
    ?>
    <?php if( $sku ):?>
      <div class="details">
        <?php echo born_translation('sku'); ?>: <span class="product-sku"><?php echo $sku; ?></span>
      </div>
    <?php endif;?>

    <?php $product_tags = get_the_terms( $product->get_id(), 'product_tag' );

    if ( $product_tags && ! is_wp_error( $product_tags ) ) : ?>
      <div class="product-tags">
        <ul class="ul-ignore">
          <?php foreach ( $product_tags as $tag ) : ?>
            <li>
              <a href="<?php echo get_term_link($tag); ?>">
                <?php echo esc_html( $tag->name ); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if(!$product->is_on_sale() && !$product->is_on_backorder()): ?>
      <div
        data-widget='aizdevums'
        data-id="<?php echo $token; ?>"
        data-price="<?php echo $price; ?>"
        data-color="y"
        style="margin-top: 10px;"
      ></div>
    <?php endif; ?>
    
    <div class="accordion-description">
      <div class="inner">

        <?php if($description_tab):?>
          <div class="tre-accordion">
            <div class="inner">
              <button class="accordion-trigger">
                <span>
                  <?php echo born_translation('desc_tab_title');?>
                </span>
              </button>
              <div class="accordion-content" style="">
                <div class="inner">
                  <?php echo $description_tab;?>
                </div>
              </div>
            </div>
          </div>
        <?php endif;?>
        
        <?php if($instructions):?>
          <div class="tre-accordion">
            <div class="inner">
              <button class="accordion-trigger">
                <span>
                  <?php echo born_translation('instructions_tab_title');?>
                </span>
              </button>
              <div class="accordion-content" style="">
                <div class="inner">
                  <?php echo $instructions;?>
                </div>
              </div>
            </div>
          </div>
        <?php endif;?>
        
        <?php if($faq):?>
          <div class="tre-accordion">
            <div class="inner">
              <button class="accordion-trigger">
                <span>
                  <?php echo born_translation('faq_tab_title');?>
                </span>
              </button>
              <div class="accordion-content" style="">
                <div class="inner">
                  <?php echo $faq;?>
                </div>
              </div>
            </div>
          </div>
        <?php endif;?>

        <div class="tre-accordion">
          <div class="inner">
            <button class="accordion-trigger">
              <span><?php echo born_translation('leasing_tab_title');?></span>
            </button>
            <div class="accordion-content">
              <div class="inner">
                <?php echo born_translation('leasing_tab_text');?>
              </div>
            </div>
          </div>
        </div>

        <div class="tre-accordion">
          <div class="inner">
            <button class="accordion-trigger">
              <span><?php echo born_translation('delivery_tab_title');?></span>
            </button>
            <div class="accordion-content">
              <div class="inner">
                <?php echo born_translation('delivery_tab_text');?>
              </div>
            </div>
          </div>
        </div>

        <div class="tre-accordion">
          <div class="inner">
            <button class="accordion-trigger">
              <span><?php echo born_translation('service_tab_title');?></span>
            </button>
            <div class="accordion-content">
              <div class="inner">
                <?php echo born_translation('service_tab_text');?>
              </div>
            </div>
          </div>
        </div>

        <div class="tre-accordion">
          <div class="inner">
            <button class="accordion-trigger">
              <span><?php echo born_translation('reviews_tab_title');?></span>
            </button>
            <div class="accordion-content">
              <div class="inner">
                <?php echo do_shortcode('[cusrev_all_reviews sort="DESC" sort_by="date" per_page="10" show_summary_bar="true" show_media="true" show_products="false" products="current" product_reviews="true" shop_reviews="true" inactive_products="false" show_replies="false" show_more="5" min_chars="0" avatars="initials" users="all" add_review="true" schema_markup="true"]'); ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
       
	</div>

</div>

<?php
if ( $product->is_type( 'variable' ) ) :
  $variations_data = array();
  $variations = $product->get_available_variations();
  foreach ( $variations as $variation ) {
    $variation_obj = wc_get_product( $variation['variation_id'] );
    $variations_data[ $variation['variation_id'] ] = $variation_obj ? $variation_obj->get_sku() : '';
  }
  ?>
  <script>
  (function() {
    var variationsData = <?php echo json_encode( $variations_data ); ?>;
    jQuery('.variations_form').on('found_variation', function(event, variation) {
      var skuEl = jQuery('.product-sku');
      if (skuEl.length && variationsData[ variation.variation_id ]) {
        skuEl.text( variationsData[ variation.variation_id ] );
      }
    });
  })();
  </script>
<?php endif; ?>

<?php do_action( 'woocommerce_after_single_product' ); ?>
