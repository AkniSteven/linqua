<?php

/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 27.08.16
 * Time: 17:30
 */
namespace IceThemeSettings\Model;

class Ice_Theme_Settings
{
    private $page;
    /**
     * Construct
     *
     * @since 1.0
     */
    public function __construct() {

        // This will keep track of the checkbox options for the validate_settings function.
//        $this->checkboxes = array();
//        $this->settings = array();
//        $this->get_settings();

//        $this->sections['general']      = __( 'General Settings' );
//        $this->sections['appearance']   = __( 'Appearance' );
//        $this->sections['reset']        = __( 'Reset to Defaults' );
//        $this->sections['about']        = __( 'About' );

          add_action( 'admin_menu', array( &$this, 'add_pages' ) );
//        add_action( 'admin_init', array( &$this, 'register_settings' ) );

//        if ( ! get_option( 'mytheme_options' ) )
//            $this->initialize_settings();

    }

    /**
     * @param $page
     * page setter
     */
    public function set_page($page){
        $this->page = $page;
    }
    
    /**
     * Add options page
     *
     * @since 1.0
     */
    public function add_pages() {
        $admin_page = add_theme_page( __( 'Theme Settings' ), __( 'Theme Settings' ), 'manage_options', 'ice-theme-settings', array( &$this, 'display_page' ) );

        add_action( 'admin_print_scripts-' . $admin_page, array( &$this, 'scripts' ) );
        add_action( 'admin_print_styles-' . $admin_page, array( &$this, 'styles' ) );
    }

    /**
     * @param $page
     * display page
     */
    public function display_page()
    {
        echo $this->page;
        return $this->page;

    }
}