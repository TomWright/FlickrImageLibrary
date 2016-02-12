<?php

namespace App\Controllers;


use TomWright\FrontEndController;

class Error extends FrontEndController
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