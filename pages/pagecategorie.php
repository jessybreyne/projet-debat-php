<?php
include 'menu.php';

$_GET["categorie"] = htmlspecialchars($_GET["categorie"]);

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

  <title>Debat - Catégorie <?php echo $_GET["categorie"]; ?></title>

  <!-- Bootstrap core CSS -->
  <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/categorie.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="nav-scroller bg-white shadow-sm">
    <nav class="nav nav-underline">
      <a class="nav-link" href="accueil.php">Revenir à l'accueil</a>
      <a class="nav-link" href="reglement.php">Règlement</a>
      <a class="nav-link" href="conditionsutilisation.php">Conditions d'utilisation</a>
      <a class="nav-link" data-toggle="collapse" href="#collapseTri" role="button" aria-expanded="false" aria-controls="collapseTri">Paramétrage du tri</a>
    </nav>
    <div class="collapse" id="collapseTri">
      <div class="card card-body">
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

    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <?php
      $listeDebCateg = listeDebatsCateg($database,$_GET["categorie"]);
      ?>
      <h6 class="border-bottom border-gray pb-2 mb-0"><?php echo count($listeDebCateg); ?> débats dans la catégorie <strong><?php echo $_GET["categorie"]; ?></strong></h6>

      <?php foreach ($listeDebCateg as $debat) { ?>
      <a href="pageDebat.php?<?php echo "categorie={$_GET["categorie"]}&debat={$debat["titre"]}"; ?>">
      <div class="media text-muted pt-3">
        <img src=<?php echo "../img/icon/".strtolower($_GET["categorie"]).".png"; ?> alt=<?php echo $_GET["categorie"]; ?> class="iconCateg">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark"><?php echo $debat["titre"]; ?></strong>
          <?php
          $infosCreateur = getInfosUserID($database,$debat["idCreateur"]);
          echo "Créateur : ".$infosCreateur["pseudo"];
          echo " | Dernière activité : ";
          print_r(derniereActivite($database,$debat["titre"]));
          echo " | Nombre de suivis : ".nbSuivis($database,$debat["titre"]);

           ?>
        </p>
      </div>
      </a>
      <?php } ?>
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
