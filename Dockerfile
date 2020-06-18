FROM php:zts-alpine

COPY . /app/

RUN cd /usr/bin/ && wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet

WORKDIR /app

RUN apk add libzip-dev bash 

RUN wget https://get.symfony.com/cli/installer -O - | bash

ENV PATH="$HOME/.symfony/bin:$PATH"

RUN docker-php-ext-install zip

RUN php -d memory_limit=-1 /usr/bin/composer.phar require doctrine/annotations

RUN php -d memory_limit=-1 /usr/bin/composer.phar install

ENTRYPOINT php bin/console server:run 0.0.0.0:8000
