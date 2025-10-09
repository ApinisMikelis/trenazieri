<?php if (!defined('WPINC')) die;

$prefix = BORN_NAME . '_';

if (class_exists('\Redux')) {

    $pages = get_pages();
    $pages_arr = [];

    foreach ($pages as $p) {
        $pages_arr[$p->ID] = $p->post_title;
    }

    $languages = born_get_languages();

    /**
     * General options
     */
    Redux::setSection('born_options', array(
        'title' => __('General Settings', BORN_NAME),
        'id' => 'general',
        'desc' => '',
        'icon' => 'el el-home',
        'callback' => 'test_redux_callback',
        'fields' => array(
            array(
                "id" => $prefix . "gtm_id",
                "desc" => "",
                'type' => 'text',
                'title' => __('Google Tag Manager ID', BORN_NAME),
                "default" => ""
            ),

            array(
                "title"   => "Cafe default map icon",
                "desc"    => "Will be set if cafe has no map icon",
                "id"      => $prefix . "cafe_default_icon",
                "default" => false,
                "type"    => "media"
            ),

            array(
                "title"   => "404 image main",
                "desc"    => "Image to the left",
                "id"      => $prefix . "404_img",
                "default" => false,
                "type"    => "media"
            ),

            array(
                "title"   => "404 image left",
                "desc"    => "Image to the left (below)",
                "id"      => $prefix . "404_img_left",
                "default" => false,
                "type"    => "media"
            ),

            array(
                "title"   => "404 image center",
                "desc"    => "Image to the center (below)",
                "id"      => $prefix . "404_img_center",
                "default" => false,
                "type"    => "media"
            ),

            array(
                "title"   => "404 image right",
                "desc"    => "Image to the right (below)",
                "id"      => $prefix . "404_img_right",
                "default" => false,
                "type"    => "media"
            ),

        )
    ));


    /**
     * Header options
     */
  /*  Redux::setSection('born_options', array(
        'title' => __('Header Settings', BORN_NAME),
        'id' => 'general',
        'desc' => '',
        'icon' => 'el el-home',
        'callback' => 'test_redux_callback',
        'fields' => array(
            array(
                "id" => $prefix . "sign_up_link",
                "desc" => "",
                'type' => 'text',
                'title' => __('Sign up link', BORN_NAME),
                "default" => ""
            ),
        )
    ));*/


    /**
     * Translations options
     */

    $translation_options = array();
//
    foreach ($languages as $lng) {



        $translation_options[] = array(
            "id" 		=> $prefix."header_fontsize" . $lng['code'],
            "type" => "text",
            "title" => __('Header font size text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Fonta izmērs"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."all_destinations" . $lng['code'],
            "type" => "text",
            "title" => __('All destinations', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Visi galamērķi"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."gal_forward" . $lng['code'],
            "type" => "text",
            "title" => __('Gallery next btn', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Šķirt galeriju uz priekšu"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."gal_back" . $lng['code'],
            "type" => "text",
            "title" => __('Gallery prev btn', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Šķirt galeriju atpakaļ"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."all_destinations" . $lng['code'],
            "type" => "text",
            "title" => __('All destinations', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Visi galamērķi"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."destinations" . $lng['code'],
            "type" => "text",
            "title" => __('Destinations', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Galamērķi"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."region_filter" . $lng['code'],
            "type" => "text",
            "title" => __('Region filter text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Reģions"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."operating_filter" . $lng['code'],
            "type" => "text",
            "title" => __('Operating times filter text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Darbības laiks"
        );


        $translation_options[] = array(
            "id" 		=> $prefix."email" . $lng['code'],
            "type" => "text",
            "title" => __('Email', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "E-pasts"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."phone" . $lng['code'],
            "type" => "text",
            "title" => __('phone', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Telefons"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."address" . $lng['code'],
            "type" => "text",
            "title" => __('Address', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Adrese"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."menu_title" . $lng['code'],
            "type" => "text",
            "title" => __('Menu', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Ēdienkarte"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."poi_text" . $lng['code'],
            "type" => "text",
            "title" => __('Points of interest', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Apskates objekti"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."socials_title" . $lng['code'],
            "type" => "text",
            "title" => __('Socials title', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Seko aktuālajam:"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."cafes_title" . $lng['code'],
            "type" => "text",
            "title" => __('Cafes title', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Kafejnīcas"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."cafes_map_scroll" . $lng['code'],
            "type" => "text",
            "title" => __('Cafes map scroll text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Lai pietuvinātu karti, turēt taustiņu \"Ctrl\" un izmantot peles rituli"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."activities_title" . $lng['code'],
            "type" => "text",
            "title" => __('Activities title', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Aktivitātes"
        );


        $translation_options[] = array(
            "id" 		=> $prefix."veg_friendly" . $lng['code'],
            "type" => "text",
            "title" => __('Vegetarian friendly', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Veģetāriešiem draudzīgi"
        );


        $translation_options[] = array(
            "id" 		=> $prefix."activity_inc" . $lng['code'],
            "type" => "text",
            "title" => __('Activities included', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Kultūras pasākumi un aktivitātes"
        );


        $translation_options[] = array(
            "id" 		=> $prefix."veg_friendly_popup" . $lng['code'],
            "type" => "text",
            "title" => __('Vegetarian friendly popup text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Ēdiens"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."activity_inc_popup" . $lng['code'],
            "type" => "text",
            "title" => __('Activities included popup text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Aktivitātes"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."enable_sound" . $lng['code'],
            "type" => "text",
            "title" => __('Enable sound', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Ieslēgt skaņu"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."settings_header" . $lng['code'],
            "type" => "text",
            "title" => __('Enable sound', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Iestatījumi"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."header_fontsize" . $lng['code'],
            "type" => "text",
            "title" => __('Header font size text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Fonta izmērs"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."header_contrast" . $lng['code'],
            "type" => "text",
            "title" => __('Header contrast text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Kontrasts"
        );


        $translation_options[] = array(
            "id" 		=> $prefix."footer_copy" . $lng['code'],
            "type" => "text",
            "title" => __('Footer copyright', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "© 2022 Latvijas Investīciju un attīstības aģentūra, Visas tiesības aizsargātas."
        );


        $translation_options[] = array(
            "id" 		=> $prefix."footer_devs" . $lng['code'],
            "type" => "text",
            "title" => __('Footer developed by', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Mājas lapas izstrāde"
        );


        $translation_options[] = array(
            "id" 		=> $prefix."404_text" . $lng['code'],
            "type" => "text",
            "title" => __('404 text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Šāda lapa netika atrasta"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."404_home" . $lng['code'],
            "type" => "text",
            "title" => __('404 button text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Uz sākumlapu"
        );

        $translation_options[] = array(
            "id" 		=> $prefix."read_more" . $lng['code'],
            "type" => "text",
            "title" => __('Read more text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => "Uzzini vairāk"
        );




    }
//
    Redux::setSection('born_options', array(
        'title' => __('Theme Translations', BORN_NAME),
        'id' => 'translations',
        'desc' => '',
        'icon' => 'el el-home',
        'callback' => 'test_redux_callback',
        'fields' => $translation_options,
    ));




    /**
     * Archives
     */
    $archives_post_types = array(
        'destinations' => __('Destinations'),
    );
    $archives_options = array();

    foreach ($archives_post_types as $archive_type => $archive_name) {
        $archive_opt_prefix = $prefix . $archive_type . '_archive_';
        $archives_options[] = array(
            'id' => $archive_opt_prefix . "section_start",
            'title' => $archive_name,
            'type' => 'section',
            'indent' => true
        );


        foreach ($languages as $lng) {



                $archives_options[] = array(
                    "id" => $archive_opt_prefix . "slug_" . $lng['code'],
                    "type" => "text",
                    "title" => sprintf(__('%1$s archive slug', BORN_NAME) . ' (%2$s)', $archive_name, $lng['translated_name']),
                    "description" => __("To take an effect you should refresh permalinks by resaving settings under \"Settings -> Permalinks\"", BORN_NAME),
                    "default" => sanitize_title($archive_name)
                );

        }
        $archives_options[] = array(
            'id' => $archive_opt_prefix . "section_end",
            'type' => 'section',
            'indent' => false
        );
    }
    Redux::setSection('born_options', array(
            'title' => __('Archives', BORN_NAME),
            'id' => 'archives',
            'desc' => '',
            'icon' => 'el el-book',
            'fields' => $archives_options
        )
    );



    $footer_settings = array();


    $footer_settings[] = array(
        "id" => $prefix . "footer_email_address",
        "type" => "text",
        "title" => __('Footer email address', BORN_NAME),
        "default" => ""
    );

    $footer_settings[] = array(
        "id" => $prefix . "footer_phone_number_1",
        "type" => "text",
        "title" => __('Footer phone number #1', BORN_NAME),
        "default" => ""
    );

    $footer_settings[] = array(
        "id" => $prefix . "footer_phone_number_2",
        "type" => "text",
        "title" => __('Footer phone number #2', BORN_NAME),
        "default" => ""
    );

    $footer_settings[] = array(
        "id" => $prefix . "footer_address",
        "type" => "text",
        "title" => __('Footer address', BORN_NAME),
        "default" => ""
    );

    $footer_settings[] = array(
        'id'    => $prefix.'footer_social',
        'type'  => 'icon_with_link',
        'title' => __('Social networks', BORN_NAME),
        //'std'   => array()
    );

    $footer_settings[] = array(
        "title"   => "Footer partner 1 img",
        //"desc"    => "If checked will hide suggested products in my account",
        "id"      => $prefix . "footer_partner_one",
        "default" => false,
        "type"    => "media"
    );

    $footer_settings[] =   array(
                "title"   => "Footer partner 2 img",
                //"desc"    => "If checked will hide suggested products in my account",
                "id"      => $prefix . "footer_partner_two",
                "default" => false,
                "type"    => "media"
            );

/*    foreach ($languages as $lng) {

        $footer_settings[] = array(
            "id" => $prefix . "header_cta_btn_link" . $lng['code'],
            "type" => "text",
            "title" => __('Header cta button link', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => ""
        );

        $footer_settings[] = array(
            "id" => $prefix . "header_login" . $lng['code'],
            "type" => "text",
            "title" => __('Header login link', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => ""
        );

        $footer_settings[] = array(
            "id" => $prefix . "header_register" . $lng['code'],
            "type" => "text",
            "title" => __('Header register link', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => ""
        );

    }*/

    /**
     * Footer options
     */
    Redux::setSection('born_options', array(
        'title' => __('Footer Settings', BORN_NAME),
        'id' => 'footer',
        'desc' => '',
        'icon' => 'el el-home',
        'callback' => 'test_redux_callback',
        'fields' => $footer_settings,
    ));



    /**
     * Cookies notification
     */
    $cookies_options = array();

    foreach($languages as $lng) {

     /*   $cookies_options[] = array(
            "id" 		=> $prefix."cookies_title_" . $lng['code'],
            "type" => "editor",
            "title" => __('Cookie notification title', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => 'Privātuma politika'
        );*/

        $cookies_options[] = array(
            "id" 		=> $prefix."cookies_text_" . $lng['code'],
            "type" => "editor",
            "title" => __('Cookie notification text', BORN_NAME) . ' (' . $lng['translated_name'] . ')',
            "default" => 'This website uses cookies for Google Analytics purposes.'
        );
        $cookies_options[] = array(
            "id" 		=> $prefix."cookies_agree_" . $lng['code'],
            "type" => "text",
            "title" => __('Agree text', BORN_NAME). ' (' . $lng['translated_name'] . ')',
            "default" => 'Apstiprināt'
        );
        $cookies_options[] = array(
            "id" 		=> $prefix."cookies_disagree_" . $lng['code'],
            "type" => "text",
            "title" => __('Read more text', BORN_NAME). ' (' . $lng['translated_name'] . ')',
            "default" => 'Noraidīt'
        );
    }

    Redux::setSection( 'born_options', array(
            'title'  => __( 'Cookies', BORN_NAME ),
            'id'     => 'cookies',
            'desc'   => '',
            'icon'   => 'el el-flag',
            'fields' => $cookies_options
        )
    );






}
