<?php
  
  $current_cat = get_queried_object();
  $subcategories = get_terms([
    'taxonomy' => 'product_cat',
    'parent'   => $current_cat->term_id,
    'hide_empty' => false,
  ]);

  $items = [];
  foreach ( $subcategories as $index => $sub ) {
    $items[] = [
      "@type" => "ListItem",
      "position" => $index + 1,
      "name" => $sub->name,
      "url" => get_term_link($sub)
    ];
  }

  $schema = [
    "@context" => "https://schema.org",
    "@type" => "CollectionPage",
    "name" => $current_cat->name,
    "mainEntity" => [
      "@type" => "ItemList",
      "numberOfItems" => count($items),
      "itemListElement" => $items
    ]
  ];

  echo "\n\n" . '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n\n";
