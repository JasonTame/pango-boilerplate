<?php

/**
 * Pango Boilerplate functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pango
 */


// Set up constant variable to control JS & CSS versioning
// This version number must be changed whenever pushing to stable branch
const PANGO_VER = 0.11;


/**
 * Enqueue scripts and styles.
 */
function pango_scripts()
{

    // Include all vendor assets
    wp_enqueue_style('vendors-style', get_template_directory_uri() . '/css/vendors-styles.min.css', array(), PANGO_VER);
    wp_enqueue_script('vendors-script', get_template_directory_uri() . '/js/vendors.min.js', array('jquery'), PANGO_VER, true);

	// Include global assets
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/css/theme-styles.min.css', array(), PANGO_VER);
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/js/theme.min.js', array('jquery'), PANGO_VER, true);

}
add_action('wp_enqueue_scripts', 'pango_scripts');


/**
 * Load Timber compatibility file.
 */
require get_template_directory() . '/includes/functions-timber.php';