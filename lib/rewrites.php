<?php

//use Born\CPTs\Municipality;
	
	if (!defined('WPINC')) {
		die;
	}
	
	/**
	 * Rewrites
	 */
	function born_change_links($post_link, $post = false, $leavename = false, $sample = false)
	{
		
		$is_term = false;
		if (isset($post->term_id)) {
			$is_term = true;
			$pID = $post->term_id;
		} else {
			$pID = $post->ID;
		}
		
		// archive slug
		$lang_code = born_get_current_language_code();
		
		if (false !== strpos($post_link, '%news_page%')) {
			$news_slug = get_field('news_slug_'.$lang_code, 'options');
			$post_link = str_replace('%news_page%', $news_slug, $post_link);
		}elseif (false !== strpos($post_link, '%portfolio_page%')) {
			$events_slug = get_field('portfolio_slug_'.$lang_code,'options');
			$post_link = str_replace('%portfolio_page%', $events_slug, $post_link);
		}
		
		if (false !== strpos($post_link, '%certificates_category%')) {
			$perma_cat = get_post_meta($post->ID, '_yoast_wpseo_primary_news-category', true);
			
			if ($perma_cat != null) {
				$category = get_term($perma_cat, 'certificates-categories');
			} else {
				$categories = get_the_terms($pID, 'certificates-categories');
				$category = $categories[0];
			}
			
			$event_type_term = $category;
			
			if ($event_type_term && is_object($event_type_term)) {
				$post_link = str_replace('%certificates_category%', $event_type_term->slug, $post_link);
			}
		}
		
		return $post_link;
	}
	add_filter('post_link', 'born_change_links', 10, 2);
	add_filter('post_type_link', 'born_change_links', 10, 2);
	add_filter('term_link', 'born_change_links', 10, 2);
	
	
	add_action('init', function () {
		
		/** START: Rewrites **/
		$languages = born_get_languages();
		foreach ($languages as $lang) {
			$news_slug = get_field('news_slug_'.$lang['code'], 'options');
			
			$portfolio = get_field('portfolio_slug_'.$lang['code'],'options');
			
			//	die($certificates_slug);
			
			add_rewrite_rule(
				'^' . $news_slug . '$',
				'index.php?post_type=news',
				'top'
			);
			
			// archive
			add_rewrite_rule(
				'^' . $news_slug . '\/$',
				'index.php?post_type=news',
				'top'
			);
			
			// paginated archive
			add_rewrite_rule(
				'^' . $news_slug . '/page/([^/]*)$',
				'index.php?post_type=news&page=$matches[1]',
				'top'
			);
			
			// single
			add_rewrite_rule(
				'^' . $news_slug . '/([^/]*)$',
				'index.php?news=$matches[1]',
				'top'
			);
			
			
			/** certificates **/
			
			add_rewrite_rule(
				'^' . $portfolio . '$',
				'index.php?post_type=portfolio',
				'top'
			);
			
			// archive
			add_rewrite_rule(
				'^' . $portfolio . '\/$',
				'index.php?post_type=portfolio',
				'top'
			);
			
			// paginated archive
			add_rewrite_rule(
				'^' . $portfolio . '/page/([^/]*)$',
				'index.php?post_type=portfolio&page=$matches[1]',
				'top'
			);
			
			// single
			add_rewrite_rule(
				'^' . $portfolio . '/([^/]*)$',
				'index.php?portfolio=$matches[1]',
				'top'
			);
			
			// paginated archive
			/*add_rewrite_rule(
				'^' . $certificates_slug . '/page/([^/]*)$',
				'index.php?post_type=certificates&page=$matches[1]',
				'top'
			);
	
			// paginated category
			add_rewrite_rule(
				'^' . $certificates_slug . '/([^/]*)/page/([^/]*)$', // fix this
				'index.php?certificates-categories=$matches[1]&page=$matches[2]',
				'top'
			);*/
			
			// single
			
			/*
					// category
					add_rewrite_rule(
						'^' . $certificates_slug . '/([^/]*)$',
						'index.php?certificates-categories=$matches[1]',
						'top'
					);*/
			
			
			
			// END: Rewrite brands
		}
		
		
		// START: Rewrite Blog
		/*	$template_page = get_post(get_option('page_for_posts'));
			$pages = array();
			if( function_exists('icl_object_id') ) {
				global $sitepress;
				$trid = $sitepress->get_element_trid($template_page->ID);
				$translations = $sitepress->get_element_translations($trid);
		
				if (!empty($translations)) { // handle incomplete WPML setup
					foreach ($translations as $tr) {
						$pages[] = get_post($tr->element_id);
					}
				} else {
					$pages[] = $template_page;
				}
			} else {
				$pages[] = $template_page;
			}
		
			// START: Rewrite Blog
			foreach ($pages as $p) {
		
		
				/*add_rewrite_rule(
					'^' . $p->post_name . '/([^/]*)/?$',
					'index.php?name=$matches[1]',
					'top'
				);
		*/

//	}
		// END: Rewrite Blog
		
		
		/** END: Rewrites **/
		
		// START: Add/Remove post type support
		add_post_type_support( 'page', 'excerpt' );
//	remove_post_type_support( 'homepage', 'page_options' );
	}, 99999);
	
	
	/*function born_post_type_archive_rewrite($link, $post_type, $language_code = null){
		die($post_type);
		if( $post_type == 'publication' ) {
			die('gg');
			$resources_doctors_slug =  born_get_archive_slug('publication', $language_code);
			$link = str_replace('%publication_page%', $resources_doctors_slug, $link);
		}
	
		return $link;
	}*/
	
	function born_post_type_archive_rewrite($link, $post_type){
		if($post_type === 'news') {
			$product_slug =  get_field('news_slug_'.born_get_current_language_code());
			if ($product_slug){
				$link = str_replace('%news_page%', '/'.$product_slug, $link);
			}
			
		}elseif($post_type === 'certificates') {
			$product_slug =  born_get_archive_slug('certificates');
			$link = str_replace('%certificates_page%', '/'.$product_slug, $link);
		}
		return $link;
	}
	if (is_admin()){
		add_filter('post_type_archive_link', 'born_post_type_archive_rewrite', 2, 2);
	}
	
	
	
	if ( function_exists('icl_object_id') ) {
		// pass our custom post type slug to WPML
		//add_filter('wpml_get_translated_slug', 'born_post_type_archive_rewrite', 2, 2);
	} else {
		// when WPML is not active
//	add_filter('post_type_archive_link', 'born_post_type_archive_rewrite', 2, 2);
	}

