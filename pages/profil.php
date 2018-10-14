<?php
include 'menu.php';


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

  <title>Debat - Profil</title>

  <!-- Bootstrap core CSS -->
  <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/categorie.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="nav-scroller bg-white shadow-sm">
    <nav class="nav nav-underline">
      <a class="nav-link" href="#">Règlement</a>
      <a class="nav-link" href="conditionsutilisation.php">Conditions d'utilisation</a>
    </nav>
  </div>

  <main role="main" class="container">

    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0">Profil de <strong><?php echo "Pseudo"; ?></strong></h6>
      <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Pseudo</label>
    <div class="col-sm-10">
      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
    </div>
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
