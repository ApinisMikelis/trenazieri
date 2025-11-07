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

$xml_file_path = __DIR__ . '/export/salidzini.xml';
$root_element  = 'root'; 

$args = array(
    'status'     => 'publish',
    'limit'      => -1,
    'return'     => 'objects',
    'visibility' => 'catalog',
);

$products = wc_get_products( $args );

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>' . "<$root_element/>");

foreach ( $products as $product ) {
    $item = $xml->addChild('item');
    
    $item->addChild('name', htmlspecialchars( $product->get_name() ) );
    $item->addChild('link', esc_url( $product->get_permalink() ) );
    $item->addChild('price', $product->get_price() ); 

    $image_id = $product->get_image_id();
    if ( $image_id ) {
        $item->addChild('image', wp_get_attachment_url( $image_id ) );
    }

    $categories = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );
    
    if ( ! empty( $categories ) ) {
        $item->addChild('category_full', implode( ' / ', $categories ) );
        
        $category_terms = wp_get_post_terms( $product->get_id(), 'product_cat' );
        $most_specific_term = null;

        if ( ! is_wp_error( $category_terms ) ) {
            foreach ($category_terms as $term) {
                if ($term->parent > 0) {
                    $most_specific_term = $term;
                    break;
                }
            }

            if ( is_null($most_specific_term) && !empty($category_terms) ) {
                $most_specific_term = $category_terms[0];
            }

            if (!is_null($most_specific_term)) {
                $term_link = get_term_link( $most_specific_term, 'product_cat' );
                $item->addChild('category_link', esc_url( $term_link ) );
            }
        }
    }

    $color_attribute_slug = 'pa_krasa'; 
    $color_attribute_value = $product->get_attribute( $color_attribute_slug );
    $color_output = '';
    
    if ( ! empty( $color_attribute_value ) ) {
        $color_output = trim( $color_attribute_value );
    }

    if ( ! empty( $color_output ) ) {
        $item->addChild('color', htmlspecialchars( $color_output ) );
    }

    $is_used = 0;
    $condition_attribute = $product->get_attribute('pa_stavoklis');
    
    if ( ! empty( $condition_attribute ) ) {
        $condition_attribute_lower = mb_strtolower( $condition_attribute );

        if ( strpos( $condition_attribute_lower, 'lietots' ) !== false ) {
            $is_used = 1;
        }
    }

    if ( $is_used === 1 ) {
        $item->addChild('used', '1');
    }

    $manufacturer_attr = $product->get_attribute('pa_razotajs');
    $item->addChild('manufacturer', htmlspecialchars( $manufacturer_attr ?? '' ) );
    
    $sku = $product->get_sku();
    
    $item->addChild('model', htmlspecialchars( $sku ?? '' ) );

    $ean_value = $product->get_meta( '_global_unique_id', true );
    if ( ! empty( $ean_value ) ) {
        $item->addChild('ean', htmlspecialchars( $ean_value ) );
    }
}

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;

$dom->loadXML($xml->asXML());
$formatted_xml_string = $dom->saveXML();

if ( file_put_contents( $xml_file_path, $formatted_xml_string ) !== false ) {
    echo "Product feed successfully exported and formatted to: $xml_file_path\n";
} else {
    echo "Error writing XML file.\n";
}
