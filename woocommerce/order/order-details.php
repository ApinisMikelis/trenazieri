<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id );

if ( ! $order ) {
	return;
}

$order_items        = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$downloads          = $order->get_downloadable_items();

$show_customer_details = $order->get_user_id() === get_current_user_id();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>

<?php
	if ( $show_customer_details ) {
		wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
	}
?>

  <div class="tre-thank-you">
    <div class="tre-container">
      <div class="inner">
        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
          <tbody>
            <?php foreach ( $order_items as $item_id => $item ) :
              $product = $item->get_product(); ?>

              <tr class="woocommerce-cart-form__cart-item cart_item">
                <td class="product-thumbnail">
                  <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>">
                    <img src="<?php echo esc_url( wp_get_attachment_url( $product->get_image_id() ) ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>">
                  </a>
                </td>
                <td class="product-name" data-title="<?php _e('Product', 'woocommerce'); ?>">
                  <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>">
                    <?php echo esc_html( $product->get_name() ); ?>
                  </a>
                </td>
                <td class="product-price" data-title="<?php _e('Price', 'woocommerce'); ?>">
                  <?php if ( $item->get_total() / $item->get_quantity() !== $product->get_regular_price() ) : ?>
                    <del aria-hidden="true">
                      <span class="woocommerce-Price-amount amount">
                        <bdi>
                          <span class="woocommerce-Price-currencySymbol">
                            <?php echo get_woocommerce_currency_symbol(); ?>
                          </span><?php echo wc_format_decimal( $product->get_regular_price(), 2 ); ?>
                        </bdi>
                      </span>
                    </del>
                  <?php endif; ?>
                    <ins>
                      <span class="woocommerce-Price-amount amount">
                        <bdi>
                          <span class="woocommerce-Price-currencySymbol">
                            <?php echo get_woocommerce_currency_symbol(); ?>
                          </span><?php echo wc_price( $item->get_total() / $item->get_quantity() ); ?>
                        </bdi>
                      </span>
                    </ins>
                </td>
                <td class="product-subtotal" data-title="<?php _e('Subtotal', 'woocommerce'); ?>">
                  <span class="woocommerce-Price-amount amount">
                      <span class="woocommerce-Price-currencySymbol">
                        <?php echo get_woocommerce_currency_symbol(); ?>
                      </span><?php echo wc_price( $item->get_total() ); ?>
                  </span>
                </td>
                <td class="total" data-title="<?php _e('Total', 'woocommerce'); ?>">
                  <span class="woocommerce-Price-amount amount">
                    <bdi>
                      <span class="woocommerce-Price-currencySymbol">
                      </span><?php echo wc_price( $item->get_total() ); ?>
                    </bdi>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<?php do_action( 'woocommerce_after_order_details', $order );
