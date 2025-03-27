<?php

namespace App\model;

    class ModelTask {
        //attributs
        private $id;
        private $name;
        private $content;
        private $date;
        private $id_category;
        private $id_user;
        private $bdd;

        //constructeur
        public function __construct(){
            $this->bdd = DBconnect();
        }

        //méthodes
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

        public function getContent(){
            return $this->content;
        }

        public function setContent($content){
            $this->content = $content;
        }

        public function getDate(){
            return $this->date;
        }

        public function setDate($date){
            $this->date = $date;
        }

        public function getIdCategory(){
            return $this->id_category;
        }

        public function setIdCategory($id){
            $this->id_category = $id;
        }

        public function getIdUser(){
            return $this->id_user;
        }

        public function setIdUser($id){
            $this->id_user = $id;
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
        //fonction qui récupère toutes les taches
        function getTasks(): ?array{
            try{
                $bdd = $this->getBdd();

                //Requête préparée
                $req = $bdd->prepare('SELECT id_task, name_task, content_task, start_task, id_category, id_user FROM tasks');

                //Exécution de la requête
                $req->execute();

                //Récupérer la réponse de la bdd : je reçois un tableau contenant des tableaux de taches
                $data = $req->fetchAll(\PDO::FETCH_ASSOC);

                return $data;

            }catch(\Exception $error){
                return $error->getMessage();
            }
        }


        //fonction qui récupère toutes les taches d'un utilisateur
        public function getTasksByUser() : ?array {
            try{

                $bdd = $this->getBdd();
                $id_user = $this->getIdUser();

                //Requête préparée
                $req = $bdd->prepare('SELECT id_task, name_task, content_task, start_task, id_category, id_user FROM tasks WHERE id_user = ?');

                //binding de param
                $req->bindParam(1, $id_user, \PDO::PARAM_STR);

                //Exécution de la requête
                $req->execute();

                //Récupérer la réponse de la bdd : je reçois un tableau contenant des tableaux de taches
                $data = $req->fetchAll(\PDO::FETCH_ASSOC);

                return $data;

            }catch(\Exception $error){
                return $error->getMessage();
            }
        }

        //récupérer une tache par son id
        public function getTaskById() : ?array {
            try{

                $bdd = $this->getBdd();
                $id = $this->getId();

                //Requête préparée
                $req = $bdd->prepare('SELECT id_task, name_task, content_task, start_task, id_category, id_user FROM tasks WHERE id_task = ?');

                //binding de param
                $req->bindParam(1, $id, \PDO::PARAM_STR);

                //exécution de la requête
                $req->execute();

                //Récupérer la réponse de la bdd : je reçois un tableau contenant des tableaux de taches
                $data = $req->fetch(\PDO::FETCH_ASSOC);

                return $data;

            }catch(\Exception $error){
                return $error->getMessage();
            }
        }


        //création
        //fonction qui ajoute une nouvelle tache
        function insertTask() : ?string {

            try{

                $name = $this->getName();
                $content = $this->getContent();
                $date = $this->getDate();
                $id_category = $this->getIdCategory();
                $id_user = $this->getIdUser();
                $bdd = $this->getBdd();

                //Prepare notre requête d'INSERT
                $req = $bdd->prepare('INSERT INTO tasks (name_task, content_task, start_task, id_category, id_user) VALUES (?,?,?,?,?)');

                //Binding de Param :
                $req->bindParam(1,$name,\PDO::PARAM_STR);
                $req->bindParam(2,$content,\PDO::PARAM_STR);
                $req->bindParam(3,$date,\PDO::PARAM_STR);
                $req->bindParam(4,$id_category,\PDO::PARAM_INT);
                $req->bindParam(5,$id_user,\PDO::PARAM_INT);

                //Exécution de la requête
                $req->execute();

                return "Tache enregistrée !";

            }catch(\Exception $error){
                return $error->getMessage();
            }
        }

        //modification
        public function updateTask(){
            try{

                $id = $this->getId();
                $name = $this->getName();
                $content = $this->getContent();
                $date = $this->getDate();
                $id_category = $this->getIdCategory();
                $id_user = $this->getIdUser();
                $bdd = $this->getBdd();

                //Prepare notre requête d'UPDATE
                $req = $bdd->prepare('UPDATE tasks SET name_task = ?, content_task = ?, start_task = ?, id_category = ?, id_user = ? WHERE id_task = ?');

                //Binding de Param :
                $req->bindParam(1,$name,\PDO::PARAM_STR);
                $req->bindParam(2,$content,\PDO::PARAM_STR);
                $req->bindParam(3,$date,\PDO::PARAM_STR);
                $req->bindParam(4,$id_category,\PDO::PARAM_INT);
                $req->bindParam(5,$id_user,\PDO::PARAM_INT);
                $req->bindParam(6,$id,\PDO::PARAM_INT);

                //exécution de la requête
                $req->execute();

                return "Tache modifiée !";

            }catch(\Exception $error){
                return $error->getMessage();
            }
        }

        //suppression
        public function deleteTaskById() {
            try {
                $bdd = $this->getBdd();
                $id = $this->getId();

                $req = $bdd->prepare("DELETE FROM tasks WHERE id_task = ?");

                $req->bindParam(1, $id, \PDO::PARAM_INT);
                
                $req->execute();

                return "Tache supprimée !";
                
            }catch(\Exception $error){
                
                return $error->getMessage();
            }
        }
    }


?>