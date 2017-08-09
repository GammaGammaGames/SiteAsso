<?php
// Dernière modification : Mercredi 09 août[08] 2017

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
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
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
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
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
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
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
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
    }

    public function testChangerAdresse() : void
    {
        $attendu = "42 rue des caribous";
        $this->j->set_adresse( $attendu );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEquals( $attendu, $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
    }

    public function testChangerVille() : void
    {
        $attendu = "Gattaca";
        $this->j->set_ville( $attendu );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEquals( $attendu, $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
    }

    public function testChangerCodePostal() : void
    {
        $attendu = "42000";
        $this->j->set_code_postal( $attendu );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEquals( $attendu, $this->j->get_code_postal() );
        $this->assertEmpty( $this->j->get_pays() );
    }

    public function testChangerPays() : void
    {
        $attendu = "Gallifrey";
        $this->j->set_pays( $attendu );
        $this->assertEquals( 0, $this->j->get_id() );
        $this->assertEmpty( $this->j->get_email() );
        $this->assertEmpty( $this->j->get_tel() );
        $this->assertEmpty( $this->j->get_nom() );
        $this->assertEmpty( $this->j->get_prenom() );
        $this->assertEmpty( $this->j->get_anniv() );
        $this->assertEmpty( $this->j->get_adresse() );
        $this->assertEmpty( $this->j->get_ville() );
        $this->assertEmpty( $this->j->get_code_postal() );
        $this->assertEquals( $attendu, $this->j->get_pays() );
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

        $attendu = "<p>Débogage de Joueur</p>";
        $attendu .= "<ul>";
        $attendu .= "<li>id=$id</li>";
        $attendu .= "<li>email=$email</li>";
        $attendu .= "<li>tel=$tel</li>";
        $attendu .= "<li>nom=$nom</li>";
        $attendu .= "<li>prenom=$prenom</li>";
        $attendu .= "<li>anniv=$anniv</li>";
        $attendu .= "<li>adresse=$adr</li>";
        $attendu .= "<li>ville=$ville</li>";
        $attendu .= "<li>code_postal=$code</li>";
        $attendu .= "<li>pays=$pays</li>";
        $attendu .= "</ul>";

        $this->j->set_id( $id );
        $this->j->set_email( $email );
        $this->j->set_tel( $tel );
        $this->j->set_nom( $nom );
        $this->j->set_prenom( $prenom );
        $this->j->set_anniv( $anniv );
        $this->j->set_adresse( $adr );
        $this->j->set_ville( $ville );
        $this->j->set_code_postal( $code );
        $this->j->set_pays( $pays );

        $this->assertEquals( $attendu, $this->j->__toString() );
    }
}
