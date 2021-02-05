<?php
/**
 * The Template for displaying all single lessons.
 *
 * This is a genesis compatible version of: sensei-lms\templates\single-lesson.php
 * 
 * Override this template by copying it to yourtheme/sensei/single-lesson.php
 *
 * @author      Automattic
 * @package     Sensei
 * @category    Templates
 * @version     1.12.2
 */
namespace DeWittePrins\GenesisConnect\SenseiLMS;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

remove_action( 'genesis_loop', 'genesis_do_loop' );

function dwp_sensei_do_single_lesson_loop() {

	global $post;

	if ( have_posts() ) {
		the_post();
	}
	?>
	<article <?php post_class( array( 'lesson', 'post' ) ); ?>>

		<?php

			/**
			 * Hook inside the single lesson above the content
			 *
			 * @since 1.9.0
			 *
			 * @param integer $lesson_id
			 *
			 * @hooked deprecated_lesson_image_hook - 10
			 * @hooked deprecate_sensei_lesson_single_title - 15
			 * @hooked Sensei_Lesson::lesson_image() -  17
			 * @hooked deprecate_lesson_single_main_content_hook - 20
			 */
			do_action( 'sensei_single_lesson_content_inside_before', get_the_ID() );

		?>

		<section class="entry fix">

			<?php

			if ( sensei_can_user_view_lesson() ) {

				if ( apply_filters( 'sensei_video_position', 'top', $post->ID ) == 'top' ) {

					do_action( 'sensei_lesson_video', $post->ID );

				}

				the_content();

			} else {
				?>

					<p>

						<?php echo wp_kses_post( get_the_excerpt() ); ?>

					</p>

				<?php
			}

			?>

		</section>

		<?php

			/**
			 * Hook inside the single lesson template after the content
			 *
			 * @since 1.9.0
			 *
			 * @param integer $lesson_id
			 *
			 * @hooked Sensei()->frontend->sensei_breadcrumb   - 30
			 */
			do_action( 'sensei_single_lesson_content_inside_after', get_the_ID() );

		?>

	</article><!-- .post -->

	<?php 
	/**
	 * sensei_pagination hook
	 *
	 * @hooked sensei_pagination - 10 (outputs pagination)
	 */
	do_action( 'sensei_pagination' );

	/**
	 * Fires inside the standard loop, after the entry closing markup.
	 *
	 * @since 2.0.0
	 */
	do_action( 'genesis_after_entry_lesson' );

}
add_action( 'genesis_loop', __NAMESPACE__ . '\dwp_sensei_do_single_lesson_loop' );

genesis();