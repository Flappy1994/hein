<?php
	/**
		* Plugin Name:       Wow Countdowns (free version)
		* Plugin URI:        https://wordpress.org/plugins/mwp-countdown/
		* Description:       Create timers & countdowns. Increase your sales & conversions with scarcity & urgency effects!
		* Version:           3.1.1
		* Author:            Wow-Company
		* Author URI:        https://wow-estore.com/author/admin/?author_downloads=true
		* License:           GPL-2.0+
		* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	*/
	if ( ! defined( 'WPINC' ) ) {die;}
	// Declaration Wow-Company class
	if( !class_exists( 'Wow_Company' )) {
		require_once plugin_dir_path( __FILE__ ) . 'asset/class-wow-company.php';					
	}	
	if( !class_exists( 'WOW_DATA' )) {
		require_once plugin_dir_path( __FILE__ ) . 'include/class/data.php';
	}
	if( !class_exists( 'JavaScriptPacker' )) {
		require_once plugin_dir_path( __FILE__ ) . 'include/class/packer.php';
	}
	// Declaration of the plugin class
	if( !class_exists( 'Wow_Countdowns_Class' ) ) {
		class Wow_Countdowns_Class
		{	
			const PREF = 'countdowns_free';
			function __construct() {
				$this->name = 'Wow Countdowns';
				$this->menuname = 'Countdowns';
				$this->version = '3.1.1';				
				$this->pluginname = dirname(plugin_basename(__FILE__));
				$this->plugindir = plugin_dir_path( __FILE__ );
				$this->pluginurl = plugin_dir_url( __FILE__ );	
				// activate & diactivate
				register_activation_hook( __FILE__, array($this, 'plugin_activate' ) );
				register_deactivation_hook( __FILE__, array($this, 'plugin_deactivate') );	
				add_action('admin_init', array($this, 'updata_data') );
				// admin pages
				add_action( 'admin_menu', array($this, 'add_menu_page') );
				// show on front end
				add_shortcode('Wow-Countdowns', array($this, 'shortcode') );
				add_shortcode('mwpCountdownFree', array($this, 'shortcode') );
				// admin links
				add_filter( 'plugin_row_meta', array($this, 'row_meta'), 10, 4 );
				add_filter( 'plugin_action_links', array($this, 'action_links'), 10, 2 );
				// check asset folder
				add_filter( 'admin_init', array($this, 'asset_folder') );				
			}
			// Activate & diactivate
			function plugin_activate() {
				require_once plugin_dir_path( __FILE__ ) . 'include/activator.php';	
			}
			function plugin_deactivate() {	
				require_once plugin_dir_path( __FILE__ ) . 'include/deactivator.php';
			}
			function updata_data() {
				require_once plugin_dir_path( __FILE__ ) . 'include/update.php';
			}
			// AdminPanel
			function add_menu_page() {
				add_submenu_page('wow-company', $this->name, $this->menuname, 'manage_options', $this->pluginname, array( $this, 'plugin_admin' ));
			}
			function plugin_admin() {
				$name = $this->name;	
				$pluginname = $this->pluginname;
				$version = $this->version;
				global $wow_company_plugin;	
				$wow_company_plugin = true;									
				include_once( 'admin/partials/main.php' );
				self:: plugin_admin_style_script();				
			}					
			function plugin_admin_style_script() {
				// plugin sctyle & script			
				wp_enqueue_style( $this->pluginname.'-style', $this->pluginurl . 'admin/css/style.css',false, $this->version);
				wp_enqueue_script($this->pluginname.'-script', $this->pluginurl . 'admin/js/script.js', array('jquery'), $this->version);
				// icon style
				wp_enqueue_style( $this->pluginname.'-icon', $this->pluginurl . 'asset/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
			}		
			// Show on Front end
			function shortcode($atts) {
				extract(shortcode_atts(array('id' => ""), $atts));		
				global $wpdb;
				$table = $wpdb->prefix . "wow_".self::PREF;    
				$sSQL = $wpdb->prepare("select * from $table WHERE id = %d", $id);
				$arrresult = $wpdb->get_results($sSQL); 	
				if (count($arrresult) > 0) {
					foreach ($arrresult as $key => $val) {	
						$param = unserialize($val->param);
						ob_start();
						include( 'public/partials/public.php' );
						$form = ob_get_contents();
						ob_end_clean();	
						$path_style = $this->plugindir.'/asset/css/style-'.$val->id.'.css';
						$path_script = $this->plugindir.'/asset/js/script-'.$val->id.'.js';
						$file_style = $this->plugindir.'/admin/partials/generator/style.php';
						$file_script = $this->plugindir.'/admin/partials/generator/script.php';
						if (file_exists($file_style) && !file_exists($path_style)){
							ob_start();
							include ($file_style);
							$content_style = ob_get_contents();
							ob_end_clean();
							file_put_contents($path_style, $content_style);
						}			
						if (file_exists($file_script) && !file_exists($path_script)){
							ob_start();
							include ($file_script);
							$content_script = ob_get_contents();
							$packer = new JavaScriptPacker($content_script, 'Normal', true, false);
							$packed = $packer->pack();
							ob_end_clean();
							file_put_contents($path_script, $packed);				
						}																						
						if (file_exists($path_style)) {
							$time = !empty($param['time']) ? $param['time'] : '';
							wp_enqueue_style( $this->pluginname.'-'.$val->id, $this->pluginurl. 'asset/css/style-'.$val->id.'.css', array(), $time);	
						}
						if (file_exists($path_script)) {	
							$time = !empty($param['time']) ? $param['time'] : '';
							wp_enqueue_script( $this->pluginname.'-'.$val->id, $this->pluginurl. 'asset/js/script-'.$val->id.'.js', array( 'jquery' ), $time );
						}	
						if ($param['type'] == 3 || $param['type'] == 5 ){
							wp_enqueue_script( $this->pluginname.'-cookie', plugin_dir_url( __FILE__ ) . 'public/js/jquery.cookie.js', array( 'jquery' ) );
						}
					}
				} 
				else {
					$form = null;
				}
				return $form;
			}			
			// Admin links
			function row_meta( $meta, $plugin_file ){
				if( false === strpos( $plugin_file, basename(__FILE__) ) )
				return $meta;
				$meta[] = '<a href="https://wow-estore.com/item/wow-countdowns-pro/" target="_blank">Pro version</a>';
				return $meta;
			}
			function action_links( $actions, $plugin_file ){
				if( false === strpos( $plugin_file, basename(__FILE__) ) )
				return $actions;
				$settings_link = '<a href="admin.php?page='. $this->pluginname .'">Settings</a>'; 
				array_unshift( $actions, $settings_link ); 
				return $actions; 
			}
			// check asset folder
			function asset_folder(){
				$path = plugin_dir_path( __FILE__ ).'asset';
				if (!is_writable($path)) {
					echo "<div class='error' id='message'><p>Please set the 775 access rights (chmod 775) for the '".$path."</p> </div>";
				} 
			}			
		}
		$plugin = new Wow_Countdowns_Class();		
	}		