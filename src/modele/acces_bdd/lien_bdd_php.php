<?php

class LienBddPhp 
{

    protected $pdo;

    private function __construct()
    {
        
        $this->pdo = new PDO('mysql:host='
            . MYSQL_HOST
            . ';port='
            . MYSQL_PORT
            .';dbname='
            . MYSQL_DB
            . ';charset=utf8'
            , MYSQL_USER, MYSQL_PASSWORD);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    }

    public function prepare_exec(string $requete, array $data): void
    {
        $requete_preparee = $this->pdo->prepare($requete);
        $requete_preparee->execute($data);
    }

    public function prepare_exec_recup(string $requete, array $data): array
    {
        $requete_preparee = $this->pdo->prepare($requete);
        $requete_preparee->execute($data);
        return $requete_preparee->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
