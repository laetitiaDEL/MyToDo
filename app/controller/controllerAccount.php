<?php

namespace App\controller;

use App\view\ViewAccount;

    class controllerAccount extends GenericController {
        //attributs
        private ViewAccount $viewAccount;

        //constructeur
        public function __construct(){
            parent::__construct();
            $this->viewAccount = new ViewAccount();
        }

        //getter setter
        public function getViewAccount(){
            return $this->viewAccount;
        }

        public function setViewAccount($viewAccount){
            $this->viewAccount = $viewAccount;
        }

        //vérifier que la session existe
        public function isConnected(){
            if(isset($_SESSION['id'])){
                $this->getViewAccount()->setNom($_SESSION['name']);
                $this->getViewAccount()->setPrenom($_SESSION['firstname']);
                $this->getViewAccount()->setEmail($_SESSION['email']);
            }
        }

        //gestion de l'affichage
        public function render(){
            $this->isConnected();
            $this->setContent($this->getViewAccount()->displayView());
            $this->renderPage();
        }
    }
    


?>