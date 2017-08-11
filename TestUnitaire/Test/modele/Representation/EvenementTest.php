<?php
// Dernière modification : Vendredi 11 août[08] 2017

declare( strict_types = 1 );

include_once "/src/modele/Representation/Evenement.php";

use PHPUnit\Framework\TestCase;

/**
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */
class EvenementTest extends TestCase
{

    protected $e;

    protected function setUp() : void
    {
        $this->e = new Evenement();
    }

    protected function tearDown() : void
    {
        $this->e = NULL;
    }

    public function testCreerEvenement() : void
    {
        $adr = new Adresse();
        $this->e->set_adresse( $adr );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEmpty( $this->e->get_date_debut() );
        $this->assertEmpty( $this->e->get_date_fin() );
        # Le assertequals vas comparer le contenu de l'objet Adresse.
        $this->assertEquals( $adr, $this->e->get_adresse() );
    }

}
