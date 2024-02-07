<?php
    $upload_folder = getcwd().'/img/affiches/';

    // Fonction qui permet de crypter les mots de passe
    function encryptPassword($password){
        return crypt($password,'CRYPT_SHA512 ');
    }

    // Redirige l'utilisateur non connecté ou non-admin dans le cas où on souhaite afficher la page qu'en admin
    function isUserConnected($isAdmin = 0){
        if(!isset($_SESSION['admin'])){
            header('Location:connexion.php');
            die;
        }elseif ($isAdmin > $_SESSION['admin']){
            header('Location:index.php');
            die;
        }
    }

    // Fonction qui return true si un utilisateur est connecté
    function connected(){
        if(!isset($_SESSION['username'])){
            return false;
        }
        else{
            return true;
        }
    }

    // Fonction qui verifie si l'utilisateur est un admin
    function isAdmin(){
        if($_SESSION['admin'] == 1){
            return true;
        }
        return false;
    }

    // FOnction qui calcul l'expérience gagnée lors d'un niveau
    function experience_calcul($correct_answers, $false_answers, $experience){
        $xpCorrectAnswer = 20;
        $xpFalseAnswer = -5;
        $newExperience = $experience;
        $newExperience += $correct_answers * $xpCorrectAnswer + $false_answers * $xpFalseAnswer;
        if($newExperience > $experience){
            $experience = $newExperience;
        }
        return $experience;
    }

    // Fonction qui défini un nouvel objectif d'expérience à atteindre pour monter en niveau
    function objective_calcul($experience, $objective, $level){
        if($experience > $objective){
            for($i = 1; $i <= $level; $i++){
                $objective = $objective + $i * 400;
            }
        }
        return $objective;
    }

    // Fonction qui ajoute 1 au niveau si l'expérience est supérieur à l'objectif
    function level_calcul($experience, $objective, $level){
        if($experience > $objective){
            for($i = 1; $i <= $level; $i++){
                $objective = $objective + $i * 400;
            }
            $level +=1;
        }
        return $level;
    }

        
    /* TEXT TO MORSE CODE */

    function textToArray($textArea) // Transforme le texte en un tableau de lettres, en majuscule et en gardant les espaces.
    {
        $textAreaMAJ = strtoupper($textArea);
        $arrayLetter = str_split($textAreaMAJ);
        return $arrayLetter;
    }

    function textToArrayMorse($textArea, $letters) // Créer un nouveau tableau avec les lettres en morses
    {
        $arrayMorse = array();
        $arrayLetter = textToArray($textArea);
        foreach ($arrayLetter as $currentLetter) {
            foreach ($letters as $letter) {
                if ($currentLetter == $letter['original']) {
                    array_push($arrayMorse, $letter['morse']);
                    break;
                } elseif ($currentLetter == ' ') {
                    array_push($arrayMorse, ' ');
                    break;
                }
            }
        }
        return $arrayMorse;
    }

    function arrayMorseToString($arrayMorse) // Convertir en chaine de caractère pour pouvoir l'afficher dans le OUTPUT
    {
        $textResult = '';
        for ($i = 0; $i < count($arrayMorse); $i++) {
            if ($arrayMorse[$i] == ' ') {
                $textResult .= "&nbsp;&nbsp;&nbsp;";
            } else {
                $textResult .= $arrayMorse[$i] . ' ';
            }
        }
        return $textResult;
    }

    function translateTextMorse($text, $letters) // Regroupe les 3 fonctions précédentes
    {
        $textInArrayMorse = textToArrayMorse($text, $letters);
        $morseInString = arrayMorseToString($textInArrayMorse);
        return $morseInString;
    }

    /* MORSE TO TEXT */

    function morseToArray($textArea) {
        $textArea = preg_replace('/\s{3,}/', '  ', $textArea);
        $morseArray = explode(' ', $textArea);
        return $morseArray;
    }

    // Fonction qui prend en paramètre un texte de type string et un tableau 
    function morseToArrayText($textArea, $letters) {
        $arrayText = array();
        $morseArray = morseToArray($textArea);
        foreach ($morseArray as $currentMorse) {
            foreach ($letters as $letter) {
                if ($currentMorse == $letter['morse']) {
                    array_push($arrayText, strtolower($letter['original']));
                    break;
                } elseif ($currentMorse == '') {
                    array_push($arrayText, ' ');
                    break;
                }
            }
        }
        return $arrayText;
    }

    // Convertir en chaine de caractère pour pouvoir l'afficher dans le OUTPUT
    function arrayTextToString($arrayText) 
    {
        $textResult = '';
        for ($i = 0; $i < count($arrayText); $i++) {
            if ($arrayText[$i] == ' ') {
                $textResult .= " ";
            } else {
                $textResult .= $arrayText[$i];
            }
        }
        return $textResult;
    }

    // Regroupe les 3 fonctions précédentes
    function translateMorseText($morse, $letters) 
    {
        $morseInArrayText = morseToArrayText($morse, $letters);
        $textInString = arrayTextToString($morseInArrayText);
        return $textInString;
    }