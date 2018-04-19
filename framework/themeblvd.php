<?php
/**
 * Theme Blvd WordPress Framework
 *
 * @author		Jason Bobich
 * @copyright	Copyright (c) Jason Bobich
 * @link		http://jasonbobich.com
 * @link		http://themeblvd.com
 * @package		Theme Blvd WordPress Framework
 */

// Constants
define( 'TB_FRAMEWORK_VERSION', '2.4.9' );
define( 'TB_FRAMEWORK_DIRECTORY', get_template_directory().'/framework' );
define( 'TB_FRAMEWORK_URI', get_template_directory_uri().'/framework' );

// Run framework
if ( is_admin() ) {

	/*------------------------------------------------------*/
	/* Admin Hooks, Filters, and Files
	/*------------------------------------------------------*/

	// Include files
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/functions/display.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/functions/general.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/functions/locals.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/functions/meta.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/options/options-interface.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/options/media-uploader-legacy.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/options/media-uploader.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/options/options-sanitize.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/options/class-tb-meta-box.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/options/class-tb-options-page.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/plugins/plugins.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/class-tb-options-api.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/class-tb-sidebars-api.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/class-tb-stylesheets-api.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/customizer.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/helpers.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/general.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/locals.php' );

	// Filters
	add_filter( 'image_size_names_choose', 'themeblvd_image_size_names_choose' );
	add_filter( 'admin_body_class', 'themeblvd_admin_body_class' );

	// Apply initial hooks
	add_action( 'themeblvd_localize', 'themeblvd_load_theme_textdomain' );
	add_action( 'themeblvd_api', 'themeblvd_api_init' );
	add_action( 'admin_enqueue_scripts', 'themeblvd_non_modular_assets' );
	add_action( 'admin_init', 'themeblvd_add_sanitization' );
	add_action( 'admin_init', 'themeblvd_clear_options' );
	add_action( 'wp_before_admin_bar_render', 'themeblvd_admin_menu_bar' );
	add_action( 'themeblvd_options_footer_text', 'themeblvd_options_footer_text_default' );
	add_action( 'admin_init', 'themeblvd_update_version' );
	add_action( 'admin_menu', 'themeblvd_hijack_page_atts' );
	add_action( 'save_post', 'themeblvd_save_page_atts' );
	add_action( 'customize_register', 'themeblvd_customizer_init' );
	add_action( 'customize_controls_print_styles', 'themeblvd_customizer_styles' );
	add_action( 'customize_controls_print_scripts', 'themeblvd_customizer_scripts' );
	add_action( 'after_setup_theme', 'themeblvd_add_image_sizes' );
	add_action( 'after_setup_theme', 'themeblvd_plugins' );
	add_action( 'after_setup_theme', 'themeblvd_admin_content_width' );
	add_action( 'admin_init', 'themeblvd_add_meta_boxes' );

	// Apply other hooks after theme has had a chance to add filters
	// Note: Options API/Settings finalized at after_setup_theme, 1000
	add_action( 'after_setup_theme', 'themeblvd_admin_init', 1001 );
	add_action( 'after_setup_theme', 'themeblvd_add_theme_support', 1001 );
	add_action( 'after_setup_theme', 'themeblvd_register_navs', 1001 );

} else {

	/*------------------------------------------------------*/
	/* Front-end Hooks, Filters, and Files
	/*------------------------------------------------------*/

	// Include files
	include_once( TB_FRAMEWORK_DIRECTORY . '/admin/options/options-sanitize.php' ); // Needed if options haven't been saved
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/class-tb-options-api.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/class-tb-sidebars-api.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/class-tb-stylesheets-api.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/customizer.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/api/helpers.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/class-tb-query.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/class-tb-frontend-init.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/actions.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/display.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/frontend.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/elements.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/general.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/helpers.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/locals.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/media.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/parts.php' );
	include_once( TB_FRAMEWORK_DIRECTORY . '/includes/post-formats.php' );

	// Filters
	add_filter( 'body_class','themeblvd_browser_class' );
	add_filter( 'oembed_result', 'themeblvd_oembed_result', 10, 2 );
	add_filter( 'embed_oembed_html', 'themeblvd_oembed_result', 10, 2 );
	add_filter( 'wp_audio_shortcode', 'themeblvd_audio_shortcode' );
	add_filter( 'themeblvd_the_content', 'wptexturize' );
	add_filter( 'themeblvd_the_content', 'wpautop' );
	add_filter( 'themeblvd_the_content', 'shortcode_unautop' );
	add_filter( 'themeblvd_the_content', 'do_shortcode' );
	add_filter( 'image_size_names_choose', 'themeblvd_image_size_names_choose' );
	add_filter( 'themeblvd_sidebar_layout', 'themeblvd_wpmultisite_signup_sidebar_layout' );
	add_filter( 'the_content_more_link', 'themeblvd_read_more_link', 10, 2 );
	add_filter( 'use_default_gallery_style', '__return_false' );
	add_filter( 'wp_title', 'themeblvd_wp_title' );
	add_filter( 'template_include', 'themeblvd_private_page' );
	add_filter( 'wp_link_pages_args', 'themeblvd_link_pages_args' );
	add_filter( 'wp_link_pages_link', 'themeblvd_link_pages_link', 10, 2 );
	add_filter( 'comment_reply_link', 'themeblvd_comment_reply_link' );
	add_filter( 'themeblvd_column_class', 'themeblvd_column_class_legacy' );
	add_filter( 'walker_nav_menu_start_el', 'themeblvd_nav_menu_start_el', 10, 4 );

	// Apply initial hooks
	add_action( 'themeblvd_localize', 'themeblvd_load_theme_textdomain' );
	add_action( 'themeblvd_api', 'themeblvd_api_init' );
	add_action( 'after_setup_theme', 'themeblvd_add_theme_support' );
	add_action( 'after_setup_theme', 'themeblvd_add_image_sizes' );
	add_action( 'wp_enqueue_scripts', 'themeblvd_include_scripts' );
	add_action( 'wp_before_admin_bar_render', 'themeblvd_admin_menu_bar' );
	add_action( 'customize_register', 'themeblvd_customizer_init' );
	add_action( 'wp_loaded', 'themeblvd_customizer_preview' );

	// Apply other hooks after theme has had a chance to add filters
	// Note: Options API/Settings finalized at after_setup_theme, 1000
	add_action( 'after_setup_theme', 'themeblvd_register_navs', 1001 );
	add_action( 'after_setup_theme', 'themeblvd_frontend_init', 1001 );

	// <head> hooks
	add_action( 'wp_head', 'themeblvd_viewport_default' );

	// Header hooks
	add_action( 'themeblvd_header_above', 'themeblvd_header_above_default' );
	add_action( 'themeblvd_header_content', 'themeblvd_header_content_default' );
	add_action( 'themeblvd_header_logo', 'themeblvd_header_logo_default' );
	add_action( 'themeblvd_header_menu', 'themeblvd_header_menu_default' );

	// Sidebars
	add_action( 'themeblvd_fixed_sidebar_before', 'themeblvd_fixed_sidebar_before_default' );
	add_action( 'themeblvd_fixed_sidebar_after', 'themeblvd_fixed_sidebar_after_default' );
	add_action( 'themeblvd_sidebars', 'themeblvd_fixed_sidebars' );

	// Featured area hooks
	add_action( 'themeblvd_featured_start', 'themeblvd_featured_start_default' );
	add_action( 'themeblvd_featured_end', 'themeblvd_featured_end_default' );
	add_action( 'themeblvd_featured_below_start', 'themeblvd_featured_below_start_default' );
	add_action( 'themeblvd_featured_below_end', 'themeblvd_featured_below_end_default' );

	// Main content area hooks
	add_action( 'themeblvd_main_start', 'themeblvd_main_start_default' );
	add_action( 'themeblvd_main_top', 'themeblvd_main_top_default' );
	add_action( 'themeblvd_main_bottom', 'themeblvd_main_bottom_default' );
	add_action( 'themeblvd_main_end', 'themeblvd_main_end_default' );
	add_action( 'themeblvd_breadcrumbs', 'themeblvd_breadcrumbs_default' );

	// Footer
	add_action( 'themeblvd_footer_content', 'themeblvd_footer_content_default' );
	add_action( 'themeblvd_footer_sub_content', 'themeblvd_footer_sub_content_default' );
	add_action( 'themeblvd_footer_below', 'themeblvd_footer_below_default' );

	// Content
	add_action( 'themeblvd_content_top', 'themeblvd_content_top_default' );
	add_action( 'themeblvd_blog_meta', 'themeblvd_blog_meta_default' );
	add_action( 'themeblvd_blog_tags', 'themeblvd_blog_tags_default' );
	add_action( 'themeblvd_the_post_thumbnail', 'themeblvd_the_post_thumbnail_default', 9, 5 );
	add_action( 'themeblvd_blog_content', 'themeblvd_blog_content_default' );

	// Elements
	add_action( 'themeblvd_element_open', 'themeblvd_element_open_default', 9, 3 );
	add_action( 'themeblvd_element_close', 'themeblvd_element_close_default', 9, 3 );

	// WordPress Multisite Signup
	add_action( 'before_signup_form', 'themeblvd_before_signup_form' );
	add_action( 'after_signup_form', 'themeblvd_after_signup_form' );
}

// Optional Intervene for anything that needs to
// happen before API is established.
do_action( 'themeblvd_intervene' );

// Register text domains
do_action( 'themeblvd_localize' );

// Initiate API
do_action( 'themeblvd_api' );

// Run theme functions
include_once( get_template_directory() . '/includes/theme-functions.php' );
