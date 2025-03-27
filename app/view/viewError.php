<?php

namespace App\view;

class ViewError{
    //METHOD
    public function displayView():string{
        ob_start();
?>
        <h1>Erreur 404 : Cette page n'existe pas...</h1>
<?php
        return ob_get_clean();
    }
}