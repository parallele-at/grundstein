<?php
/**
 * The template for displaying Author Archive pages
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  Magic-Grundstein
 * @since   0.0.1
 */

global $wp_query;

$context          = Timber::get_context();
$context['posts'] = new Timber\PostQuery();

if ( isset( $wp_query->query_vars['author'] ) ) {
	$author            = new Timber\User( $wp_query->query_vars['author'] );

	if ( current_user_can( 'create_sites' ) ) {
		$logged_in_role = 'administrator';
		$is_admin = true;
	} else if ( current_user_can( 'activate_plugins' ) ) {
		$logged_in_role = 'administrator';
		$is_admin = true;
	} else if ( current_user_can( 'delete_other_pages' ) ) {
		$logged_in_role = 'editor';
	} else if ( current_user_can( 'publish_posts' ) ) {
		$logged_in_role = 'author';
	} else if ( current_user_can( 'delete_posts' ) ) {
		$logged_in_role = 'contributor';
	} else if ( current_user_can( 'read') ) {
		$logged_in_role = 'subscriber';
	} else {
		$logged_in_role = 'unknown';
	}

	if ( user_can( $author->ID, 'create_sites' ) ) {
		$role = 'superadmin';
		$show = false;
	} else if ( user_can( $author->ID, 'activate_plugins' ) ) {
		$role = 'administrator';
		$show = false;
	} else if ( user_can( $author->ID, 'delete_other_pages' ) ) {
		$role = 'editor';
		$show = true;
	} else if ( user_can( $author->ID, 'publish_posts' ) ) {
		$role = 'author';
		$show = true;
	} else if ( user_can( $author->ID, 'delete_posts' ) ) {
		$role = 'contributor';
		$show = true;
	} else if ( user_can( $author->ID, 'read') ) {
		$role = 'subscriber';
		$show = false;
	} else {
		$role = 'unknown';
		$show = false;
	}

	if ($show) {
		$context['author'] = $author;
		$context['title']  = 'Author Archives: ' . $author->name();
	} else {
		status_header( 404 );
		Timber::render( '404.twig', $context );
		return;
	}
}

Timber::render( array( 'author.twig', 'archive.twig' ), $context );
