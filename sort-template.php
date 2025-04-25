<?php /* Template Name: C Sort Template */ ?>
<?php
/**
 * The template to display directory
 *
 * @package ANESTA
 * @since ANESTA 1.0
 */

//function custom_at_biz_dir_query( $query ) {
//    // Check if the query is for the custom post type at_biz_dir
//    if ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'at_biz_dir' ) {
//        // Order the posts by the presence of the _fm_plans meta_value
//        $query->set( 'meta_key', '_fm_plans' );
//        $query->set( 'orderby', 'meta_value_num meta_value' );
//        $query->set( 'meta_query', array(
//            'relation' => 'OR',
//            array(
//                'key' => '_fm_plans',
//                'compare' => 'EXISTS',
//                'type' => 'NUMERIC',
//            ),
//            array(
//                'key' => '_fm_plans',
//                'compare' => 'NOT EXISTS',
//            ),
//        ) );
//        $query->set( 'order', 'ASC' );
//
//    }
//}
//
//add_action( 'pre_get_posts', 'custom_at_biz_dir_query' );





get_header();


//*PA Probably needs to go elsewhere

//update_empty_fm_plans_meta();
//

while ( have_posts() ) {
	the_post();

	get_template_part( apply_filters( 'anesta_filter_get_template_part', 'templates/content', 'page' ), 'page' );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( ! is_front_page() && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}
}

get_footer();
