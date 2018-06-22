<?php
/**
 * @package  Magic-Grundstein
 * @since   0.0.1
 */

$context = Timber::get_context();
$context['posts'] = new Timber\PostQuery();

$templates = array( 'index.twig' );

if ( is_home() ) {
	array_unshift( $templates, 'home.twig' );
}

Timber::render( $templates, $context );
