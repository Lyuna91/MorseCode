<!DOCTYPE html>
<html lang=en>
    <head>
        <title> Morse Code </title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./css/base.css" />
        <link rel="stylesheet" type="text/css" href="./css/exercices.css" />
        <link rel="icon" type="image/png" href="./images/logo.png" />
    </head>
    <body>
<?php
      include_once('./global/header.php');

// Fonction pour la génération du tableau en fonction du niveau
function level($level){
    // Créeation des requêtes nécessaire pour le fonctionnement des niveau 1 à 10
    global $bdd;
    $req_letters = $bdd->prepare('SELECT original, morse FROM letter WHERE difficulty <= :difficulty ORDER BY RAND() LIMIT 1');
    $req_words = $bdd->prepare('SELECT original, morse FROM word WHERE difficulty <= :difficulty ORDER BY RAND() LIMIT 1');
    $req_codeq = $bdd->prepare('SELECT original, morse FROM code_q ORDER BY RAND() LIMIT 1');
    $req_sentences = $bdd->prepare('SELECT original, morse FROM sentence ORDER BY RAND() LIMIT 1');
    $array = [];
    if ($level == 1) {
        $req_letters->execute(['difficulty' => $_GET['level']]);
        $array = $req_letters->fetch();
    } elseif ($level == 2) {
        $req_letters->execute(['difficulty' => $_GET['level']]);
        $array = $req_letters->fetch();
    } elseif ($level == 3) {
        $req_letters->execute(['difficulty' => $_GET['level']]);
        $array = $req_letters->fetch();
    } elseif ($level == 4) {
        $req_letters->execute(['difficulty' => $_GET['level']]);
        $array = $req_letters->fetch();
    } elseif ($level == 5) {
        $req_letters->execute(['difficulty' => $_GET['level']]);
        $array = $req_letters->fetch();
    }elseif ($level == 6) {
        $req_words->execute(['difficulty' => 4]);
        $array = $req_words->fetch();
    }
    elseif ($level == 7) {
        $req_words->execute(['difficulty' => 5]);
        $array = $req_words->fetch();
    }
    elseif ($level == 8) {
        $req_words->execute(['difficulty' => 6]);
        $array = $req_words->fetch();
    }
    elseif ($level == 9) {
        $req_codeq->execute();
        $array = $req_codeq->fetch();
    }
    elseif ($level == 10) {
        $req_sentences->execute();
        $array = $req_sentences->fetch();
    }
    return $array;
}

$array = level($_GET['level']);

if(!isset($_SESSION['correct_answers'])){
    $_SESSION['correct_answers'] = 0;
}
if(!isset($_SESSION['false_answers'])){
    $_SESSION['false_answers'] = 0;
}


// Création des variables de session pour l'enregistrement de la bonne réponses
// Plus génération de nouvelles réponses si le type de réponses est "SELECT"

// Sens Morse vers texte
if($_GET['direction'] == 'M_T'){
    if(!isset($_SESSION['answer'])){
        $_SESSION['previous_answer'] = '';
    }
    else{
        $_SESSION['previous_answer'] = $_SESSION['answer'];
    }
        $_SESSION['random'] = $array['morse'];
        $_SESSION['answer'] = $array['original'];
    if($_GET['level'] < 6){
        $wrong_answer_req = $bdd->prepare('SELECT original, morse FROM letter WHERE original != :answer AND difficulty <= :difficulty ORDER BY RAND() LIMIT 3');
        $wrong_answer_req->execute(['answer' => $_SESSION['answer'], 'difficulty' => $_GET['level']]);
        $answers = $wrong_answer_req->fetchAll();
        $correct_answer = ['original' => $_SESSION['answer'], 'morse' => $_SESSION['random']];
        array_push($answers, $correct_answer);
        shuffle($answers);
    }
    elseif($_GET['level'] < 8){
        $wrong_answer_req = $bdd->prepare('SELECT original, morse FROM word WHERE original != :answer AND difficulty <= :difficulty ORDER BY RAND() LIMIT 3');
        $wrong_answer_req->execute(['answer' => $_SESSION['answer'], 'difficulty' => $_GET['level']]);
        $answers = $wrong_answer_req->fetchAll();
        $correct_answer = ['original' => $_SESSION['answer'], 'morse' => $_SESSION['random']];
        array_push($answers, $correct_answer);
        shuffle($answers);
    }
    elseif($_GET['level'] == 9){
        $wrong_answer_req = $bdd->prepare('SELECT original, morse FROM code_q WHERE original != :answer  ORDER BY RAND() LIMIT 3');
        $wrong_answer_req->execute(['answer' => $_SESSION['answer']]);
        $answers = $wrong_answer_req->fetchAll();
        $correct_answer = ['original' => $_SESSION['answer'], 'morse' => $_SESSION['random']];
        array_push($answers, $correct_answer);
        shuffle($answers);
    }
    elseif($_GET['level'] == 10){
        $wrong_answer_req = $bdd->prepare('SELECT original, morse FROM sentence WHERE original != :answer  ORDER BY RAND() LIMIT 3');
        $wrong_answer_req->execute(['answer' => $_SESSION['answer']]);
        $answers = $wrong_answer_req->fetchAll();
        $correct_answer = ['original' => $_SESSION['answer'], 'morse' => $_SESSION['random']];
        array_push($answers, $correct_answer);
        shuffle($answers);
    }
// Sens texte vers morse
}else{
    if(!isset($_SESSION['answer'])){
        $_SESSION['previous_answer'] = '';
    }
    else{
        $_SESSION['previous_answer'] = $_SESSION['answer'];
    }
        $_SESSION['random'] = $array['original'];
        $_SESSION['answer'] = $array['morse'];
    if($_GET['level'] < 6){
        $wrong_answer_req = $bdd->prepare('SELECT original, morse FROM letter WHERE morse!= :answer AND difficulty <= :difficulty ORDER BY RAND() LIMIT 3');
        $wrong_answer_req->execute(['answer' => $_SESSION['answer'], 'difficulty' => $_GET['level']]);
        $answers = $wrong_answer_req->fetchAll();
        $correct_answer = ['original' =>$_SESSION['random'] , 'morse' => $_SESSION['answer']];
        array_push($answers, $correct_answer);
        shuffle($answers);
    }
    elseif($_GET['level'] < 8){
        $wrong_answer_req = $bdd->prepare('SELECT original, morse FROM word WHERE morse != :answer AND difficulty <= :difficulty ORDER BY RAND() LIMIT 3');
        $wrong_answer_req->execute(['answer' => $_SESSION['answer'], 'difficulty' => $_GET['level']]);
        $answers = $wrong_answer_req->fetchAll();
        $correct_answer = ['original' => $_SESSION['answer'], 'morse' => $_SESSION['answer']];
        array_push($answers, $correct_answer);
        shuffle($answers);
    }
    elseif($_GET['level'] == 9){
        $wrong_answer_req = $bdd->prepare('SELECT original, morse FROM code_q WHERE morse != :answer  ORDER BY RAND() LIMIT 3');
        $wrong_answer_req->execute(['answer' => $_SESSION['answer']]);
        $answers = $wrong_answer_req->fetchAll();
        $correct_answer = ['original' => $_SESSION['answer'], 'morse' => $_SESSION['answer']];
        array_push($answers, $correct_answer);
        shuffle($answers);
    }
    elseif($_GET['level'] == 10){
        $wrong_answer_req = $bdd->prepare('SELECT original, morse FROM sentence WHERE morse != :answer  ORDER BY RAND() LIMIT 3');
        $wrong_answer_req->execute(['answer' => $_SESSION['answer']]);
        $answers = $wrong_answer_req->fetchAll();
        $correct_answer = ['original' => $_SESSION['answer'], 'morse' => $_SESSION['answer']];
        array_push($answers, $correct_answer);
        shuffle($answers);
    }
}




// Création des formulaires pour le type de façon de répondre

// Formulaire si le type de réponse est 'typing'
if($_GET['answer'] == 'typing'){
    echo '<main>';
    echo '<span>';
	echo '<form method="POST" action="">';
        echo '<div class="letter" > <h3>'.$_SESSION['random'].'</h3></div>';
      	echo '<input type="text" id="textInput" name="answer" autofocus oninput="this.value = this.value.toUpperCase();"><br>';
        echo '<button type="submit" name="check">Check</button><br>';
        echo '<button type="submit" name="stop">Stop</button><br>';
        echo '<a href="index.php" class="button" id="B"> Back </a>';
        echo '</form>';
        if(isset($_POST['check'])){
            if (isset($_POST['answer'])) {
                $user_answer = $_POST['answer'];
                if ($user_answer == $_SESSION['previous_answer']) {
                        echo "<p>Correct!</p>";
                        $_SESSION['correct_answers'] += 1;
                } else {
                        echo "<p>FAIL. Try again with a new letter.</p>";
                        $_SESSION['false_answers'] += 1;
                }
            }
            else {
                echo "FAIL. Try again with a new letter.";
                $_SESSION['false_answers'] += 1;
            }
        }
        elseif(isset($_POST['stop'])){
            $_SESSION['experience'] = experience_calcul($_SESSION['correct_answers'], $_SESSION['false_answers'],$_SESSION['experience']);
            $previous_objective = $_SESSION['objective'];
            $_SESSION['objective'] = objective_calcul($_SESSION['experience'], $_SESSION['objective'], $_SESSION['level']);
            $_SESSION['level'] = level_calcul($_SESSION['experience'], $previous_objective, $_SESSION['level']);
            $add_level_xp = $bdd->prepare('UPDATE user SET experience = ?, level = ?, objective = ?  WHERE username = ?');   
            $add_level_xp->execute([$_SESSION['experience'],$_SESSION['level'],$_SESSION['objective'], $_SESSION['username']]); 
            $_SESSION['correct_answers'] = 0;
            $_SESSION['false_answers'] = 0;
        }
}
// Formulaire si le type de réponse est 'select'
else{
    echo '<form method="POST" action="">';
    echo '<div class="letter" > <h3>'.$_SESSION['random'].'</h3></div>';
    // Génération des input type radio pour les réponses
    foreach ($answers as $answer) {
        if($_GET['direction'] == 'T_M'){
            $wrong_answers = $answer['morse'];
        }
        else{
            $wrong_answers = $answer['original'];
        }
        echo "<input type='radio' name='answer' value='".$wrong_answers."'>".$wrong_answers."</input>";
    }
    echo '<button type="submit" name="check">Check</button>';
    echo '<button type="submit" name="stop">Stop</button>';
    echo '<a href="index.php" class="button" id="B"> Back </a>';

    echo '</form>';
    // Vérifier si la réponse de l'utilisateur est égal à la question
    if(isset($_POST['check'])){
        if (isset($_POST['answer'])) {
            $user_answer = $_POST['answer'];
            if ($user_answer == $_SESSION['previous_answer']) {
                // Si bonne réponse
                echo "<p>Correct!</p>";
                if (isset($_SESSION['correct_answers'])) {
                    $_SESSION['correct_answers'] += 1;
                }
            } else {
                // Si mauvaise réponse
                echo "<p>FAIL. Try again with a new letter.</p>";
                if (isset($_SESSION['false_answers'])) {
                    $_SESSION['false_answers'] += 1;
                }
            } 
        }           
        else {
            // Si pas de réponse
            echo "FAIL. Try again with a new letter.";
            $_SESSION['false_answers'] += 1;
        }
    }
    // Arrêt de l'exercice, comptage des bonnes et mauvaises réposnes et mise à jour du niveau, de l'expétérience et de l'objectif
    elseif(isset($_POST['stop'])){
        $_SESSION['experience'] = experience_calcul($_SESSION['correct_answers'], $_SESSION['false_answers'],$_SESSION['experience']);
        $previous_objective = $_SESSION['objective'];
        $_SESSION['objective'] = objective_calcul($_SESSION['experience'], $_SESSION['objective'], $_SESSION['level']);
        $_SESSION['level'] = level_calcul($_SESSION['experience'], $previous_objective, $_SESSION['level']);
        $add_level_xp = $bdd->prepare('UPDATE user SET experience = ?, level = ?, objective = ?  WHERE username = ?');   
        $add_level_xp->execute([$_SESSION['experience'],$_SESSION['level'],$_SESSION['objective'], $_SESSION['username']]); 
        $_SESSION['correct_answers'] = 0;
        $_SESSION['false_answers'] = 0;
    }
    }
?>
</span>
</main>
</body>
</html>
