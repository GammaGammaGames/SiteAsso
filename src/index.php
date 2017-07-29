<?php

// pour le php7
// Cette déclaration doit être mise au début de chaque fichier
declare( strict_types = 1 );

session_start();

ini_set("display_errors",1);
ini_set("log_errors",1);

error_reporting(E_ALL);

require("entree_josselin.php");
require("entree_julien.php");

?>
