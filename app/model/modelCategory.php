<?php

namespace App\model;

use PDO;

    class ModelCategory {
        //attributs
        private $id;
        private $name;
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

        public function getBdd(){
            return $this->bdd;
        }

        /*
        public function setBdd($bdd){
            $this->bdd = $bdd;
        }
        */

        //lecture
        //fonction qui récupère toutes les catégories
        public function getAllCategories(){
            try{
                $bdd = $this->getBdd();

                //Requête préparée
                $req = $bdd->prepare('SELECT id_category, name_category FROM categories');

                //Exécution de la requête
                $req->execute();

                //Récupérer la réponse de la bdd : je reçois un tableau contenant des tableaux de catégories
                $data = $req->fetchAll(PDO::FETCH_ASSOC);

                return $data;

            }catch(EXCEPTION $error){
                return $error->getMessage();
            }
        }

        //fonction qui récupère une catégorie par son nom
        function getCategoryByName(){
            try{
                $bdd = $this->getBdd();
                $category = $this->getName();

                //préparation de la requête
                $req = $bdd->prepare('SELECT id_category, name_category FROM categories WHERE name_category = ? LIMIT 1');

                //binding des paramètres
                $req->bindParam(1, $category, PDO::PARAM_STR);

                //exécuter la requête
                $req->execute();

                //récupération de la réponse de la BDD
                $data = $req->fetchAll();

                return $data;

            }catch(Exception $error){
                return $error->getMessage();
            }
        }


        //fonction qui récupère une catégorie par son id
        public function getCategoryById(){
            try{

                $bdd = $this->getBdd();
                $id = $this->getId();

                //préparation de la requête
                $req = $bdd->prepare('SELECT id_category, name_category FROM categories WHERE id_category = ? LIMIT 1');

                //binding des paramètres
                $req->bindParam(1, $id, PDO::PARAM_STR);

                //exécuter la requête
                $req->execute();

                //récupération de la réponse de la BDD
                $data = $req->fetchAll();

                return $data;

            }catch(Exception $error){
                return $error->getMessage();
            }
        }


        //création
        //fonction qui ajoute une nouvelle catégorie
        public function insertCategory(){

            try{

                $bdd = $this->getBdd();
                $name = $this->getName();

                //Prepare notre requête d'INSERT
                $req = $bdd->prepare('INSERT INTO categories (name_category) VALUES (?)');

                //Binding de Param :
                $req->bindParam(1,$name,PDO::PARAM_STR);

                //Exécution de la requête
                $req->execute();

                return "La nouvelle catégorie $name a été enregistrée avec succès !";

            }catch(EXCEPTION $error){
                return $error->getMessage();
            }
        }


        //modification

        //suppression
    }

?>