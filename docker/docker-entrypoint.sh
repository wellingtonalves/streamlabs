#!/bin/bash


/usr/bin/supervisord
service supervisor restart
/etc/init.d/cron restart
composer install
php artisan key:generate
php artisan migrate:fresh
php artisan passport:install
php artisan db:seed
chmod -R 777 ./storage

if ! [ -f ".env" ]; then
  cp .env.example .env
fi

if ! [ -d "./node_modules" ]; then
  npm install
  npm run dev
fi



php artisan serve --host=0.0.0.0 --port=8000
