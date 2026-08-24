# ------------------------------------------------------------
# Stage 1: Build frontend assets
# ------------------------------------------------------------
# Node is only needed during the build process.
# It is not included in the final PHP image.
FROM node:22-alpine AS frontend

# Working directory used during the frontend build.
WORKDIR /app

# Copy package files first so Docker can reuse the npm
# dependency layer when the application code changes.
COPY package*.json ./

# Install the exact dependencies defined in package-lock.json.
RUN npm ci

# Copy the files required by Vite to build the frontend.
COPY resources ./resources
COPY vite.config.js ./
COPY public ./public

# Generate the production CSS and JavaScript assets.
# The resulting files are created under public/build/.
RUN npm run build


# ------------------------------------------------------------
# Stage 2: Laravel application
# ------------------------------------------------------------
# PHP is the runtime used by the Laravel application.
FROM php:8.3-cli

# Install system dependencies and PHP extensions required
# by Laravel and PostgreSQL.
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    && docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    mbstring \
    bcmath \
    intl \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer from the official Composer image.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set the application working directory.
WORKDIR /var/www/html

# Copy Composer files first.
# This allows Docker to reuse the dependency layer when only
# application source files change.
COPY composer.json composer.lock ./

# Install Laravel's production PHP dependencies.
# Development packages and interactive prompts are excluded.
RUN composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# Copy the Laravel application source code.
COPY . .

# Run Laravel package discovery after the application files,
# including artisan, have been copied into the image.
RUN php artisan package:discover --ansi

# Copy the production frontend assets generated in Stage 1.
# This allows Laravel to serve CSS and JavaScript without
# running Vite in development mode.
COPY --from=frontend /app/public/build ./public/build

# Document the port used by Laravel.
EXPOSE 8000

# Start the Laravel application.
# Render will use this process to serve the public application.
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]