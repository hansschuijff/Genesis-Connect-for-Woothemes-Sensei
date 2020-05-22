<?php
/**
 * Show module in quick edit of lessons and courses
 * and adds a sortable module column to the lesson post list in admin
 *
 * @package     DeWittePrins\GenesisConnect\SenseiLMS
 * @since       1.2.3
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
 * Sets the Sensei Module taxonomy to show modules in quick edit
 * This will enable bulk edits
 * 
 * Normally setting show_admin_column to true, 
 * will setup wordpress to show the column automatically in admins post list screen
 * However in case of Sensei LMS the columns in that screen are hardcoded 
 * and overwrite the default behaviour.
 * 
 * @since  1.2.3
 * @param  array  $args
 * @param  string $taxonomy
 * @return array  $args
 */
function show_module_in_quick_edit( $args, $taxonomy ) {

    if ( function_exists( 'Sensei' ) && 'module' === $taxonomy ) {

        $args['show_in_quick_edit'] = true;
        // $args['show_admin_column'] = true;
    }

    return $args;
}
add_filter( 'register_taxonomy_args', __NAMESPACE__ . '\show_module_in_quick_edit', 20, 3 );

/**
 * Add Module column to admins post list screen 
 * 
 * @since  1.2.3
 * @return void
 */
function add_module_column_to_admin_lesson_post_list() {

    /** use prio=20 since sensei-lms generates the colums with prio=10 */
    add_filter( 'manage_edit-lesson_columns', __NAMESPACE__ . '\add_lesson_module_column_heading', 19, 1 );
    add_action( 'manage_posts_custom_column', __NAMESPACE__ . '\add_lesson_module_column_data', 19, 2 );

}
add_action( 'init', __NAMESPACE__ . '\add_module_column_to_admin_lesson_post_list', 11 );

/**
 * Add module column heading to the "lesson" post list screen.
 *
 * @since  1.2.3
 * @param  array $defaults
 * @return array $new_columns
 */ 
function add_lesson_module_column_heading( $columns ) {
    
    $columns['lesson-module'] = esc_html_x( 'Module', 'column name', 'core-functionality-dwp' );

    return $columns;
}

/**
 * Add module column data to the "lesson" post list screen.
 * 
 * Although each lesson should be linked to only one module
 * this dat is build to facilitate more than one, if that is the case
 *
 * @since  1.2.3
 * @param  string $column_name
 * @param  int    $lesson_id
 * @return void
 */
function add_lesson_module_column_data( $column_name, $lesson_id ) {

    // Bail out early if this is not the lesson-module column
    if ( 'lesson-module' !== $column_name ) {
        return;
    }

    $terms = get_the_terms( $lesson_id, 'module' );

    // Bail out if no terms attached
    if ( !$terms ) {
        return;
    }

    // generate module-content for a lesson in this column
    $term_names = '';
    foreach ($terms as $term) {
        
        $term_names .=  '<div class="module-term-name">' . esc_html($term->name). '</div>';
    }

    echo $term_names;
}

/**
 * Makes the lesson-module column sortable in admins post list
 * 
 * This only tells wordpress the column is sortable.
 * By this it doesn't know yet how to sort on that column, 
 * so the query must be programmed too to sort on this taxonomy
 *  
 * @since  1.2.3
 * @param  array $columns
 * @return array $columns
 */
function make_lesson_module_column_sortable( $columns ) {

    $columns['lesson-module'] = 'lesson-module';

    return $columns;
}
add_filter( 'manage_edit-lesson_sortable_columns', __NAMESPACE__ . '\make_lesson_module_column_sortable' );

/**
 * Tells wordpress how to sort lessons by lesson module
 * 
 * Adds an order by clause to the query 
 * whenever the orderby query var is set to "lesson-module"
 * 
 * This teaches wordpress how to sort the admin post list of lessons
 * on lesson-module
 * 
 * @since  1.2.3
 * @param  array  $clauses
 * @return object $wp_query instance of WP_Query
 */
function add_clause_to_order_lessons_by_module( $clauses, $wp_query ) {
    global $wpdb;

    if ( isset( $wp_query->query['orderby'] ) && 'lesson-module' == $wp_query->query['orderby'] ) {
        $clauses['join'] .= 
            " LEFT JOIN (
            SELECT object_id, GROUP_CONCAT(name ORDER BY name ASC) AS module
            FROM $wpdb->term_relationships
            INNER JOIN $wpdb->term_taxonomy USING (term_taxonomy_id)
            INNER JOIN $wpdb->terms USING (term_id)
            WHERE taxonomy = 'module'
            GROUP BY object_id
        ) AS module_terms ON ($wpdb->posts.ID = module_terms.object_id)";
        $clauses['orderby'] = 'module_terms.module ';
        $clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
    }

    return $clauses;
}
add_filter( 'posts_clauses', __NAMESPACE__ . '\add_clause_to_order_lessons_by_module', 10, 2 );
