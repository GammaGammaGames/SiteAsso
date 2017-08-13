<?php
// Dernière modification : Dimanche 13 août[08] 2017

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

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEmpty( $this->e->get_date_debut() );
        $this->assertEmpty( $this->e->get_date_fin() );
        # Le assertequals vas comparer le contenu de l'objet Adresse.
        $this->assertEquals( $adr, $this->e->get_adresse() );
    }

    public function testChangerId()
    {
        $id = rand( 1, 100 );
        $this->e->set_id( $id );

        $this->assertEquals( $id, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEmpty( $this->e->get_date_debut() );
        $this->assertEmpty( $this->e->get_date_fin() );
        $this->assertEquals( new Adresse(), $this->e->get_adresse() );
    }

    public function testChangerNomEvenement()
    {
        $nom = "Bienvenu à Gattaca";
        $this->e->set_nom( $nom );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( $nom, $this->e->get_nom() );
        $this->assertEmpty( $this->e->get_date_debut() );
        $this->assertEmpty( $this->e->get_date_fin() );
        $this->assertEquals( new Adresse(), $this->e->get_adresse() );
    }

    public function testChangerDateDeDebut()
    {
        $date = "2018/03/22";
        $this->e->set_date_debut( $date );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $date, $this->e->get_date_debut() );
        $this->assertEmpty( $this->e->get_date_fin() );
        $this->assertEquals( new Adresse(), $this->e->get_adresse() );
    }

    public function testChangerDateDeFin()
    {
        $date = "2018/03/25";
        $this->e->set_date_fin( $date );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEmpty( $this->e->get_date_debut() );
        $this->assertEquals( $date, $this->e->get_date_fin() );
        $this->assertEquals( new Adresse(), $this->e->get_adresse() );
    }

    public function testChangerAdresse()
    {
        $adr = new Adresse();
        $adr->set_adresse( "42 Allée des nains" );
        $adr->set_ville( "Gattaca" );
        $adr->set_code_postal( "40200" );
        $adr->set_pays( "France" );

        $this->e->set_adresse( $adr );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEmpty( $this->e->get_date_debut() );
        $this->assertEmpty( $this->e->get_date_fin() );
        $this->assertEquals( $adr, $this->e->get_adresse() );
    }

}
