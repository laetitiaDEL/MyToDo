<?php

namespace App\view\commons;

    class ViewHeader {
        //attributs
        private ?string $nav = "";

        //getter setter
        public function getNav(){
            return $this->nav;
        }

        public function setNav($nav){
            $this->nav = $nav;
        }

        //methods
        public function displayView(){
            return '
            <header>
                <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom border-black shadowCustom mb-5">
                    <div class="container-fluid container">
                        <a class="navbar-brand" href='. url('/') .'>My ToDo</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href='. url('/') .'>Accueil</a>
                                </li>
                                '. $this->getNav() .'
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            ';
        }
    }
