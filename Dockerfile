FROM serversideup/php:8.4-fpm-nginx-alpine

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy sample.env.db file to the container
RUN [ -f .env.db ] || cp sample.env.db .env.db

# copy env file to the container
RUN [ -f .env ] || cp .env.example .env

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies (optimized for production)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Fix permissions (Laravel)
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 storage bootstrap/cache