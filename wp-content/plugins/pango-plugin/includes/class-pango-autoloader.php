<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // security check, don't load file outside WP
}

class Pango_Autoloader_Bundle {
    /**
     * @var $include_path. Path to the includes directory within the Pango plugin.
     */
    private $include_path = 'includes';
    private $bundle_identifier = 'pango';

    /**
     * Pango_Autoloader_Bundle constructor.
     * @param string $bundle_identifier
     * @param string $namespace_path path relative to includes
     */
    public function __construct( $bundle_identifier = 'pango', $bundle_identifier_path = '' ) {
        $this->bundle_identifier = $bundle_identifier;
        // setup a relative path for the current autoload instance
        $this->include_path = trailingslashit( trailingslashit(untrailingslashit(dirname(__FILE__))) . $bundle_identifier_path );
    }

    private function format_namespace() {
        return strtolower( $this->bundle_identifier );
    }

    /**
     * @param $class string
     * @return bool
     */
    public function load_class( $class ) {

        if( ! is_numeric( strpos ( strtolower( $class ), $this->format_namespace() ) ) ) {
            return false;
        }

        // check for file in the main includes directory
        $class_file_path = $this->include_path . 'class-'.str_replace( '_','-', strtolower( $class ) ) . '.php';
        if( file_exists( $class_file_path ) ){

            require_once( $class_file_path );
            return true;
        }

        return false;

    }// end autoload
}

/**
 * Loading all class files within the Pango/includes directory
 *
 * The auto loader class listens for calls to classes within the Pango plugin and loads
 * the file containing the class.
 *
 * @package Core
 * @since 1.9.0
 */
class Pango_Autoloader {

    /**
     * @var $include_path. Path to the includes directory within Pango.
     */
    private $include_path = 'includes';

    /**
     * @var array $class_file_map. List of classes mapped to their files
     */
    private $class_file_map = array();

    private $autoloader_bundles = array();

    /**
     * Constructor
     * @since 1.9.0
     */
    public function __construct(){

        // make sure we do not override an existing autoload function
        if( function_exists('__autoload') ){
           spl_autoload_register( '__autoload' );
        }

        // setup a relative path for the current autoload instance
        $this->include_path = trailingslashit( untrailingslashit( dirname( __FILE__ ) ) );

        //setup the class file map
        $this->initialize_class_file_map();


        $this->autoloader_bundles = array(
            new Pango_Autoloader_Bundle( 'Pango'              , ''              )
        );

        // add Pango custom auto loader
        spl_autoload_register( array( $this, 'autoload' )  );

    }

    /**
     * Generate a list of Pango classes and map them the their respective
     * files within the includes directory
     *
     * @since 1.9.0
     */
    public function initialize_class_file_map(){

        $this->class_file_map = array(

            /**
             * Main Pango class
             */
            'Pango_Main' => 'class-pango.php'

        );
    }

    /**
     * Autoload all Pango files as the class names are used.
     */
    public function autoload( $class ){

        // only handle classes with the word `Pango` in it
        if( ! is_numeric( strpos ( strtolower( $class ), 'pango') ) ){

            return;

        }

        // exit if we didn't provide mapping for this class
        if( isset( $this->class_file_map[ $class ] ) ){

            $file_location = $this->include_path . $this->class_file_map[ $class ];
            require_once( $file_location);
            return;

        }

        foreach ($this->autoloader_bundles as $bundle ) {
            if (true === $bundle->load_class( $class ) ) {
                return;
            }
        }

        return;

    }// end autoload

}
