<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wp-dsgvo.eu
 * @since             1.0.0
 * @package           WP DSGVO Tools
 *
 * @wordpress-plugin
 * Plugin Name:       WP DSGVO Tools
 * Plugin URI:        https://wp-dsgvo.eu
 * Description:       WP DSGVO Tools helfen beim Erf&uuml;llen der Richtlinien der Datenschutzgrundverordnung (<a target="_blank" href="https://ico.org.uk/for-organisations/data-protection-reform/overview-of-the-gdpr/">DSGVO</a>), spezialisiert auf &Ouml;sterreich und Deutschland.
 * Version:           2.1.3
 * Author:            Shapepress eU
 * Author URI:        https://www.shapepress.com
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shapepress-dsgvo
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die();
}

define('sp_dsgvo_VERSION', '2.1.3');
define('sp_dsgvo_NAME', 'sp-dsgvo');
/* i592995 */
define('sp_dsgvo_URL', plugin_dir_url( __FILE__ ));
/* i592995 */

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sp-dsgvo-activator.php
 */
function activate_sp_dsgvo()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-sp-dsgvo-activator.php';
    SPDSGVOActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sp-dsgvo-deactivator.php
 */
function deactivate_sp_dsgvo()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-sp-dsgvo-deactivator.php';
    SPDSGVODeactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_sp_dsgvo');
register_deactivation_hook(__FILE__, 'deactivate_sp_dsgvo');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-sp-dsgvo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_sp_dsgvo()
{
    load_plugin_textdomain('shapepress-dsgvo', false, basename(dirname(__FILE__)) . '/languages/');
    $plugin = SPDSGVO::instance();
    $plugin->run();
}
add_action('init', 'run_sp_dsgvo');
