<?php
if (!session_id()) @ session_start();


// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if (isset($_SESSION["pseudo"]) AND !peutContinuer($database,$_SESSION["pseudo"])) {
  header('Location: ../control/deconnexion.php');
  die();
}


$_POST["reponse"] = htmlspecialchars($_POST["reponse"]);

# FORMULAIRE OK


if (isset($_POST["titreDeb"])) {
  $_POST["titreDeb"] = htmlspecialchars($_POST["titreDeb"]);
  if (!titreDebExiste($database,$_POST["titreDeb"])) {
    $_SESSION["erreurDebat"] = "Ce débat n'existe pas !";
    header('Location: ../pages/accueil.php');
    die();
  }
} else {
  header('Location: ../pages/accueil.php');
  die();
}


if (strlen($_POST["reponse"]) < 10){
  $_SESSION["erreurReponse"] = "Votre réponse est trop courte : Il faut 10 caractères minimum !";
} else {

  newMessage($database,$_SESSION["pseudo"],$_POST["titreDeb"],$_POST["reponse"]);
  $_SESSION["successReponse"] = "Merci d'avoir pris part à ce débat ! Vous pouvez suivre la discussion, si ce n'est pas déjà fait !";
}

echo "../pages/pageDebat.php?categorie={$_POST["categorie"]}&debat={$_POST["titreDeb"]}";
header("Location: ../pages/pageDebat.php?categorie={$_POST["categorie"]}&debat={$_POST["titreDeb"]}");
die();

?>
