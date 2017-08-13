<?php
// Dernière modification : Dimanche 13 août[08] 2017

/**
 * Représentation d'un évènement.
 *
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

include_once "/src/modele/Representation/Adresse.php";

/**
 * Représente un évènement.
 *
 * @category Modèle
 * @package Représentation
 * */
class Evenement
{

    /**
     * @var integer
     * L'identifiant unique de l'évènement.
     * */
    protected $id;

    /**
     * @var string
     * Le nom de l'évènement.
     * */
    protected $nom = "";

    /**
     * @var string
     * La date de début de l'évènement.
     * */
    protected $debut = "";

    /**
     * @var string
     * La date de fin de l'évènement.
     * */
    protected $fin = "";

    /**
     * @var Adresse
     * L'adresse de l'évènement.
     * */
    protected $adresse = NULL;

    /**
     * Création d'un évènement avec l'identifiant 0.
     * */
    public function __construct()
    {
        $this->id = 0;
        $this->adresse = new Adresse();
    }

    // =============================== //
    //          Les Guetteurs          //
    // =============================== //

    /**
     * Récupère l'id de l'évènement.
     *
     * @return int
     * L'identifiant de l'évènement.
     * */
    public function get_id() : int
    {
        return $this->id;
    }

    /**
     * Récupère le nom de l'évènement.
     *
     * @return string
     * Le nom de l'évènement.
     * */
    public function get_nom() : string
    {
        return $this->nom;
    }

    /**
     * La date de début de l'évènement.
     *
     * @return string
     * La date de début.
     * */
    public function get_date_debut() : string
    {
        return $this->debut;
    }

    /**
     * La date de fin de l'évènement.
     *
     * @return string
     * La date de fin
     * */
    public function get_date_fin() : string
    {
        return $this->fin;
    }

    /**
     * L'adresse de l'évènement.
     *
     * @return Adresse
     * L'adresse.
     * */
    public function get_adresse() : Adresse
    {
        return $this->adresse;
    }

    // =============================== //
    //           Les Setteurs          //
    // =============================== //

    /**
     * Change l'id de l'évènement.
     *
     * @param integer
     * Le nouvel identifiant de l'évènement.
     * */
    public function set_id( int $id ) : void
    {
        $this->id = $id;
    }

    /**
     * Change le nom de l'évènement.
     *
     * @param string
     * Le nom de l'évènement.
     * */
    public function set_nom( string $nom ) : void
    {
        $this->nom = $nom;
    }

    /**
     * Change la date de début de l'évènement.
     *
     * @param string
     * La date de début.
     * */
    public function set_date_debut( string $date ) : void
    {
        $this->debut = $date;
    }

    /**
     * Change la date de fin de l'évènement.
     *
     * @param string
     * La date de fin
     * */
    public function set_date_fin( string $date ) : void
    {
        $this->fin = $date;
    }

    /**
     * Change l'adresse de l'évènement.
     *
     * @param Adresse
     * L'adresse.
     * */
    public function set_adresse( Adresse $adr ) : void
    {
        $this->adresse = $adr;
    }

    /**
     * L'affichage pour le debogage.
     * @return string
     * Les information au format html.
     * */
    public function __toString() : string
    {

        $debogage = "<p>Débogage de Evenement</p>";

        $debogage .= "<ul>";
        $debogage .= "<li>id            = $this->id</li>";
        $debogage .= "<li>nom           = $this->nom</li>";
        $debogage .= "<li>date de début = $this->debut</li>";
        $debogage .= "<li>date de fin   = $this->fin</li>";
        $debogage .= "<li>adresse       = $this->adresse</li>";
        $debogage .= "</ul>";

        return $debogage;

    }

}

?>
