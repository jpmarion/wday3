#!/bin/bash

echo Clear Cache
sudo php artisan cache:clear
echo Clear Route
php artisan route:clear
echo Clear Config
php artisan config:clear
echo Clear  View
php artisan view:clear
