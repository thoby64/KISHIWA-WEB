# Multi-stage build for Laravel application
FROM php:8.4-fpm-alpine AS builder

# Install system dependencies
RUN apk add --no-cache \
    build-base \
    curl \
    git \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    zlib-dev \
    libzip-dev \
    oniguruma-dev \
    sqlite-dev \
    postgresql-dev \
    mysql-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-webp && \
    docker-php-ext-install \
    gd \
    mbstring \
    zip \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    opcache \
    bcmath \
    ctype \
    fileinfo

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock* ./

# Install PHP dependencies without Laravel scripts until the app files exist.
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Run Laravel's Composer scripts now that artisan and the app are available.
RUN composer dump-autoload --optimize

# Copy package files
COPY package.json package-lock.json* ./

# Install npm dependencies and build assets
RUN npm install && npm run build

# Generate Laravel application key (if not set in env)
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions && \
    chmod -R 775 storage bootstrap/cache

# Production stage
FROM php:8.4-fpm-alpine

# Install runtime dependencies only
RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    libwebp \
    libzip \
    postgresql-libs \
    sqlite-libs \
    curl \
    nginx

# Copy PHP extensions from builder stage
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Copy PHP-FPM configuration
COPY --chown=www-data:www-data docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY --chown=www-data:www-data docker/php.ini /usr/local/etc/php/conf.d/php.ini

# Copy Nginx configuration template
COPY --chown=www-data:www-data docker/nginx.conf.template /etc/nginx/nginx.conf.template

# Copy start script
COPY --chown=www-data:www-data docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Set working directory
WORKDIR /app

# Copy application from builder stage
COPY --from=builder --chown=www-data:www-data /app /app

# Create necessary directories
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions && \
    chown -R www-data:www-data storage bootstrap/cache public

# Expose default port (Render provides $PORT at runtime)
EXPOSE 10000

# Health check (shell form so $PORT expands)
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
  CMD sh -c "curl -f http://localhost:${PORT:-10000}/health || exit 1"

# Use start script to substitute config and run services
CMD ["/usr/local/bin/start.sh"]
