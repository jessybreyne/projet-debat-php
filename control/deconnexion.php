<?php
if (!session_id()) @ session_start();
if (isset($_SESSION["pseudo"])) {
  unset($_SESSION["pseudo"]);
}

header('Location: ../pages/index.php');

 ?>
