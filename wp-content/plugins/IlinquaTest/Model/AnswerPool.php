<?php

namespace IlinquaTest\Model;

use IlinquaTest\Model\Answer;

/**
 * Class is a wrapper for session to save/get answers to/from the session.
 */
class AnswerPool
{
    /**
     * An id of the test.
     */
    public $_testId;

    /**
     * All the answers, given by current user for the testId questions.
     */
    protected $_answers = array();

    /**
     * Load answers, that are already in session, by test id.
     *
     * @param int $testId Current test id.
     *
     * @return void
     */
    public function __construct($testId)
    {
        $this->_testId = $testId;
        if (!isset($_SESSION['quiz'])) {
            $_SESSION['quiz'] = array();
        }
        if (!isset($_SESSION['quiz'][$this->_testId])) {
            $_SESSION['quiz'][$this->_testId] = array();
        }
        $this->_answers = unserialize($_SESSION['quiz'][$this->_testId]);
    }

    /**
     * Add answer to pool.
     *
     * @param Answer $answer Answer object.
     *
     * @return void
     */
    public function add(Answer $answer)
    {
        $this->_answers[] = $answer;
        $this->save();
    }

    /**
     * Reset  answers.
     *
     * @return void
     */
    public function drop()
    {
        $this->_answers = [];
        $this->save();
    }

    /**
     * Store answers to the session.
     *
     * @return void
     */
    public function save()
    {
        $_SESSION['quiz'][$this->_testId] = serialize($this->_answers);
    }

    /**
     * Get answers from session.
     *
     * @return array Answer objects.
     */
    public function getAll()
    {
        return $this->_answers;
    }
}
