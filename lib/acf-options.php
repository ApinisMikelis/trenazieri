<?php

if (function_exists('acf_add_options_page')) {

    acf_add_options_page([
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ]);

    acf_add_options_sub_page([
        'page_title' => 'Translations settings',
        'menu_title' => 'Translations settings',
        'parent_slug' => 'theme-general-settings',
    ]);

	acf_add_options_sub_page(array(

		'page_title' => 'Archives settings',

		'menu_title' => 'Archives settings',

		'parent_slug' => 'theme-general-settings',

	));

}