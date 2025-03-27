<?php

namespace App\controller;

use App\view\commons\ViewHeader;
use App\view\commons\ViewFooter;

    abstract class GenericController {
        //attributs
        private ?ViewHeader $header;
        private $content;
        private ?ViewFooter $footer;

        //constructeur
        public function __construct(){
            $this->header = new ViewHeader();
            $this->footer = new ViewFooter();
        }

        //getter et setter
        public function getHeader(): ?ViewHeader {
            return $this->header;
        }

        public function setHeader(?ViewHeader $header): self {
            $this->header = $header;
            return $this;
        }

        public function getContent(){
            return $this->content;
        }

        public function setContent($content){
            $this->content = $content;
        }

        public function getFooter(): ?ViewFooter{
            return $this->footer;
        }

        public function setFooter(?ViewFooter $footer): self{
            $this->footer = $footer;
            return $this;
        }

        //vérifier que la session existe
        public function isConnectedHeader(){
            if(isset($_SESSION['id'])){
                $this->getHeader()->setNav('
                    <li class="nav-item">
                        <a class="nav-link" href='. url('/account') .' > Mon compte </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='. url('/task') .' > Mes taches </a>   
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='. url('/category') .' > Catégories </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='. url('/out') .'>Déconnexion</a>  
                    </li>
                ');
            }
        }

        public function renderPage(){
            $this->isConnectedHeader();
            $header = $this->getHeader()->displayView();
            $content = $this->getContent();
            $footer = $this->getFooter()->displayView();
            require_once '../app/view/commons/viewLayout.php';
        }
    }