<?php if( !defined('WPINC') ) die;

/**
 * Custom Post Types
 */


$BORN_FRAMEWORK->Cpt
	/** START: Blog **/

	/** END: Blog **/
	
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
		//	'rewrite'             => ['slug' => 'publications', 'with_front' => false],
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
		//	'rewrite'             => ['slug' => 'publications', 'with_front' => false],
	] )
	/*->addCpt('news', [
		'name'                => _x('New', 'Post type name', BORN_NAME),
		'supports'            => array('editor', 'thumbnail'),
		'public'              => true,
		'has_archive'         => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-pressthis',
		'rewrite'             => ['slug' => '%news_page%', 'with_front' => false],
	//	'rewrite'             => ['slug' => 'publications', 'with_front' => false],
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
		//'rewrite'             => ['slug' => '%news_page%', 'with_front' => false],
		//	'rewrite'             => ['slug' => 'publications', 'with_front' => false],
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
		//'rewrite'             => ['slug' => '%news_page%', 'with_front' => false],
		//	'rewrite'             => ['slug' => 'publications', 'with_front' => false],
	] )
	
	->addTax('delivery-times', [
		'name'         => _x('Delivery time', 'Taxonomy name', BORN_NAME),
		'plural_name'  => _x('Delivery times', 'Taxonomy name plural', BORN_NAME),
		'post_types'   => ['product'],
		//'rewrite' => array('slug' => '%certificates_page%', 'with_front' => false),
		'public'       => false,
		'has_archive'         => false,
		//'rewrite'      => ['slug' => 'darbi', 'with_front' => false],
		'hierarchical' => true,
	])
	
	/*->addTax('filter-one', [
		'name'         => _x('Filter 1', 'Taxonomy name', BORN_NAME),
		'plural_name'  => _x('Filter 1', 'Taxonomy name plural', BORN_NAME),
		'post_types'   => ['product'],
		//'rewrite' => array('slug' => '%certificates_page%', 'with_front' => false),
		'public'       => false,
		'has_archive'         => false,
		//'rewrite'      => ['slug' => 'darbi', 'with_front' => false],
		'hierarchical' => true,
	])
	
	->addTax('filter-two', [
		'name'         => _x('Filter 2', 'Taxonomy name', BORN_NAME),
		'plural_name'  => _x('Filter 2', 'Taxonomy name plural', BORN_NAME),
		'post_types'   => ['product'],
		//'rewrite' => array('slug' => '%certificates_page%', 'with_front' => false),
		'public'       => false,
		'has_archive'         => false,
		//'rewrite'      => ['slug' => 'darbi', 'with_front' => false],
		'hierarchical' => true,
	])*/

/*	->addCpt('materials', [
		'name'                => _x('Material', 'Post type name', BORN_NAME),
		'supports'            => array('editor', 'thumbnail'),
		'public'              => false,
		'has_archive'         => false,
		'publicly_queryable'  => false,
		'exclude_from_search' => false,
		'show_in_rest'        => true,
		//'menu_icon'           => 'dashicons-pressthis',
		//'rewrite'             => ['slug' => '%news_page%', 'with_front' => false],
		//	'rewrite'             => ['slug' => 'publications', 'with_front' => false],
	] )*/

	/*->addCpt('certificates', [
		'name'                => _x('Certificate', 'Post type name', BORN_NAME),
		'supports'            => array('editor', 'thumbnail'),
		'public'              => true,
		'has_archive'         => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'show_in_rest'        => true,
		//'menu_icon'           => 'dashicons-pressthis',
		'rewrite'             => ['slug' => '%certificates_page%', 'with_front' => false],
		//	'rewrite'             => ['slug' => 'publications', 'with_front' => false],
	] )->addTax('certificates-category', [
		'name'         => _x('Certificate category', 'Taxonomy name', BORN_NAME),
		'plural_name'  => _x('Certificates categories', 'Taxonomy name plural', BORN_NAME),
		'post_types'   => ['certificates'],
		'public'       => true,
		'has_archive'         => true,
		'hierarchical' => false,
		'rewrite'      => ['slug' => '%animal_page%', 'with_front' => false],
	] )
*/

	/*->addCpt('certificates', [
		'name'                => _x('Certificate', 'Post type name', BORN_NAME),
		'plural_name'         => _x('Certificates', 'Post type name plural', BORN_NAME),
		'supports'            => [ 'editor','thumbnail'],
		'taxonomies'          => ['certificates-categories'],
		'has_archive' => true,
		//'rewrite'             => ['slug' => BORN_BLOG_SLUG, 'with_front' => false],
		// 'rewrite'             => ['slug' => 'darbi/%works_category%', 'with_front' => false],
		'rewrite' => array('slug' => '%certificates_page%', 'with_front' => false),
		'show_in_rest' => true,
		'public'              => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		//'menu_icon'           => 'dashicons-pressthis',
	])


	->addTax('certificates-categories', [
		'name'         => _x('Certificate categories', 'Taxonomy name', BORN_NAME),
		'plural_name'  => _x('Certificates categories', 'Taxonomy name plural', BORN_NAME),
		'post_types'   => ['certificates'],
		//'rewrite' => array('slug' => '%certificates_page%', 'with_front' => false),
		'public'       => false,
		'has_archive'         => false,
		//'rewrite'      => ['slug' => 'darbi', 'with_front' => false],
		'hierarchical' => true,
	])*/



	->register();
