<?php
/**
 * @author  wpWax
 * @since   6.7
 * @version 7.5
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*PA CUSTOM START*/
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
                        
/*PA CUSTOM END*/ 
?>
<div class="directorist-card directorist-single-listing-header <?php echo($plan_id . " " . $list_class); ?>">

	<div class="directorist-card__header directorist-flex directorist-align-center directorist-justify-content-between">

		<?php if ( $use_listing_title || $section_title ) : ?>
			<h4 class="directorist-card__header--title"><?php directorist_icon( $section_icon );?>
				<?php 
					if( empty( $use_listing_title ) ) { 
						echo esc_html( $section_title );
					} else {
						echo esc_html( $listing->get_title() );
					}	
				?>
			</h4>
		<?php endif; ?>

		<?php $listing->quick_actions_template(); ?>

	</div>

    
	<div class="directorist-card__body">

		<?php $listing->slider_template(); ?>

		<div class="directorist-listing-details">

			<?php $listing->quick_info_template(); ?>

			<?php if ( $display_title ): ?>
				<h2 class="directorist-listing-details__listing-title"><?php echo esc_html( $listing->get_title() ); ?></h2>
			<?php endif; ?>

			<?php do_action( 'directorist_single_listing_after_title', $listing->id ); ?>

			<?php if ( $display_tagline && $listing->get_tagline() ): ?>
				<p class="directorist-listing-details-tagline"><?php echo esc_html( $listing->get_tagline() ); ?></p>
			<?php endif; ?>

			<?php if ( $display_content && $listing->get_contents() ): ?>
				<div class="directorist-listing-details__text">
					<?php echo wp_kses_post( $listing->get_contents() ); ?>
				</div>
			<?php endif; ?>

		</div>

	</div>

</div>