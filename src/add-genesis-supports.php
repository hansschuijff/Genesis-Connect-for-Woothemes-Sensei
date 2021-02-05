<?php
/**
 * Adds Genesis Supports to the Sensei LMS CPTs and Taxonomy.
 *
 * @package     DeWittePrins\GenesisConnect\SenseiLMS
 * @since       1.2.0
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
 * Adds Genesis Support to Sensei LMS post_types & taxonomies
 * 
 * 1. adds support for the genesis Page Layout Settings box
 * 2. adds support for the genesis Archive Settings box
 *
 * @since 1.2.0
 *
 * @return void
 */
function add_genesis_supports() {
	$sensei_post_types = array(
	'course', 
		'lesson', 
		'quiz',
		'question',
		'sensei_message', 
		'certificate',
		'multiple_question',
	);
	$genesis_supports = array( 
		'genesis-layouts',
		'genesis-cpt-archives-settings' 
	);
	foreach ($sensei_post_types as $post_type ) {
		\add_post_type_support( $post_type, $genesis_supports );
	}
}
add_action( 'genesis_setup', __NAMESPACE__ . '\add_genesis_supports' );
