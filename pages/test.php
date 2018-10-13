<?php

// IMPORTATION DES FONCTIONS DE L'API PHP-BD
require_once("../bd/API-debat.php");

date_default_timezone_set('Europe/Paris');

// Démarrer la connexion
$database = launchPDO("../bd/data");

print_r($database);

################################### MES TESTS

// echo "<br>";
//
// foreach (listeCateg($database) as $categ) {
//   print_r($categ);
//   echo "<br>";
// }
//
// echo "<br>";
//
// foreach (listeDebatsCateg($database,"Informatique") as $debat) {
//   print_r($debat["titre"]);
//   echo "<br>";
// }

echo "<br><br><br><br>TEST dernière activité<br>";
print_r(derniereActivite($database,"L'IA, un danger pour l'Homme ?"));
echo "<br>";
print_r(derniereActivite($database,"Les cookies, inoffensifs ou danger pour la vie privée ?"));
echo "<br>";

echo "<br><br><br><br>TEST date()<br>";
print_r(date("d/m/Y H:i:s"));

echo "<br><br><br><br>TEST listeCateg()<br>";
echo "<br>";
 ?>
