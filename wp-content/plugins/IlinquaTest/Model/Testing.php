<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 20.11.16
 * Time: 21:45
 */

namespace IlinquaTest\Model;


class Testing
{
    public function __construct($type,$title)
    {
        $this->_startSession();
    }

    private function  _startSession()
    {
        if (!session_id()) {
            session_start();
        }
    }

    public function startTesting(array $data)
    {
        if (session_id()) {
            $_SESSION["test_id"] = $data['test_id'];
            $_SESSION["name"] = $data['name'];
            $_SESSION["email"] = $data['email'];
        }

    }

}