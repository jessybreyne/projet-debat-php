<?php
session_start();

function launchPDO(){
  date_default_timezone_set('Europe/Paris');
  $_SESSION["database"]=new PDO('mysql:host=servinfo-db;dbname=dbmerillon;charset=utf8', 'merillon', mdp());
  $_SESSION["database"]->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
}
 ?>
