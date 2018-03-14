<?php
/**
 * Template Name: Contact Page
 */

$context = Timber::get_context();

$post = Timber::query_post();
$context['post'] = $post;

Timber::render( 'contact.twig' , $context );
