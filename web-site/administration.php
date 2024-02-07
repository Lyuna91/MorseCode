<!DOCTYPE html>
<html lang=en>
    <head>
        <title> Morse Code </title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./css/base.css" />
        <link rel="stylesheet" type="text/css" href="./css/administration.css" />
        <link rel="icon" type="image/png" href="./images/logo.png" />
    </head>
    <body>
        <div class="container">
        <?php
        include_once('./global/header.php'); // Inclusion du header
        ?>
    <main>

<?php

$modifyWordId = null;
$newOriginal = '';
$newMorse = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Requête eset du password d'un utilisateur
    if (isset($_POST["reset_password"]) && isset($_POST["user_password"]) && isset($_POST["new_password"])) {
        $new_password = $_POST["new_password"];
        $hashed_password = encryptPassword($new_password);
        $update_password_query = $bdd->prepare('UPDATE user SET password = ? WHERE id_user = ?');
        $update_password_query->execute([$hashed_password, $_POST["user_password"]]);

    // Requête de suppression d'un utilisateur
    } elseif (isset($_POST["delete_user"]) && isset($_POST["user_delete"])) {
        $delete_user_query = $bdd->prepare('DELETE FROM user WHERE id_user = ?');
        $delete_user_query->execute($_POST["user_delete"]);

    // Requête de reset de l'expérience d'un utilisateur
    } elseif (isset($_POST["reset_experience"]) && isset($_POST["user_reset"])) {
        $reset_user_query = $bdd->prepare('UPDATE user SET experience = 0, objective = 100, level = 1 WHERE id_user = ?');
        $reset_user_query->execute([$_POST["user_reset"]]);

    // Rquête de suppression d'un mot de la BDD
    } elseif (isset($_POST["delete_word"]) && isset($_POST["word_delete"])) {
        $delete_word_query = $bdd->prepare('DELETE FROM word WHERE id = ?');
        $delete_word_query->execute([$_POST["word_delete"]]);

    // Requête de modification d'un mot de la BDD
    } elseif (isset($_POST["modify_word"]) && isset($_POST["word_id_to_modify"]) && isset($_POST["new_original"]) && isset($_POST["new_morse"])) {
        $word_id_to_modify = $_POST["word_id_to_modify"];
        $new_original = $_POST["new_original"];
        $new_morse = $_POST["new_morse"];
        $modify_word_query = $bdd->prepare('UPDATE word SET original = ?, morse = ? WHERE id = ?');
        $modify_word_query->execute([$new_original, $new_morse, $word_id_to_modify]);

    } elseif (isset($_POST["cancel_modify"])) {
        $modifyWordId = null;

    // Requête d'ajout d'un mot dans la BDD
    } elseif (isset($_POST["add_word"]) && isset($_POST["new_original"]) && isset($_POST["new_morse"])) {
        $new_original = $_POST["new_original"];
        $new_morse = $_POST["new_morse"];
        $new_difficulty = strlen($new_original);
        $add_word_query = $bdd->prepare('INSERT INTO word (original, morse, difficulty) VALUES (?, ?, ?)');
        $add_word_query->execute([$new_original, $new_morse, $new_difficulty]);

    // Requête de suppresion d'une phrase dans la BDD
    } elseif (isset($_POST["delete_sentence"]) && isset($_POST["sentence_delete"])) {
        $delete_sentence_query = $bdd->prepare('DELETE FROM sentence WHERE id = ?');
        $delete_sentence_query->execute([$_POST["sentence_delete"]]);

    // Requête de modification d'une phrase dans la BDD
    } elseif (isset($_POST["modify_sentence"]) && isset($_POST["sentence_id_to_modify"]) && isset($_POST["new_sentence"])) {
        $sentence_id_to_modify = $_POST["sentence_id_to_modify"];
        $new_sentence = $_POST["new_sentence"];
        $modify_sentence_query = $bdd->prepare('UPDATE sentence SET sentence = ? WHERE id = ?');
        $modify_sentence_query->execute([$new_sentence, $sentence_id_to_modify]);
    } elseif (isset($_POST["cancel_sentence_modify"])) {
        $modifySentenceId = null;

    // Requête d'ajout d'une phrase dans la BDD
    } elseif (isset($_POST["add_sentence"]) && isset($_POST["original_sentence"]) && isset($_POST["morse_sentence"])) {
        $original_sentence = $_POST["original_sentence"];
        $morse_sentence = $_POST["morse_sentence"];
        $add_sentence_query = $bdd->prepare('INSERT INTO sentence (original, morse) VALUES (?,?)');
        $add_sentence_query->execute([$original_sentence,$morse_sentence]);
    }
}

// Requête de selection des users qui ne sont PAS admin
$users_list = $bdd->prepare('SELECT id_user, username, email, level, experience, objective FROM user WHERE admin = 0;');
$users_list->execute([]);
$users = $users_list->fetchAll();

// Requête de selection de mots de la BDD
$words_list = $bdd->prepare('SELECT id,original, morse, difficulty FROM word;');
$words_list->execute([]);
$words = $words_list->fetchAll();

// Requête de selection des phrases de la BDD
$sentences_list = $bdd->prepare('SELECT id, original, morse FROM sentence;');
$sentences_list->execute([]);
$sentences = $sentences_list->fetchAll();
?>

<html>
    <h1> Users </h1>
    <!-- Ajout d'un tableau pour affiche les users pas admin-->
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Level</th>
            <th>Experience</th>
            <th>Email</th>
            <th>Reset password</th> 
            <th>Reset level</th> 
            <th>Delete</th> 
        </tr>
        <!-- AFFICHAGE DES UTILISATEURS PAS ADMIN -->
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?= $user['id_user'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['level'] ?></td>
                <td><?= $user['experience'] . '/' . $user['objective'] ?></td>
                <td><?= $user['email'] ?></td>
                <!-- Formulaire pour créer un nouveau mot de passe -->
                <td>
                    <form method="post">
                        <input type="hidden" name="user_password" value="<?= $user['id_user'] ?>">
                        <label for="new_password">New Password :</label>
                        <input type="password" name="new_password" id="new_password" required>
                        <button type="submit" name="reset_password">Reset Password</button>
                    </form>
                </td>
                <!-- Bouton pour mettre l'expérience à 0 et l'objectif à 100 -->
                <td>
                    <form method="post">
                        <input type="hidden" name="user_reset" value="<?= $user['id_user'] ?>">
                        <button type="submit" name="reset_experience">Reset level</button>
                    </form>
                </td>
                <!-- Bouton supprimer l'utilisateur -->
                <td>
                    <form method="post">
                        <input type="hidden" name="user_delete" value="<?= $user['id_user'] ?>">
                        <button type="submit" name="delete_user">Delete user</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h1> Word gestion </h1>
    <!-- Ajout d'un tableau pour afficher les mots de la BDD-->
    <form method="post">
        <label for="new_original">Original Word:</label>
        <input type="text" name="new_original" id="new_original" required oninput="this.value = this.value.toUpperCase();">
        <label for="new_morse">Morse Word:</label>
        <input type="text" name="new_morse" id="new_morse" required>
        <button type="submit" name="add_word">Add Word</button>
    </form>
    <!-- AFFICHAGE DES MOTS DE LA BDD -->
    <table>
        <tr>
            <th>ID word</th>
            <th>Original word</th>
            <th>Morse word</th>
            <th>Difficulty</th>
            <th>Modify</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($words as $word) { ?>
            <tr>
                <td><?= $word['id'] ?></td>
                <td><?= $word['original'] ?></td>
                <td><?= $word['morse'] ?></td>
                <td><?= $word['difficulty'] ?></td>
                <!-- Formulaire pour modifier le mot (en morse et l'alphabet latin) -->
                <td>
                    <form method="post">
                        <input type="hidden" name="word_id_to_modify" value="<?= $word['id'] ?>">
                        <label for="new_original">New Original :</label>
                        <input type="text" name="new_original" id="new_original" value="<?= $word['original'] ?>" required>
                        <label for="new_morse">New Morse :</label>
                        <input type="text" name="new_morse" id="new_morse" value="<?= $word['morse'] ?>" required>
                        <button type="submit" name="modify_word">Modify</button>
                    </form>
                </td>
                <!-- Bouton pour supprimer un mot de la BDD -->
                <td>
                    <form method="post">
                        <input type="hidden" name="word_delete" value="<?= $word['id'] ?>">
                        <button type="submit" name="delete_word">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <!-- Tableau pour afficher les phrases de la BDD -->
    <h1> Sentence gestion </h1>
    <form method="post">
        <label for="original_sentence">Original Sentence:</label>
        <input type="text" name="original_sentence" id="new_sentence" required oninput="this.value = this.value.toUpperCase();">
        <label for="morse_sentence">Morse Sentence:</label>
        <input type="text" name="morse_sentence" id="new_sentence" required>
        <button type="submit" name="add_sentence">Add Sentence</button>
    </form>
    <!-- AFFICHAGE DES PHRASES DE LA BDD -->
    <table>
        <tr>
            <th>ID sentence</th>
            <th>Original sentence</th>
            <th>Morse sentence</th>
            <th>Modify</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($sentences as $sentence) { ?>
            <tr>
                <td><?= $sentence['id'] ?></td>
                <td><?= $sentence['original'] ?></td>
                <td><?= $sentence['morse'] ?></td>
                <!-- Bouton modification d'une phrase -->
                <td>
                    <form method="post">
                        <input type="hidden" name="sentence_id_to_modify" value="<?= $sentence['id'] ?>">
                        <label for="new_sentence">Original Sentence :</label>
                        <input type="text" name="original_sentence" id="original_sentence" value="<?= $sentence['original'] ?>" required>
                        <br>
                        <label for="new_sentence">Morse Sentence :</label>
                        <input type="text" name="morse_sentence" id="morse_sentence" value="<?= $sentence['morse'] ?>" required>
                        <button type="submit" name="modify_sentence">Modify</button>
                    </form>
                </td>
                <!-- Bouton suppression d'une phrase -->
                <td>
                    <form method="post">
                        <input type="hidden" name="sentence_delete" value="<?= $sentence['id'] ?>">
                        <button type="submit" name="delete_sentence">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
        </main>
    </body>
</html>
