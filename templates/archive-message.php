<?php
/**
 * The Template for displaying message archives.
 *
 * Override this template by copying it to yourtheme/sensei/archive-message.php
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

function dwp_sensei_do_message_loop() {

	/**
	 * This action before course messages archive loop. This hook fires within the archive-message.php file.
	 * It fires even if the current archive has no no messages.
	 *
	 * @since 1.9.0
	 *
	 * @hooked Sensei_Messages::the_archive_header -20
	 */
	do_action( 'sensei_archive_before_message_loop' ); ?>

	<section id="main-sensei_message" class="sensei_message-container">

		<?php if ( have_posts() ) : ?>

			<?php sensei_load_template( 'loop-message.php' ); ?>

		<?php else : ?>

			<p> <?php esc_html_e( 'You do not have any messages.', 'sensei-lms' ); ?> </p>

		<?php endif; // End If Statement ?>

	</section>

	<?php
	/**
	 * This action before course messages archive loop. This hook fires within the archive-message.php file.
	 * It fires even if the current archive has no no messages.
	 *
	 * @since 1.9.0
	 */
	do_action( 'sensei_archive_after_message_loop' );

	/**
	 * sensei_pagination hook
	 *
	 * @hooked sensei_pagination - 10 (outputs pagination)
	 */
	do_action( 'sensei_pagination' );

}
add_action( 'genesis_loop', 'dwp_sensei_do_message_loop' );

genesis();
