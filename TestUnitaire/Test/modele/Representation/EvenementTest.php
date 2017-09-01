<?php
// Dernière modification : Vendredi 01 septembre[09] 2017

/**
 * Tests unitaires de la classe Evenement.
 *
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

include_once "/var/www/html/modele/Representation/Evenement.php";

use Modele\Representation\Adresse;
use Modele\Representation\Evenement;

use PHPUnit\Framework\TestCase;

class EvenementTest extends TestCase
{

    protected $e;
    protected $an0j0;
    protected $an0j1;

    protected function setUp() : void
    {
        $this->e = new Evenement();
        $this->an0j0 = new \DateTime( "1970-01-01" );
        $this->an0j1 = new \DateTime( "1970-01-02" );
    }

    protected function tearDown() : void
    {
        $this->e = NULL;
        $this->an0j0 = NULL;
        $this->an0j1 = NULL;
    }

    public function testCreerEvenement() : void
    {
        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->an0j0, $this->e->get_date_debut() );
        $this->assertEquals( $this->an0j1, $this->e->get_date_fin() );
        # Le assertequals vas comparer le contenu de l'objet Adresse.
        $this->assertEquals( new Adresse(), $this->e->get_adresse() );
    }

    public function testChangerId()
    {
        $id = rand( 1, 100 );
        $this->e->set_id( $id );

        $this->assertEquals( $id, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->an0j0, $this->e->get_date_debut() );
        $this->assertEquals( $this->an0j1, $this->e->get_date_fin() );
        $this->assertEquals( new Adresse(), $this->e->get_adresse() );
    }

    public function testChangerNomEvenement()
    {
        $nom = "Bienvenu à Gattaca";
        $this->e->set_nom( $nom );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( $nom, $this->e->get_nom() );
        $this->assertEquals( $this->an0j0, $this->e->get_date_debut() );
        $this->assertEquals( $this->an0j1, $this->e->get_date_fin() );
        $this->assertEquals( new Adresse(), $this->e->get_adresse() );
    }

    public function testChangerDateDeDebut()
    {
        $date = new \DateTime( "2018/03/22" );
        $this->e->set_date_debut( $date );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $date, $this->e->get_date_debut() );
        $this->assertEquals( $this->an0j1, $this->e->get_date_fin() );
        $this->assertEquals( new Adresse(), $this->e->get_adresse() );
    }

    public function testChangerDateDeFin()
    {
        $date = new \DateTime( "2018/03/25" );
        $this->e->set_date_fin( $date );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->an0j0, $this->e->get_date_debut() );
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
        $this->assertEquals( $this->an0j0, $this->e->get_date_debut() );
        $this->assertEquals( $this->an0j1, $this->e->get_date_fin() );
        $this->assertEquals( $adr, $this->e->get_adresse() );
    }

    public function testAffichageDeboguage()
    {
        $adr = new Adresse();
        $adr->set_adresse( "42 Allée des nains" );
        $adr->set_ville( "Gattaca" );
        $adr->set_code_postal( "40200" );
        $adr->set_pays( "France" );

        $this->e->set_adresse( $adr );

        $id = rand( 1, 100 );
        $nom = "Bienvenu à Gattaca";
        $date_deb = new \DateTime( "2018/03/22" );
        $date_fin = new \DateTime( "2018/03/25" );
        $this->e->set_id( $id );
        $this->e->set_nom( $nom );
        $this->e->set_date_debut( $date_deb );
        $this->e->set_date_fin( $date_fin );

        $d = $date_deb->format( \DateTime::W3C );
        $f = $date_fin->format( \DateTime::W3C );

        $attendu = "<p>Débogage de Evenement</p>";
        $attendu .= "<ul>";
        $attendu .= "<li>id            = $id</li>";
        $attendu .= "<li>nom           = $nom</li>";
        $attendu .= "<li>date de début = $d</li>";
        $attendu .= "<li>date de fin   = $f</li>";
        $attendu .= "<li>$adr</li>";
        $attendu .= "</ul>";

        $this->assertEquals( $attendu, $this->e->__toString() );
    }

}
