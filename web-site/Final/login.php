<html lang="fr">
  <head>
    <title> Morse Code </title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="./css/login.css" />
    <link rel="stylesheet" type="text/css" href="./css/base.css" />
    <link rel="icon" type="image/png" href="images/logo.png" />
  </head>
  <body>
    <div class="container">
      <?php
      include_once('./global/header.php'); // Inclusion du header
      ?>
        <main>
            <span>
                <!-- Permet de rediriger vers register.php si on souhaite se créer un compte -->
                <h2> No account? </h2>
                <a class="button" id="B" href="register.php"> Register </a> 
                <!-- Formulaire pour se connecté -->
                <form method="POST">
                    <label for="username"> <b> Enter your username </b> </label>
                    <input type="text" name="username" required>
                    <label for="password"> <b> Enter your password </b></label>
                    <input type="password" name="password" required>
                    <button type="submit"> <b> Login </b> </button>
                </form>
                <?php
                  // Si un username et un password on été récuperer depuis le formulaire
                  if(isset($_POST['username']) && $_POST['password']){
                    // Requete qui cherche un user avec ce pseudo et ce mot de passe
                    $users = $bdd->prepare("SELECT * FROM user WHERE username=? AND password=?;");
                    $users->execute([$_POST['username'], encryptPassword($_POST["password"])
                    ]);
                    $user = $users->fetch();
                    // Si il existe bien cet user, crée les variables de sessions
                    if($user){
                        $_SESSION['id_user'] = $user['id_user'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['password'] = $user['password'];
                        $_SESSION['email'] = $user['email'];
                        $_SESSION['level'] = $user['level'];
                        $_SESSION['experience'] = $user['experience'];
                        $_SESSION['objective'] = $user['objective'];
                        $_SESSION['admin'] = $user['admin'];
                        header('location:home.php');
                    }else{
                        // Sinon, informer l'utilisateur d'une erreur
                        echo '<p> The username or the password does not match.</p>';
                    }
                  }
                ?>
            </span>
      </main>
    </div>
  </body>
</html>