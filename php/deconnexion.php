<?php

session_start();

session_destroy();
echo "Vous allez être déconnecté dans 3 secondes";
header("refresh:3;url=../index.php");
 ?>
