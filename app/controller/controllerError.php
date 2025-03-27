<?php

namespace App\controller;

use App\view\ViewError;

class ControllerError extends GenericController{
    //attributs
    private ViewError $viewError;

    //constructeur
    public function __construct(){
        parent::__construct();
        $this->viewError = new ViewError();
    }

    //getter setter
    public function getViewError(){
        return $this->viewError;
    }

    public function setViewError($viewError){
        $this->viewError = $viewError;
    }

    //METHOD
    public function render():void{
        $this->setContent($this->getViewError()->displayView());
        $this->renderPage();   
    }
}