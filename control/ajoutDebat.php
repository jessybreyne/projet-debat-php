<?php

$_POST["titre"] = htmlspecialchars($_POST["titre"]);
$_POST["contenuMess1"] = htmlspecialchars($_POST["contenuMess1"]);

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if (!titreDebExiste($database,$_POST["titre"])){
  $_SESSION["erreur"] = "Ce débat existe déjà !";

  // Fermeture de la connexion
  $database = null;
  header('Location: ../pages/nouveaudebat.php');
} else {

}


 ?>
