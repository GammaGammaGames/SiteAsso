<?php
require_once("/var/private/mysql_config.php");

echo ("<p>");
echo ("Driver disponible avec pdo : ");
print_r(PDO::getAvailableDrivers());
echo ("</p>");

try
{
    $pdo = new PDO('mysql:host='
        . MYSQL_HOST
        . ';port='
        . MYSQL_PORT
        . ';dbname='
        . MYSQL_DB
        . ';charset=utf8'
        , MYSQL_USER, MYSQL_PASSWORD);

    $r = "SELECT * FROM TEST";

    $s = $pdo->prepare( $r );
    $s->execute();

    echo ("<p>");
    var_dump ($s->fetchAll());
    echo ("</p>");
}
catch(PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}

echo ("<p>");
var_dump ($_GET);
echo ("</p>");
echo ("<p>");
var_dump ($_POST);
echo ("</p>");
echo ("<p>");
var_dump ($_REQUEST);
echo ("</p>");
