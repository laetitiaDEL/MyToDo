<?php
//Le controller de l'accueil

namespace App\controller;

use App\view\ViewHome;
use App\model\ModelUser;

    class ControllerHome extends GenericController {
        //attributs
        private ViewHome $viewHome;
        private ModelUser $modelUser;

        //constructeur
        public function __construct(){
            parent::__construct();
            $this->viewHome = new ViewHome();
            $this->modelUser = new ModelUser();
        }

        //methodes
        //getter setter
        public function getViewHome(){
            return $this->viewHome;
        }

        public function setViewHome($viewHome){
            $this->viewHome = $viewHome;
        }

        public function getModelUser(){
            return $this->modelUser;
        }

        public function setModelUser($modelUser){
            $this->modelUser = $modelUser;
        }

        //Inscription d'un nouvel utilisateur
        public function createUser(){
            //Vérifier que je reçois le formulaire d'inscription
            if(isset($_POST['submitInscription'])){
                //Vérifie que les données ne sont pas vides
                if(isset($_POST['name']) && !empty($_POST['name'])
                && isset($_POST['firstname']) && !empty($_POST['firstname'])
                && isset($_POST['email']) && !empty($_POST['email'])
                && isset($_POST['password']) && !empty($_POST['password'])
                && isset($_POST['passwordVerify']) && !empty($_POST['passwordVerify'])){

                    //Vérifier que le mail est au bon format
                    if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){

                        //Vérifie que les 2 mots de passe correspondent
                        if($_POST['password'] === $_POST['passwordVerify']){

                            //Nettoyage des données
                            $name = nettoyage($_POST['name']);
                            $firstname = nettoyage($_POST['firstname']);
                            $email = nettoyage($_POST['email']);
                            $password = nettoyage($_POST['password']);
                            $passwordVerify = nettoyage($_POST['passwordVerify']);

                            //Hasher le mot de passe
                            $password = password_hash($password, PASSWORD_BCRYPT);

                            //création de l'utilisateur
                            $user = $this->getModelUser();

                            //attribution des valeurs
                            $user->setName($name);
                            $user->setFirstname($firstname);
                            $user->setEmail($email);
                            $user->setPassword($password);

                            //vérifier que l'utilisateur n'existe pas déjà dans la BDD
                            $data = $user->getUserByEmail();

                            if(empty($data)){

                                //on commence à enregistrer le compte en BDD
                                return $user->insertUser($bdd);

                            }else{
                                return "Cet email est déjà utilisé par un autre compte.";
                            }
                        }else{
                            return "Vos deux mots de passe ne correspondent pas.";
                        }
                    }else{
                        return "Votre email n'est pas au bon format.";
                    }
                }else{
                    return "Veuillez remplir tous les champs.";
                }
            }
        }

        //vérifier que l'on reçoit le formulaire de connexion
        public function login(){
            if(isset($_POST['submitConnexion'])){

                //vérifier que les données ne sont pas vides
                if(isset($_POST['emailConnexion']) && !empty($_POST['emailConnexion'])
                && isset($_POST['passwordConnexion']) && !empty($_POST['passwordConnexion'])){

                    //Vérifier que le mail est au bon format
                    if(filter_var($_POST['emailConnexion'],FILTER_VALIDATE_EMAIL)){

                        //nettoyer les inputs
                        $email = nettoyage($_POST['emailConnexion']);
                        $password = nettoyage($_POST['passwordConnexion']);

                        //création de l'utilisateur
                        $user = $this->getModelUser();

                        //attribution des valeurs
                        $user->setEmail($email);
                        $user->setPassword($password);

                        //récupérer l'utilisateur par son mail
                        $data = $this->getModelUser()->getUserByEmail();

                        //vérifier qu'on a bien un utilisateur
                        if(!empty($data)){

                            //vérifier la correspondance des mots de passe
                            if(password_verify($password, $data[0]['mdp_user'])){
                                $_SESSION['id'] = $data[0]['id_user'];
                                $_SESSION['name'] = $data[0]['name_user'];
                                $_SESSION['firstname'] = $data[0]['firstname_user'];
                                $_SESSION['email'] = $data[0]['email_user'];

                                header('Location: '. url('/account'));
                            }else{
                                return "Login et/ou mot de passe incorrect(s).";
                            }

                        }else{
                            return "Login et/ou mot de passe incorrect(s).";
                        }
                    }
                }else{
                    return "Veuillez remplir les champs.";
                }
            }
        }

        //affichage de tous les utilisateurs
        public function showUsers(){
            //j'appelle la fonction qui récupère tous les utilisateurs
            $data = $this->getModelUser()->getAllUsers();

            $display = "";

            //je parcours le tableau data, pour générer mon affichage
            foreach($data as $user){
                $display = $display."<li>{$user['firstname_user']} {$user['name_user']} : {$user['email_user']}</li>";
            }

            return $display;
        }

        //gestion de l'affichage
        public function render(){
            $this->getViewHome()->setMessage($this->createUser());
            $this->getViewHome()->setUsersList($this->showUsers());
            $this->getViewHome()->setMessageConnexion($this->login());
            $this->setContent($this->getViewHome()->displayView());
            $this->renderPage();
        }
    }

?>