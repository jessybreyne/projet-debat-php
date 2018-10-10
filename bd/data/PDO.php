<?php
#Connexion MySQL : 'mysql:host=servinfo-db;dbname=dbmerillon;charset=utf8', 'merillon',mdp

function launchPDO($link){
  try {
    date_default_timezone_set('Europe/Paris');
    $database=new PDO("sqlite:$link/data.sqlite3");
    $database->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    return $database;
  } catch (\Exception $e) {
    echo "Error : ".$e->getMessage();
  }

}
 ?>
