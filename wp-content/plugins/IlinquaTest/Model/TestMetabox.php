<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 09.10.16
 * Time: 12:43
 */

namespace IlinquaTest\Model;


class TestMetabox extends Metabox
{
    public function __construct($type,$title)
    {
        parent::__construct($type, $title);
        add_action('admin_enqueue_scripts', [&$this, 'set_ajax_scripts']);

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
    
    /**
     * add Metabox title
     */
    public function add()
    {
        add_meta_box(
            $this->_metaboxTitle,
            'Test  Settings',
            [$this, 'display'],
            $this->_metaboxPostType
        );

    }

    
    public function getQuestionsTerms()
    {
        $terms = get_terms();
        
        foreach ($terms as $key => $term) {
            if ($term->taxonomy != 'test_questions' || $term->count < 1 ) {
                    unset($terms[$key]);
            }
        }
        return $terms;
    }
    
    /**
     * save meta
     */
    public function save()
    {
        parent::save();
        $questionId = $_POST['ID'];
        if (isset($_POST['questions_category'])) {
            update_post_meta(
                $questionId, 'questions_category', $_POST['questions_category']
            );
        }
        if (isset($_POST['test_steps'])) {
            update_post_meta(
                $questionId, 'test_steps', $_POST['test_steps']
            );
        }

    }

}