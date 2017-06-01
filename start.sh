#!/bin/bash

cd DockerImages
docker-compose build
docker-compose up -d
docker pull composer/composer  

rm -f /usr/local/bin/composer  /usr/local/bin/php 
ln -s $PWD/composer.sh /usr/local/bin/composer  
ln -s $PWD/php.sh /usr/local/bin/php 

cd ../workspace/assignment
cp .env.example .env
composer install
php artisan migrate:install
php artisan migrate

php artisan db:seed

vendor/bin/phpunit