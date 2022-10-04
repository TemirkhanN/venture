FROM php:8.1-cli

RUN apt update && \
    apt install -y --no-install-recommends git

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

WORKDIR app

COPY ./ /app

RUN composer install --no-dev --prefer-dist --no-progress --optimize-autoloader

CMD php client/launch.php
