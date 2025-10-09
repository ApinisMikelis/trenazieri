<?php if (!defined('WPINC')) die;

if (!defined('BORN_THEME'))
    define('BORN_THEME', __DIR__ . '/../' );

if (!defined('BORN_CSS'))
    define('BORN_CSS', get_template_directory_uri() . '/assets/dist/css/');

if (!defined('BORN_JS'))
    define('BORN_JS', get_template_directory_uri() . '/assets/dist/js/');

if (!defined('BORN_FONT'))
    define('BORN_FONT', get_template_directory_uri() . '/assets/fonts/');

if (!defined('BORN_IMG'))
    define('BORN_IMG', get_template_directory_uri() . '/assets/img/');

if (!defined('BORN_VIDEO'))
    define('BORN_VIDEO', get_template_directory_uri() . '/assets/video/');

/*if (!defined('BORN_BLOG_PAGE'))
	define('BORN_BLOG_PAGE', 'blogs');
if (!defined('BORN_BLOG_SLUG'))
	define('BORN_BLOG_SLUG', BORN_BLOG_PAGE . '/%blog_category%');*/

/**
 * Demo settings
 */

if (!defined('BORN_USER_ROLE_VERSION'))
    define('BORN_USER_ROLE_VERSION', 2);

if (!defined('BORN_USER_ROLE_PREFIX'))
    define('BORN_USER_ROLE_PREFIX', 'demo_');

if (!defined('BORN_APP_USER'))
    define('BORN_APP_USER', 'app_user');

if (!defined('BORN_USER_ROLES'))
    define('BORN_USER_ROLES', [
        BORN_APP_USER => 'Demo App User'
    ]);

if (!defined('BORN_NONCE_VALUE'))
    define('BORN_NONCE_VALUE', 'u3UkoU4acxW4gLn5PQHTRVsokkcjIKpt7h2XRujt6xKGnlR8ex');

if (!defined('BORN_ENCRYPT_KEY'))
    define('BORN_ENCRYPT_KEY', '1q0au*mB1jwF7f%Ww^#yL4YJQJe7C8nV^Qe3D8L6zBgiUX3N5n');