<?php

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

// Démarrer la connexion
$database = launchPDO("../bd/data");

print_r($database);

echo "<br>";

foreach (listeCateg($database) as $categ) {
  echo $categ."<br>";
}

 ?>
