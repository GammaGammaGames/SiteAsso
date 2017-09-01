<?php
// Dernière modification : Vendredi 01 septembre[09] 2017

/**
 * Permet de représenter un bénévole.
 *
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

namespace Modele\Representation;

include_once "/var/www/html/modele/Representation/Joueur.php";
include_once "/var/www/html/modele/Representation/Evenement.php";

/**
 * Représente un bénévole.
 *
 * @category Modèle
 * @package Représentation
 * */
class Benevole
{

    /**
     * @var Evenement
     * L'évènement auquel participe le bénévole.
     * */
    protected $evenement;

    /**
     * @var Joueur
     * Le joueur qui s'est porté bénévole.
     * */
    protected $joueur;

    /**
     * Création d'un bénévole avec un joueur vide.
     * */
    public function __construct()
    {
        $this->joueur = new Joueur();
        $this->evenement = new Evenement();
    }

    // =============================== //
    //          Les Guetteurs          //
    // =============================== //

    /**
     * Permet de récupérer le joueur de Benevoles.
     *
     * @return Joueur
     * Le joueur bénévole.
     */
    public function get_joueur() : Joueur
    {
        return $this->joueur;
    }

    /**
     * Permet de récupérer l'evenement auquel participe le Benevoles.
     *
     * @return Evenement
     * L'évènement auquel participe le bénévole.
     */
    public function get_evenement() : Evenement
    {
        return $this->evenement;
    }

    // =============================== //
    //           Les Setteurs          //
    // =============================== //

    /**
     * Permet de changer l'evenement auquel participe le Benevoles.
     *
     * @param Evenement $evenement
     * L'évènement auquel participe le bénévole.
     */
    public function set_evenement( Evenement $evenement ) : void
    {
        $this->evenement = $evenement;
    }

    /**
     * Permet de changer le joueur de Benevoles.
     *
     * @param Joueur $joueur
     * Le joueur bénévole.
     */
    public function set_joueur( Joueur $joueur ) : void
    {
        $this->joueur = $joueur;
    }

    /**
     * L'affichage pour le debogage.
     *
     * @return string
     * Toutes les données mise en forme.
     * */
    public function __toString() : string
    {

        $debogage = "<p>Débogage de Benevoles</p>";

        $debogage .= "<ul>";
        $debogage .= "<li>$this->joueur</li>";
        $debogage .= "<li>$this->evenement</li>";
        $debogage .= "</ul>";

        return $debogage;

    }

}
