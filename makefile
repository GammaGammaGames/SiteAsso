# vim: nofoldenable: list:
# PIVARD Julien
# Dernière modification : Lundi 28 août[08] 2017

SHELL		= /bin/sh
.DEFAULT_GOAL	:= all
# Les suffixes des fichiers dont on va tenir compte
.SUFFIXES:

srcdir		= .

# Supprime les containers qui ont été stoppé et les images intermédiaires
.PHONY: nettoyage
nettoyage:
	-docker rm --volumes `docker ps --all --quiet --filter "status=exited"`
	-docker rmi `docker images --quiet --filter "dangling=true"`

ifeq ($(wildcard Docker/*), )
    $(error "Vous devez générer la configuration avec ./configure")
endif

# Configuration des variables et des chemins
include ./makefile.conf
# Vérifications automatique de la configuration
include ./makefile.checks

# Stoppe toutes les machines virtuelles en cours.
.PHONY: stop
stop:
	-docker stop $(Nginx_Nom_Container)
	-docker stop $(Php_Nom_Container)
	-docker stop $(Mysql_Nom_Container)

# Stoppe les machines virtuel et les supprimes toutes
.PHONY: clean
clean: stop
	-docker rm --force --volumes $(Nginx_Nom_Container)
	-docker rm --force --volumes $(Php_Nom_Container)
	-docker rm --force --volumes $(Mysql_Nom_Container)

.PHONY: all
all: run_ou_start

.PHONY: run_ou_start
run_ou_start: $(Start_Ou_Run_Mysql) $(Start_Ou_Run_Php) $(Start_Ou_Run_Nginx)

# Affiche un avertissement si les docker sont déjà en cours d'exécution
.PHONY: info_mysql
info_mysql:
	$(warning "Le container MySql est déjà en cours d'exécution.")

.PHONY: info_php
info_php:
	$(warning "Le container  PHP  est déjà en cours d'exécution.")

.PHONY: info_nginx
info_nginx:
	$(warning "Le container NginX est déjà en cours d'exécution.")

# --------------------------------- #

.PHONY: run
run: run_mysql run_php run_nginx

# Permet de demander à nginx de relire ses fichiers de configurations
# sans avoir à redémarrer le container.
.PHONY: reload
reload:
	docker kill -s HUP $(Nginx_Nom_Container)

# ---------------------------------------- #
# Construction et démarrage des conteneurs #
# ---------------------------------------- #

# La construction de l'image n'est lancée que si elle n'existe pas.
.PHONY: construire_php
construire_php:
ifeq ($(shell docker images -q $(Nom_Php_Construit) ), )
	docker build --tag $(Nom_Php_Construit) $(srcdir)/Fichiers_Configuration
endif

# Démarrage de la BDD avec une configuration particulière :
# - un mdp pour root
# - Une base de données
# - l'utilisateur qui ne peut agir que sur cette base
# - le mot de passe de cet utilisateur
# - Les scripts pour peupler la BDD
.PHONY: run_mysql
run_mysql: verifier_mysql
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
	@echo "──────────────────────────────────────────"
	@echo "Les bases de données seront écrites dans : [$(Mysql_Volume_Ext)] "
	@echo "──────────────────────────────────────────"

# Démarrage du serveur php avec un accès en lecteur au dossier ou se trouvent
# les fichiers php du site et lié à la base de données.
.PHONY: run_php
run_php: verifier_php construire_php
	docker run --detach \
		--publish $(Php_Port_Exterieur):$(Php_Port_Interne) \
		-v $(Chemin_Localtime_Ext):$(Chemin_Localtime_Int):ro \
		-v $(Time_Zone_Ext):$(Time_Zone_Int):ro \
		-v $(Php_Src_Ext):$(Php_Src_Int):ro \
		-v $(Php_Config_Mysql_Ext):$(Php_Config_Mysql_Int):ro \
		-v $(Php_Php_Ini_Externe):$(Php_Php_Ini_Interne):ro \
		-v $(Php_Fichier_Log_Ext):$(Php_Fichier_Log_Int) \
		--link $(Mysql_Nom_Container):$(Php_Nom_Interne_Mysql) \
		--name $(Php_Nom_Container) $(Nom_Php_Construit):latest
	@echo "──────────────────────────────────"
	@echo "Les logs de php seront écrit dans : [$(Php_Fichier_Log_Ext)] "
	@echo "──────────────────────────────────"

# Démarrage du serveur nginx avec ces fichiers de configurations;
# un accès au sources du site; et des logs accessible sans avoir à
# se connecter au docker.
.PHONY: run_nginx
run_nginx: verifier_nginx
	docker run --detach \
		--publish $(Nginx_Port_Externe):$(Nginx_Port_Interne) \
		-v $(Chemin_Localtime_Ext):$(Chemin_Localtime_Int):ro \
		-v $(Time_Zone_Ext):$(Time_Zone_Int):ro \
		-v $(Nginx_Site_Externe):$(Nginx_Site_Interne):ro \
		-v $(Nginx_Config_Externe):$(Nginx_Config_Interne):ro \
		-v $(Nginx_Conf_Global_Ext):$(Nginx_Conf_Global_Int):ro \
		-v $(Nginx_Log_Externe):$(Nginx_Log_Interne) \
		--link $(Mysql_Nom_Container):$(Nginx_Nom_Interne_Mysql) \
		--link $(Php_Nom_Container):$(Nginx_Nom_Interne_Php) \
		--name $(Nginx_Nom_Container) nginx:stable-alpine
	@echo "──────────────────────────────────────"
	@echo "Les logs de nginx seront écrits dans : [$(Nginx_Log_Externe)] "
	@echo "──────────────────────────────────────"

# -------------------------------------- #
# Démarrer les conteneurs déjà construit #
# -------------------------------------- #

.PHONY: start
start: start_mysql start_php start_nginx

.PHONY: start_mysql
start_mysql:
	@echo "──────────────────"
	@echo "Démarrage de MySql"
	@echo "──────────────────"
	docker start $(Mysql_Nom_Container)

.PHONY: start_php
start_php:
	@echo "────────────────"
	@echo "Démarrage de PHP"
	@echo "────────────────"
	docker start $(Php_Nom_Container)

.PHONY: start_nginx
start_nginx:
	@echo "──────────────────"
	@echo "Démarrage de NginX"
	@echo "──────────────────"
	docker start $(Nginx_Nom_Container)

# ------------------------------------- #
# Connections à un conteneur déjà lancé #
# ------------------------------------- #

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

# --------------------------------- #
# Consulter les logs des conteneurs #
# --------------------------------- #

# Pour pouvoir inspecter facilement le container mysql en cours d'exécution
.PHONY: logs_mysql
logs_mysql:
	docker logs $(Mysql_Nom_Container)

# Pour pouvoir inspecter facilement le container php en cours d'exécution
.PHONY: logs_php
logs_php:
	docker logs $(Php_Nom_Container)

# Pour pouvoir inspecter facilement le container nginx en cours d'exécution
.PHONY: logs_nginx
logs_nginx:
	docker logs $(Nginx_Nom_Container)

# --------------------------------- #
#    Exécuter les tests unitaire    #
# --------------------------------- #

.PHONY: unitaire_php
unitaire_php:
	-docker run --rm \
		-v $(PhpUnit_Src_Unit_Ext):$(PhpUnit_Src_Unit_Int):ro \
		-v $(Php_Src_Ext):$(Php_Src_Int):ro \
		-v $(PhpUnit_Logs_Externe):$(PhpUnit_Logs_Interne) \
		phpunit/phpunit -c ./phpunit.xml
	@echo "───────────────────────────────────────────"
	@echo "Les résultats détaillé des tests unitaire : [$(PhpUnit_Logs_Externe)] "
	@echo "La couverture des tests unitaires : file://$(PhpUnit_Logs_Externe)/coverage/index.html"
	@echo "Résumé html des tests réussi et raté : file://$(PhpUnit_Logs_Externe)/logs/dox.html"
	@echo "───────────────────────────────────────────"

# --------------------------------- #
#      Générer la documentation     #
# --------------------------------- #

# La construction de l'image n'est lancée que si elle n'existe pas.
.PHONY: construire_doc
construire_doc:
ifeq ($(shell docker images -q $(Nom_Doc_Php_Construit) ), )
	docker build --tag $(Nom_Doc_Php_Construit) $(srcdir)/Fichiers_Configuration/conf_documentation/
endif

.PHONY: generer_doc
generer_doc: construire_doc
	docker run --rm \
		-v $(Documentation_Src_Ext):$(Documentation_Src_Int):ro \
		-v $(Documentation_Res_Ext):$(Documentation_Res_Int) \
		$(Nom_Doc_Php_Construit) -c $(Documentation_Src_Int)/phpdoc.xml
	@echo "───────────────────────────"
	@echo "Documentation généré dans : [$(Documentation_Res_Ext)]"
	@echo "Page d'accueil : file://$(Documentation_Res_Ext)/index.html"
	@echo "───────────────────────────"

# --------------------------------- #

# Permet de créer un dump des bases de données
.PHONY: dump_bdd
dump_bdd:
	mkdir -p $(Chemin_Repo)/Dump_BDD/
	docker exec $(Mysql_Nom_Container) sh -c \
		'exec mysqldump --databases $(Mysql_Nom_Bdd) -uroot -p"$(Mysql_Mdp_Root)"' \
		> $(Chemin_Repo)/Dump_BDD/bdd_site_asso_dump.sql
