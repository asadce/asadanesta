<?php
/**
 * Custom single-contents.php override
 * Safe and optimized version
 */

use \Directorist\Directorist_Single_Listing;
use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

// Ensure correct global $post
global $post;
$correct_id = $post->ID;

// Safely load the listing object
$listing = Directorist_Single_Listing::instance();

// Debug mismatch in IDs
if ( $listing->id != $correct_id ) {
    error_log("🟡 WARNING: single-contents.php mismatch — listing->id = {$listing->id}, expected = {$correct_id}");
}

?>

<div class="directorist-single-contents-area directorist-w-100" data-id="<?php echo esc_attr( $listing->id ?? '' ); ?>">
    <div class="<?php Helper::directorist_container_fluid(); ?>">

        <?php $listing->notice_template(); ?>

        <div class="<?php Helper::directorist_row(); ?>">

            <div class="<?php Helper::directorist_single_column(); ?>">

                <?php 
                $disable_single_listing = get_directorist_option('disable_single_listing') ? true : false;

                if ( ! $disable_single_listing ) :

                    if ( $listing->single_page_enabled() ) : ?>

                        <div class="directorist-single-wrapper">
                            <?php
                            // Filtered output of full single page content
                            echo $listing->single_page_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            ?>
                        </div>

                    <?php else: ?>

                        <div class="directorist-single-wrapper">
                            <?php
                            $listing->header_template();

                            // 👇 TEMP: Performance-safe loop (disable if needed)
                            if ( is_array( $listing->content_data ) && ! empty( $listing->content_data ) ) {
                                foreach ( $listing->content_data as $section ) {
                                    // Optional: skip heavy custom sections
                                    if ( isset($section['id']) && in_array($section['id'], ['custom-heavy-section-1']) ) {
                                        continue; // Skip problematic sections
                                    }

                                    $listing->section_template( $section );
                                }
                            } else {
                                echo '<p>No content available for this listing.</p>';
                            }
                            ?>
                        </div>

                    <?php endif;

                else : ?>

                    <div class="directorist-alert directorist-alert-warning directorist-single-listing-notice">
                        <div class="directorist-alert__content">
                            <span><?php esc_html_e('Single listing view is disabled', 'directorist'); ?></span>
                        </div>
                    </div>

                <?php endif; ?>

            </div>

            <?php Helper::get_template('single-sidebar'); ?>

        </div>
    </div>
</div>
