release: php bin/console doctrine:migrations:migrate --no-interaction
web: vendor/bin/heroku-php-nginx -C heroku/nginx_host.conf public/