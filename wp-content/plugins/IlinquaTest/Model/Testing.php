<?php

namespace IlinquaTest\Model;
use IlinquaTest\Model\TestDb;
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

    public function  _startSession()
    {
        if (!session_id()) {
            session_start();
        }
    }
    
    public function startTesting(array $data)
    {
        if (session_id()) {
            $currentTester = $this->_dbModel->add_customer(
                $data['name'],
                $data['tel'],
                $data['email']
            );
            $_SESSION["tester_id"] =  $currentTester;
            $_SESSION["test_id"] = $data['test_id'];
            $_SESSION["name"]  =  $data['name'];
            $_SESSION["tel"]  =  $data['tel'];
            $_SESSION["email"] = $data['email'];
            $_SESSION["realStepsCount"] = $data['realStepsCount'];
        }
    }

    public function addStep(array $data)
    {
        $view = new PageView();
        $handler = $view->postsHandler;

        $currentTest = get_post($_SESSION['test_id']);
        $currentQuestion = get_post($data['question_id']);

        $handler->setResult([0 =>$currentQuestion]);
        $handler->formattedMeta();
        $handler->formattedACF();
        $currentQuestion = $handler->getResult();

        if ($data) {

        }

    }

}