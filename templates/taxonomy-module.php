<?php
/**
 * The template for displaying a module.
 *
 * Override this template by copying it to your_theme/sensei/taxonomy-module.php.
 *
 * @author    Automattic
 * @package   Sensei
 * @category  Templates
 * @version   1.9.20
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

remove_action( 'genesis_loop', 'genesis_do_loop' );

function dwp_sensei_do_taxonomy_module_loop() {

	/**
	 * Fires before rendering any markup on the module page.
	 *
	 * @since 1.9.20
	 */
	do_action( 'sensei_taxonomy_module_content_before' );
	
	if ( have_posts() ) : ?>
		<section class="module-container" >
			<?php
				/**
				 * Fires before rendering the module content.
				 *
				 * @since 1.9.20
				 */
				do_action( 'sensei_taxonomy_module_content_inside_before' );

				/**
				 * Fires after rendering the module content.
				 *
				 * @since 1.9.20
				 */
				do_action( 'sensei_taxonomy_module_content_inside_after' );
			?>
		</section>
	<?php 

	endif; 

	/**
	 * Fires after rendering all markup on the module page.
	 *
	 * @since 1.9.20
	 */
	do_action( 'sensei_taxonomy_module_content_after' );

	/**
	 * sensei_pagination hook
	 *
	 * @hooked sensei_pagination - 10 (outputs pagination)
	 */
	do_action( 'sensei_pagination' );

}
add_action( 'genesis_loop', 'dwp_sensei_do_taxonomy_module_loop' );

genesis();