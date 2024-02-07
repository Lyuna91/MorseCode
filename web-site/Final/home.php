<!DOCTYPE html>
<html lang=en>
    <head>
        <title> Morse Code </title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./css/base.css" />
        <link rel="stylesheet" type="text/css" href="./css/home.css" />
        <link rel="icon" type="image/png" href="./images/logo.png" />
    </head>
    <body>
        <div class="container">
        <?php
        include_once('./global/header.php'); // Inclusion du header
        ?>
        <main>
            <h1> Code morse </h1> 
            <h4> Let's learn morse code the <b> carlos goat </b> way.</h4>
            <a class="button" id="A" href="#here"> <b> Start here </b> </a>
        </main>
        <nav id="here">
            <div class=title>
                <?php
                if(connected()){ // Vérifie si un utlisateur est connecté
                    echo "<h1>Hello, ".$_SESSION['username']. "!</h1>"; // Affiche le pseudo de l'utilisateur
                } 
                else{
                    echo "<h1>Hello, not connected person!</h1>"; // SI personne n'est connecté...
                }
                ?>
                <h3> What would you like to do ? </h3>
            </div>
            <div class="navigation">
                <!-- Vers le manuel -->
                <article id="manual">
                    <h2> Manual </h2>
                    <p>Documentation with all letters and abbreviations.</p>
                    <img src="./images/icon-manual.png" class="icon"/>
                    <a href="manual.php" class="button" id="B"> GO !</a> <!-- -->
                </article>
                <!-- Vers les exercices -->
                <article id="exercices">
                    <h2> Exercices </h2>
                    <p> All kinds of exercises to learn and practice </p>
                    <img src="./images/icon-exercice.png" class="icon"/>
                    <a href="index.php" class="button" id="B">  GO !</a>
                </article>
                <!-- Vers le traducteur -->
                <article id="translator">
                    <h2> Translator </h2>
                    <p> If you want to take the easy way out, this is the place.</p>
                    <img src="./images/icon-translator.png" class="icon" id="short-icon"/>
                    <a href="translator.php" class="button" id="B">  GO!</a>
                </article>
            </div>
        </nav>
        <footer>
            <!-- Footer avec lien vers certains de mes réseaux -->
            <img src="./images/icon-linkedin.png" alt="my linkedin" class="footer-icon">
            <img src="./images/icon-insta.png" alt="my IG account" class="footer-icon"/>
            <img src="./images/icon-person.png" alt="my account" class="footer-icon"/>
            <img src="./images/icon-discord.png" alt="my discord server" class="footer-icon"/>
            <a href="goat.html">
                <img src="./images/icon-goat.png" alt="the GOAT" class="footer-icon" id="GOAT">
            </a>
        </footer>
        </div>
    </body>
</html>
