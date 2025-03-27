<?php
//Le controller de la page taches

namespace App\controller;

use App\view\ViewTask;
use App\model\ModelTask;
use App\model\ModelCategory;

use DateTime;

    class ControllerTask extends GenericController {
        //attributs
        private ViewTask $viewTask;
        private ModelTask $modelTask;
        private ModelCategory $modelCategory;

        //constructeur
        public function __construct(){
            parent::__construct();
            $this->viewTask = new ViewTask();
            $this->modelTask = new ModelTask();
            $this->modelCategory = new ModelCategory();
        }

        //getter setter
        public function getViewTask(){
            return $this->viewTask;
        }

        public function setViewTask($viewTask){
            $this->viewTask = $viewTask;
        }

        public function getModelTask(){
            return $this->modelTask;
        }

        public function setModelTask($modelTask){
            $this->modelTask = $modelTask;
        }

        public function getModelCategory(){
            return $this->modelCategory;
        }

        public function setModelCategory($modelCategory){
            $this->modelCategory = $modelCategory;
        }

        //methods
        //afficher la liste des catégories
        public function showCategories(){
            $data = $this->getModelCategory()->getAllCategories();
            $display = "";
            if(!empty($data)){
                foreach($data as $category){
                    $display = $display."<option value={$category['id_category']}>{$category['name_category']}</option>";
                }
            }
            return $display;
        }

        //ajouter une nouvelle tache
        public function createTask() {
            //Vérifier que je reçois le formulaire de création
            if(isset($_POST['submitTask'])){
                //Vérifie que les données ne sont pas vides
                if(isset($_POST['task']) && !empty($_POST['task'])
                && isset($_POST['content']) && !empty($_POST['content'])
                && isset($_POST['date']) && !empty($_POST['date'])
                && isset($_POST['category']) && !empty($_POST['category'])
                && isset($_SESSION['id']) && !empty($_SESSION['id'])){

                    //Vérifier que la catégorie est au bon format
                    if(filter_var($_POST['category'],FILTER_VALIDATE_INT)
                    && filter_var($_SESSION['id'],FILTER_VALIDATE_INT)){


                        //Nettoyage des données
                        $name = nettoyage($_POST['task']);
                        $content = nettoyage($_POST['content']);
                        $date = nettoyage($_POST['date']);
                        $category = nettoyage($_POST['category']);
                        $userId = nettoyage($_SESSION['id']);

                        $task = $this->getModelTask();

                        //attribution des valeurs
                        $task->setName($name);
                        $task->setContent($content);
                        $task->setDate($date);
                        $task->setIdCategory($category);
                        $task->setIdUser($userId);

                        //on commence à enregistrer en BDD
                        return $task->insertTask();

                    }else{
                        return "Erreur due au format.";
                    }
                }else{
                    return "Veuillez remplir tous les champs.";
                }
            }
        }

        //modifier une tache
        public function editTask(){
            if(isset($_POST['submitEdit']) && !empty($_POST['submitEdit'])){
                //Vérifie que les données ne sont pas vides
                if(isset($_POST['task']) && !empty($_POST['task'])
                && isset($_POST['id_task']) && !empty($_POST['id_task'])
                && isset($_POST['content']) && !empty($_POST['content'])
                && isset($_POST['date']) && !empty($_POST['date'])
                && isset($_POST['category']) && !empty($_POST['category'])
                && isset($_SESSION['id']) && !empty($_SESSION['id'])){

                    //Vérifier que la catégorie est au bon format
                    if(filter_var($_POST['category'],FILTER_VALIDATE_INT)
                    &&filter_var($_POST['id_task'],FILTER_VALIDATE_INT)
                    && filter_var($_SESSION['id'],FILTER_VALIDATE_INT)){


                        //Nettoyage des données
                        $id = nettoyage($_POST['id_task']);
                        $name = nettoyage($_POST['task']);
                        $content = nettoyage($_POST['content']);
                        $date = nettoyage($_POST['date']);
                        $category = nettoyage($_POST['category']);
                        $userId = nettoyage($_SESSION['id']);

                        $task = $this->getModelTask();

                        //attribution des valeurs
                        $task->setId($id);
                        $task->setName($name);
                        $task->setContent($content);
                        $task->setDate($date);
                        $task->setIdCategory($category);
                        $task->setIdUser($userId);

                        //on commence à modifier en BDD
                        return $task->updateTask();

                    }else{
                        return "Erreur due au format.";
                    }
                }else{
                    return "Veuillez remplir tous les champs.";
                }
            }
        }

        public function deleteTask() {
            if (isset($_POST['id_task']) && !empty($_POST['id_task'])) {
                if(filter_var($_POST['id_task'],FILTER_VALIDATE_INT)){
                    
                    // Nettoyage des données
                    $id_task = nettoyage($_POST['id_task']);
        
                    $task = $this->getModelTask();
                    $task->setId($id_task);
                    return $task->deleteTaskById();
                    
                }else {
                    // Gérer l'erreur si l'ID de la tâche n'est pas valide
                    return "ID de tâche invalide.";
                }
            } else {
                // Gérer l'erreur si l'ID de la tâche n'est pas défini ou vide
                return "ID de tâche non défini.";
            }
        }

        //afficher les taches de l'utilisateur connecté
        public function showUserTasks(){
            $display = "";
            if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
                if(filter_var($_SESSION['id'],FILTER_VALIDATE_INT)){
                    $task = new ModelTask();
                    $task->setIdUser(nettoyage($_SESSION['id']));
                    $data = $task->getTasksByUser();

                    if(gettype($data) == "array"){
                        foreach($data as $task){
                            $modelCategory = New ModelCategory();
                            $modelCategory->setId($task['id_category']);
                            $category = $modelCategory->getCategoryById();
                            $categories = $this->showCategories();
                            ob_start();
                            include '../app/view/components/taskCard.php';
                            $taskCard = ob_get_clean();
                            $display = $display . $taskCard;
                        }
                    }else{
                        $display = $data;
                    }
                } 
            }
            return $display;
        }

        //gestion de l'affichage
        public function render(){
            $this->getViewTask()->setMessage($this->createTask());
            $this->getViewTask()->setCategories($this->showCategories());
            $this->getViewTask()->setTasksList($this->showUserTasks());
            $this->setContent($this->getViewTask()->displayView());
            $this->renderPage();
        }

    }

?>