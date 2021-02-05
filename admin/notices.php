<?php
/**
 * Callbacks for `admin_notices` action to load HTML notices.
 *
 * @package Genesis_Connect_WooCommerce
 * @since 1.0
 */
namespace DeWittePrins\GenesisConnect\SenseiLMS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display notice message if Sensei LMS is not active.
 *
 * Callback for WordPress 'admin_notices' action.
 *
 * @since 1.0
 */
function sensei_required_notice() {
	include get_plugin_data('admin-views-dir') . 'sensei-required-notice.php';
}

/**
 * Display notice message if Genesis is not active.
 *
 * Callback for WordPress 'admin_notices' action.
 *
 * @since 1.0
 */
function genesis_required_notice() {
	include get_plugin_data('admin-views-dir') . 'genesis-required-notice.php';
}
