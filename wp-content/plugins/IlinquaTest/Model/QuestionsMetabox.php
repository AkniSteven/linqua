<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 09.10.16
 * Time: 12:27
 */

namespace IlinquaTest\Model;


class QuestionsMetabox extends Metabox
{
    public function __construct($type,$title)
    {
        parent::__construct($type, $title);
        add_action('admin_enqueue_scripts', [&$this, 'set_ajax_scripts']);
        add_action(
            'wp_ajax_createAnswerFields',
            [&$this,'createAnswerFields']
        );
        add_action(
            'wp_ajax_createRightAnswerField',
            [&$this,'createRightAnswerField']
        );
    }


    /**
     * this add script in admin
     */
    public function set_ajax_scripts()
    {
        wp_enqueue_script(
            'questions_ajax', $this->_pluginDir .
            '/views/public/js/questions.js'
        );
    }

    /**
     * add Metabox title
     */
    public function add()
    {
        add_meta_box(
            $this->_metaboxTitle,
            'Test Questions Settings',
            [$this, 'display'],
            $this->_metaboxPostType
        );

    }

    /**
     * create answer fields
     * @return bool
     */
    public function createAnswerFields()
    {
        $html = '';
        $counter = $_POST['counter'] > 20 ? $counter = 20 : $_POST['counter'];
        $postId = $_POST['post_id'];
        $answerCases = get_post_meta(
            $postId, 'answer_case', true
        );
        if ($counter != '') {
            if ($postId != '') {
                for ($i = 1; $i <= $counter; $i++) {
                    $html .= "<div><label for='answer_case'>$i - </label>
                 <input type='text' name='answer_case[" . $i . "]'
                  value='$answerCases[$i]'
                  />
                 </div>";
                }
            } else {
                for ($i = 1; $i <= $counter; $i++) {
                    $html .= "<div><label for='answer_case'>$i - </label>
                 <input type='text' name='answer_case[" . $i . "]'/>
                 </div>";
                }
            }
            echo $html;
            wp_die();
        }
        return true;
    }

    /**
     * create right answer field
     * @return bool
     */
    public function createRightAnswerField()
    {
        $html = '<label for="right_answer">Right answer</label>';
        $counter = $_POST['q_count'] > 20 ? $counter = 20 : $_POST['q_count'];
        $qType = $_POST['q_type'];

        switch ($qType){
            case 'checkbox':
                $html.= "<select name='right_answer[]'
                                 id='right_answer'
                                 multiple='multiple'
                                 size={$counter}>";
                break;
            case 'radio' :
                $html.= "<select name='right_answer'
                                 id='right_answer'
                          >";
                break;

        }
        for ($i = 1; $i <= $counter; $i++) {
            $html .= "<option value='{$i}'>answer $i</option>";
        }
        $html.= "</select>";

        if ($counter != '') {

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
        parent::save();
        $questionId = $_POST['ID'];
        if (isset($_POST['question_score'])) {
            update_post_meta(
                $questionId, 'question_score', $_POST['question_score']
            );
        }
        if (isset($_POST['answer_case'])) {
            update_post_meta(
                $questionId, 'answer_case', $_POST['answer_case']
            );
        }
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
        if (isset($_POST['right_answer'])) {
            update_post_meta(
                $questionId, 'right_answer', $_POST['right_answer']
            );
        }
    }

}