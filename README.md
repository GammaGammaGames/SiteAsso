# Allumage du serveur

Prérequis :
* **docker**;
* **make** ou **GNU make**;

## Premier démarrage

Pour générer automatiquement la configuration des containers mariadb et
php. Les fichiers de configurations seront écrits dans le dossier
**Temporaire**.

```sh
./configure
```

Puis pour lancer les containers.

```sh
make
```
* Les fichiers généré par MariaDB sont écrit dans **Temporaire/MySql**
* Les fichiers de log de php sont dans **Temporaire/logs_php**
* Les fichiers de log de nginx sont dans **Temporaire/logs_nginx**
* Les logs de sql sont accessible via **docker logs sql_serveur**

## Stopper les conteneurs

La configuration sera conservée

```sh
make stop
```

## Démarrer les conteneurs

```sh
make start
```

## Pour supprimer les conteneurs et toutes les données générées

Tous les conteneurs seront stoppé et le dossier **Temporaire** sera
supprimé. Une confirmation sera demandée pour la suppression des bases de
données. Le script laisse une possibilité de sauvegarder les bases avant
de supprimer.

```sh
make clean; ./configure --clean
```

## Lancer les tests uitaire

```sh
make unitaire_php
```

## Générer la documentation

```sh
make generer_doc
```
