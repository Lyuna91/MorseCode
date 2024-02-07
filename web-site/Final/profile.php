<?php
include_once('./global/header.php');
?>

<html lang="fr">
<head>
    <title>Morse Code</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="./css/profile.css"/>
    <link rel="stylesheet" type="text/css" href="./css/base.css"/>
    <link rel="icon" type="image/png" href="images/logo.png"/>
</head>
<body>
<div class="container">
    <header>
        <?php
        include_once('./global/header.php'); // Inclusion du header
        ?>
    </header>
    <main>
      <span class="form">
        <?php
        if (isset($_GET['modify'])) { 
            ?>
            <!-- Formulaire pour afficher les informations de l'utilisateur et qu'on puisse les modifier-->
            <form method="POST" class="modification">
                <label for="username"><b>Your username</b></label>
                <input type="text" value="<?= isset($_SESSION['username']) ? $_SESSION['username'] : '' ?>"
                       name="username">

                <label for="email"><b>Your E-mail</b></label>
                <input type="text" value="<?= isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>" name="email">

                <button type="submit"><b>Save changes</b></button>
            </form>
            <?php
            // Requête de mise à jour des données de l'utilisateur
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['username'], $_POST['email'])) {
                    $modify_req = $bdd->prepare('UPDATE user SET username = ?, email = ? WHERE id_user = ?');
                    $modify_req->execute([$_POST['username'], $_POST['email'], $_SESSION['id_user']]);
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['email'] = $_POST['email'];
                }
                header('Location: profile.php');
                exit;
            }
        } else {
            ?>
          </span>
            <span class="infos">
                    <h2><?= $_SESSION['username'] ?><br></h2>
                    <p>
                        <?= $_SESSION['email'] . "<br>" ?>
                        Level : <?= $_SESSION['level'] . "<br>" ?>
                        Experience : <?= $_SESSION['experience'] . "/" . $_SESSION['objective'] . "<br>" ?>
                    </p>
                    <!-- Page par URL (similaire à GET) -->
                    <a href="?modify=1" class="button" id="B">Modify</a>
                    <!-- Redirection vers la déconnexion -->
                    <a href="logout.php"class="button" id="B"> Logout </a>
                    <?php
                    // Si l'utilisateur est admin, apparition d'un nouveau bouton pour afficher les avantages des admins
                    if(isAdmin()){
                      echo "<a href='administration.php' class='button' id='B'> Admin</a>";
                    }
                    ?>
                  
            </span>
            <?php
        }
        ?>
    </main>
</div>
</body>
</html>
