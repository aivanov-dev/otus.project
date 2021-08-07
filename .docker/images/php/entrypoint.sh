cd /var/www

composer install
grep -q "^APP_KEY=base64" .env || php artisan key:generate

/usr/bin/supervisord
