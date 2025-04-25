<?php
!empty($args['fields_info']) ? extract($args['fields_info']) : array(); // extract fields
/**
 * Display the WooCommerce custom fields.
 */
/*echo '<pre>';
var_dump($args['fields_info']);
echo '</pre>';*/
//var_dump($plan_metas['_dwpp_plan_type'][0])

do_action('atbdp_field_before_plan_type_select', $args);
?>

<div class="options_group listing show_if_listing_pricing_plans" id="dwpp_woo_metaboxes">
    <?php

    $booking_url      = '<a style="text-decoration: underline" href="https://directorist.com/product/directorist-booking/" target="_blank">Booking (Reservation & Appointment)</a>';
	$booking_required = ! class_exists( 'BD_Booking' ) ? '(It requires ' . $booking_url . ' extension)' : '';

	$chat_url      = '<a style="text-decoration: underline" href="https://directorist.com/product/directorist-live-chat/" target="_blank">Live Chat</a>';
	$chat_required = ! class_exists( 'Directorist_Live_Chat' ) ? '(It requires ' . $chat_url . ' extension)' : '';

	$m_sold_url      = '<a style="text-decoration: underline" href="https://directorist.com/product/directorist-mark-as-sold/" target="_blank">Mark as Sold</a>';
	$m_sold_required = ! class_exists( 'Directorist_Mark_as_Sold' ) ? '(It requires ' . $m_sold_url . ' extension)' : '';
    $claim_url = '<a style="text-decoration: underline" href="https://directorist.com/product/directorist-booking/" target="_blank">Claim Listing</a>';
    $claim_required = ! class_exists( 'DCL_Base' ) ? '(It requires '.$claim_url.' extension)' : '';


    if( !empty( $directory_types ) && directorist_multi_directory() ) { ?>
        <div class="directorist-select-type-wrap directorist-text-center">
            <h4 class="directorist-select-type-title"><?php _e( 'Select Directory Type', 'directorist-woocommerce-pricing-plans' ); ?></h4>
            <fieldset class="form-field _dwpp_plan_type_field ">
            <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
            <ul class="directorist-selection-box-wrap">
            <?php
                foreach( $directory_types as $term ) {
                ?>
                <li>
                    <a class="directorist-radio directorist-radio-theme-admin directorist-radio-circle <?php echo ( $term->slug == $value ) ? 'active' : '' ; ?>">
                        <input type="radio" <?php echo checked( $term->term_id , $value ); ?> name="assign_to_directory" id="<?php echo esc_attr( $term->slug ); ?>" value="<?php echo esc_attr( $term->term_id ); ?>">
                        <label class="directorist-radio__label" for="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_attr( $term->name ); ?></label>
                        <span class="directorist-active-line"></span>
                    </a>
                </li>
            <?php }?>
            </ul>
            </fieldset>

            <div id="directorist-type-preloader" style="display: none;">
            <div></div><div></div><div></div><div></div>
            </div>
        </div>
    <?php } ?>


<table class="directorist-input-box directorist-atbdp-input widefat" id="directorist-field-details">
<tbody>
<h4 class="directorist-wc-pricing-plan-title"><?php _e( 'Basic Configuration', 'directorist-woocommerce-pricing-plans' ); ?></h4>

<?php if( class_exists( 'WC_Subscriptions' ) ) { ?>

<tr class="directorist-field-instructions directorist-auto-subscription">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Enable Subscription', 'directorist-woocommerce-pricing-plans'); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="hide_subscription" type="checkbox" value="1"
                                        name="hide_subscription" <?php echo (!empty($post_meta['_hide_subscription'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option"
                    for="hide_subscription"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
        </div>
    </td>
    <td>
        <label class="directorist-switch-Yn directorist-mb-20">
            <input type="checkbox" <?php echo !empty( $post_meta['_enable_subscription'][0] ) ? 'checked' : ''; ?> name="enable_subscription" value="yes">
            <span class="directorist-switch-yes">Yes</span>
            <span class="directorist-switch-no">No</span>
        </label>

    </td>
</tr>

<tr class="directorist-field-instructions directorist-link-subscription">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Link a Subscription Product', 'directorist-woocommerce-pricing-plans'); ?></label>
    </td>
    <td>
        <div class="">
            <div class="">
                <ul class="directorist-radio-list">
                    <?php
                    if( ! empty( $subscription_products ) ) {
                        $linked = ! empty( $post_meta['_linked_subscription'] ) ? $post_meta['_linked_subscription'][0] : '';
                        foreach ($subscription_products as $product) {
                            $checked = $linked == $product ? 'checked' : '';
                            $used    = get_post_meta( $product, '_linked_pricing_plan', true );
                            ?>
                            <li>
                                <div class="directorist-radio directorist-radio-theme-admin directorist-radio-circle<?php echo $used ? ' directorist_sub_in_use': ''; ?>" >
                                    <input name="linked_subscription" id="<?php echo esc_attr( $product ); ?>" type="radio" value="<?php echo esc_attr( $product ); ?>" <?php echo esc_attr( $checked ); ?>>
                                    <label for="<?php echo esc_attr( $product ); ?>" class="directorist-radio__label"><?php echo esc_html( get_the_title( $product ) ); ?></label>
                                </div>
                            </li>
                            <?php
                        }
                    }else{?>
                        <p><?php _e('No Subscription Product found!', 'directorist-woocommerce-pricing-plans'); ?></p>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>

    </td>
</tr>

<?php }
// End subscription related fields
?>


<tr class="directorist-field-instructions directorist-listing-duration">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Listing Duration', 'directorist-woocommerce-pricing-plans'); ?></label>
    </td>
    <td>
        <div class="directorist-renew-check-wrap directorist-handle-input directorist-visible">
            <div class="directorist-renew-check-content">

                <div class="directorist-recurring-time-period-from">
                    <div class="directorist-form-group directorist-renew-time">
                        <input type="number" name="fm_length" id="recurring_period"
                        value="<?php echo !empty($post_meta['fm_length']) ? (int)$post_meta['fm_length'][0] : 30; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="directorist-input-control directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-15">
            <input id="fm_length_unl" type="checkbox" value="1" name="fm_length_unl" <?php echo (!empty($post_meta['fm_length_unl'][0])) ? 'checked' : ''; ?>>
            <label class="directorist-checkbox__label" class="fm_unlimited" for="fm_length_unl"><?php _e('Never expire', 'directorist-woocommerce-pricing-plans'); ?></label>
        </div>
    </td>
</tr>

<tr class="directorist-field-type">
    <td class="directorist-label">
        <label class="directorist-input-box__title widefat"><?php _e('Select Plan Type', 'directorist-woocommerce-pricing-plans'); ?></label>
    </td>
    <td class="directorist-field-lable">
        <?php $selected_plan_type = isset($post_meta['plan_type']) ? esc_attr($post_meta['plan_type'][0]) : ''; ?>
        <ul class="directorist-radio-list">
            <li>
                <!-- <a href="" class="atpp_cptm-modal-toggle atbdp-directory-delete-link-action" data-target="atpp_seelct-plan-modal">Test Toggle</a> -->
                <div class="directorist-radio directorist-radio-theme-admin directorist-radio-circle" >
                    <input id="pay_per_listng" type="radio" name="plan_type"
                                value="pay_per_listng" <?php echo checked($selected_plan_type, 'pay_per_listng', false); ?>>
                    <label class="directorist-radio__label" for="pay_per_listng"><?php _e('Pay Per Listing', 'directorist-woocommerce-pricing-plans'); ?></label>
                </div>
            </li>
            <li>
                <div class="directorist-radio directorist-radio-theme-admin directorist-radio-circle">
                    <input id="pay_per_package" type="radio" name="plan_type" class='atpp_cptm-modal-toggle' data-target="atpp_seelct-plan-modal"
                              value="package" <?php echo checked($selected_plan_type, 'package', false); ?> <?php echo !$selected_plan_type ? 'checked' : ''; ?>>
                    <label class="directorist-radio__label" for="pay_per_package"><?php _e('Package', 'directorist-woocommerce-pricing-plans'); ?></label>
                </div>
            </li>
        </ul>
    </td>
</tr>

<tr id="is_listing_featured" class="directorist-field-instructions">
    <td class="directorist-label">
        <label class='directorist-input-box__title' for="is_featured_listing"><?php _e('Featured the Listing', 'directorist-woocommerce-pricing-plans'); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide">
                <div class="directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                    <input id="hide_listing_featured" type="checkbox" value="1" name="_dwpp_hide_listing_featured" <?php echo (!empty($post_meta['_dwpp_hide_listing_featured'][0])) ? 'checked' : ''; ?>>
                    <label class="directorist-fm-hide-option directorist-checkbox__label" for="hide_listing_featured"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
                </div>
            </div>
        </div>
    </td>
    <td class="directorist-label">
        <label class="directorist-switch-Yn">
            <input id="is_featured_listing" type="checkbox" value="1"
                name="is_featured_listing" <?php echo (!empty($post_meta['is_featured_listing'][0])) ? 'checked' : ''; ?>>
            <span class="directorist-switch-yes"><?php _e('Yes', 'directorist-woocommerce-pricing-plans'); ?></span>
            <span class="directorist-switch-no"><?php _e('No', 'directorist-woocommerce-pricing-plans'); ?></span>
        </label>
    </td>
</tr>
<tr id="regular_listing" class="directorist-field-instructions">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Number of Listings', 'directorist-woocommerce-pricing-plans'); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="hide_listings" type="checkbox" value="1" name="_dwpp_hide_listings" <?php echo (!empty($post_meta['_dwpp_hide_listings'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option" for="hide_listings"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
        </div>
    </td>
    <td>
        <div class="directorist-form-group directorist-handle-input directorist-visible">

            <input type="number" name="num_regular" value="<?php echo !empty( $post_meta['num_regular'][0] ) ? esc_attr($post_meta['num_regular'][0]) : ''; ?>" placeholder="<?php _e('Example 100', 'directorist-woocommerce-pricing-plans'); ?>">
        </div>
        <div class="directorist-input-control directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-15">
            <input id="num_regular_unl" type="checkbox" value="1" name="num_regular_unl" <?php echo (!empty($post_meta['num_regular_unl'][0])) ? 'checked' : ''; ?>>
            <label class="directorist-checkbox__label fm_unlimited" for="num_regular_unl"><?php _e('Or mark as unlimited ', 'directorist-woocommerce-pricing-plans'); ?></label>
        </div>
    </td>
</tr>

<tr id="featured_listing" class="directorist-field-instructions">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Number of Featured Listings', 'directorist-woocommerce-pricing-plans'); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="hide_featured" type="checkbox" value="1"
                                        name="_dwpp_hide_featured" <?php echo (!empty($post_meta['_dwpp_hide_featured'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option"
                    for="hide_featured"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
        </div>
    </td>
    <td>
        <div class="directorist-form-group directorist-handle-input directorist-visible">
            <input type="number" name="num_featured"
                value="<?php if (isset($post_meta['num_featured'])) echo esc_attr($post_meta['num_featured'][0]); ?>"
                placeholder="<?php _e('Example 5', 'directorist-woocommerce-pricing-plans'); ?>">
        </div>
        <div class="directorist-input-control directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-15">
            <input id="num_featured_unl" type="checkbox" value="1" name="num_featured_unl" <?php echo (!empty($post_meta['num_featured_unl'][0])) ? 'checked' : ''; ?>>
            <label class="directorist-checkbox__label fm_unlimited" for="num_featured_unl"><?php _e('Or mark as unlimited ', 'directorist-woocommerce-pricing-plans'); ?></label>
        </div>
    </td>
</tr>

<tr class="directorist-field-instructions">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Contact Listing Owner', 'directorist-woocommerce-pricing-plans'); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="hide_Cowner" type="checkbox" value="1"
                                        name="_dwpp_hide_cl_owner" <?php echo (!empty($post_meta['_dwpp_hide_cl_owner'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option"
                    for="hide_Cowner"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
        </div>
    </td>
    <td>
        <label class="directorist-switch-Yn">
            <input type="checkbox" name="cf_owner" id="cf_owner" value="yes" <?php echo (!empty($post_meta['cf_owner'][0])) ? 'checked' : ''; ?>>
            <span class="directorist-switch-yes">Yes</span>
            <span class="directorist-switch-no">No</span>
        </label>
    </td>
</tr>


<tr class="directorist-field-instructions" id="new_plan_review_area">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Customer Reviews', 'directorist-woocommerce-pricing-plans'); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="hide_review" type="checkbox" value="1"
                                        name="hide_customer_review" <?php echo (!empty($post_meta['_dwpp_hide_customer_review'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option"
                    for="hide_review"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
        </div>
    </td>
    <td>
        <label class="directorist-switch-Yn">
            <input type="checkbox" name="fm_cs_review" id="atpp_claim-badge" value="yes" <?php echo (!empty($post_meta['fm_cs_review'][0])) ? 'checked' : ''; ?>>
            <span class="directorist-switch-yes">Yes</span>
            <span class="directorist-switch-no">No</span>
        </label>
    </td>
</tr>

<tr class="directorist-field-instructions" id="new_plan_booking_area">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php echo  __( 'Booking (Reservation & Appointment) ' . $booking_required . '', 'directorist-woocommerce-pricing-plans' ); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="dwpp_hide_booking" type="checkbox" value="1"
                                        name="dwpp_hide_booking" <?php echo (!empty($post_meta['_dwpp_hide_booking'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option"
                    for="dwpp_hide_booking"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
        </div>
    </td>
    <td>
        <label class="directorist-switch-Yn <?php echo empty( $booking_required ) ? 'disabled' : ''; ?>">
            <input type="checkbox" name="fm_booking" value="yes" <?php echo (!empty($post_meta['_fm_booking'][0])) ? 'checked' : ''; ?>>
            <span class="directorist-switch-yes">Yes</span>
            <span class="directorist-switch-no">No</span>
        </label>
    </td>
</tr>

<tr class="directorist-field-instructions" id="new_plan_chat_area">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php echo  __( 'Live Chat ' . $chat_required . '', 'directorist-woocommerce-pricing-plans' ); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="dwpp_hide_live_chat" type="checkbox" value="1"
                                        name="dwpp_hide_live_chat" <?php echo (!empty($post_meta['_dwpp_hide_live_chat'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option"
                    for="dwpp_hide_live_chat"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
        </div>
    </td>
    <td>
        <label class="directorist-switch-Yn <?php echo empty( $chat_required ) ? 'disabled' : ''; ?>">
            <input type="checkbox" name="fm_live_chat" value="yes" <?php echo (!empty($post_meta['_fm_live_chat'][0])) ? 'checked' : ''; ?>>
            <span class="directorist-switch-yes">Yes</span>
            <span class="directorist-switch-no">No</span>
        </label>
    </td>
</tr>

<tr class="directorist-field-instructions" id="new_plan_claim_area">
        <td class="directorist-label">
            <label class="directorist-input-box__title"><?php _e('Claim Badge Included', 'directorist-woocommerce-pricing-plans'). $claim_required; ?></label>
            <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="hide_claim" type="checkbox" value="1"
                                        name="dwpp_hide_claim" <?php echo (!empty($post_meta['_dwpp_hide_claim'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option"
                    for="hide_claim"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
            </div>
        </td>
        <td>
            <label class="directorist-switch-Yn directorist-switch-Yn-primary <?php echo empty( $claim_required ) ? 'disabled' : ''; ?>">
                <input type="checkbox" name="fm_claim" <?php echo (!empty($post_meta['_fm_claim'][0])) ? 'checked' : ''; ?> id="atpp_claim-badge" value="yes">
                <span class="directorist-switch-yes">Yes</span>
                <span class="directorist-switch-no">No</span>
            </label>
        </td>
    </tr>

<tr class="directorist-field-instructions" id="new_plan_sold_area">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php echo  __( 'Mark as sold ' . $m_sold_required . '', 'directorist-woocommerce-pricing-plans' ); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="dwpp_hide_mark_as_sold" type="checkbox" value="1"
                                        name="dwpp_hide_mark_as_sold" <?php echo (!empty($post_meta['_dwpp_hide_mark_as_sold'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option"
                    for="dwpp_hide_mark_as_sold"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
        </div>
    </td>
    <td>
        <label class="directorist-switch-Yn <?php echo empty( $m_sold_required ) ? 'disabled' : ''; ?>">
            <input type="checkbox" name="fm_mark_as_sold" value="yes" <?php echo (!empty($post_meta['_fm_mark_as_sold'][0])) ? 'checked' : ''; ?>>
            <span class="directorist-switch-yes">Yes</span>
            <span class="directorist-switch-no">No</span>
        </label>
    </td>
</tr>

<tr class="directorist-field-instructions">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Exclude Categories', 'directorist-woocommerce-pricing-plans'); ?></label>
        <div class="directorist-input-box__selection">
            <div class="directorist-hide directorist-checkbox directorist-checkbox-blue directorist-checkbox-square directorist-mt-10">
                <input id="hide_categories" type="checkbox" value="1"
                                        name="dwpp_hide_category" <?php echo (!empty($post_meta['_dwpp_hide_category'][0])) ? 'checked' : ''; ?>>
                <label class="directorist-checkbox__label directorist-fm-hide-option"
                    for="hide_categories"><?php _e('Hide this from pricing plan page ', 'directorist-woocommerce-pricing-plans'); ?></label>
            </div>
        </div>
    </td>
    <td>
        <label class="directorist-switch-Yn directorist-mb-20">
            <input type="checkbox" <?php echo !empty( $current_val ) ? 'checked' : ''; ?> name="exclude_categories" value="yes">
            <span class="directorist-switch-yes">Yes</span>
            <span class="directorist-switch-no">No</span>
        </label>
        <div class="directorist-switch-Yn-content directorist-checkbox-list-wrap">
            <?php
            if( !empty( $dwpp_categories ) ):
                foreach ($dwpp_categories as $key => $cat_title) {
                    $id = $cat_title->term_id;
                    $checked = in_array( $id, $current_val) ? 'checked' : '';
                    printf('
                    <div class="directorist-checkbox directorist-checkbox-blue directorist-checkbox-square">
                        <input name="exclude_cat[]" id="%s" type="checkbox" value="%s" %s>
                        <label for="%s" class="directorist-checkbox__label fm_unlimited">%s</label>
                    </div>', $id, $id, $checked, $id, $cat_title->name);
                }
            endif;
            ?>
        </div>

    </td>
</tr>

<tr class="directorist-field-instructions">

    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Recommend this Plan', 'directorist-woocommerce-pricing-plans'); ?></label>
    </td>
    <td>
        <label class="directorist-switch-Yn">
            <input type="checkbox" <?php echo (!empty($post_meta['default_pln'][0])) ? 'checked' : ''; ?> name="default_pln" id="atpp_claim-badge" value="yes">
            <span class="directorist-switch-yes">Yes</span>
            <span class="directorist-switch-no">No</span>
        </label>
    </td>
</tr>

<tr class="directorist-field-instructions">
    <td class="directorist-label">
        <label class="directorist-input-box__title"><?php _e('Hide form All Plans', 'directorist-woocommerce-pricing-plans'); ?></label>
    </td>
    <td>
        <label class="directorist-switch-Yn">
            <input type="checkbox" <?php echo (!empty($post_meta['_hide_from_plans'][0])) ? 'checked' : ''; ?> name="hide_from_plans" id="atpp_claim-badge" value="yes">
            <span class="directorist-switch-yes">Yes</span>
            <span class="directorist-switch-no">No</span>
        </label>
    </td>
</tr>

</tbody>
</table>
</div>


<!-- Model : Select Plan Alert -->
<div class="atpp_cptm-modal-container atpp_seelct-plan-modal">
    <div class="atpp_cptm-modal-wrap">
        <div class="atpp_cptm-modal">
            <div class="atpp_cptm-modal-content">
                <div class="atpp_cptm-modal-header">
                    <h3 class="atpp_cptm-modal-header-title"><?php _e( 'Change Plan Type', 'directorist-woocommerce-pricing-plans' ); ?></h3>
                </div>

                <div class="atpp_cptm-modal-body atpp_cptm-center-content atpp_cptm-content-wide">
                    <form action="#" method="post" class="atpp_cptm-import-directory-form">
                        <div class="atpp_cptm-form-group-feedback atpp_cptm-text-center atpp_cptm-mb-10"></div>

                        <h2 class="atpp_cptm-title"><?php _e( 'Please Make sure to add number of Regular and Featured listings in this package', 'directorist-woocommerce-pricing-plans' ) ?></h2>


                    </form>
                </div>
                <div class="atpp_cptm-modal-footer">
                    <div class="atpp_cptm-file-input-wrap">
                        <a href="#" class="atpp_cptm-btn atpp_cptm-btn-danger atpp_cptm-modal-toggle atpp_modal-cancel" data-target="atpp_seelct-plan-modal">
                            <?php _e( 'Cancel', 'directorist-woocommerce-pricing-plans' ); ?>
                        </a>

                        <a href="#" class="atpp_cptm-btn atpp_cptm-btn-secondary atpp_cptm-modal-toggle atpp_modal-ok" data-target="atpp_seelct-plan-modal">
                            <?php _e( 'Ok', 'directorist-woocommerce-pricing-plans' ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>