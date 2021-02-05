<?php
/**
 * The Template for displaying all Quiz Questions.
 *
 * This is a genesis compatible version of: sensei-lms\templates\single-quiz.php
 * 
 * Override this template by copying it to yourtheme/sensei/single-quiz.php
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

function dwp_sensei_do_single_quiz_loop() {
	?>
	<article <?php post_class(); ?>>

		<?php

			/**
			 * Hook inside the single quiz post above the content
			 *
			 * @since 1.9.0
			 *
			 * @hooked Sensei_Quiz::the_title               - 20
			 * @hooked Sensei_Quiz::the_user_status_message - 40
			 * @param integer $quiz_id
			 */
			do_action( 'sensei_single_quiz_content_inside_before', get_the_ID() );

		?>

		<?php if ( sensei_can_user_view_lesson() ) : ?>

			<section class="entry quiz-questions">

				<?php if ( sensei_quiz_has_questions() ) : ?>

					<form method="POST" action="<?php echo esc_url_raw( get_permalink() ); ?>" enctype="multipart/form-data">

						<?php

							/**
							 * Action inside before the question content on single-quiz page
							 *
							 * @hooked Sensei_Quiz::the_user_status_message  - 10
							 *
							 * @param string $the_quiz_id
							 */
							do_action( 'sensei_single_quiz_questions_before', get_the_id() );

						?>

						<ol id="sensei-quiz-list">

						<?php
						while ( sensei_quiz_has_questions() ) :
							sensei_setup_the_question();
							?>

							<li class="<?php sensei_the_question_class(); ?>">

								<?php

									/**
									 * Action inside before the question content on single-quiz page
									 *
									 * @hooked Sensei_Question::the_question_title        - 10
									 * @hooked Sensei_Question::the_question_description  - 20
									 * @hooked Sensei_Question::the_question_media        - 30
									 * @hooked Sensei_Question::the_question_hidden_field - 40
									 *
									 * @since 1.9.0
									 * @param string $the_question_id
									 */
									do_action( 'sensei_quiz_question_inside_before', sensei_get_the_question_id() );

								?>

								<?php sensei_the_question_content(); ?>

								<?php

									/**
									 * Action inside before the question content on single-quiz page
									 *
									 * @hooked Sensei_Question::answer_feedback_notes
									 *
									 * @param string $the_question_id
									 */
									do_action( 'sensei_quiz_question_inside_after', sensei_get_the_question_id() );

								?>

							</li>

						<?php endwhile; ?>

						</ol>

						<?php

							/**
							 * Action inside before the question content on single-quiz page
							 *
							 * @param string $the_quiz_id
							 */
							do_action( 'sensei_single_quiz_questions_after', get_the_id() );

						?>

					</form>
				<?php else : ?>

					<div class="sensei-message alert"> <?php esc_html_e( 'There are no questions for this Quiz yet. Check back soon.', 'sensei-lms' ); ?></div>

				<?php endif; // End If have questions ?>


				<?php
					$quiz_lesson = Sensei()->quiz->data->quiz_lesson;
					do_action( 'sensei_quiz_back_link', $quiz_lesson );
				?>

			</section>

		<?php endif; // user can view lesson ?>

		<?php

		/**
		 * Hook inside the single quiz post above the content
		 *
		 * @since 1.9.0
		 *
		 * @param integer $quiz_id
		 */
		do_action( 'sensei_single_quiz_content_inside_after', get_the_ID() );

		?>

	</article><!-- .quiz -->

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
	do_action( 'genesis_after_entry_quiz' );

}
add_action( 'genesis_loop', 'dwp_sensei_do_single_quiz_loop' );

add_action( 'genesis_after_entry', 'dwp_sensei_after_entry_widget_area' );
/**
 * Display after-entry widget area on the genesis_after_entry action hook.
 *
 * @since 2.1.0
 *
 * @return void Return early if not singular, or post type does not support after entry widget area.
 */
function dwp_sensei_after_entry_widget_area() {

	if ( ! is_singular( 'quiz' ) 
	// || ! post_type_supports( get_post_type(), 'genesis-after-entry-widget-area' ) 
	) {
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



genesis();
