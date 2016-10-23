<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 09.10.16
 * Time: 12:43
 */

namespace IlinquaTest\Model;

use IlinquaTest\Helper\Data;

class TestMetabox extends Metabox
{
    /**
     * It`s current post data
     * @var $_testData
     */
    private $_testData;

    /**
     * It`s using for configs
     * @var $config
     */
    public $config;

    public function __construct($type,$title)
    {
        parent::__construct($type, $title);

        add_action('admin_enqueue_scripts', [&$this, 'set_ajax_scripts']);
        add_action(
            'wp_ajax_createQuestionsFields',
            [&$this,'createQuestionsFields']
        );

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
     * @param $qType
     * @return array
     */
    public function getFormateQuestions($qType)
    {
        $questions = [];
        $questionsConfig = $this->getConfig('show')['questions'];
        if ($questionsConfig !='') {
            if ($qType !='') {
                $questionsConfig['tax_query'][] =
                    [
                        "taxonomy" => "test_questions",
                        "field" => "term_id",
                        "terms" => $qType
                    ];
            }
            $allQuestions = get_posts($questionsConfig);
            if (!empty($allQuestions)) {
                foreach ($allQuestions as $question) {
                    $questionMeta = get_post_meta($question->ID);
                    $qType  =  $questionMeta ['question_type'][0];
                    $qLevel = $questionMeta ['question_level'][0];
                    if ($qType !='' && $qLevel !='') {
                        $question->qMeta = $questionMeta;
                        if ($qType =='text') {
                            $questions[$qLevel][$qType][] = $question;
                        } else {
                            $questions[$qLevel]['others'][] = $question;
                        }

                    }

                }
            }
        }
        return $questions;
    }

    /**
     * @param $questions
     * @param $i
     * @return string
     * Create text Question fields for test
     */
    private function createQuestionsTextFields($questions, $i)
    {
        $html='';
        $qTextCount = count($questions);
        if ($qTextCount > 0) {
            $html .= "<select 
                                    multiple = 'multiple'
                                    name     = 'questions_text[$i][]'
                                    id       = 'questions_text{$i}' 
                                    size     = '$qTextCount'
                                    >";
            foreach ($questions as $qText) {
                $html .="<option value='".
                    $qText->ID .
                    "'>
                                $qText->post_title
                                </option>";
            }
            $html .='</select>';
            $html .= '<div>';
            $html .= "<label for='questions_text_count[$i]' >
                                    Use n questions this type in test
                                  </label>";
            $html .= "<input type='number'
                                         value = '0'
                                         step  = '1'
                                         min   = '1'
                                         max   = '$qTextCount'
                                         name='questions_text_count[$i]'
                                         id='questions_text_count_{$i}'
                                  />";
            $html .= '</div>';
        }
        return $html;
    }

    /**
     * @param $questions
     * @param $i
     * @return string
     * Create others Question fields for test
     */
    private function createQuestionsOtherFields($questions, $i)
    {
        $postData = $this->_testData;
        $questionValues = [];
        $questionCountValues = [];

        if (!empty($postData)) {
            if ($postData->meta['questions_category'][0] === $_POST['q_type']) {
                $questionValues = get_post_meta($postData->ID, 'questions')[0];
                $questionCountValues = get_post_meta(
                    $postData->ID, 'questions_count'
                )[0];
            }
        }
        $html = '';
        $selected ='';

        $qOthersCount = count($questions);
        if ($qOthersCount > 0) {
            $html .= "<select 
                                    multiple = 'multiple'
                                    name     = 'questions[{$i}][]'
                                    id       = 'questions_{$i}' 
                                    size     = '$qOthersCount'
                                    >";
            foreach ($questions as $qOthers) {
                if (!empty($questionValues)) {
                    if (in_array(
                        $qOthers->ID, $questionValues[$i]
                    )) {
                       $selected = " selected='selected' ";
                    }
                }

                $score = $qOthers
                    ->qMeta['question_score'][0];

                $html .= "<option $selected value='".
                            $qOthers->ID .
                         "'>
                         $qOthers->post_title ($score p)
                         </option>";
            }

            $html .= '</select>';
            $html .= '<div>';
            $html .= "<label for='question_others_count_{$i}' >
                                    Use n questions this type in test
                                  </label>";
            $html .= "<input type ='number'
                                         value = '1'
                                         step  = '1'
                                         min   = '1'
                                         max   =  '$qOthersCount'
                                         name  = 'questions_count[$i]'
                                         id    = 'questions_count_{$i}'
                                  />";
            $html .= '</div>';
        }
        return $html;
    }

    /**
     * @param $questions
     * @param $i
     * @return string
     * Create Questons  Score Limit
     */
    private function createQuestionsScoreLimit($questions,$i)
    {
        $html = '';
        $maxScore = 0;
        $qOthersCount = count($questions);

        if ($qOthersCount > 0) {
            foreach ($questions as $question) {
                $score = $question
                    ->qMeta['question_score'][0];
                $maxScore += $score;
            }


            $html .= '<div>';
            $html .= "<label>
                                    Score for pass to nex step
                                  </label>";
            $html .= "<input type='number'
                                         value = '0'
                                         step  = '1'
                                         min   = '1'
                                         max   = '$maxScore'
                                         name='score_for_pass[{$i}]'
                                         id='question_text_count_{$i}'
                                  />";
            $html .= '</div>';
        }
        return $html;
    }

    private function setTestData($postID)
    {
        $post = get_post($postID);
        if (!empty($post)) {
            $post->meta = get_post_meta($postID);
            $this->_testData = $post;
            return true;
        }
        return false;
    }

    /**
     * create Questions fields
     * @return bool
     */
    public function createQuestionsFields()
    {
        $testPostId = $_POST['post_id'];
        if ($testPostId && $testPostId != 'undefined') {
            $this->setTestData($testPostId);
        }
        $html = '';
        $qType = Data::cleanString($_POST['q_type']);
        $questions = $this->getFormateQuestions($qType);
        if (!empty($questions)) {
            ksort($questions);
            $i = 1;
            foreach ($questions as $question) {
                $html .= '<div>';
                $html .= "<span>Step $i </span>";

                $html .= $this->createQuestionsOtherFields(
                    $question['others'], $i
                );

                $html .= $this->createQuestionsTextFields(
                    $question['text'], $i
                );

                $html .= $this->createQuestionsScoreLimit(
                    $question['others'], $i
                );

                $i++;
                $html .='</div>';
                $html .='<hr/>';
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
        parent::save();
        $testId = $_POST['ID'];
        if (isset($_POST['questions_category'])) {
            update_post_meta(
                $testId, 'questions_category', $_POST['questions_category']
            );
        }
        if (isset($_POST['test_steps'])) {
            update_post_meta(
                $testId, 'test_steps', $_POST['test_steps']
            );
        }
        if (isset($_POST['questions'])) {
            update_post_meta(
                $testId, 'questions', $_POST['questions']
            );
        }
        if (isset($_POST['questions_count'])) {
            update_post_meta(
                $testId, 'questions_count', $_POST['questions_count']
            );
        }
        if (isset($_POST['questions_text'])) {
            update_post_meta(
                $testId, 'questions_text', $_POST['questions_text']
            );
        }
        if (isset($_POST['questions_text_count'])) {
            update_post_meta(
                $testId, 'questions_text_count', $_POST['questions_text_count']
            );
        }
        if (isset($_POST['score_for_pass'])) {
            update_post_meta(
                $testId, 'score_for_pass', $_POST['score_for_pass']
            );
        }

    }

}