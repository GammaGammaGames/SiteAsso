<?php
// Dernière modification : Jeudi 24 août[08] 2017

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
    protected $nb_places_libres = 0;

    /**
     * @var Tournoi
     * Le tournoi dans lequel est inscrite l'équipe.
     * */
    protected $tournoi;

    /**
     * @var array[Joueur]
     * Les joueurs membres de l'équipe
     * */
    protected $liste_joueurs;

    /**
     * Construit une équipe vide.
     * */
    public function __construct()
    {
        $this->capitaine = new Joueur();
        $this->tournoi = new Tournoi();
        $this->liste_joueurs = array();
    }

    // =============================== //
    //          Les Guetteurs          //
    // =============================== //

    /**
     * Récupère le capitaine de l'équipe
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

    // =============================== //
    //           Les Setteurs          //
    // =============================== //

    /**
     * Permet de changer le capitaine de l'équipe
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
     * Le nouveau nom de l'équipe
     * */
    public function set_nom( string $nom ) : void
    {
        $this->nom = $nom;
    }

    /**
     * L'affichage pour le debogage.
     *
     * @return string
     * Toutes les données mise en forme.
     * */
    public function __toString() : string
    {

        $debogage = "<p>Débogage de Utilisateur</p>";

        $debogage .= "<ul>";
        $debogage .= "<li></li>";
        $debogage .= "</ul>";

        return $debogage;

    }

}
