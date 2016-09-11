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

    public function __construct($type,$title)
    {
        $this->_metaboxPostType = $type;
        $this->_metaboxTitle = $title;

        add_action('add_meta_boxes', array($this, 'add'));
    }

    /**
     * @param $metabox
     * metabox setter
     */
    public function set_view($metabox)
    {
        $this->_metabox = $metabox;
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