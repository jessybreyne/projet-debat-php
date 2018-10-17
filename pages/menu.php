<?php
if (!session_id()) @ session_start();


// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

if (!isset($_SESSION["pseudo"]) AND !peutContinuer($database,$_SESSION["pseudo"],$_SESSION["SystemeOuvert"])) header('Location: index.php');

 ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="accueil.php"><img src="../img/Debat-Logo-creme.png" style="width: 80px;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample04">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php
      $name=explode(".php",basename($_SERVER['REQUEST_URI']))[0];
      if($name=="pagecategorie" or $name=="accueil"){
        echo "active";
      }
      ?>">
      <a class="nav-link" href="accueil.php">

        <img  class="nav-img<?php
        $name=explode(".php",basename($_SERVER['REQUEST_URI']))[0];
        if($name=="pagecategorie" or $name=="accueil"){
          echo "-active";
        }
        ?>
        " src="../img/round_home_white_48dp.png">
        Accueil
      </a>
    </li>
    <li class="nav-item <?php
    $name=explode(".php",basename($_SERVER['REQUEST_URI']))[0];
    if($name=="mesdebats"){
      echo "active";
    }
    ?>">
    <a class="nav-link" href="mesdebats.php">
      <img class="nav-img<?php
      $name=explode(".php",basename($_SERVER['REQUEST_URI']))[0];
      if($name=="mesdebats"){
        echo "-active";
      }
      ?>" src="../img/round_question_answer_white_48dp.png">
      Mes débats
    </a>
  </li>
  <li class="nav-item dropdown <?php
      $name=explode(".php",basename($_SERVER['REQUEST_URI']))[0];
      if($name=="profil" or $name=="preferences"){
        echo "active";
      }
      ?>">
    <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <img class="nav-img<?php
      $name=explode(".php",basename($_SERVER['REQUEST_URI']))[0];
      if($name=="profil" or $name=="preferences"){
        echo "-active";
      }
      ?>" src="../img/round_person_white_48dp.png">
      <?php echo $_SESSION["pseudo"]; ?>
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdown04">
      <a class="dropdown-item" href="profil.php">Profil</a>
      <a class="dropdown-item" href="preferences.php">Préférences</a>
      <a class="dropdown-item" href="../control/deconnexion.php">Se deconnecter</a>
    </div>
  </li>
</ul>
<form action="recherche.php" class="form-inline my-2 my-md-0" method="post">
  <div class="input-group">
    <input required name="recherche" type="text" class="form-control mr-sm bug" placeholder="" aria-label="" aria-describedby="basic-addon1">
    <div class="input-group-append">
      <button class="btn btn-outline-success my-2 my-sm-0 mr-sm-2" type="submit">Chercher</button>
    </div>
  </div>
</form>
<?php
$name=explode(".php",basename($_SERVER['REQUEST_URI']))[0];
if($name!="nouveaudebat"){
  echo '<a class="btn btn-primary my-2 my-sm-0" href="nouveaudebat.php" role="button">Nouveau débat</a>';
}
?>

</div>
</nav>
