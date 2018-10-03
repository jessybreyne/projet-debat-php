<!-- API PHP pour l'application WEB de débat -->

<?php

try {

  $file_db=new PDO('mysql:host=localhost;dbname=debatDB');
  $file_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

  function getInfosUser($idU)


  // Fermeture de la connexion
  $file_db=null;
  
} catch (\Exception $e) {
  echo "ERREUR : ".$e->getMessage();
}

 ?>
