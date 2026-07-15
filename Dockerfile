# Multi-stage build for Laravel application
FROM php:8.2-fpm-alpine AS builder

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
    docker-php-ext-install -j$(nproc) \
    gd \
    mbstring \
    zip \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    opcache \
    bcmath \
    ctype \
    fileinfo \
    json

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock* ./

# Install PHP dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy application files
COPY . .

# Copy package files
COPY package.json package-lock.json* ./

# Install npm dependencies and build assets
RUN npm install && npm run build

# Generate Laravel application key (if not set in env)
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions && \
    chmod -R 775 storage bootstrap/cache

# Production stage
FROM php:8.2-fpm-alpine

# Install runtime dependencies only
RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    libwebp \
    libzip \
    postgresql-libs \
    mysql-libs \
    sqlite-libs \
    curl \
    nginx

# Install PHP extensions (runtime only)
RUN docker-php-ext-configure gd --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) \
    gd \
    mbstring \
    zip \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    opcache \
    bcmath \
    ctype \
    fileinfo \
    json

# Copy PHP-FPM configuration
COPY --chown=www-data:www-data docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY --chown=www-data:www-data docker/php.ini /usr/local/etc/php/conf.d/php.ini

# Copy Nginx configuration
COPY --chown=www-data:www-data docker/nginx.conf /etc/nginx/nginx.conf

# Set working directory
WORKDIR /app

# Copy application from builder stage
COPY --from=builder --chown=www-data:www-data /app /app

# Create necessary directories
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions && \
    chown -R www-data:www-data storage bootstrap/cache public

# Expose port
EXPOSE 10000

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:10000/health || exit 1

# Start PHP-FPM and Nginx
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
