<?php

declare( strict_types = 1 );

define( 'BASEDIR', '/' . 'src' . '/' );

function my_autoloader( $class ) : void
{
    $essai = array();
    $trouve = false;

    if ( ! $trouve )
    {
        $chemin = '';
        $file = BASEDIR . $chemin . $class . '.php' ;
        if ( ! file_exists( $file ) )
        {
            $essai[] = $file;
        }
        $trouve = file_exists( $file ) ;
    }

    if ( ! $trouve )
    {
        $chemin = 'modele';
        $file = BASEDIR . $chemin . '/' . $class . '.php' ;
        if ( ! file_exists( $file ) )
        {
            $essai[] = $file;
        }
        $trouve = file_exists( $file ) ;
    }

    if ( ! $trouve )
    {
        $chemin = 'modele/Representation';
        $file = BASEDIR . $chemin . '/' . $class . '.php' ;
        if ( ! file_exists( $file ) )
        {
            $essai[] = $file;
        }
        $trouve = file_exists( $file ) ;
    }

    if ( ! $trouve )
    {
        echo "Les fichiers suivant ont été testé sans succès.\n";
        var_dump( $essai );
        exit();
    }

    include $file;

    if ( ! class_exists ( $class ) )
    {
        echo "La classe " . $class . " n'existe pas\n";
        exit();
    }

}

spl_autoload_register('my_autoloader');
