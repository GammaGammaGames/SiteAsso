<?php
// Dernière modification : Vendredi 25 août[08] 2017

/**
 * Contient la représentation d'une équipe.
 *
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

namespace Modele\Representation;

include_once "/src/modele/Representation/RepresentationAvecId.php";
include_once "/src/modele/Representation/Joueur.php";
include_once "/src/modele/Representation/Tournoi.php";

/**
 * Représente une équipe avec son capitaine et ses joueurs.
 *
 * @category Modèle
 * @package Représentation
 * */
class Equipe extends RepresentationAvecId
{

    /**
     * @var Joueur
     * Le capitaine de l'équipe
     * */
    protected $capitaine;

    /**
     * @var string
     * Le nom de l'équipe.
     * */
    protected $nom = "";

    /**
     * @var int
     * Le nombre de places non réservé dans l'équipe.
     * */
    protected $nb_places_non_reserve = 0;

    /**
     * @var Tournoi
     * Le tournoi dans lequel est inscrite l'équipe.
     * */
    protected $tournoi;

    /**
     * @var array[Joueur]
     * Les joueurs membres de l'équipe et invité par le capitaine.
     * */
    protected $liste_joueurs_invite;

    /**
     * @var array[Joueur]
     * Les joueurs membre de l'équipe et qui ont été intégré
     * par petite annonce.
     * */
    protected $liste_joueurs_petites_annonces;

    /**
     * Construit une équipe vide.
     * */
    public function __construct()
    {
        $this->capitaine = new Joueur();
        $this->tournoi = new Tournoi();
        $this->liste_joueurs_invite = array();
        $this->liste_joueurs_petites_annonces = array();
    }

    // =============================== //
    //          Les Guetteurs          //
    // =============================== //

    /**
     * Récupère le capitaine de l'équipe.
     *
     * @return Joueur
     * Le capitaine de l'équipe.
     * */
    public function get_capitaine() : Joueur
    {
        return $this->capitaine;
    }

    /**
     * Récupère le nom de l'équipe.
     *
     * @return string
     * Le nom de l'équipe.
     * */
    public function get_nom() : string
    {
        return $this->nom;
    }

    /**
     * Permet de récupérer le nombre de places non réservé de l'équipe.
     *
     * @return int
     * Le nombre de places non réservé de l'équipe.
     */
    public function get_nb_places_non_reserve() : int
    {
        return $this->nb_places_non_reserve;
    }

    /**
     * Permet de récupérer le tournoi de l'équipe.
     *
     * @return Tournoi
     * Le tournoi auquel participe l'équipe.
     */
    public function get_tournoi() : Tournoi
    {
        return $this->tournoi;
    }

    /**
     * Permet de récupérer la liste des joueurs invité dans l'équipe.
     *
     * @return array
     * La liste des joueurs invité.
     */
    public function get_liste_joueurs_invite() : array
    {
        return $this->liste_joueurs_invite;
    }

    /**
     * Permet de récupérer la liste des joueurs libre de l'équipe.
     *
     * @return array
     * La liste des joueurs qui ont été ajouté à l'équipe en passant
     * par les petites annonces.
     */
    public function get_liste_joueurs_libre() : array
    {
        return $this->liste_joueurs_petites_annonces;
    }

    /**
     * Permet de récupérer le nombre de joueurs déjà inscrit dans l'équipe.
     *
     * @return int
     * Le nombre de joueurs inscrit dans l'équipe.
     * */
    public function get_nb_joueurs_inscrit() : int
    {
        // On compte le capitaine
        return 1 + sizeof( $this->liste_joueurs_invite ) + sizeof( $this->liste_joueurs_petites_annonces );
    }

    // =============================== //
    //           Les Setteurs          //
    // =============================== //

    /**
     * Permet de changer le capitaine de l'équipe.
     *
     * @param Joueur $captain
     * Le nouveau capitaine de l'équipe.
     * */
    public function set_capitaine( Joueur $captain ) : void
    {
        $this->capitaine = $captain;
    }

    /**
     * Permet de changer le nom de l'équipe.
     *
     * @param string $nom
     * Le nouveau nom de l'équipe.
     * */
    public function set_nom( string $nom ) : void
    {
        $this->nom = $nom;
    }

    /**
     * Permet de changer le nombre de places non réservé de l'équipe.
     *
     * @param int $nb_places_non_reserve
     * Le nombre de places non réservé de l'équipe.
     */
    public function set_nb_places_non_reserve( int $nb_places_non_reserve ) : void
    {
        // Le captain ne peut pas faire parti des places libres
        if ( $nb_places_non_reserve > $tournoi->get_nb_joueurs_par_equipe - 1 )
        {
            throw new Exception( "Le nombre de places libre excède le nombre de places dans l'équipe." );
        }
        $this->nb_places_non_reserve = $nb_places_non_reserve;
    }

    /**
     * Permet de changer le tournoi de l'équipe.
     *
     * @param Tournoi $tournoi
     * Le tournoi auquel participe l'équipe.
     */
    public function set_tournoi( Tournoi $tournoi ) : void
    {
        $this->tournoi = $tournoi;
    }

    /**
     * Ajoute un joueur à l'équipe. Ce joueur est invité par le capitaine.
     *
     * @param Joueur $joueur
     * Le joueur invité par le capitaine à ajouter à l'équipe.
     * */
    public function ajouter_joueur_invite( Joueur $joueur ) : void
    {
        if ( $this->peut_ajouter_joueur( $joueur ) === false )
        {
            throw new \Exception( "Le joueur est déjà présent dans l'équipe." );
        }
        // Le capitaine ne fait pas partit des joueurs
        $nb_j_invte_imax = $tournoi->get_nb_joueurs_par_equipe - ( 1 + $this->nb_places_non_reserve );
        if ( sizeof( $this->liste_joueurs_invite ) < $nb_j_invte_imax )
        {
            $this->liste_joueurs_invite[] = $joueur;
        }
        else
        {
            throw new \Exception( "Nombre max de joueurs invité atteint" );
        }
    }

    /**
     * Ajoute un joueur à l'équipe. Ce joueur a été recruté par petites annonces.
     *
     * @param Joueur $joueur
     * Le joueur recruté.
     * */
    public function ajouter_joueur_non_reserve( Joueur $joueur ) : void
    {
        if ( verifier_peut_ajouter_joueur( $joueur ) === false )
        {
            throw new \Exception( "Le joueur est déjà présent dans l'équipe." );
        }
        $nb_j_max = $this->nb_places_non_reserve;
        if ( sizeof( $this->liste_joueurs_petites_annonces ) < $nb_j_max )
        {
            $this->liste_joueurs_petites_annonces[] = $joueur;
        }
        else
        {
            throw new \Exception( "Nombre max de places de joueurs non réservé atteint" );
        }
    }

    /**
     * Supprime un joueur de l'équipe.
     *
     * @param Joueur $joueur
     * Le joueur à supprimer.
     * */
    public function supprimer_joueur( Joueur $joueur ) : void
    {
        $present_i = in_array( $joueur, $this->liste_joueurs_invite );
        $present_l = in_array( $joueur, $this->liste_joueurs_petites_annonces );
        if ( $present_i === true )
        {
            supprimer_joueur_invite( $joueur );
        }
        elseif ( $present_l === true )
        {
            supprimer_joueur_non_reserve( $joueur );
        }
        else
        {
            throw new \Exception( "Suppression impossible : Le joueur ne fait pas parti de l'équipe." );
        }
    }

    /**
     * L'affichage pour le debogage.
     *
     * @return string
     * Toutes les données mise en forme.
     * */
    public function __toString() : string
    {

        $debogage = "<p>Débogage de Equipe</p>";

        $debogage .= "<ul>";
        $debogage .= "<li></li>";
        $debogage .= "</ul>";

        return $debogage;

    }

    // Partie protégé ==========================================================

    /**
     * Supprime un joueur de l'équipe. Ce joueur doit avoir été invité.
     *
     * @param Joueur $joueur
     * Le joueur à supprimer.
     * */
    protected function supprimer_joueur_invite( Joueur $joueur ) : void
    {
        $position = array_search( $joueur, $this->liste_joueurs_invite );
        if ( $position === false )
        {
            throw new \Exception( "Suppression impossible : Le joueur n'a pas de place réservé." );
        }
        else
        {
            unset( $this->liste_joueurs_invite[$position] );
        }
    }

    /**
     * Supprime un joueur de l'équipe. Ce joueur doit avoir été recruté
     * par petites annonces
     *
     * @param Joueur $joueur
     * Le joueur à supprimer.
     * */
    protected function supprimer_joueur_non_reserve( Joueur $joueur ) : void
    {
        $position = array_search( $joueur, $this->liste_joueurs_petites_annonces );
        if ( $position === false )
        {
            throw new \Exception( "Suppression impossible : Le joueur n'a pas été recruté." );
        }
        else
        {
            unset( $this->liste_joueurs_petites_annonces[$position] );
        }
    }

    /**
     * Vérifie si le joueur peut être ajouté ou non.
     *
     * Pour pouvoir être ajouté, il faut que le joueur ne soit :
     * <ul>
     * <li>ni le capitain</li>
     * <li>ni dans le groupe réservé</li>
     * <li>ni dans le groupe laissé libre</li>
     * </ul>
     *
     * @param  Joueur $joueur
     * Le joueur dont on veut vérifier la présence.
     * @return boolean
     * Le joueur ne fait pas parti de l'équipe.
     * */
    protected function peut_ajouter_joueur( Joueur $joueur ) : bool
    {
        $present = in_array( $joueur, $this->liste_joueurs_petites_annonces ) or in_array( $joueur, $this->liste_joueurs_petites_annonces );
        return $joueur === $this->capitaine and ! $present;
    }

}
