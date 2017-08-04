CREATE TABLE IF NOT EXISTS joueurs (
    id INTEGER NOT NULL AUTO_INCREMENT, 
    email CHAR(50) NOT NULL, 
    mdp CHAR(255) NOT NULL, 
    tel CHAR(12), 
    nom CHAR(50), 
    prenom CHAR(50), 
    anniv DATE, 
    adresse CHAR(255),
    ville CHAR(50),
    code_postal CHAR(10), 
    pays CHAR(20), 
    PRIMARY KEY(id));

CREATE TABLE IF NOT EXISTS equipes(
    id INTEGER NOT NULL AUTO_INCREMENT, 
    id_capitaine INTEGER NOT NULL,
    nom CHAR(30) NOT NULL,
    places_libres INTEGER NOT NULL,
    PRIMARY KEY(id));


CREATE TABLE IF NOT EXISTS tournois(
    id INTEGER NOT NULL AUTO_INCREMENT, 
    id_evenement INTEGER NOT NULL,
    nom CHAR(30) NOT NULL,
    debut DATETIME NOT NULL,
    nb_joueurs INTEGER NOT NULL,
    PRIMARY KEY(id));

CREATE TABLE IF NOT EXISTS evenements(
    id INTEGER NOT NULL AUTO_INCREMENT, 
    nom CHAR(30) NOT NULL,
    debut DATETIME NOT NULL,
    fin DATETIME NOT NULL,
    adresse CHAR(255) NOT NULL,
    ville CHAR(50) NOT NULL,
    code_postal CHAR(10) NOT NULL, 
    PRIMARY KEY(id));

CREATE TABLE IF NOT EXISTS lien_joueur_equipe_tournoi(
    id_joueur INTEGER NOT NULL,
    id_equipe INTEGER NOT NULL DEFAULT -1,
    id_tournoi INTEGER NOT NULL,
    PRIMARY KEY(id_joueur,id_equipe,id_tournoi));

CREATE TABLE IF NOT EXISTS benevoles(
    id_joueur INTEGER NOT NULL,
    id_evenement INTEGER NOT NULL,
    PRIMARY KEY(id_joueur,id_evenement));

-- Changement à venir sur le placement --
CREATE TABLE IF NOT EXISTS placement(
    id_evenement INTEGER NOT NULL,
    id_tournoi INTEGER NOT NULL,
    colonne CHAR(2),
    rang INTEGER NOT NULL,
    id_joueur INTEGER NOT NULL,
    PRIMARY KEY(id_evenement,id_tournoi, id_joueur));

CREATE TABLE IF NOT EXISTS facturation(
    id_joueur INTEGER NOT NULL,
    id_evenement INTEGER NOT NULL,
    num_facture CHAR(50) DEFAULT NULL, -- NULL SI PAS PAYE --
    PRIMARY KEY(id_joueur, id_evenement));

