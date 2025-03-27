<?php

namespace App\view;

    class ViewTask {
        //attributs
        private ?string $message = "";
        private ?string $categories = "";
        private ?string $tasksList = "";
        private ?array $tasksListCal = [];

        //getter setter
        public function getMessage(): ?string { 
            return $this->message; 
        }
        public function setMessage(?string $message): self { 
            $this->message = $message; 
            return $this; 
        }

        public function getCategories(): ?string { 
            return $this->categories; 
        }
        public function setCategories(?string $categories): self { 
            $this->categories = $categories; 
            return $this; 
        }

        public function getTasksList(): ?string { 
            return $this->tasksList; 
        }
        public function setTasksList(?string $tasksList): self { 
            $this->tasksList = $tasksList; 
            return $this; 
        }

        public function getTasksListCal(): ?array { 
            return $this->tasksListCal; 
        }
        public function setTasksListCal(?array $tasksListCal): self { 
            $this->tasksListCal = $tasksListCal; 
            return $this; 
        }

        //methods
        public function displayView(){
            $categories = $this->getCategories();
            ob_start();
            include "../app/view/components/taskForm.php";
            $form = ob_get_clean();
            ob_start();
            include "../app/view/components/calendar.php";
            $calendar = ob_get_clean();
            return '
                <section class="container">
                    <div class="row" style="height: 100%;">
                        <div class="col col-lg-4 col-12 d-flex flex-column" style="height: 100%;">
                            <div>
                                <h2>Nouvelle Tache</h2>
                                <div class="card">
                                    '. $form .'
                                </div>
                                <p>'. $this->getMessage() .'</p>
                            </div>
                            <div class="card calendar flex-grow-1 d-flex flex-column" style="min-height: 0; height: 100%;">
                                '.$calendar.'
                            </div>
                        </div>
                        <div class="col col-lg-8 col-12 overflow-hidden"> 
                            <h2>Liste des Taches</h2>
                            <div class="customScroll">
                                '. $this->getTasksList() .'
                            </div>
                        </div>
                    </div>
                </section>
            ';
        }
    }

?>

