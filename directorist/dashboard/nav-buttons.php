<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-tab__nav__action">
<?php
    $user_id = get_current_user_id();
    //echo("<h2>" . $user_id . "</h2>");
    $args = array(  
        'post_type' => 'at_biz_dir',
        'author__in' => $user_id,
        'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit')
    );
if( has_active_subscription() ){  
    
    $has_sub = "true";
    
} else {
    $has_sub = "false";
    //update_post_meta(get_the_ID(), '_fm_plans', 99999);
}
    
$the_query = new WP_Query( $args ); 
        
if ( $the_query->have_posts() ) {
    
      while($the_query->have_posts()) {
                $the_query->the_post();
          $listing_id = get_the_ID();
          //echo($listing_id);
      }
    $has_listing = "true";
    
} else {
    $has_listing = "false";
}
    //echo("<h2>sub: " . $has_sub . "</h2>");
    //echo("<h2>list: " . $has_listing . "</h2>");

    wp_reset_postdata(); 
    
$users_subscriptions = wcs_get_users_subscriptions($user_id); 
   foreach ($users_subscriptions as $subscription){
       
  if ($subscription->has_status(array('active'))) {
         $p_id = $subscription-> ID;
         $plan_id = get_post_meta( $p_id, '_fm_plans', true );
      //echo($p_id);
      //echo($plan_id);
  }
} 
    ?>
	<?php 
    if ($has_sub == "true" && $has_listing == "false") {
        if ( $dashboard->user_can_submit() ) { 
    if ($plan_id == "14054") {
        $url = "13713";
         if ( !(current_user_can( 'administrator' )) ) {
        $user_id = wp_update_user( array( 'ID' => $user_id, 'role' => 'editor' ) );
    }}
    if ($plan_id == "14055") {
        $url = "13714";
        if ( !(current_user_can( 'administrator' )) ) {
        $user_id = wp_update_user( array( 'ID' => $user_id, 'role' => 'editor' ) );
        
    }}
    if ($plan_id == "14056") {
        $url = "13715"; 
        if ( !(current_user_can( 'administrator' )) ) {
        $user_id = wp_update_user( array( 'ID' => $user_id, 'role' => 'subscriber' ) );
    }}
    if ($plan_id == "14057") {
        $url = "13716"; 
         if ( !(current_user_can( 'administrator' )) ) {
        $user_id = wp_update_user( array( 'ID' => $user_id, 'role' => 'subscriber' ) );
    }}
        ?>
		<a href="/add-listing-form/?directory_type=352&plan=<?php echo $url; ?>" class="directorist-btn directorist-btn-dark directorist-btn--add-listing"><?php esc_html_e( 'Submit Listing', 'directorist' ); ?></a>
	<?php } 
        
    }
        
    if ($has_sub == "false" && $has_listing == "false") {
        
        if ( $dashboard->user_can_submit() ) { ?>
		<a href="<?php echo esc_url(ATBDP_Permalink::get_add_listing_page_link()); ?>" class="directorist-btn directorist-btn-dark directorist-btn--add-listing"><?php esc_html_e( 'Submit Listing', 'directorist' ); ?></a>
	<?php } 
    
        }else {
            //echo("already has listing");
        } ?>
   
    

	<?php if ( $dashboard->user_type == 'general' && ! empty( $dashboard->become_author_button)): ?>
		<a href="#" class="directorist-btn directorist-btn-primary directorist-become-author"><?php echo esc_html( $dashboard->become_author_button_text ); ?></a>
		<p id="directorist-become-author-success"></p>

		<div class="directorist-become-author-modal">
            <div class="directorist-become-author-modal__content">
                <!-- <a href="" class="directorist-become-author-modal__close">x</a> -->
                <h3><?php esc_html_e( 'Are you sure you want to become an author?', 'directorist' ); ?> <br><?php esc_html_e( '(It is subject to approval by the admin)', 'directorist' ); ?> <span class="directorist-become-author__loader"></span></h3>
                <p>
                    <a href="#" class="directorist-become-author-modal__cancel">Cancel</a>
                    <a href="#" class="directorist-become-author-modal__approve" data-nonce="<?php echo esc_attr( wp_create_nonce('atbdp_become_author' ) ); ?>" data-userId='<?php echo esc_attr( get_current_user_id() ); ?>'>Yes</a>
                </p>
            </div>
        </div>
	<?php endif; ?>

	<a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="directorist-btn directorist-btn-secondary directorist-btn--logout"><?php esc_html_e( 'Log Out', 'directorist' ); ?></a>

</div>
<?php //echo "<pre>" . print_r($active_orders[0]) . "</pre>"; ?>
<?php //echo "<pre>" . print_r($users_subscriptions,1) . "</pre>"; ?>