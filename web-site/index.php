<!DOCTYPE html>
<html lang="en">
<head>
    <title>Morse Code</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./css/base.css" />
    <link rel="stylesheet" type="text/css" href="./css/index.css" />
    <link rel="icon" type="image/png" href="./images/logo.png" />
</head>
<body>
    <div class="container">
        <?php
            include_once('./global/header.php'); // Insertion du header
            $userLevel = $_SESSION['level'];

            if (!connected()) {
                header('location:login.php'); // Redirige vers la connection si personne n'est connecté
            }
        ?>
        <main>
            <!-- Formulaire de choix d'exercices -->
            <form method="GET" action="exercices.php">
                <!-- Niveau de l'exercice -->
                <label><b> Level </b></label> 
                <div>
                    <?php
                    // Affiche les niveaux en fonction du niveau de l'utilisateur
                        for ($i = 1; $i <= $userLevel; $i++) {
                            echo '<input type="radio" name="level" value="'.$i.'" required selected>'.$i.'</input>';
                        }
                    ?>
                </div>
                <!-- Direction de l'apprentissage (Question en Morse, répondez avec l'alphabet et vice versa) -->
                <label><b> Direction </b></label>
                <div>
                    <input type="radio" name="direction" value="T_M" required selected> Text to Morse code </input>
                    <input type="radio" name="direction" value="M_T" required> Morse code to text </input>
                </div>
                <!-- Choix du type de réponse. Soit on choisis les réponses parmis les proposer, sois on l'écris -->
                <label><b> Answer type </b></label>
                <div>
                    <input type="radio" name="answer" value="typing" required selected> Type </input>
                    <input type="radio" name="answer" value="select" required> Select </input>
                </div>
                <button type="submit"> Start </button> 
            </form>
        </main>
    </div>
</body>
</html>
