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
    
    $export_settings = $product->get_meta( 'xml_export', true );
    if ( empty( $export_settings ) ) continue;
    
    if ( is_array( $export_settings ) ) {
        if ( ! in_array( 'rd', $export_settings ) ) continue;
    } else {
        if ( ! preg_match( '/"rd"/', $export_settings ) ) continue;
    }

    $ean = $product->get_meta( '_global_unique_id', true );
    if ( empty( $ean ) ) continue;

    $stock_quantity = $product->get_stock_quantity();
    if ( $stock_quantity < 2 ) continue;

    $node = $xml->addChild('product');
    $node->addChild('product_code', $product->get_sku());
    
    $url_node = $node->addChild('url');
    $dom_url = dom_import_simplexml($url_node);
    $dom_url->appendChild($dom_url->ownerDocument->createCDATASection($product->get_permalink()));

    $names = $node->addChild('names');
    $langs = ['EN' => 'en', 'LV' => 'lv', 'RU' => 'ru']; 
    foreach ($langs as $label => $code) {
        $name_node = $names->addChild('name', '');
        $name_node->addAttribute('lang', $label);
        $dom_name = dom_import_simplexml($name_node);
        $dom_name->appendChild($dom_name->ownerDocument->createCDATASection($product->get_name()));
    }

    $descriptions = $node->addChild('descriptions');
    foreach ($langs as $label => $code) {
        $desc_node = $descriptions->addChild('description', '');
        $desc_node->addAttribute('lang', $code);
        $dom_desc = dom_import_simplexml($desc_node);
        $short_desc = $product->get_short_description();
        $dom_desc->appendChild($dom_desc->ownerDocument->createCDATASection($short_desc));
    }

    $categories = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
    $category_text = !empty($categories) ? $categories[0] : 'General';
    $cat_node = $node->addChild('category');
    $dom_cat = dom_import_simplexml($cat_node);
    $dom_cat->appendChild($dom_cat->ownerDocument->createCDATASection($category_text));

    $node->addChild('ean', $ean);
    $brand = $product->get_attribute('pa_razotajs') ?: '';
    $node->addChild('brand', $brand);
    
    // Price Logic: x = [regular] - 15%. If x < [sale], use [sale].
    $regular_price = (float) $product->get_regular_price();
    $sale_price    = (float) $product->get_sale_price();
    $calculated_x  = $regular_price * 0.85;
    
    $final_price = ($sale_price > 0 && $calculated_x < $sale_price) ? $sale_price : $calculated_x;

    $price_node = $node->addChild('price', number_format($final_price, 2, '.', ''));
    $price_node->addAttribute('vat', '21'); 
    
    $node->addChild('stock', $stock_quantity);

    $attributes_node = $node->addChild('attributes');
    $color = $product->get_attribute('pa_krasa');
    if($color) {
        $attr = $attributes_node->addChild('attribute', '');
        $attr->addAttribute('name', 'Color');
        $dom_attr = dom_import_simplexml($attr);
        $dom_attr->appendChild($dom_attr->ownerDocument->createCDATASection($color));
    }

    $dims = $node->addChild('dimensions');
    $dims->addChild('length', $product->get_length() . 'cm');
    $dims->addChild('width', $product->get_width() . 'cm');
    $dims->addChild('height', $product->get_height() . 'cm');
    $dims->addChild('weight', $product->get_weight() . 'kg');

    $images_node = $node->addChild('images');
    $main_img_id = $product->get_image_id();
    if ($main_img_id) {
        $main_url = wp_get_attachment_url($main_img_id);
        $m_node = $images_node->addChild('main_image')->addChild('url');
        $dom_m = dom_import_simplexml($m_node);
        $dom_m->appendChild($dom_m->ownerDocument->createCDATASection($main_url));
    }

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