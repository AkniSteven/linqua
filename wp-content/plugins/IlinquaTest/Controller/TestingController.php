<?php

namespace IlinquaTest\Controller;

use IlinquaTest\Model\Testing;
use IlinquaTest\Controller\PageView;

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
            $this->_model->addStep($data);
        }
        echo print_r($data, true);
    }
}
