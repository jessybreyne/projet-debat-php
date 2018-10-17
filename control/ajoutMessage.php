<?php
if (!session_id()) @ session_start();

if (!isset($_SESSION["pseudo"]) AND !peutContinuer($database,$_SESSION["pseudo"],$_SESSION["SystemeOuvert"])) header('Location: index.php') header('Location: index.php');


$_POST["reponse"] = htmlspecialchars($_POST["reponse"]);

# FORMULAIRE OK

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if (isset($_POST["titreDeb"])) {
  $_POST["titreDeb"] = htmlspecialchars($_POST["titreDeb"]);
  if (!titreDebExiste($database,$_POST["titreDeb"])) {
    $_SESSION["erreurDebat"] = "Ce débat n'existe pas !";
    header('Location: ../pages/accueil.php');
  }
} else {
  header('Location: ../pages/accueil.php');
}


if (strlen($_POST["reponse"]) < 10){
  $_SESSION["erreurReponse"] = "Votre réponse est trop courte : Il faut 10 caractères minimum !";
} else {

  newMessage($database,$_SESSION["pseudo"],$_POST["titreDeb"],$_POST["reponse"]);
  $_SESSION["successReponse"] = "Merci d'avoir pris part à ce débat ! Vous pouvez suivre la discussion, si ce n'est pas déjà fait !";
}

echo "../pages/pageDebat.php?categorie={$_POST["categorie"]}&debat={$_POST["titreDeb"]}";
header("Location: ../pages/pageDebat.php?categorie={$_POST["categorie"]}&debat={$_POST["titreDeb"]}");

?>
