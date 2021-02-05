<?php
/**
 * View for WordPress `admin_notice` if WooCommerce is not active.
 *
 * @package Genesis_Connect_WooCommerce
 * @since 1.0.0
 */
namespace DeWittePrins\GenesisConnect\SenseiLMS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="message" class="error notice">
	<p>
		<?php esc_html_e( 'Genesis Connect for Sensei LMS requires Sensei LMS. Please activate Sensei LMS or disable Genesis Connect.', 'genesis-connect-sensei-lms' ); ?>
	</p>
</div>
