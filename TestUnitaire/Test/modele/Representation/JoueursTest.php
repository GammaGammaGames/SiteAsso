<?php
// Dernière modification : Jeudi 24 août[08] 2017

declare( strict_types = 1 );

include_once "/src/modele/Representation/Joueur.php";

use Modele\Representation\Adresse;
use Modele\Representation\Joueur;

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
        $this->assertEquals( new Adresse(), $this->j->get_adresse() );
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
        $this->assertEquals( new Adresse(), $this->j->get_adresse() );
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
        $this->assertEquals( new Adresse(), $this->j->get_adresse() );
    }

    public function testChangerNumeroTelephone() : void
    {
        $attendu = "+33611223344";
        $this->j->set_tel( $attendu );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEquals( $attendu, $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEquals( new Adresse(), $this->j->get_adresse() );
    }

    public function testChangerNom() : void
    {
        $attendu = "Omniscient (the)";
        $this->j->set_nom( $attendu );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEquals( $attendu, $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEquals( new Adresse(), $this->j->get_adresse() );
    }

    public function testChangerPrenom() : void
    {
        $attendu = "Ziltoid";
        $this->j->set_prenom( $attendu );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEquals( $attendu, $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEquals( new Adresse(), $this->j->get_adresse() );
    }

    public function testChangerDateAnnivairsaire() : void
    {
        $attendu = "1990/05/22";
        $this->j->set_anniv( $attendu );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEquals( $attendu, $this->j->get_anniv() );
        $this->assertEquals( new Adresse(), $this->j->get_adresse() );
    }

    public function testChangerAdresse() : void
    {
        $attendu = new Adresse();
        $attendu->set_adresse( "42 rue des caribous" );
        $attendu->set_ville( "Gattaca" );
        $attendu->set_code_postal( "42000" );
        $attendu->set_ville( "Gallifrey" );

        $this->j->set_adresse( $attendu );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEquals( $attendu, $this->j->get_adresse() );
    }

    public function testAffichageDeboguage() : void
    {
        $id = rand( 1, 100 );
        $email = "gerald@mail.ml";
        $tel = "+33677009988";
        $nom = "Half";
        $prenom = "Life";
        $anniv = "1888/01/31";
        $adr = "42 Allée des nains";
        $ville = "Gattaca";
        $code = "40200";
        $pays = "France";

        $adresse = new Adresse();
        $adresse->set_adresse( $adr );
        $adresse->set_ville( $ville );
        $adresse->set_code_postal( $code );
        $adresse->set_pays( $pays );

        $attendu = "<p>Débogage de Joueur</p>";
        $attendu .= "<ul>";
        $attendu .= "<li>id          = $id</li>";
        $attendu .= "<li>email       = $email</li>";
        $attendu .= "<li>tel         = $tel</li>";
        $attendu .= "<li>nom         = $nom</li>";
        $attendu .= "<li>prenom      = $prenom</li>";
        $attendu .= "<li>anniv       = $anniv</li>";
        $attendu .= "<li>$adresse</li>";
        $attendu .= "</ul>";

        $this->j->set_id( $id );
        $this->j->set_email( $email );
        $this->j->set_tel( $tel );
        $this->j->set_nom( $nom );
        $this->j->set_prenom( $prenom );
        $this->j->set_anniv( $anniv );
        $this->j->set_adresse( $adresse );

        $this->assertEquals( $attendu, $this->j->__toString() );
    }
}
