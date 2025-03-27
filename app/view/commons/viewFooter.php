<?php

namespace App\view\commons;

    class ViewFooter {

        //methods
        public function displayView(){
            return '
            <footer class="border-top border-black shadowCustom p-4 mt-5">
                <ul class="nav justify-content-center">
                    <li class="nav-item">My ToDo - 2025</li>
                </ul>
            </footer>
            ';
        }
    }
