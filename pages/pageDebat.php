<?php

if (!session_id()) @ session_start();

include 'menu.php';


// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if (isset($_GET["categorie"])) {
  $_GET["categorie"] = htmlspecialchars($_GET["categorie"]);
  if (!in_array($_GET["categorie"],listeCateg($database))) {
    $_SESSION["erreurDebat"] = "Cette catégorie n'existe pas !";
    header('Location: accueil.php');
    die();
  }
} else {
  header('Location: accueil.php');
  die();
}

if (isset($_GET["debat"])) {
  $_GET["debat"] = htmlspecialchars($_GET["debat"]);
  if (!titreDebExiste($database,$_GET["debat"])) {
    $_SESSION["erreurDebat"] = "Ce débat n'existe pas !";
    header('Location: accueil.php');
    die();
  }
} else {
  header('Location: accueil.php');
  die();
}


// ON SAUVEGARDE LES MESSAGES DANS SESSION PUIS ON LA SUPPRIME
// pour éviter qu'ils soient réutilisés pour aucune raison plus tard
if (isset($_SESSION["successReponse"])) {
  $msgReponseOK = $_SESSION["successReponse"];
  unset($_SESSION["successReponse"]);
} elseif (isset($_SESSION["erreurReponse"])) {
  $msgError = $_SESSION["erreurReponse"];
  unset($_SESSION["erreurReponse"]);
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
  <title>Debat - <?php echo $_GET["debat"]; ?></title>

  <!-- Bootstrap core CSS -->
  <link href="../dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/categorie.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="nav-scroller bg-white shadow-sm">
    <nav class="nav nav-underline">
      <a class="nav-link" href="pagecategorie.php?categorie=<?php echo $_GET["categorie"]; ?>">Revenir en arrière</a>
      <a class="nav-link" href="reglement.php">Règlement</a>
      <a class="nav-link" href="conditionsutilisation.php">Conditions d'utilisation</a>
    </nav>
  </div>

  <main role="main" class="container">

    <!-- MESSAGE APRÈS AJOUT DE REPONSE -->
    <?php if (isset($msgReponseOK)){ ?>
      <div class="alert alert-success alert-dismissible fade show alerteaccueil" role="alert">
        <strong>Envoi effectué avec succès</strong> <br>
        <?php echo $msgReponseOK; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

    <!-- MESSAGE APRÈS ECHEC D'ENVOI DE RÉPONSE -->
    <?php } elseif (isset($msgError)) { ?>
      <div class="alert alert-danger alert-dismissible fade show alerteindex" role="alert">
        <strong>Envoi du message echoué</strong> <br>
        <?php echo $msgError; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php } ?>

    <div class="row">
      <div class="col-12 col-md-4">

        <div class="my-3 p-3 bg-reponse rounded shadow-sm">
          <h6 class="border-bottom border-gray pb-2 mb-0">Ecrire une réponse</h6>
          <form action="../control/ajoutMessage.php" method="post">
            <input type="hidden" name="categorie" value=<?php echo $_GET["categorie"]; ?>>
            <input type="hidden" name="titreDeb" <?php echo 'value="'.$_GET["debat"].'"'; ?>>
            <div class="form-group">
              <textarea name="reponse" autofocus class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Prenez part au débat, exprimez vous, apportez des idées..." title="Votre réponse doit contenir au minimum 10 caractères" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
          </form>
        </div>
        <?php if (!suitDebat($database,$_SESSION["pseudo"],$_GET["debat"])) { ?>
        <form action="../control/suiviDebat.php" method="post">
          <input type="hidden" name="action" value="ON">
          <input type="hidden" name="debat" <?php echo 'value="'.$_GET["debat"].'"'; ?>>
          <input type="hidden" name="categorie" value=<?php echo $_GET["categorie"]; ?>>
          <button type="submit"  class="btn btn-outline-success btn-lg btn-block">Suivre ce débat</button>
        </form>
      <?php } else { ?>
        <form action="../control/suiviDebat.php" method="post">
          <input type="hidden" name="action" value="OFF">
          <input type="hidden" name="debat" <?php echo 'value="'.$_GET["debat"].'"'; ?>>
          <input type="hidden" name="categorie" value=<?php echo $_GET["categorie"]; ?>>
          <button type="submit"  class="btn btn-outline-danger btn-lg btn-block">Ne plus suivre ce débat</button>
        </form>
      <?php } ?>
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
