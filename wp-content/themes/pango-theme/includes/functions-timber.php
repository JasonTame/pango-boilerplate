<?php

/**
 * Add Timber functionality to the boilerplate
 *
 * Author: Pango
 */


if (!class_exists('Timber')) {
    add_action('admin_notices', function () {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
    });

    return;
}

// Add General Options Page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Pango Global Options',
        'menu_title' => 'Pango Options',
        'menu_slug' => 'pango-options',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}


Timber::$dirname = array('templates', 'views');


class PangoSite extends TimberSite
{

    function __construct()
    {
        add_theme_support('post-formats');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
        add_filter('timber_context', array($this, 'add_to_context'));
        add_filter('get_twig', array($this, 'add_to_twig'));

        parent::__construct();
    }




    function add_to_context($context)
    {

        //Add global context here

        return $context;
    }

    function add_to_twig($twig)
    {
		/* this is where you can add your own functions to twig */
		//$twig->addExtension( new Twig_Extension_StringLoader() );
		//$twig->addFilter('myfoo', new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
        return $twig;
    }

}

new PangoSite();