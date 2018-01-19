# vim: set nospell:
# docker build -t nomcontainer .

FROM php:7.2.1-alpine
MAINTAINER PIVARD Julien <pivardjulien@gmail.com>

# Based on https://hub.docker.com/r/instrumentisto/phpdoc/
# Install phpDocumentor executable
ADD https://github.com/phpDocumentor/phpDocumentor2/releases/download/v2.9.0/phpDocumentor.phar \
    /usr/local/bin/phpdoc

RUN chmod 755 /usr/local/bin/phpdoc \
    && apk add --update --no-cache \
            graphviz \
            icu-libs libxslt \
    && apk add --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/testing \
            gnu-libiconv \
    && apk add --no-cache --virtual .build-deps \
            icu-dev libxslt-dev \
    && docker-php-ext-install intl xsl \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/*

# On remplace iconv qui pose problème avec libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

VOLUME ["/app"]
WORKDIR /app

ENTRYPOINT ["/usr/local/bin/phpdoc"]
