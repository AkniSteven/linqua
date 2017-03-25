<?php

namespace IlinquaTest\Controller;

use IlinquaTest\Model\Testing;
use IlinquaTest\Controller\PageView;

class TestingController
{
    private $_model;
    private $_view;
    
    public function __construct()
    {

        $this->_model = new Testing();
        $this->_view =  new PageView();

    }
    

    public function startTesting(array $data)
    {
        $this->_model->startTesting($data);
    }

    public function addTestStep()
    {
        $data = [];
        if ($_POST['data']) {
            parse_str($_POST['data'], $data);
        }
        if (!empty($data)) {
            $this->_model->addStep($data);
        }
        echo "Тест";
        
    }

}