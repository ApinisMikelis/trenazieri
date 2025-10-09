<?php
/**
 * Created by PhpStorm.
 * User: daviskregers
 * Date: 27.10.17
 * Time: 09:05
 */

namespace Born\Core;
require_once __DIR__ . '/MailChimp.php';

use \DrewM\MailChimp\MailChimp;


class MailChimpWrapper
{

    private $apiKey = false;
    private $lists = [];

    private $chimp = false;

    public function __construct()
    {

//        add_action('wp_loaded', function() {

      //  global $BORN_FRAMEWORK;
        $this->apiKey = get_field('mailchimp_api_key','options');
	    
	    $this->lists['default'] = get_field('mailchimp_list_id','options');

        try {

            if (!$this->apiKey) throw new \Exception('Api key or list_id not set up');

            $this->chimp = new MailChimp($this->apiKey);

        } catch (\Exception $e) {

            if (is_user_logged_in() && function_exists('is_ajax') && !is_ajax()) {
                echo $e->getMessage();
            }

        }

//        });

    }

    public function add($member, $type)
    {

        try {

            if ($type == null) {
                $list_id = $this->lists['default'];
            } else {
                $list_id = $this->lists[$type];
            }

            return $this->chimp->post("lists/$list_id/members", $member);

        } catch (\Exception $e) {


            if (is_user_logged_in() && function_exists('is_ajax') && !is_ajax()) {
                echo $e->getMessage();
            }

        }

    }

}
