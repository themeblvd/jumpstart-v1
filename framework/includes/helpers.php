<?php
/**
 * Remove trailing space from string.
 *
 * @since 2.0.0
 *
 * @param string $string Current string to check
 * @param string $char Character to remove from end of string if exists
 * @return string $string String w/out trailing space, if it had one
 */
function themeblvd_remove_trailing_char( $string, $char = ' ' ) {

	if ( ! $string ) {
		return null;
	}

	$offset = strlen( $string ) - 1;

	$trailing_char = strpos( $string, $char, $offset );
	if ( $trailing_char ) {
		$string = substr( $string, 0, -1 );
	}

	return $string;
}

/**
 * Get the name for a font face to be used within the CSS.
 *
 * @since 2.0.0
 *
 * @param array $option Current option set by user for the font
 * @return string $stack CSS value for font-name property
 */
function themeblvd_get_font_face( $option ) {

	$stack = '';
	$stacks = themeblvd_font_stacks();

	if ( $option['face'] == 'google'  ) {

		// Grab font face, making sure they didn't do the
		// super, sneaky trick of including font weight or type.
		$name = explode( ':', $option['google'] );

		// And also check for accidental space at end
		$name = themeblvd_remove_trailing_char( $name[0] );

		// Add the deafult font stack to the end of the
		// google font.
		$stack = $name.', '.$stacks['default'];

	} else {
		$stack = $stacks[$option['face']];
	}

	return apply_filters( 'themeblvd_font_face', $stack, $option, $stacks );
}

/**
 * Get font size
 *
 * @since 2.3.0
 *
 * @param array $option Current option set by user for the font
 * @return string $size CSS value for font-size property
 */
function themeblvd_get_font_size( $option ) {

	$size = '13px';

	if ( isset( $option['size'] ) ) {
		$size = $option['size'];
	}

	return apply_filters( 'themeblvd_font_size', $size, $option );
}

/**
 * Get font style
 *
 * @since 2.3.0
 *
 * @param array $option Current option set by user for the font
 * @return string $style CSS value for font-style property
 */
function themeblvd_get_font_style( $option ) {

	$style = 'normal';

	if ( isset( $option['style'] ) && ( $option['style'] == 'italic' || $option['style'] == 'bold-italic' ) ) {
		$style = 'italic';
	}

	return apply_filters( 'themeblvd_font_style', $style, $option );
}

/**
 * Get font weight
 *
 * @since 2.3.0
 *
 * @param array $option Current option set by user for the font
 * @return string $weight CSS value for font-weight property
 */
function themeblvd_get_font_weight( $option ) {

	$weight = 'normal';

	if ( isset( $option['style'] ) && ( $option['style'] == 'bold' || $option['style'] == 'bold-italic' ) ) {
		$weight = 'bold';
	}

	return apply_filters( 'themeblvd_font_weight', $weight, $option );
}

if ( !function_exists( 'themeblvd_primary_menu_fallback' ) ) :
/**
 * List pages as a main navigation menu when user
 * has not set one under Apperance > Menus in the
 * WordPress admin panel.
 *
 * @since 2.0.0
 */
function themeblvd_primary_menu_fallback() {
	$home_text = themeblvd_get_local('home');
	echo '<ul id="primary-menu" class="sf-menu">';
	echo '<li class="home"><a href="'.home_url().'" title="'.$home_text.'">'.$home_text.'</a></li>';
	wp_list_pages('title_li=');
	echo '</ul>';
}
endif;

/**
 * Setup arguments to pass into get_posts()
 *
 * @since 2.0.0
 *
 * @param array $options All options for query string
 * @param string $type Type of posts setup, grid or list
 * @param boolean $slider Whether or no this is a post list/grid slider (NOT auto slider)
 * @return array $args Arguments to get passed into get_posts()
 */
function themeblvd_get_posts_args( $options, $type, $slider = false ) {

	// Is there a query source? (i.e. category, tag, query)
	$source = '';
	if ( ! empty( $options['source'] ) ) {
		$source = $options['source'];
	}

	// Custom query
	if ( ( 'query' == $source && isset( $options['query'] ) ) || ( ! $source && ! empty( $options['query'] ) ) ) {

		// Convert string to query array
		$query = wp_parse_args( htmlspecialchars_decode( $options['query'] ) );

		// Force posts per page on grids
		if( 'grid' == $type && ! $slider && apply_filters( 'themeblvd_force_grid_posts_per_page', true ) ) {
			if ( ! empty( $options['rows'] ) && ! empty( $options['columns'] ) ) {
				$query['numberposts'] = $options['rows']*$options['columns'];
			}
		}

	}

	// If no custom query, let's build it.
	if ( ! isset( $query ) ) {

		// Start $query
		$query = array( 'suppress_filters' => false );

		// Number of posts
		if ( $type == 'grid' && ! $slider ) {

			if ( ! empty( $options['rows'] ) && ! empty( $options['columns'] ) ) {
				$query['numberposts'] = intval($options['rows'])*intval($options['columns']);
			}

		} else {

			if ( ! empty( $options['numberposts'] ) ) {
				$query['numberposts'] = intval( $options['numberposts'] );
			}

		}

		if ( empty( $query['numberposts'] ) ) {
			$query['numberposts'] = -1;
		}

		// Categories
		if ( 'category' == $source || ! $source ) {

			if ( 'auto_slider' == $type ) {

				// The "Post Slider" element
				if ( ! empty( $options['category'] ) ) {
					$query['category_name'] = $options['category'];
				}

			} else {

				if ( ! empty( $options['cat'] ) ) {

					// Category override option #1 -- cat
					$query['cat'] = $options['cat'];

				} else if ( ! empty( $options['category_name'] ) ) {

					// Category override option #2 -- category_name
					$query['category_name'] = $options['category_name'];

				} else if ( ! empty( $options['categories'] ) && ( is_string( $options['categories'] ) || empty( $options['categories']['all'] ) ) ) {

					$categories = '';

					if ( is_string( $options['categories'] ) ) {

						$categories = $options['categories'];

					} else {

						if ( isset( $options['categories']['all'] ) ) {
							unset( $options['categories']['all'] );
						}

						foreach ( $options['categories'] as $category => $include ) {
							if ( $include ) {
								$current_category = get_term_by( 'slug', $category, 'category' );
								$categories .= $current_category->term_id.',';
							}
						}

					}

					if ( $categories ) {
						$categories = themeblvd_remove_trailing_char( $categories, ',' );
						$query['cat'] = $categories;
					}

				}

			}

		}

		// Tags
		if ( 'tag' == $source || ! $source ) {
			if ( ! empty( $options['tag'] ) ) {
				$query['tag'] = $options['tag'];
			}
		}

		// Additional args
		if ( ! empty( $options['orderby'] ) ) {
			$query['orderby'] = $options['orderby'];
		}

		if ( ! empty( $options['order'] ) ) {
			$query['order'] = $options['order'];
		}

		if ( ! empty( $options['offset'] ) ) {
			$query['offset'] = intval( $options['offset'] );
		}

	}

	return apply_filters( 'themeblvd_get_posts_args', $query, $options, $type, $slider );
}

/**
 * Get posts per page for grid of posts.
 *
 * @since 2.0.0
 * @deprecated 2.3.0
 *
 * @param string $type Type of grid, template or builder
 * @param string $columns Number of columns to use
 * @param string $columns Number of rows to use
 * @return int $posts_per_page The number of posts per page for a grid.
 */
function themeblvd_posts_page_page( $type, $columns = null, $rows = null ) {

	if ( $type == 'template' ) {
		if ( ! $columns || ! $rows ) {

			global $post;

			$possible_column_nums = array( 1, 2, 3, 4, 5 );
			$posts_per_page = null;

			// Columns
			$columns = get_post_meta( $post->ID, 'columns', true );
			if ( ! in_array( intval($columns), $possible_column_nums ) ) {
				$columns = apply_filters( 'themeblvd_default_grid_columns', 3 );
			}

			// Rows
			$rows = get_post_meta( $post->ID, 'rows', true );
			if ( ! $rows ) {
				$rows = apply_filters( 'themeblvd_default_grid_columns', 4 );
			}

		}
	}

	// Posts per page
	$posts_per_page = $columns * $rows;

	return apply_filters('themeblvd_posts_page_page', $posts_per_page, $type, $columns, $rows );
}

/**
 * Get the class to be used for a grid column.
 *
 * @since 2.0.0
 *
 * @param int $columns Number of columns
 * @return string $class class for each column of grid
 */
function themeblvd_grid_class( $columns ) {

	$class = 'grid_3'; // default

	if ( $columns == 1 ) {
		$class = 'grid_12';
	} else if ( $columns == 2 ) {
		$class = 'grid_6';
	} else if ( $columns == 3 ) {
		$class = 'grid_4';
	} else if ( $columns == 4 ) {
		$class = 'grid_3';
	} else if ( $columns == 5 ) {
		$class = 'grid_fifth_1';
	}

	return apply_filters( 'themeblvd_grid_class', $class, $columns );
}

/**
 * Open a row in a post grid
 *
 * @since 2.0.0
 */
function themeblvd_open_row() {
	echo apply_filters( 'themeblvd_open_row', '<div class="grid-row">' );
}

/**
 * Close a row in a post grid
 *
 * @since 2.0.0
 */
function themeblvd_close_row() {
	echo apply_filters( 'themeblvd_close_row', '<div class="clear"></div></div><!-- .grid-row (end) -->' );
}

/**
 * Determine color of text depending on background color.
 *
 * Huge thank you to Oscar for providing this:
 * http://stackoverflow.com/questions/3015116/hex-code-brightness-php
 *
 * @since 2.0.0
 *
 * @param string $bg_color Background color to determine text color for, ex: #ffffff
 * @return string $text_color Text color to show on inputed background color
 */
function themeblvd_text_color( $bg_color ) {

	// Pop off '#' from start.
	$bg_color = explode( '#', $bg_color );
	$bg_color = $bg_color[1];

	// Break up the color in its RGB components
	$r = hexdec( substr( $bg_color,0,2 ) );
	$g = hexdec( substr( $bg_color,2,2 ) );
	$b = hexdec( substr( $bg_color,4,2 ) );

	// Simple weighted average
	if ( $r + $g + $b > 382 ) {
		// bright color, use dark font
	    $text_color = apply_filters( 'themeblvd_dark_font', '#333333' );
	} else {
		// dark color, use bright font
	    $text_color = apply_filters( 'themeblvd_light_font', '#ffffff' );
	}

	return apply_filters( 'themeblvd_text_color', $text_color, $bg_color );
}

/**
 * Darken or Lighten a hex color
 *
 * Huge thank you to Jonas John for providing this:
 * http://www.jonasjohn.de/snippets/php/darker-color.htm
 *
 * @since 2.0.5
 *
 * @param string $color Hex color to adjust
 * @param string $difference Amount to adjust color
 * @param string $direction 'lighten' or 'darken'
 * @return string $new_color Adjusted color
 */
function themeblvd_adjust_color( $color, $difference = 20, $direction = 'darken' ) {

	// Pop off '#' from start.
	$color = explode( '#', $color );
	$color = $color[1];

	// Send back in black if it's not a properly
	// formatted 6-digit hex
	if ( strlen( $color ) != 6 ) {
		return '#000000';
	}

	// Build new color
	$new_color = '';
	for ( $x = 0; $x < 3; $x++ ) {
	    if( $direction == 'lighten' )
	    	$c = hexdec( substr( $color, ( 2*$x ), 2 ) ) + $difference;
	    else
			$c = hexdec( substr( $color, ( 2*$x ), 2 ) ) - $difference;
	    $c = ( $c < 0 ) ? 0 : dechex( $c );
	    $new_color .= ( strlen( $c ) < 2 ) ? '0'.$c : $c;
	}

	return apply_filters( 'themeblvd_adjust_color', '#'.$new_color, $color, $difference, $direction );
}

/**
 * Get additional classes for elements.
 *
 * @since 2.0.3
 *
 * @param string $element Element to get classes for
 * @param boolean $start_space Whether there should be a space at start
 * @param boolean $end_space Whether there should be a space at end
 * @param string $type Type of element (only relevant if there is a filter added utilizing it)
 * @param array $options Options for element (only relevant if there is a filter added utilizing it)
 * @param string $location Location of element - featured, primary, or featured_below (only relevant if there is a filter added utilizing it)
 * @return array $classes Classes for element.
 */
function themeblvd_get_classes( $element, $start_space = false, $end_space = false, $type = null, $options = array(), $location = 'primary' ) {

	$classes = '';

	$all_classes = array(
		'element_columns' 				=> array(),
		'element_content' 				=> array(),
		'element_divider' 				=> array(),
		'element_headline' 				=> array(),
		'element_jumbotron' 			=> array('element-unstyled'),
		'element_post_grid_paginated' 	=> array('themeblvd-gallery'),
		'element_post_grid' 			=> array('themeblvd-gallery'),
		'element_post_grid_slider' 		=> array('themeblvd-gallery'),
		'element_post_list_paginated' 	=> array(),
		'element_post_list' 			=> array(),
		'element_post_list_slider' 		=> array(),
		'element_post_slider' 			=> array(),
		'element_slider' 				=> array(),
		'element_slogan' 				=> array(),
		'element_tabs' 					=> array(),
		'element_tweet' 				=> array(),
		'slider_bootstrap'				=> array(),
		'slider_carrousel'				=> array(),
		'slider_nivo'					=> array(),
		'slider_standard'				=> array()
	);
	$all_classes = apply_filters( 'themeblvd_element_classes', $all_classes, $type, $options, $location );

	if ( ! empty( $all_classes[$element] ) ) {

		if ( $start_space ) {
			$classes .= ' ';
		}

		if ( is_array( $all_classes[$element] ) ) {
			$classes .= implode(' ', $all_classes[$element]);
		} else {
			// Backward compatbility, $all_classes used to use strings
			$classes .= $all_classes[$element];
		}

		if ( $end_space ) {
			$classes .= ' ';
		}

	}
	return $classes;
}

/**
 * Get the class to be used for resposive visibility.
 *
 * hide_on_standard
 * hide_on_standard_and_tablet
 * hide_on_standard_and_tablet_and_mobile
 * hide_on_standard_and_mobile
 * hide_on_tablet
 * hide_on_tablet_and_mobile
 * hide_on_mobile
 *
 * @since 2.1.0
 *
 * @param array $devices Devices to be hidden on
 * @param boolean $start_space Whether there should be a space at start
 * @param boolean $end_space Whether there should be a space at end
 * @return var $class CSS class to use
 */
function themeblvd_responsive_visibility_class( $devices, $start_space = false, $end_space = false ) {

	// Build class
	$class = '';
	$exists = false;

	if ( is_array( $devices ) && ! empty( $devices ) ) {
		foreach ( $devices as $device ) {
			if ( $device ) {
				$exists = true;
			}
		}
	}

	// Only start buld if there's a class to build
	if ( $exists ) {

		$class = 'hide_on_';

		if ( $devices['hide_on_standard'] ) {

			// Standard Devices
			$class .= 'standard';
			if ( $devices['hide_on_tablet'] ) {
				$class .= '_and_tablet';
			}

			if ( $devices['hide_on_mobile'] ) {
				$class .= '_and_mobile';
			}

		} else if ( $devices['hide_on_tablet'] ) {

			// Tablets
			$class .= 'tablet';
			if ( $devices['hide_on_mobile'] ) {
				$class .= '_and_mobile';
			}

		} else if ( $devices['hide_on_mobile'] ) {

			// Mobile
			$class .= 'mobile';

		}
	}

	// Apply filter
	$class = apply_filters( 'themeblvd_responsive_visibility_class', $class, $devices );

	// Start/End spaces
	if ( $class ) {

		if ( $start_space ) {
			$class = ' '.$class;
		}

		if ( $end_space ) {
			$class .= ' ';
		}

	}

	// Return class
	return $class;
}

/**
 * Display <title>
 * This is added to wp_title filter.
 *
 * @since 2.2.0
 */
function themeblvd_wp_title( $title ) {

	global $page, $paged;

	// Don't screw with RSS feed titles
	if ( is_feed() ) {
		return $title;
	}

	// Add the blog name.
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " | $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= ' | ' . sprintf( themeblvd_get_local( 'page_num' ), max( $paged, $page ) );
	}

	return apply_filters( 'themeblvd_wp_title', $title );
}

if ( !function_exists( 'themeblvd_standard_slider_js' ) ) :
/**
 * Print out the JS for setting up a standard slider.
 *
 * @since 2.0.0
 */
function themeblvd_standard_slider_js( $id, $options ) {
	?>
	<script>
	+function($) {
		$(window).on('load', function() {

			// Initiate flexslider for this slider.
			$('#tb-slider-<?php echo $id; ?> .flexslider').flexslider({
				useCSS: false, // Avoid CSS3 glitches
				video: true, // Avoid CSS3 glitches
				<?php if ( ! empty( $options['smoothheight'] ) && $options['smoothheight'] == 'true' ) : ?>
				smoothHeight: true,
				<?php endif; ?>
				prevText: '<i class="icon-circle-arrow-left"></i>',
				nextText: '<i class="icon-circle-arrow-right"></i>',
				animation: "<?php echo $options['fx']; ?>",
				// pauseOnHover: true - This was replaced with a custom solution to work with other controls, see below with "pause_on_hover" option.
				<?php if ( $options['timeout'] ) : ?>
				slideshowSpeed: <?php echo $options['timeout']; ?>000,
				<?php else : ?>
				slideshow: false,
				<?php endif; ?>
				<?php if ( ! $options['nav_arrows'] ) echo 'directionNav: false,'; ?>
				<?php if ( ! $options['nav_standard'] ) echo 'controlNav: false,'; ?>
				controlsContainer: ".slides-wrapper-<?php echo $id; ?>",
				<?php do_action( 'themeblvd_flexslider_properties', $id, $options ); ?>
				start: function(slider) {
    				<?php if ( $options['pause_play'] && $options['timeout'] != '0' ) : ?>
	    				$('#tb-slider-<?php echo $id; ?> .flex-direction-nav li:first-child').after('<li><a class="flex-pause" href="#"><i class="icon-pause"></i></a></li><li><a class="flex-play" href="#" style="display:none"><i class="icon-play"></i></a></li>');
	    				$('#tb-slider-<?php echo $id; ?> .flex-pause').click(function(){
							slider.pause();
							$(this).hide();
							$('#tb-slider-<?php echo $id; ?> .flex-play').show();
							return false;
						});
						$('#tb-slider-<?php echo $id; ?> .flex-play').click(function(){
							// slider.resume(); currently has a bug with FlexSlider 2.0, so will do the next line instead.
							$('#tb-slider-<?php echo $id; ?> .flexslider').flexslider('play');
							$(this).hide();
							$('#tb-slider-<?php echo $id; ?> .flex-pause').show();
							return false;
						});
						$('#tb-slider-<?php echo $id; ?> .flex-control-nav li, #tb-slider-<?php echo $id; ?> .flex-direction-nav li').click(function(){
							$('#tb-slider-<?php echo $id; ?> .flex-pause').hide();
							$('#tb-slider-<?php echo $id; ?> .flex-play').show();
						});
					<?php endif; ?>
    				$('#tb-slider-<?php echo $id; ?> .slide-thumbnail-link').click(function() {
    					$('#tb-slider-<?php echo $id; ?> .flex-pause').hide();
    					$('#tb-slider-<?php echo $id; ?> .flex-play').show();
    					slider.pause();
    				});
    			}
			}).parent().find('.tb-loader').fadeOut();

			<?php if ( isset( $options['pause_on_hover'] ) ) : ?>
				<?php if ( $options['pause_on_hover'] == 'pause_on' || $options['pause_on_hover'] == 'pause_on_off' ) : ?>
				// Custom pause on hover funtionality
				$('#tb-slider-<?php echo $id; ?>').hover(
					function() {
						$('#tb-slider-<?php echo $id; ?> .flex-pause').hide();
						$('#tb-slider-<?php echo $id; ?> .flex-play').show();
						$('#tb-slider-<?php echo $id; ?> .flexslider').flexslider('pause');
					},
					function() {
						<?php if ( $options['pause_on_hover'] == 'pause_on_off' ) : ?>
						$('#tb-slider-<?php echo $id; ?> .flex-play').hide();
						$('#tb-slider-<?php echo $id; ?> .flex-pause').show();
						$('#tb-slider-<?php echo $id; ?> .flexslider').flexslider('play');
						<?php endif; ?>
					}
				);
				<?php endif; ?>
			<?php endif; ?>


		});

	}(jQuery);
	</script>
	<?php
}
endif;

/**
 * Get Comment List arguments for comments.php
 *
 * @since 2.2.0
 *
 * @return array $args Arguments to be passed into wp_list_comments()
 */
function themeblvd_get_comment_list_args() {
	$args = array(
		'avatar_size' 		=> 48,
		'style' 			=> 'ul',
		'type' 				=> 'all',
		'reply_text' 		=> themeblvd_get_local( 'reply' ),
		'login_text' 		=> themeblvd_get_local( 'login_text' ),
		'callback' 			=> null,
		'reverse_top_level' => null,
		'reverse_children' 	=> false
	);
	return apply_filters( 'themeblvd_comment_list', $args );
}

/**
 * Get Comment Form arguments for comments.php
 *
 * @since 2.2.0
 *
 * @return array $args Arguments to be passed into comment_form()
 */
function themeblvd_get_comment_form_args() {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$args = array(
		'fields' => array(
			'author' => '<p class="comment-form-author"><input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
						'<label for="author">' . themeblvd_get_local( 'name' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label></p>',
			'email'  => '<p class="comment-form-email"><input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />' .
						'<label for="email">' . themeblvd_get_local( 'email' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label></p>',
			'url'    => '<p class="comment-form-url"><input id="url" class="form-control" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />' .
						'<label for="url">' .themeblvd_get_local( 'website' ) . '</label></p>'
		),
		'comment_field'			=> '<p class="comment-form-comment"><textarea id="comment" class="form-control" name="comment" cols="45" rows="10" aria-required="true"></textarea></p>',
		'title_reply'			=> themeblvd_get_local( 'title_reply' ),
		'title_reply_to'		=> themeblvd_get_local( 'title_reply_to' ),
		'cancel_reply_link'		=> themeblvd_get_local( 'cancel_reply_link' ),
		'label_submit'			=> themeblvd_get_local( 'label_submit' )
	);
	return apply_filters( 'themeblvd_comment_form', $args, $commenter, $req, $aria_req );
}

/**
 * Determine whether comments section should show on
 * a single post.
 *
 * At first glance, you're probably wondering why this
 * would exist when you the WP user could just close
 * the comments. When the user closes the comments,
 * comments will still be present and in place of the
 * comment form, it will say that the comments are closed.
 *
 * However, in addition to that, this framework allows
 * the user to completely hide the comments section all
 * together in various ways. So, this extends further
 * up than simply haivng the comments for a post closed.
 *
 * @since 2.2.0
 *
 * @return boolean $show Arguments to be passed into wp_list_comments()
 */
function themeblvd_show_comments() {

	global $post;
	$show = true; // default

	if ( is_single() ) {

		if ( themeblvd_get_option( 'single_comments', null, 'show' ) == 'hide' ) {
			$show = false;
		}

		if ( get_post_meta( $post->ID, '_tb_comments', true ) == 'hide' ) {
			$show = false;
		} else if ( get_post_meta( $post->ID, '_tb_comments', true ) == 'show' ) {
			$show = true;
		}

	}
	return apply_filters( 'themeblvd_show_comments', $show );
}

/**
 * Forward password-protected pages using
 * page templates to page.php
 *
 * @since 2.2.1
 *
 * @param string $template Current template file
 * @return string $template Current theme location of page.php
 */
function themeblvd_private_page( $template ) {

	// Only for password protected pages.
	if ( ! post_password_required() ) {
		return $template;
	}

	// Custom Layouts
	if ( themeblvd_config( 'builder' ) ) {
		$template = locate_template( 'page.php' );
	}

	// Page Templates
	$page_templates = apply_filters( 'themeblvd_private_page_support', array( 'template_grid.php', 'template_list.php', 'template_archives.php', 'template_sitemap.php' ) );
	foreach ( $page_templates as $page_template ) {
		if ( is_page_template( $page_template ) ) {
			$template = locate_template( 'page.php' );
		}
	}

	// Removed hooked the_content on Post Grid/List templates
	if ( is_page_template( 'template_list.php' ) || is_page_template( 'template_grid.php' ) ) {
		remove_action( 'themeblvd_content_top', 'themeblvd_content_top_default' );
	}

	return $template;
}

/**
 * When using wp_link_pages(), match surrounding markup
 * to themeblvd_pagination() and integration of Bootstrap.
 *
 * This function is attached to the filter wp_link_pages_args,
 * but won't do anything unless WP version is 3.6+.
 *
 * @since 2.2.1
 *
 * @param array $args Default arguments of wp_link_pages() to filter
 * @return array $args Args for wp_link_pages() after we've altered them
 */
function themeblvd_link_pages_args( $args ) {

	global $wp_version;

	// Before WP 3.6, this filter can't be applied because the
	// wp_link_pages_link filter did not exist yet. Our changes
	// need to come together.
	if ( version_compare( $wp_version, '3.6-alpha', '<' ) ) {
		return $args;
	}

	// Add TB Framework/Bootstrap surrounding markup
	$args['before'] = '<div class="pagination-wrap"><div class="pagination"><div class="btn-group clearfix">';
	$args['after'] = "</div></div></div>\n";

	return $args;
}

/**
 * When using wp_link_pages(), match individual button markup
 * to themeblvd_pagination() and integration of Bootstrap.
 *
 * This function is attached to the wp_link_pages_link filter,
 * which only exists in WP 3.6+.
 *
 * @since 2.2.1
 *
 * @param string $link Markup of individual link to be filtered
 * @param int $i Page number of link being filtered
 * @return string $link Markup for individual link after being filtered
 */
function themeblvd_link_pages_link( $link, $i ) {

	global $page;

	$color = apply_filters( 'themeblvd_link_pages_button_color', 'default' );
	$size = apply_filters( 'themeblvd_link_pages_button_size', 'default' );
	$class = themeblvd_get_button_class( $color, $size );

	// If is current page
	if ( $page == $i ) {
		$class .= ' active';
		$link = sprintf( '<a href="%s" class="%s">%s</a>', get_pagenum_link($i), $class, $i );
	} else {
		$link = str_replace( '<a', '<a class="'.$class.'"', $link ); // Getting actual URL to rebuild link is a bitch
	}

	return $link;
}

/**
 * Add CSS classes to reply link to they are styled as
 * a Bootstrap button.
 *
 * @since 2.4.0
 *
 * @param string $formatted_link Current HTML to modify for button
 * @return string|bool|null Link to show comment form, if successful. False, if comments are closed.
 */
function themeblvd_comment_reply_link( $formatted_link ) {
	$color = apply_filters( 'themeblvd_comment_reply_button_color', 'default' );
	$size = apply_filters( 'themeblvd_comment_reply_button_size', 'small' );
	$class = themeblvd_get_button_class( $color, $size );
	return str_replace( 'comment-reply-link', sprintf( 'comment-reply-link %s', $class ), $formatted_link );
}

/**
 * Construct parts of a breadcrumbs trail as an array
 * to be used when displaying breadcrumbs.
 *
 * @since 2.2.1
 *
 * @param string $atts Filtered attributes for breadcrumbs
 * @return array $breadcrumbs Breadcrumbs parts to display trail
 */
function themeblvd_get_breadcrumb_parts( $atts ) {

	global $post;
	global $wp_query;
	$breadcrumbs = array();
	$parts = array();
	wp_reset_query();

	// Home
	$breadcrumbs[] = array(
		'link' 	=> $atts['home_link'],
		'text' 	=> $atts['home'],
		'type'	=> 'home'
	);

	// Build parts
	if ( is_category() ) {

		/* Category Archives */

		$cat_obj = $wp_query->get_queried_object();
		$current_cat = $cat_obj->term_id;
		$current_cat = get_category( $current_cat );

		if ( $current_cat->parent && ( $current_cat->parent != $current_cat->term_id ) ) {
			$parents = themeblvd_get_category_parents( $current_cat->parent );
			if ( is_array( $parents ) ) {
				$parts = array_merge( $parts, $parents );
			}
		}

		// Add current category
		$parts[] = array(
			'link' 	=> '',
			'text' 	=> $current_cat->name,
			'type'	=> 'category'
		);

	} elseif ( is_day() ) {

		/* Day Archives */

		// Year
		$parts[] = array(
			'link' 	=> get_year_link( get_the_time('Y') ),
			'text' 	=> get_the_time('Y'),
			'type'	=> 'year'
		);

		// Month
		$parts[] = array(
			'link' 	=> get_month_link( get_the_time('Y'), get_the_time('m') ),
			'text' 	=> get_the_time('F'),
			'type'	=> 'month'
		);

		// Day
		$parts[] = array(
			'link' 	=> '',
			'text' 	=> get_the_time('d'),
			'type'	=> 'day'
		);

	} elseif ( is_month() ) {

		/* Month Archives */

		// Year
		$parts[] = array(
			'link' 	=> get_year_link( get_the_time('Y') ),
			'text' 	=> get_the_time('Y'),
			'type'	=> 'year'
		);

		// Month
		$parts[] = array(
			'link' 	=> '',
			'text' 	=> get_the_time('F'),
			'type'	=> 'month'
		);

	} elseif ( is_year() ) {

		/* Year Archives */

		// Year
		$parts[] = array(
			'link' 	=> '',
			'text' 	=> get_the_time('Y'),
			'type'	=> 'year'
		);

	} elseif ( is_tag() ) {

		/* Tag Archives */

		$parts[] = array(
			'link' 	=> '',
			'text' 	=> themeblvd_get_local('crumb_tag').' "'.single_tag_title('', false).'"',
			'type'	=> 'tag'
		);

	} elseif ( is_author() ) {

		/* Author Archives */

		global $author;
		$userdata = get_userdata( $author );

		$parts[] = array(
			'link' 	=> '',
			'text' 	=> themeblvd_get_local('crumb_author').' '.$userdata->display_name,
			'type'	=> 'author'
		);

	} elseif ( is_attachment() ) {

		/* Attachment */

		$parent = get_post( $post->post_parent );
		if ( ! empty( $parent ) ) {

			$category = get_the_category( $parent->ID );

			if ( ! empty( $category ) ) {
				$category = $category[0];
				$parents = themeblvd_get_category_parents( $category->term_id );
				if ( is_array( $parents ) ) {
					$parts = array_merge( $parts, $parents );
				}
			}

			$parts[] = array(
				'link' 	=> get_permalink( $parent->ID ),
				'text' 	=> $parent->post_title,
				'type'	=> 'single'
			);

		}

		$parts[] = array(
			'link' 	=> '',
			'text' 	=> get_the_title(),
			'type'	=> 'attachment'
		);

	} elseif ( is_single() ) {

		/* Single Posts */

		if ( get_post_type() == 'post' ) {
			// Categories (only if standard post type)
			$category = get_the_category();
			$category = $category[0];
			$parents = themeblvd_get_category_parents( $category->term_id );
			if ( is_array( $parents ) ) {
				$parts = array_merge( $parts, $parents );
			}
		}

		$parts[] = array(
			'link' 	=> '',
			'text' 	=> get_the_title(),
			'type'	=> 'single'
		);

	} elseif ( is_search() ) {

		/* Search Results */

		$parts[] = array(
			'link' 	=> '',
			'text' 	=> themeblvd_get_local('crumb_search').' "'.get_search_query().'"',
			'type'	=> 'search'
		);

	} elseif ( is_page() ) {

		/* Pages */

		if ( $post->post_parent ) {

			// Parent pages
			$parent_id  = $post->post_parent;
			$parents = array();

			while ( $parent_id ) {
				$page = get_page( $parent_id );
				$parents[] = array(
					'link' 	=> get_permalink( $page->ID ),
					'text' 	=> get_the_title( $page->ID ),
					'type'	=> 'page'
				);
				$parent_id = $page->post_parent;
			}

			$parents = array_reverse( $parents );
			$parts = array_merge( $parts, $parents );

		}
		$parts[] = array(
			'link' 	=> '',
			'text' 	=> get_the_title(),
			'type'	=> 'page'
		);

	} elseif ( is_404() ) {

		/* 404 */

		$parts[] = array(
			'link' 	=> '',
			'text' 	=> themeblvd_get_local('crumb_404'),
			'type'	=> '404'
		);

	}

	// Filter the trail before the Home link is
	// added to the start, or the page num is
	// added to the end.
	$parts = apply_filters( 'themeblvd_pre_breadcrumb_parts', $parts, $atts );

	// Add page number if is paged
	if ( get_query_var('paged') ) {
		$last = count($parts) - 1;
		$parts[$last]['text'] .= ' ('.themeblvd_get_local('page').' '.get_query_var('paged').')';
	}

	// Final filter on entire breadcrumbs trail.
	$breadcrumbs = apply_filters( 'themeblvd_breadcrumb_parts', array_merge( $breadcrumbs, $parts ), $atts );

	return $breadcrumbs;
}

/**
 * Determine if breadcrumbs should show or not.
 *
 * @since 2.2.1
 *
 * @return boolean $show Whether breadcrumbs should show or not
 */
function themeblvd_show_breadcrumbs() {

	global $post;
	$display = '';

	// Pages and Posts
	if ( is_page() || is_single() ) {
		$display = get_post_meta( $post->ID, '_tb_breadcrumbs', true );
	}

	// Standard site-wide option
	if ( ! $display || $display == 'default' ) {
		$display = themeblvd_get_option( 'breadcrumbs', null, 'show' );
	}

	// Disable on posts homepage
	if ( is_home() ) {
		$display = 'hide';
	}

	// Convert to boolean
	$show = false;
	if ( $display == 'show' ) {
		$show = true;
	}

	return apply_filters( 'themeblvd_show_breadcrumbs', $show, $display );
}

/**
 * Get parent category attributes
 *
 * @since 2.2.1
 *
 * @param int $id ID of closest category parent
 * @param array $used Any categories in our chain that we've already used
 * @return array $var Description
 */
function themeblvd_get_category_parents( $id, $used = array() ) {
	return themeblvd_get_term_parents( $id, 'category', $used );
}

/**
 * Get parent term attributes
 *
 * @since 2.3.0
 *
 * @param int $id ID of closest category parent
 * @param array $used Any categories in our chain that we've already used
 * @return array $var Description
 */
function themeblvd_get_term_parents( $id, $taxonomy = 'category', $used = array() ) {

	$chain = array();
	$parent = get_term( intval( $id ), $taxonomy );

	// Get out of here if there's an error
	if ( is_wp_error( $parent ) ) {
		return $parent;
	}

	// Parent of the parent
	if ( $parent->parent && ( $parent->parent != $parent->term_id ) && ! in_array( $parent->parent, $used ) ) {
		$used[] = $parent->parent;
		$grand_parent = themeblvd_get_term_parents( $parent->parent, $taxonomy, $used );
		$chain = array_merge( $grand_parent, $chain );
	}

	// Final part of chain
	$chain[] = array(
		'link' 	=> esc_url( get_term_link( intval( $id ), $taxonomy ) ),
		'text' 	=> $parent->name,
		'type'	=> $taxonomy
	);

	return $chain;
}

/**
 * Get pagination parts.
 *
 * @since 2.3.0
 *
 * @param int $pages Optional number of pages
 * @param int $range Optional range for paginated buttons, helpful for many pages
 * @return array $parts Parts to construct pagination
 */
function themeblvd_get_pagination_parts( $pages = 0, $range = 2 ) {

	global $paged;
	global $wp_query;

	$parts = array();
	$showitems = ($range * 2)+1;

	if ( empty( $paged ) ) {
		$paged = 1;
	}

	if ( ! $pages ) {
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}

	if ( 1 != $pages ) {

		if ( $paged > 2 && $paged > $range+1 && $showitems < $pages ) {
			$parts[] = array(
				'href'		=> get_pagenum_link(1),
				'text'		=> '&laquo;',
				'active' 	=> false
			);
		}

		if ( $paged > 1 && $showitems < $pages ) {
			$parts[] = array(
				'href'		=> get_pagenum_link($paged-1),
				'text'		=> '&lsaquo;',
				'active' 	=> false
			);
		}

		for( $i = 1; $i <= $pages; $i++ ) {
			if ( ! ( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) {
				$active = ( $paged == $i ) ? true : false;
				$parts[] = array(
					'href'		=> get_pagenum_link($i),
					'text'		=> $i,
					'active' 	=> $active
				);
			}
		}

		if ( $paged < $pages && $showitems < $pages ) {
			$parts[] = array(
				'href'		=> get_pagenum_link($paged + 1),
				'text'		=> '&rsaquo;',
				'active' 	=> false
			);
		}

		if ( $paged < $pages-1 && $paged+$range-1 < $pages && $showitems < $pages ) {
			$parts[] = array(
				'href'		=> get_pagenum_link($pages),
				'text'		=> '&raquo;',
				'active' 	=> false
			);
		}

	}
	return apply_filters( 'themeblvd_pagination_parts', $parts );
}

/**
 * Get the overlay markup for a thumbnail that animates
 * in the video, enlarge, link, or arrow icon.
 *
 * @since 2.3.0
 *
 * @return string $overlay HTML markup to get inserted within anchor tag
 */
function themeblvd_get_image_overlay() {
	$overlay = '<span class="image-overlay"><span class="image-overlay-bg"></span><span class="image-overlay-icon"></span></span>';
    return apply_filters( 'themeblvd_image_overlay', $overlay );
}

/**
 * Get class for buttons.
 *
 * @since 2.4.0
 *
 * @param string $color Color of button
 * @param string $size Size of button
 * @param bool $block Whether the button displays as block (true) or inline (false)
 * @return string $class HTML Class to be outputted into button <a> markup
 */
function themeblvd_get_button_class( $color = '', $size = '', $block = false ) {

	$class = 'btn';

	// Color
	if ( ! $color ) {
		$color = 'default';
	}

	if ( in_array( $color, apply_filters( 'themeblvd_bootstrap_btn_colors', array( 'default', 'primary', 'info', 'success', 'warning', 'danger' ) ) ) ) {
		$class .= sprintf( ' btn-%s', $color );
	} else {
		$class .= sprintf( ' %s', $color );
	}

	// Size
	switch ( $size ) {
		case 'mini' :
			$size = 'xs';
			break;
		case 'small' :
			$size = 'sm';
			break;
		case 'large' :
			$size = 'lg';
			break;
	}

	if ( in_array( $size, apply_filters( 'themeblvd_bootstrap_btn_sizes', array( 'xs', 'sm', 'lg' ) ) ) ) {
		$class .= sprintf( ' btn-%s', $size );
	}

	// Block
	if ( $block ) {
		$class .= ' btn-block';
	}

    return apply_filters( 'themeblvd_get_button_class', $class, $color, $size );
}
