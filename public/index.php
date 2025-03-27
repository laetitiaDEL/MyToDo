<?php

/*
Le routing consiste à rediriger les différentes URL vers le bon controller. Il vient en complément du modèle MVC.

Toutes nos requêtes http passeront par ce router. Celui-ci redirigera vers le bon controler.
Nous utiliserons pour se faire la réécriture des url du serveur apache dans un environnement AMP (Apache, Mysql, Php).

réécriture des url : cf .htaccess

*/

//démarrer la session
session_start();

//import des fichiers de configuration
include '../env.php';
include '../utils/functions.php';

//import des controllers
use App\controller\ControllerHome;
use App\controller\ControllerAccount;
use App\controller\ControllerCategory;
use App\controller\ControllerTask;
use App\controller\ControllerError;
//import de l'autoloader
use App\Autoloader;

//chargement automatique des classes
require_once '../app/Autoloader.php';
App\Autoloader::register();

//instancier les controllers
$home = new ControllerHome();
$account = new ControllerAccount();
$category = new ControllerCategory();
$task = new ControllerTask();

/*--------------------------
            ROUTER 
-----------------------------*/
//Analyse l'URL envoyée par l'utilisateur, avec parse_url() et retourne ses composants
$url = parse_url($_SERVER['REQUEST_URI']);

//test si l'url a une route sinon on renvoie à la racine
$path = isset($url['path']) ? $url['path'] : '/';

// Supprimer la base du projet du chemin
$path = str_replace(BASE_URL, '', $path);

//test de la valeur $path dans l'URL et import de la ressource
try {
    // Route / -> ./controller/controllerHome.php
    switch (true) {
        case $path == "/":
            $home->render();
            break;

        // Route /account -> ./controller/controllerAccount.php
        case $path == "/account":
            if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                $account->render();
            } else {
                header('Location: ' . BASE_URL);
                exit();
            }
            break;

        // Route /category -> ./controller/controllerCategory.php
        case $path == "/category":
            if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                $category->render();
            } else {
                header('Location: ' . BASE_URL);
                exit();
            }
            break;

        // Route /task -> ./controller/controllerTask.php
        case $path == "/task":
            if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                if(isset($_POST['submitEdit']) && !empty($_POST['submitEdit'])){
                    $task->editTask();
                }
                if(isset($_POST['submitDelete']) && !empty($_POST['submitDelete'])){
                    $task->deleteTask();
                }
                $task = new ControllerTask();
                $task->render();
            } else {
                header('Location: ' . BASE_URL);
                exit();
            }
            break;

        // Route /out -> ./controller/deconnexion.php
        case $path == "/out":
            if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
                include '../app/controller/deconnexion.php';
            } else {
                header('Location: ' . BASE_URL);
                exit();
            }
            break;

        default:
            throw new Exception();
    }
} catch (Exception $e) {
    $error = new ControllerError();
    $error->render();
}

?>



