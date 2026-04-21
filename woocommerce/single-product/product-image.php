<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.5.0
 */

use Automattic\WooCommerce\Enums\ProductType;

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
  return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$attachment_ids    = $product->get_gallery_image_ids();

if ( $product->is_type( ProductType::VARIABLE ) ) {
  $variation_ids = $product->get_children();
  
  foreach ( $variation_ids as $variation_id ) {
    $variation = wc_get_product( $variation_id );
    $variation_image_id = $variation->get_image_id();
    
    if ( $variation_image_id && ! in_array( $variation_image_id, $attachment_ids ) ) {
      $attachment_ids[] = $variation_image_id;
    }
  }
}

if ( $post_thumbnail_id && ! in_array( $post_thumbnail_id, $attachment_ids ) ) {
  array_unshift( $attachment_ids, $post_thumbnail_id );
}

$wrapper_classes = apply_filters(
  'woocommerce_single_product_image_gallery_classes',
  array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
    'woocommerce-product-gallery--columns-' . absint( $columns ),
    'images',
    'tre-product-single-gallery'
  )
);

$youtube_video_url = get_field('youtube_video_url', $product->get_id());
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>">
  <div class="slider-photos-wrapper">
      
    <?php if ( $product->is_on_sale() ) : ?>
      <div class="tags">
        <div class="tag">
          <?php
            if ( $product->is_type( ProductType::VARIABLE ) ) {
              $regular_price_min = $product->get_variation_regular_price( 'min' );
              $regular_price_max = $product->get_variation_regular_price( 'max' );
              $sale_price_min    = $product->get_variation_sale_price( 'min' );
              $sale_price_max    = $product->get_variation_sale_price( 'max' );
              
              $discount_min = $regular_price_min > 0 ? round( ( ( $regular_price_min - $sale_price_min ) / $regular_price_min ) * 100 ) : 0;
              $discount_max = $regular_price_max > 0 ? round( ( ( $regular_price_max - $sale_price_max ) / $regular_price_max ) * 100 ) : 0;
              
              if ( $discount_min === $discount_max || $discount_max <= $discount_min ) {
                echo '-' . $discount_min . '%';
              } else {
                echo '-' . $discount_min . '% - ' . $discount_max . '%';
              }
            } else if ($product->is_type( ProductType::SIMPLE )) {
              $regular_price       = $product->get_regular_price();
              $sale_price          = $product->get_sale_price();
              $discount_percentage = $regular_price > 0 ? round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) : 0;
              echo '-' . $discount_percentage . '%';
            }
          ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="slider-photos" style="opacity: 0;">
      <?php if ( ! empty( $attachment_ids ) ) : ?>
        <?php foreach ($attachment_ids as $attachment_id) : ?>
          <div class="slider-item" data-image-id="<?php echo $attachment_id; ?>">
            <?php echo born_acf_image($attachment_id, 'tren_woocommerce_single', true); ?>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="slider-item">
          <img src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ); ?>" alt="<?php esc_attr_e( 'Awaiting product image', 'woocommerce' ); ?>" />
        </div>
      <?php endif; ?>
    </div>

    <?php if ( count( $attachment_ids ) > 1 ) : ?>
      <div class="slider-thumbs-wrapper">
        <div class="slider-thumbs">
          <?php foreach ($attachment_ids as $attachment_id) : ?>
            <?php
            $image_url = get_custom_image_url($attachment_id, 'tre-woo-gal-thumb', 104, 136);
            $image_url_x2 = get_custom_image_url($attachment_id, 'tre-woo-gal-thumb-x2', 208, 272);

            if (empty($image_url)) {
              $image_url = born_acf_image($attachment_id, 'tre-woo-gal-thumb', false);
            }
            
            if (empty($image_url_x2)) {
              $image_url_x2 = born_acf_image($attachment_id, 'tre-woo-gal-thumb-x2', false);
            }
            ?>
            <button type="button" class="slider-item" data-image-id="<?php echo $attachment_id; ?>">
              <img srcset="<?php echo esc_url($image_url); ?>, <?php echo esc_url($image_url_x2); ?>?v=2 2x" alt="<?php echo esc_attr(get_the_title()); ?>">
            </button>
          <?php endforeach; ?>

          <?php if ($youtube_video_url):?>
            <div class="video-item" data-lightbox="tre-lightbox-gallery">
              <?php
                $youtube_id = born_extract_youtube_id( $youtube_video_url);
                $fallback = get_template_directory_uri() . '/assets/tmp/product-video-thumb-1.jpg';
                $thumb = $youtube_id 
                  ? "https://i.ytimg.com/vi/{$youtube_id}/maxresdefault.jpg" 
                  : $fallback;
              ?>
              <img
                src="<?php echo esc_url($thumb); ?>" 
                onerror="this.src='<?php echo esc_url($fallback); ?>'"
                alt="<?php echo esc_attr(get_the_title()); ?>"
                style="width:100%; height:100%; object-fit:cover; object-position:center;display:block;"
              />
            </div>
          <?php endif;?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php if ($youtube_video_url):?>
  <div class="tre-lightbox is-video" id="tre-lightbox-gallery" style="opacity: 0; visibility: hidden; pointer-events: none;">
    <div class="inner">
      <div class="tre-lightbox-popup">
        <iframe
          id="video123"
          src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>"
          title="YouTube video"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen
        ></iframe>
        <button class="is-close">Close</button>
      </div>
    </div>
  </div>
<?php endif;?>

<script>
  jQuery(document).ready(function ($) {
    if (jQuery('.tre-product-single-gallery').length) {
      var photosSlider = tns({
        mode: 'carousel',
        items: 1,
        loop: false,
        speed: 350,
        container: '.tre-product-single-gallery .slider-photos',
        slideBy: 'page',
        autoplay: false,
        autoplayHoverPause: false,
        autoplayButtonOutput: false,
        gutter: 0,
        controls: false,
        controlsPosition: 'top',
        autoHeight: true,
        preventActionWhenRunning: false,
        onInit: showGallerySlider
      });

      $('.slider-thumbs').on('click', '.slider-item', function() {
        $('.slider-thumbs .slider-item').removeClass('tns-nav-active');
        $(this).addClass('tns-nav-active');
        var index = $(this).index();
        photosSlider.goTo(index);
      });

      photosSlider.events.on('indexChanged', function() {
        var info = photosSlider.getInfo();
        $('.slider-thumbs .slider-item').removeClass('tns-nav-active');
        $('.slider-thumbs .slider-item').eq(info.index).addClass('tns-nav-active');
      });

      function showGallerySlider() {
        setTimeout(function() {
          jQuery('.tre-product-single-gallery .slider-photos').addClass('is-visible');
        }, 100);
      }

      $('.variations_form').on('found_variation', function (event, variation) {
        if (variation && variation.image_id) {
          let imageId = variation.image_id;
          let targetThumb = $('.slider-thumbs .slider-item[data-image-id="' + imageId + '"]');
          if (targetThumb.length) {
            var index = targetThumb.index();
            photosSlider.goTo(index);
          }
        }
      });
    }
  });
</script>