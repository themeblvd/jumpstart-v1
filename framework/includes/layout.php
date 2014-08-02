<?php
/**
 * Display set of elements
 *
 * @since 2.5.0
 *
 * @param array $elements All elements to loop through and display
 * @param string $context Context for elements, element or block (within a column)
 */
function themeblvd_elements( $section_id, $elements, $context = 'element' ) { // $context can be element or block

	if ( $elements ) {

		$i = 1;
		$total = count($elements);

		foreach ( $elements as $id => $element ) {

			$args = array(
				'section'	=> $section_id,
				'id'		=> $id,
				'num'		=> $i,
				'total'		=> $total,
				'context'	=> $context
			);

			if ( isset( $element['type'] ) ) {
				$args['type'] = $element['type'];
			}

			if ( isset( $element['label'] ) ) {
				$args['label'] = $element['label'];
			}

			if ( isset( $element['options'] ) ) {
				$args['options'] = $element['options'];
			}

			if ( isset( $element['display'] ) ) {
				$args['display'] = $element['display'];
			}

			themeblvd_element( $args );

			$i++;

		}
	}
}

/**
 * Display individual element
 *
 * @since 2.5.0
 *
 * @param array $args Arguments for display
 */
function themeblvd_element( $args ) {

	$defaults = array(
		'section'	=> '',			// Unique ID for the section
		'id'		=> '',			// Unique ID for the element
		'type'		=> '',			// The type of element to display
		'label'		=> '',			// Element label
		'options'	=> array(),		// Settings for this element
		'display'	=> array(),		// Display settings for this element
		'num'		=> 1,			// Current count for the element being displayed
		'total'		=> 1,			// Total number of elements in parent section
		'context'	=> 'element'	// Context for elements, element or block (within a column)
	);
	$args = wp_parse_args( $args, $defaults );

	// Element class
	$class = implode( ' ', themeblvd_get_element_class( $args ) );

	// Open element
	do_action( 'themeblvd_element_'.$args['type'].'_before', $args['id'], $args['options'], $args['section'], $args['display'], $args['context'] ); // Before element: themeblvd_element_{type}_before
	printf( '<div id="%s" class="%s" style="%s">', $args['id'], $class, themeblvd_get_display_inline_style($args['display']) );
	do_action( 'themeblvd_element_'.$args['type'].'_top', $args['id'], $args['options'], $args['section'], $args['display'], $args['context'] ); // Top of element: themeblvd_element_{type}_top

	// Display element
	switch ( $args['type'] ) {

		/*------------------------------------------------------*/
		/* Layout (layout.php)
		/*------------------------------------------------------*/

		case 'columns' :

			$num = 1;

			if ( is_string( $args['options']['setup'] ) ) {
				$num = count( explode( '-', $args['options']['setup'] ) );
			}

			$col_args = array(
				'section'		=> $args['section'],
				'layout_id'		=> themeblvd_config('builder_post_id'),
				'element_id' 	=> $args['id'],
				'num'			=> $num,
				'widths'		=> $args['options']['setup'],
				'height'		=> $args['options']['height'],
				'align'			=> $args['options']['align']
			);
			themeblvd_columns( $col_args );
			break;

		/*------------------------------------------------------*/
		/* Content (content.php)
		/*------------------------------------------------------*/

		// Content (direct input)
		case 'content' :
			themeblvd_content_block( $args['options'] );
			break;

		// Current (from post content)
		case 'current' :
			themeblvd_post_content();
			break;

		// External Page/Post content
		case 'external' :
			themeblvd_post_content( intval($args['options']['post_id']) );
			break;

		// Headline
		case 'headline' :
			themeblvd_headline( $args['options'] );
			break;

		// HTML
		case 'html' :
			echo stripslashes( $args['options']['html'] );
			break;

		// Quote
		case 'quote' :
			themeblvd_blockquote( $args['options'] );
			break;

		// Widget area
		case 'widget' :
			themeblvd_widgets( $args['options']['sidebar'], $args['context'] );
			break;

		/*------------------------------------------------------*/
		/* Components (components.php)
		/*------------------------------------------------------*/

		// Alert
		case 'alert' :
			themeblvd_alert( $args['options'] );
			break;

		// Divider
		case 'divider' :
			themeblvd_divider( $args['options'] );
			break;

		// Google Map
		case 'map' :
			themeblvd_map( $args['options'] );
			break;

		// Icon Box
		case 'icon_box' :
			themeblvd_icon_box( $args['options'] );
			break;

		// Jumbotron
		case 'jumbotron' :
			themeblvd_jumbotron( $args['options'] );
			break;

		// Panel
		case 'panel' :
			themeblvd_panel( $args['options'] );
			break;

		// Partner Logos
		case 'partners' :
			themeblvd_logos( $args['options'] );
			break;

		// Promo Box
		case 'slogan' :
			themeblvd_slogan( $args['options'] );
			break;

		// Tabs
		case 'tabs' :
			themeblvd_tabs( $args['id'], $args['options'] );
			break;

		// Team Member
		case 'team_member' :
			themeblvd_team_member( $args['options'] );
			break;

		// Testimonial
		case 'testimonial' :
			themeblvd_testimonial( $args['options'] );
			break;

		// Testimonial Slider
		case 'testimonial_slider' :
			themeblvd_testimonial_slider( $args['options'] );
			break;

		// Toggles
		case 'toggles' :
			themeblvd_toggles( $args['id'], $args['options'] );
			break;

		/*------------------------------------------------------*/
		/* Posts (loop.php)
		/*------------------------------------------------------*/

		// Post Grid
		case 'post_grid' :
			themeblvd_post_grid( $args['options'] );
			break;

		// Post List
		case 'post_list' :
			themeblvd_post_list( $args['options'] );
			break;

		// Post Slider
		case 'post_slider' :
		case 'post_slider_popout' :
			themeblvd_post_slider( $args['options'] );
			break;

		/*------------------------------------------------------*/
		/* Media (media.php)
		/*------------------------------------------------------*/

		// Image
		case 'image' :
			themeblvd_image( $args['options']['image'], $args['options'] );
			break;

		// Slider (Custom, requires Theme Blvd Sliders plugin)
		case 'slider' :
			themeblvd_slider( $args['options']['slider_id'] );
			break;

		// Simple Slider (standard and popout)
		case 'simple_slider' :
		case 'simple_slider_popout' :
			$images = $args['options']['images'];
			unset( $args['options']['images'] );
			themeblvd_simple_slider( $images, $args['options'] );
			break;

		// Video
		case 'video' :
			themeblvd_video( $args['options']['video'], $args['options'] );
			break;

		/*------------------------------------------------------*/
		/* Parts (parts.php)
		/*------------------------------------------------------*/

		// Breacrumbs
		case 'breadcrumbs' :
			themeblvd_the_breadcrumbs();
			break;

		// Contact Buttons
		case 'contact' :
			themeblvd_contact_bar( $args['options']['buttons'], $args['options'] );
			break;

		/*------------------------------------------------------*/
		/* Charts and Graphs (stats.php)
		/*------------------------------------------------------*/

		// Chart (bar)
		case 'chart_bar' :
			themeblvd_chart( 'bar', $args['options'] );
			break;

		// Chart (line)
		case 'chart_line' :
			themeblvd_chart( 'line', $args['options'] );
			break;

		// Chart (pie)
		case 'chart_pie' :
			themeblvd_chart( 'pie', $args['options'] );
			break;

		// Milestone
		case 'milestone' :
			themeblvd_milestone( $args['options'] );
			break;

		// Milestone Ring (represents percentage)
		case 'milestone_ring' :
			themeblvd_milestone_ring( $args['options'] );
			break;

		// Progress Bars
		case 'progress_bars' :
			themeblvd_progress_bars( $args['options'] );
			break;

	}

	// Close element
	do_action( 'themeblvd_element_'.$args['type'].'_bottom', $args['id'], $args['options'], $args['section'], $args['display'], $args['context'] ); // Before element: themeblvd_element_{type}_bottom
	printf( '</div><!-- #%s (end) -->', $args['id'] );
	do_action( 'themeblvd_element_'.$args['type'].'_after', $args['id'], $args['options'], $args['section'], $args['display'], $args['context']  ); // Top of element: themeblvd_element_{type}_after

}

/**
 * Get CSS classes needed for individual element
 *
 * @since 2.5.0
 *
 * @param array $args Arguments from themeblvd_element()
 * @return string $class CSS class to return
 */
function themeblvd_get_element_class( $args ) {

	// Ensure that $args is setup right and matches
	// what should be coming from themeblvd_element()
	$defaults = array(
		'id'		=> '',			// Unique ID for the element
		'type'		=> '',			// The type of element to display
		'label'		=> '',			// Element label
		'options'	=> array(),		// Settings for this element
		'display'	=> array(),		// Display settings for this element
		'num'		=> 1,			// Current count for the element being displayed
		'total'		=> 1,			// Total number of elements in parent section
		'context'	=> 'element'	// Context for elements, element or block (within a column)
	);
	$args = wp_parse_args( $args, $defaults );

	// Start class
	$class = array( 'element', 'element-'.$args['num'], 'element-'.$args['type'] );

	// Is the element being display within the "Columns" element?
	if ( $args['context'] == 'block' ) {
		$class[] = 'element-block';
	}

	// First and last elements
	if ( $args['num'] == 1 ) {
		$class[] = 'first';
	}
	if ( $args['total'] == $args['num'] ) {
		$class[] = 'last';
	}

	// Label
	if ( $args['label'] && $args['label'] != '...' ) {
		$label = str_replace( ' ', '-', $args['label'] );
		$label = preg_replace( '/[^\w-]/', '', $label );
		$class[] = strtolower($label);
	}

	// Display classes
	if ( $args['display'] ) {

		// Is the element popped out?
		if ( ! empty( $args['display']['apply_popout'] ) ) {
			$class[] = 'popout';
		}

		// Does the element have the default content BG applied?
		if ( ! empty( $args['display']['bg_content'] ) ) {
			$class[] = 'bg-content';
			$class[] = 'text-'.apply_filters('themeblvd_text_color', 'dark');
		}

		// Is the element sucked up?
		if ( ! empty( $args['display']['suck_up'] ) ) {
			$class[] = 'suck-up';
		}

		// Or maybe sucked down?
		if ( ! empty( $args['display']['suck_down'] ) ) {
			$class[] = 'suck-down';
		}

		// Responsive visibility
		if ( ! empty( $args['display']['visibility'] ) ) {
			$class[] = themeblvd_responsive_visibility_class( $args['display']['visibility'] );
		}

		// User-added CSS classes
		if ( ! empty( $args['display']['classes'] ) ) {
			$class[] = $args['display']['classes'];
		}

	}

	// For custom sliders, we can specify the type of slider
	if ( $args['type'] == 'slider' ) {
		if ( isset( $args['options']['slider_id'] ) ) {
			$slider_id = themeblvd_post_id_by_name( $args['options']['slider_id'], 'tb_slider' );
			$slider_type = get_post_meta( $slider_id, 'type', true );
			$class[] = 'element-slider-'.$slider_type;
		}
	}

	// For paginated post list/grid we want to output the shared
	// class that Post List/Grid page templates, and main index.php
	// are using.
	if ( $args['type'] == 'post_list' || $args['type'] == 'post_grid' ) {
		if ( isset( $args['options']['display'] ) && $args['options']['display'] == 'paginated' ) {
			$class[] = sprintf( 'paginated_%s', $args['type'] );
		}
	}

	// Post grid galleries
	if ( in_array( $args['type'], apply_filters( 'themeblvd_gallery_elements', array( 'post_grid', 'portfolio' ) ) ) ) {
		$class[] = 'themeblvd-gallery';
	}

	// Clear fix
	$class[] = 'clearfix';

	/**
	 * Support @deprecated class addon filter. This comes from the
	 * old themeblvd_get_classes() function, which was removed in
	 * framework v2.5. Note that the only elements present here
	 * in this list are ones that existed prior to 2.5.
	 */
	$deprecated = apply_filters( 'themeblvd_element_classes', array(
		'element_columns' 				=> array(),
		'element_content' 				=> array(),
		'element_divider' 				=> array(),
		'element_headline' 				=> array(),
		'element_jumbotron' 			=> array(),
		'element_post_grid_paginated' 	=> array(),
		'element_post_grid' 			=> array(),
		'element_post_grid_slider' 		=> array(),
		'element_post_list_paginated' 	=> array(),
		'element_post_list' 			=> array(),
		'element_post_list_slider' 		=> array(),
		'element_post_slider' 			=> array(),
		'element_slider' 				=> array(),
		'element_slogan' 				=> array(),
		'element_tabs' 					=> array(),
		'element_tweet' 				=> array()
	), $args['type'], $args['options'], $args['section'] );

	foreach ( $deprecated as $key => $value ) {
		if ( $value && $key == 'element_'.$args['type'] ) {

			// General elements
			$class = array_merge( $class, $value );

			// Specific slider type
			if ( isset( $slider_type ) && $key == 'slider_'.$slider_type ) {
				$class = array_merge( $class, $value );
			}

		}
	}

	/**
	 * If you want to filter element classes, use the following
	 * "themeblvd_element_class" and check for $type. Avoid using
	 * above, deprecated filter.
	 */
	return apply_filters( 'themeblvd_element_class', $class, $args['type'], $args );
}

/**
 * Get CSS classes needed for individual element
 *
 * @since 2.5.0
 *
 * @param array $args Data saved for section
 * @param int $count Number of elements in the current section
 * @return string $class CSS class to return
 */
function themeblvd_get_section_class( $data, $count ) {

	$class = array( 'element-section', 'element-count-'.$count );

	// Label
	if ( $data['label'] && $data['label'] != '...' ) {
		$label = str_replace( ' ', '-', $data['label'] );
		$label = preg_replace( '/[^\w-]/', '', $label );
		$class[] = strtolower($label);
	}

	// Display classes
	if ( ! empty( $data['display'] ) ) {
		$class = array_merge( $class, themeblvd_get_display_class( $data['display'] ) );
	}

	return apply_filters( 'themeblvd_section_class', $class, $data, $count );
}

/**
 * Get class for a set of display options. Used for
 * sections and columns, NOT elements.
 *
 * @since 2.5.0
 *
 * @param array $display Display options
 * @return string $style Inline style line to be used
 */
function themeblvd_get_display_class( $display ) {

	$class = array();

	if ( ! empty( $display['bg_type'] ) ) {

		$bg_type = $display['bg_type'];

		if ( $bg_type == 'none' ) {

			$class[] = 'standard';

		} else {

			$class[] = 'has-bg';
			$class[] = $bg_type;

			if ( $bg_type == 'color' || $bg_type == 'image' || $bg_type == 'texture' ) {
				if ( ! empty( $display['text_color'] ) ) {
					$class[] = 'text-'.$display['text_color'];
				}
			}

			if ( $bg_type == 'image' && ! empty( $display['apply_bg_shade'] ) ) {
				$class[] = 'has-bg-shade';
			}

		}

		if ( $bg_type == 'texture' ) {

			if ( ! empty( $display['apply_bg_texture_parallax'] ) ) {
				$class[] = 'tb-parallax';
			}

		} else if ( $bg_type == 'image' ) {

			if ( ! empty( $display['bg_image']['attachment'] ) && $display['bg_image']['attachment'] == 'parallax' ) {

				$class[] = 'tb-parallax';

				if ( ! empty( $display['bg_image_parallax_stretch'] ) ) {
					$class[] = 'tb-bg-cover';
				}

			}

		}

		// Custom padding?
		if ( ! empty( $display['apply_padding'] ) ) {
			$class[] = 'has-custom-padding';
		}

		// User-added CSS classes
		if ( ! empty( $display['classes'] ) ) {
			$class[] = $display['classes'];
		}

	}

	return apply_filters( 'themeblvd_display_class', $class, $display );
}

/**
 * If parallax is applicable for section, get the intensity.
 *
 * @since 2.5.0
 *
 * @param array $display Display options
 * @return string $intensity Intensity of the effect, 1-10
 */
function themeblvd_get_parallax_intensity( $display ) {

	$intensity = 0;

	$bg_type = '';

	if ( ! empty( $display['bg_type'] ) ) {
		$bg_type = $display['bg_type'];
	}

	if ( $bg_type == 'texture' ) {

		if ( ! empty( $display['apply_bg_texture_parallax'] ) && ! empty( $display['bg_texture_parallax'] ) ) {
			$intensity = $display['bg_texture_parallax'];
		}

	} else if ( $bg_type == 'image' ) {

		if ( ! empty( $display['bg_image']['attachment'] ) && $display['bg_image']['attachment'] == 'parallax' && ! empty( $display['bg_image_parallax'] ) ) {
			$intensity = $display['bg_image_parallax'];
		}

	}

	return apply_filters( 'themeblvd_parallax_intensity', $intensity, $display );
}

/**
 * Get inline styles for a set of display options.
 *
 * @since 2.5.0
 *
 * @param array $display Display options
 * @return string $style Inline style line to be used
 */
function themeblvd_get_display_inline_style( $display ) {

	$bg_type = '';
	$style = '';
	$params = array();

	if ( empty( $display['bg_type'] ) ) {
		$bg_type = 'none';
	} else {
		$bg_type = $display['bg_type'];
	}

	if ( in_array( $bg_type, array('color', 'texture', 'image') ) ) {

		if ( ! empty( $display['bg_color'] ) ) {

			$bg_color = $display['bg_color'];

			if ( ! empty( $display['bg_color_opacity'] ) ) {
				$bg_color = themeblvd_get_rgb( $bg_color, $display['bg_color_opacity'] );
			}

			$params['background-color'] = $bg_color;

		}

		if ( $bg_type == 'texture' ) {

			$textures = themeblvd_get_textures();

			if ( ! empty( $display['bg_texture'] ) && ! empty( $textures[$display['bg_texture']] ) ) {

				$texture = $textures[$display['bg_texture']];

				$params['background-image'] = sprintf('url(%s)', $texture['url']);
				$params['background-position'] = $texture['position'];
				$params['background-repeat'] = $texture['repeat'];
				$params['background-size'] = $texture['size'];

			}

		} else if ( $bg_type == 'image' ) {

			if ( ! empty( $display['bg_image']['image'] ) ) {
				$params['background-image'] = sprintf('url(%s)', $display['bg_image']['image']);
			}

			if ( ! empty( $display['bg_image']['repeat'] ) ) {
				$params['background-repeat'] = $display['bg_image']['repeat'];
			}

			$parallax = false;

			if ( ! empty( $display['bg_image']['attachment'] ) && $display['bg_image']['attachment'] == 'parallax' ) {
				$parallax = true;
			}

			if ( ! $parallax && ! empty( $display['bg_image']['attachment'] ) ) {
				$params['background-attachment'] = $display['bg_image']['attachment'];
			}

			if ( ! $parallax && ! empty( $display['bg_image']['position'] ) ) {
				$params['background-position'] = $display['bg_image']['position'];
			}

			if ( ! $parallax && ! empty( $display['bg_image']['size'] ) ) {
				$params['background-size'] = $display['bg_image']['size'];
			}

		}

	}

	if ( ! empty( $display['apply_padding'] ) ) {

		if ( ! empty( $display['padding_top'] ) ) {
			$params['padding-top'] = $display['padding_top'];
		}

		if ( ! empty( $display['padding_right'] ) ) {
			$params['padding-right'] = $display['padding_right'];
		}

		if ( ! empty( $display['padding_bottom'] ) ) {
			$params['padding-bottom'] = $display['padding_bottom'];
		}

		if ( ! empty( $display['padding_left'] ) ) {
			$params['padding-left'] = $display['padding_left'];
		}

	}

	$params = apply_filters( 'themeblvd_display_inline_style', $params, $display );

	foreach ( $params as $key => $value ) {
		$style .= sprintf( '%s: %s;', $key, $value );
	}

	return $style;
}

/**
 * Dislay set of columns.
 *
 * @since 2.5.0
 *
 * @param array $args
 * @param array Optionally force-feed column data
 */
function themeblvd_columns( $args, $columns = null ) {

	$defaults = array(
		'section'		=> '',
		'layout_id'		=> 0,
		'element_id'	=> 'element_',
		'num'			=> 1,
		'widths'		=> 'grid_12',
		'height'		=> 0,
		'align'			=> 'top'
	);
	$args = wp_parse_args( $args, $defaults );

	// Number of columns
	$num = intval( $args['num'] );

	// Bootstrap stack point
	$stack = apply_filters('themeblvd_columns_stack', 'sm');

	// Kill it if number of columns doesn't match the
	// number of widths exploded from the string.
	$widths = explode( '-', $args['widths'] );
	if ( $num != count( $widths ) ) {
		return;
	}

	// Column Margins
	//
	// Problem: By default with Bootstrap, a row of columns
	// has -15px margin on the sides. However, when a background is
	// applied to a column, we need to eliminate that so the background
	// of the column doesn't over hang outside of the container.
	// Note: Using Bootstrap's "container-fluid" class will not work
	// in this case, because we're doing this per individual side.
	//
	// Solution: If it's the first column and has a BG, change row
	// left margin to 0, and if the last column has a BG, change row
	// right margin to 0.
	$margin_left = '-15px';
	$margin_right = '-15px';

	for ( $i = 1; $i <= $num; $i++ ) {

		// If first or last
		if ( $i == 1 || $i == $num ) {

			$column = get_post_meta( $args['layout_id'], '_tb_builder_'.$args['element_id'].'_col_'.strval($i), true ); // Ex: _tb_builder_element_123_col_1

			if ( ! empty( $column['display']['bg_type'] ) ) {
				if ( in_array( $column['display']['bg_type'], array( 'color', 'image', 'texture' ) ) ) {

					if ( $i == 1 ) {
						$margin_left = '0';
					} else if ( $i == $num ) {
						$margin_right = '0';
					}

				}
			}
		}
	}

	$margin = sprintf( 'margin: 0 %s 0 %s;', $margin_right, $margin_left );

	// Open column row
	if ( $args['height'] && $args['layout_id'] != 0 && ! $columns ) {
		$open_row = array(
			'wrap'	=> "container-{$stack}-height",
			'class'	=> "row row-{$stack}-height",
			'style'	=> $margin
		);
	} else {
		$open_row = array(
			'class'	=> 'row',
			'style'	=> $margin
		);
	}

	themeblvd_open_row($open_row);

	// Display columns
	for ( $i = 1; $i <= $num; $i++ ) {

		$grid_class = themeblvd_grid_class( $widths[$i-1], $stack );

		// Equal height columns?
		if ( $args['height'] ) {

			$grid_class .= " col-{$stack}-height";

			if ( in_array( $args['align'], array( 'top', 'middle', 'bottom' ) ) ) {
				$grid_class .= ' col-'.$args['align'];
			}
		}

		if ( $args['layout_id'] == 0 && $columns ) {

			echo '<div class="col '.$grid_class.'">';

			if ( isset( $columns[$i] ) ) {

				switch ( $columns[$i]['type'] ) {

	                case 'widget' :
						themeblvd_widgets( $columns[$i]['sidebar'], 'tabs' );
	                    break;

	                case 'page' :
	                    themeblvd_post_content( $columns[$i]['page'], 'page' );
	                    break;

	                case 'raw' :
	                    if ( ! empty( $columns[$i]['raw_format'] ) ) {
	                        themeblvd_content( $columns[$i]['raw'] );
	                    } else {
	                        echo do_shortcode( $columns[$i]['raw'] );
	                    }
	                    break;

	            }

			}

			echo '</div><!-- .'.$grid_class.' (end) -->';

		} else {

			$blocks = array();
			$display = array();
			$column = get_post_meta( $args['layout_id'], '_tb_builder_'.$args['element_id'].'_col_'.strval($i), true ); // Ex: _tb_builder_element_123_col_1

			// Display options
			if ( ! empty( $column['display'] ) ) {
				$display = $column['display'];
			}

			// Start column
			$display_class = implode( ' ', themeblvd_get_display_class( $display ) );
			printf('<div class="col %s %s" style="%s" data-parallax="%s">', $grid_class, $display_class, themeblvd_get_display_inline_style($display), themeblvd_get_parallax_intensity($display) );

			// Content blocks
			if ( ! empty( $column['elements'] ) ) {
				$blocks = $column['elements'];
			}

			themeblvd_elements( $args['section'], $blocks, 'block' );

			echo '</div><!-- .'.$grid_class.' (end) -->';

		}

	}

	if ( $args['height'] ) {
		themeblvd_close_row( array('wrap' => true) );
	} else {
		themeblvd_close_row();
	}
}