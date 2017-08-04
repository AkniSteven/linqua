<?php

namespace IlinquaTest\Model;

/**
 * Class represents the answer, received from frontend.
 */
class ВAnswer
{
    /**
     * Create answer.
     *
     */
    public function __construct($questionId, $answer)
    {
        $this->questionId = $questionId;
           //$answer = unserialize($answer);
          //$answer = is_array($answer) ? $answer : [$answer];
    }

    /**
     * Get the question id.
     *
     * @return int Question id.
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Get answer id.
     *
     * @return array Answer, provided by user.
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Get score, won by this answer.
     *
     * @return int Score.
     */
    public function getScore()
    {
        $rightAnswer = unserialize(
            get_post_meta(
                $this->getQuestionId(),
                'right_answer',
                true
            ));
        $answer = $this->getAnswer();
        sort($answer);
        sort($rightAnswer);

        if ($answer != $rightAnswer) {
            return 0;
        }
        return get_post_meta(
            $this->getQuestionId(),
            'question_score',
            true
        );
    }
}
