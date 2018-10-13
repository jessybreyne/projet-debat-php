<?php

include 'menu.php';

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if (!session_id()) @ session_start();
if (!isset($_SESSION["pseudo"])) header('Location: index.php');
if (isset($_SESSION["erreur"])) {
  $msgError = $_SESSION["erreur"];
  unset($_SESSION["erreur"]);
}

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
      <a class="nav-link" href="accueil.php">Revenir à l'accueil</a>
      <a class="nav-link" href="#">Règlement</a>
      <a class="nav-link" href="conditionsutilisation.php">Conditions d'utilisation</a>
    </nav>
  </div>

  <main role="main" class="container">

    <!-- MESSAGE ERREUR CREATION DEBAT -->
    <?php if (isset($msgError)) { ?>
      <div class="alert alert-danger alert-dismissible fade show alerteindex" role="alert">
        <strong>Création du débat refusée</strong> <br>
        <?php echo $msgError; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>

    <div class="row">
      <div class="col">
        <div class="my-3 p-3 bg-reponse rounded shadow-sm">
          <h5 class="border-bottom border-gray pb-2 mb-0">Ecriture du débat</h6>


            <form action="../control/ajoutDebat.php" method="post">
              <div class="form-group">
                <input name="titre" type="text" class="form-control" id="formGroupExampleInput" placeholder="Saisissez le titre" required autofocus pattern=".{8,80}" title="Contenu du message d'initiation : Minimum 8 caractères">
              </div>
              <div class="row">
                <div class="col-12 col-md-8">
                  <div class="form-group">
                    <textarea name="contenuMess1" class="form-control" id="exampleFormControlTextarea1" rows="3" style="height:310px;" placeholder="Expliquez le sujet, le problème, ouvrez le débat..."  required pattern=".{10,}" title="Contenu du message d'initiation"></textarea>
                  </div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Catégorie</label>
                    <select name="Categorie" class="form-control" id="exampleFormControlSelect1">
                      <?php foreach (listeCateg($database) as $categ) {
                        $nomCateg = $categ["nomCateg"];
                        echo "<option value=$nomCateg>$nomCateg</option>";
                      } ?>
                    </select>
                  </div>
                  <legend class="col-form-label">Paramètres</legend>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                      Notification à chaque nouvelle activité
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                    <label class="form-check-label" for="defaultCheck2">
                      Notification à chaque nouveau suivi
                    </label>
                  </div>
                  <legend class="col-form-label">Statut du débat</legend>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                    <label class="form-check-label" for="gridRadios1">
                      Public
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                    <label class="form-check-label" for="gridRadios2">
                      Privé (vous pourez changer ce choix)
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3">
                    <label class="form-check-label" for="gridRadios3">
                      Masqué
                    </label>
                  </div>
                  <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Publier</button>
                </div>
              </div>
            </form>


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
