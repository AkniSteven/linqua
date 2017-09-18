<?php

namespace IlinquaTest\Controller;

use IlinquaTest\Model\Testing;
use IlinquaTest\Model\TestDb;

use IlinquaTest\Model\AnswerPool;
use IlinquaTest\Model\Mailer;

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

    /**
     * @var Mailer
     */
    private $_mailer;

    /**
     * TestingController constructor.
     */
    public function __construct()
    {
        $this->_model = new Testing();
        $this->_dbModel = new TestDb();
        $this->_view =  new PageView();
        $this->_mailer = new Mailer();
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

        if (!empty($data['answer'])) {
            $currentTestId = $_SESSION['test_id'];
            $currentStep = $data['current_step'];
            $level = $this->getQuestionLevel($data['question_id']);
            $answerPool = new AnswerPool($currentTestId);

            if ($answerPool->countAnswers($level) >= $currentStep) {
                $answerPool->drop();
                if ($currentStep != 1) {
                    echo 'error_end';
                    wp_die();
                }

            } elseif (($currentStep - $answerPool->countAnswers($level)) != 1) {
                $answerPool->drop();
                echo 'error_end';
                wp_die();
            }

            $step = $this->_model->addStep($data);

            if (empty($currentTestId)) {
                throw new Exception('No quiz started.');
            }

            $answerPool->add($step, $level);

            if ($this->isQuestionTheLast($data['question_id'])) {
                if (!$this->canLevelUp($answerPool, $level)) {
                    if (!$answerPool->countAnswers()) {
                        echo 'error_end';
                        wp_die();
                    }
                    $this->saveTest($answerPool);
                    $mailData = $this->_prepareMailData($answerPool);
                    $this->_mailer->sendMail($mailData);
                    $this->_mailer->sendCustomerMail($mailData);
                    echo 'end';
                }
            }
            wp_die();
        }
    }

    /**
     * Method to save test
     *
     * @param AnswerPool $answerPool
     */
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
        $level = $this->getQuestionLevel($questionId) -1;

        if ($_SESSION['last_questions_ids']
            && !empty($_SESSION['last_questions_ids'])) {
            $lastQuestionsIds = array_values($_SESSION['last_questions_ids']);
        }

        if ($level !=='' && $questionId) {
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

    /**
     * Method to prepare mail data
     *
     */
    private function _prepareMailData($answers)
    {
        $testResultLink = get_permalink(
            get_option('test-config')['test_result_page_id']
        );
        $test = get_post($_SESSION['test_id']);
        $mailData = [];
        $mailData['tester_name'] = $_SESSION['name'] ? $_SESSION['name'] : '';
        $mailData['tester_email'] = $_SESSION['email']
            ? $_SESSION['email'] : '';
        $mailData['tel'] = $_SESSION['tel'] ? $_SESSION['tel'] : '';
        $mailData['test_result'] = $testResultLink && $_SESSION['tester_id']
            ? $testResultLink . '?testId=' . $_SESSION['tester_id']
            : '';
        $mailData['test_name'] = $test->post_title
            ? $test->post_title
            : '';
        $mailData['test_date'] = date('d.m.y');
        $mailData['test_score'] = $this->_getUserScore($answers);
        return $mailData;
    }

    /**
     * @param $answersPool
     * @return string
     */
    private function _getUserScore($answersPool)
    {
        $answers = $answersPool->getAll();
        $userScore = 0;
        $questionsCount = 0;
        if (!empty($answers)) {
            foreach ($answers as $answerGroup) {
                foreach ($answerGroup as $answer) {
                    if ($answer['question_score'] != 0 ) {
                        $questionsCount += 1;
                        if ($answer['cached_score'] != 0) {
                            $userScore += 1;
                        }
                    }
                }
            }
        }
        return "$userScore из $questionsCount";
    }
}