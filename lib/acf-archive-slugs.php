<?php



add_action('acf/include_fields', function () {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}



	$languages = born_get_languages();

	$archives = array('news','portfolio');

	$fields_array = array();

	foreach ($archives as $archive) {

		foreach ($languages as $lang){
			$fields_array[] = array(
				'key' => 'field_'.$archive.'_'.$lang['code'],
				'label' => ucfirst($archive).' archive slug '.$lang['code'],
				'name' => $archive.'_slug_'.$lang['code'],
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'wpml_cf_preferences' => 1,
				'append' => '',
			);
			
		}



	}


	acf_add_local_field_group(array(
		'key' => 'group_archive_slugs',
		'title' => 'Archive settings',
		'fields' => $fields_array,
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-archives-settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
		'acfml_field_group_mode' => "translation",
	));



});
