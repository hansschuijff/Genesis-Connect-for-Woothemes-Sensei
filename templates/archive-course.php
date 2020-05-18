<?php
/**
 * The Template for displaying course archives, including the course page template.
 *
 * Override this template by copying it to your_theme/sensei/archive-course.php
 *
 * @author      Automattic
 * @package     Sensei
 * @category    Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

remove_action( 'genesis_loop', 'genesis_do_loop' );

function dwp_sensei_do_course_loop() {

	/**
	 * This action before course archive loop. This hook fires within the archive-course.php
	 * It fires even if the current archive has no posts.
	 *
	 * @since 1.9.0
	 *
	 * @hooked Sensei_Course::course_archive_sorting 20
	 * @hooked Sensei_Course::course_archive_filters 20
	 * @hooked Sensei_Templates::deprecated_archive_hook 80
	 */

	do_action( 'sensei_archive_before_course_loop' );

	if ( have_posts() ) : 

	sensei_load_template( 'loop-course.php' );

	else : ?>

		<p><?php esc_html_e( 'No courses found that match your selection.', 'sensei-lms' ); ?></p>

	<?php endif; // End If Statement

		/**
		 * This action runs after including the course archive loop. This hook fires within the archive-course.php
		 * It fires even if the current archive has no posts.
		 *
		 * @since 1.9.0
		 */
		do_action( 'sensei_archive_after_course_loop' );

	/**
	 * sensei_pagination hook
	 *
	 * @hooked sensei_pagination - 10 (outputs pagination)
	 */
	do_action( 'sensei_pagination' );

}
add_action( 'genesis_loop', 'dwp_sensei_do_course_loop' );

genesis();
