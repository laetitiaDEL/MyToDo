<?php

namespace App\view;

class ViewCategory{
    //attributs
    private ?string $message = "";
    private ?string $categoriesList = "";

    //GETTER ET SETTER
    public function getMessage(): ?string { 
        return $this->message; 
    }
    public function setMessage(?string $message): self { 
        $this->message = $message; 
        return $this; 
    }

    public function getCategoriesList(): ?string { 
        return $this->categoriesList; 
    }
    public function setCategoriesList(?string $categoriesList): self { 
        $this->categoriesList = $categoriesList; 
        return $this; 
    }

    //methods
    public function displayView(): string {
        return '
            <main>
                <section>
                    <h1>Nouvelle Catégorie</h1>
                    <form action="" method="post">
                        <input type="text" name="nameCategory" placeholder="Nom catégorie">

                        <input type="submit" name="submitCategory" value="Ajouter">
                    </form>
                    <p>'. $this->getMessage() .'</p>
                </section>

                <section>
                    <h1>Liste des Catégories</h1>
                    <ul>
                        '. $this->getCategoriesList() .'
                    </ul>
                </section>
            </main>
        ';
    }
}


?>