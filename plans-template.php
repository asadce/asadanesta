<?php /* Template Name: Plans Template */ ?>
<?php
/**
 * The template to display directory
 *
 * @package ANESTA
 * @since ANESTA 1.0
 */
get_header();
// *PA REDIRECT
if( has_active_subscription() ){ // Current user has an active subscription 
wp_redirect("/already-have-plan/");
die();
//echo("Has Plan");
}
// END PA
while ( have_posts() ) {
	the_post();

	get_template_part( apply_filters( 'anesta_filter_get_template_part', 'templates/content', 'page' ), 'page' );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( ! is_front_page() && ( comments_open() || get_comments_number() ) ) {
		comments_template();
	}
} ?>

<? get_footer(); ?>