#!/bin/sh
set -e

echo "Deploying application ..."

php artisan app:update

echo "Application deployed!"
