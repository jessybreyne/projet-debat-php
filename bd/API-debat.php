<!-- API PHP pour l'application WEB de débat -->

<!-- DEBUG :
$stmt->debugDumpParams();
die();
-->

<?php

require_once("data/PDO.php");

// Transformer un résultat de requette en Array pour PHP
function getArray($query){
  $res = array();
  while($row = $query->fetch()){
    array_push($res,$row);
  }
  return $res;
}

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
  $infoDeb = "SELECT * from DEBAT where titre=:titre";
  $stmt = $database->prepare($infoDeb);
  $stmt->bindParam(':titre',$titre);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC)['idDebat']; // Retourne idDebat de la première ligne
}

// Récupérer une Array contenant toutes les infos d'un User dont on connaît l'ID'
function getInfosUserID($database,$idU){
  $user = "SELECT * from UTILISATEUR where idUser=:idUser";
  $stmt = $database->prepare($user);
  $stmt->bindParam(':idUser',$idU);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la première ligne
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

// Savoir si un utilisateur à le droit de continuer sur le site en fonction de l'ouverture du système
function peutContinuer($database,$pseudo,$systemeEstOuvert){
  $infosUser = getInfosUser($database,$pseudo);
  if ($systemeEstOuvert) return true;
  return $infosUser["estAdmin"];
}

// Connaître la date de dernière activité d'un Debat dont on connaît le titre
function derniereActivite($database,$titreDeb){
  if (count(listeMessages($database,$titreDeb)) == 0){ // Aucun message dans le débat
    return "Aucune activité";
  } else {
    $lesMess = "SELECT max(datePub) as lastModif from DEBAT natural join MESSAGE where idDebat=:idDebat";
    $stmt = $database->prepare($lesMess);
    $debatID = getDebatID($database,$titreDeb);
    $stmt->bindParam(':idDebat',$debatID);
    $stmt->execute();
    $res = getArray($stmt);
    return $res[0]["lastModif"];
  }
}

// Savoir si un pseudo est déjà utilisé (utile quand on ajoute un nouvel User)
function pseudoExiste($database,$pseudo){
  $idU = "SELECT count(idUser) as nbU FROM UTILISATEUR where pseudo=:pseudo";
  $stmt = $database->prepare($idU);
  $stmt->bindParam(':pseudo',$pseudo);
  $stmt->execute();
  return $stmt->fetch()["nbU"] > 0;
}

// Savoir si un titre de débat est déjà utilisé (utile quand on ajoute un nouveau débat)
function titreDebExiste($database,$titre){
  $nbDeb = "SELECT count(idDebat) as nbDeb FROM DEBAT where titre=:titre";
  $stmt = $database->prepare($nbDeb);
  $stmt->bindParam(':titre',$titre);
  $stmt->execute();
  return $stmt->fetch()["nbDeb"] > 0;
}

// Hasher un MDP en Sha256
function hashMDP($mdpBrut){
  return hash('sha256',$mdpBrut);
}

// Obtenir un nouveau idUser libre
function newIDuser($database){
  $idU = "SELECT max(idUser) as newID from UTILISATEUR";
  $stmt = $database->query($idU);
  return $stmt->fetch()['newID']+1;
}

// Obtenir un nouveau idDebat libre
function newIDdebat($database){
  $idU = "SELECT max(idDebat) as newID from DEBAT";
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

// Connaître le nombre de messages dans un débat (dont on connait le titre)
function nbMessages($database,$titreDeb){
  $lesMess = "SELECT count(*) as nbMess from DEBAT natural join MESSAGE where idDebat=:idDebat group by idDebat";
  $stmt = $database->prepare($lesMess);
  $debatID = getDebatID($database,$titreDeb);
  $stmt->bindParam(':idDebat',$debatID);
  $stmt->execute();
  return $stmt->fetch()["nbMess"];
}

// Ajouter un message au débat
// par un utilisateur dont on connaît le nom
// dans un débat dont on connaît l'ID
function newMessage($database,$pseudo,$titreDeb,$message){
  $insert="INSERT INTO MESSAGE VALUES (:idDebat, :numMess, :idAuteur, :contenu, :datePub)";
  $stmt = $database->prepare($insert);

  $numMess = nbMessages($database,$titreDeb) + 1;
  $debatID = getDebatID($database,$titreDeb);
  $userID = getUserID($database,$pseudo);
  $date = date("d/m/Y H:i:s");

  $stmt->bindParam(':idDebat',$debatID);
  $stmt->bindParam(':numMess',$numMess);
  $stmt->bindParam(':idAuteur',$userID);
  $stmt->bindParam(':contenu',$message);
  $stmt->bindParam(':datePub',$date);
  $stmt->execute();
}

// Récupérer la liste des messages d'un débat dont on connaît le titre (dans l'ordre)
function listeMessages($database,$titreDeb){

  $lesMess = "SELECT * from DEBAT natural join MESSAGE where idDebat=:idDebat order by numMess";
  $stmt = $database->prepare($lesMess);
  $debatID = getDebatID($database,$titreDeb);
  $stmt->bindParam(':idDebat',$debatID);
  $stmt->execute();
  return getArray($stmt);
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

// Savoir si un utilisateur est admin
function estAdmin($database,$pseudo){
  $infosUser = getInfosUser($database,$pseudo);
  return $infosUser["estAdmin"];
}

// Initier un débat (automatiquement, le créateur suit son débat)
// par un utilisateur dont on connait le pseudo
// dans une catégorie dont on connait le nom
function newDebat($database,$pseudo,$nomCateg,$titreDeb){
  $insert="INSERT INTO DEBAT VALUES (:idDebat, :idCreateur, :nomCateg, :titre)";
  $stmt = $database->prepare($insert);
  $debatID = newIDdebat($database);
  $userID = getUserID($database,$pseudo);
  $stmt->bindParam(':idDebat',$debatID);
  $stmt->bindParam(':idCreateur',$userID);
  $stmt->bindParam(':nomCateg',$nomCateg);
  $stmt->bindParam(':titre',$titreDeb);
  $stmt->execute();
  newSuivi($database,$pseudo,$titreDeb);
}

// Récupérer les données pour la page "Mes débats" (idDebat, catégorie, titre, idCreateur)
// concernant un User dont on connaît le pseudo
// (les débats qu'il a créés ou qu'il suit)
function listeDebatsUser($database,$pseudo){
  $lesDeb = "SELECT idDebat,nomCateg,titre,idCreateur from CATEGORIE natural join DEBAT natural join SUIVRE where idUser=:idUser";
  $stmt = $database->prepare($lesDeb);
  $userID = getUserID($database,$pseudo);
  $stmt->bindParam(':idUser',$userID);
  $stmt->execute();

  return getArray($stmt);
}

// Récupérer la liste des débats d'une catégorie (idDebat, titre, idCreateur)
function listeDebatsCateg($database,$nomCateg){
  $lesDeb = "SELECT idDebat,titre,idCreateur from CATEGORIE natural join DEBAT where nomCateg=:nomCateg";
  $stmt = $database->prepare($lesDeb);
  $userID = getUserID($database,$nomCateg);
  $stmt->bindParam(':nomCateg',$nomCateg);
  $stmt->execute();

  return getArray($stmt);
}

// Récupérer les noms des catégories dans le résultat de la requête
function nomsCateg($query){
  $res = array();
  while($row = $query->fetch()){
    array_push($res,$row["nomCateg"]);
  }
  return $res;
}

// Récupérer la liste des catégories
function listeCateg($database){
  $lesCateg = "SELECT * from CATEGORIE";
  $query = $database->query($lesCateg);

  return nomsCateg($query);
}


// Fermeture de la connexion
// $database = null;

?>
