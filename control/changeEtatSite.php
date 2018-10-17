<?php

if (!session_id()) @ session_start();

// 1 : ouverture le fichier
$fic = fopen('../txt/bool.txt', 'r+');

// 2 : opérations sur le fichier...
ftruncate($fic, 0); // on efface le fichier

if ($_POST["maintenance"]=="OFF"){ // Si on veut ouvrir le site aux non-admin
    $bool = 0;
} else {
    $bool = 1;
}

fputs($fic, $bool); // On écrit

// 3 : fermeture du fichier
fclose($fic);

$etat = array("ON" => "ouvert" , "OFF" => "fermé");

// 4 : on crée un message de succès
$_SESSION["change"] = "Le site a bien été {$etat[$_POST["maintenance"]]} aux utilisateurs non-admin !";

// 5 On sauvegarde le nouvel état du site
$_SESSION["SystemeOuvert"] = $bool;

header('Location: ../pages/preferences.php');
?>
