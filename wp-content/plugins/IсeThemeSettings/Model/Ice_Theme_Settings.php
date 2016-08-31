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
    private $plugin_dir;
    private $page;

    /**
     * Construct
     *
     * @since 1.0
     */
    public function __construct() {
          $this->set_dir();
          add_action( 'admin_menu', array( &$this, 'add_pages' ) );
          add_action( 'admin_init', array( &$this, 'register_settings' ) );
    }

    /**
     * @param $page
     * page setter
     */
    public function set_page($page){
        $this->page = $page;
    }

    /**
     * plugin dir setter
     */
    public function set_dir(){
        $this->plugin_dir = plugins_url() .'/IсeThemeSettings/';
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
     * this add scripts
     */
    public function scripts() {
            wp_enqueue_media();
            wp_enqueue_script('upload-script',$this->plugin_dir . '/views/public/js/upload.js');
            wp_enqueue_script('fields-script',$this->plugin_dir . '/views/public/js/fields.js');
            wp_enqueue_script('jquery-tinymce-script',$this->plugin_dir . '/views/public/js/tinymce/jquery.tinymce.min.js');
            wp_enqueue_script('tinymce-script',$this->plugin_dir . '/views/public/js/tinymce/tinymce.min.js');
            wp_enqueue_script('tinymce-theme-script',$this->plugin_dir . '/views/public/js/theme_options_tinymce.js');
            wp_enqueue_script('maskedinput',$this->plugin_dir . '/views/public/js/jquery.maskedinput.js');
            wp_enqueue_script('theme_mask-script',$this->plugin_dir . '/views/public/js/theme_options_masks.js');
    }

    /**
     * this add styles
     */
    public function styles() {
            wp_register_style( 'ice-theme-settings', $this->plugin_dir . '/views/public/css/ice_theme_settings.css' );
            wp_enqueue_style(  'ice-theme-settings' );
    }

    /**
     * this register settings
     */
    public function register_settings() {
        register_setting( 'ice-theme-settings', 'ice-theme-settings');
    }

    /**
     * display page
     * return $this->page and print it
     */
    public function display_page()
    {
        echo '<form method="post" action="options.php" class="settings-form">';

        settings_fields( 'ice-theme-settings' );
        echo $this->page;
        echo '</form>';

        return $this->page;

    }

}