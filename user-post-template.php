<?php /* Template Name: User Post Template */ ?>

<?php

/**

 * The template to display directory

 *

 * @package ANESTA

 * @since ANESTA 1.0

 */

get_header();



while ( have_posts() ) {

	the_post();



	get_template_part( apply_filters( 'anesta_filter_get_template_part', 'templates/content', 'page' ), 'page' );



	// If comments are open or we have at least one comment, load up the comment template.

	if ( ! is_front_page() && ( comments_open() || get_comments_number() ) ) {

		comments_template();

	}

    

    

// *PA REDIRECT

if (current_user_can( 'administrator' ))   {

    //echo("IS ADMIN");

        if (function_exists('user_submitted_posts')) user_submitted_posts();

    

} 

    

    

$user_id = get_current_user_id();


    
    

if ( is_user_logged_in() ) {
    $user_id = get_current_user_id();
    
    // Check if the user is an admin
    if ( current_user_can( 'administrator' ) ) {
        if ( function_exists( 'user_submitted_posts' ) ) {
            user_submitted_posts();
        }
    } else {
        $user_subscriptions = wcs_get_users_subscriptions( $user_id );
        $has_required_subscription = false;

        foreach ( $user_subscriptions as $subscription ) {
            // Check for either of the two subscription IDs
            if ( ($subscription->has_product( 14054 ) || $subscription->has_product( 14055 )) && $subscription->has_status( 'active' ) ) {
                $has_required_subscription = true;
                break;
            }
        }

        if ( $has_required_subscription ) {
            if ( function_exists( 'user_submitted_posts' ) ) {
                user_submitted_posts();
            }
        } else {
            // Redirect if the user does not have the required subscription
            wp_redirect( "/cant-post-need-plan/" );
            exit; // Always call exit after wp_redirect
        }
    }
} else {
    // Redirect if the user is not logged in
    wp_redirect( "/cant-post-need-plan/" );
    exit;
} 
    
    
    
    
    
    
    
    

//$sub_id = wcs_get_users_subscriptions($user_id);

//if( has_active_subscription()){ // Current user has an active subscription 
//
//    $users_subscriptions = wcs_get_users_subscriptions($user_id);
//
//    foreach ($users_subscriptions as $subscription){
//
//if ($subscription->has_status(array('active'))) {
//
//
//
//echo $subscription->get_id(); 
//
//
//
//$subscription_id = $subscription->get_id();
//
//$meta_value = get_post_meta( $subscription_id, '_linked_pricing_plan', true );
//
//    
//echo $meta_value;
//
//if ($meta_value == "13713" || $meta_value == "13714") {
//
//        echo("Gold or Silver Found");
//
//        if (function_exists('user_submitted_posts')) user_submitted_posts();
//
//        
//
//    } else {
//
//echo("Subscription, but not G or S");
//
////wp_redirect("/cant-post/");
//
//
//
//    }
//
//
//
//  }
//
//}    

    



//} elseif (!(current_user_can( 'administrator' ))) {

//echo("NADA");

//wp_redirect("/cant-post/");



//}

// END PA

} ?>



<? get_footer(); ?>