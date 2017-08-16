-- Tout est sensé apparaître --
INSERT INTO joueurs VALUES 
    (NULL,'toto@hotmail.fr','toto','0202020202','dupont','toto','1980-12-25','la fistinière','Caen','14000','France'),
    (NULL,'julien.pivard@hotmail.fr','fdp','0695263295','Pivard','Julien','1991-11-14','40 Avenue de Thiès','Caen','14000','France'),
    (NULL,'josselin.gueneron@laposte.net','grosboulet','0679666197','Guéneron','Josselin','1996-09-15','10 Boulevard Maréchal Juin','Caen','14000','France'),
    (NULL,'jeancul-lambert@hotmail.fr','mrjeanjean','0700000000','Lambert','Jean-Cul','1968-01-20','Dans ton cul','Caen','14000','France');

-- Tout est sensé apparaître --
INSERT INTO evenements VALUES
    (NULL,'La LAN de ta vie', '2018-01-01', '2018-01-02', 'Dans la chatte de Nabilla', 'Silicon Valley', '00000'),
    (NULL,'Le salon d\'investisseur de LAN', '2019-10-23', '2019-10-24', 'IAE', 'JeanJeanVille', '$$$$$');

INSERT INTO equipes VALUES
    (NULL,1,'ta sale race',0),
    (NULL,2,'On aime mater',69),
    (NULL,4,'Buisneeeeeeess',0);

INSERT INTO tournois VALUES
    (NULL, 1, 'WoW Arena', '2018-01-01 15:00:00', 32, 2),
    (NULL, 2, 'CS GO', '2019-10-24 02:00:00', 50, 5);

INSERT INTO lien_joueur_equipe_tournoi VALUES
    (1, 2, 1, TRUE),
    (2, 2, 2, FALSE);

INSERT INTO lien_joueur_tournoi VALUES
    (2, 1),
    (3, 2);

INSERT INTO benevoles VALUES
    (1, 1),
    (2, 2);

INSERT INTO placement_joueurs VALUES
    (2,3,10,12),
    (1,4,9,3);

INSERT INTO placement_equipes VALUES
    (2,2,11),
    (1,3,8);

INSERT INTO facturation VALUES
    (4,1, NULL),
    (3,1, '213'),
    (3,2, '214'),
    (2,2, '220');
