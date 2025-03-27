<?php

namespace App\model;

use PDO;

    class ModelUser {
        //attributs
        private $id;
        private $name;
        private $firstname;
        private $email;
        private $password;
        private $bdd;

        //constructeur
        public function __construct(){
            $this->bdd = DBconnect();
        }

        //getter et setter
        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getName(){
            return $this->name;
        }

        public function setName($name){
            $this->name = $name;
        }

        public function getFirstname(){
            return $this->firstname;
        }

        public function setFirstname($firstname){
            $this->firstname = $firstname;
        }

        public function getEmail(){
            return $this->email;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        public function getPassword(){
            return $this->password;
        }

        public function setPassword($password){
            $this->password = $password;
        }

        public function getBdd(){
            return $this->bdd;
        }

        /*
        public function setBdd($bdd){
            $this->bdd = $bdd;
        }
        */

        //méthodes
        //fonction qui ajoute un nouvel utilisateur
        function insertUser(): string {
            try{
                $name = $this->getName();
                $firstname = $this->getFirstname();
                $email = $this->getEmail();
                $password = $this->getPassword();
                $bdd = $this->getBdd();

                //Prepare notre requête d'INSERT
                $req = $bdd->prepare('INSERT INTO users (name_user, firstname_user, email_user, mdp_user) VALUES (?,?,?,?)');

                //Binding de Param :
                $req->bindParam(1,$name,PDO::PARAM_STR);
                $req->bindParam(2,$firstname,PDO::PARAM_STR);
                $req->bindParam(3,$email,PDO::PARAM_STR);
                $req->bindParam(4,$password,PDO::PARAM_STR);

                //Exécution de la requête
                $req->execute();

                return "L'utilisateur $firstname $name a bien été enregistré.";

            }catch(EXCEPTION $error){
                return $error->getMessage();
            }
        }

        //fonction qui récupère tous les utilisateurs
        public function getAllUsers(): ?array {
            try{
                $bdd = $this->getBdd();

                //Requête préparée
                $req = $bdd->prepare('SELECT id_user, name_user, firstname_user, email_user FROM users');
        
                //Exécution de la requête
                $req->execute();
        
                //Récupérer la réponse de la bdd : je reçois un tableau contenant des tableaux d'utilisateurs
                $data = $req->fetchAll(PDO::FETCH_ASSOC);
        
                return $data;
        
            }catch(EXCEPTION $error){
                return $error->getMessage();
            }
        }

        //fonction qui récupère un utilisateur par son mail
        function getUserByEmail(): ?array {
            try{
                $bdd = $this->getBdd();
                $email = $this->getEmail();

                //préparation de la requête
                $req = $bdd->prepare('SELECT id_user, name_user, firstname_user, email_user, mdp_user FROM users WHERE email_user = ? LIMIT 1');

                //binding des paramètres
                $req->bindParam(1, $email, PDO::PARAM_STR);

                //exécuter la requête
                $req->execute();

                //récupération de la réponse de la BDD
                $data = $req->fetchAll();

                return $data;

            }catch(Exception $error){
                return $error->getMessage();
            }
        }
    }
?>