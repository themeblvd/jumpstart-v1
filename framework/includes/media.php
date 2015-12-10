<?php
if ( !function_exists( 'themeblvd_get_post_thumbnail' ) ) : // pluggable for backwards compat
/**
 * The post thumbnail (must be within the loop)
 *
 * @since 2.0.0
 *
 * @param string $location Where the thumbnail is being used -- primary, featured, single -- sort of a wild card to build on in the future as conflicts arise.
 * @param string $size For the image crop size of the thumbnail
 * @param bool $link Set to false to force a thumbnail to ignore post's Image Link options
 * @param bool $allow_filters Whether to allow general filters on the thumbnail or not
 * @return string $output HTML to output thumbnail
 */

function themeblvd_get_post_thumbnail( $location = 'primary', $size = '', $link = true, $allow_filters = true ) {

	global $post;

	$attachment_id = get_post_thumbnail_id( $post->ID );
	$sidebar_layout = themeblvd_config( 'sidebar_layout' );
	$lightbox = false;
	$link_target = '';
	$link_url = '';
	$anchor_class = '';
	$output = '';
	$classes = '';
	$image = '';
	$title = '';

	// If no thumbnail, we can skip everything. However,
	// we still want plugins to be able to filter in here
	// however they want. This same filter is applied below
	// on the final output.
	if ( ! has_post_thumbnail( $post->ID ) && $allow_filters ) {
		return apply_filters( 'themeblvd_post_thumbnail', '', $location, $size, $link );
	}

	// Determine correct thumbnail size string, or if wasn't
	// passed in, get a fallback based on framework options.
	$size = themeblvd_get_thumbnail_size( $size, $location, $sidebar_layout );

	// If $size was set to null, it means the post
	// thumb should be hidden. So, return nothing.
	if ( $size === null ) {
		return $output;
	}

	// Can we just skip the featured image?
	$thumb_link_meta = get_post_meta( $post->ID, '_tb_thumb_link', true ); // used below in determining featured image link
	if ( $thumb_link_meta == 'inactive' ) {
		$link = false;
	}

	// How about skipping featured image link on the single post?
	if ( $link && $location == 'single' && get_post_meta( $post->ID, '_tb_thumb_link_single', true ) == 'no' ) {
		$link = false;
	}

	// Determine link for featured image
	if ( $link ) {
		$possible_link_options = array( 'post', 'thumbnail', 'image', 'video', 'external' );
		if ( in_array( $thumb_link_meta, $possible_link_options ) ) {
			switch ( $thumb_link_meta ) {

				case 'post' :
					$title = get_the_title();
					$link_url = get_permalink( $post->ID );
					$link_target = '_self';
					break;

				case 'thumbnail' :
					$title = get_the_title( $attachment_id );
					$link_url = wp_get_attachment_url( $attachment_id );
					$lightbox = true;
					break;

				case 'image' :
					$title = get_the_title();
					$link_url = get_post_meta( $post->ID, '_tb_image_link', true );
					$lightbox = true;
					break;

				case 'video' :
					$title = get_the_title( $attachment_id );
					$link_url = get_post_meta( $post->ID, '_tb_video_link', true );
					$lightbox = true;
					break;

				case 'external' :
					$link_url = get_post_meta( $post->ID, '_tb_external_link', true );
					$link_target = get_post_meta( $post->ID, '_tb_external_link_target', true );
					if ( ! $link_target ) {
						$link_target = '_blank';
					}
					break;
			}
		} else {
			$link = false;
		}
	}

	// Attributes
	$size_class = $size;

	if ( $size_class == 'tb_small' ) {
		$size_class = 'small';
	}

	$classes = 'attachment-'.$size_class.' wp-post-image';

	if ( $link ) {

		$anchor_class = 'thumbnail';

		if ( $thumb_link_meta != 'thumbnail' ) {
			$anchor_class .= ' '.$thumb_link_meta;
		}
	}

	// Initial image without link
	$image = get_the_post_thumbnail( $post->ID, $size, array( 'class' => apply_filters('themeblvd_post_thumbnail_img_class', '') ) );

	if ( $link ) {

		// Wrap image in link

		if ( $lightbox ) {

			$args = apply_filters( 'themeblvd_featured_image_lightbox_args', array(
				'item'	=> $image.themeblvd_get_image_overlay(),
				'link'	=> $link_url,
				'class'	=> $anchor_class,
				'title'	=> $title
			), $post->ID, $attachment_id );

			$image = themeblvd_get_link_to_lightbox( $args );

		} else {

			$image = sprintf('<a href="%s" target="%s" class="%s" title="%s">%s%s</a>', $link_url, $link_target, $anchor_class, $title, $image, themeblvd_get_image_overlay() );

		}

	} else {

		// If the image isn't linked, wrap the thumbnail class
		// outside of the image. This allows for linked and non-linked
		// images to have the same width after padding.

		$image = sprintf( '<div class="thumbnail">%s</div>', $image );

	}

	// Final HTML output
	$output .= '<div class="featured-image-wrapper '.$classes.'">';
	$output .= '<div class="featured-image">';
	$output .= '<div class="featured-image-inner">';
	$output .= $image;
	$output .= '</div><!-- .featured-image-inner (end) -->';
	$output .= '</div><!-- .featured-image (end) -->';
	$output .= '</div><!-- .featured-image-wrapper (end) -->';

	// Apply filters if allowed
	if ( $allow_filters ) {
		$output = apply_filters( 'themeblvd_post_thumbnail', $output, $location, $size, $link, $image );
	}

	// Return final output
	return $output;
}
endif;

/**
 * Get thumbnail size based on passed in size and/or
 * framework options.
 *
 * @since 2.3.0
 *
 * @param $size string Optional current size of image
 * @param $location string Optional location for thumbnail
 * @param $sidebar_layout string Optional current sidebar layout
 * @return $size Size after it's been formatted
 */
function themeblvd_get_thumbnail_size( $size = '', $location = 'primary', $sidebar_layout = 'full_width' ) {

	// If no $size was passed in, we'll use the framework's options
	// to determine one for different scenarios.
	if ( ! $size ) {
		if ( themeblvd_was('home') || themeblvd_was('page_template', 'template_list.php') ) {

			// "Primary Posts Display" (i.e. homepage or post list template)
			$size = themeblvd_get_option( 'blog_thumbs' );

		} else if ( themeblvd_was('search') || themeblvd_was('archive') ) {

			// Search results and archives
			$size = themeblvd_get_option( 'archive_thumbs' );

		} else if ( themeblvd_was('single') ) {

			// Single posts. First check for overrding meta value, then
			// move to default option from theme options page.
			$size_meta = get_post_meta( get_the_ID(), '_tb_thumb', true );
			if ( $size_meta == 'full' || $size_meta == 'small' || $size_meta == 'hide' ) {
				$size = $size_meta;
			} else {
				$size = themeblvd_get_option( 'single_thumbs' );
			}

		}
	}

	if ( $size == 'hide' ) {
		$size = null;
	}

	if ( $size == 'full' ) {
		$location == 'featured' || $sidebar_layout == 'full_width' ? $size = 'tb_large' : $size = 'tb_medium';
	}

	if ( $size == 'small' ) {
		$size = 'tb_small';
	}

	return apply_filters( 'themeblvd_get_thumbnail_size', $size, $location, $sidebar_layout );
}

/**
 * Add wrapper around embedded videos to allow for respnsive videos.
 *
 * @since 2.0.0
 */
function themeblvd_oembed_result( $input, $url ) {

	// If this is a tweet, keep on movin' fella.
	if ( strpos( $url, 'twitter.com' ) ) {
		return $input;
	}

	// If this is a link to external WP post
	// (introduced in WP 4.4), abort.
	if ( strpos( $input, 'wp-embedded-content' ) !== false ) {
		return $input;
	}

	// Since the framework applies this filter in two
	// spots, we must first check if the filter has
	// been applied or not. The reason for this is
	// because WP has issues with caching the oembed
	// result, and oembed_result doesn't always get
	// applied when it's supposed to.
	if ( strpos( $input, 'themeblvd-video-wrapper' ) ) {
		return $input;
	}

	// Apply YouTube wmode fix
	if ( strpos( $url, 'youtube' ) || strpos( $url, 'youtu.be' ) ) {
		if ( ! strpos( $input, 'wmode=transparent' ) ) {
			$input = str_replace('feature=oembed', 'feature=oembed&wmode=transparent', $input);
		}
	}

	// Wrap output
	$output  = '<div class="themeblvd-video-wrapper">';
	$output .= '<div class="video-inner">';
	$output .= $input;
	$output .= '</div>';
	$output .= '</div>';

	return $output;
}

/**
 * Add 100% width to <audio> tag of WP's built-in
 * audio player to make it responsive.
 *
 * @since 2.2.1
 *
 * @param string $html HTML for output to be filtered
 */
function themeblvd_audio_shortcode( $html ) {
	return str_replace( '<audio', '<audio width="100%"', $html );
}

/**
 * Gallery slider
 *
 * @since 2.3.0
 *
 * @param string $gallery Optional gallery shortcode usage like [gallery ids="1,2,3,4"]
 * @param array $args Options for slider
 * @param string $size Image crop size for attachment images
 */
function themeblvd_gallery_slider( $gallery = '', $args = array() ) {
	echo themeblvd_get_gallery_slider( $gallery, $args );
}

/**
 * Get gallery slider
 *
 * @since 2.3.0
 *
 * @param string $gallery Optional gallery shortcode usage like [gallery ids="1,2,3,4"]
 * @param array $args Options for slider
 * @return string $output Final HTML to output
 */
function themeblvd_get_gallery_slider( $gallery = '', $args = array() ) {

	$defaults = apply_filters( 'themeblvd_gallery_slider_args', array(
		'size'			=> '',					// Crop size for images
		'thumb_size'	=> 'square_smallest', 	// Size of nav thumbnail images
		'interval'		=> 'false',				// Milliseconds between transitions, false for no auto rotation (PHP string to output as JS boolean)
		'pause'			=> 'true',				// Whether to pause on hover (PHP string to output as JS boolean)
		'wrap'			=> 'true',				// Whether sliders continues auto rotate after first pass (PHP string to output as JS boolean)
		'nav_standard'	=> false,				// Whether to show standard nav indicator dots
		'nav_arrows'	=> true,				// Whether to show standard nav arrows
		'nav_thumbs'	=> true					// Whether to show nav thumbnails (added by Theme Blvd framework)
	));
	$args = wp_parse_args( $args, $defaults );

	$post_id = get_the_ID();
	$unique_id = uniqid('gallery_slider_');
	$size = apply_filters( 'themeblvd_gallery_slider_size', $args['size'], $post_id );

	// Did user pass in a gallery shortcode?
	if ( $gallery ) {
		$content = $gallery;
	} else {
		$content = get_the_content(); // Would need to be within the loop
	}

	// Did user insert a gallery like [gallery ids="1,2,3,4"]
	// via $gallery param or anywhere in post?
	$attachments = array();
	$pattern = get_shortcode_regex();

	if ( preg_match( "/$pattern/s", $content, $match ) && 'gallery' == $match[2] ) {

		$atts = shortcode_parse_atts( $match[3] );

		if ( ! empty( $atts['ids'] ) ) {
			$query = array(
				'post_type'		=> 'attachment',
				'post__in' 		=> explode( ',', $atts['ids'] ),
				'orderby'   	=> 'post__in',
				'numberposts'	=> -1
			);
			$attachments = get_posts($query);
		}
	}

	// If no gallery present, pull from attachments of posts
	// (old school way before WP 3.5, less common)
	if ( ! $attachments ) {
		$args = array(
			'post_parent'		=> $post_id,
			'post_status'		=> 'inherit',
			'post_type'			=> 'attachment',
			'post_mime_type'	=> 'image'
		);
		$attachments = get_children( $args );
	}

	// Slider needs 2 or more attachments.
	if ( count( $attachments ) <= 1 ) {
		if ( is_user_logged_in() ) {
			return sprintf( '<div class="alert warning"><p>%s</p></div>', __( 'Oops! Couldn\'t find a gallery with one or more image attachments. Make sure to insert a gallery into the body of the post or attach some images to the post.', 'themeblvd' ) );
		} else {
			return;
		}
	}

	/*--------------------------------------------*/
	/* Bootstrap Slider
	/*--------------------------------------------*/

	$output  = sprintf( '<div id="%s" class="tb-bootstrap-carousel tb-gallery-bootstrap-carousel carousel slide" data-ride="carousel" data-interval="%s" data-pause="%s" data-wrap="%s">', $unique_id, $args['interval'], $args['pause'], $args['wrap'] );
	$output .= "\n<div class=\"carousel-control-wrap\">\n";

	// Standard nav indicators
	if ( $args['nav_standard'] ) {

		$output .= "<ol class=\"carousel-indicators\">\n";

		$counter = 0;

		foreach ( $attachments as $attachment ) {

			$class = '';

			if ( $counter == 0 ) {
				$class = 'active';
			}

			$output .= sprintf( '<li data-target="#%s" data-slide-to="%s" class="%s"></li>', $unique_id, $counter, $class );
			$output .= "\n";

			$counter++;
		}

		$output .= "</ol>\n";

	}

	// Slides
	$output .= "<div class=\"carousel-inner\">\n";

	$counter = 0;

	foreach ( $attachments as $attachment ) {

		$class = 'item';

		if ( $counter == 0 ) {
			$class .= ' active';
		}

		$image = wp_get_attachment_image_src( $attachment->ID, $size );
		$output .= sprintf( "<div class=\"%s\">\n", $class );
		$output .= sprintf( "<img src=\"%s\" alt=\"%s\" />\n", $image[0], $attachment->post_title );
		$output .= "</div><!-- .item (end) -->\n";

		$counter++;
	}

	$output .= "</div><!-- .carousel-inner (end) -->\n";

	// Nav arrows
	if ( $args['nav_arrows'] ) {

		$output .= "<a class=\"left carousel-control\" href=\"#{$unique_id}\" data-slide=\"prev\">\n";
		$output .= "<span class=\"glyphicon glyphicon-chevron-left\"></span>\n";
		$output .= "</a>\n";

		$output .= "<a class=\"right carousel-control\" href=\"#{$unique_id}\" data-slide=\"next\">\n";
		$output .= "<span class=\"glyphicon glyphicon-chevron-right\"></span>\n";
		$output .= "</a>\n";

	}

	$output .= "</div><!-- .carousel-control-wrap (end) -->";

	// Thumbnail navigation
	if ( $args['nav_thumbs'] ) {

		$output .= "<ol class=\"carousel-thumb-nav list-unstyled clearfix\">\n";

		$counter = 0;

		foreach ( $attachments as $attachment ) {

			$class = '';

			if ( $counter == 0 ) {
				$class = 'active';
			}

			$output .= sprintf( '<li data-target="#%s" data-slide-to="%s" class="%s">', $unique_id, $counter, $class );
			$image = wp_get_attachment_image_src( $attachment->ID, $args['thumb_size'] );
			$output .= sprintf( "<img src=\"%s\" alt=\"%s\" />\n", $image[0], $attachment->post_title );
			$output .= '</li>';
			$output .= "\n";

			$counter++;
		}

		$output .= "</ol>\n";

	}

	$output .= "</div><!-- .carousel (end) -->\n";

	return apply_filters( 'themeblvd_gallery_slider', $output, $post_id, $attachments, $args, $unique_id );
}

/**
 * Take a piece of markup and wrap it in a link to a lightbox.
 *
 * @since 2.3.0
 *
 * @param $args array Arguments for lightbox link
 */
function themeblvd_link_to_lightbox( $args ) {
	echo themeblvd_get_link_to_lightbox( $args );
}

/**
 * Take a piece of markup and wrap it in a link to a lightbox.
 *
 * @since 2.3.0
 *
 * @param $args array Arguments for lightbox link
 * @return $output string Final HTML to output
 */
function themeblvd_get_link_to_lightbox( $args ) {

	$defaults = array(
		'item' 		=> themeblvd_get_local('link_to_lightbox'), // HTML Markup to be wrapped in link
		'link' 		=> '',										// Source for media in lightbox
		'title' 	=> '', 										// Title for link
		'type'		=> '',										// Type of lightbox link - image, iframe, ajax, inline - leave blank for auto detection
		'class' 	=> '', 										// Additional CSS classes to add
		'props'		=> array(),									// Additional properties for anchor tag, i.e. array( 'data-something' => 'whatever' )
		'addon'		=> '',										// Optional addon for anchor tag, i.e. data-something="whatever"
		'gallery' 	=> false									// Whether this is part of a gallery
	);
	$args = wp_parse_args( $args, $defaults );

	// Item markup to wrap link around
	$item = $args['item'];

	// Start building link properties
	$props = array(
		'href'	=> $args['link'],
		'title'	=> $args['title'],
		'class'	=> ''
	);

	// Fix for youtu.be links
	if ( strpos( $props['href'], 'http://youtu.be/' ) !== false ) {
		$props['href'] = str_replace( 'http://youtu.be/', 'http://youtube.com/watch?v=', $props['href'] );
	}

	// Lightbox type
	$types = array( 'image', 'iframe', 'inline', 'ajax' );
	$type = $args['type'];

	if ( ! in_array( $type, $types ) ) {

		// Auto lightbox type detection
		if ( strpos( $props['href'], 'youtube.com' ) !== false || strpos( $props['href'], 'vimeo.com' ) !== false || strpos( $props['href'], 'maps.google.com' ) !== false ) {

			$type = 'iframe';

		} else if ( strpos( $props['href'], '#' ) === 0 ) {

			$type = 'inline';

		} else {

			$parsed_url = parse_url( $props['href'] );
			$filetype = wp_check_filetype( $parsed_url['path'] );

			// Link to image file?
			if ( substr( $filetype['type'], 0, 5 ) == 'image' ) {
				$type = 'image';
			}
		}

	}

	// CSS classes
	$class = array( 'themeblvd-lightbox', "mfp-{$type}" );

	if ( 'iframe' == $type ) {
		$class[] = 'lightbox-iframe'; // Enables framework's separate JS for iframe video handling in non-galleries
	}

	$user_class = $args['class'];
	if ( ! is_array( $args['class'] ) ) {
		$user_class = explode(' ', $args['class'] );
	}

	$class = array_merge( $class, $user_class );
	$class = apply_filters( 'themeblvd_lightbox_class', $class, $args, $type, $item ); // Filter while still an array
	$props['class'] = implode( ' ', $class );

	// Add user any additional properties passed in
	if ( is_array( $args['props'] ) ) {
		$props = array_merge( $props, $args['props'] );
	}

	// Extend link properties
	$props = apply_filters( 'themeblvd_lightbox_props', $props, $args, $type, $item, $class );

	// Use properties array to build anchor tag
	$output = '<a ';
	foreach ( $props as $key => $value ) {
		$output .= "{$key}=\"{$value}\" ";
	}
	$output = themeblvd_remove_trailing_char( $output, ' ' );

	// Manual addon
	if ( $args['addon'] ) {
		$output .= ' '.$args['addon'];
	}

	// Finish link
	$output .= sprintf( '>%s</a>', $item );

	return apply_filters( 'themeblvd_link_to_lightbox', $output, $args, $props, $type, $item, $class );
}
