<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
  return;
}
?>
<table class="woocommerce-product-attributes shop_attributes" aria-label="<?php esc_attr_e( 'Product Details', 'woocommerce' ); ?>">
  <?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
    <?php 
      $attribute_value = wp_kses_post( $product_attribute['value'] );
      $strip_value = trim(strip_tags($attribute_value));
      $forbidden_values = array( '', 'Nav pieejams', 'n/a', '-' );

      if ( in_array( $strip_value, $forbidden_values ) ) {
        continue;
      }
    ?>
    <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
      <th class="woocommerce-product-attributes-item__label" scope="row"><?php echo wp_kses_post( $product_attribute['label'] ); ?></th>
      <td class="woocommerce-product-attributes-item__value"><?php echo $attribute_value; ?></td>
    </tr>
  <?php endforeach; ?>
</table>
