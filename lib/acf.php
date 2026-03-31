<?php

add_filter('acf/settings/save_json', function($path) {
    $path = get_stylesheet_directory() . '/acf-json';

    return $path;
});

add_filter('acf/settings/load_json', function($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';

    return $paths;
});

add_action('acf/init', 'born_acf_init');
function born_acf_init()
{

    // check function exists
    if (function_exists('acf_register_block')) {

        acf_register_block([
            'name' => 'mega-menu-list',
            'title' => __('Mega menu list'),
            'render_callback' => 'born_acf_block_render_callback',
            'category' => 'born-category',
            'mode' => 'edit',
            'supports' => ['mode' => false],
        ]);
	    
	    acf_register_block([
		    'name' => 'intro-promo',
		    'title' => __('Intro promo'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'single-product-promo',
		    'title' => __('Single product promo'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'brands-slider',
		    'title' => __('Brands slider'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'product-slider',
		    'title' => __('Product slider'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'product-collection',
		    'title' => __('Product collection'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'single-feature',
		    'title' => __('Single feature'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'accordion',
		    'title' => __('Accordion'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'contact-info',
		    'title' => __('Contact info'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'custom-map',
		    'title' => __('Custom map'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'legal-info',
		    'title' => __('Legal info'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'portfolio-blocks',
		    'title' => __('Portfolio blocks'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);
	    
	    acf_register_block([
		    'name' => 'facet-filter',
		    'title' => __('Facet filters'),
		    'render_callback' => 'born_acf_block_render_callback',
		    'category' => 'born-category',
		    'mode' => 'edit',
		    'supports' => ['mode' => false],
	    ]);


    }
}

function born_acf_block_render_callback($block)
{

    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);

    // include a template part from within the "template-parts/block" folder
    if (file_exists(get_theme_file_path("/layout/acf/{$slug}.php"))) {
        include(get_theme_file_path("/layout/acf/{$slug}.php"));
    }
}

add_filter('block_categories_all' , function($categories) {

	$categories[] = [
		'slug'  => 'born-category',
		'title' => 'Born'
	];

	return $categories;
});