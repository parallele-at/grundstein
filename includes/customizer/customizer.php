<?php

function mgs_slug_sanitize_radio( $input, $setting ) {
    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);
    //get the list of possible radio box options
    $choices = $setting->manager->get_control( $setting->id )->choices;
    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function mgs_add_customizer_section($wp_customize, $name, $label, $priority = 30) {
	$wp_customize->add_section( $name , array(
    'title'      => esc_html__($label, 'magic-grundstein'),
    'priority'   => $priority,
	) );
}

function mgs_add_customizer($wp_customize, $section, $name, $default, $label, $control, $opts = [], $sanitize = 'sanitize_hex_color') {
  $setting_options = array(
		'transport' => 'refresh',
  );
  if ( is_array($default) ) {
    $setting_options = array_merge($setting_options, $default);
  } else {
    $setting_options = array_merge($setting_options, array(
      'default' => $default,
      'sanitize' => $sanitize,
    ));
  }

  $wp_customize->add_setting( $name, $setting_options );

  $def_opts = array(
    'section' => $section,
    'label' => esc_html__($label, 'magic-grundstein'),
    'settings' => $name,
  );

	$options = array_merge($def_opts, $opts);

  $wp_customize->add_control( new $control( $wp_customize, $name, $options) );
}

function mgs_customize_register( $wp_customize ) {
	mgs_add_customizer_section( $wp_customize, 'layout', 'Layout', 20 );
	mgs_add_customizer_section( $wp_customize, 'header', 'Header' );
	mgs_add_customizer_section( $wp_customize, 'footer', 'Footer', 40 );

  $layout_settings_options = array(
    'sanitize' => 'mgs_slug_sanitize_radio',
    'default' => 'classic',
  );

  $layout_options = array(
    'type' => 'radio',
    'choices' => array(
      '1' => 'Classic',
      '2' => '2 Column',
      '3' => '3 Column',
    ),
  );

  $menu_layout_settings_options = array(
    'sanitize' => 'mgs_slug_sanitize_radio',
    'default' => '1',
  );
  $menu_layout_options = array(
    'type' => 'radio',
    'choices' => array(
      '1' => 'Classic',
      '2' => 'Centered',
    ),
  );

  mgs_add_customizer($wp_customize, 'layout', 'layout_id', $layout_settings_options, 'Layout', 'WP_Customize_Control', $layout_options );

	mgs_add_customizer($wp_customize, 'colors', 'text_color', '#fff', 'Text', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'colors', 'link_color', '#fff', 'Link', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'colors', 'link_hover_color', '#aaa', 'Link hover', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'colors', 'accent_color', '#ed1c24', 'Accents', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'colors', 'contrast_color', '#00ff00', 'Contrast', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'colors', 'subtle_color', '#aaa', 'Subtle', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'colors', 'border_color', '#ed1c24', 'Borders', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'colors', 'body_background_color', '#3c3c3c', 'Body Background', 'WP_Customize_Color_Control');

	mgs_add_customizer($wp_customize, 'header', 'header_background_color', '#191919', 'Header Background', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'header', 'header_border_color', '#ed1c24', 'Header Border', 'WP_Customize_Color_Control');
  mgs_add_customizer($wp_customize, 'header', 'menu_layout_id', $menu_layout_settings_options, 'Menu Layout', 'WP_Customize_Control', $menu_layout_options );
	mgs_add_customizer($wp_customize, 'header', 'header_link_color', '#fff', 'Header Links', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'header', 'header_link_hover_color', '#aaa', 'Header Links Hover', 'WP_Customize_Color_Control');

	mgs_add_customizer($wp_customize, 'footer', 'footer_background_color', '#191919', 'Footer Background', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'footer', 'footer_border_color', '#ed1c24', 'Footer Border', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'footer', 'footer_link_color', '#fff', 'Footer Links', 'WP_Customize_Color_Control');
	mgs_add_customizer($wp_customize, 'footer', 'footer_link_hover_color', '#aaa', 'Footer Links Hover', 'WP_Customize_Color_Control');
}


if (class_exists('WPLessPlugin')) {
	$less = WPLessPlugin::getInstance();

  $attr_names = array (
    'layout_id' => '1',
    'menu_layout_id' => '1',

    'header_background_color' => '#191919',
    'header_border_color' => '#ed1c24',
    'header_link_color' => '#fff',
    'header_link_color_hover' => '#aaa',
    'header_text_color' => '#fff',

    'footer_background_color' => '#191919',
    'footer_border_color' => '#ed1c24',
    'footer_link_color' => '#fff',
    'footer_link_color_hover' => '#aaa',
    'footer_text_color' => '#fff',

    'body_background_color' => '#3c3c3c',
    'border_color' => '#ed1c24',
    'accent_color' => '#ed1c24',
    'contrast_color' => '#00ff00',
    'subtle_color' => '#aaa',
    'link_color' => '#fff',
    'link_hover_color' => '#aaa',
    'text_color' => '#fff',
  );

  $colors = [];
  foreach ( $attr_names as $attr_name => $attr_value ) {
    $colors[$attr_name] = get_theme_mod( $attr_name, $attr_value );
  }

	$less->setVariables( $colors );
}
