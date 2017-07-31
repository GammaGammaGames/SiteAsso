# vim: set nospell:
# docker build -t nomcontainer .

FROM php:fpm-alpine
MAINTAINER PIVARD Julien pivardjulien@gmail.com

# Permet d'exécuter une suite de commande shell
#RUN commande
RUN ["docker-php-ext-install", "pdo_mysql"]
