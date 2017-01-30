<?php
namespace IceThemeSettings\Model;

class Ice_Theme_Settings
{
    private $_pluginDir;
    private $_page;

    /**
     * Construct
     *
     * @since 1.0
     */
    public function __construct()
    {
          $this->set_dir();
          add_action('admin_menu', [ &$this, 'add_pages' ]);
          add_action('admin_init', [ &$this, 'register_settings' ]);
    }

    /**
     * @param $page
     * page setter
     */
    public function set_page($page)
    {
        $this->_page = $page;
    }

    /**
     * plugin dir setter
     */
    public function set_dir()
    {
        $this->_pluginDir = plugins_url() .'/IсeThemeSettings/';
    }

    /**
     * Add options page
     *
     * @since 1.0
     */
    public function add_pages()
    {
        $admin_page = add_theme_page(
            __('Theme Settings'), 
            __('Theme Settings'),
            'manage_options',
            'ice-theme-settings',
            [&$this, 'display_page']);
        add_action('admin_print_scripts-' . $admin_page, [&$this, 'scripts' ]);
        add_action('admin_print_styles-' . $admin_page, [&$this, 'styles']);
    }

    /**
     * this add scripts
     */
    public function scripts()
    {
            wp_enqueue_media();
            wp_enqueue_script(
                'upload-script', $this->_pluginDir .
                '/views/public/js/upload.js'
            );
            wp_enqueue_script('fields-script',$this->_pluginDir . '/views/public/js/fields.js');
            wp_enqueue_script('jquery-tinymce-script',$this->_pluginDir . '/views/public/js/tinymce/jquery.tinymce.min.js');
            wp_enqueue_script('tinymce-script',$this->_pluginDir . '/views/public/js/tinymce/tinymce.min.js');
            wp_enqueue_script('tinymce-theme-script',$this->_pluginDir . '/views/public/js/theme_options_tinymce.js');
            wp_enqueue_script('maskedinput',$this->_pluginDir . '/views/public/js/jquery.maskedinput.js');
            wp_enqueue_script('theme_mask-script',$this->_pluginDir . '/views/public/js/theme_options_masks.js');
    }

    /**
     * this add styles
     */
    public function styles() {
            wp_register_style( 'ice-theme-settings', $this->_pluginDir . '/views/public/css/ice_theme_settings.css' );
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
        echo $this->_page;
        echo '</form>';

        return $this->_page;

    }

}