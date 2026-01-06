<?php

  global $wp_query;
  $products = $wp_query->posts;
  $current_cat = get_queried_object();

  $items = [];

  if ( ! empty( $products ) ) {
    foreach ( $products as $index => $post ) {
      $product = wc_get_product($post->ID);
      
      if ( ! $product ) continue;

      $items[] = [
        "@type" => "ListItem",
        "position" => $index + 1,
        "item" => [
          "@type" => "Product",
          "url" => get_permalink($post->ID),
          "name" => $product->get_name(),
          "image" => wp_get_attachment_url($product->get_image_id()),
          "offers" => [
            "@type" => "Offer",
            "price" => $product->get_price(),
            "priceCurrency" => get_woocommerce_currency(),
            "availability" => $product->is_in_stock() ? "https://schema.org/InStock" : "https://schema.org/OutOfStock"
          ]
        ]
      ];
    }
  }

  if ( ! empty( $items ) ) {
    $schema = [
      "@context" => "https://schema.org",
      "@type"    => "CollectionPage",
      "name"     => isset($current_cat->name) ? $current_cat->name : '',
      "url"      => get_term_link($current_cat),
      "mainEntity" => [
        "@type"           => "ItemList",
        "numberOfItems"   => count( $items ),
        "itemListElement" => $items
      ]
    ];

    echo "\n" . '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n"; 
  }
  