# vim: nofoldenable: list:
# PIVARD Julien
# Dernière modification : Samedi 20 janvier[01] 2018

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

.PHONY: help
help:
	@echo "- all         : Démarre ou crée les VM pour démarrer le site."
	@echo "    - run_ou_start"
	@echo "- run         : Démarre toutes les VM pour faire fonctionner le site."
	@echo "    - run_sql    : Spécifique à la VM mariadb"
	@echo "    - run_php    : Spécifique à la VM php"
	@echo "    - run_nginx  : Spécifique à la VM nginx"
	@echo "- start       : Démarre les VM nécessaires au fonctionnement du site."
	@echo "    - start_sql   : Spécifique à la VM mariadb"
	@echo "    - start_php   : Spécifique à la VM php"
	@echo "    - start_nginx : Spécifique à la VM nginx"
	@echo "- generer_doc : Génère la documentation php de l'application"
	@echo
	@echo "[ Tests unitaires ]"
	@echo " - unitaire   : Lance les tests unitaires"
	@echo "     - run_unitaire_sql   : Lance la VM destiné aux tests unitaires."
	@echo "     - run_unitaire_php   : Lance la VM des tests unitaires de php."
	@echo
	@echo "[ Logs ]"
	@echo " - logs_sql   : Affiche les logs de la VM mariadb"
	@echo " - logs_php   : Affiche les logs de la VM php"
	@echo " - logs_nginx : Affiche les logs de la VM nginx"
	@echo
	@echo "[ Connection aux VM ]"
	@echo " - connect_sql    : Connection à travers un bash à la VM mariadb"
	@echo " - connect_php    : Connection à travers un bash à la VM php"
	@echo " - connect_nginx  : Connection à travers un bash à la VM nginx"
	@echo
	@echo "[ Arret et suppression ]"
	@echo " - nettoyage : Supprime les containers qui ont été stoppé et les images intermédiaires."
	@echo " - stop      : Stop toutes les machines virtuelles en cours."
	@echo " - clean     : Stop toutes les VM et les supprime."
	@echo
	@echo "[ Autres ]"
	@echo " - construire_php : Construit la VM php si elle n'existe pas déjà."
	@echo " - construire_doc : Construit la VM de génération de la documentation php"
	@echo " - reload_nginx   : Force la VM nginx à recharger sa configuration."
	@echo " - dump_bdd       : Réalise un dump de la base de données."


Nom_D_Tmp		:= Fichiers_Généré_Par_Script
ifeq ($(wildcard $(Nom_D_Tmp)/*), )
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
	-docker stop $(Sql_Nom_Container)
	-docker stop $(Sql_U_Nom_Cont)

# Stoppe les machines virtuel et les supprimes toutes
.PHONY: clean
clean: stop
	-docker rm --force --volumes $(Nginx_Nom_Container)
	-docker rm --force --volumes $(Php_Nom_Container)
	-docker rm --force --volumes $(Sql_Nom_Container)
	-docker rm --force --volumes $(Sql_U_Nom_Cont)

.PHONY: all
all: run_ou_start

.PHONY: run_ou_start
run_ou_start: $(Start_Ou_Run_Sql) $(Start_Ou_Run_Php) $(Start_Ou_Run_Nginx)

# Affiche un avertissement si les docker sont déjà en cours d'exécution
.PHONY: info_sql
info_sql:
	$(info "Le container  Sql  est déjà en cours d'exécution.")

.PHONY: info_php
info_php:
	$(info "Le container  PHP  est déjà en cours d'exécution.")

.PHONY: info_nginx
info_nginx:
	$(info "Le container NginX est déjà en cours d'exécution.")

# --------------------------------- #

.PHONY: run
run: run_sql run_php run_nginx

# Permet de demander à nginx de relire ses fichiers de configurations
# sans avoir à redémarrer le container.
.PHONY: reload_nginx
reload_nginx:
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
.PHONY: run_sql
run_sql: verifier_sql
	docker run --detach \
		--publish $(Sql_Port_Exterieur):$(Sql_Port_Interne) \
		--env MYSQL_ROOT_PASSWORD='$(Sql_Mdp_Root)' \
		--env MYSQL_DATABASE='$(Sql_Nom_Bdd)' \
		--env MYSQL_USER='$(Sql_Utilisateur)' \
		--env MYSQL_PASSWORD='$(Sql_Pass_Utilisateur)' \
		-v $(Chemin_Localtime_Ext):$(Chemin_Localtime_Int):ro \
		-v $(Time_Zone_Ext):$(Time_Zone_Int):ro \
		-v $(Sql_Config_Externe):$(Sql_Config_Interne):ro \
		-v $(Sql_Init_Bdd_Externe):$(Sql_Init_Bdd_Interne):ro \
		-v $(Sql_Volume_Ext):$(Sql_Volume_Int) \
		--name $(Sql_Nom_Container) $(Sql_Nom_Image):$(Sql_Version_Image)
	@echo "──────────────────────────────────────────"
	@echo "Les bases de données seront écrites dans : [$(Sql_Volume_Ext)] "
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
		-v $(Php_Config_Sql_Ext):$(Php_Config_Sql_Int):ro \
		-v $(Php_Php_Ini_Externe):$(Php_Php_Ini_Interne):ro \
		-v $(Php_Fichier_Log_Ext):$(Php_Fichier_Log_Int) \
		--link $(Sql_Nom_Container):$(Php_Nom_Interne_Sql) \
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
		--link $(Sql_Nom_Container):$(Nginx_Nom_Interne_Sql) \
		--link $(Php_Nom_Container):$(Nginx_Nom_Interne_Php) \
		--name $(Nginx_Nom_Container) $(Nginx_Nom_Image):$(Nginx_Version_Image)
	@echo "──────────────────────────────────────"
	@echo "Les logs de nginx seront écrits dans : [$(Nginx_Log_Externe)] "
	@echo "──────────────────────────────────────"

# -------------------------------------- #
# Démarrer les conteneurs déjà construit #
# -------------------------------------- #

.PHONY: start
start: start_sql start_php start_nginx

.PHONY: start_sql
start_sql:
	@echo "────────────────────"
	@echo "Démarrage de MariaDB"
	@echo "────────────────────"
	docker start $(Sql_Nom_Container)

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

# Pour se connecter au docker sql lancé en daemon
.PHONY: connect_sql
connect_sql:
	docker exec --interactive --tty $(Sql_Nom_Container) /bin/sh

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

# Pour pouvoir inspecter facilement le container sql en cours d'exécution
.PHONY: logs_sql
logs_sql:
	docker logs $(Sql_Nom_Container)

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

.PHONY: unitaire
unitaire: $(Start_Ou_Run_Sql_U) run_unitaire_php

.PHONY: run_unitaire_sql
run_unitaire_sql:
	docker run --detach \
		--publish $(Sql_U_Port_Exterieur):$(Sql_U_Port_Interne) \
		--env MYSQL_ROOT_PASSWORD='$(Sql_Mdp_Root)' \
		--env MYSQL_DATABASE='$(Sql_Nom_Bdd)' \
		--env MYSQL_USER='$(Sql_Utilisateur)' \
		--env MYSQL_PASSWORD='$(Sql_Pass_Utilisateur)' \
		-v $(Chemin_Localtime_Ext):$(Chemin_Localtime_Int):ro \
		-v $(Time_Zone_Ext):$(Time_Zone_Int):ro \
		-v $(Sql_Config_Externe):$(Sql_Config_Interne):ro \
		-v $(Sql_Init_Bdd_Externe):$(Sql_Init_Bdd_Interne):ro \
		-v $(Sql_U_Volume_Ext):$(Sql_Volume_Int) \
		--name $(Sql_U_Nom_Cont) $(Sql_Nom_Image):$(Sql_Version_Image)

.PHONY: start_unitaire_sql
start_unitaire_sql:
	@echo "───────────────────────────────────────"
	@echo "Démarrage de MariaDB en tests unitaires"
	@echo "───────────────────────────────────────"
	docker start $(Sql_U_Nom_Cont)

.PHONY: info_sql_unitaire
info_sql_unitaire:
	$(info "Le container de tests unitaire sql est déjà en cours d'exécution.")

.PHONY: run_unitaire_php
run_unitaire_php: verifier_sql_unitaire
	-docker run --rm \
		-v $(Chemin_Localtime_Ext):$(Chemin_Localtime_Int):ro \
		-v $(Time_Zone_Ext):$(Time_Zone_Int):ro \
		-v $(PhpUnit_Src_Unit_Ext):$(PhpUnit_Src_Unit_Int):ro \
		-v $(Php_Src_Ext):$(Php_Src_Int):ro \
		-v $(Php_Config_Sql_Ext):$(Php_Config_Sql_Int):ro \
		-v $(PhpUnit_Logs_Externe):$(PhpUnit_Logs_Interne) \
		--link $(Sql_U_Nom_Cont):$(Php_Nom_Interne_Sql) \
		$(PhpUnit_Nom_Image):$(PhpUnit_Version_Image) -c ./phpunit.xml
	@echo "───────────────────────────────────────────"
	@echo "Les résultats détaillé des tests unitaire : [$(PhpUnit_Logs_Externe)] "
	@echo "La couverture des tests unitaires         : file://$(PhpUnit_Logs_Externe)/coverage/index.html"
	@echo "Résumé html des tests réussi et raté      : file://$(PhpUnit_Logs_Externe)/logs/dox.html"
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
	docker exec $(Sql_Nom_Container) sh -c \
		'exec mysqldump --databases $(Sql_Nom_Bdd) -uroot -p"$(Sql_Mdp_Root)"' \
		> $(Chemin_Repo)/Dump_BDD/bdd_site_asso_dump.sql
