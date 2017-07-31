# vim: nofoldenable: list:
# PIVARD Julien
# Dernière modification : Lundi 31 juillet[07] 2017

SHELL		= /bin/sh
.DEFAULT_GOAL	:= all
# Les suffixes des fichiers dont on va tenir compte
.SUFFIXES:

srcdir		= .

.PHONY: clean
clean:
	-docker stop `docker ps --quiet`
	-docker rm --force --volumes `docker ps --all --quiet`
	$(RM) -rf ./Docker

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
restart: stop run_nginx

# Permet de demander à nginx de relire ses fichiers de configurations
# sans avoir à redémarrer le container.
.PHONY: reload
reload:
	docker kill -s HUP $(Nginx_Nom_Container)

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
		--name $(Mysql_Nom_Container) \
		--env MYSQL_ROOT_PASSWORD='$(Mysql_Mdp_Root)' \
		--env MYSQL_DATABASE='$(Mysql_Nom_Bdd)' \
		--env MYSQL_USER='$(Mysql_Utilisateur)' \
		--env MYSQL_PASSWORD='$(Mysql_Pass_Utilisateur)' \
		-v $(Mysql_Config_Externe):$(Mysql_Config_Interne) \
		-v $(Mysql_Init_Bdd_Externe):$(Mysql_Init_Bdd_Interne) \
		-v $(Mysql_Volume_Ext):$(Mysql_Volume_Int) mysql:latest

Nom_Php_Construit = php-mysql-alpine
.PHONY: build_php
build_php:
	docker build --tag $(Nom_Php_Construit) $(srcdir)/Fichiers_Configuration

# Démarrage du serveur php avec un accès en lecteur au dossier ou se trouvent
# les fichiers php du site et lié à la base de données.
.PHONY: run_php
run_php: build_php
	docker run --detach \
		--publish $(Php_Port_Exterieur):$(Php_Port_Interne) \
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
		--name $(Nginx_Nom_Container) \
		-v $(Nginx_Site_Externe):$(Nginx_Site_Interne):ro \
		-v $(Nginx_Config_Externe):$(Nginx_Config_Interne):ro \
		-v $(Nginx_Log_Externe):$(Nginx_Log_Interne) \
		--link $(Mysql_Nom_Container):$(Nginx_Nom_Interne_Mysql) \
		--link $(Php_Nom_Container):$(Nginx_Nom_Interne_Php) \
		nginx:stable-alpine

# Pour se connecter au docker mysql lancé en daemon
.PHONY: connect_bdd
connect_bdd:
	docker exec --interactive --tty $(Mysql_Nom_Container) /bin/sh

.PHONY: dump_bdd
dump_bdd:
	docker exec $(Mysql_Nom_Container) sh -c \
		'exec mysqldump --all-databases -uroot -p"$(Mysql_Mdp_Root)"' \
		> $(Chemin_Repo)/Dump_BDD/bdd_site_asso_dump.sql

# Pour se connecter au docker php lancé en daemon
.PHONY: connect_php
connect_php:
	docker exec --interactive --tty $(Php_Nom_Container) /bin/sh

# Pour se connecter au docker nginx lancé en daemon
.PHONY: connect
connect:
	docker exec --interactive --tty $(Nginx_Nom_Container) /bin/sh

# Stop proprement le container nginx le supprime ainsi que son volume lié
.PHONY: stop
stop:
	-docker stop $(Nginx_Nom_Container)
	-docker rm --volumes $(Nginx_Nom_Container)

# Pour pouvoir inspecter facilement le container nginx en cours d'exécution
.PHONY: logs
logs:
	docker logs $(Nginx_Nom_Container)
