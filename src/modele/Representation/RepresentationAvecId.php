<?php
// Dernière modification : Lundi 14 août[08] 2017

/**
 * Classe mère de tous les objets avec un id de la BDD.
 *
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );
include_once "/src/modele/Representation/RepresentationBDD.php";

/**
 * Toutes les classes qui représentent un objet de la base avec un id unique
 * héritent de cette classe.
 *
 * @category Modèle
 * @package Représentation
 * */
abstract class RepresentationAvecId implements RepresentationBDD
{

    /**
     * @var integer
     * L'identifiant unique.
     * Si celui-ci vaut 0 c'est que l'objet représenté n'a jamais
     * été ajouté à la BDD.
     * */
    protected $id = 0;

    /**
     * Récupère l'identifiant.
     *
     * @return integer
     * L'identifiant unique.
     * */
    public function get_id() : int
    {
        return $this->id;
    }

    /**
     * Modifie l'identifiant.
     *
     * @param integer $id
     * Le nouvel identifiant.
     * */
    public function set_id( int $id ) : void
    {
        $this->id = $id;
    }

}
