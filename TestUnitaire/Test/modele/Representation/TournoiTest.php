<?php
// Dernière modification : Samedi 26 août[08] 2017

declare( strict_types = 1 );

include_once "/var/www/html/modele/Representation/Tournoi.php";

use Modele\Representation\Evenement;
use Modele\Representation\Adresse;
use Modele\Representation\Tournoi;

use PHPUnit\Framework\TestCase;

/**
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */
class TournoiTest extends TestCase
{

    protected $t;

    protected function setUp() : void
    {
        $this->t = new Tournoi();
    }

    protected function tearDown() : void
    {
        $this->t = NULL;
    }

    public function testCreerTournoi() : void
    {
        $this->assertEquals( 0, $this->t->get_id() );
        $this->assertEmpty( $this->t->get_nom() );
        $this->assertEmpty( $this->t->get_debut() );
        $this->assertEmpty( $this->t->get_nb_joueurs() );
        $this->assertEmpty( $this->t->get_nb_joueurs_par_equipe() );
        $this->assertEquals( new Evenement(), $this->t->get_evenement() );
    }

    public function testChangerId() : void
    {
        $attendu = rand( 1, 100 );
        $this->t->set_id( $attendu );

        $this->assertEquals( $attendu, $this->t->get_id() );
        $this->assertEmpty( $this->t->get_nom() );
        $this->assertEmpty( $this->t->get_debut() );
        $this->assertEmpty( $this->t->get_nb_joueurs() );
        $this->assertEmpty( $this->t->get_nb_joueurs_par_equipe() );
        $this->assertEquals( new Evenement(), $this->t->get_evenement() );
    }

    public function testChangerNom() : void
    {
        $attendu = "Counter Strike";
        $this->t->set_nom( $attendu );

        $this->assertEquals( 0, $this->t->get_id() );
        $this->assertEquals( $attendu, $this->t->get_nom() );
        $this->assertEmpty( $this->t->get_debut() );
        $this->assertEmpty( $this->t->get_nb_joueurs() );
        $this->assertEmpty( $this->t->get_nb_joueurs_par_equipe() );
        $this->assertEquals( new Evenement(), $this->t->get_evenement() );
    }

    public function testChangerDateDebut() : void
    {

        $attendu = "2018/12/25-12:00";
        $this->t->set_debut( $attendu );

        $this->assertEquals( 0, $this->t->get_id() );
        $this->assertEmpty( $this->t->get_nom() );
        $this->assertEquals( $attendu, $this->t->get_debut() );
        $this->assertEmpty( $this->t->get_nb_joueurs() );
        $this->assertEmpty( $this->t->get_nb_joueurs_par_equipe() );
        $this->assertEquals( new Evenement(), $this->t->get_evenement() );

    }

    public function testChangerNombreJoueursMax() : void
    {

        $attendu = 200;
        $this->t->set_nb_joueurs( $attendu );

        $this->assertEquals( 0, $this->t->get_id() );
        $this->assertEmpty( $this->t->get_nom() );
        $this->assertEmpty( $this->t->get_debut() );
        $this->assertEquals( $attendu, $this->t->get_nb_joueurs() );
        $this->assertEmpty( $this->t->get_nb_joueurs_par_equipe() );
        $this->assertEquals( new Evenement(), $this->t->get_evenement() );

    }

    public function testChangerNombreJoueursParEquipe() : void
    {

        $attendu = 5;
        $this->t->set_nb_joueurs_par_equipe( $attendu );

        $this->assertEquals( 0, $this->t->get_id() );
        $this->assertEmpty( $this->t->get_nom() );
        $this->assertEmpty( $this->t->get_debut() );
        $this->assertEmpty( $this->t->get_nb_joueurs() );
        $this->assertEquals( $attendu, $this->t->get_nb_joueurs_par_equipe() );
        $this->assertEquals( new Evenement(), $this->t->get_evenement() );

    }

    public function testChangerEvenement() : void
    {

        $attendu = new Evenement();

        $attendu->set_id( rand( 1, 100 ) );
        $attendu->set_nom( "Lan partie" );
        $attendu->set_date_debut( "2000/02/12" );
        $attendu->set_date_fin( "2000/02/14" );

        $this->t->set_evenement( $attendu );

        $this->assertEquals( 0, $this->t->get_id() );
        $this->assertEmpty( $this->t->get_nom() );
        $this->assertEmpty( $this->t->get_debut() );
        $this->assertEmpty( $this->t->get_nb_joueurs() );
        $this->assertEmpty( $this->t->get_nb_joueurs_par_equipe() );
        $this->assertEquals( $attendu, $this->t->get_evenement() );

    }

    public function testAffichageDeboguage()
    {
        $adr = new Adresse();
        $adr->set_adresse( "42 Allée des nains" );
        $adr->set_ville( "Gattaca" );
        $adr->set_code_postal( "40200" );
        $adr->set_pays( "France" );

        $evenement = new Evenement();
        $evenement->set_id( rand( 1, 100 ) );
        $evenement->set_nom( "Lan partie" );
        $evenement->set_date_debut( "2000/02/12" );
        $evenement->set_date_fin( "2000/02/14" );
        $evenement->set_adresse( $adr );

        $id = rand( 1, 100 );
        $nom = "Counter Strike";
        $debut = "2018/12/25-12:00";
        $nb_j = rand( 200, 400 );
        $nb_j_equipe = rand( 2, 10 );
        $this->t->set_id( $id );
        $this->t->set_nom( $nom );
        $this->t->set_debut( $debut );
        $this->t->set_nb_joueurs( $nb_j );
        $this->t->set_nb_joueurs_par_equipe( $nb_j_equipe );
        $this->t->set_evenement( $evenement );

        $attendu = "<p>Débogage du Tournoi</p>";
        $attendu .= "<ul>";
        $attendu .= "<li>id                    = $id</li>";
        $attendu .= "<li>nom                   = $nom</li>";
        $attendu .= "<li>debut                 = $debut</li>";
        $attendu .= "<li>nb joueurs max        = $nb_j</li>";
        $attendu .= "<li>nb joueurs par équipe = $nb_j_equipe</li>";
        $attendu .= "<li>$evenement</li>";
        $attendu .= "</ul>";

        $this->assertEquals( $attendu, $this->t->__toString() );
    }

}
