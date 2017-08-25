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
     * Le nombre de places laissé ouverte par le capitaine de l'équipe.
     * N'importe quel joueur peut postuler à une place ouverte.
     * Le reste des places est par défaut reservé.
     * */
    protected $nb_places_ouverte = 0;

    /**
     * @var Tournoi
     * Le tournoi dans lequel est inscrite l'équipe.
     * */
    protected $tournoi;

    /**
     * @var array[Joueur]
     * Les joueurs membres de l'équipe et invité par le capitaine.
     * */
    protected $liste_joueurs_places_reserve;

    /**
     * @var array[Joueur]
     * Les joueurs membre de l'équipe et qui ont été intégré
     * par petite annonce.
     * */
    protected $liste_joueurs_places_ouverte;

    /**
     * Construit une équipe vide.
     * */
    public function __construct()
    {
        $this->capitaine = new Joueur();
        $this->tournoi = new Tournoi();
        $this->liste_joueurs_places_reserve = array();
        $this->liste_joueurs_places_ouverte = array();
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
     * Permet de connaitre le nombre de places total
     *
     * @return int
     * Le nombre de places dans l'équipe.
     * */
    public function get_nb_places_total() : int
    {
        return $this->tournoi->get_nb_joueurs_par_equipe();
    }

    /**
     * Permet de connaitre le nombre de places réservé par le capitaine
     * de l'équipe.
     *
     * @return int
     * Le nombre de places réservé.
     * */
    public function get_nb_places_reserve() : int
    {
        if ( $this->tournoi->get_nb_joueurs_par_equipe() <= 0 )
        {
            return 0;
        }
        return $this->tournoi->get_nb_joueurs_par_equipe() -
            ( 1 + $this->nb_places_ouverte );
    }

    /**
     * Permet de récupérer le nombre de places ouverte par le capitaine
     * de l'équipe.
     *
     * @return int
     * Le nombre de places ouverte de l'équipe.
     */
    public function get_nb_places_ouverte() : int
    {
        return $this->nb_places_ouverte;
    }

    /**
     * Permet de récupérer le tournoi auquel participe l'équipe.
     *
     * @return Tournoi
     * Le tournoi auquel participe l'équipe.
     */
    public function get_tournoi() : Tournoi
    {
        return $this->tournoi;
    }

    /**
     * Permet de récupérer la liste des joueurs dont la places a été
     * réservé par le capitaine dans l'équipe.
     *
     * @return array
     * La liste des joueurs avec places réservé.
     */
    public function get_liste_joueurs_places_reserve() : array
    {
        return $this->liste_joueurs_places_reserve;
    }

    /**
     * Permet de récupérer la liste des joueurs recruté dans des places
     * laissé ouverte par le capitaine de l'équipe.
     *
     * @return array
     * La liste des joueurs qui ont été ajouté à l'équipe en passant
     * par les petites annonces.
     */
    public function get_liste_joueurs_places_ouverte() : array
    {
        return $this->liste_joueurs_places_ouverte;
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
        return 1 + sizeof( $this->liste_joueurs_places_reserve ) +
            sizeof( $this->liste_joueurs_places_ouverte );
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
        if ( ! $this->peut_ajouter_joueur( $captain ) )
        {
            throw new \Exception( "Le capitaine ne doit pas être présent dans la liste des joueurs." );
        }
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
     * Permet de changer le nombre de places ouverte par le capitaine
     * de l'équipe.
     *
     * @param int $nb_places_ouverte
     * Le nombre de places ouverte de l'équipe.
     */
    public function set_nb_places_ouverte( int $nb_places_ouverte ) : void
    {
        // Le capitaine ne peut pas faire parti des places libres
        if ( $nb_places_ouverte > $this->tournoi->get_nb_joueurs_par_equipe() - 1 )
        {
            throw new \Exception( "Le nombre de places ouverte excède le nombre de places dans l'équipe." );
        }
        $this->nb_places_ouverte = $nb_places_ouverte;
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
     * Le joueur invité par le capitaine.
     * */
    public function ajouter_joueur_place_reserve( Joueur $joueur ) : void
    {
        if ( $this->peut_ajouter_joueur( $joueur ) === false )
        {
            throw new \Exception( "Le joueur est déjà présent dans l'équipe." );
        }
        // Le capitaine ne fait pas partit des joueurs
        $nb_j_invte_imax = $this->tournoi->get_nb_joueurs_par_equipe() -
            ( 1 + $this->nb_places_ouverte );
        if ( sizeof( $this->liste_joueurs_places_reserve ) < $nb_j_invte_imax )
        {
            $this->liste_joueurs_places_reserve[] = $joueur;
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
    public function ajouter_joueur_place_ouverte( Joueur $joueur ) : void
    {
        if ( $this->peut_ajouter_joueur( $joueur ) === false )
        {
            throw new \Exception( "Le joueur est déjà présent dans l'équipe." );
        }
        $nb_j_max = $this->nb_places_ouverte;
        if ( sizeof( $this->liste_joueurs_places_ouverte ) < $nb_j_max )
        {
            $this->liste_joueurs_places_ouverte[] = $joueur;
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
        if ( $joueur === $this->capitaine )
        {
            throw new \Exception( "Le capitaine ne peut pas être supprimé." );
        }
        $present_i = in_array( $joueur, $this->liste_joueurs_places_reserve );
        $present_l = in_array( $joueur, $this->liste_joueurs_places_ouverte );
        if ( $present_i === true )
        {
            $this->supprimer_joueur_places_reserve( $joueur );
        }
        elseif ( $present_l === true )
        {
            $this->supprimer_joueur_place_ouverte( $joueur );
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
        $debogage .= "<li>id                     = $this->id</li>";
        $debogage .= "<li>nom                    = $this->nom</li>";
        $debogage .= "<li>nombres places ouverte = $this->nb_places_ouverte</li>";
        $debogage .= "<li><h5>Capitaine</h5></li>";
        $debogage .= "<li>$this->capitaine</li>";
        $debogage .= "<li><h5>Tournoi</h5></li>";
        $debogage .= "<li>$this->tournoi</li>";
        $debogage .= "<li></li>";
        $debogage .= "</ul>";

        return $debogage;

    }

    // Partie protégé =========================================================

    /**
     * Supprime un joueur de l'équipe. Ce joueur doit avoir une place réservé.
     *
     * @param Joueur $joueur
     * Le joueur à supprimer.
     * */
    protected function supprimer_joueur_places_reserve( Joueur $joueur ) : void
    {
        $position = array_search( $joueur, $this->liste_joueurs_places_reserve );
        if ( $position === false )
        {
            throw new \Exception( "Suppression impossible : Le joueur n'a pas de place réservé." );
        }
        else
        {
            unset( $this->liste_joueurs_places_reserve[$position] );
        }
    }

    /**
     * Supprime un joueur de l'équipe. Ce joueur doit avoir une place ouverte.
     *
     * @param Joueur $joueur
     * Le joueur à supprimer.
     * */
    protected function supprimer_joueur_place_ouverte( Joueur $joueur ) : void
    {
        $position = array_search( $joueur, $this->liste_joueurs_places_ouverte );
        if ( $position === false )
        {
            throw new \Exception( "Suppression impossible : Le joueur n'a pas été recruté." );
        }
        else
        {
            unset( $this->liste_joueurs_places_ouverte[$position] );
        }
    }

    /**
     * Vérifie si le joueur peut être ajouté ou non.
     *
     * Pour pouvoir être ajouté, il faut que le joueur ne soit :
     * <ul>
     * <li>ni le capitaine</li>
     * <li>ni dans le groupe de places réservé</li>
     * <li>ni dans le groupe de places ouverte</li>
     * </ul>
     *
     * @param  Joueur $joueur
     * Le joueur dont on veut vérifier la présence.
     * @return bool
     * Le joueur ne fait pas parti de l'équipe.
     * */
    protected function peut_ajouter_joueur( Joueur $joueur ) : bool
    {
        $present = in_array( $joueur, $this->liste_joueurs_places_reserve ) ||
            in_array( $joueur, $this->liste_joueurs_places_ouverte );
        return $joueur !== $this->capitaine && ! $present;
    }

}
