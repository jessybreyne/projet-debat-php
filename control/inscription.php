<?php
if ( ! session_id() ) @ session_start();
$_SESSION["erreur"] = "";

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

function formEstRempli(){
  return isset($_POST["pseudo"]) AND isset($_POST["pwd1"]) AND isset($_POST["pwd2"]);
}

function filtrerForm(){
  $_POST["pseudo"] = htmlspecialchars($_POST["pseudo"]);
  $_POST["pwd1"] = htmlspecialchars($_POST["pwd1"]);
  $_POST["pwd2"] = htmlspecialchars($_POST["pwd2"]);
}

if (!formEstRempli()){ // On s'assure que tout est bien rempli
  $_SESSION["erreur"] = "Veuillez compléter les champs indiqués !";

  header('Location: ../pages/index.php');
  die();

} elseif (!isset($_POST["conditionsOK"])) {
  $_SESSION["erreur"] = "Veuillez accepter les conditions d'utilisation.";

  header('Location: ../pages/index.php');
  die();
} else {
  filtrerForm();
  if ($_POST["pwd1"] != $_POST["pwd2"]){
    $_SESSION["erreur"] = "Erreur lors de la confirmation du mot de passe !";

    header('Location: ../pages/index.php');
    die();
  } elseif (pseudoExiste($database,$_POST["pseudo"])) {
    $_SESSION["erreur"] = "Ce pseudo est déjà utilisé !";

    header('Location: ../pages/index.php');
    die();
  } else {
    // INSCRIPTION OK
    newUser($database,$_POST["pseudo"],$_POST["pwd1"]);

    if (pseudoExiste($database,$_POST["pseudo"])) {
      // Le nouveau compte abien été ajouté à la base
      $_SESSION["pseudo"] = $_POST["pseudo"];
      $_SESSION["successIns"] = "Bienvenue sur la plateforme, {$_SESSION["pseudo"]} !";

      header('Location: ../pages/accueil.php');
      die();
    } else {
      // La BD n'est pas accessible ou alors pas les droits d'écriture
      $_SESSION["erreur"] = "La base de données n'est pas accessible !";

      header('Location: ../pages/index.php');
      die();
    }
  }
}

 ?>
