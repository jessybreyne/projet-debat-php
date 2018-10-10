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
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Inscription réussie</strong> <br>
      <?php echo $msgIns; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php } ?>

    <!-- MESSAGE BIENVENUE APRÈS CONNEXION -->
    <?php if (isset($msgCo)) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Connexion réussie</strong> <br>
      <?php echo $msgCo; ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php } ?>

    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0">Liste des débats</h6>
      <div class="media text-muted pt-3">
        <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">Titre du débat</strong>
          Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
        </p>
      </div>
      <div class="media text-muted pt-3">
        <img data-src="holder.js/32x32?theme=thumb&bg=e83e8c&fg=e83e8c&size=1" alt="" class="mr-2 rounded">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">Titre du débat</strong>
          Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
        </p>
      </div>
      <div class="media text-muted pt-3">
        <img data-src="holder.js/32x32?theme=thumb&bg=6f42c1&fg=6f42c1&size=1" alt="" class="mr-2 rounded">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">Titre du débat</strong>
          Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
        </p>
      </div>
      <small class="d-block text-right mt-3">
        <a href="#">Afficher plus de débat</a>
      </small>
    </div>


    <nav aria-label="..." class="pagination justify-content-center">
      <ul class="pagination">
       <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Previous</span>
        </a>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item active">
        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
      </li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">Next</span>
        </a>
      </li>
    </ul>
  </nav>

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
