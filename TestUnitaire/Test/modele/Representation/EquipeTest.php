<?php
// Dernière modification : Vendredi 01 septembre[09] 2017

/**
 * Tests unitaires de la classe Equipe.
 *
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

include_once "/var/www/html/modele/Representation/Equipe.php";

use Modele\Representation\Equipe;
use Modele\Representation\Joueur;
use Modele\Representation\Tournoi;

use PHPUnit\Framework\TestCase;

class EquipeTest extends TestCase
{

    // Equipe
    protected $e;
    //Tournoi
    protected $t;
    protected $nb_places = 5;

    protected function setUp() : void
    {
        // On a besoin de connaitre le nombre de joueur max par équipes
        $this->t = new Tournoi();
        $this->t->set_nb_joueurs_par_equipe( $this->nb_places );

        $this->e = new Equipe();
    }

    protected function tearDown() : void
    {
        $this->e = NULL;
        $this->t = NULL;
    }

    public function testCreerEquipe() : void
    {
        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( 0, $this->e->get_nb_places_total() );
        $this->assertEquals( 0, $this->e->get_nb_places_reserve() );
        $this->assertEquals( 0, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( new Tournoi(), $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testChangerId() : void
    {
        $id = rand( 1, 100 );
        $this->e->set_id( $id );

        $this->assertEquals( $id, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( 0, $this->e->get_nb_places_total() );
        $this->assertEquals( 0, $this->e->get_nb_places_reserve() );
        $this->assertEquals( 0, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( new Tournoi(), $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testChangerCapitain() : void
    {
        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_prenom( "Ralf" );
        $j->set_nom( "Wigom" );

        $this->e->set_capitaine( $j );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( $j, $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( 0, $this->e->get_nb_places_total() );
        $this->assertEquals( 0, $this->e->get_nb_places_reserve() );
        $this->assertEquals( 0, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( new Tournoi(), $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testChangerCapitainInviteException()
    {
        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_prenom( "Ralf" );
        $j->set_nom( "Wigom" );

        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );
        $this->e->ajouter_joueur_place_reserve( $j );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur, $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array( $j ), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->set_capitaine( $j );
    }


    public function testChangerCapitainLibreException()
    {
        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_prenom( "Ralf" );
        $j->set_nom( "Wigom" );

        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );
        $this->e->ajouter_joueur_place_ouverte( $j );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur, $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array( $j ), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->set_capitaine( $j );
    }

    public function testChangerNom() : void
    {
        $nom = "Les Guépards";
        $this->e->set_nom( $nom );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEquals( $nom, $this->e->get_nom() );
        $this->assertEquals( 0, $this->e->get_nb_places_total() );
        $this->assertEquals( 0, $this->e->get_nb_places_reserve() );
        $this->assertEquals( 0, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( new Tournoi(), $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testChangerTournoi() : void
    {
        $this->e->set_tournoi( $this->t );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - 1, $this->e->get_nb_places_reserve() );
        $this->assertEquals( 0, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testChangerNbPlacesOuverte() : void
    {
        $nb_places = rand( 1, $this->t->get_nb_joueurs_par_equipe() - 1 );
        $this->e->set_tournoi( $this->t );
        $this->e->set_nb_places_ouverte( $nb_places );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testChangerNbPlacesOuverteException() : void
    {
        $nb = rand( 1, 100 );

        $this->expectException( \Exception::class );
        $this->e->set_nb_places_ouverte( $nb );
    }

    public function testAjouterJoueurInvite() : void
    {
        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_prenom( "Gros" );
        $j->set_nom( "Tas" );

        $this->e->set_tournoi( $this->t );
        $this->e->ajouter_joueur_place_reserve( $j );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - 1, $this->e->get_nb_places_reserve() );
        $this->assertEquals( 0, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array( $j ), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testJoueurInviteDejaAjouteException() : void
    {
        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_prenom( "Gros" );
        $j->set_nom( "Tas" );

        $this->e->set_tournoi( $this->t );
        $this->e->ajouter_joueur_place_reserve( $j );

        $this->expectException( \Exception::class );
        $this->e->ajouter_joueur_place_reserve( $j );
    }

    public function testJoueurInviteEstCapitainException() : void
    {
        $j1 = new Joueur();
        $j1->set_id( rand( 1, 100 ) );
        $j1->set_prenom( "Gros" );
        $j1->set_nom( "Tas" );

        $this->e->set_tournoi( $this->t );
        $this->e->set_capitaine( $j1 );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( $j1, $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - 1, $this->e->get_nb_places_reserve() );
        $this->assertEquals( 0, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->ajouter_joueur_place_reserve( $j1 );
    }

    public function testNombreMaxJoueursInviteException() : void
    {
        $j1 = new Joueur();
        $j1->set_id( rand( 1, 100 ) );
        $j1->set_prenom( "Gros" );
        $j1->set_nom( "Tas" );

        $j2 = new Joueur();
        $j2->set_id( rand( 1, 100 ) );
        $j2->set_prenom( "Petit" );
        $j2->set_nom( "Tas" );

        $j3 = new Joueur();
        $j3->set_id( rand( 1, 100 ) );
        $j3->set_prenom( "Petit" );
        $j3->set_nom( "Con" );

        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->e->ajouter_joueur_place_reserve( $j1 );
        $this->assertEquals( array( $j1 ), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );

        $this->e->ajouter_joueur_place_reserve( $j2 );
        $this->assertEquals( array( $j1, $j2 ), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( 3, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->ajouter_joueur_place_reserve( $j3 );
    }

    public function testAjouterJoueurNonReserve() : void
    {
        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_prenom( "Gros" );
        $j->set_nom( "Tas" );

        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );
        $this->e->ajouter_joueur_place_ouverte( $j );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array( $j ), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testJoueurNonReserveDejaAjouteException() : void
    {
        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_prenom( "Gros" );
        $j->set_nom( "Tas" );

        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->e->ajouter_joueur_place_ouverte( $j );

        $this->expectException( \Exception::class );
        $this->e->ajouter_joueur_place_ouverte( $j );
    }

    public function testJoueurNonReserveEstCapitainException() : void
    {
        $j1 = new Joueur();
        $j1->set_id( rand( 1, 100 ) );
        $j1->set_prenom( "Gros" );
        $j1->set_nom( "Tas" );

        $this->e->set_tournoi( $this->t );
        $this->e->set_capitaine( $j1 );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( $j1, $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - 1, $this->e->get_nb_places_reserve() );
        $this->assertEquals( 0, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->ajouter_joueur_place_ouverte( $j1 );
    }

    public function testNombreMaxJoueursNonReserveException() : void
    {
        $j1 = new Joueur();
        $j1->set_id( rand( 1, 100 ) );
        $j1->set_prenom( "Gros" );
        $j1->set_nom( "Tas" );

        $j2 = new Joueur();
        $j2->set_id( rand( 1, 100 ) );
        $j2->set_prenom( "Petit" );
        $j2->set_nom( "Tas" );

        $j3 = new Joueur();
        $j3->set_id( rand( 1, 100 ) );
        $j3->set_prenom( "Petit" );
        $j3->set_nom( "Con" );

        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->e->ajouter_joueur_place_ouverte( $j1 );
        $this->assertEquals( array( $j1 ), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );

        $this->e->ajouter_joueur_place_ouverte( $j2 );
        $this->assertEquals( array( $j1, $j2 ), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 3, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->ajouter_joueur_place_ouverte( $j3 );
    }

    public function testJoueurInvitePuisLibreException() : void
    {
        $j1 = new Joueur();
        $j1->set_id( rand( 1, 100 ) );
        $j1->set_prenom( "Gros" );
        $j1->set_nom( "Tas" );

        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->e->ajouter_joueur_place_reserve( $j1 );
        $this->assertEquals( array( $j1 ), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->ajouter_joueur_place_ouverte( $j1 );
    }

    public function testJoueurLibrePuisInviteException() : void
    {
        $j1 = new Joueur();
        $j1->set_id( rand( 1, 100 ) );
        $j1->set_prenom( "Gros" );
        $j1->set_nom( "Tas" );

        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( new Joueur(), $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->e->ajouter_joueur_place_ouverte( $j1 );
        $this->assertEquals( array( $j1 ), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->ajouter_joueur_place_reserve( $j1 );
    }

    public function testSupprimerJoueurInvite()
    {
        $c = new Joueur();
        $c->set_id( rand( 1, 100 ) );
        $c->set_prenom( "Ralf" );
        $c->set_nom( "Wigom" );

        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_prenom( "Petit" );
        $j->set_nom( "Tas" );

        $this->e->set_capitaine( $c );
        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( $c, $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->e->ajouter_joueur_place_reserve( $j );
        $this->assertEquals( array( $j ), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );

        $this->e->supprimer_joueur( $j );
        $this->assertEquals( $c, $this->e->get_capitaine() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testSupprimerJoueurLibre()
    {
        $c = new Joueur();
        $c->set_id( rand( 1, 100 ) );
        $c->set_prenom( "Ralf" );
        $c->set_nom( "Wigom" );

        $j = new Joueur();
        $j->set_id( rand( 1, 100 ) );
        $j->set_prenom( "Petit" );
        $j->set_nom( "Tas" );

        $this->e->set_capitaine( $c );
        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( $c, $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->e->ajouter_joueur_place_ouverte( $j );
        $this->assertEquals( array( $j ), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 2, $this->e->get_nb_joueurs_inscrit() );

        $this->e->supprimer_joueur( $j );
        $this->assertEquals( $c, $this->e->get_capitaine() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );
    }

    public function testSupprimerCapitaineException()
    {
        $c = new Joueur();
        $c->set_id( rand( 1, 100 ) );
        $c->set_prenom( "Ralf" );
        $c->set_nom( "Wigom" );

        $this->e->set_capitaine( $c );
        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( $c, $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->supprimer_joueur( $c );
    }

    public function testSupprimerJoueurNonInscrit()
    {
        $c = new Joueur();
        $c->set_id( rand( 1, 100 ) );
        $c->set_prenom( "Ralf" );
        $c->set_nom( "Wigom" );

        $j = new Joueur();

        $this->e->set_capitaine( $c );
        $this->e->set_tournoi( $this->t );
        $nb_places = 2;
        $this->e->set_nb_places_ouverte( $nb_places );

        $this->assertEquals( 0, $this->e->get_id() );
        $this->assertEquals( $c, $this->e->get_capitaine() );
        $this->assertEmpty( $this->e->get_nom() );
        $this->assertEquals( $this->nb_places, $this->e->get_nb_places_total() );
        $this->assertEquals( $this->nb_places - ( $nb_places + 1 ), $this->e->get_nb_places_reserve() );
        $this->assertEquals( $nb_places, $this->e->get_nb_places_ouverte() );
        $this->assertEquals( $this->t, $this->e->get_tournoi() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_reserve() );
        $this->assertEquals( array(), $this->e->get_liste_joueurs_places_ouverte() );
        $this->assertEquals( 1, $this->e->get_nb_joueurs_inscrit() );

        $this->expectException( \Exception::class );
        $this->e->supprimer_joueur( $j );
    }

    public function testAffichageDeboguage()
    {
        $c = new Joueur();
        $c->set_id( rand( 1, 100 ) );
        $c->set_prenom( "Ralf" );
        $c->set_nom( "Wigom" );

        $j2 = new Joueur();
        $j2->set_id( rand( 1, 100 ) );
        $j2->set_prenom( "Petit" );
        $j2->set_nom( "Tas" );

        $j3 = new Joueur();
        $j3->set_id( rand( 1, 100 ) );
        $j3->set_prenom( "Petit" );
        $j3->set_nom( "Con" );

        $id = rand( 1, 100 );
        $nom = "Les Guépards";
        $nb_places_ouverte = 1;

        $this->t->set_id( rand( 1, 100 ) );
        $this->t->set_nom( "Counter Strike" );
        $this->t->set_nb_joueurs( rand( 200, 400 ) );
        $this->t->set_nb_joueurs_par_equipe( 3 );

        $this->e->set_id( $id );
        $this->e->set_nom( $nom );
        $this->e->set_capitaine( $c );
        $this->e->set_tournoi( $this->t );
        $this->e->set_nb_places_ouverte( $nb_places_ouverte );
        $this->e->ajouter_joueur_place_reserve( $j2 );
        $this->e->ajouter_joueur_place_ouverte( $j3 );

        $attendu = "<p>Débogage de Equipe</p>";
        $attendu .= "<ul>";
        $attendu .= "<li>id                     = $id</li>";
        $attendu .= "<li>nom                    = $nom</li>";
        $attendu .= "<li>nombres places ouverte = $nb_places_ouverte</li>";
        $attendu .= "<li><h5>Capitaine</h5></li>";
        $attendu .= "<li>$c</li>";
        $attendu .= "<li><h5>Tournoi</h5></li>";
        $attendu .= "<li>$this->t</li>";
        $attendu .= "<li></li>";
        $attendu .= "</ul>";

        $this->assertEquals( $attendu, $this->e->__toString() );
    }

}
