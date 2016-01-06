<?php

namespace TomWright;

abstract class FrontEndController extends BaseController
{

    /**
     * @var string
     */
    protected $activeLayout;

    public function __construct()
    {
        parent::__construct();

        $this->setActiveLayout('layout');
    }


    /**
     * Set the layout to be used in views.
     * @param $layout
     */
    public function setActiveLayout($layout)
    {
        $this->activeLayout = $layout;
    }


    /**
     * Get the layout to be used in views.
     */
    public function getActiveLayout()
    {
        return $this->activeLayout;
    }


    /**
     * @override In order to include $activeLayout.
     * @param $view
     * @param array $data
     * @return mixed
     */
    protected function loadView($view, array $data = array())
    {
        $layout = $this->getActiveLayout();
        if ($layout !== null) {
            $data['activeLayout'] = $layout . '.php';
        }

        return parent::loadView($view, $data);
    }

}