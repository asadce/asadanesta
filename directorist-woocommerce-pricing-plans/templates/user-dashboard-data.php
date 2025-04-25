<?php
$user_id = get_current_user_id();
if (!class_exists('WooCommerce')) return false;
$filters = array(
    'post_type' => 'shop_order',
    'post_status' => 'any',
    'numberposts' => -1,
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => '_customer_user',
            'value' => $user_id,
            'compare' => '='
        ),
        array(
            'key' => '_fm_plan_ordered',
            'compare' => 'EXISTS'
        )
    ),
);


$loop = new WP_Query($filters);
$plan_type = array();
$subscribed_package_ids = array();
$order_data = array();
while ($loop->have_posts()) {
    $loop->the_post();
    $all_order_ids[] = $loop->post->ID;
    $order = new WC_Order($loop->post->ID);
    foreach ($order->get_items() as $key => $lineItem) {

        $order_data[] = $lineItem->get_data();
        $subscribed_package_id = $lineItem->get_data()['product_id'];
        $plan_type[] = get_post_meta($subscribed_package_id, 'plan_type', true);
        array_push($subscribed_package_ids, $subscribed_package_id);
        }
}
wp_reset_postdata();
?>

<div <?php echo apply_filters('atbdp_dashboard_package_content_div_attributes', 'class="atbd_tab_inner" id="manage_fees"'); ?>>
    <?php
    /**
     * @since 1.2.3
     */
    do_action('atbdp_before_package_table'); ?>

    <div class="atbd_manage_fees_wrapper">
        <?php
        if (!empty($subscribed_package_ids)) { ?>
            <table class="table table-bordered atbd_single_saved_item table-responsive-sm">

                <thead>
                <tr>
                    <th><?php _e('Package Name', 'directorist-woocommerce-pricing-plans') ?></th>
                    <th><?php _e('Amount', 'directorist-woocommerce-pricing-plans') ?></th>
                    <th><?php _e('Remaining listings', 'directorist-woocommerce-pricing-plans') ?></th>
                    <th><?php _e('Order Date', 'directorist-woocommerce-pricing-plans') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $all_order_ids = array();
                $order_data = array();
                while ($loop->have_posts()) {
                $loop->the_post();
                $all_order_ids[] = $loop->post->ID;
                $order = new WC_Order($loop->post->ID);
                foreach ($order->get_items() as $key => $lineItem) {
                    $order_data[] = $order->get_items();
                    $subscribed_package_id = $lineItem->get_data()['product_id'];

                    $plan_type = get_post_meta($subscribed_package_id, 'plan_type', true);
                    if ($plan_type === 'package') {
                        //$subscribed_date = $subscribed_plan_info[0]->post_date;
                        //$order_id = $subscribed_plan_info[0]->ID;
                        $gateway = $order->get_payment_method_title();
                        $order_id = $order->get_id();
                        $subscribed_package_dates = $order->get_date_completed();
                        $plan_meta = get_post_meta($subscribed_package_id);
                        $package_length = get_post_meta($subscribed_package_id, 'fm_length', true);
                        $is_never_expaired = get_post_meta($subscribed_package_id, 'fm_length_unl', true);
                        $fm_tag_limit = get_post_meta($subscribed_package_id, 'fm_tag_limit', true);
                        $fm_tag_limit_unl = get_post_meta($subscribed_package_id, 'fm_tag_limit_unl', true);
                        $package_length = $package_length ? $package_length : '1';
                        $plan_name = get_the_title($subscribed_package_id);
                        $plan_metas = get_post_meta($subscribed_package_id);
                        $num_regular_unl = esc_attr($plan_metas['num_regular_unl'][0]);
                        $num_featured_unl = esc_attr($plan_metas['num_featured_unl'][0]);
                        //calculate regular listing number
                        $user_featured_listing = listings_data_with_plan($user_id, '1', $subscribed_package_id, $order_id);
                        $user_regular_listing = listings_data_with_plan($user_id, '0', $subscribed_package_id, $order_id);
                        $num_regular = get_post_meta($subscribed_package_id, 'num_regular', true);
                        $num_featured = get_post_meta($subscribed_package_id, 'num_featured', true);
                        $listing_id = get_post_meta($order_id, '_listing_id', true);
                        $featured = get_post_meta($listing_id, '_featured', true);
                        $total_regular_listing = $num_regular - ('0' === $featured ? $user_regular_listing + 1 : $user_regular_listing);
                        $total_featured_listing = $num_featured - ('1' === $featured ? $user_featured_listing + 1 : $user_featured_listing);
                        $total_regular_listing = max($total_regular_listing, 0);
                        $total_featured_listing = max($total_featured_listing, 0);



                        //lets check how many listing already submitted by this user

                        // Current time
                        $start_date = !empty($subscribed_package_dates) ? $subscribed_package_dates : '';
                        // Calculate new date
                        $date = new DateTime($start_date);
                        $date->add(new DateInterval("P{$package_length}D")); // set the interval in days
                        $expired_date = $date->format('Y-m-d H:i:s');
                        $current_d = current_time('mysql');
                        $remaining_days = ($expired_date > $current_d) ? (floor(strtotime($expired_date) / (60 * 60 * 24)) - floor(strtotime($current_d) / (60 * 60 * 24))) : 0; //calculate the number of days remaining in a plan


                        printf(' <tr>
                                            <td class="package_name">
                                               <p>%s</p>
                                            </td>
                                            <td class="package_amount">
                                               <p>%s</p>
                                            </td>
                                            <td class="package_remaining">
                                               <p>%s</p>
                                               <p>%s</p>

                                            </td>
                                            <td class="package_start">
                                               <p>%s</p>
                                            </td>
                                        </tr>',
                            //td 1
                            $plan_name,
                            //td 2
                            get_woocommerce_currency_symbol() . $lineItem->get_data()["total"],
                            //td 3
                            !empty($num_regular_unl)?__('Unlimited Regular listing ', 'directorist-woocommerce-pricing-plans'):__('Regular listing ', 'directorist-woocommerce-pricing-plans') . esc_attr($total_regular_listing),
                            !empty($num_featured_unl)?__('Unlimited Featured listing ', 'directorist-woocommerce-pricing-plans'):__('Featured listing ', 'directorist-woocommerce-pricing-plans') . esc_attr($total_featured_listing),
                            //td 4
                            $start_date ? date('Y-m-d', strtotime($start_date)) : __('----', 'directorist-woocommerce-pricing-plans'),

                        );
                    }
                }//end foreach
                }//end while
                wp_reset_postdata();
                ?>
                </tbody>
            </table>
            <?php
        } else {
            $text = '<p class="no_package_found">' . __("No package found!", 'directorist-woocommerce-pricing-plans') . '</p>';
            echo apply_filters('atbdp_no_package_found_text', $text);
        } ?>
    </div>

    <?php
    /**
     * @since 1.3.3
     */
    do_action('atbdp_after_package_table'); ?>
</div>


<div <?php echo apply_filters('atbdp_dashboard_orderHistory_content_div_attributes', 'class="atbd_tab_inner" id="manage_invoices"'); ?>>
    <?php
    /**
     * @since 1.3.3
     */
    do_action('atbdp_before_order_table'); ?>

    <div class="atbd_manage_fees_wrapper">
        <?php
        if (!empty($all_order_ids)) { ?>

            <table class="table table-bordered atbd_single_saved_item table-responsive-sm">
                <thead>
                <tr>
                    <th><?php _e('Order Number', 'directorist-woocommerce-pricing-plans') ?></th>
                    <th><?php _e('Amount', 'directorist-woocommerce-pricing-plans') ?></th>
                    <th><?php _e('Order Date', 'directorist-woocommerce-pricing-plans') ?></th>
                    <th><?php _e('Plan Name', 'directorist-woocommerce-pricing-plans') ?></th>
                    <th><?php _e('Payment Receipt', 'directorist-woocommerce-pricing-plans') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
            while ($loop->have_posts()) {
            $loop->the_post();
            $all_order_ids[] = $loop->post->ID;
            $order = new WC_Order($loop->post->ID);
            foreach ($order->get_items() as $key => $lineItem) {
                $subscribed_package_id = $lineItem->get_data()['product_id'];
                $subscribed_date = $order->get_date_completed();
                $plan_name = $lineItem->get_name();
                // Current time
                $start_date = !empty($subscribed_date) ? $subscribed_date : '';

                printf(' <tr>
                                            <td class="order_no">
                                               <p>%s</p>
                                            </td>
                                            <td class="package_amount">
                                               <p>%s</p>
                                            </td>

                                            <td class="date">
                                               <p>%s</p>
                                            </td>

                                            <td class="name">
                                               <p>%s</p>
                                            </td>

                                            <td class="action">
                                               <p>%s</p>
                                            </td>
                                        </tr>',
                    //td 1
                    '#' . $order->get_order_number(),
                    //td 2
                    get_woocommerce_currency_symbol() . $order->get_total(),
                    //td 3
                    $start_date ? date('Y-m-d', strtotime($start_date)) : __('----', 'directorist-woocommerce-pricing-plans'),
                    //td 4
                    $plan_name,
                    //td 5
                    '<a class="btn btn-block" href=' . $order->get_view_order_url() . '>' . __('View', 'directorist-woocommerce-pricing-plans') . '</a>'

                );
            }
            }
            wp_reset_postdata();
            ?>
                </tbody>
            </table>

            <?php
        } else {
            $text = '<p class="no_order_found">' . __("No order found!", 'directorist-woocommerce-pricing-plans') . '</p>';
            echo apply_filters('atbdp_no_order_found_text', $text);
        } ?>
    </div>

    <?php
    /**
     * @since 1.3.3
     */
    do_action('atbdp_after_order_table'); ?>
</div>