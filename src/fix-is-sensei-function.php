<?php
/**
 * temporary fix for Sensei lms issue #3193
 * 
 * The is_sensei() function doesn't take all sensei pages in account
 * This function makes sure it recognizes all files that use sensei-templates:
 * 
 * Adds:
 * 1. the learners profile
 * 2. the course result page
 * 3. the teacher archive
 *
 * @package		DeWittePrins\GenesisConnect\SenseiLMS
 * @since		1.2.3
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
 * Adds missing pages to sensei's is_sensei function
 * 
 * Missing pages are:
 * 1. the learners profile
 * 2. the course result page
 * 3. the teacher archive
 * 
 * This function allows for custom pages to be marked as sensei pages 
 * by using the filter 'gcws_custom_sensei_lms_pages'
 * 
 * In this way themes can add pages that use sensei shortcodes to generate archives
 *  
 * @since 1.2.3
 * @param bool $is_sensei the result of the is_sensei function
 * @return bool
 */
function add_missing_pages_to_is_sensei( $is_sensei ) {

	// bail out early
	if ( $is_sensei ) {
		return true;
	}

	/**
	 * this filter allowsfor custom pages to be marked as being a sensei page
	 * callbacks should return a valid parameter for the is_page() function
	 * 
	 * @since 1.2.3
	 */
	$custom_sensei_lms_pages = apply_filters( 'gcfws_custom_sensei_lms_pages', "" );

	if ( $custom_sensei_lms_pages && is_page( $custom_sensei_lms_pages )) {

		return true;
	}

	if ( is_sensei_learner_profile() ) {

		return true;
	}

	if ( is_sensei_course_results_page() ) {

		return true;
	}

	return is_sensei_teacher_archive();
	
}
add_filter( 'is_sensei', __NAMESPACE__ . '\add_missing_pages_to_is_sensei' );


/**
 * Add body classes to sensei LMS pages the plugin only marks with the class sensei
 * 
 * - mark the My courses page with body class "my-sensei-courses-page"
 * 
 * - pages passed by filter 'gcfws_custom_sensei_lms_pages' 
 *   are marked with body class "custom-sensei-courses-page"
 * 
 *   this is meanth for pages that are build with the sensei_courses shortcode.
 *   Since they are also added to the is_sensei() selection, they will also have the "sensei" body class.
 *
 * - the courses page set in the settings page of sensei lms is marked as an course-archive 
 *   and is not accessible as a page. Sensei LMS just uses that page for the slug.
 *
 * - all other sensei pages already have recognizable individual body classes 
 * 
 * @since 1.2.3
 * @param bool $is_sensei the result of the is_sensei function
 * @return bool
 * 
 */
function add_custom_body_class_to_sensei_pages( $classes ) {

	if ( is_page( Sensei()->settings->settings['my_course_page'] ) ) {

		$classes[] = 'my-sensei-courses';

	} else {
	
		/**
		 * this filter allows for custom pages to be marked as being a sensei page
		 * callbacks should return a valid parameter for the is_page() function
		 * 
		 * @since 1.2.3
		 */
		$custom_sensei_lms_pages = apply_filters( 'gcfws_custom_sensei_lms_pages', "" );

		if ( $custom_sensei_lms_pages && is_page( $custom_sensei_lms_pages )) {

			$classes[] = 'sensei-courses-custom-page';
		}
	}


	return $classes;
}
add_action( 'body_class', __NAMESPACE__ . '\add_custom_body_class_to_sensei_pages' );


/**
 * checks if the current page is a sensei learner profile page
 * 
 * @since 1.2.3
 * 
 * @return bool
 */
function is_sensei_learner_profile() {
	global $wp_query;

	return isset( $wp_query->query_vars['learner_profile'] );
}

/**
 * checks if the current page is a sensei course results page
 * 
 * @since 1.2.3
 * 
 * @return bool
 */
function is_sensei_course_results_page() {
	global $wp_query;
		
	return isset( $wp_query->query_vars['course_results'] );
}

/**
 * checks if the current page is sensei teacher archive
 * 
 * @since 1.2.3
 * 
 * @return bool
 */
function is_sensei_teacher_archive() {

	if ( is_author() 
		&& Sensei_Teacher::is_a_teacher( get_query_var( 'author' ) ) 
		&& ! user_can( get_query_var( 'author' ), 'manage_options' ) ) {

		return true;
	}

	return false;
}
