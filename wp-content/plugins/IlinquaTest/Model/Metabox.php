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
            'Test Settings',
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

    /**
     * create answer fields
     * @return bool
     */
    public function createAnswerFields()
    {
        $html = '';
        $counter = $_POST['counter'] > 20 ? $counter = 20 :  $_POST['counter'];
        $postId = $_POST['post_id'];
        $answerCases = get_post_meta(
            $postId, 'answer_case', true
        );
        if ($counter !='' && $postId !='') {
            for ($i = 1; $i <= $counter; $i++) {
                $html.= "<div><label for='answer_case'>$i - </label>
                 <input type='text' name='answer_case[". $i . "]'
                  value='$answerCases[$i]'
                  />
                 </div>";
            }
            echo $html;
            wp_die();
        }
        return true;
    }

    /**
     * save meta
     */
    public function save()
    {
        $questionId = $_POST['ID'];
        if (isset($_POST['question_level'])) {
            update_post_meta(
                $questionId, 'question_level', $_POST['question_level']
            );
        }
        if (isset($_POST['question_type'])) {
            update_post_meta(
                $questionId, 'question_type', $_POST['question_type']
            );
        }
        if (isset($_POST['counter'])) {
            update_post_meta(
                $questionId, 'counter', $_POST['counter']
            );
        }
        if (isset($_POST['answer_case'])) {
            update_post_meta(
                $questionId, 'answer_case', $_POST['answer_case']
            );
        }
    }
}