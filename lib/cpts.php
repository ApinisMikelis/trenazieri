<?php if( !defined('WPINC') ) die;

/**
 * Custom Post Types
 */


$BORN_FRAMEWORK->Cpt
	->addCpt('news', [
		'name'                => _x('New', 'Post type name', BORN_NAME),
		'supports'            => array('editor', 'thumbnail'),
		'public'              => true,
		'has_archive'         => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-pressthis',
		'rewrite'             => ['slug' => '%news_page%', 'with_front' => false],
	] )
	
	->addCpt('portfolio', [
		'name'                => _x('Portfolio', 'Post type name', BORN_NAME),
		'supports'            => array('editor', 'thumbnail'),
		'public'              => true,
		'has_archive'         => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-pressthis',
		'rewrite'             => ['slug' => '%portfolio_page%', 'with_front' => false],
	] )
	
	->addCpt('reviews', [
		'name'                => _x('Review', 'Post type name', BORN_NAME),
		'supports'            => array('editor', 'thumbnail'),
		'public'              => false,
		'has_archive'         => false,
		'publicly_queryable'  => false,
		'exclude_from_search' => false,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-pressthis',
	] )*/
	
	->addCpt('frequent-blocks', [
		'name'                => _x('Frequent block', 'Post type name', BORN_NAME),
		'supports'            => array('editor'),
		'public'              => false,
		'has_archive'         => false,
		'publicly_queryable'  => false,
		'exclude_from_search' => false,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-pressthis',
	] )
	
	->addTax('delivery-times', [
		'name'         => _x('Delivery time', 'Taxonomy name', BORN_NAME),
		'plural_name'  => _x('Delivery times', 'Taxonomy name plural', BORN_NAME),
		'post_types'   => ['product'],
		'public'       => false,
		'has_archive'  => false,
		'hierarchical' => true,
	])

	->register();
