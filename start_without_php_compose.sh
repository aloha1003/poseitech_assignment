#!/bin/bash

cd DockerImages
docker-compose build
docker-compose up -d
docker pull composer/composer  


cd ../workspace/assignment
cp .env.example .env
composer install
php artisan migrate:install
php artisan migrate

php artisan db:seed

vendor/bin/phpunit