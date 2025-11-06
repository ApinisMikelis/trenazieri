<?php
/**
 * Content wrappers
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/wrapper-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?>
<?php if (!is_singular('product')):?>
<div class="tre-page-title">
	<div class="tre-container">
		<div class="inner">
			<h1><?php woocommerce_page_title(); ?></h1>
      <?php
        if ( is_product_category() ) {
          $description = term_description();
      
          if ( $description ) {
              echo '<div class="product-category-description">';
              echo $description;
              echo '</div>';
          }
        }
      ?>
		</div>
	</div>
</div>
<?php endif;?>
<?php
