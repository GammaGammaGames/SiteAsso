CREATE TABLE IF NOT EXISTS Test
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR (255) NOT NULL,
    `categorie` VARCHAR (255) NOT NULL,
    `quantite` INTEGER NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO Test ( `nom`, `categorie`, `quantite` ) VALUES
( 'CocaNasson'               , 'Boisson' , 104 ) ,
( 'OrangiFruits'             , 'Boisson' , 222 ) ,
( 'Slurm'                    , 'Boisson' , 200 ) ,
( 'SoleilVert Cola'          , 'Boisson' , 50  ) ,
( 'Olde Fortran'             , 'Alcool'  , 394 ) ,
( 'Chips Glagnard à lhumain' , 'En-Cas'  , 573 ) ,
( 'Popplers'                 , 'En-Cas'  , 44  ) ,
( 'Amiral Crunch'            , 'En-Cas'  , 95  ) ,
( 'Pamplemouse beaconisé'    , 'En-Cas'  , 32  ) ,
( 'Sandwich jambon beurre'   , 'En-Cas'  , 433 ) ,
( 'Burger'                   , 'En-Cas'  , 200 ) ,
( 'Bashelor shew'            , 'En-Cas'  , 89  );
