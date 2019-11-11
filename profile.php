<?php
/**
 * The template for displaying pages.
 *
 * @package  Magic-Grundstein
 * @since   0.0.1
 */

$timber_post     = new TimberPost();
$context         = Timber::get_context();
$context['post'] = $timber_post;

Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );
