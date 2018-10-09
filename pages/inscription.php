<?php
session_start();

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");


function formEstRempli(){
  print_r($_POST);
  return isset($_POST["pseudo"]) AND isset($_POST["pwd1"]) AND isset($_POST["pwd2"]);
}

function filtrerForm(){
  $_POST["pseudo"] = htmlspecialchars($_POST["pseudo"]);
  $_POST["pwd1"] = htmlspecialchars($_POST["pwd1"]);
  $_POST["pwd2"] = htmlspecialchars($_POST["pwd2"]);
  print_r($_POST);
}

if (!formEstRempli()){ // On s'assure que tout est bien rempli
  $_SESSION["etatInscription"] = "Veuillez compléter les champs indiqués !";
  header('Location: index.php');
} else {
  filtrerForm();
  if ($_POST["pwd1"] != $_POST["pwd2"]){
    $_SESSION["etatInscription"] = "Erreur lors de la confirmation du mot de passe !";
    header('Location: index.php');
  } elseif (pseudoExiste($_POST["pseudo"])) {
    $_SESSION["etatInscription"] = "Ce pseudo est déjà utilisé !";
    header('Location: index.php');
  } else {
    // INSCRIPTION OK
    newUser($_POST["pseudo"],$_POST["pwd1"]);
    $_SESSION["pseudo"] = $_POST["pseudo"];
    $_SESSION["etatInscription"] = "Inscription effectuée !";
    header('Location: accueil.php');
  }
}
 ?>
