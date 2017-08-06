<?php
require_once("/var/private/mysql_config.php");

$pdo = new PDO('mysql:host='
    . MYSQL_HOST
    . ';port='
    . MYSQL_PORT
    .';dbname='
    . MYSQL_DB
    . ';charset=utf8'
    , MYSQL_USER, MYSQL_PASSWORD);

$req_test=$pdo->query('SELECT * FROM joueurs;');
//$req_test->setFetchMode(PDO::FETCH_ASSOC);
$req_test->setFetchMode(PDO::FETCH_OBJ);
while($line = $req_test->fetch()){
    echo "<p>";
    var_dump($line);
    echo "</p>";
}
//var_dump($res_test);
echo "fini";

?>

