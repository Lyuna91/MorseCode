<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="./css/manual.css" />
    <link rel="stylesheet" type="text/css" href="./css/base.css" />
</head>
<body>
    <?php
    include_once('./global/header.php'); // Inclusion du header
    ?>
    <main>
        <form method="GET">
            <section class="letter">
                <h3> Morse code Letter</h3>
                <!-- Proposition du hcoix de tri du tableau des LETTRES-->
                <label for="options1">Sort by</label>
                <br>
                <select id="options1" name="selectedOption">
                    <option value="option1" selected> Alphabetically (A - Z)</option>
                    <option value="option2"> Alphabetically (Z - A)</option>
                    <option value="option3">Difficulty (Easy - Hard)</option>
                    <option value="option4">Difficulty (Hard - Easy)</option>
                </select>
                <br>
                <button type="submit">Sort</button>
                <br>
                <?php
                // Requête en fonction du choix du tri 
                if (isset($_GET["selectedOption"])) {
                    $selectedOption = $_GET["selectedOption"];
                    if($selectedOption == "option1"){
                        $letter_req = $bdd->prepare('SELECT original, morse FROM letter');
                        $letter_req->execute();
                    }
                    elseif($selectedOption == "option2"){
                        $letter_req = $bdd->prepare('SELECT original, morse FROM letter ORDER BY original DESC');
                        $letter_req->execute();
                    }
                    elseif($selectedOption == "option3"){
                        $letter_req = $bdd->prepare('SELECT original, morse FROM letter ORDER BY difficulty');
                        $letter_req->execute();
                    }
                    elseif($selectedOption == "option4"){
                        $letter_req = $bdd->prepare('SELECT original, morse FROM letter ORDER BY difficulty DESC');
                        $letter_req->execute();
                    }
                    $letters = $letter_req->fetchAll();
                    // Affichage du tableau des LETTRES
                    echo '<table>';
                    echo '<tr><th>Original Letter</th><th>Morse Letter</th></tr>';

                    foreach ($letters as $letter) {
                        echo '<tr>';
                        echo '<td>' . $letter['original'] . '</td>';
                        echo '<td>' . $letter['morse'] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                }
                ?>
            </section>
            <section class="code_q">
                <h3> Morse code Q</h3>
                <!-- Proposition du choix de tri du tableau des CODE Q-->
                <label for="options2">Sort by</label>
                <br>
                <select id="options2" name="selectedOptionQ">
                    <option value="option5" selected> Alphabetically (A - Z)</option>
                    <option value="option6"> Alphabetically (Z - A)</option>
                </select>
                <br>
                <button type="submit">Sort</button>
                <br>
                <?php
                // Requête en fonction du tri
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["selectedOptionQ"])) {
                    $selectedOptionQ = $_GET["selectedOptionQ"];
                    if($selectedOptionQ == "option5"){
                        $code_q_req = $bdd->prepare('SELECT original, morse, information FROM code_q');
                        $code_q_req->execute();
                    }
                    elseif($selectedOptionQ == "option6"){
                        $code_q_req = $bdd->prepare('SELECT original, morse, information FROM code_q ORDER BY original DESC');
                        $code_q_req->execute();
                    }
                    $codes_q = $code_q_req->fetchAll();
                    // Affichage du tableau des code Q
                    echo '<table>';
                    echo '<tr><th>Original Code Q</th><th> Morse Code Q</th><th> Description </th></tr>';

                    foreach ($codes_q as $code_q) {
                        echo '<tr>';
                        echo '<td>' . $code_q['original'] . '</td>';
                        echo '<td>' . $code_q['morse'] . '</td>';
                        echo '<td style="max-width:200px;">' . $code_q['information'] . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
                ?>
            </section>
        </form>
    </main>
</body>
</html>
