<?php

require_once 'menu.php';

if (isset($_SESSION["erreur"])) unset($_SESSION["erreur"]);


// ON SAUVEGARDE LES MESSAGES DANS SESSION PUIS ON LA SUPPRIME
// pour éviter qu'ils soient réutilisés pour aucune raison plus tard
if (isset($_SESSION["successIns"])){
  $msgIns = $_SESSION["successIns"];
  unset($_SESSION["successIns"]);
} elseif (isset($_SESSION["successCo"])){
  $msgCo = $_SESSION["successCo"];
  unset($_SESSION["successCo"]);
} elseif (isset($_SESSION["creationDebatOK"])) {
  $msgDebatOK = $_SESSION["creationDebatOK"];
  unset($_SESSION["creationDebatOK"]);
} elseif (isset($_SESSION["erreurDebat"])) {
  $msgError = $_SESSION["erreurDebat"];
  unset($_SESSION["erreurDebat"]);
}

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");


?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../img/favicon.ico">

  <title>Debat - Accueil</title>

  <!-- Bootstrap core CSS -->
  <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/categorie.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="nav-scroller bg-white shadow-sm">
    <nav class="nav nav-underline">
      <a class="nav-link" href="reglement.php">Règlement</a>
      <a class="nav-link" href="conditionsutilisation.php">Conditions d'utilisation</a>
    </nav>
  </div>

  <main role="main" class="container">

    <!-- MESSAGE BIENVENUE APRÈS INSCRIPTION -->
    <?php if (isset($msgIns)) { ?>
    <div class="alert alert-success alert-dismissible fade show alerteaccueil" role="alert">
      <strong>Inscription réussie</strong> <br>
      <?php echo $msgIns; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php } ?>

    <!-- MESSAGE BIENVENUE APRÈS CONNEXION -->
    <?php if (isset($msgCo)) { ?>
    <div class="alert alert-success alert-dismissible fade show alerteaccueil" role="alert">
      <strong>Connexion réussie</strong> <br>
      <?php echo $msgCo; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php } ?>

    <!-- MESSAGE CRÉATION DÉBAT OK -->
    <?php if (isset($msgDebatOK)) { ?>
    <div class="alert alert-success alert-dismissible fade show alerteaccueil" role="alert">
      <strong>Initiation du débat réussie</strong> <br>
      <?php echo $msgDebatOK; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php } ?>

    <!-- MESSAGE D'ERREUR -->
    <?php if (isset($msgError)) { ?>
      <div class="alert alert-danger alert-dismissible fade show alerteaccueil" role="alert">
        <strong>Oups... Erreur 404</strong> <br>
        <?php echo $msgError; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>

    <div class="row">
      <h3 class="titreaccueil">Découvrez, participez, créez de nouveaux débats...</h3>
    </div>
    <div class="row ligneban">
      <?php
      foreach (listeCateg($database) as $nomCateg) {
        echo '<div class="col-12 col-sm-6 ban">';
        echo '<a href="pagecategorie.php?categorie=';
        echo $nomCateg;
        echo '">';
        echo '<img src="../img/ban/';
        echo strtolower($nomCateg);
        echo '.png" alt="';
        echo $nomCateg;
        echo '" height=auto width="100%">';
        echo '</a>';
        echo '</div>';
      }
      ?>
    </div>
</main>
<?php
include 'footer.php';
?>

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
