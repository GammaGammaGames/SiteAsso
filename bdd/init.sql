CREATE TABLE IF NOT EXISTS joueurs (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
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

CREATE TABLE IF NOT EXISTS evenements (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
    nom CHAR(30) NOT NULL,
    debut DATETIME NOT NULL,
    fin DATETIME NOT NULL,
    adresse CHAR(255) NOT NULL,
    ville CHAR(50) NOT NULL,
    code_postal CHAR(10) NOT NULL, 
    PRIMARY KEY(id));

CREATE TABLE IF NOT EXISTS equipes (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
    id_capitaine INTEGER UNSIGNED NOT NULL,
    nom CHAR(30) NOT NULL,
    places_libres INTEGER UNSIGNED NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (id_capitaine) REFERENCES joueurs (id));


CREATE TABLE IF NOT EXISTS tournois (
    id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT, 
    id_evenement INTEGER UNSIGNED NOT NULL,
    nom CHAR(30) NOT NULL,
    debut DATETIME NOT NULL,
    nb_joueurs INTEGER UNSIGNED NOT NULL,
    joueur_par_equipe INTEGER UNSIGNED NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (id_evenement) REFERENCES evenements (id));

CREATE TABLE IF NOT EXISTS lien_joueur_equipe_tournoi (
    id_joueur INTEGER UNSIGNED NOT NULL,
    id_equipe INTEGER UNSIGNED NOT NULL DEFAULT 1,
    id_tournoi INTEGER UNSIGNED NOT NULL,
    PRIMARY KEY(id_joueur,id_equipe,id_tournoi),
    FOREIGN KEY (id_joueur) REFERENCES joueurs (id),
    FOREIGN KEY (id_equipe) REFERENCES equipes (id),
    FOREIGN KEY (id_tournoi) REFERENCES tournois (id));

CREATE TABLE IF NOT EXISTS benevoles (
    id_joueur INTEGER UNSIGNED NOT NULL,
    id_evenement INTEGER UNSIGNED NOT NULL,
    PRIMARY KEY(id_joueur,id_evenement),
    FOREIGN KEY (id_joueur) REFERENCES joueurs (id),
    FOREIGN KEY (id_evenement) REFERENCES evenements (id));

-- Changement à venir sur le placement --
CREATE TABLE IF NOT EXISTS placement_joueurs (
    id_tournoi INTEGER UNSIGNED NOT NULL,
    id_joueur INTEGER UNSIGNED NOT NULL,
    num_table INTEGER UNSIGNED NOT NULL,
    num_chaise INTEGER UNSIGNED NOT NULL,
    PRIMARY KEY(id_tournoi, id_joueur),
    FOREIGN KEY (id_tournoi) REFERENCES tournois (id),
    FOREIGN KEY (id_joueur) REFERENCES joueurs (id));

CREATE TABLE IF NOT EXISTS placement_equipes (
    id_tournoi INTEGER UNSIGNED NOT NULL,
    id_equipe INTEGER UNSIGNED NOT NULL,
    num_table INTEGER UNSIGNED NOT NULL,
    PRIMARY KEY(id_tournoi, id_equipe),
    FOREIGN KEY (id_tournoi) REFERENCES tournois (id),
    FOREIGN KEY (id_equipe) REFERENCES equipes (id));

CREATE TABLE IF NOT EXISTS facturation (
    id_joueur INTEGER UNSIGNED NOT NULL,
    id_evenement INTEGER UNSIGNED NOT NULL,
    num_facture CHAR(50) DEFAULT NULL, -- NULL SI PAS PAYE --
    PRIMARY KEY(id_joueur, id_evenement),
    FOREIGN KEY (id_joueur) REFERENCES joueurs (id),
    FOREIGN KEY (id_evenement) REFERENCES evenements (id));

