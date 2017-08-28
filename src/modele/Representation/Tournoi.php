<?php
// Dernière modification : Lundi 28 août[08] 2017

/**
 * Contient la représentation d'un tournoi.
 *
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

namespace Modele\Representation;

include_once "/var/www/html/modele/Representation/RepresentationAvecId.php";
include_once "/var/www/html/modele/Representation/Evenement.php";

/**
 * Représente un tournoi avec ses équipes.
 *
 * @category Modèle
 * @package Représentation
 * */
class Tournoi extends RepresentationAvecId
{

    /**
     * @var Evenement
     * L'évènement auquel est lié le tournoi.
     * */
    protected $evenement;

    /**
     * @var string
     * Le nom du tournoi.
     * */
    protected $nom = "";

    /**
     * @var \DateTime
     * La date et heure de début.
     * */
    protected $debut = "";

    /**
     * @var int
     * Le nombre de joueurs total
     * */
    protected $nb_joueurs = 0;

    /**
     * @var int
     * Le nombre de joueurs par équipe.
     * */
    protected $nb_joueurs_par_equipe = 0;

    /**
     * Crée un tournoi vide.
     * */
    public function __construct()
    {
        $this->evenement = new Evenement();
        $this->debut = new \DateTime( "1970-01-01" );
    }

    // =============================== //
    //          Les Guetteurs          //
    // =============================== //

    /**
     * Permet de récupérer l'Evenement durant lequel se déroule le Tournoi
     *
     * @return Evenement
     * L'Evenement durant lequel se déroule le tournoi.
     */
    public function get_evenement() : Evenement
    {
        return $this->evenement;
    }

    /**
     * Permet de récupérer le nom du tournoi.
     *
     * @return string
     * Le nom du tournoi.
     */
    public function get_nom()
    {
        return $this->nom;
    }

    /**
     * Permet de récupérer le debut du Tournoi
     *
     * @return \DateTime
     * La date et l'heure de début du tournoi au format international.
     */
    public function get_debut() : \DateTime
    {
        return $this->debut;
    }

    /**
     * Permet de récupérer le nombre de joueurs du Tournoi
     *
     * @return int
     * Le nombre de joueurs max du tournoi.
     */
    public function get_nb_joueurs() : int
    {
        return $this->nb_joueurs;
    }

    /**
     * Permet de récupérer le nombre de joueurs par équipe du Tournoi
     *
     * @return int
     * Le nombre de joueurs par équipe pour ce tournoi.
     */
    public function get_nb_joueurs_par_equipe() : int
    {
        return $this->nb_joueurs_par_equipe;
    }

    // =============================== //
    //           Les Setteurs          //
    // =============================== //

    /**
     * Permet de changer l'Evenement durant lequel se déroule le Tournoi
     *
     * @param Evenement $evenement
     * L'Evenement durant lequel se déroule le tournoi.
     */
    public function set_evenement( Evenement $evenement ) : void
    {
        $this->evenement = $evenement;
    }

    /**
     * Permet de changer le nom du tournoi.
     *
     * @param string $nom
     * Le nom du tournoi.
     */
    public function set_nom( $nom )
    {
        $this->nom = $nom;
    }

    /**
     * Permet de changer le debut du Tournoi
     *
     * @param \DateTime $debut
     * La date et l'heure de début du tournoi au format international.
     */
    public function set_debut( \DateTime $debut ) : void
    {
        $this->debut = $debut;
    }

    /**
     * Permet de changer le nombre de joueurs du Tournoi
     *
     * @param int $nb_joueurs
     * Le nombre de joueurs max du tournoi.
     */
    public function set_nb_joueurs( int $nb_joueurs ) : void
    {
        $this->nb_joueurs = $nb_joueurs;
    }

    /**
     * Permet de changer le nombre de joueurs par équipe du Tournoi
     *
     * @param int $nb_joueurs_par_equipe
     * Le nombre de joueurs par équipe pour ce tournoi.
     */
    public function set_nb_joueurs_par_equipe( int $nb_joueurs_par_equipe ) : void
    {
        $this->nb_joueurs_par_equipe = $nb_joueurs_par_equipe;
    }

    /**
     * L'affichage pour le debogage.
     *
     * @return string
     * Toutes les données mise en forme.
     * */
    public function __toString() : string
    {

        $debogage = "<p>Débogage du Tournoi</p>";
        $date = $this->debut->format( \DateTime::W3C );

        $debogage .= "<ul>";
        $debogage .= "<li>id                    = $this->id</li>";
        $debogage .= "<li>nom                   = $this->nom</li>";
        $debogage .= "<li>debut                 = $date</li>";
        $debogage .= "<li>nb joueurs max        = $this->nb_joueurs</li>";
        $debogage .= "<li>nb joueurs par équipe = $this->nb_joueurs_par_equipe</li>";
        $debogage .= "<li>$this->evenement</li>";
        $debogage .= "</ul>";

        return $debogage;

    }

}
