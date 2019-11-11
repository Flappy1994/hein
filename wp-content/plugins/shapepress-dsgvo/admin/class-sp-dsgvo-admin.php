<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wp-dsgvo.eu
 * @since      1.0.0
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP DSGVO Tools
 * @subpackage WP DSGVO Tools/admin
 * @author     Shapepress eU
 */
class SPDSGVOAdmin{


	public $tabs = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sp_dsgvo       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct(){
		$this->tabs = array_merge(array(
			//'overview' 					=> new SPDSGVOOverviewTab,
		    'common-settings' 			=> new SPDSGVOCommonSettingsTab,
		    'cookie-notice' 			=> new SPDSGVOCookieNoticeTab,
		    'services' 					=> new SPDSGVOServicesTab,
			'subject-access-request' 	=> new SPDSGVOSubjectAccessRequestTab,
			'super-unsubscribe' 		=> new SPDSGVOSuperUnsubscribeTab,
			//'terms-conditions'  		=> new SPDSGVOTermsConditionsTab,
			'privacy-policy'    		=> new SPDSGVOPrivacyPolicyTab,
		    'imprint'    		        => new SPDSGVOImprintTab,
			'integrations'				=> new SPDSGVOIntegrationsTab
		)
		);

		if (isValidPremiumEdition())
		{
		    $this->tabs = array_merge( $this->tabs,SPDSGVOIntegration::getAllIntegrations());

		    // Gravity Forms Tab
		    if(class_exists('GFAPI')){
		        $this->tabs = array_merge( $this->tabs, array('gravity-forms' => new SPDSGVOGravityFormsTab) );
		    }
		}

		//$this->tabs = array_merge( $this->tabs, array('premium' => new SPDSGVOPremiumTab) );
	}

	public function menuItem()
    {
        global $submenu;

		$svg = 'data:image/svg+xml;base64,'. base64_encode(file_get_contents(SPDSGVO::pluginDir('admin/images/logo.svg')));
		add_menu_page('WP DSGVO Tools', 'WP DSGVO Tools',  'manage_options', 'sp-dsgvo', array($this, 'adminPage'), $svg);

		//add_submenu_page('sp-dsgvo', 'Terms & Conditions',  'Terms & Conditions', 'manage_options', 'admin.php?page=sp-dsgvo&tab=terms-conditions');
		add_submenu_page('sp-dsgvo', __('Privacy policy','shapepress-dsgvo'),  __('Privacy policy','shapepress-dsgvo'), 'manage_options', 'admin.php?page=sp-dsgvo&tab=privacy-policy');
		add_submenu_page('sp-dsgvo', __('Imprint','shapepress-dsgvo'),  __('Imprint','shapepress-dsgvo'), 'manage_options', 'admin.php?page=sp-dsgvo&tab=imprint');
		//add_submenu_page('sp-dsgvo', 'Integrations',  'Integrations', 'manage_options', 'admin.php?page=sp-dsgvo&tab=integrations');

		$index = 8;
		$menu_slug = 'sp-dsgvo';

		$submenu[$menu_slug][$index++] = array(__('Experts Info','shapepress-dsgvo'), 'manage_options', 'https://wp-dsgvo.eu/experten');
		$submenu[$menu_slug][$index++] = array(__('Legal advice','shapepress-dsgvo'), 'manage_options', 'https://wp-dsgvo.eu/tipps-hilfe');
		$submenu[$menu_slug][$index++] = array(__('FAQ','shapepress-dsgvo'), 'manage_options', 'https://wp-dsgvo.eu/faq');
		$submenu[$menu_slug][$index++] = array(__('About WP DSGVO Tools','shapepress-dsgvo'), 'manage_options', 'https://wp-dsgvo.eu/about');
	}


	public function adminPage(){
		$tabs = $this->tabs;

		if(isset($_GET['tab'])){
			$tab = $_GET['tab'];
		}else{
		    $tab = 'common-settings';
// 			if(in_array('setup', array_keys($this->tabs))){
// 				$tab = 'setup';
// 			}else{
// 				$tab = 'overview';
// 			}
		}

		include SPDSGVO::pluginDir('admin/base.php');
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(){
		wp_enqueue_style(sp_dsgvo_VERSION, plugin_dir_url(__FILE__). 'css/sp-dsgvo-admin.css', array(), sp_dsgvo_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(){
		/* i592995 */
		wp_enqueue_media();
		/* i592995 */
		wp_enqueue_script(sp_dsgvo_VERSION, plugin_dir_url(__FILE__). 'js/sp-dsgvo-admin.js', array('jquery'), sp_dsgvo_VERSION, false );

		/* i592995 */
		wp_localize_script(sp_dsgvo_VERSION, 'args', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
			'dismiss_confirm' => __('Are you sure you want to dismiss this request?', 'shapepress-dsgvo')
        ));
		/* i592995 */

	}



	public function enqueueColorPicker($hook_suffix){
	    wp_enqueue_style( 'wp-color-picker' );
   		wp_enqueue_script( 'wp-color-picker');
	}


	public function addCustomPostStates($states, $post){

		$pages = array(
		    SPDSGVOSettings::get('user_permissions_page') 	 => __('Privacy settings user page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('super_unsubscribe_page') 	 => __('Delete request page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('terms_conditions_page') 	 => __('Terms page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('explicit_permission_page') => __('Explicit permissions page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('opt_out_page') 			 => __('Opt Out page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('privacy_policy_page')		 => __('Privacy policy page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('sar_page')		 		 => __('Subject access request page','shapepress-dsgvo'),
		    SPDSGVOSettings::get('imprint_page')		 	 => __('Imprint page','shapepress-dsgvo')
		);

	    if(in_array($post->ID, array_keys($pages))){
			$states[] =  $pages[$post->ID];
	    }

    	return $states;
	}


	/**
	 * Filter: Adds Extra Column to users table
	 *
	 * @since    1.0.0
	 * @author Shapepress eU
	 */
	public function addExplicitPermissionColumn($column){
	    $column['terms'] = 'Terms';
	    return $column;
	}

	/**
	 * Filter: Adds Extra Column to users table
	 *
	 * @since  1.0.0
	 * @author Shapepress eU
	 */
	public function explicitPermissionColumnCallback($val, $columnName, $userID){
	    switch($columnName){
	        case 'terms':
	            return (hasUserAgreedToTerms($userID))? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>' ;
	            break;

	        default:
	        	return '';
	    }

	    return '';
	}


	/**
	 * Hook: Displays User Permission status
	 *
	 * @since    1.0.0
	 * @author Shapepress eU
	 * @param  WP_User $user
	 */
	public function showPermissonStatus($user){
		?>
			<h2><?php _e('Privacy settings of the user','shapepress-dsgvo')?></h2>
			<table class="form-table">
				<tbody>

					<tr class="user-profile-picture">
						<th><?php _e('Dienste','shapepress-dsgvo')?></th>
						<td>
							<ul>
								<?php foreach(SPDSGVOSettings::get('services') as $slug => $service): ?>
									<li>
										<strong><?= $service['name'] ?>:</strong>
										<?= (hasUserGivenPermissionFor($service['slug']))? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>' ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</td>
					</tr>

				</tbody>
			</table>
		<?php
	}


	/*
	* Gravity Forms Action
	*/
	public function gf_after_submisison_cleanse( $entry, $form ){

		// DELETE ALL ENTRIES
		if( SPDSGVOSettings::get('gf_save_no_data') ){
			GFAPI::delete_entry( $entry['id'] );
			return;
		}

		// DELETE IP and USER AGENT
		if( SPDSGVOSettings::get('gf_no_ip_meta') ){
			GFAPI::update_entry_property( $entry['id'], 'ip', '' );
			GFAPI::update_entry_property( $entry['id'], 'user_agent', '' );
		}

		// update fields to 'removed' that have been selected as 'do not save'
		$fields_to_delete = SPDSGVOSettings::get('gf_save_no_');
		if( !is_array($fields_to_delete) ){
			return;
		}
		if( isset($fields_to_delete[$form['id']]) ){
			foreach($fields_to_delete[$form['id']] as $field_id=>$check){
				if(!$check){
					continue;
				}

				if( isset($entry[$field_id]) ){
					// single level data
					GFAPI::update_entry_field( $entry['id'], $field_id, 'Removed' );
				} else {
					// multi level data (eg checkbox)
					$fields = preg_grep("/^".$field_id.".([0-9]*)$/", array_keys($entry)); // find keys like 2.1, 2.2 etc

					foreach( $fields as $field_id_key){
						if( $entry[$field_id_key] != '' ){
							GFAPI::update_entry_field( $entry['id'], $field_id_key, 'Removed' );
						}
					}
				}

			}
		}

	}

}
