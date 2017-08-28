<?php
// Dernière modification : Lundi 28 août[08] 2017

/**
 * Stock les données d'un joueur en provenance de la BDD.
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

namespace Modele\Representation;

include_once "/var/www/html/modele/Representation/RepresentationAvecId.php";
include_once "/var/www/html/modele/Representation/Adresse.php";

/**
 * Représente un joueur avec toutes ces données.
 *
 * @category Modèle
 * @package Représentation
 * */
class Joueur extends RepresentationAvecId
{

    /**
     * @var string
     * L'email du joueur.
     * */
    protected $email = "";

    /**
     * @var string
     * Le numéro de téléphone du joueur.
     * */
    protected $tel = "";

    /**
     * @var string
     * Le nom du joueur.
     * */
    protected $nom = "";

    /**
     * @var string
     * Le prénom du joueur.
     * */
    protected $prenom = "";

    /**
     * @var \DateTime
     * La date de naissance du joueur.
     * */
    protected $anniv;

    /**
     * @var string
     * L'adresse du joueur.
     * */
    protected $adresse;

    /**
     * Construit un joueur inexistant.
     * */
    public function __construct()
    {
        $this->adresse = new Adresse();
        $this->anniv = new \DateTime( "1970-01-01" );
    }

    // =============================== //
    //          Les Guetteurs          //
    // =============================== //

    /**
     * Récupère l'email du joueur.
     *
     * @return string
     * L'email du joueur
     * */
    public function get_email() : string
    {
        return $this->email;
    }

    /**
     * Récupère le numéro de téléphone du joueur.
     *
     * @return string
     * Le numéro du joueur
     * */
    public function get_tel() : string
    {
        return $this->tel;
    }

    /**
     * Récupère le nom du joueur.
     *
     * @return string
     * Le nom du joueur
     * */
    public function get_nom() : string
    {
        return $this->nom;
    }

    /**
     * Récupère le prénom du joueur.
     *
     * @return string
     * Le prénom du joueur
     * */
    public function get_prenom() : string
    {
        return $this->prenom;
    }

    /**
     * Récupère la date de naissance du joueur.
     *
     * @return \DateTime
     * La date de naissance du joueur
     * */
    public function get_anniv() : \DateTime
    {
        return $this->anniv;
    }

    /**
     * Récupère l'adresse du joueur.
     *
     * @return Adresse
     * L'adresse du joueur
     * */
    public function get_adresse() : Adresse
    {
        return $this->adresse;
    }

    // =============================== //
    //           Les Setteurs          //
    // =============================== //

    /**
     * Modifie l'email du joueur.
     *
     * @param string $email
     * L'email du joueur.
     * */
    public function set_email( string $email ) : void
    {
        $this->email = $email;
    }

    /**
     * Modifie le numéro de téléphone du joueur.
     *
     * @param string $tel
     * Le numéro de téléphone du joueur.
     * */
    public function set_tel( string $tel ) : void
    {
        $this->tel = $tel;
    }

    /**
     * Modifie le nom du joueur.
     *
     * @param string $nom
     * Le nom du joueur.
     * */
    public function set_nom( string $nom ) : void
    {
        $this->nom = $nom;
    }

    /**
     * Modifie le prénom du joueur.
     *
     * @param string $prenom
     * Le prénom du joueur.
     * */
    public function set_prenom( string $prenom ) : void
    {
        $this->prenom = $prenom;
    }

    /**
     * Modifie la date de naissance du joueur.
     *
     * @param \DateTime $anniv
     * La date de naissance du joueur.
     * */
    public function set_anniv( \DateTime $anniv ) : void
    {
        $this->anniv = $anniv;
    }

    /**
     * Modifie l'adresse du joueur.
     *
     * @param Adresse $adresse
     * L'adresse du joueur.
     * */
    public function set_adresse( Adresse $adresse ) : void
    {
        $this->adresse = $adresse;
    }

    /**
     * L'affichage pour le debogage.
     *
     * @return string
     * Toutes les données mise en forme.
     * */
    public function __toString() : string
    {

        $debogage = "<p>Débogage de Joueur</p>";
        $date = $this->anniv->format( \DateTime::W3C );

        $debogage .= "<ul>";
        $debogage .= "<li>id          = $this->id</li>";
        $debogage .= "<li>email       = $this->email</li>";
        $debogage .= "<li>tel         = $this->tel</li>";
        $debogage .= "<li>nom         = $this->nom</li>";
        $debogage .= "<li>prenom      = $this->prenom</li>";
        $debogage .= "<li>anniv       = $date</li>";
        $debogage .= "<li>$this->adresse</li>";
        $debogage .= "</ul>";

        return $debogage;

    }

}
