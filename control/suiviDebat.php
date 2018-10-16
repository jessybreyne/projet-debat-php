<?php

if (!session_id()) @ session_start();

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if (!isset($_SESSION["pseudo"])) header('Location: ../pages/index.php');

if ($_POST["action"] == "ON"){ // On suit un débat
  newSuivi($database,$_SESSION["pseudo"],$_POST["debat"]);

} else { // On ne suit plus le débat
  deleteSuivi($database,$_SESSION["pseudo"],$_POST["debat"]);
}

header("Location: ../pages/pageDebat.php?categorie={$_POST["categorie"]}&debat={$_POST["debat"]}");
 ?>
