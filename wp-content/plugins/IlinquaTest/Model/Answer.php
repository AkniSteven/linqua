<?php

namespace IlinquaTest\Model;

/**
 * Class represents the answer, received from frontend.
 */
class Answer
{
    /**
     * Create answer.
     *
     * @param int        $questionId Question id.
     * @param int|string $answer     Answer.
     *
     * @return void
     */
    public function __construct($questionId, $answer)
    {
        $this->questionId = $questionId;
        $this->answer = $answer;
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
     * @return int|string Answer, provided by user.
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
