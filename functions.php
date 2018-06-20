<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php') ) . '</a></p></div>';
	});

	add_filter('template_include', function($template) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

Timber::$dirname = array('templates', 'views');

class StarterSite extends TimberSite {

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
		  register_nav_menu( 'header', __( 'Primary Menu', 'avatami-com' ) );
		  register_nav_menu( 'footer', __( 'Footer Menu', 'avatami-com' ) );
		});

		add_theme_support( 'custom-logo', array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

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

	// function myfoo( $text ) {
	// 	$text .= ' bar!';
	// 	return $text;
	// }

	function add_to_twig( $twig ) {
		/* this is where you can add your own functions to twig */
		// $twig->addExtension( new Twig_Extension_StringLoader() );
		// $twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

new StarterSite();
