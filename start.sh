#!/bin/bash
set -e

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Seeding default users ==="
php artisan db:seed --class=DefaultUsersSeeder --force

echo "=== Starting server ==="
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
