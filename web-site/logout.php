<?php
session_start();
session_destroy(); // Destruction de la session ce qui implique une déconnexion
header('location:home.php'); // Redirige vers l'accueil

?>