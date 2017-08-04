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
        $answerPool->add(
            //new Answer($data['question_id'], $step, $step['user_score'] )
            $step
        );
        if ($this->isQuestionTheLast($currentTestId, $data['question_id'])) {
        }

        //if ($this->isQuestionTheLast($currentTestId, $data['question_id']) && !$this->canLevelUp($answerPool)) {
        //}
        // Check if this is the last question of the level.
        // If it is the last one, stop the test.
        // Save history from session to db.
        // Send a letter to somebody.
        echo print_r('test', true);
    }

    protected function isQuestionTheLast($testId, $questionId)
    {
        $levelQuestionIds = $this->getAllQuestionIds($questionId);
        return $questionId == last($levelQuestionIds);
    }

    protected function getQuestionLevel($questionId)
    {
        return get_post_meta($questionId, 'question_level', true);
    }

    protected function getLevelQuestionIds($questionId)
    {
        $currentTest = get_post($testId);
        $questionIds = get_post_meta($testId, 'questions', true);
        $questionLevel = $this->getQuestionLevel($questionid);
        return $questionIds[$questionLevel];
    }

//    protected function canLevelUp(AnswerPool $answerPool, $questionLevel)
//    {
//        $points = 0;
//        $levelAnswers = array_filter(
//          $answerPool->getAll(),
//          function ($item) (use $questionLevel) {
//            return $this->getQuestionLevel($item->getQuestionId()) == $questionLevel;
//          }
//        );
//        foreach ($levelAnswers as $answer) {
//          $points += $answer->getScore();
//        }
//        //$passScore = get_post_meta(, 'score_for_pass', true);
//    }
}
