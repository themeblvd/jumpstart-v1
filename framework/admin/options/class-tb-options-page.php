<?php
/**
 * Theme Blvd Options Page
 */

class Theme_Blvd_Options_Page {
	
	public $id;
	public $options;
	public $args;
	
	/**
	 * Constructor.
	 *
	 * @since 2.2.0
	 *
	 * @param string $id A unique ID for this admin page
	 * @param array $options Options for admin page
	 * @param array $args Arguments to setup various elements of the admin page
	 */
	public function __construct( $id, $options, $args = null ) {
		
		// Arguments
		$defaults = array(
			'parent'		=> 'themes.php',
			'page_title' 	=> __( 'Theme Options', 'themeblvd' ),
			'menu_title' 	=> __( 'Theme Options', 'themeblvd' ),
			'cap'			=> themeblvd_admin_module_cap( 'options' )
		);
		$this->args = wp_parse_args( $args, $defaults );
		
		// Option ID -- get_option( $id )
		$this->id = $id;
		
		// Form options
		$this->options = $options;
		
		// Hook it all into motion
		add_action( 'admin_menu', array( $this, 'add_page' ) );
		add_action( 'admin_init', array( $this, 'register' ) );
		add_action( 'admin_init', 'optionsframework_mlu_init' );
		
	}
	
	/**
	 * Register Setting.
	 *
	 * This set of options will all be registered under one 
	 * option in a single multi-dimensional array.
	 *
	 * @since 2.2.0
	 */
	function register() {
		// Registers the settings fields and callback
		register_setting( $this->id, $this->id, array( $this, 'validate' ) );
	}

	/** 
	 * Add the menu page. 
	 *
	 * @since 2.2.0
	 */
	function add_page() {
		$admin_page = add_submenu_page( $this->args['parent'], $this->args['page_title'], $this->args['menu_title'], $this->args['cap'], $this->id, array( $this, 'admin_page' ) );
		add_action( 'admin_print_styles-'.$admin_page, array( $this, 'load_styles' ) );
		add_action( 'admin_print_scripts-'.$admin_page, array( $this, 'load_scripts' ) );
		add_action( 'admin_print_styles-'.$admin_page, 'optionsframework_mlu_css', 0 );
		add_action( 'admin_print_scripts-'.$admin_page, 'optionsframework_mlu_js', 0 );
	}

	/** 
	 * Load CSS.
	 *
	 * @since 2.2.0
	 */
	function load_styles() {
		wp_enqueue_style( 'themeblvd_admin', TB_FRAMEWORK_URI . '/admin/assets/css/admin-style.css', null, TB_FRAMEWORK_VERSION );
		wp_enqueue_style( 'themeblvd_options', TB_FRAMEWORK_URI . '/admin/options/css/admin-style.css', null, TB_FRAMEWORK_VERSION );
		wp_enqueue_style( 'color-picker', TB_FRAMEWORK_URI . '/admin/options/css/colorpicker.css' );
	}

	/**
	 * Load scripts.
	 *
	 * @since 2.2.0
	 */
	function load_scripts() {		
		wp_enqueue_script( 'jquery-ui-core');
		wp_enqueue_script( 'themeblvd_admin', TB_FRAMEWORK_URI . '/admin/assets/js/shared.js', array('jquery'), TB_FRAMEWORK_VERSION );
		wp_localize_script( 'themeblvd_admin', 'themeblvd', themeblvd_get_admin_locals( 'js' ) );
		wp_enqueue_script( 'themeblvd_options', TB_FRAMEWORK_URI . '/admin/options/js/options.js', array('jquery'), TB_FRAMEWORK_VERSION );
		wp_enqueue_script( 'color-picker', TB_FRAMEWORK_URI . '/admin/options/js/colorpicker.js', array('jquery') );
	}

	/**
	 * Builds out the options panel.
	 *
	 * If we were using the Settings API as it was likely intended 
	 * we would use do_settings_sections here.  But as we don't want 
	 * the settings wrapped in a table, we'll call our own custom 
	 * themeblvd_option_fields.  See options-interface.php for 
	 * specifics on how each individual field is generated.
	 *
	 * Nonces are provided using the settings_fields()
	 *
	 * @since 2.2.0
	 */
	function admin_page() {
		
		// Get any current settings from the database.
		$settings = get_option( $this->id );
	    
	    // Setup options form
		$return = themeblvd_option_fields( $this->id, $this->options, $settings  );
		
		// Display any errors or update messages.
		settings_errors();
		?>
		<div class="wrap">
			<div class="admin-module-header">
				<?php do_action( 'themeblvd_admin_module_header', 'options' ); ?>
			</div>
		    <?php screen_icon( 'themes' ); ?>
		    <h2 class="nav-tab-wrapper">
		        <?php echo $return[1]; ?>
		    </h2>
		    <div class="metabox-holder">
			    <div id="optionsframework">
					<form id="themeblvd_theme_options" action="options.php" method="post">
						<?php settings_fields( $this->id ); ?>
						<?php echo $return[0]; /* Settings */ ?>
				        <div id="optionsframework-submit">
							<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( 'Save Options', 'themeblvd' ); ?>" />
							<input type="submit" class="reset-button button-secondary" value="<?php esc_attr_e( 'Restore Defaults', 'themeblvd' ); ?>" />
							<input type="submit" class="clear-button button-secondary" value="<?php esc_attr_e( 'Clear Options', 'themeblvd' ); ?>" />
				           	<div class="clear"></div>
						</div>
					</form>
					<div class="tb-footer-text">
						<?php do_action( 'themeblvd_options_footer_text' ); ?>
					</div><!-- .tb-footer-text (end) -->
				</div><!-- #optionsframework (end) -->
				<div class="admin-module-footer">
					<?php do_action( 'themeblvd_admin_module_footer', 'options' ); ?>
				</div><!-- .admin-module-footer (end) -->
			</div><!-- .metabox-holder (end) -->
		</div><!-- .wrap (end) -->
		<?php
	}

	/** 
	 * Validate Options.
	 *
	 * This runs after the submit/reset button has been clicked and
	 * validates the inputs.
	 * 
	 * @since 2.2.0
	 *
	 * @param array $input Input from submitted form
	 * @return array $clean Sanitized options from submitted form
	 */
	function validate( $input ) {
		
		// Restore Defaults --
		// In the event that the user clicked the "Restore Defaults"
		// button, the options defined in the theme's options.php
		// file will be added to the option for the active theme.
		
		if ( isset( $_POST['reset'] ) ) {
			add_settings_error( $this->id, 'restore_defaults', __( 'Default options restored.', 'themeblvd' ), 'error fade' );
			return themeblvd_get_option_defaults( $this->options );
		}
		
		// Clear options --
		// This gives the user a chance to clear the options from 
		// the database.
		 
		if ( isset( $_POST['clear'] ) ) {
			add_settings_error( $this->id, 'restore_defaults', __( 'Options cleared from database.', 'themeblvd' ), 'error fade' );
			return null;
		}
		 
		// Update Settings --
		// Basically, we're just looping through the current options 
		// registered in this set and sanitizing each value from the 
		// $input before sending back the final $clean array.
				 
		$clean = array();
		foreach( $this->options as $option ){

			// Skip if we don't have an ID or type.
			if ( ! isset( $option['id'] ) || ! isset( $option['type'] ) )
				continue;
			
			// Make sure ID is formatted right.
			$id = preg_replace( '/\W/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) )
				$input[$id] = '0';

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) && ! empty( $option['options'] ) ) {
				foreach ( $option['options'] as $key => $value ){
					$input[$id][$key] = '0';
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'of_sanitize_' . $option['type'] ) && ! empty( $input[$id] ) )
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $input[$id], $option );
				
		}
		
		// Add update message for page re-fresh
		add_settings_error( $this->id, 'save_options', __( 'Options saved.', 'themeblvd' ), 'updated fade' );

		// Return sanitized options
		return $clean;
	}

}