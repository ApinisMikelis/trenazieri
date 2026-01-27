<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\HTML
 * @version 10.4.0
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

defined( 'ABSPATH' ) || exit;

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php
echo $email_improvements_enabled ? '<div class="email-introduction">' : '';
/* translators: %s: Customer billing full name */
$text = __( 'You’ve received the following order from %s:', 'woocommerce' );
if ( $email_improvements_enabled ) {
	/* translators: %s: Customer billing full name */
	$text = __( 'You’ve received a new order from %s:', 'woocommerce' );
}
?>
<p><?php printf( esc_html( $text ), esc_html( $order->get_formatted_billing_full_name() ) ); ?></p>
<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );


/**
 * Born Courier Address Display
 * Data is saved with a leading underscore as per the plugin source code.
 */
$order_id = $order->get_id();

$born_address  = get_post_meta( $order_id, '_born_courier_address', true );
$born_city     = get_post_meta( $order_id, '_born_courier_city', true );
$born_postcode = get_post_meta( $order_id, '_born_courier_postcode', true );
$born_country  = get_post_meta( $order_id, '_born_courier_country', true );

if ( ! empty( $born_address ) ) : ?>
    <div style="margin-top: 20px; margin-bottom: 20px; padding: 15px; border: 2px solid #e07425; background-color: #fafafa; border-radius: 4px;">
        <h2 style="color: #e07425; font-family: Antonio, sans-serif; margin-bottom: 10px; text-transform: uppercase; font-size: 18px; line-height: 1.2;">
            <?php _e( 'Piegādes Informācija', 'woocommerce' ); ?>
        </h2>
        <p style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; color: #333; margin: 0;">
            <strong>Adrese:</strong> <?php echo esc_html( $born_address ); ?><br>
            <strong>Pilsēta:</strong> <?php echo esc_html( $born_city ); ?><br>
            <strong>Pasta indekss:</strong> <?php echo esc_html( $born_postcode ); ?><br>
            <strong>Valsts:</strong> <?php echo esc_html( WC()->countries->countries[ $born_country ] ?? $born_country ); ?>
        </p>
    </div>
<?php endif;

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation"><tr><td class="email-additional-content">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
