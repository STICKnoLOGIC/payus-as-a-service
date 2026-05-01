FROM serversideup/php:8.4-fpm-nginx-alpine

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY --chown=coolify:coolify . .

# copy env file to the container
RUN [ -f .env ] || cp .env.example .env


# Install PHP dependencies (optimized for production)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Fix permissions (Laravel)
RUN chown -R coolify:coolify /var/www/html && chmod -R 775 storage bootstrap/cache