<?php
// Obtenez le nom du fichier actuel
$current_page = basename($_SERVER['PHP_SELF']);

// Démarrage des variables de session
session_start();

// Inclusion des variables pour la connection à la BDD
include_once 'functions.php';
include_once 'bdd.php';
try {
    // Connexion en BDD
    $bdd = new PDO("mysql:host=$bdd_host:$bdd_port;dbname=$bdd_nom_base;charset=utf8", $bdd_user, $bdd_password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<header>
    <?php
    // Gestion de l'affichage du header

    // Sur la page home, à gauche le logo, à droite login si non connecté et profile si connecté
    if ($current_page == 'home.php') {
        echo '<img src="./images/logo.png" alt="site\'s logo" id="logo"/>';
        if(connected()){
            echo '<a href="profile.php" class="button" id="B"> <b> Profile </b> </a>';
        }
        else{
            echo '<a href="login.php" class="button" id="B"> <b> Login </b> </a>';
        }
    // Pour les pages login.php, register.php et profile.php, on met juste un bouton qui permet de retourner à home
    } elseif ($current_page == 'login.php' || $current_page == 'register.php' || $current_page == 'profile.php') {
        echo '<a href="home.php"><img src="./images/icon-home.png" alt="Home Icon" style="height: 50px;"></a>';
    }
    // Pour toutes les autres pages, un bouton pour retourner à home.php à gauche, à droite login si non connecté et profile si connecté
    else{
        echo '<a href="home.php"><img src="./images/icon-home.png" alt="Home Icon" style="height: 50px;"></a>';
        if(connected()){
            echo '<a href="profile.php" class="button" id="B"> <b> Profile </b> </a>';
        }
        else{
            echo '<a href="login.php" class="button" id="B"> <b> Login </b> </a>';
        } 
    }
    ?>
</header>

