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

  <title>Debat - Préférences</title>

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

    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0"><strong>Préférences</strong></h6>
      <h6><strong>Maintenance</strong></h6>
      <form class="form-inline">
  <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Site ouvert aux non-admin</label>
  <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
    <option value="1">Oui</option>
    <option value="2">Non</option>
</select>
  <button type="submit" class="btn btn-primary my-1">Enregistrer</button>
</form>
<h6><strong>Changer de mot de passe</strong></h6>
<form>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Ancien mot de passe</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" placeholder="Mot de passe">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Nouveau mot de passe</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" placeholder="Mot de passe">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Répéter le nouveau mot de passe</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" placeholder="Mot de passe">
    </div>
  </div>

  <button type="submit" class="btn btn-primary my-1">Valider</button>

</form>
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
