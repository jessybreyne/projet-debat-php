<?php

if (!session_id()) @ session_start();

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if ($_POST["pwd1"] != $_POST["pwd2"]) {
  $_SESSION["changeMDPerror"] = "Problème de confirmation du nouveau mot de passe !";
} else {
  $mdpPost = hashMDP($_POST["pwd"]);
  $mdpUser = getInfosUser($database,$_SESSION["pseudo"])["mdpHash"];
  if ($mdpPost != $mdpUser){
    // MAUVAIS MDP
    $_SESSION["changeMDPerror"] = "Mauvais mot de passe !";
  } else {
    // CHGT OK

    changeMDP($database,$_SESSION["pseudo"],$_POST["pwd1"]);

    $_SESSION["change"] = "Votre mot de passe a bien été mis à jour !";
  }
}

header('Location: ../pages/preferences.php');

?>
