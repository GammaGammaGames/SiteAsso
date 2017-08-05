<?php
require_once("/var/private/mysql_config.php");

function afficher_base($id, $nom, $categorie, $nb)
{
    echo ("<h3>");
    echo ("$nom");
    echo ("</h3>");
    echo ("<ul>\n");
    echo ("<li>$id</li>\n");
    echo ("<li>$categorie</li>\n");
    echo ("<li>$nb</li>\n");
    echo ("</ul>\n");
}

echo ("<h1>Les driver PDO</h1>");

echo ("<p>");
echo ("Driver disponible avec pdo : ");
print_r(PDO::getAvailableDrivers());
echo ("</p>");

echo ("<h1>Résultat de l'exécution de la requête</h1>");

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

    // Récupération de la requête de l'utilisateur
    $requete = $_GET["req"]?? "";

    $affichage = "";
    $pos = 0;

    if ($requete != "")
    {
        $val = explode ("/", $requete);

        $nb_arg = count( $val );
        if ($nb_arg >= 1)
        {
            $affichage = $val[0];
            if ($affichage === "position" and $nb_arg >= 2)
            {
                $pos = $val[1];
            }
        }
    }

    if ($affichage === "complet")
    {
        $tableau = $s->fetchAll();

        foreach ($tableau as $e)
        {
            echo ("<p>");
            var_dump ($e);
            echo ("</p>");
        }
    }
    elseif ($affichage === "position")
    {
        $tableau = $s->fetchAll();
        echo ("<p>");
        var_dump ($tableau[$pos]);
        echo ("</p>");
    }
    elseif ($affichage === "jolie")
    {
        $s->fetchAll( PDO::FETCH_FUNC, "afficher_base" );
    }
    else
    {
        $debut = $_SERVER["HTTP_HOST"];
        $debut_adresse = "http://$debut/gamma";
        echo ("<ul>");
        echo ("    <li><a href='$debut_adresse/complet' >var dump de la base</a></li>");
        echo ("    <li><a href='$debut_adresse/position/6' >Afficher item 6</a></li>");
        echo ("    <li><a href='$debut_adresse/jolie' >Affichage lisible</a></li>");
        echo ("</ul>");
    }

}
catch(PDOException $e) {
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    die($msg);
}

echo ("<h1>Contenu des variables GET POST REQUEST</h1>");

echo ("<p>");
echo ("GET : ");
var_dump ($_GET);
echo ("</p>");
echo ("<p>");
echo ("POST : ");
var_dump ($_POST);
echo ("</p>");
echo ("<p>");
echo ("REQUEST : ");
var_dump ($_REQUEST);
echo ("</p>");
