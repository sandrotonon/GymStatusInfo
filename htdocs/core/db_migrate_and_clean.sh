#!/bin/bash
rm -f database/migrations/*entrust*.php
php artisan entrust:migration
composer dump-autoload
php artisan migrate:refresh
php artisan db:seed