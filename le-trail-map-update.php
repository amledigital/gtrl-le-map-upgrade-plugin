<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           LE Trail Map Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Le Trail Map Plugin
 * Description:       2025 Trail Map Revisions
 * Version:           0.0.1
 * Author:            Lake Effect Digital
 * Author URI:        https://ledigital.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       le-trail-map-plugin
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
define( 'LE_TRAIL_MAP_PLUGIN_VERSION', '0.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-le-trail-map-update-activator.php
 */
function activate_LE_Trail_Map_Update() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-le-trail-map-update-activator.php';
	LE_Trail_Map_Update_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-le-trail-map-update-deactivator.php
 */
function deactivate_LE_Trail_Map_Update() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-le-trail-map-update-deactivator.php';
	LE_Trail_Map_Update_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_LE_Trail_Map_Update' );
register_deactivation_hook( __FILE__, 'deactivate_LE_Trail_Map_Update' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-le-trail-map-update.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_LE_Trail_Map_Update() {

	$plugin = new LE_Trail_Map_Update();
	
	$plugin->run();

}
run_LE_Trail_Map_Update();
