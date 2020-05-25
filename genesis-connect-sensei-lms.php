<?php
/**
 * Plugin Name: Genesis Connect for Sensei LMS
 * Plugin URI:  https://github.com/hansschuijff/genesis-connect-sensei-lms
 * Description: Plugin to easily integrate the Sensei LMS plugin with the Genesis Framework. This plugin will only work with the Genesis Framework and its child themes. It is an enhanced and corrected version of the genesis connect plugin of Christoph Herr
 * Author:      Hans Schuijff
 * Author URI:  https://dewitteprins.nl
* Version:     1.2.3
 * Text Domain: genesis-connect-sensei-lms
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package   DeWittePrins\GenesisConnect\SenseiLMS
 * @author    Hans Schuijff
 * @version   1.2.4
 * @license   GPL-2.0+
 *
 * Genesis Connect for Sensei LMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Genesis Connect for Sensei LMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Genesis Connect for Sensei LMS. If not, see <http://www.gnu.org/licenses/>.
 */
namespace DeWittePrins\GenesisConnect\SenseiLMS;

// Prevent direct access to the plugin.
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( _e( 'Sorry, you are not allowed to access this page directly.', 'genesis-connect-sensei-lms' ) );
}

define( __NAMESPACE__ . '\TEMPLATE_DIR', get_plugin_data('TemplatesDir') );

// Plugin version
define( __NAMESPACE__ . '\PLUGIN_VERSION', get_plugin_data('Version') );

// Fully Qualified name of plugin's base directory
define( __NAMESPACE__ . '\PLUGIN_DIR', get_plugin_data('PluginDir') );

// Full URL to the plugin's base directory
define( __NAMESPACE__ . '\PLUGIN_URL', get_plugin_data('PluginURL') );

// Fully Qualified name of plugin bootstrap file
define( __NAMESPACE__ . '\PLUGIN_BOOTSTRAP_FILE', get_plugin_data('PluginFile') );

// name of plugin bootstrap file with relative path (from plugins folder)
define( __NAMESPACE__ . '\PLUGIN_BASENAME', get_plugin_data('BaseName') );

// plugins text domain
define( __NAMESPACE__ . '\PLUGIN_TEXT_DOMAIN', get_plugin_data('TextDomain') );

// plugins text domain
define( __NAMESPACE__ . '\PlUGIN_LANGUAGES_DIR', get_plugin_data('LanquagesDir') );

/**
 * Retrieves and returns plugin data
 * 
 * @since 1.2.3
 * @param string $key indicates what data should be returned.
 * @return string|array the value belonging to $key or a plugin containing all plugin data
 */
function get_plugin_data( $key = false) {
	
	static $plugin_data_store = [];

	if ( ! function_exists( '\get_plugin_data' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	// first time build data, after that use plugin data store
	if ( !$plugin_data_store ) {

		// get plugin data from file header
		$plugin_data_store = \get_plugin_data( __FILE__, false, false );
		
		// Fully Qualified name of plugin's base directory
		$plugin_data_store ['PluginDir'] = trailingslashit( __DIR__ );

		// Full URL to the plugin's base directory
		$plugin_data_store ['PluginURL'] = plugin_dir_url( __FILE__ );

		// Fully Qualified name of plugin bootstrap file
		$plugin_data_store ['PluginFile'] = __FILE__;

		// Name of plugin bootstrap file with relative path (from plugins folder)
		$plugin_data_store ['BaseName'] = plugin_basename( __FILE__ );

		// Plugins base directory ( Relative to plugins folder ) 
		$plugin_data_store ['BaseDir'] = trailingslashit( plugin_basename( __DIR__ ) );

		// Fully Qualified name of plugin's template directory
		$plugin_data_store ['TemplatesDir'] = $plugin_data_store ['PluginDir'] . 'templates/';

		// Relative path to language files ( .pot, .po, .mo )
		$plugin_data_store ['LanguagesDir'] = $plugin_data_store ['BaseDir'] . 'languages';
		
	}

	if ( $key ) {

		if ( isset( $plugin_data_store[ $key ] ) ) {

			return $plugin_data_store[ $key ];
		}

		return '';
	}

	return $plugin_data_store;
}

/**
 * Load plugin textdomain.
 *
 * @since 1.0.1
 *
 * @return void
 */
function load_textdomain() {
	
	load_plugin_textdomain( 'genesis-connect-sensei-lms', false, namespace\PlUGIN_LANGUAGES_DIR );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain' );

/**
 * This function runs on plugin activation. It checks to make sure the
 * Genesis Framework and Woothemes Sensei are active. If not, it deactivates the plugin.
 *
 * @since 1.0.0
 *
 * @return void
 */
function activation() {

	if ( ! function_exists( 'genesis' ) ) {
		
		// Deactivate.
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', __NAMESPACE__ . '\render_admin_notice' );
	}
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\activation' );

/**
 * This function is triggered when the WordPress theme is changed.
 * It checks if the Genesis Framework is active. If not, it deactivates the plugin.
 *
 * @since 1.0.0
 *
 * @return void
 */
function plugin_deactivate() {

	if ( ! function_exists( 'genesis' ) ) {

		// Deactivate.
		deactivate_plugins( plugin_basename( __FILE__ ) );
		add_action( 'admin_notices', __NAMESPACE__ . '\render_admin_notice' );
	}
}
add_action( 'admin_init', __NAMESPACE__ . '\plugin_deactivate' );
add_action( 'switch_theme', __NAMESPACE__ . '\plugin_deactivate' );

/**
 * Error message if you're not using the Genesis Framework.
 *
 * @since 1.0.0
 *
 * @return void
 */
function render_admin_notice() {

	$error = sprintf(
		// translators: Link to the Studiopress website.
		__( 'Sorry, you can\'t use the Genesis Connect for Sensei LMS Plugin unless the <a href="%s">Genesis Framework</a> is active. The plugin has been deactivated.', 'genesis-connect-sensei-lms' ),
		'http://www.studiopress.com'
	);

	printf( '<div class="error"><p>%s</p></div>', $error );

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}

/**
 * Load the plugin files.
 *
 * @since 1.2.0
 *
 * @return void
 */
function autoloader() {

	$plugin_files = [
		'sensei-lms-integration',
		'template-loader',
		'add-genesis-layout-settings',
		'fix-is-sensei-function',
		'add-course-module-to-lesson-admin'
	];

	foreach ( $plugin_files as $file ) {

		require namespace\PLUGIN_DIR . 'src/' . $file . '.php'; 
	}
}
autoloader();
