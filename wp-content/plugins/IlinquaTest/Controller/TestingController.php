<?php

namespace IlinquaTest\Controller;

use IlinquaTest\Model\Testing;
use IlinquaTest\Controller\PageView;

use IlinquaTest\Model\AnswerPool;
use IlinquaTest\Model\Answer;

/**
 * Controller for test reqests.
 */
class TestingController
{
    /**
     * Test model.
     */
    private $_model;

    /**
     * Test page view.
     */
    private $_view;

    public function __construct()
    {
        $this->_model = new Testing();
        $this->_view =  new PageView();
    }

    /**
     * Save user data and start test.
     *
     * @param  array $data User data(e.g. name, phone, email).
     *
     * @return void
     */
    public function startTesting(array $data)
    {
        $answerPool = new AnswerPool($data['test_id']);
        $answerPool->drop();
        $this->_model->startTesting($data);
    }

    /**
     * Process quiz answer.
     *
     * @return void
     */
    public function addTestStep()
    {
        $data = [];
        if ($_POST['data']) {
            parse_str($_POST['data'], $data);
        }
        if (!empty($data)) {
           $step = $this->_model->addStep($data);
        }

        $currentTestId = $_SESSION['test_id'];
        if (empty($currentTestId)) {
            throw new Exception('No quiz started.');
        }


        $answerPool = new AnswerPool($currentTestId);
        $answerPool->add($step);

        if ($this->isQuestionTheLast($data['question_id'])) {
            if($this->canLevelUp($answerPool)) {

            }
            echo print_r('test', true);
        }
        wp_die();
    }

    /**
     *  Method to get last question
     *
     * @param $questionId
     * @return bool
     */
    protected function isQuestionTheLast($questionId)
    {
        $lastQuestionsIds = [];
        $level = $this->getQuestionLevel($questionId);

        if ($_SESSION['last_questions_ids']
            && !empty($_SESSION['last_questions_ids'])) {
            $lastQuestionsIds = $_SESSION['last_questions_ids'];
        }

        if ($level && $questionId) {
            if (isset($lastQuestionsIds[$level])) {
                return $questionId == $lastQuestionsIds[$level];
            }
        }
        return false;
    }

    protected function getQuestionLevel($questionId)
    {
        return get_post_meta($questionId, 'question_level', true);
    }


    protected function canLevelUp(AnswerPool $answerPool, $questionLevel)
    {
//        $points = 0;
//        $levelAnswers = array_filter(
//          $answerPool->getAll(),
//            1
//        );
//        foreach ($levelAnswers as $answer) {
//          $points += $answer->getScore();
//        }
        //$passScore = get_post_meta(, 'score_for_pass', true);
    }
}
