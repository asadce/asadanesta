<?php
/**
 * The template to display login link
 *
 * @package ThemeREX Addons
 * @since v1.0.1
 */

// Display link
$args = get_query_var('trx_addons_args_login');

// If user not logged in
if ( !is_user_logged_in() ) {
	?><ul class="sc_layouts_login_menu sc_layouts_menu_nav sc_layouts_menu_no_collapse"><li class="menu-item"><a href="#trx_addons_login_popup" class="trx_addons_popup_link trx_addons_login_link "><?php
		?><span class="sc_layouts_item_icon sc_layouts_login_icon sc_icons_type_icons trx_addons_icon-user-alt"></span><?php
		if (!empty($args['text_login'])) {
			?><span class="sc_layouts_item_details sc_layouts_login_details"><?php
				$rows = explode('|', $args['text_login']);
				if (!empty($rows[0])) {
					?><span class="sc_layouts_item_details_line1 sc_layouts_iconed_text_line1"><?php echo esc_html($rows[0]); ?></span><?php
				}
				if (!empty($rows[1])) {
					?><span class="sc_layouts_item_details_line2 sc_layouts_iconed_text_line2"><?php echo esc_html($rows[1]); ?></span><?php
				}
			?></span><?php
		}
	?></a></li></ul><?php

// Else if user logged in
} else {
	?><ul class="sc_layouts_login_menu sc_layouts_dropdown sc_layouts_menu_nav sc_layouts_menu_no_collapse">
		<li class="menu-item<?php if (!empty($args['user_menu'])) { echo ' menu-item-has-children'; } ?>">
			<a href="<?php
				if (empty($args['user_menu']))
					echo esc_url( wp_logout_url( apply_filters( 'trx_addons_filter_logout_url', home_url('/') ) ) );
				else
					echo '#';
				?>" class="trx_addons_login_link"><?php
				// User profile photo
				if ( anesta_exists_bbpress() ) {
					?><span class="sc_layouts_item_avatar"><?php
						bp_loggedin_user_avatar( 'type=thumb&width=50&height=50' ); 
					?></span><?php
				} else {
					?><span class="sc_layouts_item_icon sc_layouts_login_icon sc_icons_type_icons trx_addons_icon-<?php echo empty($args['user_menu']) ? 'user-times' : 'user-alt'; ?>"></span><?php
				}
				if (!empty($args['text_logout'])) {
					?><span class="sc_layouts_item_details sc_layouts_login_details"><?php
						$current_user = wp_get_current_user();
						$rows = explode('|', str_replace('%s',
														!empty($current_user->user_firstname)	// user_login or user_firstname or user_lastname or display_name
															? $current_user->user_firstname
															: $current_user->user_login,
														$args['text_logout'])
										);
						if (!empty($rows[0])) {
							?><span class="sc_layouts_item_details_line1 sc_layouts_iconed_text_line1"><?php echo esc_html($rows[0]); ?></span><?php
						}
						if (!empty($rows[1])) {
							?><span class="sc_layouts_item_details_line2 sc_layouts_iconed_text_line2"><?php echo esc_html($rows[1]); ?></span><?php
						}
					?></span><?php
				}
			?></a><?php 
			if (!empty($args['user_menu'])) {
				?><ul><?php
					do_action('trx_addons_action_login_menu_start');
									
					
					do_action('trx_addons_action_login_menu_logout');
					// Logout
					?><li class="menu-item trx_addons_icon-user-times"><a href="<?php echo esc_url( wp_logout_url( apply_filters( 'trx_addons_filter_logout_url', home_url('/') ) ) ); ?>"><span><?php esc_html_e('Logout', 'anesta'); ?></span></a></li><?php
					do_action('trx_addons_action_login_menu_end');
				?></ul><?php 
			}
		?></li>
	</ul><?php
}
