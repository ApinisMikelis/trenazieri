<?php

define('AUTOMATIC_UPDATER_DISABLED', true);

require 'vendor/autoload.php';
	
add_theme_support( 'woocommerce' );

function allow_svg_upload($mimes)
{
	$mimes['svg'] = 'image/svg';
	return $mimes;
}

add_filter('upload_mimes', 'allow_svg_upload');

function enqueue_custom_admin_styles( $hook ) {
  // Check to ensure we are only loading the CSS on the WooCommerce Products list screen
  // The screen ID for the products list is typically 'edit.php' with the 'post_type=product' query arg.
  if ( 'edit.php' !== $hook ) {
      return;
  }
  
  // Additional check for the correct post type
  if ( !isset( $_GET['post_type'] ) || $_GET['post_type'] !== 'product' ) {
      return;
  }

  // Enqueue the stylesheet from your theme's root directory
  wp_enqueue_style( 
      'custom_admin_css', 
      get_template_directory_uri() . '/admin-style.css', 
      array(), 
      wp_get_theme()->get('Version') 
  );
}
add_action( 'admin_enqueue_scripts', 'enqueue_custom_admin_styles' );


/**
 * Adds the Contentsquare UXA script to the <head> of the website.
 */
function my_custom_tracking_script() {
    // Check if the user is NOT logged into the WordPress dashboard
    // This is a common practice to exclude admin users from tracking data.
    if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
        ?>
        <script src="https://t.contentsquare.net/uxa/3c8df11e34731.js"></script>
        <?php
    }
}

add_action( 'wp_head', 'my_custom_tracking_script' );



// enqueue styles.css
add_action('wp_enqueue_scripts', 'enqueue_styles');
function enqueue_styles() {
  wp_enqueue_style('styles', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version'));
}

try {
	require_once __DIR__ . '/lib/constants.php';
	require_once __DIR__ . '/lib/helpers.php';
	global $BORN_FRAMEWORK;
	$BORN_FRAMEWORK = new \Born\Core\Framework('trenazieri', 'Trenazieri');
	require_once __DIR__ . '/lib/acf-archive-slugs.php';
	require_once __DIR__ . '/lib/rewrites.php';
	require_once __DIR__ . '/lib/cpts.php';

	require_once __DIR__ . '/lib/MenuFields/Menu.php';
	require_once __DIR__ . '/lib/Walkers/MainMenu.php';
	require_once __DIR__ . '/lib/Walkers/SlinkyMenu.php';
	require_once __DIR__ . '/lib/Walkers/MainMobileMenu.php';
	
	require_once __DIR__ . '/lib/assets.php';
	require_once __DIR__ . '/lib/acf.php';
	require_once __DIR__ . '/lib/acf-options.php';
	require_once __DIR__ . '/lib/Schemas.php';

	/**
	 * MENUS
	 */
	$BORN_FRAMEWORK->Menus->batchAdd([
		'top-menu-left'   => 'Top menu left',
        'top-menu-right'   => 'Top menu right',
		'main-menu'   => 'Main menu',
		'main-menu-mobile'   => 'Main menu mobile',
		'footer-menu-left'   => 'Footer menu left',
		'footer-menu-right'   => 'Footer menu right',
    'footer-categories-menu-1'   => 'Footer categories menu 1',
    'footer-categories-menu-2'   => 'Footer categories menu 2',
		
	])->register();

} catch (\Exception $e) {
	error_log(
		"[" . BORN_NAME_PRETTY . " ERROR] " .
		$e->getMessage() . " \nEncountered at " . $e->getFile() . ":" . $e->getLine() .
		"\nTRACE:\n" . $e->getTraceAsString()
		, 0
	);
	add_action('admin_notices', function () use ($e) {
		?>
       <div class="notice notice-error">
           <h3><?php printf(esc_html__('An error encountered while setting up %s theme:', BORN_NAME), BORN_NAME_PRETTY); ?></h3>
           <pre><?php echo $e->getMessage(); ?></pre>
       </div>
		<?php
	});
}

if (class_exists('Schemas')) {
    new Schemas();
}

add_theme_support( 'post-thumbnails' );
add_theme_support( 'wp-block-styles' );
add_theme_support( 'align-wide' );
add_theme_support( 'alignfull' );

add_image_size('intro-banners', 937, 750,array('center','center') );
add_image_size('intro-banners-x2', 1874, 1500,array('center','center') );
add_image_size('mega-banner', 666, 534,array('center','center') );
add_image_size('mega-banner-x2', 1332, 1068,array('center','center') );
add_image_size('mega-thumb', 142, 142,array('center','center') );

add_image_size('brand-slider', 340, 0 );

add_image_size('single-promo-banner', 800, 800,array('center','center') );
add_image_size('single-promo-banner-x2', 1600, 1600,array('center','center') );
	
add_image_size('brand-logo-small', 124, 46 );
add_image_size('tren_woocommerce_single',0,740);
	
add_image_size('tre-woo-gal-thumb', 104, 136,array('center','center') );
add_image_size('tre-woo-gal-thumb-x2', 208, 272,array('center','center') );

add_image_size('feature-block', 685, 476,array('center','center') );
add_image_size('feature-block-x2', 1370, 952,array('center','center') );


add_image_size('portfolio', 450, 325,array('center','center') );
add_image_size('portfolio-x2', 900, 650,array('center','center') );

add_image_size('contacts-icon', 75, 75 );

// Disable WordPress' automatic image scaling feature
add_filter( 'big_image_size_threshold', '__return_false' );

/** wordpress 6.+ fix */


remove_filter( 'render_block', 'wp_render_layout_support_flag', 10, 2 );

add_filter( 'render_block', function( $block_content, $block ) {
	if ( $block['blockName'] === 'core/columns' ) {
		return $block_content;
	}
	if ( $block['blockName'] === 'core/column' ) {
		return $block_content;
	}
	if ( $block['blockName'] === 'core/group' ) {
		return $block_content;
	}

	return wp_render_layout_support_flag( $block_content, $block );
}, 10, 2 );


// disable gutenberg frontend styles
function disable_gutenberg_wp_enqueue_scripts() {

	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');

}
add_filter('wp_enqueue_scripts', 'disable_gutenberg_wp_enqueue_scripts', 100);

function born_extract_youtube_id($url) {
	$pattern =
		'/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#\&\?]*).*/';
	preg_match($pattern, $url, $matches);
	return $matches[2];
}



function born_get_page_by_template($template) {
	return get_pages([
		'post_type' => 'page',
		'meta_key' => '_wp_page_template',
		'hierarchical' => 0,
		'meta_value' => $template
	]);
}

// Remove jQuery migrate

function remove_jquery_migrate( $scripts ) {
	if (!is_admin() && isset( $scripts->registered['jquery'])) {
		$script = $scripts->registered['jquery'];
		if ($script->deps) {
			// Check whether the script has any dependencies
			$script->deps = array_diff( $script->deps, array('jquery-migrate'));
		}
	}
}
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );

// autopull test 3






/**
 * Advanced Custom Fields Options function
 * Always fetch an Options field value from the default language
 */
function cl_acf_set_language() {
	return acf_get_setting('default_language');
}
function get_global_option($name) {
	add_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
	$option = get_field($name, 'options');
	remove_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
	return $option;
}

function disable_woo_commerce_sidebar() {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
}
	add_action('init', 'disable_woo_commerce_sidebar');
	
	

	
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
	
	
	
	
	
	
	
	// Register AJAX actions for logged-in and guest users
	add_action('wp_ajax_multi_add_to_cart', 'multi_ajax_add_to_cart');
	add_action('wp_ajax_nopriv_multi_add_to_cart', 'multi_ajax_add_to_cart');
	
	function multi_ajax_add_to_cart() {
		// Check if items are set in the POST request
		if (isset($_POST['items'])) {
			$item_keys = array(); // Array to store added cart item keys
			
			// Iterate over each item
			foreach ($_POST['items'] as $item) {
				if (isset($item['id'])) {
					// Determine quantity, defaulting to 1 if not set or less than 1
					$item_qty = isset($item['qty']) && $item['qty'] > 0 ? $item['qty'] : 1;
					
					// Add the item to the cart and store the cart item key
					$item_keys[] = WC()->cart->add_to_cart($item['id'], $item_qty);
				}
			}
			
			// Send back cart item keys as JSON response
			echo json_encode($item_keys);
		} else {
			echo json_encode(array('error' => 'No items found.'));
		}
		wp_die(); // Properly terminate the AJAX request
	}
	
	
	
	// Disable new WooCommerce product template (from Version 7.7.0)
	function bp_reset_product_template($post_type_args) {
		if (array_key_exists('template', $post_type_args)) {
			unset($post_type_args['template']);
		}
		return $post_type_args;
	}
	add_filter('woocommerce_register_post_type_product', 'bp_reset_product_template');

// Enable Gutenberg editor for WooCommerce
	function bp_activate_gutenberg_product($can_edit, $post_type) {
		if ($post_type == 'product') {
			$can_edit = true;
		}
		return $can_edit;
	}
	add_filter('use_block_editor_for_post_type', 'bp_activate_gutenberg_product', 10, 2);

// Enable taxonomy fields for woocommerce with gutenberg on
	function bp_enable_taxonomy_rest($args) {
		$args['show_in_rest'] = true;
		return $args;
	}
	add_filter('woocommerce_taxonomy_args_product_cat', 'bp_enable_taxonomy_rest');
	add_filter('woocommerce_taxonomy_args_product_tag', 'bp_enable_taxonomy_rest');
	
	
	
	
	add_filter('upload_mimes', function($mime_types) {
		$mime_types['gltf'] = 'model/gltf+json';
		$mime_types['glb'] = 'model/gltf-binary';
		$mime_types['dwg'] = 'image/vnd.dwg';
		$mime_types['stl'] = 'application/sla';
		$mime_types['stp'] = 'text/plain';
		$mime_types['step'] = 'text/plain';
		
		return $mime_types;
	});
	
	
	add_filter('wp_check_filetype_and_ext', function($data, $file, $filename, $mime_types, $real_mime_type) {
		if (empty($data['ext'])
			|| empty($data['type'])
		) {
			$file_type = wp_check_filetype($filename, $mime_types);
			
			if ('gltf' === $file_type['ext']) {
				$data['ext']  = 'gltf';
				$data['type'] = 'model/gltf+json';
			}
			
			if ('glb' === $file_type['ext']) {
				$data['ext']  = 'glb';
				$data['type'] = 'model/glb-binary';
			}
		}
		
		return $data;
	}, 10, 5);
	
	
	
	function fix_dwg_mime_type($data, $file, $filename, $mimes) {
		// Check if the file is a .dwg file by extension
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		if ($ext === 'dwg') {
			// Correct the MIME type and set the correct type
			$data['ext']  = 'dwg';
			$data['type'] = 'application/acad'; // Standard MIME for .dwg files
		}
		
		return $data;
	}
	add_filter('wp_check_filetype_and_ext', 'fix_dwg_mime_type', 10, 4);
	
	function customize_dwg_media_display($response, $attachment, $meta) {
		// Check if the file is a .dwg file
		if ($response['mime'] === 'image/vnd.dwg') {
			// Set the correct MIME type and ensure it's not treated as an image
			$response['type'] = 'file'; // Set type to 'file' instead of 'image'
			
			// Ensure the file has an appropriate icon
			$response['icon'] = '/wp-includes/images/media/default.png'; // Default icon or your custom icon
			
			// Set the filename if it's not already set
			if (empty($response['title'])) {
				$response['title'] = basename($attachment->guid);
			}
		}
		
		return $response;
	}
	add_filter('wp_prepare_attachment_for_js', 'customize_dwg_media_display', 10, 3);
	
	
	
	
	
	
	
	
	
	add_filter( 'woocommerce_checkout_fields', 'custom_remove_fields' );
	
	function custom_remove_fields( $fields ) {
		// Check if 'billing_municipality' field exists and remove it
		if ( isset( $fields['billing']['billing_state'] ) ) {
			unset( $fields['billing']['billing_state'] );
		}
		
		// Check if 'shipping_municipality' field exists and remove it
		if ( isset( $fields['shipping']['shipping_state'] ) ) {
			unset( $fields['shipping']['shipping_state'] );
		}
		 
		 if ( isset( $fields['shipping']['shipping_first_name'] ) ) {
			 unset( $fields['shipping']['shipping_first_name'] );
		 }
		 if ( isset( $fields['shipping']['shipping_last_name'] ) ) {
			 unset( $fields['shipping']['shipping_last_name'] );
		 }
		 if ( isset( $fields['shipping']['shipping_company'] ) ) {
			 unset( $fields['shipping']['shipping_company'] );
		 }
		 
		 unset($fields['billing']['billing_postcode']['validate']);
		 unset($fields['shipping']['shipping_postcode']['validate']);
		
		 unset( $fields['billing']['billing_city'] );
		 unset( $fields['billing']['billing_address_1'] );
		 unset( $fields['billing']['billing_address_2'] );
		 unset( $fields['billing']['billing_postcode'] );
	//	 unset( $fields['billing']['billing_country'] );
		
   
		 
		 $fields['billing']['billing_first_name']['priority'] = 1;
		 $fields['billing']['billing_last_name']['priority'] = 2;
		 $fields['billing']['billing_company']['priority'] = 7;
		 
		// $fields['billing']['billing_address_1']['priority'] = 8;
		// $fields['billing']['billing_address_2']['priority'] = 9;
		// $fields['billing']['billing_city']['priority'] = 10;
		// $fields['billing']['billing_postcode']['priority'] = 11;
		 $fields['billing']['billing_email']['priority'] = 5;
		 $fields['billing']['billing_phone']['priority'] = 6;
		 
		// $fields['billing']['billing_country']['priority'] = 99999;
		 
		 
		 $fields['shipping']['shipping_address_1']['priority'] = 1;
		 $fields['shipping']['shipping_address_2']['priority'] = 2;
		 $fields['shipping']['shipping_city']['priority'] = 3;
		 $fields['shipping']['shipping_postcode']['priority'] = 4;
		 $fields['shipping']['shipping_country']['priority'] = 99999;
		 
		
		return $fields;
	}

  
  /**
   * Display Born Courier address on Order Received and My Account pages
   */
  add_filter( 'woocommerce_order_get_formatted_shipping_address', 'display_born_courier_on_frontend', 10, 3 );

  function display_born_courier_on_frontend( $address, $raw_address, $order ) {
      $order_id = $order->get_id();
      
      // Pull the hidden Born Courier fields
      $born_address  = get_post_meta( $order_id, '_born_courier_address', true );
      $born_city     = get_post_meta( $order_id, '_born_courier_city', true );
      $born_postcode = get_post_meta( $order_id, '_born_courier_postcode', true );

      // If we have a Born Courier address, override the "Nav pieejams" default
      if ( ! empty( $born_address ) ) {
          $address = sprintf(
              '%s, %s, %s',
              esc_html( $born_address ),
              esc_html( $born_city ),
              esc_html( $born_postcode )
          );
      }

      return $address;
  }

	// Remove validation for missing fields
	add_filter( 'woocommerce_checkout_posted_data', 'custom_skip_validation', 10, 1 );
	function custom_skip_validation( $data ) {
		// Remove unnecessary fields from posted data
		unset( $data['billing_address_1'], $data['billing_address_2'], $data['billing_city'], $data['billing_state'], $data['billing_postcode'], $data['billing_country'] );
		unset( $data['shipping_address_1'], $data['shipping_address_2'], $data['shipping_city'], $data['shipping_state'], $data['shipping_postcode'], $data['shipping_country'] );
		
		return $data;
	}
	
	add_filter( 'woocommerce_after_checkout_validation', 'custom_disable_validation', 10, 2 );
	function custom_disable_validation( $data, $errors ) {
		// Prevent validation errors for removed fields
		$fields_to_ignore = [
			'billing_address_1',
			'billing_address_2',
			'billing_city',
			'billing_state',
			'billing_postcode',
			'billing_country',
			'shipping_address_1',
			'shipping_address_2',
			'shipping_city',
			'shipping_state',
			'shipping_postcode',
			'shipping_country',
		];
		
		foreach ( $fields_to_ignore as $field ) {
			if ( $errors->get_error_message( $field ) ) {
				$errors->remove( $field );
			}
		}
	}
	
	
	add_filter('woocommerce_default_address_fields', 'custom_default_address_fields', 20, 1);
	function custom_default_address_fields( $address_fields ){
		
		if( ! is_cart()){ // <== On cart page only
			// Change placeholder
			/*$address_fields['first_name']['placeholder'] = __( 'Fornavn', $domain );
			$address_fields['last_name']['placeholder']  = __( 'Efternavn', $domain );
			$address_fields['address_1']['placeholder']  = __( 'Adresse', $domain );
			$address_fields['state']['placeholder']      = __( 'Stat', $domain );
			$address_fields['postcode']['placeholder']   = __( 'Postnummer', $domain );
			$address_fields['city']['placeholder']       = __( 'By', $domain );*/
			
			// Change class
			//$address_fields['first_name']['class'] = array('form-row-first'); //  50%
		//	$address_fields['last_name']['class']  = array('form-row-last');  //  50%
		//	$address_fields['address_1']['class']  = array('form-row-wide');  // 100%
			$address_fields['country']['class']      = array('form-row-first');  // 100%
			$address_fields['postcode']['class']   = array('form-row-last'); //  50%
			$address_fields['city']['class']       = array('form-row-first');  //  50%
		}
		return $address_fields;
	}
	
	
	
	add_action( 'wp_footer', 'checkout_business_person' );
	
	function checkout_business_person() {
		if (is_checkout()) {
			?>
           <style>
              /* #billing_address_1_field{
                   display:none;
               }*/
           </style>
          <script type="text/javascript">

              function toggleFields() {
                  const isChecked = jQuery('#billing_business_person').is(':checked');

                  // List of fields to hide/show
                  const fields = [
                      '#billing_company_field',
                      '#billing_address_1_field',
                      '#billing_address_2_field',
                      '#billing_city_field',
                      '#billing_postcode_field',
                      '#billing_country_field',
                      '#billing_registration_number_field',
                      '#billing_vat_number_field'
                  ];

                  fields.forEach(function (field) {
                      if (isChecked) {
                  
                          jQuery(field).show();
                      } else {
                         
                          jQuery(field).hide();
                      }
                  });
                
              }

              setTimeout(function() {
                  toggleFields();
              }, 500);
              


           jQuery("#billing_business_person").bind('change', function(){

					let checked = this.checked;

               toggleFields();
                  
                  if (checked){
                      if (jQuery("#billing_company").attr('oldvalue') === '-'){
                          jQuery("#billing_company").val('');
                      }else{
                          jQuery("#billing_company").val(jQuery("#billing_company").attr('oldvalue'));
                      }

                      if (jQuery("#billing_address_1").attr('oldvalue') === '-'){
                          jQuery("#billing_address_1").val('');
                      }else{
                          jQuery("#billing_address_1").val(jQuery("#billing_address_1").attr('oldvalue'));
                      }

                      if (jQuery("#billing_city").attr('oldvalue') === '-'){
                          jQuery("#billing_city").val('');
                      }else{
                          jQuery("#billing_city").val(jQuery("#billing_city").attr('oldvalue'));
                      }

                      if (jQuery("#billing_postcode").attr('oldvalue') === '-'){
                          jQuery("#billing_postcode").val('');
                      }else{
                          jQuery("#billing_postcode").val(jQuery("#billing_postcode").attr('oldvalue'));
                      }

							 jQuery(".buyer-is-company-label").addClass('is-checked');

                  }else{

							jQuery(".buyer-is-company-label").removeClass('is-checked');

            

                      jQuery("#billing_company").attr('oldvalue', jQuery("#billing_company").val());
  

                      jQuery("#billing_company").val('-');
          

                      jQuery("#billing_address_1").attr('oldvalue', jQuery("#billing_address_1").val());
                      jQuery("#billing_address_1").val('-');

                      jQuery("#billing_city").attr('oldvalue', jQuery("#billing_city").val());
                      jQuery("#billing_city").val('-');

                      jQuery("#billing_postcode").attr('oldvalue', jQuery("#billing_postcode").val());
                      jQuery("#billing_postcode").val('-');

                  }
              });

          </script>
			<?php
		}
	}
	
	
	function ufloat_delivery_estimates() {
		$min_delivery_time = 0;
		$max_delivery_time = 0;
		$delivery_text = '';
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
			$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
			
			$prod_delivery_time = get_the_terms($cart_item['product_id'],'delivery-times');
   
			$delivery_time_in_days_min = get_field('days_from', $prod_delivery_time[0]);
			$delivery_time_in_days_max = get_field('days_to', $prod_delivery_time[0]);
            $text = get_field('frontend_text',$prod_delivery_time[0]);
            
            if ($max_delivery_time < $delivery_time_in_days_max){
	            $max_delivery_time = $delivery_time_in_days_max;
	            $delivery_text = $text;
            }
            
		}
		
		if (!empty($delivery_text)) {
			$html = '<div class="delivery">';
			$html .= get_field('frontend_text',$prod_delivery_time[0]);
			$html .= '</div>';
			
			return $html;
		}
		
		return '';
	}
	
	
	
	/**
	 *
	 *
	 * Adding megamenu
	 */
	
	add_action( 'init', function () {
		
		$mega_menus = get_posts( [ 'post_type' => 'frequent-blocks','posts_per_page' => -1, ] );
		$m_array    = [ null => 'None' ];
		
		
		foreach ( $mega_menus as $m ) {
			$m_array[ $m->ID ] = $m->post_title;
		}
		
		$fields = [
			
			'_born_megamenu' => [
				'label'             => __( 'Mega Menu', BORN_NAME ),
				'element'           => 'select',
				'sanitize_callback' => 'sanitize_text_field',
				'options'           => $m_array,
			],
   
		];
		
		new \Lucymtc\Menu( $fields );
		

	} );
	
	
	function borntheme_theme_widgets_init() {
		
		
		register_sidebar( array(
			'name' => 'Footer menu left',
			'id' => 'footer-left',
			'before_widget' => '',
			'after_widget' => '',
		) );
		
		register_sidebar( array(
			'name' => 'Footer menu center',
			'id' => 'footer-center',
			'before_widget' => '',
			'after_widget' => '',
		) );
		
		register_sidebar( array(
			'name' => 'Footer menu right',
			'id' => 'footer-right',
			'before_widget' => '',
			'after_widget' => '',
		) );
		
		register_sidebar( array(
			'name' => 'Footer socials',
			'id' => 'footer-socials',
			'before_widget' => '',
			'after_widget' => '',
		) );
		
	}
	add_action( 'widgets_init', 'borntheme_theme_widgets_init' );

	add_filter( 'acf/location/rule_types', function( $choices ) {
		$choices[ __("Other", 'acf') ]['wc_prod_attr'] = 'WC Product Attribute';
		return $choices;
	} );

	add_filter( 'acf/location/rule_values/wc_prod_attr', function( $choices ) {
		foreach ( wc_get_attribute_taxonomies() as $attr ) {
			$pa_name = wc_attribute_taxonomy_name( $attr->attribute_name );
			$choices[ $pa_name ] = $attr->attribute_label;
		}
		return $choices;
	} );

	add_filter( 'acf/location/rule_match/wc_prod_attr', function( $match, $rule, $options ) {
		if ( isset( $options['taxonomy'] ) ) {
			// Automatically match all attributes regardless of operator or specific value.
			$match = in_array( $options['taxonomy'], array_map(
				function( $attr ) {
					return wc_attribute_taxonomy_name( $attr->attribute_name );
				},
				wc_get_attribute_taxonomies()
			), true );
		}
		return $match;
	}, 10, 3 );
	
	
	function md_custom_woocommerce_checkout_fields( $fields )
	{
		$fields['order']['order_comments']['placeholder'] = '';
		$fields['order']['order_comments']['label'] = born_translation('order_notes_title');
		
		return $fields;
	}
	add_filter( 'woocommerce_checkout_fields', 'md_custom_woocommerce_checkout_fields' );
	
	
	
	
	/**
     * Checkout fields
     */

// Add Registration Number and VAT Number fields to WooCommerce billing section
	add_filter('woocommerce_checkout_fields', 'add_custom_billing_fields');
	
	function add_custom_billing_fields($fields) {
		// Add Registration Number Field to Billing
		$fields['billing']['billing_registration_number'] = array(
			'type'        => 'text',
			'label'       => __('Registration Number'),
			'required'    => false,
			'priority'    => 21, // Adjust this priority to set the order
			'class'       => array('form-row-wide'),
		);
		
		// Add VAT Number Field to Billing
		$fields['billing']['billing_vat_number'] = array(
			'type'        => 'text',
			'label'       => __('VAT Number'),
			'required'    => false,
			'priority'    => 22,
			'class'       => array('form-row-wide'),
		);
		
		return $fields;
	}

// Save the custom fields to order meta
	add_action('woocommerce_checkout_update_order_meta', 'save_custom_billing_fields');
	
	function save_custom_billing_fields($order_id) {
		if (!empty($_POST['billing_registration_number'])) {
			update_post_meta($order_id, 'Registration Number', sanitize_text_field($_POST['billing_registration_number']));
		}
		if (!empty($_POST['billing_vat_number'])) {
			update_post_meta($order_id, 'VAT Number', sanitize_text_field($_POST['billing_vat_number']));
		}
	}

// Display custom fields in the admin order edit page
	add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_billing_fields_in_admin', 10, 1);
	
	function display_custom_billing_fields_in_admin($order) {
		$registration_number = get_post_meta($order->get_id(), 'Registration Number', true);
		$vat_number = get_post_meta($order->get_id(), 'VAT Number', true);
		
		if ($registration_number) {
			echo '<p><strong>' . __('Registration Number') . ':</strong> ' . esc_html($registration_number) . '</p>';
		}
		
		if ($vat_number) {
			echo '<p><strong>' . __('VAT Number') . ':</strong> ' . esc_html($vat_number) . '</p>';
		}
	}
	
	
	
	add_action( 'wp_ajax_mc_subscribe', 'mc_subscribe' );
	add_action( 'wp_ajax_nopriv_mc_subscribe', 'mc_subscribe' );
	
	
	include __DIR__ . '/lib/MailChimp.php';
	
	use DrewM\MailChimp\MailChimp;
	
	function mc_subscribe() {
	
		$apiKey = get_field('mailchimp_api_key','options');	
		$list_id = get_field('mailchimp_list_id','options');
		
		if ($apiKey && $list_id){	
			
			$email	= isset($_POST['data']['email'])?trim($_POST['data']['email']):"";
			
			$MailChimp = new MailChimp($apiKey);
			
			$MailChimp->post("lists/$list_id/members", [
				'email_address' => $email,
				'status'        => 'subscribed',
			]);
			
			if ($MailChimp->success()) {
				// user created
			} else {
				
				//update user status
				$subscriber_hash = MailChimp::subscriberHash($email);
				
				$result = $MailChimp->patch("lists/$list_id/members/$subscriber_hash", [
					'status'        => 'subscribed',
					
				]);
			}
			
			exit;
			
		}
		
		
	}
	
	
	if ( ! function_exists( 'born_template_loop_category_link_open' ) ) {
		/**
		 * Insert the opening anchor tag for categories in the loop.
		 *
		 * @param int|object|string $category Category ID, Object or String.
		 */
		function born_template_loop_category_link_open( $category ) {
			$category_term = get_term( $category, 'product_cat' );
			$category_name = ( ! $category_term || is_wp_error( $category_term ) ) ? '' : $category_term->name;
            $video_file = get_field('video_file', $category_term);
            $classes = 'item';
            if ($video_file){
                $classes .= ' has-video';
            }
            
			/* translators: %s: Category name */
			echo '<a aria-label="' . sprintf( esc_attr__( 'Visit product category %1$s', 'woocommerce' ), esc_attr( $category_name ) ) . '" class="'.$classes.'" href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">';
		}
	}
	
	
	// Add the custom stock status to the WooCommerce dropdown.
	function add_custom_stock_status( $statuses ) {
		$statuses['in_showroom'] = born_translation('in_showroom');
		return $statuses;
	}
	add_filter( 'woocommerce_product_stock_status_options', 'add_custom_stock_status' );

// Save the custom stock status when the product is updated.
	function save_custom_stock_status( $post_id ) {
		if ( isset( $_POST['_stock_status'] ) ) {
			// Get the submitted stock status from the dropdown.
			$stock_status = sanitize_text_field( $_POST['_stock_status'] );
			
			// Save the stock status as meta data.
			update_post_meta( $post_id, '_stock_status', $stock_status );
		}
	}
	add_action( 'woocommerce_process_product_meta', 'save_custom_stock_status' );

// Display the custom stock status on the frontend.
	/*function display_custom_stock_status( $availability, $product ) {
		if ( 'in_showroom' === $product->get_meta( '_stock_status' ) ) {
			$availability['availability'] = __( 'In showroom', 'your-text-domain' );
			$availability['class'] = 'in-showroom';
		}
		return $availability;
	}
	add_filter( 'woocommerce_get_availability', 'display_custom_stock_status', 10, 2 );*/
	
	
	
	add_filter('facetwp_facet_display_value', function($label, $params) {
		if ('pieejamba' == $params['facet']['name']) {
			if ('instock' == $label) {
				// Register the string for translation and get translated value
				do_action('wpml_register_single_string', 'FacetWP Labels', 'In stock', 'In stock');
				$label = apply_filters('wpml_translate_single_string', 'In stock', 'FacetWP Labels', 'In stock');
			}
			if ('outofstock' == $label) {
				do_action('wpml_register_single_string', 'FacetWP Labels', 'Out of Stock', 'Out of Stock');
				$label = apply_filters('wpml_translate_single_string', 'Out of Stock', 'FacetWP Labels', 'Out of Stock');
			}
			if ('onbackorder' == $label) {
				do_action('wpml_register_single_string', 'FacetWP Labels', 'On backorder', 'On backorder');
				$label = apply_filters('wpml_translate_single_string', 'On backorder', 'FacetWP Labels', 'On backorder');
			}
			if ('in_showroom' == $label) {
				do_action('wpml_register_single_string', 'FacetWP Labels', 'In shop', 'In shop');
				$label = apply_filters('wpml_translate_single_string', 'In shop', 'FacetWP Labels', 'In shop');
			}
		}
		return $label;
	}, 10, 2);
	
	add_action( 'wp_footer', function() {
		?>
        <link href="<?php echo get_site_url();?>/wp-content/plugins/facetwp/assets/vendor/fSelect/fSelect.css" rel="stylesheet" type="text/css">
        <script src="<?php echo get_site_url();?>/wp-content/plugins/facetwp/assets/vendor/fSelect/fSelect.js"></script>
        <script>
            document.addEventListener('facetwp-loaded', function() {
                fUtil('.facetwp-type-sort select').fSelect({showSearch: false});
            });
        </script>
		<?php
	}, 100 );
	
	
	function tren_register_widget_area() {
    register_sidebar( array(
        'name'          => __( 'Products Sidebar', 'textdomain' ),
        'id'            => 'products-sidebar',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => '',
    ) );

    register_sidebar( array(
      'name'          => __( 'Tags Sidebar', 'textdomain' ),
      'id'            => 'tags-sidebar',
      'before_widget' => '',
      'after_widget'  => '',
      'before_title'  => '',
      'after_title'   => '',
  ) );
  }
add_action( 'widgets_init', 'tren_register_widget_area' );
	
	
	function display_stock_status( $product ) {
		if ( $product->is_in_stock() || $product->is_on_backorder() ) {
			?>
            <div class="stock">
            <span>
                <?php
	                if ( $product->is_on_backorder() ) {
		                echo 'Uz pasūtījuma'; // On backorder
	                } elseif ( $product->is_in_stock() ) {
		                echo 'Ir noliktavā'; // In stock
	                }
                ?>
            </span>
            </div>
			<?php
		}
	}
    
    function output_consultation_cta(){
        ob_start();
        ?>

        <div class="cta"><a href="#" data-lightbox="tre-lightbox-consult">Vēlies konsultāciju?</a></div>
        
        <div class="tre-lightbox" id="tre-lightbox-consult" style="opacity: 0; visibility: hidden; pointer-events: none;">
            <div class="inner">

                <div class="tre-lightbox-popup">

                    <button class="is-close">Close</button>

                    <div class="heading">

                        <h2><?php echo born_translation('consultation_form_title');?></h2>
	                    
	                    <?php echo born_translation('consultation_form_text');?>

                    </div>
				    
				    <?php echo do_shortcode('[ninja_form id=2]');?>

                </div>

            </div>
        </div>
        
        <?php
        $c = ob_get_contents();
        ob_end_clean();
        
        return $c;
    }
	
	
	function remove_posts_menu() {
		remove_menu_page('edit.php');
	}
	add_action('admin_menu', 'remove_posts_menu');

	
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
		
	
	function get_custom_image_url($attachment_id, $size_name, $width, $height) {
		$file_path = get_attached_file($attachment_id);
		
		if (!$file_path) {
			return false; // Attachment not found
		}
		
		// Extract the directory, filename, and extension
		$upload_dir = wp_upload_dir();
		$file_dir   = dirname($file_path);
		$file_name  = pathinfo($file_path, PATHINFO_FILENAME);
		$file_ext   = pathinfo($file_path, PATHINFO_EXTENSION);
		
		// Construct the expected filename
		$custom_filename = "{$file_name}-{$width}x{$height}.{$file_ext}";
		$custom_path     = "{$file_dir}/{$custom_filename}";
		
		// Check if the file exists
		if (file_exists($custom_path)) {
			// Convert file system path to URL
			return str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $custom_path);
		}
		
		// Fallback to the default WordPress function
		return wp_get_attachment_image_url($attachment_id, 'full');
	}
	
	
	
	function tre_yoast_search_title($title) {
		if (is_search()) {
			$title = born_translation('search_title').' ' . get_search_query() . ' - ' . get_bloginfo('name');
		}
		return $title;
	}
	add_filter('wpseo_title', 'tre_yoast_search_title');
	
	
	add_filter('woocommerce_cart_shipping_method_full_label', 'remove_shipping_label_colon', 10, 2);
	function remove_shipping_label_colon($label, $method) {
		// Remove the colon and any whitespace after it
		$label = str_replace(':', '', $label);
		return $label;
	}
	
	
	add_action('init', 'register_woocommerce_strings');
	function register_woocommerce_strings() {
		if (function_exists('icl_register_string')) {
			icl_register_string('woocommerce', 'Address is required.', 'Address is required.');
			icl_register_string('woocommerce', 'City is required.', 'City is required.');
			icl_register_string('woocommerce', 'Postcode is required.', 'Postcode is required.');
			icl_register_string('woocommerce', 'Please select a bank', 'Please select a bank');
			
			icl_register_string('woocommerce', 'In stock', 'In stock');
			icl_register_string('woocommerce', 'Out of Stock', 'Out of Stock');
			icl_register_string('woocommerce', 'On backorder', 'On backorder');
			icl_register_string('woocommerce', 'In shop', 'In shop');
		}
	}
	
 
// Then filter checkout error messages
	add_filter('woocommerce_add_error', 'translate_woocommerce_errors');
	function translate_woocommerce_errors($error) {
		if (function_exists('icl_t')) {
			return icl_t('woocommerce', $error, $error);
		}
		return $error;
	}
 
 
 add_filter('woocommerce_return_to_shop_redirect', 'redirect_empty_cart_to_homepage');
function redirect_empty_cart_to_homepage() {
    return home_url();
}

// Change the button text to homepage title
add_filter('woocommerce_return_to_shop_text', 'change_empty_cart_button_text');
function change_empty_cart_button_text() {
    $front_page_id = get_option('page_on_front');
    if ($front_page_id) {
        return get_the_title($front_page_id);
    }
    return get_bloginfo('name'); // Fallback to site title if no static homepage is set
}
 


add_action( 'wp_head', 'tre_inject_product_schema' );

function tre_inject_product_schema() {
  if ( ! is_product() ) {
    return;
  }

  global $product;

  if ( ! is_a( $product, 'WC_Product' ) ) {
    $product = wc_get_product( get_the_ID() );
  }

  if ( $product ) {
    $schema = [
        "@context" => "https://schema.org/",
        "@type"    => "Product",
        "name"     => $product->get_name(),
        "image"    => wp_get_attachment_url( $product->get_image_id() ),
        "description" => wp_strip_all_tags( $product->get_short_description() ),
        "sku"      => $product->get_sku(),
        "brand"    => [
          "@type" => "Brand",
          "name"  => $product->get_attribute('brand') ?: get_bloginfo('name')
        ],
        "offers"   => [
          "@type"         => "Offer",
          "url"           => get_permalink( $product->get_id() ),
          "priceCurrency" => get_woocommerce_currency(),
          "price"         => $product->get_price(),
          "availability"  => "https://schema.org/" . ( $product->is_in_stock() ? 'InStock' : 'OutOfStock' ),
          "itemCondition" => "https://schema.org/NewCondition"
        ]
    ];

    $attributes = $product->get_attributes();
    foreach ( $attributes as $attribute ) {
      $name = wc_attribute_label( $attribute->get_name() );
      $value = $product->get_attribute( $attribute->get_name() );
      if ( $value ) {
        $schema["additionalProperty"][] = [
          "@type" => "PropertyValue",
          "name"  => $name,
          "value" => $value
        ];
      }
    }

    echo "\n" . '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
  }
}

add_action( 'wp_head', 'tre_inject_brand_schema' );

function tre_inject_brand_schema() {
  if ( is_front_page() ) {
    $schema_path = get_template_directory() . '/schemas/brand-schema.php';

    if ( file_exists( $schema_path ) ) {
      include $schema_path;
    }
  }
}

add_action('wp_head', 'tre_inject_schemas_final', 5);

function tre_inject_schemas_final() {
  $schema_folder = get_stylesheet_directory() . '/schemas/';

  if ( is_product_category() || is_shop() ) {
    $obj = get_queried_object();  
    $is_top_level = is_shop() || ( isset($obj->parent) && $obj->parent === 0 );

    if ( $is_top_level ) {
      $file = $schema_folder . 'category-schema.php';
      echo "";
    } else {
      $file = $schema_folder . 'subcategory-schema.php';
      echo "";
    }

    if ( file_exists( $file ) ) { 
      include $file;             
    }
  }
}

function get_faq_schema($faq_data) {
  if (empty($faq_data) || !is_array($faq_data)) {
    return '';
  }

  $schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'FAQPage',
    'mainEntity' => []
  ];

  foreach ($faq_data as $faq) {
    if (!empty($faq['title']) && !empty($faq['text'])) {
      $schema['mainEntity'][] = [
        '@type' => 'Question',
        'name'  => wp_strip_all_tags($faq['title']),
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text'  => wp_kses_post($faq['text'])
        ]
      ];
    }
  }

  return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}
