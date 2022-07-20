#!/bin/sh

composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan queue:work --tries=3 &
php artisan cache:clear
composer dump-autoload
