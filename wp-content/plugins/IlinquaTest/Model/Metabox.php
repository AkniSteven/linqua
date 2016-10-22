<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 11.09.16
 * Time: 20:25
 */

namespace IlinquaTest\Model;

class Metabox
{
    protected $_metabox;
    protected $_metaboxTitle;
    protected $_metaboxPostType;
    protected $_pluginDir;

    public function __construct($type,$title)
    {
        $this->set_dir();
        $this->_metaboxPostType = $type;
        $this->_metaboxTitle = $title;
        add_action('add_meta_boxes', [$this, 'add']);
        add_action('save_post', [&$this, 'save'], 10, 2);
    }

    /**
     * @param $metabox
     * metabox setter
     */
    public function set_view($metabox)
    {
        $this->_metabox = $metabox;
    }

    /**
     * plugin dir setter
     */
    public function set_dir()
    {
        $this->_pluginDir = plugins_url() .'/IlinquaTest/';
    }

    /**
     * this add script in admin
     */
    public function set_ajax_scripts()
    {
        wp_enqueue_script(
            'test_ajax', $this->_pluginDir .
            '/views/public/js/test.js'
        );
    }

    public function add()
    {
        add_meta_box(
            $this->_metaboxTitle,
            'Settings',
            [$this, 'display'],
            $this->_metaboxPostType
        );

    }

    /**
     * display meta
     * @return mixed
     */
    public function display()
    {
        echo $this->_metabox;

        return $this->_metabox;
    }

    public function save()
    {

    }
}