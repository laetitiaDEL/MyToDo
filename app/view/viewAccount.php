<?php

namespace App\view;

    class ViewAccount  {
        //attributs
        private ?string $nom = "";
        private ?string $prenom = "";
        private ?string $email = "";

        //getter et setter
        public function getNom(){
            return $this->nom;
        }

        public function setNom($nom){
            $this->nom = $nom;
        }

        public function getPrenom(){
            return $this->prenom;
        }

        public function setPrenom($prenom){
            $this->prenom = $prenom;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function displayView():string{
            return '
                <main>
                    <div>
                        <h3>Nom : '.$this->getNom().'</h3>
                        <h3>Prénom : '.$this->getPrenom().'</h3>
                        <h3>Email : '.$this->getEmail().'</h3>
                    </div>
                </main>';
        }
    }

?>