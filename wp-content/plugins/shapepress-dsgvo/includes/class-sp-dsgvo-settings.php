<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author     Shapepress eU
 */
class SPDSGVOSettings{

    public $defaults = array();

    public function __construct() {
        $this->defaults = array(
		/////////////////////////////////////
	    // common settings
	    /////////////////////////////////////
	    'show_setup'                      	=> '0',
	    'license_key_error'                 => '1',
	    'license_activated'                 => '0',
	    'licence_activated_on'              => '2018-05-01',
	    'licence_valid_to'                  => '2019-05-05',
	    'licence_details_fetched'           => '0',
	    'api_key' 		                    => '',
	    'admin_email'                      	=> '',
        'use_wpml_strings'                  => '0',
	    'sp_dsgvo_comments_checkbox' 	    => '0',
	    'spdsgvo_comments_checkbox_confirm'	=> __('I confirm','shapepress-dsgvo'),
	    'spdsgvo_comments_checkbox_info' 	=> __('The confirmation to GDPR is mandatory.','shapepress-dsgvo'),
	    'spdsgvo_comments_checkbox_text' 	=> __('This form stores your name, email address and content so that we can evaluate the comments on our site. For more information, visit our Privacy Policy page.','shapepress-dsgvo'),

        'spdsgvo_company_info_name'         => '',
        'spdsgvo_company_info_street'       => '',
        'spdsgvo_company_info_loc_zip'      => '',
        'spdsgvo_company_fn_nr'             => '',
        'spdsgvo_company_law_loc'           => '',
        'spdsgvo_company_uid_nr'            => '',
        'spdsgvo_company_law_person'        => '',
        'spdsgvo_company_chairmen'          => '',
        'spdsgvo_company_resp_content'      => '',
        'spdsgvo_company_info_phone'        => '',
        'spdsgvo_company_info_fax'          => '',
        'spdsgvo_company_info_email'        => '',
        'spdsgvo_newsletter_service'        => '',
        'spdsgvo_newsletter_service_privacy_policy_url' => '',



		/////////////////////////////////////
		// SAR
		/////////////////////////////////////
		'sar_cron'	           	 => '0',
		'sar_page'		         => '0',
	    'sar_email_notification' => '0',
	    'sar_dsgvo_accepted_text'       => __('I agree to the storage of the data for processing within the meaning of the GDPR.','shapepress-dsgvo'),

		/////////////////////////////////////
		// Third-party Services
		/////////////////////////////////////
		'user_permissions_page' => '0',

		'services' => array(
			'cookies' => array(
				'slug'      => 'cookies',
                'name'      => 'Cookies',
			    'reason'    => __('We use cookies to analyze visitor behavior.','shapepress-dsgvo'),
                'link'      => '',
                'default'   => '1',
			),
			'google-analytics' => array(
				'slug'      => 'google-analytics',
                'name'      => 'Google Analytics',
			    'reason'    => __('Google Analytics is used to analyze website traffic.','shapepress-dsgvo'),
                'link'      => 'https://www.google.com/analytics/terms/us.html',
                'default'   => '1',
			),
		    'facebook-pixel' => array(
			    'slug'      => 'facebook-pixel',
			    'name'      => 'Facebook Pixel',
		        'reason'    => __('Facebook Pixel is used to analyze visitor behavior.','shapepress-dsgvo'),
			    'link'      => 'https://www.facebook.com/legal/terms/update',
			    'default'   => '1',
			)
		),


		/////////////////////////////////////
		// Unsubscribe Page
		/////////////////////////////////////
		'super_unsubscribe_page' 	   => '0',
		'unsubscribe_auto_delete' 	   => '0',
	    'su_auto_del_time'             => '0',
	    'su_woo_data_action'           => 'ignore',
	    'su_bbpress_data_action'       => 'ignore',
	    'su_buddypress_data_action'    => 'ignore',
	    'su_email_notification'        => '0',
	    'su_dsgvo_accepted_text'       => __('I agree to the storage of the data for processing within the meaning of the GDPR.','shapepress-dsgvo'),


		/////////////////////////////////////
		// Cookie Notice
		/////////////////////////////////////
		'display_cookie_notice' 			=> '0',
		'cookie_notice' 					=> __("This website uses cookies. By clicking 'accept' you are providing consent to us using cookies on this browser.", 'shapepress-dsgvo'),
		'cookie_notice_custom_css' 			=> "",
	    'cn_tracker_init'                   => 'on_load',
	    'ga_enable_analytics'               => '0',
	    'ga_tag_number'                     => '',
	    'fb_enable_pixel'                   => '0',
	    'fb_pixel_number'                   => '',
	    'display_cookie_notice'             => '0',
	    'cookie_notice_custom_text'         => __('We use cookies to give you the best user experience. If you continue to use this site, we assume that you agree.','shapepress-dsgvo'),
	    'cn_cookie_validity'                => '86400',
	    'cn_button_text_ok'                 => __('OK','shapepress-dsgvo'),
	    'cn_reload_on_confirm'              => '0',
	    'cn_activate_cancel_btn'            => '1',
	    'cn_button_text_cancel'             => __('Deny','shapepress-dsgvo'),
	    'cn_decline_target_url'             => '',
	    'cn_activate_more_btn'              => '0',
	    'cn_button_text_more'               => __('More information','shapepress-dsgvo'),
	    'cn_read_more_page'                 => '',
	    'cn_position'                       => 'bottom',
	    'cn_animation'                      => 'none',
	    'cn_background_color'               => '#333333',
	    'cn_text_color'                     => '#ffffff',
	    'cn_background_color_button'        => '#F3F3F3',
	    'cn_text_color_button'              => '#333333',
	    'cn_custom_css_container'           => '',
	    'cn_custom_css_text'                => '',
	    'cn_custom_css_buttons'             => '',
	    'cn_size_text'                      => '13px',
	    'cn_height_container'               => 'auto',
	    'cn_show_dsgvo_icon'                => '1',
	    'cn_use_overlay'                    => '0',
        'cookie_notice_display'             => 'cookie_notice',


		/////////////////////////////////////
		// Terms Conditions
		/////////////////////////////////////
		'terms_conditions' 						=> '',
		'terms_conditions_page' 				=> '0',
		'terms_conditions_version' 				=> '1',
		'terms_conditions_hash' 				=> '',
		'force_explicit_permission_public' 		=> '0',
		'force_explicit_permission_authenticated' => '0',
		'explicit_permission_page' 				=> '0',
		'opt_out_page' 							=> '0',


		/////////////////////////////////////
		// Privacy Policy
		/////////////////////////////////////
		'privacy_policy' 		 => '',
		'privacy_policy_page' 	 => '0',
		'privacy_policy_version' => '1',
		'privacy_policy_hash' 	 => '',
        'woo_show_privacy_checkbox' => '0',
        'woo_show_privacy_checkbox_register' => '0',
		'woo_privacy_text'       => __('I have read and accepted the Privacy Policy.','shapepress-dsgvo'),

		/////////////////////////////////////
	    // imprint
	    /////////////////////////////////////
	    'imprint' 		 => '',
	    'imprint_page' 	 => '0',
	    'imprint_version' => '1',
	    'imprint_hash' 	 => '',

        'cb_spdsgvo_cl_vdv'                  => '0',
        'cb_spdsgvo_cl_filled_out'           => '0',
        'cb_spdsgvo_cl_maintainance'         => '0',
        'cb_spdsgvo_cl_security'             => '0',
        'cb_spdsgvo_cl_hosting'              => '0',
        'cb_spdsgvo_cl_plugins'              => '0',
        'cb_spdsgvo_cl_experts'              => '0',


	);
    }

	public static function init(){

	    $sInstance = (new self);
		$users = get_users(array('role' => 'administrator'));
		$admin = (isset($users[0]))? $users[0] : FALSE;
		if(!self::get('admin_email')){
			if($admin){
			    self::set('admin_email', $admin->user_email);
			}
		}


		if(!self::get('privacy_policy')){
		    $privacyPolicy = file_get_contents(SPDSGVO::pluginDir('/templates/'.get_locale().'/privacy-policy.txt'));
// 			if($admin){
// 				$privacyPolicy = str_replace('[name]',  $admin->display_name, $privacyPolicy);
// 				$privacyPolicy = str_replace('[email]', $admin->user_email,   $privacyPolicy);
// 			}
    		SPDSGVOSettings::set('privacy_policy_hash', wp_hash($privacyPolicy));
    		self::set('privacy_policy', $privacyPolicy);
		}


		if(!self::get('terms_conditions')){
			$termsConditions = '';// file_get_contents(SPDSGVO::pluginDir('terms-conditions.txt'));
    		SPDSGVOSettings::set('terms_conditions_hash', wp_hash($termsConditions));
    		self::set('terms_conditions', $termsConditions);
		}

		if(!self::get('imprint')){
		    $imprint = file_get_contents(SPDSGVO::pluginDir('/templates/'.get_locale().'/imprint.txt'));
		    SPDSGVOSettings::set('imprint_hash', wp_hash($imprint));
		    self::set('imprint', $imprint);
		}


		if(!self::get('services')){
		    self::set('services', array(
			    'cookies' => array(
			        'slug'      => 'cookies',
			        'name'      => 'Cookies',
			        'reason'    => __('We use cookies to analyze visitor behavior.','shapepress-dsgvo'),
			        'link'      => '',
			        'default'   => '0',
			    ),
			    'google-analytics' => array(
			        'slug'      => 'google-analytics',
			        'name'      => 'Google Analytics',
			        'reason'    => __('Google Analytics is used to analyze website traffic.','shapepress-dsgvo'),
			        'link'      => 'https://www.google.com/analytics/terms/us.html',
			        'default'   => '0',
			    ),
			    'facebook-pixel' => array(
			        'slug'      => 'facebook-pixel',
			        'name'      => 'Facebook Pixel',
			        'reason'    => __('Facebook Pixel is used to analyze visitor behavior.','shapepress-dsgvo'),
			        'link'      => 'https://www.facebook.com/legal/terms/update',
			        'default'   => '0',
			    )

			));
		}


		foreach($sInstance->defaults as $setting => $value){
		    if(!self::get($setting)){
		        self::set($setting, $value);
			}
		}
	}

	public static function set($property, $value){
		update_option('sp_dsgvo_'.$property, $value);
	}

	public static function get($property){
		$value = get_option('sp_dsgvo_'.$property);

		if($value !== '0'){
			if(!$value || empty($value)){

			    $value = self::getDefault($property);
			}
		}

		return $value;
	}

	public static function getDefault($property){

	    $sInstance = new self;

	    if (array_key_exists($property, $sInstance->defaults))
	    {
	        return $sInstance->defaults[$property];
	    } else
	    {
	        return '';
	    }
	}


	public function __get($property){
	    return self::get($property);
	}

	public function __set($property, $value){
	    return self::set($property, $value);
	}
}
