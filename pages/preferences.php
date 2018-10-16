<?php
if (!session_id()) @ session_start();

include 'menu.php';

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if (isset($_SESSION["change"])) {
  $msgSuccess = $_SESSION["change"];
  unset($_SESSION["change"]);
} elseif (isset($_SESSION["changeMDPerror"])) {
  $msgError = $_SESSION["changeMDPerror"];
  unset($_SESSION["changeMDPerror"]);
}

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

    <!-- MESSAGE SUCCÈS CHANGEMENT -->
    <?php if (isset($msgSuccess)) { ?>
      <div class="alert alert-success alert-dismissible fade show alerteaccueil" role="alert">
        <strong>Modification effectuée avec succès</strong> <br>
        <?php echo $msgSuccess; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>

    <!-- MESSAGE ERREUR CHANGEMENT -->
    <?php if (isset($msgError)) { ?>
      <div class="alert alert-danger alert-dismissible fade show alerteaccueil" role="alert">
        <strong>Modification echouée</strong> <br>
        <?php echo $msgError; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>

    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0"><strong>Préférences</strong></h6>
      <br>

      <?php

      $fic = fopen('../txt/bool.txt', 'r+');
      $bool = fgets($fic);
      if($bool=="1"){
        $message="Le site est ouvert aux non-administrateurs.";
      }else{
        $message="Le site est fermé aux non-administrateurs.";
      }

      if(estAdmin($database,$_SESSION["pseudo"])){
        echo '
        <h6><strong>Maintenance</strong></h6>
        <p>'.$message.'</p>
        <form action="../control/changeEtatSite.php" method="post">
        <div class="form-group row">
        <label class="col-sm-4 col-form-label" for="inlineFormCustomSelectPref">Ouvrir le site aux non-admin</label>
        <div class="col-sm-8">
        <input type="radio" name="maintenance" value="ON" id="ON"> <label for="ON">Oui</label> <br>
        <input type="radio" name="maintenance" value="OFF" id="OFF"> <label for="OFF">Non</label>
        </div>
        </div>
        <button type="submit" class="btn btn-primary my-1">Confirmer l\'état de la maintenance</button>
        </form>
        <br>';
      }
      ?>

      <h6><strong>Changer de mot de passe</strong></h6>
      <form action="../control/changeMDP.php" method="post">
        <div class="form-group row">
          <label for="inputPassword" class="col-sm-4 col-form-label">Ancien mot de passe</label>
          <div class="col-sm-8">
            <input name="pwd" required type="password" class="form-control" id="inputPassword" placeholder="Mot de passe">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword1" class="col-sm-4 col-form-label">Nouveau mot de passe</label>
          <div class="col-sm-8">
            <input name="pwd1" required type="password" class="form-control" id="inputPassword1" placeholder="Mot de passe">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputPassword2" class="col-sm-4 col-form-label">Répéter le nouveau mot de passe</label>
          <div class="col-sm-8">
            <input name="pwd2" required type="password" class="form-control" id="inputPassword2" placeholder="Mot de passe" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Entrez minimum 8 caractères, faites un mot de passe fort (Majuscules, chiffres, caractères spéciaux, minuscules...)">
          </div>
        </div>

        <button type="submit" class="btn btn-primary my-1">Confirmer le changement de mot de passe</button>

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
