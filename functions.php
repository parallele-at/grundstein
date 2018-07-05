<?php

/**
 * @package  Magic-Grundstein
 * @since   0.0.1
 */

require_once( get_template_directory() . '/includes/plugin-activation/requirements.php' );
require_once( get_template_directory() . '/includes/customizer/customizer.php' );
require_once( get_template_directory() . '/includes/password-hashing.php' );
require_once( get_template_directory() . '/includes/post-form-login.php' );

require_once(__DIR__ . '/vendor/autoload.php');

if ( !class_exists('Timber') ) {
	return;
}

Timber::$dirname = array('templates', 'views');

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

		add_action( 'customize_register', 'mgs_customize_register' );

		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['header_menu'] = new TimberMenu('header');
		$context['footer_menu'] = new TimberMenu('footer');

	  $custom_logo_id = get_theme_mod( 'custom_logo' );
	  $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		$context['logo'] = $image[0];

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
