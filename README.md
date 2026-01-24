![Banner](https://cdn.sticknologic.is-a.dev/payus-aas/banner.png)

# 💸 PayUs-as-a-Service
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-blue)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red)](https://laravel.com)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

Does it come to your career/life that you need to collect something they owe you? or are you shy or out of word and dont know how and what to said?

You dont know what tone are you going to use. is Profesional, Friendly, Frank, Funny or Playful?

This project will perfectly solve(I hope) the questions above.

## About
PayUs-as-a-Service (PUaaS) is an API that returns randomized messages for past-due invoices — Perfectly suited for any scenario: personal, Professional, dev life or just your life.

Built for thick-faced, Ghost and shameless clients.

<!-- sponsor here -->
<!-- GitAds-Verify: AKZ9GHHCV9DNI2JZ17D3P7598WKKVQAL -->
## GitAds Sponsored
[![Sponsored by GitAds](https://gitads.dev/v1/ad-serve?source=sticknologic/payus-as-a-service@github)](https://gitads.dev/v1/ad-track?source=sticknologic/payus-as-a-service@github)


## API Usage
Base URL
```
https://puaas.sticknologic.is-a.dev
```
Method: `GET`

Rate Limit: `60 requests per minute per IP`

### Example Request
```
GET /payus
```

### Example Response
```json
{
  "message": "string",
  "tone": "Professional"
}
```

For more info, read our docs: https://puaas.sticknologic.is-a.dev/docs

## Self-Hosting

Want to run it yourself? It’s lightweight and simple.

### Requirements

- Docker & Docker Compose
- Or: PHP 8.3+, Composer 2.x

### With Docker (Recommended)

```bash
# Clone the repository
git clone https://github.com/sticknologic/payus-as-a-service.git
cd payus-as-a-service

# Copy environment file
cp .env.example .env

# Build and start containers
docker compose build
docker compose up -d

# Install dependencies
docker compose run --rm app composer install

# Generate application key
docker compose run --rm app php artisan key:generate

# Run migrations
docker compose run --rm app php artisan migrate:fresh --seed --force

# Run tests to verify installation
docker compose run --rm app ./vendor/bin/pest
```

### Without Docker

```bash
# Clone and install
git clone https://github.com/sticknologic/payus-as-a-service.git
cd payus-as-a-service
composer install

# Configure
cp .env.example .env
php artisan key:generate

# Database (SQLite by default)
touch database/database.sqlite
php artisan migrate:fresh --seed --force

# Verify
./vendor/bin/pest
```

### HTTP Status Codes

| Code | Description |
|------|-------------|
| 200  | Success |
| 201  | Resource created |
| 204  | No content |
| 400  | Bad request |
| 401  | Unauthorized |
| 403  | Forbidden |
| 404  | Not found |
| 422  | Validation error |
| 429  | Too many requests |
| 500  | Server error |

## Project Structure

```
laravel-api-kit/
├── app/
│   ├── Actions/                    
│   ├── DTOs/                       
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── ApiController.php      # Base controller with ApiResponse
│   │   │       └── V1/                    # Version 1 controllers
│   │   │           └── PayUsController.php  
│   │   ├── Requests/
│   │   │   └── GetMessageRequest
│   │   └── Resources/                     # API Resources
│   │       └── MessageResource.php
│   ├── Models/
|   |   ├── Message.php
│   │   └── User.php                       
│   ├── Providers/
│   │   └── AppServiceProvider.php         # Rate limiting config
│   ├── Services/                          # Business logic services
│   └── Traits/
│       └── ApiResponse.php                # Standardized responses
├── config/
│   ├── apiroute.php                       # API versioning config
│   ├── cors.php                           # CORS settings
│   ├── sanctum.php                        # Token auth config
│   └── scramble.php                       # API docs config
├── database/*                              # Migrations and seeder
├── resources/views/
│   └── welcome.blade.php                  # Home
├── routes/
│   ├── api.php                            # API routes entry point
│   └── web.php
├── tests/
│   └── Feature/
│       └── PayUsTest.php                   # API tests
├── docker-compose.yml
├── Dockerfile
├── CLAUDE.md                              # AI assistant instructions
└── messages.json                          # 1500 messages (300 messages per tone)
```

## Development Commands

```bash
# List all routes
docker compose run --rm app php artisan route:list

# Clear all caches
docker compose run --rm app php artisan optimize:clear

# Generate IDE helper files (if using Laravel IDE Helper)
docker compose run --rm app php artisan ide-helper:generate
docker compose run --rm app php artisan ide-helper:models -N

# Export OpenAPI spec to file
docker compose run --rm app php artisan scramble:export
```

## Environment Configuration

Key `.env` variables:

```env
# Application
APP_NAME="Laravel API Kit"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080

# Database (SQLite for development)
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite

# For MySQL/PostgreSQL
# DB_CONNECTION=mysql
# DB_HOST=mysql
# DB_PORT=3306
# DB_DATABASE=laravel_api_kit
# DB_USERNAME=laravel
# DB_PASSWORD=secret

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1

# API Versioning
API_VERSION_STRATEGY=uri
API_DEFAULT_VERSION=latest

# Rate Limiting
API_RATE_LIMIT=60

# Documentation
API_DOCS_URL=http://localhost:8080/docs/api
```

## Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Configure proper database (MySQL/PostgreSQL)
- [ ] Set `APP_URL` to your production URL
- [ ] Configure `SANCTUM_STATEFUL_DOMAINS` for your frontend domains
- [ ] Review and tighten CORS settings in `config/cors.php`
- [ ] Set up proper rate limiting for production load
- [ ] Configure caching (Redis recommended)
- [ ] Set up queue worker for background jobs
- [ ] Enable HTTPS and update URLs

### Docker Production

```dockerfile
# Example production Dockerfile additions
FROM php:8.3-fpm-alpine

# Install opcache for performance
RUN docker-php-ext-install opcache

# Production PHP settings
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/
COPY docker/php/php.ini /usr/local/etc/php/conf.d/
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Credits

- [Laravel](https://laravel.com) - The PHP Framework
- [Laravel-API-Kit](https://github.com/grazulex/laravel-api-kit) - The laravel Boiler Plate
- [spatie/laravel-query-builder](https://github.com/spatie/laravel-query-builder) - Query Building
- [spatie/laravel-data](https://github.com/spatie/laravel-data) - Data Transfer Objects
- [dedoc/scramble](https://github.com/dedoc/scramble) - API Documentation
- [Pest PHP](https://pestphp.com) - Testing Framework

## Support

- [Documentation](https://github.com/sticknologic/payus-as-a-service/wiki)
- [Issues](https://github.com/sticknologic/payus-as-a-service/issues)
- [Discussions](https://sticknologic/payus-as-a-service/discussions)
