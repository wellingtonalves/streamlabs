#!/bin/bash

chmod 777 -R storage &&
/usr/bin/supervisord &&
service supervisor restart &&
/etc/init.d/cron restart &&
composer install &&
cp .env.example .env &&
php artisan key:generate &&
php artisan migrate:fresh &&
php artisan passport:install &&
php artisan db:seed &&
npm install &&
npm run dev &&

php artisan serve --host=0.0.0.0 --port=8000
