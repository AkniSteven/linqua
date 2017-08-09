<?php

namespace IlinquaTest\Controller;

use IlinquaTest\Model\Testing;
use IlinquaTest\Model\TestDb;

use IlinquaTest\Model\AnswerPool;
use IlinquaTest\Model\Answer;

/**
 * Controller for test reqests.
 */
class TestingController
{
    /**
     * @var $_dbModel
     */
    private $_dbModel;

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
        $this->_dbModel = new TestDb();
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
            $currentTestId = $_SESSION['test_id'];
            $currentStep = $data['current_step'];
            $level = $this->getQuestionLevel($data['question_id']);
            $answerPool = new AnswerPool($currentTestId);

            if ($answerPool->countAnswers($level) > $currentStep) {
                $answerPool->drop();
            }

            $level = $this->getQuestionLevel($data['question_id']);
            $step = $this->_model->addStep($data);

            if (empty($currentTestId)) {
                throw new Exception('No quiz started.');
            }

            $answerPool->add($step, $level);

            if ($this->isQuestionTheLast($data['question_id'])) {
                if (!$this->canLevelUp($answerPool, $level)) {
                    $this->saveTest($answerPool);
                    echo 'end';
                }
            }
            wp_die();
        }
    }

    private function saveTest(AnswerPool $answerPool)
    {
        $testerId = $_SESSION['tester_id'];
        $testId = $answerPool->_testId;
        $answers = serialize($answerPool->getAll());

        $this->_dbModel->updateTest($testerId, $testId, $answers);

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

    /**
     * Method to get question level
     *
     * @param $questionId
     * @return mixed
     */
    protected function getQuestionLevel($questionId)
    {
        return get_post_meta($questionId, 'question_level', true);
    }


    /**
     * Method to levelup
     *
     * @param AnswerPool $answerPool
     * @param $questionLevel
     * @return bool
     */
    protected function canLevelUp(AnswerPool $answerPool, $questionLevel)
    {
        $points = 0;
        $stepsCount = $_SESSION['realStepsCount'];
        if (!$stepsCount || $questionLevel >= $stepsCount) {
            return false;
        }
        $levelAnswers = !empty($answerPool->getAll()[$questionLevel])
        ? $answerPool->getAll()[$questionLevel] : [];
        $passScore = get_post_meta(
            $answerPool->_testId, 'score_for_pass', true
        )[$questionLevel];
        if (!empty($levelAnswers) && $passScore) {
            foreach ($levelAnswers as $answer) {
                $points += $answer['cached_score'];
            }
            if ($points >= $passScore) {
                return true;
            }
        }
        return false;
    }
}
