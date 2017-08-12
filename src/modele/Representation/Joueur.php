<?php
// Dernière modification : Samedi 12 août[08] 2017

/**
 * Stock les données d'un joueur en provenance de la BDD.
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

/**
 * Représente un joueur avec toutes ces données.
 *
 * @category Modèle
 * @package Représentation
 * */
class Joueur
{

    /**
     * @var int
     * L'identifiant unique du joueur en BDD.
     * Si la valeur vaut 0 alors le joueur n'a pas été ajouté à la BDD
     * */
    protected $id;

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
     * @var string
     * La date de naissance du joueur.
     * */
    protected $anniv = "";

    /**
     * @var string
     * L'adresse du joueur.
     * */
    protected $adresse = "";

    /**
     * @var string
     * La ville du joueur.
     * */
    protected $ville = "";

    /**
     * @var string
     * Le code postal du joueur
     * */
    protected $code_postal = "";

    /**
     * @var string
     * Le pays du joueur
     * */
    protected $pays = "";

    /**
     * Construit un joueur inexistant.
     * */
    public function __construct()
    {
        $this->id = 0;
    }

    // =============================== //
    //          Les Guetteurs          //
    // =============================== //

    /**
     * Récupère l'id du joueur.
     *
     * @return int
     * L'identifiant du joueur
     * */
    public function get_id() : int
    {
        return $this->id;
    }

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
     * @return string
     * La date de naissance du joueur
     * */
    public function get_anniv() : string
    {
        return $this->anniv;
    }

    /**
     * Récupère l'adresse du joueur.
     *
     * @return string
     * L'adresse du joueur
     * */
    public function get_adresse() : string
    {
        return $this->adresse;
    }

    /**
     * Récupère la ville du joueur.
     *
     * @return string
     * La ville du joueur
     * */
    public function get_ville() : string
    {
        return $this->ville;
    }

    /**
     * Récupère le code postal du joueur.
     *
     * @return string
     * Le code postal du joueur
     * */
    public function get_code_postal() : string
    {
        return $this->code_postal;
    }

    /**
     * Récupère le pays du joueur.
     *
     * @return string
     * Le pays du joueur
     * */
    public function get_pays() : string
    {
        return $this->pays;
    }

    // =============================== //
    //           Les Setteurs          //
    // =============================== //

    /**
     * Modifie l'identifiant du joueur.
     *
     * @param int $id
     * L'identifiant du joueur.
     * */
    public function set_id( int $id ) : void
    {
        $this->id = $id;
    }

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
     * @param string $anniv
     * La date de naissance du joueur.
     * */
    public function set_anniv( string $anniv ) : void
    {
        $this->anniv = $anniv;
    }

    /**
     * Modifie l'adresse du joueur.
     *
     * @param string $adresse
     * L'adresse du joueur.
     * */
    public function set_adresse( string $adresse ) : void
    {
        $this->adresse = $adresse;
    }

    /**
     * Modifie la ville du joueur.
     *
     * @param string $ville
     * La ville du joueur.
     * */
    public function set_ville( string $ville ) : void
    {
        $this->ville = $ville;
    }

    /**
     * Modifie le code postal du joueur.
     *
     * @param string $code_postal
     * Le code postal du joueur.
     * */
    public function set_code_postal( string $code_postal ) : void
    {
        $this->code_postal = $code_postal;
    }

    /**
     * Modifie le pays du joueur.
     *
     * @param string $pays
     * Le pays du joueur.
     * */
    public function set_pays( string $pays ) : void
    {
        $this->pays = $pays;
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

        $debogage .= "<ul>";
        $debogage .= "<li>id          = $this->id</li>";
        $debogage .= "<li>email       = $this->email</li>";
        $debogage .= "<li>tel         = $this->tel</li>";
        $debogage .= "<li>nom         = $this->nom</li>";
        $debogage .= "<li>prenom      = $this->prenom</li>";
        $debogage .= "<li>anniv       = $this->anniv</li>";
        $debogage .= "<li>adresse     = $this->adresse</li>";
        $debogage .= "<li>ville       = $this->ville</li>";
        $debogage .= "<li>code_postal = $this->code_postal</li>";
        $debogage .= "<li>pays        = $this->pays</li>";
        $debogage .= "</ul>";

        return $debogage;

    }

}

?>
