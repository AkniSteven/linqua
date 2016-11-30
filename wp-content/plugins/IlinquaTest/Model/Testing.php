<?php

namespace IlinquaTest\Model;

class Testing
{
    public function __construct()
    {

        $this->_startSession();
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
            $_SESSION["test_id"] = $data['test_id'];
            $_SESSION["name"]  =  $data['name'];
            $_SESSION["email"] = $data['email'];
            $_SESSION["realStepsCount"] = $data['realStepsCount'];
        }
    }

}