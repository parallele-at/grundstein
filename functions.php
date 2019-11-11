<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package Grundstein
 * @since  0.0.1
 */

/**
 * Require the WordPress admin customizer fields
 *
 * @since 0.0.1
 */
if ( is_admin() ) {
	require_once get_template_directory() . '/includes/customizer/customizer.php';
}

/**
 * Require the Timber\Site configuration Class
 *
 * @since 0.0.1
 */
require_once get_template_directory() . '/includes/class-magic-grundstein.php';

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

new Magic_Grundstein();
