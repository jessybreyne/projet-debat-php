<!-- API PHP pour l'application WEB de débat -->

<?php

try {
  require_once("data/mdp.php");

  date_default_timezone_set('Europe/Paris');
  $fileDB=new PDO('mysql:host=servinfo-db;dbname=dbmerillon;charset=utf8', 'merillon', mdp());
  $fileDB->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

  // Récupérer l'ID d'un User dont on connaît le pseudo
  function getUserID($pseudo){
    $infoU = $fileDB->query('SELECT * from UTILISATEUR where pseudo=:pseudo');
    $stmt = $fileDB->prepare($infoU);
    $stmt->bindParam(':pseudo',$pseudo);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['idUser']; // Retourne idUser de la première ligne
  }

  // Récupérer l'ID d'un Débat dont on connaît le titre
  function getDebatID($titre){
    $infoDeb = $fileDB->query('SELECT * from UTILISATEUR where titre=:titre');
    $stmt = $fileDB->prepare($infoDeb);
    $stmt->bindParam(':titre',$titre);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['idDebat']; // Retourne idDebat de la première ligne
  }

  // Récupérer une Array contenant toutes les infos d'un User dont on connaît l'ID
  function getInfosUser($idU){
    $user = $fileDB->query('SELECT * from UTILISATEUR where idUser=:idUser');
    $stmt = $fileDB->prepare($user);
    $stmt->bindParam(':idUser',$idU);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la première ligne
  }

  // Récupérer une Array contenant toutes les infos d'un Debat dont on connaît l'ID
  function getInfosDebat($idDeb){
    $debat = $fileDB->query('SELECT * from DEBAT where idDebat=:idDebat');
    $stmt = $fileDB->prepare($debat);
    $stmt->bindParam(':idDebat',$idDeb);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la première ligne
  }

  // Savoir si un pseudo est déjà utilisé (utile quand on ajoute un nouvel User)
  function pseudoExiste($pseudo){
    $idU = $fileDB->query('SELECT idUser from UTILISATEUR where pseudo=:pseudo');
    $stmt = $fileDB->prepare($idU);
    $stmt->bindParam(':pseudo',$pseudo);
    $stmt->execute();
    return count($idU) > 0;
  }

  // Hasher un MDP en Sha256
  function hashMDP($mdpBrut){
    return hash('sha2560',$mdpBrut);
  }

  // Obtenir un nouveau userId libre
  function newIDuser(){
    $idU = $fileDB->query('SELECT max(idUser) as newID from UTILISATEUR');
    return $idu->fetch()['newID'];
  }

  // Créer un utilisateur (non admin)
  function newUser($pseudo,$mdpBrut){
    $insert="INSERT INTO UTILISATEUR VALUES (:idUser, :pseudo, :mdpHash , :estAdmin)";
    $stmt = $fileDB->prepare($insert);
    $stmt->bindParam(':idUser',newIDuser());
    $stmt->bindParam(':pseudo',$pseudo);
    $stmt->bindParam(':mdpHash',hashMDP($mdpBrut));
    $stmt->bindParam(':estAdmin',0);
    $stmt->execute();
  }

  // Connaître le nombre de messages dans un débat (dont on connait l'ID)
  function nbMessages($titreDeb){
    $lesMess = $fileDB->query('SELECT * from DEBAT natural join MESSAGE where idDebat=:idDebat');
    $stmt = $fileDB->prepare($lesMess);
    $stmt->bindParam(':idDebat',getDebatID($titreDeb));
    $stmt->execute();
    return count($lesMess);
  }

  // Ajouter un message au débat
  // par un utilisateur dont on connaît le nom
  // dans un débat dont on connaît l'ID
  function newMessage($pseudo,$titreDeb,$message){
    // On commence par calculer le numMess
    $numMess = nbMessages($titreDeb) + 1;
    $insert="INSERT INTO MESSAGE VALUES (:idDebat, :numMess, :idAuteur, :contenu)";
    $stmt = $fileDB->prepare($insert);
    $stmt->bindParam(':idDebat',getDebatID($titreDeb));
    $stmt->bindParam(':numMess',$numMess);
    $stmt->bindParam(':idAuteur',getUserID($pseudo));
    $stmt->bindParam(':contenu',$message);
    $stmt->execute();
  }

  // Récupérer la liste des messages d'un débat dont on connaît l'ID (dans l'ordre)
  function listeMessages($titreDeb){
    $lesMess = $fileDB->query('SELECT * from DEBAT natural join MESSAGE where idDebat=:idDebat order by numMess');
    $stmt = $fileDB->prepare($lesMess);
    $stmt->bindParam(':idDebat',getDebatID($titreDeb));
    $stmt->execute();
    return $lesMess;
  }

  // Ajouter un suivi entre un User (dont on connaît le pseudo)
  // et un Débat (dont on connaît le titre)
  function newSuivi($pseudo,$titreDeb){
    $insert="INSERT INTO SUIVRE VALUES (:idDebat, :idUser)";
    $stmt = $fileDB->prepare($insert);
    $stmt->bindParam(':idDebat',getDebatID($titreDeb));
    $stmt->bindParam(':idUser',getUserID($pseudo));
    $stmt->execute();
  }

  // Initier un débat (automatiquement, le créateur suit son débat)
  // par un utilisateur dont on connait le pseudo
  // dans une catégorie dont on connait le nom
  function newDebat($pseudo,$nomCateg,$titreDeb){
    $insert="INSERT INTO DEBAT (idCreateur,nomCateg,titre) VALUES (:idCreateur, :nomCateg, :titre)";
    $stmt = $fileDB->prepare($insert);
    $stmt->bindParam(':idCreateur',getUserID($pseudo));
    $stmt->bindParam(':nomCateg',$nomCateg);
    $stmt->bindParam(':titre',$titreDeb);
    $stmt->execute();
    newSuivi($pseudo,$titreDeb);
  }

  // Récupérer les données pour la page "Mes débats" (catégorie, titre, auteur)
  // concernant un User dont on connaît le pseudo
  // (les débats qu'il a créés ou qu'il suit)
  function listeDebats($pseudo){
    $lesDeb = $fileDB->query('SELECT nomCateg,titre,idUser from CATEGORIE natural join DEBAT natural join SUIVRE and idUser=:idUser');
    $stmt = $fileDB->prepare($lesDeb);
    $stmt->bindParam(':idUser',getUserID($pseudo));
    $stmt->execute();
    return $lesDeb;
  }

  // Fermeture de la connexion
  // $fileDB=null;

} catch (\Exception $e) {
  echo "ERREUR : ".$e->getMessage();
}

 ?>
