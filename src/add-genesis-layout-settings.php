<?php
/**
 * Adds Genesis Layout options to the Sensei CPTs and Taxonomy.
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
 * Adds the Genesis Layout options to single CPT posts 
 * and Adds Genesis CPT archive Settings to the CPT archives.
 *
 * @since 1.2.0
 *
 * @return void
 */
function add_genesis_layout_to_sensei_post_types() {

	add_post_type_support( 'course', array( 'genesis-layouts', 'genesis-cpt-archives-settings' ) );
	add_post_type_support( 'lesson', array( 'genesis-layouts', 'genesis-cpt-archives-settings' ) );
	add_post_type_support( 'question', array( 'genesis-layouts', 'genesis-cpt-archives-settings' ) );
	add_post_type_support( 'quiz', array( 'genesis-layouts', 'genesis-cpt-archives-settings' ) );
	add_post_type_support( 'sensei_message', array( 'genesis-layouts', 'genesis-cpt-archives-settings' ) );

	// perhaps not needed:
	add_post_type_support( 'certificate', array( 'genesis-layouts', 'genesis-cpt-archives-settings' ) );
	add_post_type_support( 'multiple_question', array( 'genesis-layouts', 'genesis-cpt-archives-settings' ) );

}
add_action( 'genesis_setup', __NAMESPACE__ . '\add_genesis_layout_to_sensei_post_types' );
