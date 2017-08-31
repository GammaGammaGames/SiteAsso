<?php
require_once( "/var/private/mysql_config.php" );

function afficher_base( $id, $nom, $categorie, $nb )
{
    echo ( "\n<h3>" );
    echo ( "$nom" );
    echo ( "</h3>" );
    echo ( "<ul>\n" );
    echo ( "    <li>$id</li>\n" );
    echo ( "    <li>$categorie</li>\n" );
    echo ( "    <li>$nb</li>\n" );
    echo ( "</ul>\n" );
}

echo ( "<h1>Les driver PDO</h1>\n" );

echo ( "<p>\n" );
echo ( "Driver disponible avec pdo : \n" );
print_r( PDO::getAvailableDrivers() );
echo ( "</p>\n" );

echo ( "<h1>Résultat de l'exécution de la requête</h1>\n" );

try
{
    $pdo = new PDO(
        'mysql:host='
        . MYSQL_HOST
        . ';port='
        . MYSQL_PORT
        . ';dbname='
        . MYSQL_DB
        . ';charset=utf8'
        , MYSQL_USER
        , MYSQL_PASSWORD);

    $r = "SELECT * FROM TEST";

    $s = $pdo->prepare( $r );
    $s->execute();

    // Récupération de la requête de l'utilisateur
    $requete = $_GET["req"]?? "accueil";

    $affichage = "";
    $pos = 0;

    if ( $requete !== "accueil" )
    {
        $val = explode ( "/", $requete );

        $nb_arg = count( $val );
        if ( $nb_arg >= 1 )
        {
            $affichage = $val[1];
        }
        if ( $nb_arg > 2 )
        {
            if ( $affichage === "position" && $nb_arg === 3 )
            {
                $pos = $val[2] - 1;
            }
            else
            {
                $affichage = "404";
            }
        }
    }

    $debut = $_SERVER["HTTP_HOST"];
    $debut_adresse = "http://$debut";
    if ( $affichage === "complet" )
    {
        echo ( "<ul>\n" );
        echo ( "    <li><a href='$debut_adresse/' >Accueil</a></li>\n" );
        echo ( "</ul>\n" );
        $tableau = $s->fetchAll();

        foreach ( $tableau as $e )
        {
            echo ( "\n<p>\n" );
            var_dump ( $e );
            echo ( "\n</p>\n" );
        }
    }
    elseif ( $affichage === "position" )
    {
        echo ( "<ul>\n" );
        echo ( "    <li><a href='$debut_adresse/' >Accueil</a></li>\n" );
        echo ( "</ul>\n" );
        $tableau = $s->fetchAll();
        echo ( "<p>\n" );
        $p = $tableau[$pos];
        afficher_base ( $p[0], $p[1], $p[2], $p[3] );
        echo ( "</p>\n" );
        echo ( "<div>\n" );
        $deb = "";
        $fin = "";
        if ( $pos > 0 )
        {
            $deb = "<a href='$debut_adresse/position/$pos' >";
            $fin = "</a>";
        }
        echo ( "$deb" );
        echo ( "Précédent" );
        echo ( "$fin - " );
        $suivant = $pos + 2;
        $deb = "";
        $fin = "";
        if ( $pos + 1 < count( $tableau ) )
        {
            $deb = "<a href='$debut_adresse/position/$suivant' >";
            $fin = "</a>";
        }
        echo ( "$deb" );
        echo ( "Suivant" );
        echo ( "$fin" );
        echo ( "\n</div>\n" );
    }
    elseif ( $affichage === "jolie" )
    {
        echo ( "<ul>\n" );
        echo ( "    <li><a href='$debut_adresse/' >Accueil</a></li>\n" );
        echo ( "</ul>\n" );
        $s->fetchAll( PDO::FETCH_FUNC, "afficher_base" );
    }
    elseif ( $affichage === "" )
    {
        echo ( "<ul>\n" );
        echo ( "    <li><a href='$debut_adresse/complet' >var dump de la base</a></li>\n" );
        echo ( "    <li><a href='$debut_adresse/position/6' >Afficher item 6</a></li>\n" );
        echo ( "    <li><a href='$debut_adresse/jolie' >Affichage lisible</a></li>\n" );
        echo ( "    <li><a href='$debut_adresse/iebfzej' >Page inconnue</a></li>\n" );
        echo ( "</ul>\n" );
    }
    else
    {
        echo( "<ul>\n" );
        echo( "    <li><a href='$debut_adresse/' >Accueil</a></li>\n" );
        echo( "</ul>\n" );
        echo( "<h1>404</h1>\n" );
        $affichage = "404";
    }

}
catch ( Exception $e )
{
    $msg = 'ERREUR PDO dans ' . $e->getFile() . ' L.' . $e->getLine() . ' : ' . $e->getMessage();
    echo ( $msg );
    $affichage = "404";
}


if ( $affichage !== "404" )
{
    echo ( "<h1>Contenu des variables GET POST REQUEST</h1>\n" );

    echo ( "<p>\n" );
    echo ( "GET : " );
    var_dump ( $_GET );
    echo ( "\n</p>\n" );
    echo ( "<p>\n" );
    echo ( "POST : " );
    var_dump ( $_POST );
    echo ( "\n</p>\n" );
    echo ( "<p>\n" );
    echo ( "REQUEST : " );
    var_dump ( $_REQUEST );
    echo ( "\n</p>\n" );
}
