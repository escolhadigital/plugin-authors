<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              joelrocha.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       WP Custom Plugin
 * Plugin URI:        http://joelrocha.com
 * Description:       Custom plugin with some code.
 * Version:           1.0.0
 * Author:            Joel Rocha
 * Author URI:        http://joelrocha.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpcp
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpcp-activator.php
 */
register_activation_hook( __FILE__, 'activate_wpcp' );
function activate_wpcp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-activator.php';
	Wpcp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpcp-deactivator.php
 */
register_deactivation_hook( __FILE__, 'deactivate_wpcp' );
function deactivate_wpcp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpcp-deactivator.php';
	Wpcp_Deactivator::deactivate();
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpcp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_init() {

	$plugin = new Wpcp();
	$plugin->run();

}

// add_action('admin_menu', 'wpcp_plugin_setup_menu');
function wpcp_plugin_setup_menu(){
  add_menu_page( 'WP Custom Plugin', 'WP Custom Plugin', 'manage_options', 'wpcp', '_init' );
}

function _init() {
	echo "Possible options page";
}

// EXECUTE PLUGIN
run_plugin_init();
