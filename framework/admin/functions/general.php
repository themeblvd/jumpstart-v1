<?php
/**
 * Initialize anything needed for admin panel to run.
 *
 * @since 2.0.0
 */
function themeblvd_admin_init() {

	// Allow theme options page to run if framework filters
	// have don't have it hidden it and user is capable.
	if ( themeblvd_supports( 'admin', 'options' ) && current_user_can( themeblvd_admin_module_cap( 'options' ) ) ) {

		// Access Options API, instance should already be created.
		$api = Theme_Blvd_Options_API::get_instance();

		// Option ID the theme options are registered and
		// saved to. -- i.e. get_option( $option_name )
		$option_id = $api->get_option_id();

		// All options constructed from framework and
		// potentially added to by client API.
		$options = $api->get_formatted_options();

		// Arguments for theme options admin page.
		// Filterable with "themeblvd_theme_options_args"
		$args = $api->get_args();

		// Theme Options Page
		$options_page = new Theme_Blvd_Options_Page( $option_id, $options, $args );

	}

}

/**
 * Save current version of framework to DB.
 *
 * @since 2.3.0
 */
function themeblvd_update_version() {
	update_option( 'themeblvd_framework_version', TB_FRAMEWORK_VERSION );
}

if ( !function_exists( 'themeblvd_non_modular_assets' ) ) :
/**
 * Non-modular Admin Assets
 *
 * @since 2.0.0
 */
function themeblvd_non_modular_assets() {

	global $pagenow;

	// Assets for editing posts
	if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
		wp_enqueue_style( 'tb_meta_box-styles', TB_FRAMEWORK_URI . '/admin/assets/css/meta-box.min.css', false, false, 'screen' );
		wp_enqueue_script( 'tb_meta_box-scripts', TB_FRAMEWORK_URI . '/admin/assets/js/meta-box.min.js', array('jquery'), TB_FRAMEWORK_VERSION );
		wp_localize_script( 'tb_meta_box-scripts', 'themeblvd', themeblvd_get_admin_locals( 'js' ) );
	}

	// Includes Theme Blvd admin icon font
	wp_enqueue_style( 'tb_admin_global', TB_FRAMEWORK_URI . '/admin/assets/css/admin-global.min.css', null, TB_FRAMEWORK_VERSION );

}
endif;

/**
 * Gather all assignments for posts into a single
 * array organized by post ID.
 *
 * @since 2.0.0
 *
 * @param $posts array all posts from WP's get_posts()
 * @return $assignments array assignments from all posts organized by ID
 */
function themeblvd_get_assignment_conflicts( $posts ) {

	// Setup $conflicts/$non_conflicts arrays
	$non_conflicts = array();
	$conflicts = array();
	$locations = themeblvd_get_sidebar_locations();
	foreach ( $locations as $location ) {
		$conflicts[$location['location']['id']] = array();
		$non_conflicts[$location['location']['id']] = array();
	}

	// Loop through sidebar posts to construct two arrays side-by-side.
	// As we build the $non_conflicts arrays, we will be able to build
	// the $conflicts arrays off to the side by checking if items already
	// exist in the $non_conflicts.
	foreach ( $posts as $post ) {

		// Determine location sidebar is assigned to.
		$location = get_post_meta( $post->ID, 'location', true );

		// Only run check if a location exists and this
		// is not a floating widget area.
		if ( $location && $location != 'floating' ) {

			$assignments = get_post_meta( $post->ID, 'assignments', true );

			if ( is_array( $assignments ) && ! empty( $assignments ) ) {
				foreach ( $assignments as $key => $assignment ) {

					if ( $key != 'custom' && in_array( $key, $non_conflicts[$location] ) ) {
						if ( ! in_array( $key, $conflicts[$location] ) ) {
							$conflicts[$location][] = $key;
						}
					} else {
						$non_conflicts[$location][] = $key;
					}

				}
			}
		}
	}
	return $conflicts;
}

/**
 * Hijack and modify default WP's "Page Attributes"
 * meta box.
 *
 * @since 2.0.0
 */
function themeblvd_hijack_page_atts() {
	if ( themeblvd_supports( 'meta', 'hijack_atts' ) ) {
		remove_meta_box( 'pageparentdiv', 'page', 'side' );
		add_meta_box( 'themeblvd_pageparentdiv', __( 'Page Attributes', 'themeblvd' ), 'themeblvd_page_attributes_meta_box', 'page', 'side', 'core' );
	}
}

/**
 * Saved data from Hi-jacked "Page Attributes"
 * meta box.
 *
 * @since 2.0.0
 */
function themeblvd_save_page_atts( $post_id ) {
	if ( themeblvd_supports( 'meta', 'hijack_atts' ) ) {

		// Save sidebar layout
		if ( isset( $_POST['_tb_sidebar_layout'] ) ) {
			update_post_meta( $post_id, '_tb_sidebar_layout', $_POST['_tb_sidebar_layout'] );
		}

		// Save custom layout
		if ( isset( $_POST['_tb_custom_layout'] ) ) { // backwards compat
			update_post_meta( $post_id, '_tb_custom_layout', $_POST['_tb_custom_layout'] );
		}

	}
}

/**
 * Determine if current admin page is an admin
 * module page.
 *
 * @since 2.2.0
 */
function themeblvd_is_admin_module() {

	global $pagenow;
	global $_GET;

	// Current page
	$current_page = $pagenow;
	if ( isset( $_GET['page'] ) ) {
		$current_page .= sprintf( '?page=%s', $_GET['page'] );
	}

	// Get admin modules
	$modules = themeblvd_get_admin_modules();

	return in_array( $current_page, $modules );
}

/**
 * Clear set of options. Hooked to "admin_init".
 *
 * @since 2.3.0
 */
function themeblvd_clear_options() {
	if ( isset( $_POST['themeblvd_clear_options'] ) ) {
		check_admin_referer( themeblvd_get_option_name().'-options' );
		$option_id = $_POST['themeblvd_clear_options'];
		delete_option( $option_id );
		add_settings_error( $option_id , 'clear_defaults', __( 'Options cleared from database.', 'themeblvd' ), 'themeblvd-error error fade' );
	}
}

if ( !function_exists( 'themeblvd_admin_content_width' ) ) :
/**
 * Adjust frontend content width for admin panel.
 *
 * This is a little ironic, as $content_width is only for
 * the frontend of the site. This was originally implemented
 * so videos can be displayed at a reasonable size with WP 3.6+
 * in the admin panel when editing a video format post.
 *
 * @since 2.2.1
 */
function themeblvd_admin_content_width() {
	global $content_width;
	$content_width = 600;
}
endif;

/**
 * Integrate 3.8+ admin styling.
 *
 * This function will help the transition period as we go
 * from MP6 to these new admin styles being incorporated
 * into WP core.
 *
 * @todo Remove sometime after WP 3.8 has been released. No rush.
 *
 * @since 2.4.0
 */
function themeblvd_admin_body_class( $classes ) {

	global $wp_version;

	// If WordPress 3.8+, add themeblvd-ui class
	if ( version_compare( floatval( $wp_version ), '3.8', '>=' ) ) {

		$classes = explode( " ", $classes );

	    if ( ! in_array( 'themeblvd-ui', $classes ) ) {
	        $classes[] = 'themeblvd-ui';
	    }

	    $classes = implode( " ", $classes );
	}

	return $classes;
}