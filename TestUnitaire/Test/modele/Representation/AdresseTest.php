<?php
// Dernière modification : Vendredi 11 août[08] 2017

declare( strict_types = 1 );

include_once "/src/modele/Representation/Adresse.php";

use PHPUnit\Framework\TestCase;

/**
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */
class AdresseTest extends TestCase
{

    protected $a;

    protected function setUp() : void
    {
        $this->a = new Adresse();
    }

    protected function tearDown() : void
    {
        $this->a = NULL;
    }

    public function testCreerAdresse() : void
    {
        $this->assertEmpty( $this->a->get_adresse() );
        $this->assertEmpty( $this->a->get_ville() );
        $this->assertEmpty( $this->a->get_code_postal() );
        $this->assertEmpty( $this->a->get_pays() );
    }

    public function testChangerAdresse() : void
    {
        $adr = "42 rue des caribous";
        $this->a->set_adresse( $adr );
        $this->assertEquals( $adr, $this->a->get_adresse() );
        $this->assertEmpty( $this->a->get_ville() );
        $this->assertEmpty( $this->a->get_code_postal() );
        $this->assertEmpty( $this->a->get_pays() );
    }

    public function testChangerVille() : void
    {
        $ville = "Gattaca";
        $this->a->set_ville( $ville );
        $this->assertEmpty( $this->a->get_adresse() );
        $this->assertEquals( $ville, $this->a->get_ville() );
        $this->assertEmpty( $this->a->get_code_postal() );
        $this->assertEmpty( $this->a->get_pays() );
    }

    public function testChangerCodePostal() : void
    {
        $code = "42000";
        $this->a->set_code_postal( $code );
        $this->assertEmpty( $this->a->get_adresse() );
        $this->assertEmpty( $this->a->get_ville() );
        $this->assertEquals( $code, $this->a->get_code_postal() );
        $this->assertEmpty( $this->a->get_pays() );
    }

    public function testChangerPays() : void
    {
        $pays = "Gallifrey";
        $this->a->set_pays( $pays );
        $this->assertEmpty( $this->a->get_adresse() );
        $this->assertEmpty( $this->a->get_ville() );
        $this->assertEmpty( $this->a->get_code_postal() );
        $this->assertEquals( $pays, $this->a->get_pays() );
    }

    public function testAffichageDeboguage() : void
    {
        $adr = "42 Allée des nains";
        $ville = "Gattaca";
        $code = "40200";
        $pays = "France";

        $attendu = "<p>Débogage Adresse</p>";
        $attendu .= "<ul>";
        $attendu .= "<li>adresse=$adr</li>";
        $attendu .= "<li>ville=$ville</li>";
        $attendu .= "<li>code_postal=$code</li>";
        $attendu .= "<li>pays=$pays</li>";
        $attendu .= "</ul>";

        $this->a->set_adresse( $adr );
        $this->a->set_ville( $ville );
        $this->a->set_code_postal( $code );
        $this->a->set_pays( $pays );

        $this->assertEquals( $attendu, $this->a->__toString() );
    }

}
