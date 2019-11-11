<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/includes
 * @author     Shapepress eU
 */
class SPDSGVO{
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      sp_dsgvo_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Singleton
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object    $instance    The singleton instance
	 */
	protected static $instance = null;

    protected function __construct(){
		$this->version = sp_dsgvo_VERSION;
		$this->loadDependencies();
		$this->defineAdminHooks();
		$this->definePublicHooks();
    }

    protected function __clone(){}

    public static function instance(){
        if(!isset(static::$instance)){
            static::$instance = new static;
        }

        return static::$instance;
    }

	private function loadDependencies(){
		require_once plugin_dir_path(dirname(__FILE__)) .'includes/class-sp-dsgvo-loader.php';
		$this->loader = new SPDSGVOLoader();

		if(file_exists(dirname(dirname(__FILE__)) .'/vendor/autoload.php')){
			require_once dirname(dirname(__FILE__)) .'/vendor/autoload.php';
		}

		if(!class_exists('TCPDF')){
			require_once SPDSGVO::pluginDir('includes/lib/tcpdf/tcpdf.php');
			require_once SPDSGVO::pluginDir('includes/class-sp-dsgvo-pdf.php');
		}

		$load = array(
			//======================================================================
			// Libraries
			//======================================================================
			SPDSGVO::pluginDir('includes/helpers.php'),
			SPDSGVO::pluginDir('admin/class-sp-dsgvo-admin.php'),
			SPDSGVO::pluginDir('admin/class-sp-dsgvo-admin-tab.php'),
			SPDSGVO::pluginDir('includes/class-sp-dsgvo-ajax-action.php'),
		    SPDSGVO::pluginDir('admin/class-sp-dsgvo-admin-action.php'),
			SPDSGVO::pluginDir('includes/class-sp-dsgvo-settings.php'),
			SPDSGVO::pluginDir('includes/class-sp-dsgvo-settings-polylang.php'),
			SPDSGVO::pluginDir('includes/class-sp-dsgvo-mail.php'),
			SPDSGVO::pluginDir('includes/class-sp-dsgvo-data-collecter.php'),
			SPDSGVO::pluginDir('includes/class-sp-dsgvo-log.php'),
			SPDSGVO::pluginDir('includes/class-sp-dsgvo-integration.php'),
			SPDSGVO::pluginDir('includes/class-sp-dsgvo-slim-model.php'),
			SPDSGVO::pluginDir('includes/class-sp-dsgvo-cron.php'),
			SPDSGVO::pluginDir('public/class-sp-dsgvo-public.php'),


			//======================================================================
			// Models
			//======================================================================
			SPDSGVO::pluginDir('includes/models/unsubscriber.php'),
			SPDSGVO::pluginDir('includes/models/subject-access-request.php'),


			//======================================================================
			// Cron
			//======================================================================
			SPDSGVO::pluginDir('includes/cron/do-subject-access-request.php'),
		    SPDSGVO::pluginDir('includes/cron/do-delete-data-request.php'),


			//======================================================================
			// Actions
			//======================================================================
			SPDSGVO::pluginDir('public/actions/unsubscribe.php'),
			SPDSGVO::pluginDir('public/actions/explicit-permission.php'),
			SPDSGVO::pluginDir('public/actions/user-permissions.php'),
			/* i592995 */
			SPDSGVO::pluginDir('public/actions/popup-accept.php'),
			/* i592995 */


			//======================================================================
			// Shortcodes
			//======================================================================
			// SAR
			SPDSGVO::pluginDir('public/shortcodes/subject-access-request/download-subject-access-request.php'),
			SPDSGVO::pluginDir('public/shortcodes/subject-access-request/subject-access-request-action.php'),
			SPDSGVO::pluginDir('public/shortcodes/subject-access-request/subject-access-request.php'),

			// Super Unsubscribe
			SPDSGVO::pluginDir('public/shortcodes/super-unsubscribe/unsubscribe-form.php'),
			SPDSGVO::pluginDir('public/shortcodes/super-unsubscribe/unsubscribe-form-action.php'),
			SPDSGVO::pluginDir('public/shortcodes/super-unsubscribe/unsubscribe-confirm-action.php'),


			SPDSGVO::pluginDir('public/shortcodes/privacy-policy.php'),
			SPDSGVO::pluginDir('public/shortcodes/explicit-permission.php'),
			SPDSGVO::pluginDir('public/shortcodes/decline-permission.php'),
			SPDSGVO::pluginDir('public/shortcodes/privacy-settings-form.php'),
			/* i592995 */
			SPDSGVO::pluginDir('public/shortcodes/privacy-settings-form-alt.php'),
			/* i592995 */
			SPDSGVO::pluginDir('public/shortcodes/display-services.php'),
		    SPDSGVO::pluginDir('public/shortcodes/imprint.php'),

			//======================================================================
			// Default Integrations
			//======================================================================
			SPDSGVO::pluginDir('includes/integrations/mailchimp/MailchimpIntegration.php'),
		    SPDSGVO::pluginDir('includes/integrations/woocommerce/WoocommerceIntegration.php'),
		    SPDSGVO::pluginDir('includes/integrations/cf7/Cf7Integration.php'),
		    SPDSGVO::pluginDir('includes/integrations/bbpress/BbpressIntegration.php'),
		    SPDSGVO::pluginDir('includes/integrations/buddypress/BuddyPressIntegration.php'),


			//======================================================================
			// Admin Pages
			//======================================================================

			// Subject Access Request
			SPDSGVO::pluginDir('admin/tabs/subject-access-request/class-sp-dsgvo-subject-access-request-tab.php'),
			SPDSGVO::pluginDir('admin/tabs/subject-access-request/class-sp-dsgvo-subject-access-request-action.php'),

			// Super Unsubscribe
			SPDSGVO::pluginDir('admin/tabs/super-unsubscribe/class-sp-dsgvo-super-unsubscribe-tab.php'),
			SPDSGVO::pluginDir('admin/tabs/super-unsubscribe/class-sp-dsgvo-super-unsubscribe-action.php'),
			/* i592995 */
			SPDSGVO::pluginDir('admin/tabs/super-unsubscribe/class-sp-dsgvo-dismiss-unsubscribe-action.php'),
			/* i592995 */

			// Services
			SPDSGVO::pluginDir('admin/tabs/services/class-sp-dsgvo-services-tab.php'),
			SPDSGVO::pluginDir('admin/tabs/services/class-sp-dsgvo-services-action.php'),
			SPDSGVO::pluginDir('admin/tabs/services/class-sp-dsgvo-delete-service-action.php'),
			SPDSGVO::pluginDir('admin/tabs/services/class-sp-dsgvo-add-service-action.php'),

			// Privacy Policy
			SPDSGVO::pluginDir('admin/tabs/privacy-policy/class-sp-dsgvo-privacy-policy-tab.php'),
			SPDSGVO::pluginDir('admin/tabs/privacy-policy/class-sp-dsgvo-privacy-policy-action.php'),

			// Imprint
		    SPDSGVO::pluginDir('admin/tabs/imprint/class-sp-dsgvo-imprint-tab.php'),
		    SPDSGVO::pluginDir('admin/tabs/imprint/class-sp-dsgvo-imprint-action.php'),


			// Common Settings
		    SPDSGVO::pluginDir('admin/tabs/common-settings/class-sp-dsgvo-common-settings-tab.php'),
		    SPDSGVO::pluginDir('admin/tabs/common-settings/class-sp-dsgvo-common-settings-action.php'),
		    SPDSGVO::pluginDir('admin/tabs/common-settings/class-sp-dsgvo-common-settings-activate-action.php'),

			// Cookie Notice
		    SPDSGVO::pluginDir('admin/tabs/cookie-notice/class-sp-dsgvo-cookie-notice-tab.php'),
		    SPDSGVO::pluginDir('admin/tabs/cookie-notice/class-sp-dsgvo-cookie-notice-action.php'),

			// Integrations
			SPDSGVO::pluginDir('admin/tabs/integrations/class-sp-dsgvo-integrations-tab.php'),
			SPDSGVO::pluginDir('admin/tabs/integrations/class-sp-dsgvo-integrations-action.php'),

			// Imprint
		    SPDSGVO::pluginDir('admin/tabs/setup/class-sp-dsgvo-setup-tab.php'),
		    SPDSGVO::pluginDir('admin/tabs/setup/class-sp-dsgvo-create-page-action.php'),
		);

		// Gravity Forms
		if(class_exists( 'GFAPI' )){
			$load[] = SPDSGVO::pluginDir('admin/tabs/gravity-forms/class-sp-dsgvo-gravity-forms-tab.php');
			$load[] = SPDSGVO::pluginDir('admin/tabs/gravity-forms/class-sp-dsgvo-gravity-forms-action.php');
		}

		foreach($load as $path){
			require_once $path;
		}

		do_action('sp_dsgvo_booted');
	}

	public static function version(){
	    return (new self)->version;
	}

	public static function isTesting(){
		return (defined('sp_dsgvo_TESTING') && sp_dsgvo_TESTING === '1');
	}



	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function defineAdminHooks(){
		$admin = new SPDSGVOAdmin();
		$this->loader->add_action('init', 						$admin, 'adminInit');
		$this->loader->add_action('admin_enqueue_scripts', 		$admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', 		$admin, 'enqueue_scripts');

		$this->loader->add_action('admin_menu', 				$admin, 'menuItem');

		// $this->loader->add_filter('manage_users_columns', 		$admin, 'addExplicitPermissionColumn');
		// $this->loader->add_filter('manage_users_custom_column', $admin, 'explicitPermissionColumnCallback', 1, 3);

		$this->loader->add_action('show_user_profile', 			$admin, 'showPermissonStatus');
		$this->loader->add_action('edit_user_profile', 			$admin, 'showPermissonStatus');

		$this->loader->add_action('admin_enqueue_scripts',		$admin, 'enqueueColorPicker');
		$this->loader->add_action('display_post_states',		$admin, 'addCustomPostStates', 1, 3);

		// gravity forms action
		$this->loader->add_action('gform_after_submission',		$admin, 'gf_after_submisison_cleanse', 10, 2);

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function definePublicHooks(){
		$public = new SPDSGVOPublic();
		$this->loader->add_action('wp_enqueue_scripts', 		$public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', 		$public, 'enqueue_scripts');
		$this->loader->add_action('upload_mimes', 				$public, 'allowJSON');
		$this->loader->add_action('user_register', 				$public, 'newUserRegistered', 10, 1);
		$this->loader->add_action('wp', 						$public, 'forcePermisson');
		$this->loader->add_action('init', 						$public, 'publicInit');
		$this->loader->add_action('sp_dsgvo_collect_user_data', $public, 'collectUserData');
		$this->loader->add_action('wp_print_footer_scripts',    $public, 'wp_print_footer_scripts');
		$this->loader->add_action('wp_footer', 					$public, 'writeFooterScripts', 1000);
		$this->loader->add_action('wp_head', 					$public, 'writeHeaderScripts');
		$this->loader->add_action('comment_form',               $public, 'addCommentsCheckBoxForDSGVO' );
		$this->loader->add_action('wpcf7_init',                 $public, 'wpcf7AddDsgvoTag' );
		$this->loader->add_action('woocommerce_after_order_notes', $public, 'wooAddCustomFields' );
		$this->loader->add_action('woocommerce_checkout_process',  $public, 'wooAddCustomCheckout');
		$this->loader->add_action('woocommerce_checkout_update_order_meta', $public, 'wooUpdateOrderMeta');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run(){
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_sp_dsgvo() {
		return sp_dsgvo_NAME;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    sp_dsgvo_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function testPermissions(){
		return wp_upload_bits('sp-dsgvo-test-file.txt', NULL, time())['error'] === FALSE;
	}


	//======================================================================
	// Helpers
	//======================================================================
	public static function adminURL($params = NULL){
		if(is_null($params)){
			$params = array();
		}

		$params = http_build_query(array_merge(array(
			'page' => 'sp-dsgvo',
		), $params));

		return admin_url() .'?'. $params;
	}

	public static function pluginDir($append = ''){
		return plugin_dir_path(dirname(__FILE__)) . $append;
	}

	public static function pluginURI($append = ''){
		return plugin_dir_url(dirname(__FILE__)) . $append;
	}

	public static function isAjax(){
		return (strpos($_SERVER['REQUEST_URI'], 'admin-ajax.php') !== FALSE);
	}

	public function slugify($text){
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if(empty($text)){
			return 'n-a';
		}

		return $text;
	}
}
