<?php
/**
 * Add Sensei integration:
 * - Declare sensei theme support
 * - Replace sensei content wrappers by genesis wrappers
 * - Use genesis sidebar
 *
 * @package     DeWittePrins\GenesisConnect\SenseiLMS
 * @since       1.2.2
 * @author      Hans Schuijff
 * @link        https://github.com/hansschuijff/genesis-connect-sensei-lms
 * @license     GNU General Public License 2.0+
 */
namespace DeWittePrins\GenesisConnect\SenseiLMS;

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( _e( 'Sorry, you are not allowed to access this page directly.', 'genesis-connect-sensei-lms' ) );
}

/**
 * Declare theme support for Sensei
 *
 * @since 1.0.0
 */
function declare_sensei_theme_support() {

	add_theme_support( 'sensei' );

	// this filter must be removed after the declaration of sensei theme support, 
	// since sensei otherwise forces the use of the page.php template.
	// remove_filter( 'template_include', array( 'Sensei_Templates', 'template_loader' ), 10, 1 );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\declare_sensei_theme_support' );

/**
 * Removes the default Woothemes Sensei wrappers.
 * 
 * Checks which version of Woothemes Sensei is running
 * and removes the wrappers accordingly.
 *
 * @since 1.1.0
 */
function remove_default_sensei_content_wrappers() {

	if ( Sensei()->version < '1.9.0' ) {

		// Legacy code	(for Sensei LMS versions before 1.9.0)
		global $woothemes_sensei;
		remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
		remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );

		return;
	}

	remove_action( 'sensei_before_main_content', array( Sensei()->frontend, 'sensei_output_content_wrapper' ), 10 );
	remove_action( 'sensei_after_main_content', array( Sensei()->frontend, 'sensei_output_content_wrapper_end' ), 10 );
	
}
add_action( 'genesis_meta', __NAMESPACE__ . '\remove_default_sensei_content_wrappers' );

/**
 * Renders Genesis-specific opening wrappers for Sensei
 *
 * @since 1.0.0
 */
function render_genesis_sensei_content_wrapper_open() {
	echo '<div class="content-sidebar-wrap">';
	echo '    <main class="content" role="main" itemprop="mainContentOfPage">';
}
add_action( 'sensei_before_main_content', __NAMESPACE__ . '\render_genesis_sensei_content_wrapper_open', 10 );

/**
 * Renders Genesis-specific closing wrappers for Sensei LMS
 *
 * @since 1.0.0
 */
function render_genesis_sensei_content_wrapper_close() {
	echo '    </main> <!-- end main-->';
	genesis_get_sidebar();
	echo '</div> <!-- end .content-sidebar-wrap-->';
}
add_action( 'sensei_after_main_content', __NAMESPACE__ . '\render_genesis_sensei_content_wrapper_close', 10 );
