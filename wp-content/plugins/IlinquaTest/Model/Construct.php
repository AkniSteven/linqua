<?php

/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 22.08.16
 * Time: 22:46
 */
namespace IlinquaTest\Model;

class Construct
{
    public $config;

    protected $_configPage;

    public function __construct()
    {
        add_action(
            'plugins_loaded', [$this, 'PageTemplates']
        );
        add_action('admin_menu', [ &$this, 'add_test_page' ]);
        add_action('init', [$this, 'create_plugin_table']);
        add_action('init', [$this, 'registerTaxType']);
        add_action('init', [$this, 'registerPostType']);
        add_action('init', [$this, 'initConfigPage']);
        add_filter ('manage_test_question_posts_columns', [
            $this,
            'addLevelColumn'
        ]);
        add_action (
            'manage_test_question_posts_custom_column',
            [$this,
            'setLevelColumnValue'],
            10, 2);

    }

    public function initConfigPage()
    {
        $this->_configPage = new TestConfigPage();
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * This method need for use $this,
     * for default php functions.
     */
    public function __call($name, $arguments)
    {
        if (function_exists($name)) {
            return call_user_func_array($name, $arguments);
        }
        return false;
    }

    /**
     * @param $columns
     * @return mixed
     */
    public function addLevelColumn($columns)
    {
        $columns['level'] = __('Level');
        return $columns;
    }

    /**
     * @param $column
     * @param $post_id
     * @return mixed
     */
    public function setLevelColumnValue($column, $post_id)
    {
        if ($column == 'level') {
            echo get_post_meta($post_id, 'question_level', true );
        }
    }

    /**
     * create plugin table
     */
    public function create_plugin_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'test';
        $charsetCollate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $sql = "CREATE TABLE " . $table_name . " (
              id int NOT NULL AUTO_INCREMENT,
              name text NOT NULL,
              phone text NOT NULL,
              email text NOT NULL,
              status text NOT NULL,
              info text NOT NULL,
              test text NOT NULL,
              score int default 0,
              date  datetime NOT NULL,
              UNIQUE KEY id (id)
            ){$charsetCollate};";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    /**
     * This add only the test page (
     */
    public function add_test_page()
    {
        add_menu_page(
            'Test page',
            'Test page',
            'read',
            'test_page',
            [$this, 'display_test_page']
        );

    }
    /**
     * This display only test page
     */
    public function display_test_page()
    {
        require_once TEMPLATE_PATH_TEST . '/page-templates/admin_test_page.php';

    }

    /**
     * @param $file
     * @param string $dir
     * @return array|mixed|object
     */
    public function getConfig($file, $dir ='')
    {

        if ($dir !='') {
            $file = TEMPLATE_PATH_TEST . $dir .'/' . $file . '.json';
        } else {
            $file = TEMPLATE_PATH_TEST . '/config/'  . $file . '.json';
        }
        if (file_exists($file)) {
            $this->config = json_decode(file_get_contents($file), true);
        } else {
            $this->config = array();
        }
        return $this->config;
    }

    /**
     * Register custom tax
     */
    public function registerTaxType()
    {
        $tax = $this->getConfig('tax');

        foreach ($tax as $key => $item) {
            $item['args']['labels'] = $item['labels'];
            $this->register_taxonomy($key, $item['post_type'], $item['args']);
        }

    }

    /**
     * Register custom post types
     */
    public function registerPostType()
    {
        $posts = $this->getConfig('posts');
        foreach ($posts as $key => $item) {
            $item['args']['labels'] = $item['labels'];
            $this->register_post_type($key, $item['args']);
        }
    }

    /**
     * Register page templates
     */
    public function PageTemplates()
    {
        $pageTemplates = $this->getConfig('page_templates');
        if (!empty($pageTemplates)) {
            new Tempalte_Constructor($pageTemplates);
        }
    }
}