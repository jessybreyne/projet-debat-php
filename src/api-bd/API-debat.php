<!-- API PHP pour l'application WEB de débat -->

<?php

try {

  $fileDB=new PDO('mysql:host=localhost;dbname=DBmerillon');
  $fileDB->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

  // Récupérer l'ID d'un User dont on connaît le pseudo
  function getIdUser($pseudo){
    $idU = $fileDB->query('SELECT * from UTILISATEUR where pseudo='.$pseudo);
    foreach ($idU as $res) { // On fait une boucle mais il n'y a qu'une seule ligne
      return $res;
    }
  }

  // Récupérer une Array contenant toutes les infos d'un User dont on connaît l'ID
  function getInfosUser($idU){
    $user = $fileDB->query('SELECT * from UTILISATEUR where idUser='.$idU);
    foreach ($user as $res) { // On fait une boucle mais il n'y a qu'une seule ligne
      return $res;
    }
  }

  // Savoir si un pseudo est déjà utilisé (utile quand on ajoute un nouvel User)
  function pseudoExiste($pseudo){
    $idU = $fileDB->query('SELECT * from UTILISATEUR where pseudo='.$pseudo);
    return count($idU) > 0;
  }

  // Hasher un MDP en Sha256
  function hashMDP($mdpBrut){
    return hash('sha2560',$mdpBrut);
  }

  // Créer un utilisateur (non admin)
  function newUser($pseudo,$mdpBrut){
    $insert="INSERT INTO contacts (pseudo, mdpHash, estAdmin) VALUES (:pseudo, :mdpHash , :estAdmin)";
    $stmt = $fileDB->prepare($insert);
    $stmt->bindParam(':pseudo',$pseudo);
    $stmt->bindParam(':mdpHash',hashMDP($mdpBrut));
    $stmt->bindParam(':estAdmin',0);
    $stmt->execute();
  }

  // Fermeture de la connexion
  $fileDB=null;

} catch (\Exception $e) {
  echo "ERREUR : ".$e->getMessage();
}

 ?>
