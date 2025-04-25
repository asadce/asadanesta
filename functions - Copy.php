<?php
/**
 * Child-Theme functions and definitions
 */

function anesta_child_scripts() {
    wp_enqueue_style( 'anesta-style', get_template_directory_uri(). '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'anesta_child_scripts' );


/**
 * Auto Complete all WooCommerce orders.
 */
add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) { 
    if ( ! $order_id ) {
        return;
    }

    $order = wc_get_order( $order_id );
    $order->update_status( 'completed' );
}

add_action( 'woocommerce_thankyou', 'redirect_product_based', 1 ); 
function redirect_product_based ( $order_id ){
            $order = wc_get_order( $order_id );
        
            foreach( $order->get_items() as $item ) {
              
                if ( $item['product_id'] == 13716 ) {
                    // URL 
                     wp_redirect( 'https://j0p.4c6.myftpupload.com/directory-dash/' );
            }  if ( $item['product_id'] == 13715 ) {
                    // The other URL
                    wp_redirect( '/add-listing-form/?directory_type=352&plan=13715' );
                }
                if ( $item['product_id'] == 13714 ) {
                    // The other URL
                    wp_redirect( '/add-listing-form/?directory_type=352&plan=13714' );
                }
                if ( $item['product_id'] == 13713 ) {
                    // The other URL
                    wp_redirect( '/add-listing-form/?directory_type=352&plan=13713' );
                if ( $item['product_id'] == 13743 ) {
                    // The other URL
                    wp_redirect( '/membership-account/' );
                }
                } else {
                    wp_redirect( '/' );
                }
            }
}


function add_listing_enqueue() {
  if ( is_page( 'add-listing' ) ) {
    wp_enqueue_script( 'add-listing-js', get_stylesheet_directory_uri() . ( '/assets/custom-add-listing.js' ), array( 'jquery' ), null, true );
  } 
}
add_action( 'wp_enqueue_scripts', 'add_listing_enqueue' );

function dash_enqueue() {
  if ( is_page( 'directory-dash' ) ) {
    wp_enqueue_script( 'dir-dash-js', get_stylesheet_directory_uri() . ( '/assets/custom-dash.js' ), array( 'jquery' ), null, true );
  } 
}
add_action( 'wp_enqueue_scripts', 'dash_enqueue' );

//user already exists fix
add_filter( 'woocommerce_checkout_posted_data', 'filter_woocommerce_checkout_posted_data', 10, 1);
function filter_woocommerce_checkout_posted_data( $data) {
// Exit function if user is logged in to let checkout process as normal
if ( is_user_logged_in()) {
return $data;
}

/* IF USER EMAIL ALREADY EXISTS */
if ( !is_user_logged_in() && is_checkout()) {
// Make sure not logged in and are on checkout page.
$user = get_user_by('email', $data['billing_email']);if ( !empty($user->ID) ) {
wp_set_current_user($user->ID);
$data['createaccount'] = 0; // Unset flag to create a new user.
}
else {
$data['createaccount'] = 1; // Set the flag to create a new user.
}
}
return $data;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'skip_cart_redirect_checkout' );
 


// SKIP CART
function skip_cart_redirect_checkout( $url ) {
    return wc_get_checkout_url();
}
add_filter( 'wc_add_to_cart_message', '__return_false' );



// Woo Subscription Test
function has_active_subscription( $user_id='' ) {
    // When a $user_id is not specified, get the current user Id
    if( '' == $user_id && is_user_logged_in() ) 
        $user_id = get_current_user_id();
    // User not logged in we return false
    if( $user_id == 0 ) 
        return false;

    return wcs_user_has_subscription( $user_id, '', 'active' );
}

// Redirect After Checkout
/*add_action( 'woocommerce_thankyou', 'woo_redirectcustom');
function woo_redirectcustom( $order_id ){
    $order = wc_get_order( $order_id );
    $url = 'https://j0p.4c6.myftpupload.com/add-listing/';
    if ( ! $order->has_status( 'failed' ) ) {
        wp_safe_redirect( $url );
        exit;
    }
}*/


// catches query and Orders listings by plan ID
function custom_at_biz_dir_query( $query ) {
    // Check if the query is for the custom post type at_biz_dir
    if(! is_admin() ) {
    if ( isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] == 'at_biz_dir' ) {
        // Order the posts by the ID of the _fm_plans meta_value
        $query->set( 'meta_key', '_fm_plans' );
        $query->set( 'orderby', 'meta_value_num' );
        $query->set( 'meta_query', array(
            array(
                'key' => '_fm_plans',
                'compare' => 'EXISTS',
                'type' => 'NUMERIC',
            ),
            array(
                'key' => '_fm_plans',
                'compare' => '!=',
                'value' => '',
                'type' => 'NUMERIC',
            ),
        ) );
        $query->set( 'order', 'ASC' );
    }
}
}
add_action( 'pre_get_posts', 'custom_at_biz_dir_query' );

// SET TAGS


?>