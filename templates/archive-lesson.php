<?php
/**
 * The Template for displaying lesson archives, including the lesson page template.
 * This template also handels the lesson modules taxonomy and the lessons_tag taxonomy.
 *
 * Override this template by copying it to your_theme/sensei/archive-lesson.php
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

function dwp_sensei_do_lesson_loop() {

	/**
	 * Action before lesson archive loop. This action runs within the archive-lesson.php.
	 *
	 * It will be executed even if there are no posts on the archive page.
	 */
	do_action( 'sensei_archive_before_lesson_loop' );
		
		if ( have_posts() ) : 

			sensei_load_template( 'loop-lesson.php' );

		else : ?>

			<p><?php esc_html_e( 'No lessons found that match your selection.', 'sensei-lms' ); ?></p>

		<?php endif; // End If Statement 

			/**
			 * Action after lesson archive  loop on the archive-lesson.php template file
			 * It will be executed even if there are no posts on the archive page.
			 *
			 * @since 1.9.0
			 */
			do_action( 'sensei_archive_after_lesson_loop' );

	/**
	 * sensei_pagination hook
	 *
	 * @hooked sensei_pagination - 10 (outputs pagination)
	 */
	do_action( 'sensei_pagination' );

}
add_action( 'genesis_loop', 'dwp_sensei_do_lesson_loop' );

genesis();