<html lang="fr">
    <head>
        <title>Morse Code</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./css/login.css" />
        <link rel="stylesheet" type="text/css" href="./css/base.css" />
        <link rel="icon" type="image/png" href="./images/logo.png" />
    </head>
    <body>
        <div class="container">
            <header>
            <?php
            include_once("./global/header.php"); // Inclusion du Header
            ?>
            </header>
            <main>
                <span>
                    <!-- Permet de rediriger vers loginphp si on souhaite se créer un compte -->
                    <h2> You have an account ? </h2>
                    <a class="button" id="B" href="login.php"> Login </a>
                    <!-- formulaire en post pour la sécurité des données -->
                    <form method="POST">
                        <label for="username" > <b>Enter an username </b> </label>
                        <input type="text" name ="username" required>
                        <label for="email" > <b>Enter an E-mail </b> </label>
                        <input type="text" name="email" required>
                        <label for="password" > <b>Enter a password </b></label>
                        <input type="password" name="password" required>
                        <button type="submit"> <b> Sign in </b> </button>
                    </form>
                    <?php
                    // Si le formulaire en POST à bien été soumis
                    if(isset($_POST['username']) && ($_POST["password"])){
                        $existingUser = $bdd->prepare("SELECT * FROM user WHERE username = ?;");
                        $existingUser->execute([$_POST['username']]);
                        if(count($existingUser->fetchAll()) === 0){
                            $user = $bdd->prepare("INSERT INTO `user`(`username`, `email`, `password`, `level`,`experience`,`objective`, `admin`) VALUES (:username, :email, :password, 1,0,100, 0);");
                            $user->execute(                                
                            ['username' => $_POST['username'],
                            'email' => $_POST['email'],
                            'password' => $_POST['password'],
                            'password' => encryptPassword($_POST['password']),
                        ]);
                            header('Location:login.php');
                        }else{
                            $message = "This username has already been choosed. Too late :D";
                        }
                    }
                    ?>
                </span>
            </main>
        </div>
    </body>
</html>