#!/bin/sh
set -e

# Default port if not set by Render
: ${PORT:=10000}

# Generate nginx config from template
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

# Ensure storage logs exist
mkdir -p /app/storage/logs
chown -R www-data:www-data /app/storage

# Start php-fpm and nginx
php-fpm &
nginx -g 'daemon off;'
