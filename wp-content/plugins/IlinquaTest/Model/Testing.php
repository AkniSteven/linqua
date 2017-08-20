<?php

namespace IlinquaTest\Model;

use IlinquaTest\Controller\PageView;
use IlinquaTest\Helper\Data;

class Testing
{
    private $_dbModel;

    public function __construct()
    {
        $this->_startSession();
        $this->_dbModel = new TestDb();
    }

    public function _startSession()
    {
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * Method to start testing
     *
     * @param array $data
     */
    public function startTesting(array $data)
    {
        if (session_id()) {
            if (!($_SESSION['tester_id'])) {
                $currentTester = $this->_dbModel->add_customer(
                    $data['name'],
                    $data['tel'],
                    $data['email']
                );
                $_SESSION["tester_id"] =  $currentTester;
            }

            $_SESSION["test_id"] = $data['test_id'];
            $_SESSION["name"]  =  $data['name'];
            $_SESSION["tel"]  =  $data['tel'];
            $_SESSION["email"] = $data['email'];
            $_SESSION["realStepsCount"] = $data['realStepsCount'];
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function addStep(array $data)
    {
        $step = [
            'id' => '',
            'title' => '',
            'description' => '',
            'right_answer' => '',
            'user_answer' => '',
            'question_score' => '',
            'cached_score' => ''
        ];

        $view = new PageView();
        $handler = $view->postsHandler;

        $currentQuestion = get_post($data['question_id']);
        $handler->setResult([0 =>$currentQuestion]);
        $handler->formattedMeta();
        $handler->formattedACF();
        $currentQuestion = $handler->getResult()[0];

        if ($data) {
            if ($currentQuestion) {
                $step['id'] = $data['question_id'];
                $step['title'] = $currentQuestion->post_title;
                $step['description'] = $currentQuestion->post_content;
                $step['right_answer'] = get_post_meta(
                    $currentQuestion->ID, 'right_answer', true
                );
                $step['user_answer'] = $data['answer'];
                $step['question_score'] = $currentQuestion

                    ->meta['question_score'][0];
                $step['cached_score'] = $this->countScore(
                    $step['right_answer'],
                    $step['user_answer'],
                    $step['question_score']
                );

            }
        }
        return $step;
    }

    /**
     * Method to get score
     *
     * @param $rightAnswer
     * @param $userAnswer
     * @param $score
     * @return int
     */
    protected function countScore($rightAnswer, $userAnswer, $score)
    {
        $points = 0;
        if (is_array($rightAnswer) || is_array($userAnswer)) {
            if (!(count($userAnswer) > count($rightAnswer))) {
                if ($userAnswer == $rightAnswer) {
                    $points = $score;
                } else {
                    $scorePoint = $score / count($rightAnswer);
                    if (is_array($rightAnswer)) {
                        $right = array_intersect($rightAnswer, $userAnswer);
                        $points = $scorePoint * count($right);
                    } else {
                        if (in_array($userAnswer, $rightAnswer)) {
                            $points = $scorePoint;
                        }
                    }
                }
            }
        } else {
            if ($userAnswer == $rightAnswer) {
                $points = $score;
            }
        }
        return $points;
    }


    public function formatResultAnswers($answers)
    {
        if (is_array($answers)) {
            foreach ($answers as &$answer) {
                if ($answer['id']) {
                    if (!$answer['right_answer']) {
                        continue;
                    }
                    $questionAnswers = get_post_meta($answer['id'], 'answer_case', true);
                    if (is_array($answer['right_answer'])) {
                        foreach ($answer['right_answer'] as &$right_answer) {
                            $right_answer = $questionAnswers[$right_answer];
                        }
                    } else {
                        $answer['right_answer'] = $questionAnswers[$answer['right_answer']];
                    }
                    if (is_array($answer['user_answer'])) {
                        foreach ($answer['user_answer'] as &$user_answer) {
                            $user_answer = $questionAnswers[$user_answer];
                        }
                    } else {
                        $answer['user_answer'] = $questionAnswers[$answer['user_answer']];
                    }
                }
            }
        }
        return $answers;
    }

    public function calculateAnswersScore($answers)
    {
        $points = 0;
        foreach ($answers as $answer) {
            $points += $answer['cached_score'];
        }
        return $points;
    }

    public function getAnswersScore($answers)
    {
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
