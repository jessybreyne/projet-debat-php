<?php

if (!session_id()) @ session_start();

if (!isset($_SESSION["pseudo"])) header('Location: index.php');

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if (isset($_GET["categorie"])) {
  $_GET["categorie"] = htmlspecialchars($_GET["categorie"]);
  if (!in_array($_GET["categorie"],listeCateg($database))) {
    $_SESSION["erreurDebat"] = "Cette catégorie n'existe pas !";
    // header('Location: accueil.php');
  }
} else {
  header('Location: accueil.php');
}

if (isset($_GET["debat"])) {
  $_GET["debat"] = htmlspecialchars($_GET["debat"]);
  if (!titreDebExiste($database,$_GET["debat"])) {
    $_SESSION["erreurDebat"] = "Ce débat n'existe pas !";
    header('Location: accueil.php');
  }
} else {
  header('Location: accueil.php');
}

include 'menu.php';
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../../../favicon.ico">

  <title>Debat - </title>

  <!-- Bootstrap core CSS -->
  <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/categorie.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="nav-scroller bg-white shadow-sm">
    <nav class="nav nav-underline">
      <a class="nav-link" href="pagecategorie.php?categorie=<?php echo $_GET["categorie"]; ?>">Revenir en arrière</a>
      <a class="nav-link" href="#">Règlement</a>
    </nav>
  </div>

  <main role="main" class="container">
    <div class="row">
      <div class="col-12 col-md-4">

        <div class="my-3 p-3 bg-reponse rounded shadow-sm">
          <h6 class="border-bottom border-gray pb-2 mb-0">Ecrire une réponse</h6>
          <form>
            <div class="form-group">
              <textarea autofocus class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Prenez part au débat, exprimez vous, apportez des idées..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
          </form>
        </div>

      </div>
      <div class="col-12 col-md-8">
        <!-- LES MESSAGES -->

        <?php
        $nbMessages = nbMessages($database,$_GET["debat"]);
        $lesMessages = listeMessages($database,$_GET["debat"]);
        if ($nbMessages > 0){
          $mess1 = $lesMessages[0];
          $pseudoCreateur = getInfosUserID($database,$mess1["idCreateur"])["pseudo"];
        } else {
          $mess1 = array("contenu" => "Aucun message dans ce débat !", "datePub" => "00/00/0000");
          $pseudoCreateur = "< CREATEUR INCONNU >";
        }
         ?>
        <div class="my-3 p-3 bg-question rounded shadow-sm">
          <h5 class="border-bottom border-gray pb-2 mb-0"><?php echo $_GET["debat"]; ?></h5>
          <div class="media text-muted pt-3">
            <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
              <strong class="d-block text-gray-dark"> <?php echo $mess1["datePub"]." | Débat initié par ".$pseudoCreateur; ?> </strong>
              <?php echo $mess1["contenu"]; ?>
            </p>
          </div>
        </div>

        <h3>Les réponses:</h3>

        <!-- AFFICHAGE DE TOUTES LES RÉPONSES -->

        <!-- S'IL N'Y A AUCUNE RÉPONSE -->
        <?php
        if ($nbMessages <= 1){
        ?>
        <div class="my-3 p-3 bg-white rounded shadow-sm">
          <div class="media text-muted pt-3">
            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
              <h6><strong class="d-block text-gray-dark"> Ce débat n'a aucune réponse pour le moment ! <br> Soyez le premier a exprimé votre avis sur ce sujet ! </strong></h6>
            </p>
          </div>
        </div>

        <!-- S'IL Y EN A -->
        <?php
        } else {
        for ($i=1; $i < $nbMessages; $i++) {
          $mess = $lesMessages[$i];
          $pseudoUser = getInfosUserID($database,$mess["idAuteur"])["pseudo"];
        ?>
        <div class="my-3 p-3 bg-white rounded shadow-sm">
          <div class="media text-muted pt-3">
            <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
              <strong class="d-block text-gray-dark"> <?php echo $mess["datePub"]." | Réponse n°$i, de $pseudoUser"; ?> </strong>
              <?php echo $mess["contenu"]; ?>
            </p>
          </div>
        </div>
        <?php }} ?>

      </div>
    </div>


  </main>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="../dist/js/jquery-3.2.1.slim.min.js"></script>
  <script>window.jQuery || document.write('<script src="../dist/js/jquery-slim.min.js"><\/script>')</script>
  <script src="../dist/js/popper.min.js"></script>
  <script src="../dist/js/bootstrap.min.js"></script>
  <script src="../dist/js/holder.min.js"></script>
  <script src="../js/categorie.js"></script>
</body>
</html>
