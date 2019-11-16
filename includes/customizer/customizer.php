<?php
/**
 * Add customizer custom fields for this theme
 *
 * @package grundstein
 * @since 0.0.1
 */

/**
 * Sanitize radio input values
 *
 * @since 0.0.1
 *
 * @param string $input string with input name.
 * @param array  $setting value of the input.
 *
 * @return string either the input value or the input default value
 */
function mgs_slug_sanitize_radio( string $input, array $setting ) {
	// input must be a slug: only lowercase alphanumeric characters, dashes and underscores are allowed.
	$input = sanitize_key( $input );
	// get the list of possible radio box options.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	// return input if valid or return default option.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Add a section to the customizer
 *
 * @since 0.0.1
 *
 * @param object $wp_customize WordPress customizer instance.
 * @param string $name of the input.
 * @param string $label info label.
 * @param int    $priority order this input appears in the list, higher = lower.
 */
function mgs_add_customizer_section( object $wp_customize, string $name, string $label, int $priority = 30 ) {
	$wp_customize->add_section(
		$name,
		array(
			'title'    => esc_html( $label ),
			'priority' => $priority,
		)
	);
}

/**
 * Add a section to the customizer
 *
 * @since 0.0.1
 *
 * @param object $wp_customize WordPress customizer instance.
 * @param string $section to put the input in.
 * @param string $name of the input.
 * @param any    $default value of this input.
 * @param string $label info label.
 * @param array  $control Class to inherit this control from.
 * @param array  $opts options for this section.
 * @param string $sanitize type of sanitizer to run against the input.
 */
function mgs_add_customizer( $wp_customize, string $section, string $name, $default, string $label, $control, array $opts = [], string $sanitize = 'sanitize_hex_color' ) {
	$setting_options = array(
		'transport' => 'refresh',
	);
	if ( is_array( $default ) ) {
		$setting_options = array_merge( $setting_options, $default );
	} else {
		$setting_options = array_merge(
			$setting_options,
			array(
				'default'  => $default,
				'sanitize' => $sanitize,
			)
		);
	}

	$wp_customize->add_setting( $name, $setting_options );

	$def_opts = array(
		'section'  => $section,
		'label'    => esc_html( $label ),
		'settings' => $name,
	);

	$options = array_merge( $def_opts, $opts );

	$wp_customize->add_control( new $control( $wp_customize, $name, $options ) );
}

/**
 * Add a section to the customizer
 *
 * @since 0.0.1
 *
 * @param object $wp_customize WordPress customizer instance.
 */
function mgs_customize_register( $wp_customize ) {
	mgs_add_customizer_section( $wp_customize, 'layout', 'Layout', 20 );
	mgs_add_customizer_section( $wp_customize, 'header', 'Header' );
	mgs_add_customizer_section( $wp_customize, 'footer', 'Footer', 40 );

	$layout_settings_options = array(
		'sanitize' => 'mgs_slug_sanitize_radio',
		'default'  => 'classic',
	);

	$layout_options = array(
		'type'    => 'radio',
		'choices' => array(
			'1' => 'Classic',
			'2' => '2 Column',
			'3' => '3 Column',
		),
	);

	$menu_layout_settings_options = array(
		'sanitize' => 'mgs_slug_sanitize_radio',
		'default'  => '1',
	);
	$menu_layout_options          = array(
		'type'    => 'radio',
		'choices' => array(
			'1' => 'Classic',
			'2' => 'Centered',
		),
	);

	mgs_add_customizer( $wp_customize, 'layout', 'layout_id', $layout_settings_options, 'Layout', 'WP_Customize_Control', $layout_options );

	mgs_add_customizer( $wp_customize, 'colors', 'text_color', '#fff', 'Text', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'link_color', '#fff', 'Link', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'link_hover_color', '#aaa', 'Link hover', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'accent_color', '#ed1c24', 'Accents', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'contrast_color', '#00ff00', 'Contrast', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'subtle_color', '#aaa', 'Subtle', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'border_color', '#ed1c24', 'Borders', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'border_alpha', 'ff', 'Border Alpha 0-ff', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'body_background_color', '#3c3c3c', 'Body Background', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'body_background_alpha', 'ff', 'Body Background Alpha 00-ff', 'WP_Customize_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'error_color', '#ed1c24', 'Error Color', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'warning_color', '#ffff22', 'Warning Color', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'colors', 'success_color', '#00ff00', 'Success Color', 'WP_Customize_Color_Control' );

	mgs_add_customizer( $wp_customize, 'header', 'header_background_color', '#191919', 'Header Background', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'header', 'header_background_alpha', 'ff', 'Header Background Alpha 00-ff', 'WP_Customize_Control' );
	mgs_add_customizer( $wp_customize, 'header', 'header_border_color', '#ed1c24', 'Header Border', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'header', 'header_border_alpha', 'ff', 'Header Border Alpha 00-ff', 'WP_Customize_Control' );
	mgs_add_customizer( $wp_customize, 'header', 'menu_layout_id', $menu_layout_settings_options, 'Menu Layout', 'WP_Customize_Control', $menu_layout_options );
	mgs_add_customizer( $wp_customize, 'header', 'header_link_color', '#fff', 'Header Links', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'header', 'header_link_hover_color', '#aaa', 'Header Links Hover', 'WP_Customize_Color_Control' );

	mgs_add_customizer( $wp_customize, 'footer', 'footer_background_color', '#191919', 'Footer Background', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'footer', 'footer_background_alpha', 'ff', 'Footer Background Alpha 00-ff', 'WP_Customize_Control' );
	mgs_add_customizer( $wp_customize, 'footer', 'footer_border_color', '#ed1c24', 'Footer Border', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'footer', 'footer_border_alpha', 'ff', 'Footer Border Alpha 00-ff', 'WP_Customize_Control' );
	mgs_add_customizer( $wp_customize, 'footer', 'footer_link_color', '#fff', 'Footer Links', 'WP_Customize_Color_Control' );
	mgs_add_customizer( $wp_customize, 'footer', 'footer_link_hover_color', '#aaa', 'Footer Links Hover', 'WP_Customize_Color_Control' );
}
