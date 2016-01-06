<?php

use TomWright\FrontEndController;

class ErrorController extends FrontEndController
{

    public function __construct()
    {
        parent::__construct();
    }


    public function indexAction()
    {
        echo '404 not found';
    }

}