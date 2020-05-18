<?php
/**
 * The Template for displaying all single courses.
 *
 * Override this template by copying it to yourtheme/sensei/single-course.php
 *
 * @author      Automattic
 * @package     Sensei
 * @category    Templates
 * @version     1.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

remove_action( 'genesis_loop', 'genesis_do_loop' );

function dwp_sensei_do_single_course_loop() {

	?>
	<article <?php post_class( array( 'course', 'post' ) ); ?>>

		<?php

		/**
		 * Hook inside the single course post above the content
		 *
		 * @since 1.9.0
		 *
		 * @param integer $course_id
		 *
		 * @hooked Sensei()->frontend->sensei_course_start     -  10
		 * @hooked Sensei_Course::the_title                    -  10
		 * @hooked Sensei()->course->course_image              -  20
		 * @hooked Sensei_Course::the_course_enrolment_actions -  30
		 * @hooked Sensei()->message->send_message_link        -  35
		 * @hooked Sensei_Course::the_course_video             -  40
		 */
		do_action( 'sensei_single_course_content_inside_before', get_the_ID() );

		?>

		<section class="entry fix">

			<?php the_content(); ?>

		</section>

		<?php

		/**
		 * Hook inside the single course post above the content
		 *
		 * @since 1.9.0
		 *
		 * @param integer $course_id
		 */
		do_action( 'sensei_single_course_content_inside_after', get_the_ID() );

		?>
		
	</article> <!-- .post .single-course -->

	<?php
	/**
	 * sensei_pagination hook
	 *
	 * @hooked sensei_pagination - 10 (outputs pagination)
	 */
	do_action( 'sensei_pagination' );

}
add_action( 'genesis_loop', 'dwp_sensei_do_single_course_loop' );

genesis();
