<?php
/**
*Template Name: Home Page Template
 *
 * @package Pango
 */


if ( class_exists( 'Timber' ) ) {

    $context = Timber::get_context();
    $post = new TimberPost();
    $context['post'] = $post;
    $user = new TimberUser();

    Timber::render(array('template-home.twig', 'page.twig'), $context);

}