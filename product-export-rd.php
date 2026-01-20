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

$xml_file_path = __DIR__ . '/export/rd.xml';

// RD Electronics usually expects a <products> root or similar based on the single <product> node shown
$args = array(
    'status'     => 'publish',
    'limit'      => -1,
    'return'     => 'objects',
    'visibility' => 'catalog',
    'stock_status' => 'instock', // Optimization: only get instock items
);

$products = wc_get_products( $args );

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products/>');

foreach ( $products as $product ) {
    
    // REQUIREMENT 1: EAN must be set
    $ean = $product->get_meta( '_global_unique_id', true );
    if ( empty( $ean ) ) continue;

    // REQUIREMENT 2: Stock must be at least 2
    $stock_quantity = $product->get_stock_quantity();
    if ( $stock_quantity < 2 ) continue;

    $node = $xml->addChild('product');
    
    // Product Code & URL
    $node->addChild('product_code', $product->get_sku());
    $url_node = $node->addChild('url');
    // Using CDATA for URLs and Names as per screenshot
    $dom_url = dom_import_simplexml($url_node);
    $dom_url->appendChild($dom_url->ownerDocument->createCDATASection($product->get_permalink()));

    // Names (Multilingual)
    $names = $node->addChild('names');
    $langs = ['EN' => 'en', 'LV' => 'lv', 'RU' => 'ru']; // Map as needed
    foreach ($langs as $label => $code) {
        $name_node = $names->addChild('name', '');
        $name_node->addAttribute('lang', $label);
        $dom_name = dom_import_simplexml($name_node);
        $dom_name->appendChild($dom_name->ownerDocument->createCDATASection($product->get_name()));
    }

    // Descriptions (Multilingual)
    $descriptions = $node->addChild('descriptions');
    foreach ($langs as $label => $code) {
        $desc_node = $descriptions->addChild('description', '');
        $desc_node->addAttribute('lang', $code);
        $dom_desc = dom_import_simplexml($desc_node);
        // Note: RD screenshot shows HTML inside CDATA
        $dom_desc->appendChild($dom_desc->ownerDocument->createCDATASection($product->get_description()));
    }

    // Category
    $categories = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
    $category_text = !empty($categories) ? $categories[0] : 'General';
    $cat_node = $node->addChild('category');
    $dom_cat = dom_import_simplexml($cat_node);
    $dom_cat->appendChild($dom_cat->ownerDocument->createCDATASection($category_text));

    // EAN, Brand, Price, Stock
    $node->addChild('ean', $ean);
    $brand = $product->get_attribute('pa_razotajs') ?: '';
    $node->addChild('brand', $brand);
    
    $price_node = $node->addChild('price', number_format($product->get_price(), 2, '.', ''));
    $price_node->addAttribute('vat', '21'); // Adjust if your VAT varies
    
    $node->addChild('stock', $stock_quantity);

    // Attributes (Color, Material, etc)
    $attributes_node = $node->addChild('attributes');
    
    $color = $product->get_attribute('pa_krasa');
    if($color) {
        $attr = $attributes_node->addChild('attribute', '');
        $attr->addAttribute('name', 'Color');
        $dom_attr = dom_import_simplexml($attr);
        $dom_attr->appendChild($dom_attr->ownerDocument->createCDATASection($color));
    }

    // Dimensions
    $dims = $node->addChild('dimensions');
    $dims->addChild('length', $product->get_length() . 'cm');
    $dims->addChild('width', $product->get_width() . 'cm');
    $dims->addChild('height', $product->get_height() . 'cm');
    $dims->addChild('weight', $product->get_weight() . 'kg');

    // Images
    $images_node = $node->addChild('images');
    $main_img_id = $product->get_image_id();
    if ($main_img_id) {
        $main_url = wp_get_attachment_url($main_img_id);
        $m_node = $images_node->addChild('main_image')->addChild('url');
        $dom_m = dom_import_simplexml($m_node);
        $dom_m->appendChild($dom_m->ownerDocument->createCDATASection($main_url));
    }

    // Gallery
    $gallery_ids = $product->get_gallery_image_ids();
    if (!empty($gallery_ids)) {
        $gallery_node = $images_node->addChild('gallery');
        foreach ($gallery_ids as $id) {
            $g_url = wp_get_attachment_url($id);
            $gu_node = $gallery_node->addChild('url');
            $dom_gu = dom_import_simplexml($gu_node);
            $dom_gu->appendChild($dom_gu->ownerDocument->createCDATASection($g_url));
        }
    }
}

// Formatting and Saving
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());
$formatted_xml_string = $dom->saveXML();

if ( file_put_contents( $xml_file_path, $formatted_xml_string ) !== false ) {
    echo "RD Electronics feed successfully exported to: $xml_file_path\n";
} else {
    echo "Error writing XML file.\n";
}