<?php
// Dernière modification : Vendredi 01 septembre[09] 2017

/**
 * Tests unitaires de la classe Benevole.
 *
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

include_once "/var/www/html/modele/Representation/Benevole.php";

use Modele\Representation\Benevole;
use Modele\Representation\Joueur;
use Modele\Representation\Evenement;

use PHPUnit\Framework\TestCase;

class BenevoleTest extends TestCase
{

    protected $b;

    protected function setUp() : void
    {
        $this->b = new Benevole();
    }

    protected function tearDown() : void
    {
        $this->b = NULL;
    }

    public function testCreerBenevole()
    {
        $this->assertEquals( new Joueur(), $this->b->get_joueur() );
        $this->assertEquals( new Evenement(), $this->b->get_evenement() );
    }

    public function testChangerJoueur()
    {
        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_nom( "Baradur" );
        $j->set_prenom( "Yirtim" );

        $this->b->set_joueur( $j );

        $this->assertEquals( $j, $this->b->get_joueur() );
        $this->assertEquals( new Evenement(), $this->b->get_evenement() );
    }

    public function testChangerEvenement()
    {
        $e = new Evenement();
        $e->set_id( rand( 1, 100 ) );
        $e->set_nom( "Hooltar" );

        $this->b->set_evenement( $e );

        $this->assertEquals( new Joueur(), $this->b->get_joueur() );
        $this->assertEquals( $e, $this->b->get_evenement() );
    }

    /**
     * L'affichage pour le debogage.
     *
     * @return string
     * Toutes les données mise en forme.
     * */
    public function testAffichageDeboguage()
    {
        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_nom( "Baradur" );
        $j->set_prenom( "Yirtim" );

        $this->b->set_joueur( $j );

        $e = new Evenement();
        $e->set_id( rand( 1, 100 ) );
        $e->set_nom( "Hooltar" );

        $this->b->set_evenement( $e );

        $attendu = "<p>Débogage de Benevoles</p>";

        $attendu .= "<ul>";
        $attendu .= "<li>$j</li>";
        $attendu .= "<li>$e</li>";
        $attendu .= "</ul>";

        $this->assertEquals( $attendu, $this->b->__toString() );

    }

}
