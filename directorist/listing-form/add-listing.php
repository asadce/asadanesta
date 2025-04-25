<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.3.1
 */

use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;




 //*PA redirect if already has sub and lsiting
//$user_id = get_current_user_id();
//$args = array(  
//        'post_type' => 'at_biz_dir',
//        'author__in' => $user_id,
//        'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit')
//    );
//if( has_active_subscription() ){  
//    $plan_id = get_post_meta( get_the_ID(), '_fm_plans', true );
//    echo("<h2>PLAN ID: " . $plan_id . "</h2>");
//    
//} else {
//    $has_sub = "false";
//}
//    
//$the_query = new WP_Query( $args ); 
//        
//if ( $the_query->have_posts() ) {
//    $has_listing = "true";
//    
//} else {
//    $has_listing = "false";
//}
//    wp_reset_postdata(); 
//    
//	
//    if ($has_sub == "true" && $has_listing == "true") {

//header("Location: /directory-dash/");
//die();
//}

// END PA

$action_url = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ): '';
?>

<div class="directorist-add-listing-wrapper directorist-w-100">
	<div class="<?php Helper::directorist_container_fluid(); ?>">

		<form action="<?php echo esc_url( $action_url ); ?>" method="post" id="directorist-add-listing-form">

        <?php do_action('directorist_before_add_listing_from_frontend');?>

            <div class="directorist-add-listing-form">

                <input type="hidden" name="add_listing_form" value="1">
                <input type="hidden" name="listing_id" value="<?php echo !empty($p_id) ? esc_attr($p_id) : ''; ?>">

                <?php
                ATBDP()->listing->add_listing->show_nonce_field();
                if ( !empty( $is_edit_mode ) || !empty( $single_directory )) {
                    $listing_form->type_hidden_field();
                }

                foreach ( $form_data as $section ) {
                    $listing_form->section_template( $section );
                }

              //  $listing_form->submit_template();
$listing_form->submit_template(); 

?>
<!--button type="submit">Force Submit</button-->

<!-- *********** Some code added to directorist main plugin directory. Because the Submit button was missing from /directorist/templates/listing-form/submit.php
Added this: 
	<div class="directorist-form-submit">
		<button type="submit" class="directorist-btn directorist-btn-primary directorist-btn-lg directorist-form-submit__btn"><?php // echo esc_html( $listing_form->submit_label() ); ?></button>
	</div>

	<?php /* do_action( 'directorist_after_submit_listing_frontend' ); */ ?>

This button information got from previous directorist plugin -->


            </div>
        </form>

    </div>
</div>
<? //*PA GET VARS ?>
<?
if ( empty( $is_edit_mode )) {
    if (isset($_GET['plan'])) {
        $plan_id = $_GET['plan'];
}
    
    if (isset($_GET['directory_type'])) {
        $directory_id = $_GET['directory_type'];
}
      
    if (isset($_GET['order'])) {
        $order_id = $_GET['order'];
}
}  elseif ( !empty( $is_edit_mode )) { 
    $plan_id = get_post_meta( $p_id, '_fm_plans', true );
    $post_tags = get_the_tags( $p_id );
    $listing_id = get_the_ID();
    $order_id = basename(parse_url($action_url, PHP_URL_PATH));
} 
    

if ( !empty($plan_id)) {
        if ($plan_id == "13713") { $tag = "GOLD LEVEL";} 
        if ($plan_id == "13714") { $tag = "SILVER LEVEL";} 
        if ($plan_id == "13715") { $tag = "BRONZE LEVEL";} 
        if ($plan_id == "13716") { $tag = "BUSINESS LEVEL";}
        } else {
            $plan_id = "";
            $tag = "";
        }
if ( empty($post_tags)) {
    $post_tags = "";
}
if ( empty($is_edit_mode)) {
    $is_edit_mode = "";
}

?>

<?php /*?><? echo("<h2 class='zzz'>P ID: " . $p_id . "</h2>"); ?>
<? echo("<h2 class='zzz'>Action URL Post: " . $action_url . "</h2>"); ?>
<? echo("<h2 class='zzz'>Plan ID: " . $plan_id . "</h2>"); ?>
<? echo("<h2 class='zzz'>Editing Mode: " . $is_edit_mode . "</h2>"); ?>
<? echo("<h2 class='zzz'>Existing Tag: " . $post_tags . "</h2>"); ?>
<? echo("<h2 class='zzz'>New Tag: " . $tag . "</h2>"); ?>
<? echo("<h2 class='zzz'>User ID: " . $user_id . "</h2>"); ?>
<? echo("<h2 class='zzz'>ID from URL: " . $order_id . "</h2>"); ?>
<? echo("<h2 class='zzz'>Listing ID: " . $listing_id . "</h2>"); ?><?php */?>


<script>
var $ = jQuery;
$(function() {
    $("#at_biz_dir-tags").val('<? echo($tag); ?>');
});
</script>

<?php Helper::get_template( 'listing-form/quick-login' ); ?>