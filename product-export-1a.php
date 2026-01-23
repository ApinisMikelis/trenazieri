<?php

$CRON_KEY = 'BCM1gvGyUBHL8fBjscjt'; 

require_once( __DIR__ . '/wp-load.php' ); 

if ( 
    php_sapi_name() !== 'cli' && 
    !defined('DOING_CRON') && 
    (empty($_GET['key']) || $_GET['key'] !== $CRON_KEY)
) {
    exit('Direct access not permitted.');
}

$xml_file_path = __DIR__ . '/export/1a-test.xml';

$args = array(
    'status'     => 'publish',
    'limit'      => -1,
    'return'     => 'objects',
    'visibility' => 'catalog',
    'stock_status' => 'instock',
);

$products = wc_get_products( $args );

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products/>');

foreach ( $products as $product ) {
    
    // REQUIREMENT: Check if '1a' is selected in the ACF checkbox
    $export_settings = $product->get_meta( 'xml_export', true );
    if ( empty( $export_settings ) ) continue;
    
    if ( is_array( $export_settings ) ) {
        if ( ! in_array( '1a', $export_settings ) ) continue;
    } else {
        if ( ! preg_match( '/"1a"/', $export_settings ) ) continue;
    }

    // REQUIREMENT: EAN/Global ID must be set
    $ean = $product->get_meta( '_global_unique_id', true );
    if ( empty( $ean ) ) continue;

    // REQUIREMENT: Stock must be at least 2
    $stock_quantity = $product->get_stock_quantity();
    if ( $stock_quantity < 2 ) continue;

    $node = $xml->addChild('product');
    
    // Core ID & Codes
    $node->addChild('id', $product->get_id());
    $node->addChild('manufacturer_code', $product->get_sku());
    
    // Name
    $name_node = $node->addChild('name');
    $dom_name = dom_import_simplexml($name_node);
    $dom_name->appendChild($dom_name->ownerDocument->createCDATASection($product->get_name()));

    // Category & Brand
    $categories = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
    $category_text = !empty($categories) ? $categories[0] : 'General';
    $node->addChild('category', $category_text);
    
    $brand = $product->get_attribute('pa_razotajs') ?: '';
    $node->addChild('brand', $brand);
    $node->addChild('ean', $ean);

    // Description (Using Product Short Description)
    $desc_node = $node->addChild('description');
    $dom_desc = dom_import_simplexml($desc_node);
    $short_desc = $product->get_short_description();
    $dom_desc->appendChild($dom_desc->ownerDocument->createCDATASection($short_desc));

    // Price Logic: x = [regular] - 15%. If x < [sale], use [sale].
    $regular_price = (float) $product->get_regular_price();
    $sale_price    = (float) $product->get_sale_price();
    $calculated_x  = $regular_price * 0.85;
    
    $final_price = ($sale_price > 0 && $calculated_x < $sale_price) ? $sale_price : $calculated_x;
    $node->addChild('purchase_price', number_format($final_price, 2, '.', ''));
    
    // Stock
    $node->addChild('quantity_in_stock', $stock_quantity);

    // Images
    $images_node = $node->addChild('images');
    $main_img_id = $product->get_image_id();
    if ($main_img_id) {
        $main_url = wp_get_attachment_url($main_img_id);
        $url_node = $images_node->addChild('image_url');
        $dom_img = dom_import_simplexml($url_node);
        $dom_img->appendChild($dom_img->ownerDocument->createCDATASection($main_url));
    }

    // Product URL
    $prod_url_node = $node->addChild('product_url');
    $dom_p_url = dom_import_simplexml($prod_url_node);
    $dom_p_url->appendChild($dom_p_url->ownerDocument->createCDATASection($product->get_permalink()));
}

// Formatting and Saving
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());
$formatted_xml_string = $dom->saveXML();

if ( file_put_contents( $xml_file_path, $formatted_xml_string ) !== false ) {
    echo "1A store feed successfully exported to: $xml_file_path\n";
} else {
    echo "Error writing XML file.\n";
}