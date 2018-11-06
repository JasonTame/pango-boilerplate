<?php
if (!defined('ABSPATH')) {
	exit;
} // End if().

/**
 * Responsible for loading the Pango plugin and setting up the Main WordPress hooks.
 *
 * @package Core
 * @author Pango
 * @since 1.0.0
 */
class Pango_Main
{

	/**
	 * @var string
	 * Reference to the main plugin file name
	 */
	private $main_plugin_file_name;

	/**
	 * @var Pango_Main $_instance to the the main and only instance of the Pango class.
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * Main reference to the plugins current version
	 */
	public $version;

	/**
	 * Public token, referencing for the text domain.
	 */
	public $token = 'woothemes-pango';

	/**
	 * Plugin url and path for use when access resources.
	 */
	public $plugin_url;
	public $plugin_path;
	public $template_url;

	/**
	 * @var Pango_PostTypes
	 * All Pango sub classes.
	 */
	public $post_types;

	/**
	 * @var Pango_Settings
	 */
	public $settings;

	/**
	 * Constructor method.
	 *
	 * @param  string $file The base file of the plugin.
	 * @since  1.0.0
	 */
	private function __construct($main_plugin_file_name, $args)
	{

		// Setup object data
		$this->main_plugin_file_name = $main_plugin_file_name;
		$this->plugin_url = trailingslashit(plugins_url('', $plugin = $this->main_plugin_file_name));
		$this->plugin_path = trailingslashit(dirname($this->main_plugin_file_name));
		$this->template_url = apply_filters('pango_template_url', 'pango/');
		$this->version = isset($args['version']) ? $args['version'] : null;

		// Initialize the core functionality
		$this->init();

		// Run this on activation.
		register_activation_hook($this->main_plugin_file_name, array($this, 'activation'));


	} // End __construct()

	/**
	 * Load the foundations of Pango.
	 *
	 * @since 1.0.0
	 */
	protected function init()
	{


		$this->initialize_global_objects();

	}

	/**
	 * Global Pango Instance
	 *
	 * Ensure that only one instance of the main Pango class can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see WC()
	 * @return Pango_Main Instance.
	 */
	public static function instance($args)
	{

		if (is_null(self::$_instance)) {


			// A reference to the main Pango plugin file is required
			$pango_main_plugin_file = dirname(dirname(__FILE__)) . '/pango.php';

			self::$_instance = new self($pango_main_plugin_file, $args);

		}

		return self::$_instance;

	} // end instance()

	/**
	 * This function is linked into the activation
	 * hook to reset flush the urls to ensure Pango post types show up.
	 *
	 * @since 1.0.0
	 *
	 * @param $plugin
	 */
	public static function activation_flush_rules($plugin)
	{

		if (strpos($plugin, '/pango.php') > 0) {

			flush_rewrite_rules(true);

		}

	}

	/**
	 * Load the properties for the main Pango object
	 *
	 * @since 1.0.0
	 */
	public function initialize_global_objects()
	{

        // Differentiate between administration and frontend logic.
		if (is_admin()) {

            // Set up admin specific classes
			$this->admin = new Pango_Admin();

		} else {

            // Load Frontend Class
			$this->frontend = new Pango_Frontend();


		}
	}

	/**
	 * Initialize all Pango hooks
	 *
	 * @since 1.0.0
	 */
	public function load_hooks()
	{

	}

	/**
	 * Determine the relative path to the plugin's directory.
	 *
	 * @access public
	 * @since  1.0.0
	 * @return string $pango_plugin_path
	 */
	public function plugin_path()
	{

		if ($this->plugin_path) {

			$pango_plugin_path = $this->plugin_path;

		} else {

			$pango_plugin_path = plugin_dir_path(__FILE__);

		}

		return $pango_plugin_path;

	} // End plugin_path()



} // End Pango_Main Class