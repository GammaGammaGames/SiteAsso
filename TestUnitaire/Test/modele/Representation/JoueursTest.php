<?php
// Dernière modification : Mardi 08 août[08] 2017

declare( strict_types = 1 );

include_once "/src/modele/Representation/Joueur.php";

use PHPUnit\Framework\TestCase;

/**
 * @author PIVARD Julien
 * */
class JoueursTest extends TestCase
{

    protected $j;

    protected function setUp() : void
    {
        $this->j = new Joueur();
    }

    protected function tearDown() : void
    {
        $this->j = NULL;
    }

    public function testCreerJoueur() : void
    {
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
    }

    public function testChangerId() : void
    {
        $id = rand( 1, 100 );
        $this->j->set_id( $id );
        $this->assertEquals( $id, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
    }

    public function testChangerAdresseEmail() : void
    {
        $mail = "coucou@test.fr";
        $this->j->set_email( $mail );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEquals( $mail, $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
    }

}
