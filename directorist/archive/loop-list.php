<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$loop_fields = $listings->loop['list_fields']['template_data']['list_view_with_thumbnail'];

/* START PA CUSTOM EDITS */
        $plan_id = get_post_meta( get_the_ID(), '_fm_plans', true );
        if ($plan_id) {
        if ($plan_id == "13713") { $list_class = "gold";} 
        if ($plan_id == "13714") { $list_class = "silver";} 
        if ($plan_id == "13715") { $list_class = "bronze";} 
        if ($plan_id == "13716") { $list_class = "business";}
        } else {
            $plan_id = "";
            $list_class = "";
        }
        
/* END PA CUSTOM EDITS - inserted addtional style below from above vars*/ 

?>


<div class="directorist-listing-single directorist-listing-list directorist-listing-has-thumb ribbon <?php echo($plan_id . " " . $list_class); ?>  <?php echo esc_attr( $listings->loop_wrapper_class() ); ?>">

	<figure class="directorist-listing-single__thumb">
		<?php $listings->loop_thumb_card_template(); ?>
		<div class="directorist-thumb-top-right"><?php $listings->render_loop_fields($loop_fields['thumbnail']['top_right']); ?></div>
        
	</figure>

	<div class="directorist-listing-single__content">

		<div class="directorist-listing-single__info">
			<div class="directorist-listing-single__info--top"><?php $listings->render_loop_fields($loop_fields['body']['top']); ?></div>
			<div class="directorist-listing-single__info--list"><ul><?php $listings->render_loop_fields($loop_fields['body']['bottom'], '<li>', '</li>'); ?></ul></div>
			<div class="directorist-listing-single__info--excerpt"><?php $listings->render_loop_fields($loop_fields['body']['excerpt']); ?></div>
			<div class="directorist-listing-single__info--right"><?php $listings->render_loop_fields($loop_fields['body']['right']); ?></div>
		</div>

		<div class="directorist-listing-single__meta">
			<div class="directorist-listing-single__meta--left"><?php $listings->render_loop_fields($loop_fields['footer']['left']); ?></div>
			<div class="directorist-listing-single__meta--right"><?php $listings->render_loop_fields($loop_fields['footer']['right']); ?></div>
		</div>

	</div>

</div>