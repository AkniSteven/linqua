<?php

namespace IlinquaTest\Model;

use IlinquaTest\Model\Abstractions\AdminPages;

class TestConfigPage extends AdminPages
{
    const TEMLATES_PATH = 'page-templates/';

    protected $_templateDir;

    public function __construct()
    {
        parent::__construct();
        $this->_templateDir = plugin_dir_path(__DIR__) . self::TEMLATES_PATH;
    }

    public function addAdminPage()
    {
        add_menu_page(
            __('Test config page'),
            __('Test config page'),
            'manage_options',
            'test_config_page',
            [&$this, 'displaySettingsPage']
        );
    }
    public function registerSettings()
    {
        register_setting(
            'test-config', 'test-config'
        );
    }
    /**
     * Method to display settings page
     *
     * @return bool
     */
    public function displaySettingsPage()
    {
        try {
            $error = __('You have some problems with template');
            $path = $this->_templateDir . 'config.php';
            if (!file_exists($path)) {
                throw new \Exception($error);
            }
            $content = require ($path);
            if ($content !='') {
                echo $content;
                return true;
            }
            throw new \Exception($error);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

}