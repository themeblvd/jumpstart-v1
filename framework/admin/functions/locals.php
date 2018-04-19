<?php
/**
 * Return user read text strings. This function allows
 * to have all of the framework's common localized text
 * strings in once place. Also, the following filters can
 * be used to add/remove strings.
 *
 * themeblvd_locals_js
 *
 * @since 2.0.0
 *
 * @param string $type type of set, js or frontend
 * @return array $locals filtered array of localized text strings
 */
function themeblvd_get_admin_locals( $type ) {
	$locals = array();
	switch ( $type ) {

		// General JS strings
		case 'js' :
			$locals = array (
				'clear'					=> __( 'By doing this, you will clear your database of this option set. In other words, you will lose any previously saved settings. Are you sure you want to continue?', 'themeblvd' ),
				'clear_title'			=> __( 'Clear Options', 'themeblvd' ),
				'no_name'				=> __( 'Oops! You forgot to enter a name.', 'themeblvd' ),
				'invalid_name'			=> __( 'Oops! The name you entered is either taken or too close to another name you\'ve already used.', 'themeblvd' ),
				'publish'				=> __( 'Publish', 'themeblvd' ),
				'primary_query'			=> __( 'Oops! You can only have one primary query element per layout. A paginated post list or paginated post grid would be examples of primary query elements.', 'themeblvd' ),
				'reset'					=> __( 'By doing this, all of your default theme settings will be saved, and you will lose any previously saved settings. Are you sure you want to continue?', 'themeblvd' ),
				'reset_title'			=> __( 'Restore Defaults', 'themeblvd' )
			);
			break;

		// Customizer JS strings
		case 'customizer_js' :
			$locals = array (
				// @TODO
			);

		// @todo Could add more types other than JS here later.
	}
	return apply_filters( 'themeblvd_locals_'.$type, $locals );
}
