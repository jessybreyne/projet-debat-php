<?php
if (!session_id()) @ session_start();
if (isset($_SESSION)) session_destroy();

header('Location: ../pages/index.php');

 ?>
