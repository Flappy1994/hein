<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://logichunt.com
 * @since             1.0.0
 * @package           Wp_Counter_Up
 *
 * @wordpress-plugin
 * Plugin Name:       WP Counter Up
 * Plugin URI:        http://logichunt.com/product/wordpress-counter-up
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.2.0
 * Author:            LogicHunt
 * Author URI:        http://logichunt.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-counter-up
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_COUNTER_UP', '1.2.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-counter-up-activator.php
 */
function activate_wp_counter_up() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-counter-up-activator.php';
	Wp_Counter_Up_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-counter-up-deactivator.php
 */
function deactivate_wp_counter_up() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-counter-up-deactivator.php';
	Wp_Counter_Up_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_counter_up' );
register_deactivation_hook( __FILE__, 'deactivate_wp_counter_up' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-counter-up.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_counter_up() {

	$plugin = new Wp_Counter_Up();
	$plugin->run();

}
run_wp_counter_up();
