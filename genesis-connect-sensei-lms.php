<?php
/**
 * Plugin Name: Genesis Connect for Sensei LMS
 * Plugin URI:  https://github.com/hansschuijff/genesis-connect-sensei-lms
 * Description: Plugin to easily integrate the Sensei LMS plugin with the Genesis Framework. This plugin will only work with the Genesis Framework and its child themes. It is an enhanced and corrected version of the genesis connect plugin of Christoph Herr
 * Author:      Hans Schuijff
 * Author URI:  https://dewitteprins.nl
 * Version:     1.2.8
 * Text Domain: genesis-connect-sensei-lms
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package   DeWittePrins\GenesisConnect\SenseiLMS
 * @author    Hans Schuijff
 * @version   1.2.7
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
		$plugin_data_store ['PluginDir']        = trailingslashit( __DIR__ );
		$plugin_data_store ['dir']              = trailingslashit( __DIR__ );
		$plugin_data_store ['source-dir']       = $plugin_data_store ['dir'] . 'src/';
		$plugin_data_store ['config-dir']       = $plugin_data_store ['dir'] . 'config/';
		$plugin_data_store ['admin-source-dir'] = $plugin_data_store ['dir'] . 'admin/';
		$plugin_data_store ['admin-views-dir']  = $plugin_data_store ['dir'] . 'admin/views/';

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
 * Are plugin requirements met?
 *
 * @since 1.2.8
 * @return boolean True when required plugins and themes are active, otherwises false;
 */
function should_plugin_run() {
	if ( is_genesis_loaded() && is_sensei_loaded() ) {
		return true;
	}
	render_admin_notices();
	return false;
}

/**
 * Render admin notices.
 * 
 * Render the proper admin notices 
 * to inform users on any plugin requirments that are not met.
 *
 * @since 1.2.8
 * @return void
 */
function render_admin_notices() {
	if ( ! is_admin() ) {
		return;
	}
	require_once get_plugin_data('admin-source-dir') . 'notices.php';
	if ( ! is_genesis_loaded() ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\genesis_required_notice' );
	}
	if ( ! is_sensei_loaded() ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\sensei_required_notice' );
	}
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}

/**
 * Is Sensei LMS loaded?
 * 
 * Initiates an admin notice when Sensei LMS is not active.
 *
 * @since 1.2.8
 * @return boolean True when Sensei LMS is active, otherwise false.
 */
function is_sensei_loaded() {
	return function_exists( 'sensei' );
}

/**
 * Is the Genesis Framework loaded?
 * 
 * Initiates an admin notice when Sensei LMS is not active.
 *
 * @since 1.2.8
 * @return boolean True when Sensei LMS is active, otherwise false.
 */
function is_genesis_loaded() {
	return function_exists( 'genesis' );
}

/**
 * Load plugin textdomain.
 *
 * @since 1.0.1
 * @return void
 */
function load_textdomain() {
	load_plugin_textdomain( 'genesis-connect-sensei-lms', false, namespace\PlUGIN_LANGUAGES_DIR );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain' );

/**
 * Get runtime configuration files for a given contexts.
 *
 * @since 1.2.8
 * @param string $context
 * @return array The runtime configuration for the context.
 */
function get_config( string $context ) {
	static $_config_store;
	if ( ! isset( $_config_store[ $context ] ) ) {
		$_config_store[ $context ] = require get_plugin_data( 'config-dir' ) . $context . '.php';
	}
	return $_config_store[ $context ];
}

/**
 * Load the plugin files.
 * 
 * Check if plugin requirements are met and load plugin files.
 *
 * @since 1.2.0
 * @return void
 */
function autoloader() {
	if ( ! should_plugin_run() ) {
		return;
	}
	$plugin_files = get_config( 'autoload' );
	foreach ( $plugin_files as $file ) {
		require_once namespace\PLUGIN_DIR . 'src/' . $file . '.php'; 
	}
}
/**
 * Plugin is loaded a this hook, because genesis 
 * and sensei lms need to be loaded already for it to function.
 */
add_action( 'after_setup_theme', __NAMESPACE__ . '\autoloader' );
