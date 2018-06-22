<?php

/**
 * @package  Magic-Grundstein
 * @since   0.0.1
 */

require_once get_template_directory() . '/lib/plugin-activation/requirements.php';

if ( ! class_exists( 'Timber' ) ) {
	return;
}

Timber::$dirname = array('templates', 'views');

function add_customizer_section($wp_customize, $name, $label, $priority = 30) {
	$wp_customize->add_section( $name , array(
    'title'      => __($label, 'magic-grundstein'),
    'priority'   => $priority,
	) );
}

function add_customizer($wp_customize, $section, $name, $default, $label) {
	$wp_customize->add_setting( $name, array(
		'default'   => $default,
		'transport' => 'refresh',
		'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, $name, array(
			'section' => $section,
			'label'   => esc_html__($label, 'magic-grundstein'),
		) )
	);
}

class Magic_Grundstein extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );

		add_action( 'after_setup_theme', function() {
		  register_nav_menu( 'header', __( 'Primary Menu', 'magic-grundstein' ) );
		  register_nav_menu( 'footer', __( 'Footer Menu', 'magic-grundstein' ) );
		});

		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		add_action( 'customize_register', array( $this, 'customize_register') );

		add_filter('less_vars', function () {
			return array(
				'header_background_color' => get_theme_mod('header_background_color', '#191919'),
				'header_border_color' => get_theme_mod('header_border_color', '#ed1c24'),
				'header_link_color' => get_theme_mod('header_link_color', '#fff'),
				'header_link_color_hover' => get_theme_mod('header_link_color_hover', '#aaa'),
				'header_text_color' => get_theme_mod('text_color', '#fff'),

				'footer_background_color' => get_theme_mod('footer_background_color', '#191919'),
				'footer_border_color' => get_theme_mod('footer_border_color', '#ed1c24'),
				'footer_link_color' => get_theme_mod('footer_link_color', '#fff'),
				'footer_link_color_hover' => get_theme_mod('footer_link_color_hover', '#aaa'),
				'footer_text_color' => get_theme_mod('text_color', '#fff'),

				'body_background_color' => get_theme_mod('body_background', '#3c3c3c'),
				'border_color' => get_theme_mod('border_color', '#ed1c24'),
				'accent_color' => get_theme_mod('accent_color', '#ed1c24'),
				'subtle_color' => get_theme_mod('subtle_color', '#aaa'),
				'link_color' => get_theme_mod('link_color', '#fff'),
				'link_hover_color' => get_theme_mod('link_hover_color', '#aaa'),
				'text_color' => get_theme_mod('text_color', '#fff'),
			);
		} );

		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function customize_register( $wp_customize ) {
		add_customizer_section( $wp_customize, 'header', 'Header' );
		add_customizer_section( $wp_customize, 'footer', 'Footer' );

		add_customizer($wp_customize, 'colors', 'text_color', '#fff', 'Text');
		add_customizer($wp_customize, 'colors', 'link_color', '#fff', 'Link');
		add_customizer($wp_customize, 'colors', 'link_hover_color', '#aaa', 'Link hover');
		add_customizer($wp_customize, 'colors', 'accent_color', '#ed1c24', 'Accents');
		add_customizer($wp_customize, 'colors', 'subtle_color', '#aaa', 'Subtle');

		add_customizer($wp_customize, 'colors', 'border_color', '#ed1c24', 'Borders');

		add_customizer($wp_customize, 'header', 'header_background_color', '#191919', 'Header Background');
		add_customizer($wp_customize, 'header', 'header_border_color', '#ed1c24', 'Header Border');
		add_customizer($wp_customize, 'header', 'header_link_color', '#fff', 'Header Links');
		add_customizer($wp_customize, 'header', 'header_link_hover_color', '#aaa', 'Header Links Hover');

		add_customizer($wp_customize, 'colors', 'body_background_color', '#3c3c3c', 'Body Background');

		add_customizer($wp_customize, 'footer', 'footer_background_color', '#191919', 'Footer Background');
		add_customizer($wp_customize, 'footer', 'footer_border_color', '#ed1c24', 'Footer Border');
		add_customizer($wp_customize, 'footer', 'footer_link_color', '#fff', 'Footer Links');
		add_customizer($wp_customize, 'footer', 'footer_link_hover_color', '#aaa', 'Footer Links Hover');
  }

	function add_to_context( $context ) {
		$context['header_menu'] = new TimberMenu('header');
		$context['footer_menu'] = new TimberMenu('footer');

		function get_logo() {
		  $custom_logo_id = get_theme_mod( 'custom_logo' );
		  $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		  return $image[0];
		}

		$context['logo'] = get_logo();
		$context['is_admin'] = current_user_can( 'manage_options' );

		$context['site'] = $this;

		return $context;
	}

	function filter_substr( $text, $start, $end ) {
		return substr($text, $start, $end);
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		// $twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter('substr', new Twig_SimpleFilter('substr', array($this, 'filter_substr')));
		return $twig;
	}

}

new Magic_Grundstein();
