<?php

namespace App\Controllers;

use TomWright\FrontEndController;

class Home extends FrontEndController
{

    public function __construct()
    {
        parent::__construct();

        $this->setActiveLayout('layout');
    }


    public function helloWorldAction()
    {
        $this->displayView('main');
    }

}