git pull -p
php composer.phar install
php composer.phar dump-autoload --no-dev --classmap-authoritative
php bin/console c:c
