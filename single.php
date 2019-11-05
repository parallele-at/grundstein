<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
$context['post'] = Timber::query_post();

if ( post_password_required( $context['post']->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 
		'single-' . $context['post']->ID . '.twig', 
		'single-' . $context['post']->post_type . '.twig', 'single-' . $context['post']->slug . '.twig', 'single.twig' 
	), $context );
}
