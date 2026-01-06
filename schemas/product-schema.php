<?php

$post_id = get_the_ID();

if ( ! $post_id || get_post_type( $post_id ) !== 'product' ) {
    return;
}

$product_data = wc_get_product( $post_id );

if ( $product_data ) {
    $name         = $product->get_name();
    $sku          = $product->get_sku();
    $gtin = get_post_meta( $post_id, '_global_unique_id', true );
    $price        = $product->get_price();
    $currency     = get_woocommerce_currency();
    $availability = $product->is_in_stock() ? 'InStock' : 'OutOfStock';
    $image_url    = wp_get_attachment_url( $product->get_image_id() );
    $description  = wp_strip_all_tags( $product->get_short_description() );
    $brand_name = $product->get_attribute('pa_brends');

    if ( empty($brand_name) ) { $brand_name = get_bloginfo('name'); }

    $schema = [
        "@context" => "https://schema.org/",
        "@type" => "Product",
        "name" => $name,
        "image" => $image_url,
        "description" => $description,
        "sku" => $sku,
        "brand" => [
            "@type" => "Brand",
            "name" => $brand_name
        ],
        "offers" => [
            "@type" => "Offer",
            "url" => get_permalink(),
            "priceCurrency" => $currency,
            "price" => $price,
            "availability" => "https://schema.org/" . $availability,
            "itemCondition" => "https://schema.org/NewCondition",
            "priceValidUntil" => date('Y-12-31')
        ],
        "additionalProperty" => []
    ];

    if ( $gtin ) {
      $schema["gtin13"] = $gtin;
    }

    $attributes = $product->get_attributes();
    
    foreach ( $attributes as $attribute ) {
        $attr_name = wc_attribute_label( $attribute->get_name() );
        $attr_values = $product->get_attribute( $attribute->get_name() );
        
        $schema["additionalProperty"][] = [
            "@type" => "PropertyValue",
            "name" => $attr_name,
            "value" => $attr_values
        ];
    }

    echo '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>';
}
?>