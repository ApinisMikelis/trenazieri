<?php


class Schemas {
	public function __construct()
	{
		add_filter( 'wpseo_json_ld_output', '__return_false' );
		
		if (function_exists('acf_add_options_page')) {
			acf_add_options_sub_page(array(
				'page_title' => 'Schema settings',
				'menu_title' => 'Schema settings',
				'parent_slug' => 'theme-general-settings',
			));
		}
		
		
		add_action( 'acf/include_fields', function() {
			if ( ! function_exists( 'acf_add_local_field_group' ) ) {
				return;
			}
			
			acf_add_local_field_group( array(
				'key' => 'group_6798c98ce7643',
				'title' => 'Schemas',
				'fields' => array(
					array(
						'key' => 'field_6798c98e0a702',
						'label' => 'General schema',
						'name' => '',
						'aria-label' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 3,
						'placement' => 'top',
						'endpoint' => 0,
						'selected' => 0,
					),
					array(
						'key' => 'field_6798c9f10a703',
						'label' => 'Type',
						'name' => 'schemas_general_type',
						'aria-label' => '',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 3,
						'choices' => array(
							'LocalBusiness' => 'LocalBusiness',
							'Organization' => 'Organization',
							'Corporation' => 'Corporation',
							'Brand' => 'Brand',
						),
						'default_value' => 'LocalBusiness',
						'return_format' => 'value',
						'multiple' => 0,
						'allow_null' => 0,
						'allow_in_bindings' => 0,
						'ui' => 0,
						'ajax' => 0,
						'placeholder' => '',
					),
					array(
						'key' => 'field_6798cb5c0a704',
						'label' => 'Name',
						'name' => 'schemas_name',
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
						'wpml_cf_preferences' => 3,
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_6798cb660a705',
						'label' => 'Image',
						'name' => 'schemas_image',
						'aria-label' => '',
						'type' => 'image',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 3,
						'return_format' => 'url',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
						'allow_in_bindings' => 0,
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_6798cb7d0a706',
						'label' => 'Description',
						'name' => 'schemas_description',
						'aria-label' => '',
						'type' => 'textarea',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 3,
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'rows' => '',
						'placeholder' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_6798cb9d0a707',
						'label' => 'Address locality',
						'name' => 'schemas_address_locality',
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
						'wpml_cf_preferences' => 3,
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_6798cbb90a708',
						'label' => 'Address country',
						'name' => 'schemas_address_country',
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
						'wpml_cf_preferences' => 3,
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_6798cc020a709',
						'label' => 'Telephone',
						'name' => 'schemas_telephone',
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
						'wpml_cf_preferences' => 3,
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_6798cc170a70a',
						'label' => 'Opening Hours',
						'name' => 'schemas_opening_hours',
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
						'wpml_cf_preferences' => 3,
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_6798cc2b0a70b',
						'label' => 'Email',
						'name' => 'schemas_email',
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
						'wpml_cf_preferences' => 3,
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_6798cc840a70c',
						'label' => 'Geo type',
						'name' => 'schemas_geo_type',
						'aria-label' => '',
						'type' => 'select',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 3,
						'choices' => array(
							'GeoCoordinates' => 'GeoCoordinates',
							'GeoShape' => 'GeoShape',
						),
						'default_value' => false,
						'return_format' => 'value',
						'multiple' => 0,
						'allow_null' => 0,
						'allow_in_bindings' => 0,
						'ui' => 0,
						'ajax' => 0,
						'placeholder' => '',
					),
					array(
						'key' => 'field_6798ccc20a70d',
						'label' => 'Latitude',
						'name' => 'schemas_latitude',
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
						'wpml_cf_preferences' => 3,
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_6798ccd80a70e',
						'label' => 'Longitude',
						'name' => 'schemas_longitude',
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
						'wpml_cf_preferences' => 3,
						'default_value' => '',
						'maxlength' => '',
						'allow_in_bindings' => 0,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
					),
					array(
						'key' => 'field_6798cce80a70f',
						'label' => 'Knows about',
						'name' => 'schemas_knows_about',
						'aria-label' => '',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 3,
						'layout' => 'table',
						'pagination' => 0,
						'min' => 0,
						'max' => 0,
						'collapsed' => '',
						'button_label' => 'Add Row',
						'rows_per_page' => 20,
						'sub_fields' => array(
							array(
								'key' => 'field_6798ccf90a710',
								'label' => 'Title',
								'name' => 'title',
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
								'wpml_cf_preferences' => 3,
								'default_value' => '',
								'maxlength' => '',
								'allow_in_bindings' => 0,
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'parent_repeater' => 'field_6798cce80a70f',
							),
						),
					),
					array(
						'key' => 'field_6798cd070a711',
						'label' => 'Same As',
						'name' => 'schemas_same_as',
						'aria-label' => '',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 3,
						'layout' => 'table',
						'pagination' => 0,
						'min' => 0,
						'max' => 0,
						'collapsed' => '',
						'button_label' => 'Add Row',
						'rows_per_page' => 20,
						'sub_fields' => array(
							array(
								'key' => 'field_6798cd130a712',
								'label' => 'Link',
								'name' => 'link',
								'aria-label' => '',
								'type' => 'url',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 3,
								'default_value' => '',
								'allow_in_bindings' => 0,
								'placeholder' => '',
								'parent_repeater' => 'field_6798cd070a711',
							),
						),
					),
					array(
						'key' => 'field_6799e627ca5df',
						'label' => 'Services',
						'name' => '',
						'aria-label' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 3,
						'placement' => 'top',
						'endpoint' => 0,
						'selected' => 0,
					),
					array(
						'key' => 'field_6799e8b06317e',
						'label' => 'Services items',
						'name' => 'schemas_services_items',
						'aria-label' => '',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 3,
						'layout' => 'table',
						'pagination' => 0,
						'min' => 0,
						'max' => 0,
						'collapsed' => '',
						'button_label' => 'Add Row',
						'rows_per_page' => 20,
						'sub_fields' => array(
							array(
								'key' => 'field_6799e635ca5e0',
								'label' => 'Name',
								'name' => 'schemas_service_name',
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
								'wpml_cf_preferences' => 3,
								'default_value' => '',
								'maxlength' => '',
								'allow_in_bindings' => 0,
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'parent_repeater' => 'field_6799e8b06317e',
							),
							array(
								'key' => 'field_6799e725ca5e3',
								'label' => 'Description',
								'name' => 'description',
								'aria-label' => '',
								'type' => 'textarea',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 0,
								'default_value' => '',
								'maxlength' => '',
								'allow_in_bindings' => 0,
								'rows' => '',
								'placeholder' => '',
								'new_lines' => '',
								'parent_repeater' => 'field_6799e8b06317e',
							),
							array(
								'key' => 'field_6799e764ca5e4',
								'label' => 'Service type',
								'name' => 'service_type',
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
								'wpml_cf_preferences' => 3,
								'default_value' => '',
								'maxlength' => '',
								'allow_in_bindings' => 0,
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'parent_repeater' => 'field_6799e8b06317e',
							),
							array(
								'key' => 'field_6799e6c8ca5e1',
								'label' => 'Provider',
								'name' => 'provider',
								'aria-label' => '',
								'type' => 'select',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 3,
								'choices' => array(
									'LocalBusiness' => 'LocalBusiness',
									'Organization' => 'Organization',
									'Person' => 'Person',
								),
								'default_value' => 'LocalBusiness',
								'return_format' => 'value',
								'multiple' => 0,
								'allow_null' => 0,
								'allow_in_bindings' => 0,
								'ui' => 0,
								'ajax' => 0,
								'placeholder' => '',
								'parent_repeater' => 'field_6799e8b06317e',
							),
							array(
								'key' => 'field_6799e70aca5e2',
								'label' => 'Provider name',
								'name' => 'provider_name',
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
								'wpml_cf_preferences' => 3,
								'default_value' => '',
								'maxlength' => '',
								'allow_in_bindings' => 0,
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'parent_repeater' => 'field_6799e8b06317e',
							),
							array(
								'key' => 'field_6799ef7eef2a3',
								'label' => 'Areas served',
								'name' => 'areas_served',
								'aria-label' => '',
								'type' => 'repeater',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'wpml_cf_preferences' => 3,
								'layout' => 'table',
								'pagination' => 0,
								'min' => 0,
								'max' => 0,
								'collapsed' => '',
								'button_label' => 'Add Row',
								'rows_per_page' => 20,
								'sub_fields' => array(
									array(
										'key' => 'field_6799efa9ef2a4',
										'label' => 'Name',
										'name' => 'name',
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
										'wpml_cf_preferences' => 3,
										'default_value' => '',
										'maxlength' => '',
										'allow_in_bindings' => 0,
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'parent_repeater' => 'field_6799ef7eef2a3',
									),
								),
								'parent_repeater' => 'field_6799e8b06317e',
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-schema-settings',
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
				'acfml_field_group_mode' => 'advanced',
			) );
		} );
		
		
		
		add_action('wp_footer', [$this, 'output_shemas']);
		
	}
	
	public function output_shemas() {
		if (is_front_page()) {
			$this->output_general_schema();
			$this->output_services_schema();
		}
	}
	
	public function output_general_schema() {
		
		$schemas_general_type = get_field('schemas_general_type', 'options');
		$schemas_name = get_field('schemas_name', 'options');
		$schemas_image = get_field('schemas_image', 'options');
		$schemas_description = get_field('schemas_description', 'options');
		$schemas_address_locality = get_field('schemas_address_locality', 'options');
		$schemas_address_country = get_field('schemas_address_country', 'options');
		$schemas_telephone = get_field('schemas_telephone', 'options');
		$schemas_opening_hours = get_field('schemas_opening_hours', 'options');
		$schemas_email = get_field('schemas_email', 'options');
		$schemas_geo_type = get_field('schemas_geo_type', 'options');
		$schemas_latitude = get_field('schemas_latitude', 'options');
		$schemas_longitude = get_field('schemas_longitude', 'options');
		$schemas_knows_about = get_field('schemas_knows_about', 'options'); // Repeater field
		$schemas_same_as = get_field('schemas_same_as', 'options'); // Repeater field
		
		if (empty($schemas_name)){
			return;
		}
		
		// Build schema data
		$schema_data = ["@context" => "https://schema.org"];
		
		if (!empty($schemas_general_type)) {
			$schema_data["@type"] = $schemas_general_type;
		} else {
			$schema_data["@type"] = "LocalBusiness";
		}
		
		if (!empty($schemas_name)) {
			$schema_data["name"] = $schemas_name;
		}
		
		if (!empty($schemas_image)) {
			$schema_data["image"] = $schemas_image;
		}
		
		if (!empty($schemas_description)) {
			$schema_data["description"] = $schemas_description;
		}
		
		if (!empty($schemas_address_locality) || !empty($schemas_address_country)) {
			$schema_data["address"] = ["@type" => "PostalAddress"];
			if (!empty($schemas_address_locality)) {
				$schema_data["address"]["addressLocality"] = $schemas_address_locality;
			}
			if (!empty($schemas_address_country)) {
				$schema_data["address"]["addressCountry"] = $schemas_address_country;
			}
		}
		
		if (!empty($schemas_telephone)) {
			$schema_data["telephone"] = $schemas_telephone;
		}
		
		if (!empty($schemas_opening_hours)) {
			$schema_data["openingHours"] = $schemas_opening_hours;
		}
		
		if (!empty($schemas_email)) {
			$schema_data["email"] = $schemas_email;
		}
		
		if (!empty($schemas_latitude) || !empty($schemas_longitude)) {
			$schema_data["geo"] = ["@type" => $schemas_geo_type ?: "GeoCoordinates"];
			if (!empty($schemas_latitude)) {
				$schema_data["geo"]["latitude"] = $schemas_latitude;
			}
			if (!empty($schemas_longitude)) {
				$schema_data["geo"]["longitude"] = $schemas_longitude;
			}
		}
		
		/*if (!empty($schemas_knows_about)) {
			$schema_data["knowsAbout"] = $schemas_knows_about;
		}*/
		
		if (!empty($schemas_knows_about)) {
			$knows_about_data = [];
			foreach ($schemas_knows_about as $item) {
				if (!empty($item['title'])) { // Assuming 'title' is the field name in the repeater
					$knows_about_data[] = $item['title'];
				}
			}
			if (!empty($knows_about_data)) {
				$schema_data["knowsAbout"] = $knows_about_data;
			}
		}
		
		/*if (!empty($schemas_same_as)) {
			$schema_data["sameAs"] = $schemas_same_as;
		}*/
		
		if (!empty($schemas_same_as)) {
			$same_as_data = [];
			foreach ($schemas_same_as as $item) {
				//if (!empty($item['link'])) { // Assuming 'title' is the field name in the repeater
					$same_as_data[] = $item['link'];
				//}
			}
			//if (!empty($schemas_same_as)) {
				$schema_data["sameAs"] = $same_as_data;
			//}
		}
		
		// Convert schema data to JSON-LD
		if (!empty($schema_data)) {
			echo '<script type="application/ld+json">' . json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
		}
	}
	
	public function output_services_schema() {
		$schemas_services_items = get_field('schemas_services_items', 'options'); // Repeater field
		
		if (empty($schemas_services_items)) {
			return;
		}
		
		$schemas_address_locality = get_field('schemas_address_locality', 'options');
		$schemas_address_country = get_field('schemas_address_country', 'options');
		
		
		$services_schema = [];
		
		foreach ($schemas_services_items as $service) {
			$service_data = [
				"@context" => "https://schema.org",
				"@type" => "Service"
			];
			
			if (!empty($service['schemas_service_name'])) {
				$service_data["name"] = $service['schemas_service_name'];
			}
			
			if (!empty($service['description'])) {
				$service_data["description"] = $service['description'];
			}
			
			if (!empty($service['service_type'])) {
				$service_data["serviceType"] = $service['service_type'];
			}
			
			if (!empty($service['provider']) || !empty($service['provider_name'])) {
				$service_data["provider"] = ["@type" => $service['provider'] ?: "LocalBusiness"];
				if (!empty($service['provider_name'])) {
					$service_data["provider"]["name"] = $service['provider_name'];
				}
			}
			
			if (!empty($service['areas_served'])) {
				$service_data["areaServed"] = [];
				foreach ($service['areas_served'] as $served) {
					$service_data["areaServed"][] = ["@type" => 'Place', 'name' => $served['name']];
				}
			}
			
			if ($schemas_address_locality && $schemas_address_country){
				
				$service_data["availableChannel"] = [
					"@type" => "ServiceChannel",
					"serviceLocation" => [
						"@type" => "Place",
						"address" => [
							"@type" => "PostalAddress",
							"addressLocality" => $schemas_address_locality,
							"addressCountry" => $schemas_address_country
						]
					]
				];
				
			}
			
			
			$services_schema[] = $service_data;
		}
		
		if (!empty($services_schema)) {
			echo '<script type="application/ld+json">' . json_encode($services_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
		}
	}
	
}


