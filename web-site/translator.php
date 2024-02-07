<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Morse Code</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./css/base.css" />
        <link rel="stylesheet" type="text/css" href="./css/translator.css" />
        <link rel="icon" type="image/png" href="./images/logo2.png" />
    </head>
    <body>
        <div class="container"> 
            <?php include_once('./global/header.php'); // Inclusion du header
            ?>



<?php
// Préparation de la requête des lettres
$letters_req = $bdd->prepare('SELECT original, morse FROM letter'); 
$letters_req->execute();
$letters = $letters_req->fetchAll();



/* Gestion du select */

if (isset($_POST['translate'])) // Vérifie qu'un texte à bien été soumis
{   // Si $_POST['direction'] existe et si la direction est égale à 1 (traduction texte vers morse)
    if(isset($_POST["direction"]) && ($_POST["direction"] == 1)){ 
        $textToTranslate = $_POST["translate"];
        $translatedText = translateTextMorse($textToTranslate, $letters);
    // Treaduction morse vers texte
    }else{
        $textToTranslate = $_POST['translate'];
        $translatedText = translateMorseText($textToTranslate, $letters);
    }
}

?>
            <main>
                <form method="POST">
                    <!-- Formulaire pour choisis le sens de traducteur et entrer du texte-->
                    <label>Choose the direction</label>
                    <!-- Choix de la direction de la traduction -->
                    <select name="direction">
                        <option value="1" <?php if (isset($_POST["direction"]) && $_POST["direction"] == 1) echo "selected"; ?>>Text to
                            Morse Code</option>
                        <option value="2" <?php if (isset($_POST["direction"]) && $_POST["direction"] == 2) echo "selected"; ?>>Morse
                            Code to Text</option>
                    </select>
                    <!-- INPUT (entrée du texte morse ou normal) / OUTPUT (sortie traduite) -->
                    <textarea id="input" rows="4" cols="50" placeholder="Enter your text to translate here..."
                        name="translate" selected><?php if (isset($translatedText)) echo $_POST['translate']; ?></textarea>
                    <button type="submit">Translate</button>
                    <textarea id="output" rows="4" cols="50" placeholder="Translated text here..."name="translated"
                        readonly><?php if (isset($translatedText)) echo $translatedText; ?></textarea>
                </form>
            </main>
        </div>
    </body>
</html>

