<?php
/**
 * Magic Timber\Site extending configuration for Timber.
 *
 * @package grundstein
 * @since 0.0.1
 */

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 *
 * @since 0.0.1
 */
class Magic_Grundstein extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );

		add_action( 'customize_register', 'mgs_customize_register', PHP_INT_MAX - 1 );

		parent::__construct();
	}

	/** This is where you can register custom post types. */
	public function register_post_types() {

	}

	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	/**
	 * This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['site']        = $this;

		if (is_nav_menu('header')) {
			$context['header_menu'] = new Timber\Menu( 'header' );
		}

		if (is_nav_menu('social')) {
			$context['social_menu']    = new Timber\Menu( 'social' );
			$context['footer_menu'] = new Timber\Menu( 'social' );
		}
		if (is_nav_menu('languages')) {
			$context['languages_menu'] = new Timber\Menu( 'languages' );
		}

		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( ! empty( $custom_logo_id ) ) {
			$image           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
			$context['logo'] = $image[0];
		}

		$context['is_admin'] = current_user_can( 'manage_options' );

		return $context;
	}

	/**
	 * Add theme support hook
	 *
	 * @since 0.0.1
	 */
	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );

		$defaults = array(
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		);
		add_theme_support( 'custom-logo', $defaults );
	}

	/**
	 * Returns a substring of a string
	 *
	 * @param string $text string to get substring from.
	 * @param int    $start value to start substring at.
	 * @param int    $end value to end substring at.

	 * @return string returns substring
	 */
	private function filter_substr( $text, $start, $end ) {
		return substr( $text, $start, $end );
	}

	/**
	 * This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addFilter( 'substr', new Twig\TwigFilter( 'substr', array( $this, 'filter_substr' ) ) );

		return $twig;
	}
}
