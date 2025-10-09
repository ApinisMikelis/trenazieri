<?php if (!defined('WPINC')) die;

function born_get_theme_version()
{
	$theme = wp_get_theme();
	return $theme->get('Version');
}

function born_get_current_language_code()
{
	return defined('ICL_LANGUAGE_CODE') && !empty(ICL_LANGUAGE_CODE) ? ICL_LANGUAGE_CODE : preg_replace('/\_.+/', '', get_locale());
}

function born_get_languages()
{
	$languages = [];
	if (function_exists('icl_get_languages')) $languages = icl_get_languages('skip_missing=0');
	if (empty($languages)) {
		$lang_code = preg_replace('/\_.+/', '', get_locale());
		$languages[$lang_code] = ['translated_name' => $lang_code, 'code' => $lang_code];
	}

	return $languages;
}

function born_get_permalink_by_lang($page_id, $lang_code)
{
	$current_lang = born_get_current_language_code();
	if ($current_lang === $lang_code || !function_exists('icl_object_id')) return get_permalink($page_id);
	global $sitepress;
	$sitepress->switch_lang($lang_code, true);
	$default_permalink = get_the_permalink(apply_filters('wpml_object_id', $page_id, 'page', true, $lang_code));
	$sitepress->switch_lang($current_lang, true);
	return apply_filters('wpml_permalink', $default_permalink, $lang_code, true);
}

function born_get_select_post_lists_by_lang($post_type, $languages)
{
	global $sitepress;
	$current_lang = born_get_current_language_code();

	if(empty($post_type)) {
		$post_type = 'post';
	}

	$posts_args = [
		'post_type' => $post_type,
		'posts_per_page' => -1,
		'suppress_filters' => false,
		'post_status' => 'publish',
	];

	$posts_by_languages = [];

	if (!function_exists('icl_object_id')) {
		$posts_by_languages[$languages[0]['code']] = get_posts($posts_args);
	} else {
		foreach ($languages as $lang) {
			if ($current_lang == $lang['code']) {
				$posts_by_languages[$lang['code']] = get_posts($posts_args);
			} else {
				$sitepress->switch_lang($lang['code'], true);
				$posts_by_languages[$lang['code']] = get_posts($posts_args);
				$sitepress->switch_lang($current_lang, true);
			}
		}
	}


	$lists_by_languages = [];

	foreach ($posts_by_languages as $lang_code => $posts) {
		$lists_by_languages[$lang_code] = [-1 => ' - '];

		foreach ($posts as $p) {
			$lists_by_languages[$lang_code][$p->ID] = $p->post_title;
		}
	}

	return $lists_by_languages;
}

function born_get_archive_pagination($post_type, $category = 0, $current = 1, $max_num_pages = 0,$baseurl = '') {
	global $sitepress;

	$base = '/';
	if(defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != $sitepress->get_default_language()){
		$base .= ICL_LANGUAGE_CODE . '/';
	}

	$base = $baseurl;





	$pagination_args = array(
//		'base' => $lang .'/'.$archive_slug.'/'.$category_slug.'page/%#%/',
		'base' => $base . '/page/%#%',
		'current' => max( $current, get_query_var('paged') ),
		'format' => '%#%',
		'type' => 'array',
		// 'total' => $max_num_pages,
		'prev_next' => false,
//		'prev_text' => '<svg width="10px" height="18px"><path fill-rule="evenodd" fill="rgb(0, 117, 101)" d="M9.489,3.101 L3.746,8.844 L9.489,14.586 C10.075,15.172 10.075,16.122 9.489,16.708 C8.903,17.294 7.954,17.294 7.368,16.708 L0.761,10.101 C0.417,9.757 0.300,9.291 0.360,8.844 C0.300,8.396 0.417,7.930 0.761,7.586 L7.368,0.980 C7.954,0.394 8.903,0.394 9.489,0.980 C10.075,1.566 10.075,2.515 9.489,3.101 Z" /></svg><svg width="6px" height="6px"><path fill-rule="evenodd" fill="rgb(0, 117, 101)" d="M3.125,0.344 C4.506,0.344 5.625,1.463 5.625,2.844 C5.625,4.224 4.506,5.344 3.125,5.344 C1.744,5.344 0.625,4.224 0.625,2.844 C0.625,1.463 1.744,0.344 3.125,0.344 Z" /></svg>',
//		'next_text' => '<svg width="6px" height="6px"><path fill-rule="evenodd" fill="rgb(0, 117, 101)" d="M3.125,0.344 C4.506,0.344 5.625,1.463 5.625,2.844 C5.625,4.224 4.506,5.344 3.125,5.344 C1.744,5.344 0.625,4.224 0.625,2.844 C0.625,1.463 1.744,0.344 3.125,0.344 Z" /></svg><svg width="10px" height="18px"><path fill-rule="evenodd" fill="rgb(0, 117, 101)" d="M9.239,10.101 L2.632,16.708 C2.047,17.294 1.097,17.294 0.511,16.708 C-0.075,16.122 -0.075,15.172 0.511,14.586 L6.254,8.844 L0.511,3.101 C-0.075,2.515 -0.075,1.566 0.511,0.980 C1.097,0.394 2.047,0.394 2.632,0.980 L9.239,7.586 C9.583,7.930 9.700,8.396 9.640,8.844 C9.700,9.291 9.583,9.757 9.239,10.101 Z" /></svg>'
	);


	// AJAX request
	if($max_num_pages) $pagination_args['total'] = $max_num_pages;

	$pagination = paginate_links( $pagination_args ) ;

	//print_r($pagination);

	$return = '';

	if( !empty($pagination) ) {

		// $return .= '<div class="arm-pagination">';

		/* foreach($pagination as $index => $page_link) {
				 if( false !== strpos($page_link, ' dots') ) $pagination[$index] = '<span class="separator"></span>';


			}*/
		foreach ($pagination as $key => $page) {
			// if($page === '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>') {
			// $pagination[$key] = '<li class="separator">/</li>';
			// } else {
			$pagination[$key] =  '<li>'.$page.'</li>' ;
			//  }
		}

		$return .= implode("\n", $pagination);
		// $return .= '</div>';
	}

	return $return;
}

function born_get_blog_pagination($category = 0, $current = 1, $max_num_pages = 0)
{
	global $sitepress, $wp_query;

	$blog_id = get_option('page_for_posts');
	$blog_page = get_post($blog_id);

	$category_slug = '';
	if (!empty($category)) {
		if (is_int($category)) {
			$term = get_category($category);
			if (!empty($term) && !isset($term->errors)) $category_slug = $term->slug . '/';
		} else {
			$category_slug = $category . '/';
		}
	}

	$lang = '';
	if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != $sitepress->get_default_language()) {
		$lang = '/' . ICL_LANGUAGE_CODE;
	}

	$base = $lang . '/' . $blog_page->post_name . '/' . $category_slug . 'page/%#%/';

	$pagination_args = array(
		'base' => $base,
		'current' => max($current, get_query_var('paged')),
		'type' => 'array',
		'prev_next' => false,
		//	'prev_text' => '<svg width="14px" height="24px"><path d="M13.364,21.950 L11.950,23.364 L0.636,12.050 L0.686,12.000 L0.636,11.950 L11.950,0.636 L13.364,2.050 L3.414,12.000 L13.364,21.950 Z"></path></svg>',
//		'next_text' => '<svg width="14px" height="24px"><path d="M13.364,12.050 L2.050,23.364 L0.636,21.950 L10.586,12.000 L0.636,2.050 L2.050,0.636 L13.364,11.950 L13.314,12.000 L13.364,12.050 Z"></path></svg>'
	);

	// AJAX request
	if ($max_num_pages) $pagination_args['total'] = $max_num_pages;

	$pagination = paginate_links($pagination_args);

	$return = '';

	if (!empty($pagination)) {

		foreach ($pagination as $key => $page) {
			// if($page === '<span class="page-numbers dots">' . __( '&hellip;' ) . '</span>') {
			// $pagination[$key] = '<li class="separator">/</li>';
			// } else {
			$pagination[$key] = $page;
			//  }
		}


		// $return .= "<ul>\n\t";
		$return .= join("\n\t", $pagination);
		// $return .= "\n</ul>";
	}

	return $return;
}


function born_get_language_switcher($echo = true, $type = 'dropdown')
{
	$languages = [];
	if (function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=1');
	}
	
	//die(print_r($languages));
	
	if (count($languages) < 2) return;
	
	$active_lang = '';
	/*	foreach ($languages as $l) {
			 if ($l['active']) {
				 $active_lang = $l;
			 }
		 }*/
	
	ob_start();
	?>
	
	
	<?php foreach ($languages as $l):
	if ($l['active']){
		continue;
	}
	//$lang_code = born_get_current_language_code();
	/* if (strpos($l['url'], '%certificates_page%') !== false) {
	  $cert_slug = get_global_option('certificates_slug_'.$l['language_code']);
	  $l['url'] = str_replace('%certificates_page%',$cert_slug,$l['url']);
  }
  if (strpos($l['url'], '%news_page%') !== false) {
	  $news_slug = get_global_option('news_slug_'.$l['language_code']);
	  $l['url'] = str_replace('%news_page%',$news_slug,$l['url']);
  }*/
	?>
    <a href="<?= $l['url']; ?>"><?php echo ucfirst($l['code']);?></a>
<?php endforeach; ?>
	
	
	<?php
	$html_content = ob_get_contents();
	ob_end_clean();
	
	if ($echo) {
		echo $html_content;
	} else {
		return $html_content;
	}
}


function born_get_language_switcher_popup($echo = true, $type = 'dropdown')
{
    $languages = [];
    if (function_exists('icl_get_languages')) {
        $languages = icl_get_languages('skip_missing=1');
    }
    
    //die(print_r($languages));
    
    if (count($languages) < 2) return;
    
    $active_lang = '';
    /*	foreach ($languages as $l) {
              if ($l['active']) {
                  $active_lang = $l;
              }
          }*/
    
    ob_start();
    ?>
    
    
    <?php foreach ($languages as $l):
   /* if ($l['active']){
        continue;
    }*/
    //$lang_code = born_get_current_language_code();
    /* if (strpos($l['url'], '%certificates_page%') !== false) {
        $cert_slug = get_global_option('certificates_slug_'.$l['language_code']);
        $l['url'] = str_replace('%certificates_page%',$cert_slug,$l['url']);
    }
    if (strpos($l['url'], '%news_page%') !== false) {
        $news_slug = get_global_option('news_slug_'.$l['language_code']);
        $l['url'] = str_replace('%news_page%',$news_slug,$l['url']);
    }*/
    ?>
   
   <?php if ($l['code'] != 'en'):?>
    <li class="<?php echo $l['code'];?>"><a href="<?= $l['url']; ?>"><span><?= $l['native_name'];?></span></a></li>
   <?php endif;?>
   
<?php endforeach; ?>
	<?php foreach ($languages as $l):?>
   
    <?php if ($l['code'] == 'en'):?>
        <li class="ww"><a href="<?= $l['url']; ?>"><span>World Wide (English)</span></a></li>
      <?php endif;?>
   
   <?php endforeach;?>
    
    
    
    <?php
    $html_content = ob_get_contents();
    ob_end_clean();
    
    if ($echo) {
        echo $html_content;
    } else {
        return $html_content;
    }
}

function born_get_social_networks()
{
	return array(
		'facebook-f' => 'Facebook',
		'instagram' => 'Instagram',
//		'linkedin-in' => 'LinkedIn',
//		'twitter' => 'Twitter',
//		'youtube' => 'YouTube',
	);
}

function born_get_products_breadcrumbs()
{
	$breadcrumbs = '';

	global $BORN_FRAMEWORK;
	$template_id = $BORN_FRAMEWORK->Helpers->get_template_page('product', false);
	$template_page = get_post($template_id);
	$breadcrumbs .= "<a href=" . get_permalink($template_page->ID) . ">" . $template_page->post_title . "</a>";

	$current = '';

	if (is_tax('resource-category')) {
		$breadcrumbs .= '<a href="' . get_term_link(get_queried_object_id()) . '">' . get_queried_object()->name . '</a>';
	} else {
		$current = '<a href="' . get_post_permalink(get_queried_object_id()) . '">' . get_the_title() . '</a>';

		$categories = get_terms('resource-category', 'orderby=count&hide_empty=0');
		if (!empty($categories) && is_array($categories) && isset($categories[0]->slug)) {

			$breadcrumbs .= "<a href=" . get_term_link($categories[0]->slug, 'resource-category') . ">" . $categories[0]->name . "</a>";
		}
	}

	$breadcrumbs .= $current;

	return $breadcrumbs;
}

function born_get_blog_category_breadcrumbs()
{
	$breadcrumbs = '';

	$current = '<a href="' . get_term_link(get_queried_object_id()) . '">' . get_cat_name(get_queried_object_id()) . '</a>';

	$template_page = get_post(get_option('page_for_posts'));

	$breadcrumbs .= "<a href=" . get_permalink($template_page->ID) . ">" . $template_page->post_title . "</a>";

	$breadcrumbs .= $current;

	return $breadcrumbs;
}

/**
 * Get favicon from Options and render it
 */
function born_render_favicon()
{
	global $BORN_FRAMEWORK;
	$favicon = $BORN_FRAMEWORK->Options->Get('favicon');

	if ($favicon && is_array($favicon) && $favicon['url']): ?>
       <link rel="shortcut icon" href="<?php echo $favicon['url']; ?>"/>
	<?php endif;
}

/**
 * Get image url
 */
function born_image_url($image)
{
	return BORN_IMAGES . '/' . $image;
}

/**
 * Render menu
 *
 * @param $args
 *
 * @return false|string|void
 */
function born_render_menu($args)
{
	if (!isset($args['echo'])) {
		$args['echo'] = false;
	}

	if (!isset($args['items_wrap'])) {
		$args['items_wrap'] = '<ul>%3$s</ul>';
	}

	if (!isset($args['container'])) {
		$args['container'] = '';
	}

	/*if (isset($args['menu'])) {
		$args['menu'] = $args['menu'];
	}*/

	if (isset($args['walker'])) {
		$args['walker'] = new $args['walker']();
	}

	return wp_nav_menu($args);
}

/**
 * Render post content
 *
 * @param $post_id
 * @return string
 */
function born_render_post_content($post_id)
{
	$post_id = (int)$post_id;
	if ($post_id < 1) return '';

	$post = get_post($post_id);

	return !empty($post) ? do_shortcode($post->post_content) : '';
}

/**
 * Parse VC attachment id and return image with size
 *
 * @param $link
 *
 * @return string
 */
function born_acf_image($attachment_id, $size, $html = false, $css_class = null, $extra_atts = null)
{

	$src = wp_get_attachment_image_url($attachment_id, $size);

	if (!$html || !$src) return $src ? $src : '';

	$alt = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
	$class = !empty($css_class) ? ' class="' . $css_class . '"' : '';
	$atts = !empty($extra_atts) && is_string($extra_atts) ? ' ' . $extra_atts : '';


	return '<img src="' . $src . '" alt="' . $alt . '"' . $class . $atts . '>';
}

function born_img_alt($attachment_id)
{
    
    $alt = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
    
    return $alt;
}

/**
 * Parse VC attachment id and return image with size
 *
 * @param $link
 *
 * @return string
 */
function born_vc_image_list($ids, $size, $html = false, $css_class = null)
{

	$explode = explode(',', $ids);
	$arr = [];

	foreach ($explode as $image) {
		$arr[] = born_vc_image($image, $size, $html, $css_class);
	}

	return $arr;

}

/**
 * Parse VC attachment id and return image with size
 *
 * @param $link
 *
 * @return string
 */
function born_vc_image($attachment_id, $size, $html = false, $css_class = null, $extra_atts = null)
{

	$src = wp_get_attachment_image_url($attachment_id, $size);

	if (!$html || !$src) return $src ? $src : '';

	$alt = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
	$class = !empty($css_class) ? ' class="' . $css_class . '"' : '';
	$atts = !empty($extra_atts) && is_string($extra_atts) ? ' ' . $extra_atts : '';


	return '<img src="' . $src . '" alt="' . $alt . '"' . $class . $atts .'>';
}

/**
 * Parse VC link and return link title
 *
 * @param $link
 *
 * @return string
 */
function born_vc_link_title($link)
{

	if (empty($link)) return '';

	$link = vc_build_link($link);
	return $link['title'];
}

/**
 * Parse VC link and return link, target, rel as html
 *
 * @param $link
 *
 * @return string
 */
function born_acf_link($link)
{

	if (empty($link)) return '';

	return 'href="' . $link['url'] . '" target="' . $link['target'] . '" title="' . $link['title'] . '"';
}


/**
 * Acquire ninja forms
 *
 * @return array
 */
function born_get_ninja_forms()
{
	$ninja_forms = array(-1 => ' - ');
	include_once(ABSPATH . 'wp-admin/includes/plugin.php'); // Require plugin.php to use is_plugin_active() below
	if (is_plugin_active('ninja-forms/ninja-forms.php') && defined('NINJA_FORMS_DIR') && function_exists('ninja_forms_get_all_forms')) {
		$ninja_forms_data = ninja_forms_get_all_forms();
		if (!empty($ninja_forms_data)) {
			foreach ($ninja_forms_data as $key => $value) {
				if (is_array($value)) {
					$ninja_forms[$value['id']] = $value['name'];
				}
			}
		}
	}
	return $ninja_forms;
}

/**
 * Parse VC color and return valid CSS color
 *
 * @param $color
 *
 * @return string
 */
function born_vc_color($color)
{
	return !empty($color) ? $color : 'transparent';
}

/**
 * Parse VC content, strip unnecessary paragraph tags
 *
 * @param $content
 *
 * @return string
 */
function born_vc_content($content)
{
	// strip unnecessary p closing tag at the beginning of the content
	$content = preg_replace('/^(<\/p>)/', '', $content);
	// strip unnecessary p opening tag at the end of the content
	$content = preg_replace('/(<p>)$/', '', $content);

	return wpautop($content);
}

/**
 * Acquire taxonomy term list intended for select
 *
 * @param $taxonomy
 * @return array
 */
function born_get_select_term_list($taxonomy)
{
	$terms = get_terms(array(
		'taxonomy' => $taxonomy,
	));

	$list = [-1 => ' - '];

	if (!empty($terms) && !is_wp_error($terms)) {
		foreach ($terms as $t) {
			$list[$t->term_id] = $t->name;
		}
	}

	return $list;
}

function born_get_select_term_list_cat($taxonomy)
{
	$terms = get_terms(array(
		'taxonomy' => $taxonomy,
	));

	if (!empty($terms) && !is_wp_error($terms)) {
		foreach ($terms as $t) {
			// print_r($t);
			$list[$t->term_id] = $t->name;
		}
	}

	return $list;
}

/**
 * Acquire post list intended for select
 *
 * @param $post_type
 * @param string $post_status
 * @return array
 */
function born_get_select_post_list($post_type, $all_languages = false, $post_status = 'publish')
{
	$all_posts = get_posts([
		'post_type' => $post_type,
		'posts_per_page' => -1,
		'suppress_filters' => $all_languages,
		'post_status' => $post_status,
	]);

	$list = [-1 => ' - '];

	foreach ($all_posts as $p) {
		$list[$p->ID] = $p->post_title;
	}

	return $list;
}

/**
 * @param string $action
 * @return mixed
 */
function born_get_nonce_field($action = 'form-id')
{
	return wp_nonce_field($action, 'born_form_string', false, false);
}

/**
 * validate nonce field in GET, POST request
 *
 * @param $form_data
 * @param string $action
 * @return bool
 */
function born_validate_nonce_field($form_data, $action = 'form-id')
{
	if (empty($form_data)) return false;

	if (!isset($form_data['born_form_string']) || (isset($form_data['born_form_string']) && !wp_verify_nonce($form_data['born_form_string'], $action))) return false;

	return true;
}

/**
 * Retrieve Redux options for archives
 *
 * @param $post_type
 * @return array
 */
function born_get_archive_options($post_type)
{
	global $BORN_FRAMEWORK;
	$lang_code = born_get_current_language_code();

	$slug = $BORN_FRAMEWORK->Options->Get($post_type . '_archive_slug_' . $lang_code);
	$slug = !empty($slug) ? sanitize_title($slug) : $post_type;

	return array(
		'slug' => $slug,
		'title' => $BORN_FRAMEWORK->Options->Get($post_type . '_archive_title_' . $lang_code),
		'notes' => $BORN_FRAMEWORK->Options->Get($post_type . '_archive_notes_' . $lang_code),
		'pdf' => $BORN_FRAMEWORK->Options->Get($post_type . '_archive_pdf_' . $lang_code),
		'pdf_text' => $BORN_FRAMEWORK->Options->Get($post_type . '_archive_pdf_text_' . $lang_code),
		'archive_background_image' => $BORN_FRAMEWORK->Options->Get($post_type . '_archive_header_background_image'),
	);
}

/**
 * Retrieve Redux options for archives
 *
 * @param $post_type
 */
function born_get_archive_permalink($post_type)
{

	$lang_code = born_get_current_language_code();

	$default_lang = apply_filters('wpml_default_language', NULL );
	if ($default_lang == $lang_code){
		$base = get_home_url() . '/';
	}else{
		$base = get_home_url();
	}


	$slug = get_global_option($post_type.'_slug_'.$lang_code, 'options');
	//$slug = get_field($post_type.'_slug_'.$lang_code, 'options');
	$slug = !empty($slug) ? sanitize_title($slug) : $post_type;

	$permalink = $base . $slug;

	return $permalink;
}

/**
 * Retrieve Redux option for archive slug
 *
 * @param $post_type
 * @param null $lang_code
 * @return string
 */
function born_get_archive_slug($post_type, $lang_code = null)
{
	global $BORN_FRAMEWORK;
	$lang_code = $lang_code ?? born_get_current_language_code();
	$slug = $BORN_FRAMEWORK->Options->Get($post_type . '_archive_slug_' . $lang_code);
	$slug = !empty($slug) ? sanitize_title($slug) : $post_type;
	return $slug;
}

/**
 * Retrieve Redux option for archive title
 *
 * @param $post_type
 * @param null $lang_code
 * @return string
 */
function born_get_archive_title($post_type, $lang_code = null)
{
	global $BORN_FRAMEWORK;
	$lang_code = $lang_code ?? born_get_current_language_code();
	$title = $BORN_FRAMEWORK->Options->Get($post_type . '_archive_title_' . $lang_code);
	return $title;
}

function born_get_archive_filter_names($post_type, $taxonomy_base, $count, $fallback_base, $lang_code = null)
{
	global $BORN_FRAMEWORK;
	$lang_code = $lang_code ?? born_get_current_language_code();

	$names_array = [];

	// filter option handle example: quicklink_archive_quicklink-filter-1_name_en
	for ($i = 1; $i <= $count; $i++) {
		$filter_name = $BORN_FRAMEWORK->Options->Get($post_type . '_archive_' . $taxonomy_base . $i . '_' . 'name_' . $lang_code);

		$names_array[$i] = $filter_name ?: $fallback_base . ' ' . $i;
	}

	return $names_array;
}

/**
 * acquire share button JavaScript for sharing functionality
 *
 * @param $post_id
 * @return false|string
 */
function born_get_share_js($post_id)
{
	$post_id = (int)$post_id;

	ob_start();
	?>
    <script>
        document.getElementById('born-fb-share').addEventListener('click', function (e) {
            e.preventDefault();
            window.open("https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink($post_id)); ?>", "pop", "width=600, height=400, scrollbars=no");
        });
        document.getElementById('born-tw-share').addEventListener('click', function (e) {
            e.preventDefault();
            window.open("https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink($post_id)); ?>", "pop", "width=600, height=400, scrollbars=no");
        });
        document.getElementById('born-li-share').addEventListener('click', function () {
            window.open("https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink($post_id)); ?>&title=<?php echo urlencode(get_the_title($post_id)); ?>", "pop", "width=600, height=400, scrollbars=no");
            return false;
        });
    </script>
	<?php
	$js = ob_get_contents();
	ob_end_clean();

	return $js;
}

/**
 * convert any youtube link to embed link
 *
 * @param $video_url
 * @return string
 */
function born_convert_youtube($video_url)
{
	return preg_replace(
		"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
		"https://www.youtube.com/embed/$2",
		$video_url
	);
}

/**
 * acquire primary or first taxonomy
 *
 * @param $post_id
 * @param string $taxonomy
 * @return int|false
 */
function born_get_post_term($post_id, $taxonomy = 'category')
{
	$yoast_primary_meta = '_yoast_wpseo_primary_' . $taxonomy;

	$primary_category = get_post_meta($post_id, $yoast_primary_meta, true);

	if (!empty($primary_category)) {
		$category_term = get_term($primary_category, $taxonomy);

		if (!empty($category_term) && !isset($category_term->errors))
			return $category_term;
		else
			return false;
	} else {
		$category_terms = get_the_terms($post_id, $taxonomy);

		if (!empty($category_terms) && !isset($category_terms->errors))
			return $category_terms[0];
		else
			return false;
	}
}

/**
 * acquire posts by taxonomy slug
 *
 * @param string $type
 * @param string $taxonomy
 * @param int $term_id
 * @param int $paged
 * @param null $posts_per_page
 * @param bool $set_query_var
 * @param array $exclude
 * @return array|false
 */
function born_get_term_posts($type = 'post', $taxonomy = 'category', $term_id = 0, $paged = 1, $posts_per_page = null, $set_query_var = false, $exclude = array())
{
	// prepare tax query if category selected
	$tax_query = array();
	if ($term_id > 0) {
		$tax_query = array(
			array(
				'taxonomy' => $taxonomy,
				'field' => 'term_id',
				'terms' => array($term_id)
			)
		);
	}

	$posts_query = array(
		'post_type' => $type,
		'post__not_in' => $exclude,
		'paged' => $paged,
		'tax_query' => $tax_query,
	);

	// override default posts per page
	if (!empty($posts_per_page)) $posts_query['posts_per_page'] = $posts_per_page;

	$category_posts = new WP_Query($posts_query);

	if (!$category_posts->have_posts()) {
		return false;
	} else {
		if ($set_query_var) set_query_var('born_vc_' . $type . '_pages', $category_posts->max_num_pages);

		return $category_posts;
	}

	return $return;
}

/**
 * Validate language code, return corresponding MailChimp list ID
 *
 * @param $lang_code
 * @return bool
 */
function born_get_mailchimp_list_id($lang_code)
{
	if (empty($lang_code)) return false;

	$lang_available = false;

	foreach (born_get_languages() as $lang) {
		if ($lang['code'] === $lang_code) {
			$lang_available = true;
			break;
		}
	}

	if (!$lang_available) return false;

	global $BORN_FRAMEWORK;
	return $BORN_FRAMEWORK->Options->Get('mc_list_id_' . $lang_code);
}

function born_do_mailchimp_subscription($api_key, $list_id, $member, $status = 'pending')
{
	if (empty($api_key) || empty($list_id) || empty($member)) return false;

	$member_data = array();
	if (!empty($member) && is_array($member)) {
		$member_data = [
			'email_address' => $member['email'],
			'merge_fields' => [
				'FNAME' => $member['name'],
				'LNAME' => $member['surname']
			],
			'status' => $status,
		];
	}

	try {
		$mailchimp = new \DrewM\MailChimp\MailChimp($api_key);
		return $mailchimp->post("lists/$list_id/members", $member_data);
	} catch (\Exception $e) {
		/** @noinspection ForgottenDebugOutputInspection */
		error_log(
			'[ERROR] ' . $e->getMessage() . ' \nEncountered at ' . $e->getFile() . ':' . $e->getLine() .
			'\nTRACE:\n' . $e->getTraceAsString()
			, 0
		);
	}

	return false;
}

function born_get_vc_spacing_tab($args = array())
{
	$defaults = array(
		'direction' => 'top',
		'options' => array(
			'None' => 'none',
			'Micro' => 'micro',
			'Very small' => 'verysmall',
			'Small' => 'small',
			'Medium' => 'medium',
			'Big' => 'big',
			'Very big' => 'verybig',
		),
		'default' => 'none',
	);

	extract(
		wp_parse_args(
			$args,
			$defaults
		)
	);

	return array(
		'group' => 'Spacing',
		'type' => 'dropdown',
		'heading' => ucfirst($direction),
		'param_name' => 'born_margin_' . $direction,
		'value' => $options,
		'std' => array_search($default, $options) ? $default : reset($array),
	);
}

function born_vc_spacing(&$atts, $directions_defaults = array('top' => 'none', 'bottom' => 'none'))
{
	if (empty($directions_defaults)) return '';

	$classes = array();

	$param_prefix = 'born_margin_';
	$class_prefix = 'born-m';

	foreach ($directions_defaults as $direction => $default) {
		if (isset($atts[$param_prefix . $direction]))
			$classes[] = $class_prefix . substr($direction, 0, 1) . '-' . esc_attr($atts[$param_prefix . $direction]);
		else
			$classes[] = $class_prefix . substr($direction, 0, 1) . '-' . $default;
	}

	return implode(' ', $classes);
}

function born_add_localize_script($variable_name, $localize_data)
{
	global $wp_scripts;
	$data = $wp_scripts->get_data(BORN_NAME, 'data');

	if (empty($data)) {
		wp_localize_script(BORN_NAME, 'bornTheme', array($variable_name => $localize_data));
	} else {
		if (!is_array($data)) {
			$data = json_decode(str_replace('var bornTheme = ', '', substr($data, 0, -1)), true);
		}

		$data[$variable_name] = $localize_data;

		$wp_scripts->add_data(BORN_NAME, 'data', '');
		wp_localize_script(BORN_NAME, 'bornTheme', $data);
	}
}

function born_tag_text_between_asterisk($text, $open_tag = '<span>', $close_tag = '</span>')
{
	return preg_replace('/\*([^\*]*)\*/', $open_tag . '$1' . $close_tag, $text);
}

function born_time_ago()
{
//	return human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ).' '.__( 'ago' );
	return sprintf(_x('Pirms %s', 'Time format', BORN_NAME), human_time_diff(get_the_time('U'), current_time('timestamp')));
}

function born_get_posts_list_vc($post_type, $post_status = 'publish')
{
	$all_posts = get_posts([
		'post_type' => $post_type,
		'posts_per_page' => -1,
		'post_status' => $post_status,
		'suppress_filters' => false
	]);

	$list = [' - ' => -1];

	foreach ($all_posts as $p) {
		$list[$p->post_title] = $p->ID;
	}

	return $list;
}

function born_get_pagination($current = 1, $max_num_pages = 0)
{
	global $wp_query;

	$pagination = paginate_links([
		'base'      => get_pagenum_link(1) . '%_%',
		'format'    => '/page/%#%',
		'current'   => $current,
		'total'     => $max_num_pages,
		'prev_next' => false,
		'type'      => 'array'
	]);

	if (!empty($pagination)) {
		$return = '<ul class="born-reset">';

		foreach($pagination as $value) {
			$return .= '<li>'.$value.'</li>';
		}

		return $return . '</ul>';
	}

	return '';
}

/**
 * Parse VC link and return link, target, rel as html
 *
 * @param $link
 *
 * @return string
 */
function born_vc_link($link)
{

	if (empty($link)) return '';

	$link = vc_build_link($link);

	return 'href="' . $link['url'] . '" target="' . $link['target'] . '" rel="' . $link['rel'] . '"';

}

function born_generate_random_string($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}



/** acf spacing */

function born_acf_spacing_top($default){
	if (get_field('margin_top')){
		return get_field('margin_top');
	}else{
		return $default;
	}
}

function born_acf_spacing_bottom($default){
	if (get_field('margin_bottom')){
		return get_field('margin_bottom');
	}else{
		return $default;
	}
}

function born_acf_spacing_top_mobile($default){
	if (get_field('margin_top')){
		return get_field('margin_top');
	}else{
		return $default;
	}
}

function born_acf_spacing_bottom_mobile($default){
	if (get_field('margin_bottom_mobile')){
		return get_field('margin_bottom_mobile');
	}else{
		return $default;
	}
}


function born_translation($field_name){
    $t = get_field($field_name,'options');
    if(empty($t)){
	    return $field_name;
    }
	return $t;
}


function generate_archive_tax_link($tax,$post_type)
{


	$slug = get_home_url() . '/' . get_field($post_type.'_slug','options') . '/' . $tax->slug;


	return $slug;
}


function generate_archive_link($post_type)
{


	$slug = get_home_url() . '/' . get_field($post_type.'_slug','options');


	return $slug;
}

function born_get_page_breadcrumbs($page_id) {
	$page = get_post($page_id);

	if ($page->post_parent) {
		$parent_page = get_post($page->post_parent);

		$parent_pages = born_get_page_breadcrumbs($page->post_parent);

		$parent_pages[] = $parent_page;

		return $parent_pages;
	}

	return [];
}