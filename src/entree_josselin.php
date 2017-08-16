<?php
require_once("/var/private/mysql_config.php");
require_once("/var/www/html/acces_bdd/acces_bdd.php");


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

