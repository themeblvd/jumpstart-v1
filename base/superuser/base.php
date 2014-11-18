<?php
/**
 * Add theme options to framework.
 *
 * @since 2.0.0
 */
function jumpstart_su_options() {

	// Background support
	add_theme_support( 'custom-background', array(
		'default-color'	=> 'f5f5f5',
		'default-image'	=> ''
	));

	$bg_types = array();

	if ( function_exists('themeblvd_get_bg_types') ) {
		$bg_types = themeblvd_get_bg_types('section');
	}

	// Theme Options
	$options = apply_filters('jumpstart_su_options', array(
		'general' => array(
			'sub_group_start_1' => array(
				'id'		=> 'sub_group_start_xxx',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide-toggle'
			),
			'layout_style' => array(
				'name' 		=> __( 'Site Layout Style', 'themeblvd' ),
				'desc' 		=> __( 'Select whether you\'d like the layotu of the theme to be boxed or not.', 'themeblvd' ),
				'id' 		=> 'layout_style',
				'std' 		=> 'stretch',
				'type' 		=> 'select',
				'options'	=> array(
					'stretch' 	=> __( 'Stretch', 'themeblvd' ),
					'boxed' 	=> __( 'Boxed', 'themeblvd' )
				),
				'class'		=> 'trigger'
			),
			'layout_shadow_size' => array(
				'id'		=> 'layout_shadow_size',
				'name'		=> __('Layout Shadow Size', 'themeblvd'),
				'desc'		=> __('Select the size of the shadow around the boxed layout. Set to <em>0px</em> for no shadow.', 'themeblvd'),
				'std'		=> '5px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '20'
				),
				'class'		=> 'receiver receiver-boxed'
			),
			'layout_shadow_opacity' => array(
				'id'		=> 'layout_shadow_opacity',
				'name'		=> __('Layout Shadow Strength', 'themeblvd'),
				'desc'		=> __('Select the opacity of the shadow for the boxed layout. The darker <a href="themes.php?page=custom-background" target="_blank">your background</a>, the closer to 1.0 you want to go.', 'themeblvd'),
				'std'		=> '0.3',
				'type'		=> 'select',
				'options'	=> array(
					'0.1'	=> '0.1',
					'0.2'	=> '0.2',
					'0.3'	=> '0.3',
					'0.4'	=> '0.4',
					'0.5'	=> '0.5',
					'0.6'	=> '0.6',
					'0.7'	=> '0.7',
					'0.8'	=> '0.8',
					'0.9'	=> '0.9',
					'1'		=> '1.0'
				),
				'class'		=> 'receiver  receiver-boxed'
			),
			'layout_border_width' => array(
				'id'		=> 'layout_border_width',
				'name'		=> __('Layout Border Width', 'themeblvd'),
				'desc'		=> __('Select a width in pixels for the boxed layout. Set to <em>0px</em> for no border.', 'themeblvd'),
				'std'		=> '1px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '20'
				),
				'class'		=> 'receiver receiver-boxed'
			),
			'layout_border_color' => array(
				'id'		=> 'layout_border_color',
				'name'		=> __('Layout Border Color', 'themeblvd'),
				'desc'		=> __('Select a color for the border around the boxed layout.', 'themeblvd'),
				'std'		=> '#cccccc',
				'type'		=> 'color',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '20'
				),
				'class'		=> 'receiver receiver-boxed'
			),
			'sub_group_end_1' => array(
				'id'		=> 'sub_group_end_1',
				'type' 		=> 'subgroup_end'
			),
			'style' =>  array(
				'id'		=> 'style',
				'name' 		=> __( 'Content Style', 'themeblvd' ),
				'desc'		=> __( 'Select the content style of the site.', 'themeblvd' ),
				'std'		=> 'light',
				'type' 		=> 'select',
				'options'	=> array(
					'light' => __( 'Light', 'themeblvd' ),
					'dark' 	=> __( 'Dark', 'themeblvd' )
				)
			)
		),
		'header_top' => array(
			'top_bg_color' => array(
				'id'		=> 'top_bg_color',
				'name'		=> __('Top Background Color', 'themeblvd'),
				'desc'		=> __('Select a background color for the bar that runs across the top of the header.', 'themeblvd'),
				'std'		=> '#ffffff',
				'type'		=> 'color',
				'class'		=> 'receiver'
			),
			'top_bg_color_brightness' => array(
				'name' 		=> __( 'Top Background Color Brightness', 'themeblvd' ),
				'desc' 		=> __( 'In the previous option, did you go dark or light?', 'themeblvd' ),
				'id' 		=> 'top_bg_color_brightness',
				'std' 		=> 'light',
				'type' 		=> 'select',
				'options'	=> array(
					'light' => __( 'I chose a light color in the previous option.', 'themeblvd' ),
					'dark' 	=> __( 'I chose a dark color in the previous option.', 'themeblvd' )
				),
				'class'		=> 'receiver'
			),
			'top_bg_color_opacity' => array(
				'id'		=> 'top_bg_color_opacity',
				'name'		=> __('Top Background Color Opacity', 'themeblvd'),
				'desc'		=> __('Select the opacity of the above background color. Selecting "1.0" means that the background color is not transparent, at all.', 'themeblvd'),
				'std'		=> '1',
				'type'		=> 'select',
				'options'	=> array(
					'0.1'	=> '0.1',
					'0.2'	=> '0.2',
					'0.3'	=> '0.3',
					'0.4'	=> '0.4',
					'0.5'	=> '0.5',
					'0.6'	=> '0.6',
					'0.7'	=> '0.7',
					'0.8'	=> '0.8',
					'0.9'	=> '0.9',
					'1'		=> '1.0'
				),
				'class'		=> 'receiver'
			),
			'sub_group_start_2' => array(
				'id'		=> 'sub_group_start_2',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide receiver'
			),
			'top_apply_border_bottom' => array(
				'id'		=> 'top_apply_border_bottom',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Bottom Border', 'themeblvd').'</strong>: '.__('Apply bottom border to the top bar of the header.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'top_border_bottom_color' => array(
				'id'		=> 'top_border_bottom_color',
				'name'		=> __('Bottom Border Color', 'themeblvd'),
				'desc'		=> __('Select a color for the bottom border.', 'themeblvd'),
				'std'		=> '#dddddd',
				'type'		=> 'color',
				'class'		=> 'hide receiver'
			),
			'top_border_bottom_width' => array(
				'id'		=> 'top_border_bottom_width',
				'name'		=> __('Bottom Border Width', 'themeblvd'),
				'desc'		=> __('Select a width in pixels for the bottom border.', 'themeblvd'),
				'std'		=> '1px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '1',
					'max'		=> '10'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_2' => array(
				'id'		=> 'sub_group_end_2',
				'type' 		=> 'subgroup_end'
			)
		),
		'header' => array(
			'sub_group_start_3' => array(
				'id'		=> 'sub_group_start_3',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide-toggle'
			),
			'header_bg_type' => array(
				'id'		=> 'header_bg_type',
				'name'		=> __('Apply Header Background', 'themeblvd'),
				'desc'		=> __('Select if you\'d like to apply a custom background and how you want to control it.', 'themeblvd'),
				'std'		=> 'none',
				'type'		=> 'select',
				'options'	=> $bg_types,
				'class'		=> 'trigger'
			),
			'header_bg_color' => array(
				'id'		=> 'header_bg_color',
				'name'		=> __('Background Color', 'themeblvd'),
				'desc'		=> __('Select a background color.', 'themeblvd'),
				'std'		=> '#f8f8f8',
				'type'		=> 'color',
				'class'		=> 'hide receiver receiver-color receiver-texture receiver-image'
			),
			'header_bg_color_brightness' => array(
				'id' 		=> 'header_bg_color_brightness',
				'name' 		=> __( 'Background Color Brightness', 'themeblvd' ),
				'desc' 		=> __( 'In the previous option, did you go dark or light?', 'themeblvd' ),
				'std' 		=> 'light',
				'type' 		=> 'select',
				'options'	=> array(
					'light' => __( 'I chose a light color in the previous option.', 'themeblvd' ),
					'dark' 	=> __( 'I chose a dark color in the previous option.', 'themeblvd' )
				),
				'class'		=> 'hide receiver receiver-color receiver-texture receiver-image'
			),
			'header_bg_color_opacity' => array(
				'id'		=> 'header_bg_color_opacity',
				'name'		=> __('Background Color Opacity', 'themeblvd'),
				'desc'		=> __('Select the opacity of the background color. Selecting "1.0" means that the background color is not transparent, at all.', 'themeblvd'),
				'std'		=> '1',
				'type'		=> 'select',
				'options'	=> array(
					'0.1'	=> '0.1',
					'0.2'	=> '0.2',
					'0.3'	=> '0.3',
					'0.4'	=> '0.4',
					'0.5'	=> '0.5',
					'0.6'	=> '0.6',
					'0.7'	=> '0.7',
					'0.8'	=> '0.8',
					'0.9'	=> '0.9',
					'1'		=> '1.0'
				),
				'class'		=> 'hide receiver receiver-color receiver-texture'
			),
			'header_bg_texture' => array(
				'id'		=> 'header_bg_texture',
				'name'		=> __('Background Texture', 'themeblvd'),
				'desc'		=> __('Select a background texture.', 'themeblvd'),
				'type'		=> 'select',
				'select'	=> 'textures',
				'class'		=> 'hide receiver receiver-texture'
			),
			'sub_group_start_4' => array(
				'id'		=> 'sub_group_start_4',
				'type'		=> 'subgroup_start',
				'class'		=> 'show-hide hide receiver receiver-texture'
			),
			'header_apply_bg_texture_parallax' => array(
				'id'		=> 'header_apply_bg_texture_parallax',
				'name'		=> null,
				'desc'		=> __('Apply parallax scroll effect to background texture.', 'themeblvd'),
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'header_bg_texture_parallax' => array(
				'id'		=> 'header_bg_texture_parallax',
				'name'		=> __('Parallax Intensity', 'themeblvd'),
				'desc'		=> __('Select the instensity of the scroll effect. 1 is the least intense, and 10 is the most intense.', 'themeblvd'),
				'type'		=> 'slide',
				'std'		=> '5',
				'options'	=> array(
					'min'	=> '1',
					'max'	=> '10',
					'step'	=> '1'
				),
				'class'		=> 'hide receiver'
			),
			'subgroup_end_4' => array(
				'id'		=> 'subgroup_end_4',
				'type'		=> 'subgroup_end'
			),
			'sub_group_start_5' => array(
				'id'		=> 'sub_group_start_5',
				'type'		=> 'subgroup_start',
				'class'		=> 'select-parallax hide receiver receiver-image'
			),
			'header_bg_image' => array(
				'id'		=> 'header_bg_image',
				'name'		=> __('Background Image', 'themeblvd'),
				'desc'		=> __('Select a background image.', 'themeblvd'),
				'type'		=> 'background',
				'color'		=> false,
				'parallax'	=> true
			),
			'header_bg_image_parallax_stretch' => array(
				'id'		=> 'header_bg_image_parallax_stretch',
				'name'		=> __('Parallax: Stretch Background', 'themeblvd'),
				'desc'		=> __('When this is checked, your background image will be expanded to fit horizontally, but never condensed. &mdash; <em>Note: This will only work if Background Repeat is set to "No Repeat."</em>', 'themeblvd'),
				'type'		=> 'checkbox',
				'std'		=> '1',
				'class'		=> 'hide parallax'
			),
			'header_bg_image_parallax' => array(
				'id'		=> 'header_bg_image_parallax',
				'name'		=> __('Parallax: Intensity', 'themeblvd'),
				'desc'		=> __('Select the instensity of the scroll effect. 1 is the least intense, and 10 is the most intense.', 'themeblvd'),
				'type'		=> 'slide',
				'std'		=> '2',
				'options'	=> array(
					'min'	=> '1',
					'max'	=> '10',
					'step'	=> '1'
				),
				'class'		=> 'hide parallax'
			),
			'sub_group_end_5' => array(
				'id'		=> 'sub_group_end_5',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_6' => array(
				'id'		=> 'sub_group_start_6',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide hide receiver receiver-image receiver-slideshow'
			),
			'header_apply_bg_shade' => array(
				'id'		=> 'header_apply_bg_shade',
				'name'		=> null,
				'desc'		=> __('Shade background with transparent color.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'header_bg_shade_color' => array(
				'id'		=> 'header_bg_shade_color',
				'name'		=> __('Shade Color', 'themeblvd'),
				'desc'		=> __('Select the color you want overlaid on your background.', 'themeblvd'),
				'std'		=> '#000000',
				'type'		=> 'color',
				'class'		=> 'hide receiver'
			),
			'header_bg_shade_opacity' => array(
				'id'		=> 'header_bg_shade_opacity',
				'name'		=> __('Shade Opacity', 'themeblvd'),
				'desc'		=> __('Select the opacity of the shade color overlaid on your background.', 'themeblvd'),
				'std'		=> '0.5',
				'type'		=> 'select',
				'options'	=> array(
					'0.1'	=> '0.1',
					'0.2'	=> '0.2',
					'0.3'	=> '0.3',
					'0.4'	=> '0.4',
					'0.5'	=> '0.5',
					'0.6'	=> '0.6',
					'0.7'	=> '0.7',
					'0.8'	=> '0.8',
					'0.9'	=> '0.9'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_6' => array(
				'id'		=> 'sub_group_end_6',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_7' => array(
				'id'		=> 'sub_group_start_7',
				'type'		=> 'subgroup_start',
				'class'		=> 'section-bg-slideshow hide receiver receiver-slideshow'
			),
			'header_bg_slideshow' => array(
				'id' 		=> 'header_bg_slideshow',
				'name'		=> __('Slideshow Images', 'themeblvd'),
				'desc'		=> null,
				'type'		=> 'slider'
			),
			'header_bg_slideshow_crop' => array(
				'name' 		=> __( 'Slideshow Crop Size', 'themeblvd' ),
				'desc' 		=> __( 'Select the crop size to be used for the background slideshow images. Remember that the background images will be stretched to cover the area.', 'themeblvd' ),
				'id' 		=> 'header_bg_slideshow_crop',
				'std' 		=> 'full',
				'type' 		=> 'select',
				'select'	=> 'crop'
			),
			'sub_group_start_8' => array(
				'id'		=> 'sub_group_start_8',
				'type'		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'header_apply_bg_slideshow_parallax' => array(
				'id'		=> 'header_apply_bg_slideshow_parallax',
				'name'		=> null,
				'desc'		=> __('Apply parallax scroll effect to background slideshow.', 'themeblvd'),
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'header_bg_slideshow_parallax' => array(
				'id'		=> 'header_bg_slideshow_parallax',
				'name'		=> __('Parallax Intensity', 'themeblvd'),
				'desc'		=> __('Select the instensity of the scroll effect. 1 is the least intense, and 10 is the most intense.', 'themeblvd'),
				'type'		=> 'slide',
				'std'		=> '5',
				'options'	=> array(
					'min'	=> '1',
					'max'	=> '10',
					'step'	=> '1'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_8' => array(
				'id'		=> 'sub_group_end_8',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_end_7' => array(
				'id'		=> 'sub_group_end_7',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_end_3' => array(
				'id'		=> 'sub_group_end_3',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_9' => array(
				'id'		=> 'sub_group_start_9',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'header_apply_border_top' => array(
				'id'		=> 'header_apply_border_top',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Top Border', 'themeblvd').'</strong>: '.__('Apply top border to header.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'header_border_top_color' => array(
				'id'		=> 'header_border_top_color',
				'name'		=> __('Top Border Color', 'themeblvd'),
				'desc'		=> __('Select a color for the top border.', 'themeblvd'),
				'std'		=> '#dddddd',
				'type'		=> 'color',
				'class'		=> 'hide receiver'
			),
			'header_border_top_width' => array(
				'id'		=> 'header_border_top_width',
				'name'		=> __('Top Border Width', 'themeblvd'),
				'desc'		=> __('Select a width in pixels for the top border.', 'themeblvd'),
				'std'		=> '5px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '1',
					'max'		=> '10'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_9' => array(
				'id'		=> 'sub_group_end_9',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_10' => array(
				'id'		=> 'sub_group_start_10',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'header_apply_border_bottom' => array(
				'id'		=> 'header_apply_border_bottom',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Bottom Border', 'themeblvd').'</strong>: '.__('Apply bottom border to header.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'header_border_bottom_color' => array(
				'id'		=> 'header_border_bottom_color',
				'name'		=> __('Bottom Border Color', 'themeblvd'),
				'desc'		=> __('Select a color for the bottom border.', 'themeblvd'),
				'std'		=> '#dddddd',
				'type'		=> 'color',
				'class'		=> 'hide receiver'
			),
			'header_border_bottom_width' => array(
				'id'		=> 'header_border_bottom_width',
				'name'		=> __('Bottom Border Width', 'themeblvd'),
				'desc'		=> __('Select a width in pixels for the bottom border.', 'themeblvd'),
				'std'		=> '5px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '1',
					'max'		=> '10'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_10' => array(
				'id'		=> 'sub_group_end_10',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_11' => array(
				'id'		=> 'sub_group_start_11',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'header_apply_padding_desktop' => array(
				'id'		=> 'header_apply_padding_desktop',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Desktop Padding', 'themeblvd').':</strong> '.__('Apply custom padding around header content.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'header_padding_top_desktop' => array(
				'id'		=> 'header_padding_top_desktop',
				'name'		=> __('Top Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the top of the header.', 'themeblvd'),
				'std'		=> '20px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'header_padding_right_desktop' => array(
				'id'		=> 'header_padding_right_desktop',
				'name'		=> __('Right Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the right of the header.', 'themeblvd'),
				'std'		=> '20px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'header_padding_bottom_desktop' => array(
				'id'		=> 'header_padding_bottom_desktop',
				'name'		=> __('Bottom Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the bottom of the header.', 'themeblvd'),
				'std'		=> '20px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'header_padding_left_desktop' => array(
				'id'		=> 'header_padding_left_desktop',
				'name'		=> __('Left Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the left of the header.', 'themeblvd'),
				'std'		=> '20px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_11' => array(
				'id'		=> 'sub_group_end_11',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_12' => array(
				'id'		=> 'sub_group_start_12',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'header_apply_padding_tablet' => array(
				'id'		=> 'header_apply_padding_tablet',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Tablet Padding', 'themeblvd').':</strong> '.__('Apply custom padding around header content.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'header_padding_top_tablet' => array(
				'id'		=> 'header_padding_top_tablet',
				'name'		=> __('Top Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the top of the header.', 'themeblvd'),
				'std'		=> '10px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'header_padding_right_tablet' => array(
				'id'		=> 'header_padding_right_tablet',
				'name'		=> __('Right Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the right of the header.', 'themeblvd'),
				'std'		=> '10px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'header_padding_bottom_tablet' => array(
				'id'		=> 'header_padding_bottom_tablet',
				'name'		=> __('Bottom Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the bottom of the header.', 'themeblvd'),
				'std'		=> '10px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'header_padding_left_tablet' => array(
				'id'		=> 'header_padding_left_tablet',
				'name'		=> __('Left Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the left of the header.', 'themeblvd'),
				'std'		=> '10px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_12' => array(
				'id'		=> 'sub_group_end_12',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_13' => array(
				'id'		=> 'sub_group_start_13',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'header_apply_padding_mobile' => array(
				'id'		=> 'header_apply_padding_mobile',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Mobile Padding', 'themeblvd').':</strong> '.__('Apply custom padding around header content.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'header_padding_top_mobile' => array(
				'id'		=> 'header_padding_top_mobile',
				'name'		=> __('Top Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the top of the header.', 'themeblvd'),
				'std'		=> '10px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'header_padding_right_mobile' => array(
				'id'		=> 'header_padding_right_mobile',
				'name'		=> __('Right Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the right of the header.', 'themeblvd'),
				'std'		=> '10px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'header_padding_bottom_mobile' => array(
				'id'		=> 'header_padding_bottom_mobile',
				'name'		=> __('Bottom Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the bottom of the header.', 'themeblvd'),
				'std'		=> '10px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'header_padding_left_mobile' => array(
				'id'		=> 'header_padding_left_mobile',
				'name'		=> __('Left Padding', 'themeblvd'),
				'desc'		=> __('Set the padding on the left of the header.', 'themeblvd'),
				'std'		=> '10px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '600'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_13' => array(
				'id'		=> 'sub_group_end_13',
				'type' 		=> 'subgroup_end'
			)
		),
		'menu' => array(
			'sub_group_start_14' => array(
				'id'		=> 'sub_group_start_14',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide-toggle'
			),
			'menu_bg_type' => array(
				'id'		=> 'menu_bg_type',
				'name'		=> __('Main Menu Background', 'themeblvd'),
				'desc'		=> __('Select if you\'d like to apply a custom background and how you want to control it.', 'themeblvd'),
				'std'		=> 'color',
				'type'		=> 'select',
				'options'	=> array(
					'color'				=> __('Custom color', 'themeblvd'),
					'glassy'			=> __('Custom color + glassy overlay', 'themeblvd'),
					'textured'			=> __('Custom color + noisy texture', 'themeblvd'),
					'gradient'			=> __('Custom gradient', 'themeblvd')
				),
				'class'		=> 'trigger'
			),
			'menu_bg_color' => array(
				'id'		=> 'menu_bg_color',
				'name'		=> __('Background Color', 'themeblvd'),
				'desc'		=> __('Select a background color for the main menu.', 'themeblvd'),
				'std'		=> '#333333',
				'type'		=> 'color',
				'class'		=> 'hide receiver receiver-color receiver-glassy receiver-textured'
			),
			'menu_bg_gradient' => array(
				'id'		=> 'menu_bg_gradient',
				'name'		=> __('Background Gradient', 'themeblvd'),
				'desc'		=> __('Select two colors to create a gradient with for the main menu.', 'themeblvd'),
				'std'		=> array('start' => '#3c3c3c', 'end' => '#2b2b2b'),
				'type'		=> 'gradient',
				'class'		=> 'hide receiver receiver-gradient receiver-gradient_glassy'
			),
			'menu_bg_color_brightness' => array(
				'id' 		=> 'menu_bg_color_brightness',
				'name' 		=> __( 'Background Color Brightness', 'themeblvd' ),
				'desc' 		=> __( 'In the previous option, did you go dark or light?', 'themeblvd' ),
				'std' 		=> 'dark',
				'type' 		=> 'select',
				'options'	=> array(
					'light' => __( 'I chose a light color in the previous option.', 'themeblvd' ),
					'dark' 	=> __( 'I chose a dark color in the previous option.', 'themeblvd' )
				),
				'class'		=> 'hide receiver receiver-color receiver-glassy receiver-textured receiver-gradient receiver-gradient_glassy'
			),
			'sub_group_end_14' => array(
				'id'		=> 'sub_group_end_14',
				'type' 		=> 'subgroup_end'
			),
			'menu_hover_bg_color' => array(
				'id'		=> 'menu_hover_bg_color',
				'name'		=> __('Button Hover Background Color', 'themeblvd'),
				'desc'		=> __('Select a background color for when buttons of the main are hovered on.', 'themeblvd'),
				'std'		=> '#000000',
				'type'		=> 'color'
			),
			'menu_hover_bg_color_opacity' => array(
				'id'		=> 'menu_hover_bg_color_opacity',
				'name'		=> __('Button Hover Background Color Opacity', 'themeblvd'),
				'desc'		=> __('Select the opacity of the color you selected in the previous option.', 'themeblvd'),
				'std'		=> '0.3',
				'type'		=> 'select',
				'options'	=> array(
					'0.1'	=> '0.1',
					'0.2'	=> '0.2',
					'0.3'	=> '0.3',
					'0.4'	=> '0.4',
					'0.5'	=> '0.5',
					'0.6'	=> '0.6',
					'0.7'	=> '0.7',
					'0.8'	=> '0.8',
					'0.9'	=> '0.9',
					'1'		=> '1.0'
				)
			),
			'menu_hover_bg_color_brightness' => array(
				'id' 		=> 'menu_hover_bg_color_brightness',
				'name' 		=> __( 'Button Hover Background Color Brightness', 'themeblvd' ),
				'desc' 		=> __( 'In the previous option, did you go dark or light?', 'themeblvd' ),
				'std' 		=> 'dark',
				'type' 		=> 'select',
				'options'	=> array(
					'light' => __( 'I chose a light color in the previous option.', 'themeblvd' ),
					'dark' 	=> __( 'I chose a dark color in the previous option.', 'themeblvd' )
				)
			),
			'menu_sub_bg_color' => array(
				'id'		=> 'menu_sub_bg_color',
				'name'		=> __('Dropdown Background Color', 'themeblvd'),
				'desc'		=> __('Select a background color for the main menu\'s drop down menus.', 'themeblvd'),
				'std'		=> '#ffffff',
				'type'		=> 'color'
			),
			'menu_sub_bg_color_brightness' => array(
				'id' 		=> 'menu_sub_bg_color_brightness',
				'name' 		=> __( 'Dropdown Background Color Brightness', 'themeblvd' ),
				'desc' 		=> __( 'In the previous option, did you go dark or light?', 'themeblvd' ),
				'std' 		=> 'light',
				'type' 		=> 'select',
				'options'	=> array(
					'light' => __( 'I chose a light color in the previous option.', 'themeblvd' ),
					'dark' 	=> __( 'I chose a dark color in the previous option.', 'themeblvd' )
				)
			),
			'sub_group_start_15' => array(
				'id'		=> 'sub_group_start_15',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'menu_apply_border_top' => array(
				'id'		=> 'menu_apply_border_top',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Top Border', 'themeblvd').'</strong>: '.__('Apply top border to menu.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'menu_border_top_color' => array(
				'id'		=> 'menu_border_top_color',
				'name'		=> __('Top Border Color', 'themeblvd'),
				'desc'		=> __('Select a color for the top border.', 'themeblvd'),
				'std'		=> '#181818',
				'type'		=> 'color',
				'class'		=> 'hide receiver'
			),
			'menu_border_top_width' => array(
				'id'		=> 'menu_border_top_width',
				'name'		=> __('Top Border Width', 'themeblvd'),
				'desc'		=> __('Select a width in pixels for the top border.', 'themeblvd'),
				'std'		=> '1px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '1',
					'max'		=> '10'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_15' => array(
				'id'		=> 'sub_group_end_15',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_16' => array(
				'id'		=> 'sub_group_start_16',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'menu_apply_border_bottom' => array(
				'id'		=> 'menu_apply_border_bottom',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Bottom Border', 'themeblvd').'</strong>: '.__('Apply bottom border to menu.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'menu_border_bottom_color' => array(
				'id'		=> 'menu_border_bottom_color',
				'name'		=> __('Bottom Border Color', 'themeblvd'),
				'desc'		=> __('Select a color for the bottom border.', 'themeblvd'),
				'std'		=> '#181818',
				'type'		=> 'color',
				'class'		=> 'hide receiver'
			),
			'menu_border_bottom_width' => array(
				'id'		=> 'menu_border_bottom_width',
				'name'		=> __('Bottom Border Width', 'themeblvd'),
				'desc'		=> __('Select a width in pixels for the bottom border.', 'themeblvd'),
				'std'		=> '1px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '1',
					'max'		=> '10'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_16' => array(
				'id'		=> 'sub_group_end_16',
				'type' 		=> 'subgroup_end'
			),
			'menu_text_bold' => array(
				'id'		=> 'menu_text_bold',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Bold', 'themeblvd').'</strong>: '.__('Bold the text of the main menu.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox'
			),
			'menu_text_shadow' => array(
				'id'		=> 'menu_text_shadow',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Text Shadow', 'themeblvd').'</strong>: '.__('Apply shadow to the text of the main menu.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox'
			)
		),
		'menu_mobile' => array(
			'menu_mobile_bg_color' => array(
				'id'		=> 'menu_mobile_bg_color',
				'name'		=> __('Mobile Menu Background Color', 'themeblvd'),
				'desc'		=> __('Select a background color for the main menu\'s drop down menus.', 'themeblvd'),
				'std'		=> '#333333',
				'type'		=> 'color'
			),
			'menu_mobile_bg_color_brightness' => array(
				'id' 		=> 'menu_mobile_bg_color_brightness',
				'name' 		=> __( 'Mobile Menu Background Color Brightness', 'themeblvd' ),
				'desc' 		=> __( 'In the previous option, did you go dark or light?', 'themeblvd' ),
				'std' 		=> 'dark',
				'type' 		=> 'select',
				'options'	=> array(
					'light' => __( 'I chose a light color in the previous option.', 'themeblvd' ),
					'dark' 	=> __( 'I chose a dark color in the previous option.', 'themeblvd' )
				)
			),
			'menu_mobile_social_media_style' => array(
				'name' 		=> __( 'Social Media Style', 'themeblvd' ),
				'desc'		=> __( 'Select the color you\'d like applied to the social icons in the mobile menu.', 'themeblvd' ),
				'id'		=> 'menu_mobile_social_media_style',
				'std'		=> 'light',
				'type' 		=> 'select',
				'options'	=> array(
					'flat'			=> __( 'Flat Color', 'themeblvd' ),
					'dark' 			=> __( 'Flat Dark', 'themeblvd' ),
					'grey' 			=> __( 'Flat Grey', 'themeblvd' ),
					'light' 		=> __( 'Flat Light', 'themeblvd' ),
					'color'			=> __( 'Color', 'themeblvd' )
				)
			)
		),
		'footer' => array(
			'sub_group_start_17' => array(
				'id'		=> 'sub_group_start_17',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide-toggle'
			),
			'footer_bg_type' => array(
				'id'		=> 'footer_bg_type',
				'name'		=> __('Apply Footer Background', 'themeblvd'),
				'desc'		=> __('Select if you\'d like to apply a custom background color to the footer.<br><br>Note: To setup a more complex designed footer, go to <em>Layout > Footer</em> and use the "Template Sync" feature.', 'themeblvd'),
				'std'		=> 'none',
				'type'		=> 'select',
				'options'	=> array(
					'none'		=> __('None', 'themeblvd'),
					'color'		=> __('Custom color', 'themeblvd')
				),
				'class'		=> 'trigger'
			),
			'footer_bg_color' => array(
				'id'		=> 'footer_bg_color',
				'name'		=> __('Background Color', 'themeblvd'),
				'desc'		=> __('Select a background color for the footer.', 'themeblvd'),
				'std'		=> '#333333',
				'type'		=> 'color',
				'class'		=> 'hide receiver receiver-color'
			),
			'footer_bg_color_brightness' => array(
				'id' 		=> 'footer_bg_color_brightness',
				'name' 		=> __( 'Background Color Brightness', 'themeblvd' ),
				'desc' 		=> __( 'In the previous option, did you go dark or light?', 'themeblvd' ),
				'std' 		=> 'dark',
				'type' 		=> 'select',
				'options'	=> array(
					'light' => __( 'I chose a light color in the previous option.', 'themeblvd' ),
					'dark' 	=> __( 'I chose a dark color in the previous option.', 'themeblvd' )
				),
				'class'		=> 'hide receiver receiver-color'
			),
			'footer_bg_color_opacity' => array(
				'id'		=> 'footer_bg_color_opacity',
				'name'		=> __('Background Color Opacity', 'themeblvd'),
				'desc'		=> __('Select the opacity of the background color you chose.', 'themeblvd'),
				'std'		=> '1',
				'type'		=> 'select',
				'options'	=> array(
					'0.1'	=> '0.1',
					'0.2'	=> '0.2',
					'0.3'	=> '0.3',
					'0.4'	=> '0.4',
					'0.5'	=> '0.5',
					'0.6'	=> '0.6',
					'0.7'	=> '0.7',
					'0.8'	=> '0.8',
					'0.9'	=> '0.9',
					'1'		=> '1.0'
				),
				'class'		=> 'hide receiver receiver-color'
			),
			'sub_group_end_17' => array(
				'id'		=> 'sub_group_end_17',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_18' => array(
				'id'		=> 'sub_group_start_18',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'footer_apply_border_top' => array(
				'id'		=> 'footer_apply_border_top',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Top Border', 'themeblvd').'</strong>: '.__('Apply top border to footer.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'footer_border_top_color' => array(
				'id'		=> 'footer_border_top_color',
				'name'		=> __('Top Border Color', 'themeblvd'),
				'desc'		=> __('Select a color for the top border.', 'themeblvd'),
				'std'		=> '#181818',
				'type'		=> 'color',
				'class'		=> 'hide receiver'
			),
			'footer_border_top_width' => array(
				'id'		=> 'footer_border_top_width',
				'name'		=> __('Top Border Width', 'themeblvd'),
				'desc'		=> __('Select a width in pixels for the top border.', 'themeblvd'),
				'std'		=> '1px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '1',
					'max'		=> '10'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_18' => array(
				'id'		=> 'sub_group_end_18',
				'type' 		=> 'subgroup_end'
			),
			'sub_group_start_19' => array(
				'id'		=> 'sub_group_start_19',
				'type' 		=> 'subgroup_start',
				'class'		=> 'show-hide'
			),
			'footer_apply_border_bottom' => array(
				'id'		=> 'footer_apply_border_bottom',
				'name'		=> null,
				'desc'		=> '<strong>'.__('Bottom Border', 'themeblvd').'</strong>: '.__('Apply bottom border to footer.', 'themeblvd'),
				'std'		=> 0,
				'type'		=> 'checkbox',
				'class'		=> 'trigger'
			),
			'footer_border_bottom_color' => array(
				'id'		=> 'footer_border_bottom_color',
				'name'		=> __('Bottom Border Color', 'themeblvd'),
				'desc'		=> __('Select a color for the bottom border.', 'themeblvd'),
				'std'		=> '#181818',
				'type'		=> 'color',
				'class'		=> 'hide receiver'
			),
			'footer_border_bottom_width' => array(
				'id'		=> 'footer_border_bottom_width',
				'name'		=> __('Bottom Border Width', 'themeblvd'),
				'desc'		=> __('Select a width in pixels for the bottom border.', 'themeblvd'),
				'std'		=> '1px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '1',
					'max'		=> '10'
				),
				'class'		=> 'hide receiver'
			),
			'sub_group_end_19' => array(
				'id'		=> 'sub_group_end_19',
				'type' 		=> 'subgroup_end'
			)
		),
		'typo' => array(
			'font_body' => array(
				'id' 		=> 'font_body',
				'name' 		=> __( 'Primary Font', 'themeblvd' ),
				'desc' 		=> __( 'This applies to most of the text on your site.', 'themeblvd' ),
				'std' 		=> array('size' => '14px', 'face' => 'helvetica', 'color' => '', 'google' => '', 'style' => 'thin'),
				'atts'		=> array('size', 'face', 'style'),
				'type' 		=> 'typography'
			),
			'font_header' => array(
				'id' 		=> 'font_header',
				'name' 		=> __( 'Header Font', 'themeblvd' ),
				'desc' 		=> __( 'This applies to all of the primary headers throughout your site (h1, h2, h3, h4, h5, h6). This would include header tags used in redundant areas like widgets and the content of posts and pages.', 'themeblvd' ),
				'std' 		=> array('size' => '','face' => 'helvetica', 'color' => '', 'google' => '', 'style' => 'bold'),
				'atts'		=> array('face', 'style'),
				'type' 		=> 'typography'
			),
			'link_color' => array(
				'id' 		=> 'link_color',
				'name' 		=> __( 'Link Color', 'themeblvd' ),
				'desc' 		=> __( 'Choose the color you\'d like applied to links.', 'themeblvd' ),
				'std' 		=> '#428bca',
				'type' 		=> 'color'
			),
			'link_hover_color' => array(
				'id' 		=> 'link_hover_color',
				'name' 		=> __( 'Link Hover Color', 'themeblvd' ),
				'desc' 		=> __( 'Choose the color you\'d like applied to links when they are hovered over.', 'themeblvd' ),
				'std' 		=> '#2a6496',
				'type' 		=> 'color'
			),
			'footer_link_color' => array(
				'id' 		=> 'footer_link_color',
				'name' 		=> __( 'Link Color', 'themeblvd' ),
				'desc' 		=> __( 'Choose the color you\'d like applied to links.', 'themeblvd' ),
				'std' 		=> '#428bca',
				'type' 		=> 'color'
			),
			'footer_link_hover_color' => array(
				'id' 		=> 'footer_link_hover_color',
				'name' 		=> __( 'Link Hover Color', 'themeblvd' ),
				'desc' 		=> __( 'Choose the color you\'d like applied to links when they are hovered over.', 'themeblvd' ),
				'std' 		=> '#2a6496',
				'type' 		=> 'color'
			)
		),
		'buttons' => array(
			'btn_default' => array(
				'id' 		=> 'btn_default',
				'name'		=> __( 'Default Buttons', 'themeblvd' ),
				'desc'		=> __( 'Configure what a default button looks like.', 'themeblvd' ),
				'std'		=> array(
					'bg' 				=> '#ffffff',
					'bg_hover'			=> '#e6e6e7',
					'border' 			=> '#cccccc',
					'text'				=> '#333333',
					'text_hover'		=> '#333333',
					'include_bg'		=> 1,
					'include_border'	=> 1
				),
				'type'		=> 'button'
			),
			'btn_primary' => array(
				'id' 		=> 'btn_primary',
				'name'		=> __( 'Primary Buttons', 'themeblvd' ),
				'desc'		=> __( 'Configure what a primary button looks like.', 'themeblvd' ),
				'std'		=> array(
					'bg' 				=> '#333333',
					'bg_hover'			=> '#222222',
					'border' 			=> '#000000',
					'text'				=> '#ffffff',
					'text_hover'		=> '#ffffff',
					'include_bg'		=> 1,
					'include_border'	=> 1
				),
				'type'		=> 'button'
			),
			'btn_border' => array(
				'id'		=> 'btn_border',
				'name'		=> __('General Button Border Width', 'themeblvd'),
				'desc'		=> __('Select a width in pixels for border of buttons.', 'themeblvd'),
				'std'		=> '1px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '5'
				)
			),
			'btn_corners' => array(
				'id'		=> 'btn_corners',
				'name'		=> __('General Button Corners', 'themeblvd'),
				'desc'		=> __('Select the border radius of button corners.', 'themeblvd'),
				'std'		=> '0px',
				'type'		=> 'slide',
				'options'	=> array(
					'units'		=> 'px',
					'min'		=> '0',
					'max'		=> '50'
				)
			)
		),
		'extras' => array(
			'thumbnail' =>  array(
				'id'		=> 'thumbnail',
				'name' 		=> null,
				'desc'		=> __( 'Apply border to thumbnails and featured images', 'themeblvd' ),
				'std'		=> '0',
				'type' 		=> 'checkbox'
			)
		)
	));

	themeblvd_add_option_tab( 'styles', __('Styles', 'themeblvd'), true );

	themeblvd_add_option_section( 'styles', 'su_general',		__('General', 'themeblvd'), 	null, $options['general'] );
	themeblvd_add_option_section( 'styles', 'su_header_top',	__('Header Top', 'themeblvd'), 	null, $options['header_top'] );
	themeblvd_add_option_section( 'styles', 'su_header',		__('Header', 'themeblvd'),		null, $options['header'] );
	themeblvd_add_option_section( 'styles', 'su_menu',			__('Main Menu', 'themeblvd'),	null, $options['menu'] );
	themeblvd_add_option_section( 'styles', 'su_menu_mobile',	__('Mobile Menu', 'themeblvd'),	null, $options['menu_mobile'] );
	themeblvd_add_option_section( 'styles', 'su_footer',		__('Footer', 'themeblvd'),		null, $options['footer'] );
	themeblvd_add_option_section( 'styles', 'su_typo',			__('Typography', 'themeblvd'), 	null, $options['typo'] );
	themeblvd_add_option_section( 'styles', 'su_buttons',		__('Buttons', 'themeblvd'),		null, $options['buttons'] );
	themeblvd_add_option_section( 'styles', 'su_extras',		__('Extras', 'themeblvd'), 		null, $options['extras'] );

}
add_action('after_setup_theme', 'jumpstart_su_options');

/**
 * Filter global config
 *
 * @since 2.0.0
 */
function jumpstart_su_global_config( $setup ) {

	if ( themeblvd_get_option('style') == 'dark' ) {
		$setup['display']['dark'] = true;
	}

	return $setup;
}
add_filter('themeblvd_global_config', 'jumpstart_su_global_config');

/**
 * Change the color of social icons on
 * mobile side menu
 *
 * @since 2.0.0
 */
function jumpstart_su_mobile_side_menu_social_media_color( $color ) {
	return themeblvd_get_option('menu_mobile_social_media_style');
}
add_filter('themeblvd_mobile_side_menu_social_media_color', 'jumpstart_su_mobile_side_menu_social_media_color');

/**
 * Filter on thumbnail borders
 *
 * @since 2.0.0
 */
function jumpstart_su_featured_thumb_frame() {

	if ( themeblvd_get_option('thumbnail') ) {
		return true;
	}

	return false;
}
add_filter('themeblvd_featured_thumb_frame', 'jumpstart_su_featured_thumb_frame');

/**
 * Body class
 *
 * @since 2.0.0
 */
function jumpstart_su_body_class($class) {

	// Boxed layout
	if ( themeblvd_get_option('layout_style') == 'boxed' ) {
		$class[] = 'js-boxed';
	}

	return $class;

}
add_filter('body_class', 'jumpstart_su_body_class');

/**
 * Enqueue any CSS
 *
 * @since 2.0.0
 */
function jumpstart_su_css() {

	$print = '';

	$header_bg_type = themeblvd_get_option('header_bg_type');
	$header_bg_color = themeblvd_get_option('header_bg_color');

	// Typography and links
	$font = themeblvd_get_option('font_body');

	if ( $font ) {
		$print .= "html,\n";
		$print .= "body {\n";
		$print .= sprintf("\tfont-family: %s;\n", themeblvd_get_font_face($font) );
		$print .= sprintf("\tfont-size: %s;\n", themeblvd_get_font_size($font) );
		$print .= sprintf("\tfont-style: %s;\n", themeblvd_get_font_style($font) );
		$print .= sprintf("\tfont-weight: %s;\n", themeblvd_get_font_weight($font) );
		$print .= "}\n";
	}

	$font = themeblvd_get_option('font_header');

	if ( $font ) {
		$print .= "h1, h2, h3, h4, h5, h6 {\n";
		$print .= sprintf("\tfont-family: %s;\n", themeblvd_get_font_face($font) );
		$print .= sprintf("\tfont-style: %s;\n", themeblvd_get_font_style($font) );
		$print .= sprintf("\tfont-weight: %s;\n", themeblvd_get_font_weight($font) );
		$print .= "}\n";
	}

	$print .= "a {\n";
	$print .= sprintf("\tcolor: %s;\n", themeblvd_get_option('link_color'));
	$print .= "}\n";

	$print .= "a:hover,\n";
	$print .= ".entry-title a:hover,\n";
	$print .= "#comments .comment-body .comment-meta a:hover {\n";
	$print .= sprintf("\tcolor: %s;\n", themeblvd_get_option('link_hover_color'));
	$print .= "}\n";

	$print .= ".site-footer a {\n";
	$print .= sprintf("\tcolor: %s;\n", themeblvd_get_option('footer_link_color'));
	$print .= "}\n";

	$print .= ".site-footer a:hover {\n";
	$print .= sprintf("\tcolor: %s;\n", themeblvd_get_option('footer_link_hover_color'));
	$print .= "}\n";

	// Buttons
	$print .= ".btn {\n";
	$print .= sprintf("\tborder-width: %s;\n", themeblvd_get_option('btn_border'));
	$print .= sprintf("\t-webkit-border-radius: %s;\n", themeblvd_get_option('btn_corners'));
	$print .= sprintf("\tborder-radius: %s;\n", themeblvd_get_option('btn_corners'));
	$print .= "}\n";

	$btn = themeblvd_get_option('btn_default');

	if ( $btn ) {

		$print .= ".btn-default {\n";

		if ( $btn['include_bg'] ) {
			$print .= sprintf("\tbackground-color: %s;\n", $btn['bg']);
		} else {
			$print .= "\tbackground-color: transparent;\n";
		}

		if ( $btn['include_border'] ) {
			$print .= sprintf("\tborder-color: %s;\n", $btn['border']);
		} else {
			$print .= "\tborder: none;\n";
		}

		$print .= sprintf("\tcolor: %s;\n", $btn['text']);

		$print .= "}\n";

		$print .= ".btn-default:hover,\n";
		$print .= ".btn-default:focus,\n";
		$print .= ".btn-default:active,\n";
		$print .= ".btn-default.active {\n";

		$print .= sprintf("\tbackground-color: %s;\n", $btn['bg_hover']);

		if ( $btn['include_border'] ) {
			$print .= sprintf("\tborder-color: %s;\n", $btn['border']);
		}

		$print .= sprintf("\tcolor: %s;\n", $btn['text_hover']);
		$print .= "}\n";

	}

	$btn = themeblvd_get_option('btn_primary');

	if ( $btn ) {

		$print .= ".primary,\n";
		$print .= ".bg-primary,\n";
		$print .= ".btn-primary,\n";
		$print .= ".label-primary,\n";
		$print .= ".panel-primary > .panel-heading {\n";

		if ( $btn['include_bg'] ) {
			$print .= sprintf("\tbackground-color: %s;\n", $btn['bg']);
		} else {
			$print .= "\tbackground-color: transparent;\n";
		}

		if ( $btn['include_border'] ) {
			$print .= sprintf("\tborder-color: %s;\n", $btn['border']);
		} else {
			$print .= "\tborder: none;\n";
		}

		$print .= sprintf("\tcolor: %s;\n", $btn['text']);

		$print .= "}\n";

		$print .= ".primary:hover,\n";
		$print .= ".primary:focus,\n";
		$print .= "a.bg-primary:hover,\n";
		$print .= ".btn-primary:hover,\n";
		$print .= ".btn-primary:focus,\n";
		$print .= ".btn-primary:active,\n";
		$print .= ".btn-primary.active,\n";
		$print .= ".label-primary[href]:hover,\n";
		$print .= ".label-primary[href]:focus {\n";

		$print .= sprintf("\tbackground-color: %s;\n", $btn['bg_hover']);

		if ( $btn['include_border'] ) {
			$print .= sprintf("\tborder-color: %s;\n", $btn['border']);
		}

		$print .= sprintf("\tcolor: %s;\n", $btn['text_hover']);

		$print .= "}\n";

		$print .= ".panel-primary {\n";

		if ( $btn['include_border'] ) {
			$print .= sprintf("\tborder-color: %s;\n", $btn['border']);
		} else {
			$print .= "\tborder: none;\n";
		}

		$print .= "}\n";
	}

	// Boxed Layout
	if ( themeblvd_get_option('layout_style') == 'boxed' ) {
		$print .= ".js-boxed #container {\n";
		$print .= sprintf( "\tbox-shadow: 0 0 %s %s;\n", themeblvd_get_option('layout_shadow_size'), themeblvd_get_rgb( '#000000', themeblvd_get_option('layout_shadow_opacity') ) );
		$print .= sprintf( "\tborder: %s solid %s;\n", themeblvd_get_option('layout_border_width'), themeblvd_get_option('layout_border_color') );
		$print .= "}\n";
	}

	// Header background (entire header, behind top bar and main menu)
	$options = array();

	$options['bg_type'] = $header_bg_type;
	$options['bg_color'] = $header_bg_color;
	$options['bg_color_opacity'] = themeblvd_get_option('header_bg_color_opacity');
	$options['bg_texture'] = themeblvd_get_option('header_bg_texture');
	$options['apply_bg_texture_parallax'] = themeblvd_get_option('header_apply_bg_texture_parallax');
	$options['bg_texture_parallax'] = themeblvd_get_option('header_bg_texture_parallax');
	$options['bg_image'] = themeblvd_get_option('header_bg_image');
	$options['bg_image_parallax_stretch'] = themeblvd_get_option('header_bg_image_parallax_stretch');
	$options['bg_image_parallax'] = themeblvd_get_option('header_bg_image_parallax');
	$options['apply_bg_shade'] = themeblvd_get_option('header_apply_bg_shade');
	$options['bg_shade_color'] = themeblvd_get_option('header_bg_shade_color');
	$options['bg_shade_opacity'] = themeblvd_get_option('header_bg_shade_opacity');

	$options['apply_border_top'] = themeblvd_get_option('header_apply_border_top');
	$options['border_top_color'] = themeblvd_get_option('header_border_top_color');
	$options['border_top_width'] = themeblvd_get_option('header_border_top_width');

	$options['apply_border_bottom'] = themeblvd_get_option('header_apply_border_bottom');
	$options['border_bottom_color'] = themeblvd_get_option('header_border_bottom_color');
	$options['border_bottom_width'] = themeblvd_get_option('header_border_bottom_width');

	$styles = themeblvd_get_display_inline_style( $options, 'external' );

	if ( ! empty( $styles['general'] ) ) {

		$print .= ".site-header {\n";

		foreach ( $styles['general'] as $prop => $value ) {
			$prop = str_replace('-2', '', $prop);
			$print .= sprintf("\t%s: %s;\n", $prop, $value);
		}

		$print .= "}\n";

	}

	// Header top bar
	$options = array();
	$options['bg_type'] = 'color';
	$options['bg_color'] = themeblvd_get_option('top_bg_color');
	$options['apply_border_bottom'] = themeblvd_get_option('top_apply_border_bottom');
	$options['border_bottom_color'] = themeblvd_get_option('top_border_bottom_color');
	$options['border_bottom_width'] = themeblvd_get_option('top_border_bottom_width');
	$options['bg_color_opacity'] = themeblvd_get_option('top_bg_color_opacity');

	$styles = themeblvd_get_display_inline_style( $options, 'external' );

	if ( ! empty( $styles['general'] ) ) {

		$print .= ".header-top {\n";

		foreach ( $styles['general'] as $prop => $value ) {
			$prop = str_replace('-2', '', $prop);
			$print .= sprintf("\t%s: %s;\n", $prop, $value);
		}

		if ( themeblvd_get_option('top_bg_color_brightness') == 'dark' ) {
			$print .= "\tcolor: #ffffff;\n";
			$print .= "\ttext-shadow: 1px 1px 1px rgba(0,0,0,.8);\n";
		} else {
			$print .= "\tcolor: #666666;\n";
		}

		$print .= "}\n";

		$print .= ".tb-search-popup .search-popup {\n";
		$print .= sprintf("\tbackground-color: %s;\n", $options['bg_color']);
		$print .= "}\n";

		$print .= ".tb-search-popup.bottom.left .search-popup > .arrow:after,\n";
		$print .= ".tb-search-popup.bottom.right .search-popup > .arrow:after {\n";
		$print .= sprintf("\tborder-bottom-color: %s;\n", $options['bg_color']);
		$print .= "}\n";

		$print .= ".tb-search-popup.top.left .search-popup > .arrow:after,\n";
		$print .= ".tb-search-popup.top.right .search-popup > .arrow:after {\n";
		$print .= sprintf("\tborder-top-color: %s;\n", $options['bg_color']);
		$print .= "}\n";

	}

	// Header sticky menu
	if ( $header_bg_type && $header_bg_type != 'none' && $header_bg_color ) {

		$brightness = themeblvd_get_option('header_bg_color_brightness');

		$print .= ".tb-sticky-menu {\n";
		$print .= sprintf("\tbackground-color: %s;\n", $header_bg_color);
		$print .= sprintf("\tbackground-color: %s;\n", themeblvd_get_rgb($header_bg_color, '0.9'));

		if ( $brightness == 'dark' ) {
			$print .= "\tcolor: #ffffff;\n";
		} else {
			$print .= "\tcolor: #333333;\n";
		}

		$print .= "}\n";

		if ( $brightness == 'dark' ) {

			$print .= ".tb-sticky-menu .tb-primary-menu > li > .menu-btn,\n";
			$print .= ".tb-sticky-menu .tb-primary-menu > li > .menu-btn:hover {\n";
			$print .= "\tcolor: #ffffff;\n";
			$print .= "}\n";

			$print .= ".tb-sticky-menu .tb-primary-menu > li > .menu-btn:hover {\n";
			$print .= "\tbackground-color: #000000;\n";
			$print .= "\tbackground-color: rgba(255,255,255,.1);\n";
			$print .= "}\n";

		}

	}

	// Header content padding
	$options = array();

	$options['apply_padding_desktop'] = themeblvd_get_option('header_apply_padding_desktop');
	$options['padding_top_desktop'] = themeblvd_get_option('header_padding_top_desktop');
	$options['padding_right_desktop'] = themeblvd_get_option('header_padding_right_desktop');
	$options['padding_bottom_desktop'] = themeblvd_get_option('header_padding_bottom_desktop');
	$options['padding_left_desktop'] = themeblvd_get_option('header_padding_left_desktop');

	$options['apply_padding_tablet'] = themeblvd_get_option('header_apply_padding_tablet');
	$options['padding_top_tablet'] = themeblvd_get_option('header_padding_top_tablet');
	$options['padding_right_tablet'] = themeblvd_get_option('header_padding_right_tablet');
	$options['padding_bottom_tablet'] = themeblvd_get_option('header_padding_bottom_tablet');
	$options['padding_left_tablet'] = themeblvd_get_option('header_padding_left_tablet');

	$options['apply_padding_mobile'] = themeblvd_get_option('header_apply_padding_mobile');
	$options['padding_top_mobile'] = themeblvd_get_option('header_padding_top_mobile');
	$options['padding_right_mobile'] = themeblvd_get_option('header_padding_right_mobile');
	$options['padding_bottom_mobile'] = themeblvd_get_option('header_padding_bottom_mobile');
	$options['padding_left_mobile'] = themeblvd_get_option('header_padding_left_mobile');

	$styles = themeblvd_get_display_inline_style( $options, 'external' );

	if ( $styles ) {

		foreach ( $styles as $type => $params ) {

			if ( ! $params ) {
				continue;
			}

			$indent = '';

			if ( $type != 'general' ) {
				$indent = "\t";
			}

			switch ( $type ) {
				case 'desktop' :
					$print .= "@media (min-width: 993px) {\n";
					break;
				case 'tablet' :
					$print .= "@media (max-width: 992px) and (min-width: 768px) {\n";
					break;
				case 'mobile' :
					$print .= "@media (max-width: 767px) {\n";
			}

			$print .= $indent.".header-content > .wrap {\n";

			foreach ( $params as $prop => $value ) {
				$print .= $indent.sprintf("\t%s: %s;\n", $prop, $value);
			}

			$print .= $indent."}\n";

			if ( $type != 'general' ) {
				$print .= "}\n";
			}

		}

	}

	// Primary navigation
	$options = array();

	$options['bg_type'] = themeblvd_get_option('menu_bg_type');
	$options['bg_color'] = themeblvd_get_option('menu_bg_color');
	$options['bg_gradient'] = themeblvd_get_option('menu_bg_gradient');
	$options['bg_color_brightness'] = themeblvd_get_option('menu_bg_color_brightness');

	$options['hover_bg_color'] = themeblvd_get_option('menu_hover_bg_color');
	$options['hover_bg_color_opacity'] = themeblvd_get_option('menu_hover_bg_color_opacity');
	$options['hover_bg_color_brightness'] = themeblvd_get_option('menu_hover_bg_color_brightness');

	$options['sub_bg_color'] = themeblvd_get_option('menu_sub_bg_color');
	$options['sub_bg_color_brightness'] = themeblvd_get_option('menu_sub_bg_color_brightness');

	$options['text_bold'] = themeblvd_get_option('menu_text_bold');
	$options['text_shadow'] = themeblvd_get_option('menu_text_shadow');

	$options['apply_border_top'] = themeblvd_get_option('menu_apply_border_top');
	$options['border_top_color'] = themeblvd_get_option('menu_border_top_color');
	$options['border_top_width'] = themeblvd_get_option('menu_border_top_width');

	$options['apply_border_bottom'] = themeblvd_get_option('menu_apply_border_bottom');
	$options['border_bottom_color'] = themeblvd_get_option('menu_border_bottom_color');
	$options['border_bottom_width'] = themeblvd_get_option('menu_border_bottom_width');

	$print .= ".header-nav {\n";

	if ( $options['bg_type'] == 'gradient' ) {
		$print .= sprintf("\tbackground-color: %s;\n", $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -webkit-gradient(linear, left top, left bottom, from(%s), to(%s));\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -webkit-linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -moz-linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -o-linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -ms-linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tfilter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='%s', EndColorStr='%s');\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
	} else {
		$print .= sprintf("\tbackground-color: %s;\n", $options['bg_color']);
	}

	if ( $options['bg_type'] == 'glassy' ) {
		$print .= sprintf("\tbackground-image: url(%s);\n", themeblvd_get_base_uri('superuser').'/images/menu-glassy.png');
	} else if ( $options['bg_type'] == 'textured' ) {
		$print .= sprintf("\tbackground-image: url(%s);\n", themeblvd_get_base_uri('superuser').'/images/menu-textured.png');
		$print .= "\tbackground-position: 0 0;\n";
		$print .= "\tbackground-repeat: repeat;\n";
		$print .= "\tbackground-size: 72px 56px;\n";
	}

	if ( $options['apply_border_top'] ) {
		$print .= sprintf("\tborder-top: %s solid %s;\n", $options['border_top_width'], $options['border_top_color'] );
	}

	if ( $options['apply_border_top'] ) {
		$print .= sprintf("\tborder-bottom: %s solid %s;\n", $options['border_bottom_width'], $options['border_bottom_color'] );
	}

	$print .= "}\n";

	if ( $options['bg_color_brightness'] == 'light' || $options['text_bold'] || $options['text_shadow'] ) {

		$print .= ".tb-primary-menu > li > .menu-btn {\n";

		if ( $options['bg_color_brightness'] == 'light' ) {
			$print .= "\tcolor: #333333;\n";
		}

		if ( $options['text_bold'] ) {
			$print .= "\tfont-weight: bold;\n";
		}

		if ( $options['text_shadow'] ) {
			$print .= "\ttext-shadow: 1px 1px 1px rgba(0,0,0,.8);\n";
		}

		$print .= "}\n";

	}

	$print .= ".tb-primary-menu > li > a:hover {\n";

	$print .= sprintf("\tbackground-color: %s;\n", $options['hover_bg_color'] );
	$print .= sprintf("\tbackground-color: %s;\n", themeblvd_get_rgb($options['hover_bg_color'], $options['hover_bg_color_opacity']) );

	if ( $options['hover_bg_color_brightness'] == 'light' ) {
		$print .= "\tcolor: #333333;\n";
	}

	$print .= "}\n";

	// Primary menu mobile toggle
	$print .= ".btn-navbar {\n";

	if ( $options['bg_type'] == 'gradient' ) {
		$print .= sprintf("\tbackground-color: %s;\n", $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -webkit-gradient(linear, left top, left bottom, from(%s), to(%s));\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -webkit-linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -moz-linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -o-linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: -ms-linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tbackground-image: linear-gradient(top, %s, %s);\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
		$print .= sprintf("\tfilter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='%s', EndColorStr='%s');\n", $options['bg_gradient']['start'], $options['bg_gradient']['end'] );
	} else {
		$print .= sprintf("\tbackground-color: %s;\n", $options['bg_color']);
	}

	if ( $options['bg_color_brightness'] == 'light' ) {
		$print .= "\tcolor: #333333 !important;\n";
	}

	$print .= "}\n";

	$print .= ".btn-navbar:hover {\n";

	if ( $options['bg_type'] == 'gradient' ) {
		$print .= sprintf("\tbackground-color: %s;\n", themeblvd_adjust_color( $options['bg_gradient']['end'] ) );
	} else {
		$print .= sprintf("\tbackground-color: %s;\n", themeblvd_adjust_color( $options['bg_color'] ) );
	}

	$print .= "}\n";

	// Primary nav sub menus
	$print .= ".tb-primary-menu ul.non-mega-sub-menu,\n";
	$print .= ".tb-primary-menu .sf-mega {\n";
	$print .= sprintf("\tbackground-color: %s;\n", $options['sub_bg_color'] );
	$print .= "}\n";

	if ( $options['sub_bg_color_brightness'] == 'dark' ) {

		$print .= ".tb-primary-menu ul .menu-btn,\n";
		$print .= ".tb-primary-menu .mega-section-header {\n";
		$print .= "\tcolor: #ffffff;\n";
		$print .= "}\n";

		$print .= ".tb-primary-menu ul.non-mega-sub-menu,\n";
		$print .= ".tb-primary-menu .sf-mega {\n";
		$print .= "\tborder-color: rgba(0,0,0,.2);\n";
		$print .= "}";

		$print .= "\t.tb-primary-menu ul a:hover {";
		$print .= "background-color: rgba(255,255,255,.1)\n";
		$print .= "}\n";

	}

	// Primary mobile menu
	$print .= "#tb-side-menu-wrapper,\n";
	$print .= "#tb-side-menu-wrapper .tb-side-menu,\n";
	$print .= "#tb-side-menu-wrapper .tb-side-menu .sub-menu li.non-mega-sub-menu:last-child {\n";
	$print .= sprintf("\tbackground-color: %s;\n", themeblvd_get_option('menu_mobile_bg_color'));
	$print .= "}\n";

	if ( themeblvd_get_option('menu_mobile_bg_color_brightness') == 'light' ) {

		$print .= "#tb-side-menu-wrapper .tb-side-menu a,\n";
		$print .= "#tb-side-menu-wrapper .tb-side-menu span,\n";
		$print .= "#tb-side-menu-wrapper .tb-side-menu .tb-side-menu-toggle:hover,\n";
		$print .= "#tb-side-menu-wrapper .tb-side-menu .tb-side-menu-toggle:active,\n";
		$print .= "#tb-side-menu-wrapper .tb-search .search-input {\n";
		$print .= "\tcolor: #666666;\n";
		$print .= "}\n";

		$print .= "#tb-side-menu-wrapper .tb-side-menu .tb-side-menu-toggle {\n";
		$print .= "\tcolor: #333333;\n";
		$print .= "}\n";

		$print .= "#tb-side-menu-wrapper .tb-side-menu .sub-menu {\n";
		$print .= sprintf("\tbackground-image: url(%s/assets/images/parts/side-nav-list-outer-cccccc.png);", TB_FRAMEWORK_URI);
		$print .= "}\n";
		$print .= "#tb-side-menu-wrapper .tb-side-menu .sub-menu li {\n";
		$print .= sprintf("\tbackground-image: url(%s/assets/images/parts/side-nav-list-ltr-cccccc.png);", TB_FRAMEWORK_URI);
		$print .= "}\n";

	}

	// Footer
	$options = array();

	$options['bg_type'] = themeblvd_get_option('footer_bg_type');
	$options['bg_color'] = themeblvd_get_option('footer_bg_color');
	$options['bg_color_opacity'] = themeblvd_get_option('footer_bg_color_opacity');

	$options['apply_border_top'] = themeblvd_get_option('footer_apply_border_top');
	$options['border_top_color'] = themeblvd_get_option('footer_border_top_color');
	$options['border_top_width'] = themeblvd_get_option('footer_border_top_width');

	$options['apply_border_bottom'] = themeblvd_get_option('footer_apply_border_bottom');
	$options['border_bottom_color'] = themeblvd_get_option('footer_border_bottom_color');
	$options['border_bottom_width'] = themeblvd_get_option('footer_border_bottom_width');

	$styles = themeblvd_get_display_inline_style( $options, 'external' );

	if ( ! empty( $styles['general'] ) ) {

		$print .= ".site-footer {\n";

		foreach ( $styles['general'] as $prop => $value ) {
			$prop = str_replace('-2', '', $prop);
			$print .= sprintf("\t%s: %s;\n", $prop, $value);
		}

		$print .= "}\n";

	}

	// Final output
	if ( $print ) {
		wp_add_inline_style( 'themeblvd-ie', apply_filters('jumpstart_su_css_output', $print) );
	}

}
add_action( 'wp_enqueue_scripts', 'jumpstart_su_css', 25 );

/**
 * Add CSS classes and parralax data() to header
 *
 * @since 2.0.0
 */
function jumpstart_su_header_class( $output, $class ) {

	$options = array(
		'bg_type'						=> themeblvd_get_option('header_bg_type'),
		'apply_bg_shade'				=> themeblvd_get_option('header_apply_bg_shade'),
		'apply_bg_texture_parallax'		=> themeblvd_get_option('header_apply_bg_texture_parallax'),
		'bg_image'						=> themeblvd_get_option('header_bg_image'),
		'bg_image_parallax'				=> themeblvd_get_option('header_bg_image_parallax'),
		'bg_image_parallax_stretch'		=> themeblvd_get_option('header_bg_image_parallax_stretch'),
		'bg_slideshow'					=> themeblvd_get_option('header_bg_slideshow'),
		'apply_padding'					=> themeblvd_get_option('header_apply_padding')
	);

	$class = array_merge( $class, themeblvd_get_display_class($options) );

	return sprintf('class="%s" data-parallax="%s"', implode(' ', $class), themeblvd_get_parallax_intensity($options) );
}
add_filter('themeblvd_header_class_output', 'jumpstart_su_header_class', 10, 2);

/**
 * Add CSS classes to footer
 *
 * @since 2.0.0
 */
function jumpstart_su_footer_class( $class ) {

	if ( themeblvd_get_option('footer_bg_type') == 'color' ) {

		if ( themeblvd_get_option('footer_bg_color_brightness') == 'dark' ) {
			$class[] = 'text-light';
		}

		$class[] = 'has-bg';

	}

	return $class;
}
add_filter('themeblvd_footer_class', 'jumpstart_su_footer_class');

/**
 * Add any outputted HTML needed for header styling
 * options to work.
 *
 * @since 2.0.0
 */
function jumpstart_su_header_top() {

	$display = array(
		'bg_type' 						=> themeblvd_get_option('header_bg_type'),
		'apply_bg_shade'				=> themeblvd_get_option('header_apply_bg_shade'),
		'bg_shade_color'				=> themeblvd_get_option('header_bg_shade_color'),
		'bg_shade_opacity'				=> themeblvd_get_option('header_bg_shade_opacity'),
		'bg_slideshow'					=> themeblvd_get_option('header_bg_slideshow'),
		'apply_bg_slideshow_parallax'	=> themeblvd_get_option('header_apply_bg_slideshow_parallax'),
		'bg_slideshow_parallax'			=> themeblvd_get_option('header_bg_slideshow_parallax')
	);

	if ( ( $display['bg_type'] == 'image' || $display['bg_type'] == 'slideshow' ) && ! empty($display['apply_bg_shade']) ) {
		printf( '<div class="bg-shade" style="background-color: %s; background-color: %s;"></div>', $display['bg_shade_color'], themeblvd_get_rgb( $display['bg_shade_color'], $display['bg_shade_opacity'] ) );
	}

	if ( $display['bg_type'] == 'slideshow' && ! empty($display['bg_slideshow']) ) {

		$parallax = 0;

		if ( ! empty($display['apply_bg_slideshow_parallax']) ) {
			$parallax = $display['bg_slideshow_parallax'];
		}

		themeblvd_bg_slideshow( 'header', $display['bg_slideshow'], $parallax );
	}

}
add_action( 'themeblvd_header_top', 'jumpstart_su_header_top', 5 );