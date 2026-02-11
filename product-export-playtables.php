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

// Adjusted file path for this specific format
$xml_file_path = __DIR__ . '/export/playtables.xml';

$args = array(
    'status'     => 'publish',
    'limit'      => -1,
    'return'     => 'objects',
    'visibility' => 'catalog',
    'stock_status' => 'instock',
);

$products = wc_get_products( $args );

// Root node changed to <root> per your sample
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root/>');

foreach ( $products as $product ) {
    
    // Keeping your existing export filters
    $export_settings = $product->get_meta( 'xml_export', true );
    if ( empty( $export_settings ) ) continue;
    
    if ( is_array( $export_settings ) ) {
        if ( ! in_array( 'playtables', $export_settings ) ) continue;
    } else {
        if ( ! preg_match( '/"playtables"/', $export_settings ) ) continue;
    }

    $stock_quantity = $product->get_stock_quantity();
    if ( $stock_quantity < 2 ) continue;

    
    // Pricing Logic: 15% discount then deduct 21% VAT
    $regular_price = (float) $product->get_regular_price();
    $sale_price    = (float) $product->get_sale_price();
    $calculated_x  = $regular_price * 0.85;
    
    $final_price_gross = ($sale_price > 0 && $calculated_x < $sale_price) ? $sale_price : $calculated_x;
    $final_price_net = $final_price_gross / 1.21;
    
    // Create <item> node
    $node = $xml->addChild('item');
    
    $node->addChild('name', htmlspecialchars($product->get_name()));
    $node->addChild('link', get_permalink($product->get_id()));
    
    // Price node without VAT
    $node->addChild('price', number_format($final_price_net, 2, '.', ''));
    $node->addChild('stock', $stock_quantity);
    
    // Image logic
    $main_img_id = $product->get_image_id();
    $image_url = $main_img_id ? wp_get_attachment_url($main_img_id) : '';
    $node->addChild('image', $image_url);

    // Category Logic
    $categories = wc_get_product_terms($product->get_id(), 'product_cat', array('fields' => 'all'));
    $cat_full_names = [];
    $first_cat_link = '';

    if (!empty($categories)) {
        foreach ($categories as $cat) {
            $cat_full_names[] = $cat->name;
        }
        $first_cat_link = get_term_link($categories[0]);
    }

    $node->addChild('category_full', htmlspecialchars(implode(' / ', $cat_full_names)));
    $node->addChild('category_link', $first_cat_link);

    // Color (if exists)
    $color = $product->get_attribute('pa_krasa');
    if ($color) {
        $node->addChild('color', htmlspecialchars($color));
    }

    // Manufacturer (Brand)
    $brand = $product->get_attribute('pa_razotajs') ?: '';
    $node->addChild('manufacturer', htmlspecialchars($brand));

    // Model (Using SKU or Model attribute)
    $model = $product->get_sku() ?: $product->get_attribute('pa_modelis');
    $node->addChild('model', htmlspecialchars($model));

    // Used flag (optional check based on category)
    if (strpos(strtolower(implode(' ', $cat_full_names)), 'lietoti') !== false) {
        $node->addChild('used', '1');
    }
}

// Format the output for readability
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());
$formatted_xml_string = $dom->saveXML();

if ( file_put_contents( $xml_file_path, $formatted_xml_string ) !== false ) {
    echo "Custom feed successfully exported to: $xml_file_path\n";
} else {
    echo "Error writing XML file.\n";
}
