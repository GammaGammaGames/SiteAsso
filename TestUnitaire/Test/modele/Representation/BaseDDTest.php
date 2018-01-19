<?php
// Dernière modification : Vendredi 19 janvier[01] 2018

/**
 * @author PIVARD Julien
 * @license GPL-v3
 * @version 0.1
 * */

declare( strict_types = 1 );

require_once( "/var/private/mysql_config.php" );

use PHPUnit\Framework\TestCase;

class BaseDDTest extends TestCase
{

    protected $pdo;

    protected function setUp() : void
    {
        $this->pdo = new \PDO(
            'mysql:host='
            . MYSQL_HOST
            . ';port='
            . MYSQL_PORT
            . ';dbname='
            . MYSQL_DB
            . ';charset=utf8'
            , MYSQL_USER
            , MYSQL_PASSWORD);
    }

    protected function tearDown() : void
    {
        $this->pdo = NULL;
    }

    public function testConnexionBase() : void
    {
        $r = "SELECT * FROM test";
        $s = $this->pdo->prepare( $r );
        $s->execute();
        $tableau = $s->fetchAll();
        $attendu = array
            (
                array
                (
                    'id' => '1',
                    'nom' => 'CocaNasson',
                    'categorie' => 'Boisson',
                    'quantite' => '104',
                    0 => '1',
                    1 => 'CocaNasson',
                    2 => 'Boisson',
                    3 => '104',
                ),
                array
                (
                    'id' => '2',
                    'nom' => 'OrangiFruits',
                    'categorie' => 'Boisson',
                    'quantite' => '222',
                    0 => '2',
                    1 => 'OrangiFruits',
                    2 => 'Boisson',
                    3 => '222',
                ),
                array
                (
                    'id' => '3',
                    'nom' => 'Slurm',
                    'categorie' => 'Boisson',
                    'quantite' => '200',
                    0 => '3',
                    1 => 'Slurm',
                    2 => 'Boisson',
                    3 => '200',
                ),
                array
                (
                    'id' => '4',
                    'nom' => 'SoleilVert Cola',
                    'categorie' => 'Boisson',
                    'quantite' => '50',
                    0 => '4',
                    1 => 'SoleilVert Cola',
                    2 => 'Boisson',
                    3 => '50',
                ),
                array
                (
                    'id' => '5',
                    'nom' => 'Olde Fortran',
                    'categorie' => 'Alcool',
                    'quantite' => '394',
                    0 => '5',
                    1 => 'Olde Fortran',
                    2 => 'Alcool',
                    3 => '394',
                ),
                array
                (
                    'id' => '6',
                    'nom' => "Chips Glagnard à l'humain",
                    'categorie' => 'En-Cas',
                    'quantite' => '573',
                    0 => '6',
                    1 => "Chips Glagnard à l'humain",
                    2 => 'En-Cas',
                    3 => '573',
                ),
                array
                (
                    'id' => '7',
                    'nom' => 'Popplers',
                    'categorie' => 'En-Cas',
                    'quantite' => '44',
                    0 => '7',
                    1 => 'Popplers',
                    2 => 'En-Cas',
                    3 => '44',
                ),
                array
                (
                    'id' => '8',
                    'nom' => 'Amiral Crunch',
                    'categorie' => 'En-Cas',
                    'quantite' => '95',
                    0 => '8',
                    1 => 'Amiral Crunch',
                    2 => 'En-Cas',
                    3 => '95',
                ),
                array
                (
                    'id' => '9',
                    'nom' => 'Pamplemouse beaconisé',
                    'categorie' => 'En-Cas',
                    'quantite' => '32',
                    0 => '9',
                    1 => 'Pamplemouse beaconisé',
                    2 => 'En-Cas',
                    3 => '32',
                ),
                array
                (
                    'id' => '10',
                    'nom' => 'Sandwich jambon beurre',
                    'categorie' => 'En-Cas',
                    'quantite' => '433',
                    0 => '10',
                    1 => 'Sandwich jambon beurre',
                    2 => 'En-Cas',
                    3 => '433',
                ),
                array
                (
                    'id' => '11',
                    'nom' => 'Burger',
                    'categorie' => 'En-Cas',
                    'quantite' => '200',
                    0 => '11',
                    1 => 'Burger',
                    2 => 'En-Cas',
                    3 => '200',
                ),
                array
                (
                    'id' => '12',
                    'nom' => 'Bashelor shew',
                    'categorie' => 'En-Cas',
                    'quantite' => '89',
                    0 => '12',
                    1 => 'Bashelor shew',
                    2 => 'En-Cas',
                    3 => '89',
                ),
            );
        $this->assertEquals( $attendu, $tableau );
    }

}
