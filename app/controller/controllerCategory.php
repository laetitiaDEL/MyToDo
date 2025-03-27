<?php
//Le controller de la page catégorie

namespace App\controller;

    use App\view\ViewCategory;
    use App\model\ModelCategory;

    class ControllerCategory extends GenericController {
        //attributs
        private ViewCategory $viewCategory;
        private ModelCategory $modelCategory;

        //constructeur
        public function __construct(){
            //appeler le constructeur du parent avant de faire la suite (sinon celui l'écrase)
            parent::__construct();
            $this->viewCategory = new ViewCategory();
            $this->modelCategory = new ModelCategory();
        }

        //getter setter
        public function getViewCategory(){
            return $this->viewCategory;
        }

        public function setViewCategory($viewCategory){
            $this->viewCategory = $viewCategory;
        }

        public function getModelCategory(){
            return $this->modelCategory;
        }

        public function setModelUser($modelCategory){
            $this->modelCategory = $modelCategory;
        }
    

        //Création d'une nouvelle catégorie
        public function createCategory(){
            //Vérifier que je reçois le formulaire de création
            if(isset($_POST['submitCategory'])){
                //Vérifie que les données ne sont pas vides
                if(isset($_POST['nameCategory']) && !empty($_POST['nameCategory'])){

                    //Nettoyage des données
                    $name = nettoyage($_POST['nameCategory']);

                    //instanciation d'un nouvel objet user
                    $category = $this->getModelCategory();

                    //attribution des valeurs
                    $category->setName($name);

                    //vérifier que la catégorie n'existe pas déjà dans la BDD
                    $data = $category->getCategoryByName();

                    if(empty($data)){

                        //on commence à enregistrer la catégorie
                        return $category->insertCategory();

                    }else{
                        return "Cette catégorie existe déjà.";
                    }
                }else{
                    return "Veuillez remplir tous les champs.";
                }
            }
        }

        //affichage des catégories
        public function showCategories(){
            //j'appelle la fonction qui récupère toutes les catégories
            $data = $this->getModelCategory()->getAllCategories();

            //je parcours le tableau data, pour générer mon affichage
            $display = '';
            foreach($data as $category){
                $display = $display."<li>{$category['name_category']}</li>";
            }
            
            return $display;
        }

        //gestion de l'affichage
        public function render(){
            $this->getViewCategory()->setMessage($this->createCategory());
            $this->getViewCategory()->setCategoriesList($this->showCategories());
            $this->setContent($this->getViewCategory()->displayView());
            $this->renderPage();
        }
    }

?>