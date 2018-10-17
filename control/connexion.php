<?php
if ( !session_id() ) @ session_start();
$_SESSION["erreur"] = "";

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

$database = launchPDO("../bd/data");

function formEstRempli(){
  return isset($_POST["pseudo"]) AND isset($_POST["pwd"]);
}

function filtrerForm(){
  $_POST["pseudo"] = htmlspecialchars($_POST["pseudo"]);
  $_POST["pwd"] = htmlspecialchars($_POST["pwd"]);
}

if (!formEstRempli()){ // On s'assure que tout est bien rempli
  $_SESSION["erreur"] = "Veuillez compléter les champs indiqués !";

  header('Location: index.php');
} else {
  filtrerForm();
  if (!pseudoExiste($database,$_POST["pseudo"])){
    $_SESSION["erreur"] = "Ce pseudo n'existe pas !";

    header('Location: ../pages/index.php');
  } else {
    $mdpPost = hashMDP($_POST["pwd"]);
    $mdpUser = getInfosUser($database,$_POST["pseudo"])["mdpHash"];
    if ($mdpPost == $mdpUser){
      // CONNEXION OK
      $_SESSION["pseudo"] = $_POST["pseudo"];
      $_SESSION["successCo"] = "Bon retour sur la plateforme, {$_SESSION["pseudo"]} !";

      header('Location: ../pages/accueil.php');
    } else {
      $_SESSION["erreur"] = "Mauvais mot de passe !";

      header('Location: ../pages/index.php');
    }
  }

}

 ?>
