<?php

use TomWright\FrontEndController;

class HomeController extends FrontEndController
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