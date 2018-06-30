<?php
/**
 * The template for displaying pages.
 *
 * @package  Magic-Grundstein
 * @since   0.0.1
 */

$post = new TimberPost();
$context = Timber::get_context();
$context['post'] = $post;

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );
