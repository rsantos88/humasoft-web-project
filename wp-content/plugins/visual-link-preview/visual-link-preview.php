<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://bootstrapped.ventures/
 * @since             1.0.0
 * @package           Visual_Link_Preview
 *
 * @wordpress-plugin
 * Plugin Name:       Visual Link Preview
 * Plugin URI:        http://bootstrapped.ventures/visual-link-preview/
 * Description:       Display a fully customizable visual link preview for any internal or external link.
 * Version:           2.1.0
 * Author:            Bootstrapped Ventures
 * Author URI:        http://bootstrapped.ventures/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       visual-link-preview
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vlp-activator.php
 */
function activate_visual_link_preview() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vlp-activator.php';
	VLP_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vlp-deactivator.php
 */
function deactivate_visual_link_preview() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vlp-deactivator.php';
	VLP_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_visual_link_preview' );
register_deactivation_hook( __FILE__, 'deactivate_visual_link_preview' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-visual-link-preview.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_visual_link_preview() {
	$plugin = new Visual_Link_Preview();
}
run_visual_link_preview();
