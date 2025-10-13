<?php if (!defined('WPINC')) die;

add_action('wp_loaded', function () {
	global $BORN_FRAMEWORK;
//	$theme_version = born_get_theme_version();

	$maps_api_key = $BORN_FRAMEWORK->Options->Get('gm_api_key');
	if (!$maps_api_key) $maps_api_key = '';

	$theme_styles = [
		// ['bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css','', ''],
		// ['tinycss', 'https://cdn.jsdelivr.net/npm/tiny-slider@2.9.4/dist/tiny-slider.min.css','', ''],
		// ['jquery-ui', 'https://cdn.jsdelivr.net/npm/jquery-ui@1.13.2/dist/themes/base/jquery-ui.css','', ''],
		// ['jquery-ui-theme', 'https://cdn.jsdelivr.net/npm/jquery-ui@1.13.2/themes/base/theme.min.css','', ''],
		//['common', BORN_CSS.'common.min.css','', BORN_VERSION],
		['woocss', BORN_CSS.'woocommerce.css','', BORN_VERSION],
		['leaflet', 'https://cdn.jsdelivr.net/npm/leaflet@1.9.3/dist/leaflet.min.css','', BORN_VERSION],
		['slinkycss', 'https://cdn.jsdelivr.net/npm/jquery-slinky@4.2.1/dist/slinky.min.css','', BORN_VERSION],
		
	//	['lightboxcss', BORN_CSS.'simple-lightbox.min.css','', BORN_VERSION],
		[BORN_NAME, BORN_CSS . 'app.min.css','', BORN_VERSION],
		//['custom', BORN_CSS . 'custom.css','', ''],
	];

	$BORN_FRAMEWORK->Styles
		->addStyles('main', $theme_styles)
		->register();
});



function add_data_attribute($tag, $handle) {
   if ( 'custom' !== $handle )
    return $tag;

   return str_replace( ' src', ' data-cookieconsent="ignore" src', $tag );
}
add_filter('script_loader_tag', 'add_data_attribute', 10, 2);

add_action('wp_enqueue_scripts', function () {

//	wp_register_script('lazy-load', BORN_JS . 'lazyload.min.js', ['jquery'], '', false);
	//wp_register_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['jquery'], '', false);
	
	//wp_register_script('bootstrap', BORN_JS . 'bootstrap.bundle.min.js', ['jquery'], '', true);
	//wp_register_script('custom', BORN_JS . 'custom.js', ['jquery'], BORN_VERSION, true);
	//wp_register_script('ajax', BORN_JS . 'ajax.js', ['jquery'], BORN_VERSION, true);


	$born_data = [
		'admin_ajax' => admin_url('admin-ajax.php'),
	];
	
	


	/*$born_data = [
		'admin_ajax' => admin_url('admin-ajax.php'),
		'img_url' => BORN_IMG,
		'nonce' => wp_create_nonce(BORN_NONCE_VALUE),
		'born_translation_test_result' => born_translation('born_translation_test_result'),
		'born_translation_test_pass' => born_translation('born_translation_test_pass'),
		'born_translation_test_fail' => born_translation('born_translation_test_fail'),
		'born_translation_test_pass_text' => born_translation('born_translation_test_pass_text'),
		'born_translation_test_fail_text' => born_translation('born_translation_test_fail_text'),
		'load_more_current_page' => 1
	];

	wp_localize_script('custom', 'born_data', $born_data);*/
	
	

	 wp_register_script('tiny-slider', 'https://cdn.jsdelivr.net/npm/tiny-slider@2.9.4/dist/min/tiny-slider.min.js', ['jquery'], "", true);
	wp_register_script('simple-lightbox', BORN_JS.'simple-lightbox.jquery.min.js', ['jquery'], BORN_VERSION, true);
	wp_register_script('cookies-born', BORN_JS . 'cookies.js', ['jquery'], BORN_VERSION, true);
	// wp_register_script('mailchimp-born', BORN_JS . 'mailchimp.js', ['jquery'], BORN_VERSION, true);
	 wp_register_script('lazyload', 'https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js', ['jquery'], "", true);
	wp_register_script('slinky', 'https://cdn.jsdelivr.net/npm/jquery-slinky@4.2.1/dist/slinky.min.js', ['jquery'], "", true);
	// wp_register_script('chart', 'https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js', ['jquery'], "", true);
	// wp_register_script('chart-plugin', 'https://cdn.jsdelivr.net/npm/chartjs-plugin-deferred@2.0.0/dist/chartjs-plugin-deferred.min.js', ['jquery'], "", true);
	// wp_register_script('chart-data-labels', 'https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js', ['jquery'], "", true);
	// wp_register_script('isotope-layout', 'https://cdn.jsdelivr.net/npm/isotope-layout@3.0.6/dist/isotope.pkgd.min.js', ['jquery'], "", true);

	// wp_register_script('jquery-ui-touch-punch', BORN_JS . 'jquery.ui.touch-punch.min.js', ['jquery'], '', true);
//	wp_register_script('born-cookies', BORN_JS . 'cookies.js', ['jquery'], BORN_VERSION, true);
	wp_register_script(BORN_NAME, BORN_JS . 'app.min.js', ['jquery'], BORN_VERSION, true);
	
	
	// wp_localize_script('mailchimp-born', 'born_data', $born_data);
	

	wp_enqueue_script('lazyload');
	wp_enqueue_script('slinky');
	//wp_enqueue_script('bootstrap');
	 wp_enqueue_script('tiny-slider');
	// wp_enqueue_script('jquery-ui');
	// wp_enqueue_script('chart');
	// wp_enqueue_script('chart-plugin');
	// wp_enqueue_script('chart-data-labels');
	// wp_enqueue_script('isotope-layout');
	// wp_enqueue_script('jquery-ui-touch-punch');
	//wp_enqueue_script('born-cookies');
	wp_enqueue_script('select2');
	//wp_enqueue_script('simple-lightbox');
	//wp_enqueue_script('cookies-born');
	// wp_enqueue_script('mailchimp-born');
	wp_enqueue_script(BORN_NAME);
}, 99);

/*add_action('admin_enqueue_scripts', function() {
	wp_register_style(BORN_NAME . '-admin', BORN_CSS . 'admin.css', false, BORN_VERSION);
	wp_enqueue_style(BORN_NAME . '-admin');
});*/
