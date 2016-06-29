## Base image
FROM alpine:latest

## Copy modified PHP files into container
COPY . /php-react

## Set working directory
WORKDIR /php-react

## Install PHP
RUN apk apk update && \
    apk upgrade && \
    apk add --update tzdata && \
    apk add git && \
    apk add --update php-common php-json php-curl php-pdo php-pdo_sqlite php-phar php-cli php-openssl php-ctype php-mcrypt && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

## Install ReactPHP and PIMF micro frameworks
RUN curl -s http://getcomposer.org/installer | php
RUN php composer.phar update
RUN php composer.phar install
RUN php composer.phar dump-autoload --optimize

## Expose port
EXPOSE 666

## Run the reactive API server
ENTRYPOINT php run-server.php
