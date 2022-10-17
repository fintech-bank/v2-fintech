#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true
    # Update codebase
    git fetch origin production
    git reset --hard origin/production

    # Install dependencies based on lock file
    composer install --no-interaction --prefer-dist --optimize-autoloader

    # Migrate database
    php artisan system:seed --base

    # Note: If you're using queue workers, this is the place to restart them.
    # ...
    screen -dmS schedule php artisan schedule:work
	screen -dmS queue php artisan queue:work

    # Clear cache
    php artisan optimize

    # Reload PHP to update opcache
    echo "" | sudo -S service php8.1-fpm reload
# Exit maintenance mode
php artisan up

echo "Application deployed!"
