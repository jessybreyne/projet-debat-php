<?php
if (!session_id()) @ session_start();


// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");


if (!isset($_SESSION["pseudo"]) AND !peutContinuer($database,$_SESSION["pseudo"],$_SESSION["SystemeOuvert"])) header('Location: index.php');


$_POST["titre"] = htmlspecialchars($_POST["titre"]);
$_POST["contenuMess1"] = htmlspecialchars($_POST["contenuMess1"]);



if (titreDebExiste($database,$_POST["titre"])){
  $_SESSION["erreur"] = "Ce débat existe déjà !";

  // Fermeture de la connexion
  $database = null;
  header('Location: ../pages/nouveaudebat.php');
} else {
  // LANCEMENT OK

  // 1 - Création du débat
  newDebat($database,$_SESSION["pseudo"],$_POST["Categorie"],$_POST["titre"]);

  // 2 - Ajout du premier message au débat
  newMessage($database,$_SESSION["pseudo"],$_POST["titre"],$_POST["contenuMess1"]);

  $_SESSION["creationDebatOK"] = "Félicitations ! Votre nouveau débat a bien été lancé !";

  // Fermeture de la connexion
  $database = null;
  header('Location: ../pages/accueil.php');
}


 ?>
