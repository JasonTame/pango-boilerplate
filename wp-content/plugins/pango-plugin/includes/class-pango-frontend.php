<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Pango Frontend Class
 *
 * All functionality pertaining to the frontend.
 *
 * @package Core
 * @author Pango
 *
 * @since 1.0.0
 */
class Pango_Frontend
{

	/**
	 * Constructor.
	 * @since  1.0.0
	 */
	public function __construct()
	{

		// Scripts and Styles
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

	} // End __construct()


	/**
	 * Enqueue front end JavaScript files.
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_scripts()
	{


	} // End enqueue_scripts()

} // End Pango_Frontend Class
