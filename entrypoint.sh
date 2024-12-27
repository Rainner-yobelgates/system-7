#!/bin/sh

# Run database migrations
php artisan storage:link
php artisan migrate --force

# Start Apache in the foreground
apache2-foreground
