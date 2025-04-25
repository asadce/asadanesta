<?php
use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

global $post;
setup_postdata($post);

// Optional debug logging – remove in production
// error_log('Rendering single.php for post ID: ' . $post->ID);

get_header('directorist');
?>

<div class="directorist-single <?php Helper::directorist_container(); ?>">
    <?php
    // Pass post ID to Directorist safely
    $listing_id = $post->ID;
    $listing = \Directorist\Directorist_Single_Listing::instance();

    // Optional: Debug meta mismatch
    if ( $listing->id != $listing_id ) {
        error_log("Directorist ID mismatch: listing->id = {$listing->id}, expected post->ID = {$listing_id}");
    }

    // Load your overridden single-contents.php
    Helper::get_template('single-contents');
    ?>
</div>

<?php get_footer('directorist'); ?>
