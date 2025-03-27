<?php

//lancer la session
session_start();

//detruire la session
session_destroy();

//rediriger vers l'accueil
header('Location: '. url('/'));
exit;

?>