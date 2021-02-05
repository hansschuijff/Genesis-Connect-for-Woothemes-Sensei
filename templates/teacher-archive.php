<?php
/**
 * The Template for displaying teacher author archives, this template wil show the teacher
 * and all course that belong to to them.
 *
 * This is a genesis compatible version of: sensei-lms\templates\teacher-archive.php
 * 
 * Override this template by copying it to your_theme/sensei/teacher-archive.php
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

function dwp_sensei_do_loop() {

	/**
	 * This action before teacher courses loop. This hook fires within the archive-course.php
	 * It fires even if the current archive has no posts.
	 *
	 * @since 1.9.0
	 */
	do_action( 'sensei_teacher_archive_course_loop_before' );
	?>

	<?php if ( have_posts() ) : ?>

		<?php sensei_load_template( 'loop-course.php' ); ?>

	<?php else : ?>

		<p><?php esc_html_e( 'There are no courses for this teacher.', 'sensei-lms' ); ?></p>

	<?php endif; // End If Statement ?>

	<?php

	/**
	 * This action runs after including the teacher archive loop. This hook fires within the teacher-archive.php
	 * It fires even if the current archive has no posts.
	 *
	 * @since 1.9.0
	 */
	do_action( 'sensei_teacher_archive_course_loop_after' );

	/**
	 * sensei_pagination hook
	 *
	 * @hooked sensei_pagination - 10 (outputs pagination)
	 */
	do_action( 'sensei_pagination' );

}
add_action( 'genesis_loop', 'dwp_sensei_do_loop' );

genesis();
