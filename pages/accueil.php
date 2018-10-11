<?php
if (!session_id()) @ session_start();
if (isset($_SESSION["erreur"])) $_SESSION["erreur"] = null;

if (isset($_SESSION["successIns"])){
  $msgIns = $_SESSION["successIns"];
  $_SESSION["successIns"] = null;
}

if (isset($_SESSION["successCo"])){
  $msgCo = $_SESSION["successCo"];
  $_SESSION["successCo"] = null;
}

if (!isset($_SESSION["pseudo"])) header('Location: index.php');
 ?>
 <?php

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
  <link rel="icon" href="../../../../favicon.ico">

  <title>Debat - </title>

  <!-- Bootstrap core CSS -->
  <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/categorie.css" rel="stylesheet">
</head>

<body class="bg-light">

  <?php
  require_once 'menu.php';
  ?>

  <div class="nav-scroller bg-white shadow-sm">
    <nav class="nav nav-underline">
      <a class="nav-link" href="#">Revenir aux catégories</a>
      <a class="nav-link" href="#">Règlement</a>
      <a class="nav-link" data-toggle="collapse" href="#collapseTri" role="button" aria-expanded="false" aria-controls="collapseTri">Paramétrage du tri</a>
    </nav>
    <div class="collapse" id="collapseTri">
      <div class="card card-body">
        <form class="form-inline">
          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tri par nombre de message dans les débats</label>
          <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
            <option selected>Choisir...</option>
            <option value="1">Ordre croissant</option>
            <option value="2">Ordre décroissant</option>
          </select>
          <button type="submit" class="btn btn-primary my-1">Valider</button>
        </form>
        <form class="form-inline">
          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tri par nombre de message dans les débats</label>
          <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
            <option selected>Choisir...</option>
            <option value="1">Ordre croissant</option>
            <option value="2">Ordre décroissant</option>
          </select>
          <button type="submit" class="btn btn-primary my-1">Valider</button>
        </form>
        <form class="form-inline">
          <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Tri par date des débats</label>
          <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
            <option selected>Choisir...</option>
            <option value="1">Ordre croissant</option>
            <option value="2">Ordre décroissant</option>
          </select>
          <button type="submit" class="btn btn-primary my-1">Valider</button>
        </form>
      </div>
    </div>
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

    <div class="row">
      <h3 class="titreaccueil">Découvrez, participez, créez de nouveaux débats...</h3>
    </div>
    <div class="row ligneban">
      <?php
      foreach (listeCateg($database) as $categ) {
        echo '<div class="col-12 col-sm-6 ban">';
        echo '<a href="pagecategorie.php?=';
        echo strtolower($categ);
        echo '">';
        echo '<img src="../img/ban/';
        echo strtolower($categ);
        echo '.png" alt="';
        echo strtolower($categ);
        echo '" height="100%" width="100%">';
        echo '</a>';
        echo '</div>';
      }
      ?>
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
