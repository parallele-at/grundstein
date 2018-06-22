<?php
/**
 * The template for displaying pages.
 *
 * @package  Magic-Grundstein
 * @since   0.0.1
 */

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );
