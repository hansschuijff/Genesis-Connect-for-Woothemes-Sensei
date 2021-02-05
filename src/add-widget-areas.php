<?php
/**
 * Adds After Entry Widget Areas to Single Lesson and Single Quiz pages 
 *
 * @package     DeWittePrins\GenesisConnect\SenseiLMS
 * @since       1.2.8
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
 * Register after entry widget areas for sensei LMS lessons and quizes
 *
 * @since 1.2.8
 * 
 * @return void
 */
function register_widget_areas() {
	genesis_register_sidebar(
		[
			'id'          => 'after-entry-lesson',
			'name'        => __( 'After Lesson Entry', 'genesis-connect-sensei-lms' ),
			'description' => __( 'Widgets in this widget area will display after single lesson entries.', 'genesis-connect-sensei-lms' ),
		]
	);
	genesis_register_sidebar(
		[
			'id'          => 'after-entry-quiz',
			'name'        => __( 'After Quiz Entry', 'genesis-connect-sensei-lms' ),
			'description' => __( 'Widgets in this widget area will display after single quiz entries.', 'genesis-connect-sensei-lms' ),
		]
	);
}
add_action('widgets_init', __NAMESPACE__ . '\register_widget_areas');

/**
 * Render after-entry-lesson widget area.
 *
 * @since 1.2.8
 *
 * @return void Return early if not singular quiz, or after entry lesson widget area is not active.
 */
function do_after_entry_lesson() {

	if ( ! is_singular( 'lesson' )
	||   ! is_active_sidebar('after-entry-lesson') ) {
        return;
    }
	genesis_widget_area(
		'after-entry-lesson',
		[
			'before' => '<div class="after-entry after-entry-lesson widget-area">',
			'after'  => '</div>',
		]
	);
}
add_action( 'genesis_after_entry_lesson', __NAMESPACE__ . '\do_after_entry_lesson', 21);

/**
 * Render after-entry-lesson widget area.
 *
 * @since 1.2.8
 *
 * @return void Return early if not singular quiz, or after entry quiz widget area is not active.
 */
function do_after_entry_quiz() {
	if ( ! is_singular( 'quiz' )
	||   ! is_active_sidebar('after-entry-quiz') ) {
        return;
    }

	genesis_widget_area(
		'after-entry-quiz',
		[
			'before' => '<div class="after-entry after-entry-quiz widget-area">',
			'after'  => '</div>',
		]
	);
}
add_action('genesis_after_entry_quiz', __NAMESPACE__ . '\do_after_entry_quiz', 21);
