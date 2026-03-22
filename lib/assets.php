<?php if (!defined('WPINC')) die;

add_action('wp_loaded', function () {
	global $BORN_FRAMEWORK;

	$maps_api_key = $BORN_FRAMEWORK->Options->Get('gm_api_key');
	if (!$maps_api_key) $maps_api_key = '';

	$theme_styles = [
		['woocss', BORN_CSS.'woocommerce.css','', BORN_VERSION],
		['leaflet', 'https://cdn.jsdelivr.net/npm/leaflet@1.9.3/dist/leaflet.min.css','', BORN_VERSION],
		['slinkycss', 'https://cdn.jsdelivr.net/npm/jquery-slinky@4.2.1/dist/slinky.min.css','', BORN_VERSION],
    ['select2css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', '', BORN_VERSION],
		[BORN_NAME, BORN_CSS . 'app.min.css','', BORN_VERSION],
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

	$born_data = [
		'admin_ajax' => admin_url('admin-ajax.php'),
	];
	
  wp_register_script('tiny-slider', 'https://cdn.jsdelivr.net/npm/tiny-slider@2.9.4/dist/min/tiny-slider.min.js', ['jquery'], "", true);
	wp_register_script('simple-lightbox', BORN_JS.'simple-lightbox.jquery.min.js', ['jquery'], BORN_VERSION, true);
	wp_register_script('cookies-born', BORN_JS . 'cookies.js', ['jquery'], BORN_VERSION, true);
  wp_register_script('lazyload', 'https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js', ['jquery'], "", true);
	wp_register_script('slinky', 'https://cdn.jsdelivr.net/npm/jquery-slinky@4.2.1/dist/slinky.min.js', ['jquery'], "", true);
  wp_register_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['jquery'], BORN_VERSION, true);
	wp_register_script(BORN_NAME, BORN_JS . 'app.min.js', ['jquery', 'tiny-slider'], BORN_VERSION, true);

	wp_enqueue_script('lazyload');
	wp_enqueue_script('slinky');
  wp_enqueue_script('tiny-slider');
	wp_enqueue_script('select2');
	wp_enqueue_script(BORN_NAME);
}, 99);
