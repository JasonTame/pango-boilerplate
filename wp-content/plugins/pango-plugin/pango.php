<?php
/*
 * Plugin Name: Pango
 * Version: 1.0.00
 * Plugin URI: https://fundawande.rog
 * Description: Boilerplate Pango Plugin
 * Author: Pango
 * Author URI: http://pango.studio
 * Requires at least: 3.5
 * Tested up to: 4.4
 * @package WordPress
 * @author Pango
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Returns the global Pango Instance.
 *
 * @since 1.8.0
 */
function Pango() {
    return Pango_Main::instance( array( 'version' => '3.2.00' ) );
}

// Get active theme
$theme = wp_get_theme();

// If the active theme is Pango then initalise the plugin
if ($theme->slug = 'pango') {

    function init_autoloader() {
        require_once( 'includes/class-pango-autoloader.php' );
        new Pango_Autoloader();
    }

    // Load auto loader to add include all includes class files
    init_autoloader();

    // Run global Pango instance
    Pango();
}

