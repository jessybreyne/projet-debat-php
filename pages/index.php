<?php
if (!session_id()) @ session_start();
if (isset($_SESSION["pseudo"])) unset($_SESSION["pseudo"]);


// ON SAUVEGARDE LES MESSAGES DANS SESSION PUIS ON LA SUPPRIME
// pour éviter qu'ils soient réutilisés pour aucune raison plus tard
if (isset($_SESSION["erreur"])) {
  $msgError = $_SESSION["erreur"];
  unset($_SESSION["erreur"]);
}

// WARNING:
// POSSIBILITÉ DE BLOQUER LES UTILISATEURS NON-ADMIN
// mettre à true pour désactiver
$_SESSION["SystemeOuvert"] = true;

?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../img/favicon.ico">

  <title>Debat - Bienvenue</title>

  <!-- Bootstrap core CSS -->
  <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/accueil.css" rel="stylesheet">
</head>

<body class="bg-dark">

  <header class="navbar-expand navbar-dark header">
    <div class="row logo-centered" style="padding-top: 15px;">
      <div class="logo">
        <h1>
          <div class="logo"><a class="navbar-brand" href="#">Bienvenue sur </a></div>
          <div class="logo"><img src="../img/Debat-Logo-creme.png" class="logo-img"></div>
        </h1></div>
      </div>
      <div class="row logo-centered">

        <div style="margin: 0 auto; color: #e1e1e1;"><h3>Plateforme de débat collaborative</h3>
        </div>
      </div>
    </header>

    <main role="main" class="container espacement-main">
      <div class="row block">
        <h3 style="color: white;">Nouvel arrivant ? <a class="btn btn-primary" data-toggle="collapse" href="#collapseInscription" role="button" aria-expanded="false" aria-controls="collapseInscription">Inscrivez-vous !</a></h3>
      </div>
      <div class="row block">
      </div>

      <!-- MESSAGE D'ERREUR -->
      <?php if (isset($msgError)) { ?>
        <div class="alert alert-danger alert-dismissible fade show alerteindex" role="alert">
          <strong>Inscription/Connexion refusée</strong> <br>
          <?php echo $msgError; ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php } ?>

      <div class="collapse row block" id="collapseInscription" style="margin-bottom: 30px;">
        <div class="card card-body">
          <h2>Inscription</h2>
          <form action="../control/inscription.php" method="post">
            <div class="form-group row">
              <label for="pseudoIns" class="col-sm-2 col-form-label">Pseudo</label>
              <div class="col-sm-10">
                <input name="pseudo" type="text" class="form-control" id="pseudoIns" placeholder="Pseudo" pattern="[A-Za-z][A-Za-z0-9]{2,14}" title="Entre 3 et 15 caractères. Chiffres autorisés. Commencer par une lettre." required>
              </div>
            </div>
            <div class="form-group row">
              <label for="pwdIns1" class="col-sm-2 col-form-label">Mot de passe</label>
              <div class="col-sm-10">
                <input name="pwd1" type="password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Entrez minimum 8 caractères, faites un mot de passe fort (Majuscules, chiffres, caractères spéciaux, minuscules...)" class="form-control" id="pwdIns1" placeholder="Mot de passe" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="pwdIns2" class="col-sm-2 col-form-label">Confirmer le mot de passe</label>
              <div class="col-sm-10">
                <input name="pwd2" type="password" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Entrez minimum 8 caractères, faites un mot de passe fort (Majuscules, chiffres, caractères spéciaux, minuscules...)" class="form-control" id="pwdIns2" placeholder="Mot de passe" required>
              </div>
            </div>
            <div class="form-group row">
              <div class="col">
                <a data-toggle="collapse" href="#condition" role="button" aria-expanded="false" aria-controls="condition">Afficher les conditions d'utilisation</a><br>
                <div class="collapse" id="condition">
                  <div class="card card-body cardc">
                    <a class="btn btn-danger" data-toggle="collapse" href="#condition" role="button" aria-expanded="false" aria-controls="condition">
                      Fermer
                    </a>
                    <?php
                    include 'conditions.html';
                    ?>
                    <a class="btn btn-danger" data-toggle="collapse" href="#condition" role="button" aria-expanded="false" aria-controls="condition">
                      Fermer
                    </a>                  </div>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck1">
                    <label class="form-check-label" for="gridCheck1">
                      J'accepte les conditions d'utilisation
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Inscription</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row hauteur">
        <div class="col-12 col-md-4">
          <div class="card">
            <div class="card-body">

              <h2>Se connecter</h2>
              <form action="../control/connexion.php" method="post">
                <div class="form-group">
                  <label for="pseudoCo">Pseudo</label>
                  <!-- aria-describedby="emailHelp" -->
                  <input name="pseudo" type="text" class="form-control" id="pseudoCo" placeholder="Entrer le pseudo">
                </div>
                <div class="form-group">
                  <label for="pwd">Mot de passe</label>
                  <input name="pwd" type="password" class="form-control" id="pwd" placeholder="Entrer le mot de passe">
                </div>
                <div class="form-group form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Rester connecté</label>
                </div>
                <button type="submit" class="btn btn-primary">Connexion</button>
              </form>

            </div>
          </div>
        </div>
        <div class="col-12 col-md-8 block-mobile">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="../img/Slide-1.png" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="bgtextcarouselle">Oui ou non ?</h5>
                  <p class="bgtextcarouselle">Des débats à contradiction binaire ? Débat est fait pour vous.</p>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="../img/Slide-2.png" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="bgtextcarouselle">Les opinions</h5>
                  <p class="bgtextcarouselle">Accédez à une grande diversité d'opinions.</p>
                </div>
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="../img/Slide-3.png" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="bgtextcarouselle">L'argumentation</h5>
                  <p class="bgtextcarouselle">De tout temps, l'humanité à débattu pour trouver des solutions.</p>
                </div>
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
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
