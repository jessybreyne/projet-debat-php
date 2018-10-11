<!-- API PHP pour l'application WEB de débat -->

<!-- DEBUG :
$stmt->debugDumpParams();
die();
-->

<?php

require_once("data/PDO.php");

// Récupérer l'ID d'un User dont on connaît le pseudo
function getUserID($database,$pseudo){
  $infoU = "SELECT * from UTILISATEUR where pseudo=:pseudo";
  $stmt = $database->prepare($infoU);
  $stmt->bindParam(':pseudo',$pseudo);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC)['idUser']; // Retourne idUser de la première ligne
}

// Récupérer l'ID d'un Débat dont on connaît le titre
function getDebatID($database,$titre){
  $infoDeb = "SELECT * from UTILISATEUR where titre=:titre";
  $stmt = $database->prepare($infoDeb);
  $stmt->bindParam(':titre',$titre);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC)['idDebat']; // Retourne idDebat de la première ligne
}

// Récupérer une Array contenant toutes les infos d'un User dont on connaît le pseudo
function getInfosUser($database,$pseudo){
  $user = "SELECT * from UTILISATEUR where pseudo=:pseudo";
  $stmt = $database->prepare($user);
  $stmt->bindParam(':pseudo',$pseudo);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la première ligne
}

// Récupérer une Array contenant toutes les infos d'un Debat dont on connaît l'ID
function getInfosDebat($database,$idDeb){
  $debat = "SELECT * from DEBAT where idDebat=:idDebat";
  $stmt = $database->prepare($debat);
  $stmt->bindParam(':idDebat',$idDeb);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la première ligne
}

// Savoir si un pseudo est déjà utilisé (utile quand on ajoute un nouvel User)
function pseudoExiste($database,$pseudo){
  $idU = "SELECT count(idUser) as nbU FROM UTILISATEUR where pseudo=:pseudo";
  $stmt = $database->prepare($idU);
  $stmt->bindParam(':pseudo',$pseudo);
  $stmt->execute();
  return $stmt->fetch()["nbU"] > 0;
}

// Hasher un MDP en Sha256
function hashMDP($mdpBrut){
  return hash('sha256',$mdpBrut);
}

// Obtenir un nouveau userId libre
function newIDuser($database){
  $idU = "SELECT max(idUser) as newID from UTILISATEUR";
  $stmt = $database->query($idU);
  return $stmt->fetch()['newID']+1;
}

// Créer un utilisateur (non admin)
function newUser($database,$pseudo,$mdpBrut){
  $insert="INSERT INTO UTILISATEUR VALUES (:idUser, :pseudo, :mdpHash , 0)";
  $stmt = $database->prepare($insert);

  $hash = hashMDP($mdpBrut);
  $user = newIDuser($database);

  $stmt->bindParam(':idUser',$user);
  $stmt->bindParam(':pseudo',$pseudo);
  $stmt->bindParam(':mdpHash',$hash);
  $stmt->execute();
}

// Connaître le nombre de messages dans un débat (dont on connait l'ID)
function nbMessages($database,$titreDeb){

  $lesMess = "SELECT * from DEBAT natural join MESSAGE where idDebat=:idDebat";
  $stmt = $database->prepare($lesMess);
  $debatID = getDebatID($database,$titreDeb);
  $stmt->bindParam(':idDebat',$debatID);
  $stmt->execute();
  return count($lesMess);
}

// Ajouter un message au débat
// par un utilisateur dont on connaît le nom
// dans un débat dont on connaît l'ID
function newMessage($database,$pseudo,$titreDeb,$message){
  // On commence par calculer le numMess
  $numMess = nbMessages($database,$titreDeb) + 1;
  $insert="INSERT INTO MESSAGE VALUES (:idDebat, :numMess, :idAuteur, :contenu)";
  $stmt = $database->prepare($insert);
  $debatID = getDebatID($database,$titreDeb);
  $userID = getUserID($database,$pseudo);
  $stmt->bindParam(':idDebat',$debatID);
  $stmt->bindParam(':numMess',$numMess);
  $stmt->bindParam(':idAuteur',$userID);
  $stmt->bindParam(':contenu',$message);
  $stmt->execute();
}

// Récupérer la liste des messages d'un débat dont on connaît l'ID (dans l'ordre)
function listeMessages($database,$titreDeb){

  $lesMess = "SELECT * from DEBAT natural join MESSAGE where idDebat=:idDebat order by numMess";
  $stmt = $database->prepare($lesMess);
  $debatID = getDebatID($database,$titreDeb);
  $stmt->bindParam(':idDebat',$debatID);
  $stmt->execute();
  return $lesMess;
}

// Ajouter un suivi entre un User (dont on connaît le pseudo)
// et un Débat (dont on connaît le titre)
function newSuivi($database,$pseudo,$titreDeb){
  $insert="INSERT INTO SUIVRE VALUES (:idDebat, :idUser)";
  $stmt = $database->prepare($insert);
  $debatID = getDebatID($database,$titreDeb);
  $userID = getUserID($database,$pseudo);
  $stmt->bindParam(':idDebat',$debatID);
  $stmt->bindParam(':idUser',$userID);
  $stmt->execute();
}

// Initier un débat (automatiquement, le créateur suit son débat)
// par un utilisateur dont on connait le pseudo
// dans une catégorie dont on connait le nom
function newDebat($database,$pseudo,$nomCateg,$titreDeb){
  $insert="INSERT INTO DEBAT (idCreateur,nomCateg,titre) VALUES (:idCreateur, :nomCateg, :titre)";
  $stmt = $database->prepare($insert);
  $userID = getUserID($database,$pseudo);
  $stmt->bindParam(':idCreateur',$userID);
  $stmt->bindParam(':nomCateg',$nomCateg);
  $stmt->bindParam(':titre',$titreDeb);
  $stmt->execute();
  newSuivi($database,$pseudo,$titreDeb);
}

// Récupérer les données pour la page "Mes débats" (catégorie, titre, auteur)
// concernant un User dont on connaît le pseudo
// (les débats qu'il a créés ou qu'il suit)
function listeDebats($database,$pseudo){
  $lesDeb = "SELECT nomCateg,titre,idUser from CATEGORIE natural join DEBAT natural join SUIVRE and idUser=:idUser";
  $stmt = $database->prepare($lesDeb);
  $userID = getUserID($database,$pseudo);
  $stmt->bindParam(':idUser',$userID);
  $stmt->execute();
  return $lesDeb;
}

// Récupérer la liste des catégories
function listeCateg($database){
  $lesCateg = "SELECT * from CATEGORIE";
  $query = $database->query($lesCateg);

  // Transformation en array php
  $res = array();
  while($row = $query->fetch()){
    array_push($res,$row["nomCateg"]);
  }
  return $res;
}


// Fermeture de la connexion
// $database = null;

?>
