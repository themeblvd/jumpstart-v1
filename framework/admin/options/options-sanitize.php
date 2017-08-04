<?php
/**
 * Sanitization Filters
 *
 * This function gets hooked to admin_init when the framework
 * runs on the admin side, but why have this in a function? --
 * Because on the frontend of the site, if the options have
 * never been saved we can call this function to allow default
 * option values to be generated. This will almost never happen,
 * so this is our way of including them, but only if needed;
 * no point in adding these filters every time the frontend loads.
 *
 * @since 2.2.0
 */
function themeblvd_add_sanitization() {
	add_filter( 'themeblvd_sanitize_text', 'themeblvd_sanitize_text' );
	add_filter( 'themeblvd_sanitize_textarea', 'themeblvd_sanitize_textarea' );
	add_filter( 'themeblvd_sanitize_select', 'themeblvd_sanitize_enum', 10, 2 );
	add_filter( 'themeblvd_sanitize_radio', 'themeblvd_sanitize_enum', 10, 2 );
	add_filter( 'themeblvd_sanitize_images', 'themeblvd_sanitize_enum', 10, 2 );
	add_filter( 'themeblvd_sanitize_checkbox', 'themeblvd_sanitize_checkbox' );
	add_filter( 'themeblvd_sanitize_multicheck', 'themeblvd_sanitize_multicheck', 10, 2 );
	add_filter( 'themeblvd_sanitize_color', 'themeblvd_sanitize_hex' );
	add_filter( 'themeblvd_sanitize_upload', 'themeblvd_sanitize_upload' );
	add_filter( 'themeblvd_sanitize_background', 'themeblvd_sanitize_background' );
	add_filter( 'themeblvd_background_repeat', 'themeblvd_sanitize_background_repeat' );
	add_filter( 'themeblvd_background_position', 'themeblvd_sanitize_background_position' );
	add_filter( 'themeblvd_background_attachment', 'themeblvd_sanitize_background_attachment' );
	add_filter( 'themeblvd_sanitize_typography', 'themeblvd_sanitize_typography' );
	add_filter( 'themeblvd_font_face', 'themeblvd_sanitize_font_face' );
	add_filter( 'themeblvd_font_style', 'themeblvd_sanitize_font_style' );
	add_filter( 'themeblvd_font_face', 'themeblvd_sanitize_font_face' );
	add_filter( 'themeblvd_sanitize_columns', 'themeblvd_sanitize_columns' );
	add_filter( 'themeblvd_sanitize_tabs', 'themeblvd_sanitize_tabs' );
	add_filter( 'themeblvd_sanitize_content', 'themeblvd_sanitize_content' );
	add_filter( 'themeblvd_sanitize_logo', 'themeblvd_sanitize_logo' );
	add_filter( 'themeblvd_sanitize_social_media', 'themeblvd_sanitize_social_media' );
	add_filter( 'themeblvd_sanitize_conditionals', 'themeblvd_sanitize_conditionals', 10, 3 );
	add_filter( 'themeblvd_sanitize_editor', 'themeblvd_sanitize_editor' );
}

/**
 * Text
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_text( $input ) {
	$allowedtags = themeblvd_allowed_tags();
	$output = wp_kses( $input, $allowedtags );
	$output = htmlspecialchars_decode( $output );
	$output = str_replace( "\r\n", "\n", $output );
	return $output;
}

/**
 * Textarea
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_textarea( $input ) {
	$allowedtags = themeblvd_allowed_tags();
	$output = wp_kses( $input, $allowedtags );
	$output = htmlspecialchars_decode( $output );
	$output = str_replace( "\r\n", "\n", $output );
	return $output;
}

/**
 * Info
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_allowedtags($input) {
	$allowedtags = themeblvd_allowed_tags();
	$output = wpautop(wp_kses( $input, $allowedtags));
	return $output;
}

/**
 * Checkbox
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_checkbox( $input ) {
	if ( $input ) {
		$output = "1";
	} else {
		$output = "0";
	}
	return $output;
}

/**
 * Multicheck
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_multicheck( $input, $option ) {
	$output = array();
	if ( is_array( $input ) ) {
		foreach ( $option['options'] as $key => $value ) {
			$output[$key] = "0";
		}
		foreach ( $input as $key => $value ) {
			if ( array_key_exists( $key, $option['options'] ) && $value ) {
				$output[$key] = "1";
			}
		}
	}
	return $output;
}

/**
 * Uploader
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_upload( $input ) {
	$output = '';
	$filetype = wp_check_filetype($input);
	if ( $filetype["ext"] ) {
		$output = $input;
	}
	return $output;
}

/**
 * Check that the key value sent is valid
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_enum( $input, $option ) {
	$output = '';
	if ( array_key_exists( $input, $option['options'] ) ) {
		$output = $input;
	}
	return $output;
}

/**
 * Background
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_background( $input ) {
	$output = wp_parse_args( $input, array(
		'color' => '',
		'image'  => '',
		'repeat'  => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll'
	) );
	$output['color'] = apply_filters( 'themeblvd_sanitize_hex', $input['color'] );
	$output['image'] = apply_filters( 'themeblvd_sanitize_upload', $input['image'] );
	$output['repeat'] = apply_filters( 'themeblvd_background_repeat', $input['repeat'] );
	$output['position'] = apply_filters( 'themeblvd_background_position', $input['position'] );
	$output['attachment'] = apply_filters( 'themeblvd_background_attachment', $input['attachment'] );
	return $output;
}

/**
 * Background - repeat
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_background_repeat( $value ) {
	$recognized = themeblvd_recognized_background_repeat();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'themeblvd_default_background_repeat', current( $recognized ) );
}

/**
 * Background - position
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_background_position( $value ) {
	$recognized = themeblvd_recognized_background_position();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'themeblvd_default_background_position', current( $recognized ) );
}

/**
 * Background - attachment
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_background_attachment( $value ) {
	$recognized = themeblvd_recognized_background_attachment();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'themeblvd_default_background_attachment', current( $recognized ) );
}

/**
 * Get recognized background positions
 *
 * @since 2.2.0
 */
function themeblvd_recognized_background_position() {
	$default = array(
		'top left'      => 'Top Left',
		'top center'    => 'Top Center',
		'top right'     => 'Top Right',
		'center left'   => 'Middle Left',
		'center center' => 'Middle Center',
		'center right'  => 'Middle Right',
		'bottom left'   => 'Bottom Left',
		'bottom center' => 'Bottom Center',
		'bottom right'  => 'Bottom Right'
	);
	return apply_filters( 'themeblvd_recognized_background_position', $default );
}

/**
 * Get recognized background attachment
 *
 * @since 2.2.0
 */
function themeblvd_recognized_background_attachment() {
	$default = array(
		'scroll' => 'Scroll Normally',
		'fixed'  => 'Fixed in Place'
	);
	return apply_filters( 'themeblvd_recognized_background_attachment', $default );
}

/**
 * Get recognized background repeat settings
 *
 * @since 2.2.0
 */
function themeblvd_recognized_background_repeat() {
	$default = array(
		'no-repeat' => 'No Repeat',
		'repeat-x'  => 'Repeat Horizontally',
		'repeat-y'  => 'Repeat Vertically',
		'repeat'    => 'Repeat All',
		);
	return apply_filters( 'themeblvd_recognized_background_repeat', $default );
}

/**
 * Typography
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_typography( $input ) {
	$output = wp_parse_args( $input, array(
		'size' 		=> '',
		'face'  	=> '',
		'style' 	=> '',
		'color' 	=> '',
		'google' 	=> ''
	) );
	$output['size']  = apply_filters( 'themeblvd_font_size', $output['size'] );
	$output['face']  = apply_filters( 'themeblvd_font_face', $output['face'] );
	$output['style'] = apply_filters( 'themeblvd_font_style', $output['style'] );
	$output['color'] = apply_filters( 'themeblvd_color', $output['color'] );
	$output['google'] = apply_filters( 'themeblvd_sanitize_text', $output['google'] );
	return $output;
}

/**
 * Typography - font size
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_font_size( $value ) {
	$recognized = themeblvd_recognized_font_sizes();
	$value = preg_replace('/px/','', $value);
	if ( in_array( (int) $value, $recognized ) ) {
		return (int) $value;
	}
	return (int) apply_filters( 'themeblvd_default_font_size', $recognized );
}

/**
 * Typography - font style
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_font_style( $value ) {
	$recognized = themeblvd_recognized_font_styles();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'themeblvd_default_font_style', 'normal' );
}

/**
 * Typography - font face
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_font_face( $value ) {
	$recognized = themeblvd_recognized_font_faces();
	if ( array_key_exists( $value, $recognized ) ) {
		return $value;
	}
	return apply_filters( 'themeblvd_default_font_face', current( $recognized ) );
}

/**
 * Columns
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_columns( $input ) {

	$width_options = themeblvd_column_widths();
	$output = array();

	// Verify number of columns is an integer
	if ( is_numeric( $input['num'] ) ) {
		$output['num'] = $input['num'];
	} else {
		$output['num'] = null;
	}

	// Verify widths
	foreach ( $input['width'] as $key => $width ) {

		$valid = false;

		foreach ( $width_options[$key.'-col'] as $width_option ) {
			if ( $width == $width_option['value'] ) {
				$valid = true;
			}
		}

		if ( $valid ) {
			$output['width'][$key] = $width;
		} else {
			$output['width'][$key] = null;
		}
	}

	return $output;
}

/**
 * Tabs
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_tabs( $input ) {

	$output = array();

	// Verify number of tabs is an integer
	if ( is_numeric( $input['num'] ) ) {
		$output['num'] = $input['num'];
	} else {
		$output['num'] = null;
	}

	// Verify style
	if ( in_array( $input['style'], array( 'open', 'framed' ) ) ) {
		$output['style'] = $input['style'];
	}

	// Verify nav
	if ( in_array( $input['nav'], array( 'tabs', 'pills', 'tabs_above', 'tabs_right', 'tabs_below', 'tabs_left', 'pills_above', 'pills_below' ) ) ) {
		$output['nav'] = $input['nav'];
	}

	// Verify name fields and only save the right amount of names
	if ( $output['num'] ) {
		$total_num = intval( $output['num'] );
		$i = 1;
		while ( $i <= $total_num ) {
			$output['names']['tab_'.$i] = sanitize_text_field( $input['names']['tab_'.$i] );
			$i++;
		}
	}
	return $output;
}

/**
 * Dynamic Content
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_content( $input ) {

	$allowedtags = themeblvd_allowed_tags();
	$output = array();

	// Verify type
	$types = array( 'widget', 'current', 'page', 'raw' );
	if ( in_array( $input['type'], $types ) ) {
		$output['type'] = $input['type'];
	} else {
		$output['type'] = null;
	}

	// Add type's corresponding option
	switch ( $output['type'] ) {

		case 'widget' :
			if ( isset( $input['sidebar'] ) ) {
				$output['sidebar'] = $input['sidebar'];
			} else {
				$output['sidebar'] = null;
			}
			break;

		case 'page' :
			$output['page'] = $input['page'];
			break;

		case 'raw' :
			$output['raw'] = wp_kses( $input['raw'], $allowedtags );
			$output['raw'] = str_replace( "\r\n", "\n", $output['raw'] );
			$output['raw_format'] = '0';
			if ( isset( $input['raw_format'] ) ) {
				$output['raw_format'] = '1';
			}
			break;
	}

	return $output;
}

/**
 * Logo
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_logo( $input ) {

	$output = array();

	// Type
	if ( is_array( $input ) && isset( $input['type'] ) ) {
		$output['type'] = $input['type'];
	}

	// Custom
	if ( isset( $input['custom'] ) ) {
		$output['custom'] = sanitize_text_field( $input['custom'] );
	}
	if ( isset( $input['custom_tagline'] ) ) {
		$output['custom_tagline'] = sanitize_text_field( $input['custom_tagline'] );
	}

	// Image (standard)
	if ( isset( $input['image'] ) ) {
		$filetype = wp_check_filetype( $input['image'] );
		if ( $filetype["ext"] ) {
			$output['image'] = $input['image'];
			if ( isset( $input['image_width'] ) ) {
				$output['image_width'] = $input['image_width'];
			}
		} else {
			$output['image'] = null;
			$output['image_width'] = null;
		}
	}

	// Image (for retina)
	if ( isset( $input['image_2x'] ) ) {
		$filetype = wp_check_filetype( $input['image_2x'] );
		if ( $filetype["ext"] ) {
			$output['image_2x'] = $input['image_2x'];
		} else {
			$output['image_2x'] = null;
		}
	}

	return $output;
}

/**
 * Social Media Buttons
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_social_media( $input ) {
	if ( ! empty( $input ) && ! empty( $input['sources'] ) ) {
		// The option is being sent from the actual
		// Theme Options page and so it hasn't been
		// formatted yet.
		$output = array();
		if ( ! empty( $input['includes'] ) ) {
			foreach ( $input['includes'] as $include ) {
				if ( isset( $input['sources'][$include] ) ) {
					$output[$include] = $input['sources'][$include];
				}
			}
		}
	} else {
		// The option has already been formatted,
		// so let it on through.
		$output = $input;
	}
	return $output;
}

/**
 * Conditionals
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_conditionals( $input, $sidebar_slug = null, $sidebar_id = null ) {

	$conditionals = themeblvd_conditionals_config();
	$output = array();

	// Prepare items that weren't straight-up arrays
	// gifted on a platter for us.
	if ( ! empty( $input['post'] ) ) {
		$input['post'] = str_replace(' ', '', $input['post'] );
		$input['post'] = explode( ',', $input['post'] );
	}
	if ( ! empty( $input['tag'] ) ) {
		$input['tag'] = str_replace(' ', '', $input['tag'] );
		$input['tag'] = explode( ',', $input['tag'] );
	}

	// Now loop through each group and then each item
	foreach ( $input as $type => $group ) {
		if ( is_array( $group ) && ! empty( $group ) ) {
			foreach ( $group as $item_id ) {
				$name = '';
				switch ( $type ) {

					case 'page' :
						$page_id = themeblvd_post_id_by_name( $item_id, 'page' );
						$page = get_page( $page_id );
						if ( $page ) {
							$name = $page->post_title;
						}
						break;

					case 'post' :
						$post_id = themeblvd_post_id_by_name( $item_id );
						$post = get_post( $post_id );
						if ( $post ) {
							$name = $post->post_title;
						}
						break;

					case 'posts_in_category' :
						$category = get_category_by_slug( $item_id );
						if ( $category ) {
							$name = $category->slug;
						}
						break;

					case 'category' :
						$category = get_category_by_slug( $item_id );
						if ( $category ) {
							$name = $category->slug;
						}
						break;

					case 'tag' :
						$tag = get_term_by( 'slug', $item_id, 'post_tag' );
						if ( $tag ) {
							$name = $tag->name;
						}
						break;

					case 'top' :
						$name = $conditionals['top']['items'][$item_id];
						break;
				}
				if ( $name ) {
					$output[$type.'_'.$item_id] = array(
						'type' 		=> $type,
						'id' 		=> $item_id,
						'name' 		=> $name,
						'post_slug' => $sidebar_slug,
						'post_id' 	=> $sidebar_id
					);
				}
			}
		}
	}
	// Add in cusotm conditional
	if ( ! empty( $input['custom'] ) ) {
		$output['custom'] = array(
			'type' 		=> 'custom',
			'id' 		=> themeblvd_sanitize_text( $input['custom'] ),
			'name' 		=> themeblvd_sanitize_text( $input['custom'] ),
			'post_slug' => $sidebar_slug,
			'post_id' 	=> $sidebar_id
		);
	}

	return $output;
}

/**
 * Sanitize Editor option type
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_editor( $input ) {
	if ( current_user_can( 'unfiltered_html' ) ) {
		$output = $input;
	} else {
		$output = wp_kses( $input, themeblvd_allowed_tags() );
	}
	return $output;
}

/**
 * Sanitize a color represented in hexidecimal notation.
 *
 * @since 2.2.0
 */
function themeblvd_sanitize_hex( $hex, $default = '' ) {
	if ( themeblvd_validate_hex( $hex ) ) {
		return $hex;
	}
	return $default;
}

/**
 * Get recognized font sizes.
 *
 * @since 2.2.0
 */
function themeblvd_recognized_font_sizes() {
	$sizes = range( 9, 71 );
	$sizes = apply_filters( 'themeblvd_recognized_font_sizes', $sizes );
	$sizes = array_map( 'absint', $sizes );
	return $sizes;
}

/**
 * Get recognized font faces.
 *
 * @since 2.2.0
 */
function themeblvd_recognized_font_faces() {
	$default = array(
		'arial'     	=> 'Arial',
		'baskerville'	=> 'Baskerville',
		'georgia'   	=> 'Georgia',
		'helvetica' 	=> 'Helvetica*',
		'lucida'  		=> 'Lucida Sans',
		'palatino'  	=> 'Palatino',
		'tahoma'    	=> 'Tahoma, Geneva',
		'times'     	=> 'Times New Roman',
		'trebuchet' 	=> 'Trebuchet',
		'verdana'   	=> 'Verdana, Geneva',
		'google'		=> 'Google Font'
	);
	return apply_filters( 'themeblvd_recognized_font_faces', $default );
}

/**
 * Get recognized font styles.
 *
 * @since 2.2.0
 */
function themeblvd_recognized_font_styles() {
	$default = array(
		'normal'      => 'Normal',
		'italic'      => 'Italic',
		'bold'        => 'Bold',
		'bold-italic' => 'Bold Italic'
	);
	return apply_filters( 'themeblvd_recognized_font_styles', $default );
}

/**
 * Verify formatted in hexidecimal notation
 *
 * @since 2.2.0
 */
function themeblvd_validate_hex( $hex ) {

	$hex = trim( $hex );

	/* Strip recognized prefixes. */
	if ( 0 === strpos( $hex, '#' ) ) {
		$hex = substr( $hex, 1 );
	} else if ( 0 === strpos( $hex, '%23' ) ) {
		$hex = substr( $hex, 3 );
	}

	/* Regex match. */
	if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
		return false;
	} else {
		return true;
	}

}
