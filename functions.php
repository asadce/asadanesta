<?php
/**
 * Child-Theme functions and definitions
 */

// Enqueue child theme style
function anesta_child_scripts() {
    wp_enqueue_style('anesta-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'anesta_child_scripts');

// WooCommerce: Skip cart, go directly to checkout
add_filter('woocommerce_add_to_cart_redirect', 'lw_add_to_cart_redirect');
function lw_add_to_cart_redirect() {
    return wc_get_checkout_url();
}

// Remove "added to cart" message
add_filter('wc_add_to_cart_message_html', '__return_false');

// WooCommerce: Has active subscription
function has_active_subscription($user_id = '') {
    if ('' === $user_id && is_user_logged_in()) {
        $user_id = get_current_user_id();
    }
    if ($user_id == 0) {
        return false;
    }
    return wcs_user_has_subscription($user_id, '', 'active');
}

// WooCommerce: Redirect after checkout based on product ID
add_action('woocommerce_thankyou', 'redirect_product_based', 1);
function redirect_product_based($order_id) {
    $order = wc_get_order($order_id);

    foreach ($order->get_items() as $item) {
        $product_id = $item['product_id'];
        switch ($product_id) {
            case 1457:
                wp_redirect("/directory-dash/?pp=13716");
                exit;
            case 14056:
                wp_redirect("/directory-dash/?pp=13715");
                exit;
            case 14055:
                wp_redirect("/directory-dash/?pp=13714");
                exit;
            case 14054:
                wp_redirect("/directory-dash/?pp=13713");
                exit;
            case 13743:
                wp_redirect("/membership-account/");
                exit;
            default:
                wp_redirect("/?test=3");
                exit;
        }
    }
}

// Update listings without valid _fm_plans meta with default value
function update_empty_fm_plans_meta($paged = 1) {
    $args = array(
        'post_type'      => 'at_biz_dir',
        'meta_query'     => array(
            array(
                'key'     => '_fm_plans',
                'value'   => array(13000, 14000),
                'type'    => 'NUMERIC',
                'compare' => 'NOT BETWEEN',
            ),
        ),
        'posts_per_page' => 100,
        'paged'          => $paged,
        'fields'         => 'ids',
    );

    $query = new WP_Query($args);

    foreach ($query->posts as $post_id) {
        $fm_plans_value = get_post_meta($post_id, '_fm_plans', true);
        if (empty($fm_plans_value) || !is_numeric($fm_plans_value)) {
            update_post_meta($post_id, '_fm_plans', 99999);
        }
    }

    if ($paged < $query->max_num_pages) {
        update_empty_fm_plans_meta($paged + 1);
    }
}

// Trigger FM plans update via query parameter (admin only)
add_action('init', function () {
    if (current_user_can('manage_options') && isset($_GET['run_fm_update'])) {
        update_empty_fm_plans_meta();
        echo "Update complete.";
        exit;
    }
});


add_filter('wp_insert_post_data', function ($data, $postarr) {
    if ($data['post_type'] === 'at_biz_dir') {
        // Force it to stay published
        $data['post_status'] = 'publish';
    }
    return $data;
}, 10, 2);
