<?php
// 1 : ouverture le fichier
$fic = fopen('../txt/bool.txt', 'r+');

// 2 : opérations sur le fichier...
ftruncate($fic, 0); // on efface le fichier

if ($_POST["maintenance"]==2){ // Si on clique sur RESET
    $bool = 0;
} else {
    $bool = 1; // On ecrit 1
    fseek($fic, 0); // On remet le curseur au début du fichier
}

fputs($fic, $bool); // On écrit

// 3 : fermeture le fichier
fclose($fic);
header('Location: ../pages/preferences.php');
?>