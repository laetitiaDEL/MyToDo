<?php

namespace App;

class Autoloader {

    //permet d'enregistrer notre autoloader
    static function register(){
        //spl_autoload_register() permet d'enregistrer une fonction comme implémentation de __autoload()
        //__CLASS__ est une constante magique qui retourne le nom de la classe courante
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    //permet de charger une classe
    //autoload() est une fonction magique qui est appelée lorsqu'une classe est instanciée et que cette classe n'est pas encore déclarée
    static function autoload($class){
        //si la classe commence par le namespace de notre application
        if(strpos($class, __NAMESPACE__.'\\') === 0){
            //remplacer le namespace par le chemin vers le dossier app
            //str_replace() remplace toutes les occurrences de la chaîne de caractères recherchée dans la chaîne de caractères par une autre chaîne de caractères
            $class = str_replace(__NAMESPACE__.'\\', '', $class);
            $class = str_replace('\\', '/', $class);
            //require le fichier correspondant à la classe
            //require() est identique à include(), mais émet une erreur de niveau E_COMPILE_ERROR en cas d'échec
            require __DIR__ .'/'. $class . '.php';
        }
    }
}

?>