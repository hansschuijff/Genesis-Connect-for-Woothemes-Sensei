<?php
/**
 * Sensei integration
 *
 * @package     GenesisConnectforWoothemesSensei
 * @since       1.2.0
 * @author      Christoph Herr
 * @link        https://www.christophherr.com
 * @license     GNU General Public License 2.0+
 */

/**
 * Declare theme support for Sensei
 *
 * @since 1.0.0
 */
function gcfws_sensei_support() {
	add_theme_support( 'sensei' );

	// this filter must be removed after the declaration of sensei theme support, 
	// since sensei otherwise forces the use of the page.php template.
	// remove_filter( 'template_include', array( 'Sensei_Templates', 'template_loader' ), 10, 1 );
}
add_action( 'after_setup_theme', 'gcfws_sensei_support' );
/**
 * Remove the default Woothemes Sensei wrappers.
 * Checks which version of Woothemes Sensei is running
 * and removes the wrappers accordingly.
 *
 * @since 1.1.0
 */
function gcfws_remove_default_sensei_wrappers() {

	if ( Sensei()->version >= '1.9.0' ) {
		remove_action( 'sensei_before_main_content', array( Sensei()->frontend, 'sensei_output_content_wrapper' ), 10 );
		remove_action( 'sensei_after_main_content', array( Sensei()->frontend, 'sensei_output_content_wrapper_end' ), 10 );
		return;
	}
	global $woothemes_sensei;
	remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
	remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );
}
add_action( 'genesis_meta', 'gcfws_remove_default_sensei_wrappers' );

/**
 * Genesis-specific opening wrapper for Sensei
 *
 * @since 1.0.0
 */
function gcfws_genesis_sensei_wrapper_start() {
	echo '<div class="content-sidebar-wrap"><main class="content" role="main" itemprop="mainContentOfPage">';
}
add_action( 'sensei_before_main_content', 'gcfws_genesis_sensei_wrapper_start', 10 );

/**
 * Genesis-specific closing wrapper for Sensei
 *
 * @since 1.0.0
 */
function gcfws_genesis_sensei_wrapper_end() {
	echo '</main> <!-- end main-->';
	genesis_get_sidebar();
	echo '</div> <!-- end .content-sidebar-wrap-->';
}
add_action( 'sensei_after_main_content', 'gcfws_genesis_sensei_wrapper_end', 10 );
