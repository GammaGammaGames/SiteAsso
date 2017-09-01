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

}
