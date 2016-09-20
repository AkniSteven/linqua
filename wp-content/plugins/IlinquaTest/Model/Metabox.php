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
    private $_metabox;
    private $_metaboxTitle;
    private $_metaboxPostType;
    private $_pluginDir;

    public function __construct($type,$title)
    {
        $this->set_dir();
        $this->_metaboxPostType = $type;
        $this->_metaboxTitle = $title;

        add_action('add_meta_boxes', [$this, 'add']);
        add_action('admin_enqueue_scripts', [&$this, 'set_ajax_scripts']);
        add_action(
            'wp_ajax_createAnswerFields',
            [&$this,'createAnswerFields']
        );
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
            'Test Settings',
            [$this, 'display'],
            $this->_metaboxPostType
        );

    }

    public function display()
    {
        echo $this->_metabox;

        return $this->_metabox;
    }

    public function createAnswerFields()
    {
        $html = '';
        $counter = $_POST['counter'];
        $postId = $_POST['post_id'];
        if ($counter !='' && $postId !='') {
            for ($i = 0; $i < $counter; $i++) {
                $html.=$i;
            }
            echo $html;
        }
        return 1;
    }

    public function save()
    {

        /* This is where the save functionality goes.
         *
         * It should check to make sure the current user has permission
         * to save, and then should update whatever information - such as post meta -
         * that's relevant to the current post and the data presented in the meta box,
         * if any.
         */
    }
}