<?php
/////////////////////////////////////
//Création des Fonctions Utilitaires
/////////////////////////////////////

/*nettoyage() : enlève les balises HTML, PHP, les espaces et les caractères d'échappement
* Param : $data -> string
* Return : string
*/
function nettoyage($data){
    return htmlentities(strip_tags(stripslashes(trim($data))));
}

/**
 * DBconnect() : crée un objet de connexion à la BDD
 * Param : void
 * Return : object PDO
 */
function DBconnect(){
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
    $bdd = new \PDO($dsn, DB_USER, DB_PASS, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
    return $bdd;
}

/**
 * Génère une URL complète en ajoutant la base du projet.
 *
 * @param string $path Le chemin à ajouter à la base de l'URL.
 * @return string L'URL complète.
 */
function url($path = '') {
    return BASE_URL . $path;
}
?>
