enemy, player, character, equipment, fight
dungeon->battles


docker run --rm -v ${PWD}:/app -p 8080:8080 -it php:8.1-cli bash

curl -sS https://getcomposer.org/installer | php \
&& mv composer.phar /usr/local/bin/ \
&& ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

php -S 172.17.0.2:8080 -t client client/launch.php
