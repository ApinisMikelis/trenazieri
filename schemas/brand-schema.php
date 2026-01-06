<?php

$site_url  = home_url('/');
$logo_url  = "https://trenazieri.lv/wp-content/uploads/2026/01/trenazieri-lv-logo-100x100-1.png";
$brand_id  = $site_url . '#organization';
$store_id  = $site_url . '#rigastore';

$brand_schema = [
  "@context" => "https://schema.org",
  "@graph" => [
      [
        "@type" => "OnlineStore",
        "@id" => $brand_id,
        "name" => "Trenazieri.lv",
        "url" => $site_url,
        "logo" => [
          "@type" => "ImageObject",
          "url" => $logo_url
        ],
        "description" => "Profesionālie un mājas trenažieri Baltijā. Skrejceliņi, velotrenažieri un fitnesa inventārs. Trenažieru zāļu, sporta klubu plānošana un aprīkošana.",
        "address" => [
          "@type" => "PostalAddress",
          "addressCountry" => "LV"
        ],
        "areaServed" => [
          ["@type" => "Country", "name" => "Latvia"],
          ["@type" => "Country", "name" => "Estonia"],
          ["@type" => "Country", "name" => "Lithuania"]
        ],
        "sameAs" => [
          "https://www.facebook.com/SportsystemsLtd",
          "https://www.instagram.com/trenazieri/",
          "https://www.youtube.com/@trenazieri"
        ]
      ],
      [
        "@type" => "SportingGoodsStore",
        "@id" => $store_id,
        "name" => "Trenazieri.lv Veikals un noliktava",
        "parentOrganization" => ["@id" => $brand_id],
        "url" => $site_url . "kontakti/",
        "telephone" => "+371 29219953",
        "priceRange" => "$$",
        "image" => $logo_url,
        "address" => [
          "@type" => "PostalAddress",
          "streetAddress" => "Bieķensalas iela 21",
          "addressLocality" => "Rīga",
          "postalCode" => "LV-1004",
          "addressCountry" => "LV"
        ],
        "geo" => [
          "@type" => "GeoCoordinates",
          "latitude" => "56.928057772068065",
          "longitude" => "24.105325327084593"
        ],
        "openingHoursSpecification" => [
          [
            "@type" => "OpeningHoursSpecification",
            "dayOfWeek" => ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
            "opens" => "09:00",
            "closes" => "18:00"
          ]
        ]
      ]
  ]
];

echo "\n" . '<script type="application/ld+json">' . json_encode($brand_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
