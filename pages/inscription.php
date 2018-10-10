<?php
session_start();

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

launchPDO();
$database = $_SESSION["database"];

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
  $_SESSION["erreurInscription"] = "Veuillez compléter les champs indiqués !";
  header('Location: index.php');
} else {
  filtrerForm();
  if ($_POST["pwd1"] != $_POST["pwd2"]){
    $_SESSION["erreurInscription"] = "Erreur lors de la confirmation du mot de passe !";
    header('Location: index.php');
  } elseif (pseudoExiste($database,$_POST["pseudo"])) {
    $_SESSION["erreurInscription"] = "Ce pseudo est déjà utilisé !";
    // header('Location: index.php');
  } else {
    // INSCRIPTION OK
    newUser($database,$_POST["pseudo"],$_POST["pwd1"]);
    $_SESSION["pseudo"] = $_POST["pseudo"];
    $_SESSION["SuccessInscription"] = "Bienvenue sur la plateforme, {$_SESSION["pseudo"]} !";
    // Fermeture de la connexion
    $database = null;
    $_SESSION["database"] = null;
    header('Location: accueil.php');
  }
}

 ?>
