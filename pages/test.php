<?php

if (!session_id()) @ session_start();

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

echo "<br><br><br><br>TEST fermeture du site aux non-admin<br>";
if (peutContinuer($database,"admin",$_SESSION["SystemeOuvert"])) echo "Le site est ouvert aux administrateurs.";
if (!peutContinuer($database,"Mathieu",$_SESSION["SystemeOuvert"])) echo "Le site est fermé aux non-admin.";
echo "<br>";

echo "<br><br><br><br>TEST suitDebat<br>";
echo suitDebat($database,"admin","L'IA, un danger pour l'Homme ?");
echo "<br>";
if (!suitDebat($database,"admin","Les cookies, inoffensifs ou danger pour la vie privée ?")){
  echo "Admin ne suit pas ce débat !";
}
echo "<br>";

echo "<br><br><br><br>TEST recherches<br>Je cherche un débat avec le mot 'danger' : <br>";
print_r(listeDebatsString($database,"danger"));
echo "<br>";

 ?>
