<!-- API PHP pour l'application WEB de débat -->

<?php
require_once("data/mdp.php");

date_default_timezone_set('Europe/Paris');
$database=new PDO('mysql:host=servinfo-db;dbname=dbmerillon;charset=utf8', 'merillon', mdp());
$database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

// Récupérer l'ID d'un User dont on connaît le pseudo
function getUserID($pseudo){
  $infoU = $database->query('SELECT * from UTILISATEUR where pseudo=:pseudo');
  $stmt = $database->prepare($infoU);
  $stmt->bindParam(':pseudo',$pseudo);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC)['idUser']; // Retourne idUser de la première ligne
}

// Récupérer l'ID d'un Débat dont on connaît le titre
function getDebatID($titre){
  $infoDeb = $database->query('SELECT * from UTILISATEUR where titre=:titre');
  $stmt = $database->prepare($infoDeb);
  $stmt->bindParam(':titre',$titre);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC)['idDebat']; // Retourne idDebat de la première ligne
}

// Récupérer une Array contenant toutes les infos d'un User dont on connaît l'ID
function getInfosUser($idU){
  $user = $database->query('SELECT * from UTILISATEUR where idUser=:idUser');
  $stmt = $database->prepare($user);
  $stmt->bindParam(':idUser',$idU);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la première ligne
}

// Récupérer une Array contenant toutes les infos d'un Debat dont on connaît l'ID
function getInfosDebat($idDeb){
  $debat = $database->query('SELECT * from DEBAT where idDebat=:idDebat');
  $stmt = $database->prepare($debat);
  $stmt->bindParam(':idDebat',$idDeb);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la première ligne
}

// Savoir si un pseudo est déjà utilisé (utile quand on ajoute un nouvel User)
function pseudoExiste($pseudo){
  $idU = $database->query('SELECT idUser from UTILISATEUR where pseudo=:pseudo');
  $stmt = $database->prepare($idU);
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
  $idU = $database->query('SELECT max(idUser) as newID from UTILISATEUR');
  return $idu->fetch()['newID'];
}

// Créer un utilisateur (non admin)
function newUser($pseudo,$mdpBrut){
  $insert="INSERT INTO UTILISATEUR VALUES (:idUser, :pseudo, :mdpHash , :estAdmin)";
  $stmt = $database->prepare($insert);
  $stmt->bindParam(':idUser',newIDuser());
  $stmt->bindParam(':pseudo',$pseudo);
  $stmt->bindParam(':mdpHash',hashMDP($mdpBrut));
  $stmt->bindParam(':estAdmin',0);
  $stmt->execute();
}

// Connaître le nombre de messages dans un débat (dont on connait l'ID)
function nbMessages($titreDeb){
  $lesMess = $database->query('SELECT * from DEBAT natural join MESSAGE where idDebat=:idDebat');
  $stmt = $database->prepare($lesMess);
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
  $stmt = $database->prepare($insert);
  $stmt->bindParam(':idDebat',getDebatID($titreDeb));
  $stmt->bindParam(':numMess',$numMess);
  $stmt->bindParam(':idAuteur',getUserID($pseudo));
  $stmt->bindParam(':contenu',$message);
  $stmt->execute();
}

// Récupérer la liste des messages d'un débat dont on connaît l'ID (dans l'ordre)
function listeMessages($titreDeb){
  $lesMess = $database->query('SELECT * from DEBAT natural join MESSAGE where idDebat=:idDebat order by numMess');
  $stmt = $database->prepare($lesMess);
  $stmt->bindParam(':idDebat',getDebatID($titreDeb));
  $stmt->execute();
  return $lesMess;
}

// Ajouter un suivi entre un User (dont on connaît le pseudo)
// et un Débat (dont on connaît le titre)
function newSuivi($pseudo,$titreDeb){
  $insert="INSERT INTO SUIVRE VALUES (:idDebat, :idUser)";
  $stmt = $database->prepare($insert);
  $stmt->bindParam(':idDebat',getDebatID($titreDeb));
  $stmt->bindParam(':idUser',getUserID($pseudo));
  $stmt->execute();
}

// Initier un débat (automatiquement, le créateur suit son débat)
// par un utilisateur dont on connait le pseudo
// dans une catégorie dont on connait le nom
function newDebat($pseudo,$nomCateg,$titreDeb){
  $insert="INSERT INTO DEBAT (idCreateur,nomCateg,titre) VALUES (:idCreateur, :nomCateg, :titre)";
  $stmt = $database->prepare($insert);
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
  $lesDeb = $database->query('SELECT nomCateg,titre,idUser from CATEGORIE natural join DEBAT natural join SUIVRE and idUser=:idUser');
  $stmt = $database->prepare($lesDeb);
  $stmt->bindParam(':idUser',getUserID($pseudo));
  $stmt->execute();
  return $lesDeb;
}
// Fermeture de la connexion
// $database=null;

?>
