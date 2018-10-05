<?php

function formEstRempli(){
  return isset($_POST["pseudo"]) AND isset($_POST["pwd1"]) AND isset($_POST["pwd2"]);
}

if (!formEstRempli()){
  header('Location: index.php');
}
 ?>
