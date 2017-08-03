# vim: nofoldenable: list:
# PIVARD Julien
# Dernière modification : Jeudi 03 août[08] 2017

SHELL		= /bin/sh
.DEFAULT_GOAL	:= all
# Les suffixes des fichiers dont on va tenir compte
.SUFFIXES:

srcdir		= .

# Stoppe toutes les machines virtuelles en cours.
.PHONY: stop
stop:
	-docker stop `docker ps --quiet`

# Stoppe les machines virtuel et les supprimes toutes
.PHONY: clean
clean: stop
	-docker rm --force --volumes `docker ps --all --quiet`

# Stoppe, supprime et nettoie les fichiers temporaires.
.PHONY: distclean
distclean: clean
	$(RM) -rf ./Docker

ifeq ($(wildcard Docker/*), )
    $(error "Vous devez générer la configuration avec ./configure")
endif

# Configuration des variables et des chemins
include ./makefile.conf
# Vérifications automatique de la configuration
include ./makefile.checks

.PHONY: all
all: run

.PHONY: run
run: run_mysql run_php run_nginx

# Permet de redémarrer seulement le container nginx
.PHONY: restart
restart: stop_nginx run_nginx

# Permet de demander à nginx de relire ses fichiers de configurations
# sans avoir à redémarrer le container.
.PHONY: reload
reload:
	docker kill -s HUP $(Nginx_Nom_Container)

Nom_Php_Construit = php-mysql-alpine
.PHONY: build_php
build_php:
	docker build --tag $(Nom_Php_Construit) $(srcdir)/Fichiers_Configuration

# Démarrage de la BDD avec une configuration particulière :
# - un mdp pour root
# - Une base de données
# - l'utilisateur qui ne peut agir que sur cette base
# - le mot de passe de cet utilisateur
# - Les scripts pour peupler la BDD
.PHONY: run_mysql
run_mysql:
	docker run --detach \
		--publish $(Mysql_Port_Exterieur):$(Mysql_Port_Interne) \
		--env MYSQL_ROOT_PASSWORD='$(Mysql_Mdp_Root)' \
		--env MYSQL_DATABASE='$(Mysql_Nom_Bdd)' \
		--env MYSQL_USER='$(Mysql_Utilisateur)' \
		--env MYSQL_PASSWORD='$(Mysql_Pass_Utilisateur)' \
		-v $(Chemin_Localtime_Ext):$(Chemin_Localtime_Int):ro \
		-v $(Time_Zone_Ext):$(Time_Zone_Int):ro \
		-v $(Mysql_Config_Externe):$(Mysql_Config_Interne):ro \
		-v $(Mysql_Init_Bdd_Externe):$(Mysql_Init_Bdd_Interne):ro \
		-v $(Mysql_Volume_Ext):$(Mysql_Volume_Int) \
		--name $(Mysql_Nom_Container) mysql:latest

# Démarrage du serveur php avec un accès en lecteur au dossier ou se trouvent
# les fichiers php du site et lié à la base de données.
.PHONY: run_php
run_php: build_php
	docker run --detach \
		--publish $(Php_Port_Exterieur):$(Php_Port_Interne) \
		-v $(Chemin_Localtime_Ext):$(Chemin_Localtime_Int):ro \
		-v $(Time_Zone_Ext):$(Time_Zone_Int):ro \
		-v $(Php_Volume_Ext):$(Php_Volume_Int):ro \
		-v $(Php_Config_Mysql_Ext):$(Php_Config_Mysql_Int):ro \
		-v $(Php_Php_Ini_Externe):$(Php_Php_Ini_Interne):ro \
		-v $(Php_Fichier_Log_Ext):$(Php_Fichier_Log_Int) \
		--link $(Mysql_Nom_Container):$(Php_Nom_Interne_Mysql) \
		--name $(Php_Nom_Container) $(Nom_Php_Construit)

# Démarrage du serveur nginx avec ces fichiers de configurations;
# un accès au sources du site; et des logs accessible sans avoir à
# se connecter au docker.
.PHONY: run_nginx
run_nginx:
	docker run --detach \
		--publish $(Nginx_Port_Externe):$(Nginx_Port_Interne) \
		-v $(Chemin_Localtime_Ext):$(Chemin_Localtime_Int):ro \
		-v $(Time_Zone_Ext):$(Time_Zone_Int):ro \
		-v $(Nginx_Site_Externe):$(Nginx_Site_Interne):ro \
		-v $(Nginx_Config_Externe):$(Nginx_Config_Interne):ro \
		-v $(Nginx_Log_Externe):$(Nginx_Log_Interne) \
		--link $(Mysql_Nom_Container):$(Nginx_Nom_Interne_Mysql) \
		--link $(Php_Nom_Container):$(Nginx_Nom_Interne_Php) \
		--name $(Nginx_Nom_Container) nginx:stable-alpine

.PHONY: start
start: start_mysql start_php start_nginx

.PHONY: start_mysql
start_mysql:
	docker start $(Mysql_Nom_Container)

.PHONY: start_php
start_php:
	docker start $(Php_Nom_Container)

.PHONY: start_nginx
start_nginx:
	docker start $(Nginx_Nom_Container)

# Pour se connecter au docker mysql lancé en daemon
.PHONY: connect_mysql
connect_mysql:
	docker exec --interactive --tty $(Mysql_Nom_Container) /bin/sh

# Pour se connecter au docker php lancé en daemon
.PHONY: connect_php
connect_php:
	docker exec --interactive --tty $(Php_Nom_Container) /bin/sh

# Pour se connecter au docker nginx lancé en daemon
.PHONY: connect_nginx
connect_nginx:
	docker exec --interactive --tty $(Nginx_Nom_Container) /bin/sh

# Permet de créer un dump des bases de données
.PHONY: dump_bdd
dump_bdd:
	docker exec $(Mysql_Nom_Container) sh -c \
		'exec mysqldump --all-databases -uroot -p"$(Mysql_Mdp_Root)"' \
		> $(Chemin_Repo)/Dump_BDD/bdd_site_asso_dump.sql

# Stop proprement le container nginx le supprime ainsi que son volume lié
.PHONY: stop_nginx
stop_nginx:
	-docker stop $(Nginx_Nom_Container)
	-docker rm --volumes $(Nginx_Nom_Container)

# Pour pouvoir inspecter facilement le container nginx en cours d'exécution
.PHONY: logs
logs:
	docker logs $(Nginx_Nom_Container)
