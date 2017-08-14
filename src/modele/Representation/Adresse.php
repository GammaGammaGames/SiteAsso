<?php
// Dernière modification : Lundi 14 août[08] 2017

/**
 * Stock une adresse.
 *
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

/**
 * Représente une adresse.
 *
 * @category Modèle
 * @package Représentation
 * */
class Adresse
{

    /**
     * @var string
     * L'adresse.
     * */
    protected $adresse = "";

    /**
     * @var string
     * La ville.
     * */
    protected $ville = "";

    /**
     * @var string
     * Le code postal.
     * */
    protected $code_postal = "";

    /**
     * @var string
     * Le pays.
     * */
    protected $pays = "";

    /**
     * Une adresse vide.
     * */
    public function __construct()
    {
    }

    // =============================== //
    //          Les Guetteurs          //
    // =============================== //

    /**
     * Récupère l'adresse.
     *
     * @return string
     * L'adresse.
     * */
    public function get_adresse() : string
    {
        return $this->adresse;
    }

    /**
     * Récupère la ville.
     *
     * @return string
     * La ville.
     * */
    public function get_ville() : string
    {
        return $this->ville;
    }

    /**
     * Récupère le code postal.
     *
     * @return string
     * Le code postal.
     * */
    public function get_code_postal() : string
    {
        return $this->code_postal;
    }

    /**
     * Récupère le pays.
     *
     * @return string
     * Le pays.
     * */
    public function get_pays() : string
    {
        return $this->pays;
    }

    // =============================== //
    //           Les Setteurs          //
    // =============================== //

    /**
     * Modifie l'adresse.
     *
     * @param string $adresse
     * L'adresse.
     * */
    public function set_adresse( string $adresse ) : void
    {
        $this->adresse = $adresse;
    }

    /**
     * Modifie la ville.
     *
     * @param string $ville
     * La ville.
     * */
    public function set_ville( string $ville ) : void
    {
        $this->ville = $ville;
    }

    /**
     * Modifie le code postal.
     *
     * @param string $code_postal
     * Le code postal.
     * */
    public function set_code_postal( string $code_postal ) : void
    {
        $this->code_postal = $code_postal;
    }

    /**
     * Modifie le pays.
     *
     * @param string $pays
     * Le pays.
     * */
    public function set_pays( string $pays ) : void
    {
        $this->pays = $pays;
    }

    /**
     * L'affichage pour le debogage.
     *
     * @return string
     * Les données au format html.
     * */
    public function __toString() : string
    {

        $debogage = "<p>Débogage Adresse</p>";

        $debogage .= "<ul>";
        $debogage .= "<li>adresse     = $this->adresse</li>";
        $debogage .= "<li>ville       = $this->ville</li>";
        $debogage .= "<li>code_postal = $this->code_postal</li>";
        $debogage .= "<li>pays        = $this->pays</li>";
        $debogage .= "</ul>";

        return $debogage;

    }

}
