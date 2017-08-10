<?php
// Dernière modification : Jeudi 10 août[08] 2017

declare( strict_types = 1 );

include_once "/src/modele/Representation/Adresse.php";

use PHPUnit\Framework\TestCase;

/**
 * Petite explication du fichier @TODO
 * @author PIVARD Julien
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
        $adr = "coucou";
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

}
