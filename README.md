<p align="center">
  <img src="https://cdn.sticknologic.is-a.dev/payus-aas/banner.png" width="800" alt="Banner" width="70%"/>
</p>

# 💸 PayUs-as-a-Service
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-blue)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red)](https://laravel.com)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

> **📖 [Full Documentation](../../wiki)** | **🚀 [Getting Started](../../wiki/Getting-Started)** | **📚 [API Reference](../../wiki/API-Reference)**

Does it ever happen in your career or personal life that you need to collect money someone owes you? Are you shy, out of words, or don't know how to ask or what tone to use?

Should it be Professional, Friendly, Frank, Funny, or Playful?

This project will perfectly solve (I hope) the questions above.

## About

PayUs-as-a-Service (PUaaS) is an API that returns randomized messages for past-due invoices — perfectly suited for any scenario: personal, professional, dev life, or just your everyday life.

Built for thick-faced, ghost, and shameless clients.

<!-- sponsor here -->
<!-- GitAds-Verify: AKZ9GHHCV9DNI2JZ17D3P7598WKKVQAL -->
## GitAds Sponsored
[![Sponsored by GitAds](https://gitads.dev/v1/ad-serve?source=sticknologic/payus-as-a-service@github)](https://gitads.dev/v1/ad-track?source=sticknologic/payus-as-a-service@github)


## API Usage

**Live API:** https://puaas.sticknologic.is-a.dev

**Interactive Documentation:** https://puaas.sticknologic.is-a.dev/docs

**Method:** `GET`

**Rate Limit:** `60 requests per minute per IP`

### API Endpoints
| Method | Endpoint            | Auth | Description                             | Rate Limit |
|--------|---------------------|------|-----------------------------------------|------------|
| GET    | /payus              | No   | Get a randomized message in random tone | 60/min     |
| GET    | /payus/professional | No   | Get random professional message         | 60/min     |
| GET    | /payus/frank        | No   | Get random frank message                | 60/min     |
| GET    | /payus/friendly     | No   | Get random friendly message             | 60/min     |
| GET    | /payus/playful      | No   | Get random playful message              | 60/min     |
| GET    | /payus/funny        | No   | Get random funny message                | 60/min     |
| GET    | /payus/tones        | No   | Get available tones                     | 60/min     |

### Example Responses

**Success Response:**
```json
{
  "message": "string",
  "tone": "Professional"
}
```

**Error Response:**
```json
{
  "success": false,
  "message": "No messages found for the specified criteria.",
  "errors": "string"
}
```

**Available Tones Response:**
```json
{
  "success": true,
  "message": "Success",
  "data": {
    "tones": {
      "professional": "Professional",
      "friendly": "Friendly",
      "frank": "Frank",
      "funny": "Funny",
      "playful": "Playful"
    }
  }
}
```

---

## Quick Start

### Try It Now (No Installation Required)

Test the API directly from your terminal:

```bash
# Get a random message with any tone
curl https://puaas.sticknologic.is-a.dev/payus

# Get a professional tone message
curl https://puaas.sticknologic.is-a.dev/payus/professional

# Get all available tones
curl https://puaas.sticknologic.is-a.dev/payus/tones
```

For complete API documentation with interactive examples, visit: **https://puaas.sticknologic.is-a.dev/docs**

---

## Self-Hosting

Want to run your own instance? It's lightweight and simple to set up.

### Requirements

Choose one of the following:

- **Option 1 (Recommended for Beginners):** Docker & Docker Compose
- **Option 2 (Advanced Users):** PHP 8.3+, Composer 2.x, MySQL/SQLite

### Installation with Docker (Recommended)

**Step 1:** Clone the repository
```bash
git clone https://github.com/sticknologic/payus-as-a-service.git
cd payus-as-a-service
```

**Step 2:** Set up environment files
```bash
cp .env.example .env
```

**Step 3:** Build and start Docker containers
```bash
docker compose build
docker compose up -d
```

**Step 4:** Generate application security key
```bash
docker compose run --rm app php artisan key:generate
```

**Step 5:** (Opttional) Run tests to verify everything works
```bash
docker compose run --rm app ./vendor/bin/pest
```

**Step 6:** Access your API
- API: `http://localhost:9006/payus`
- Documentation: `http://localhost:9006/docs`

### Installation without Docker (Advanced)

**Step 1:** Clone and install dependencies
```bash
git clone https://github.com/sticknologic/payus-as-a-service.git
cd payus-as-a-service
composer install
```

**Step 2:** Configure environment
```bash
cp .env.example .env
```

**Step 3:** Set up database (SQLite by default - easiest option)
```bash
touch database/database.sqlite
php artisan migrate:fresh --seed --force
```

**Step 4:** Run tests to verify
```bash
./vendor/bin/pest
```

**Step 5:** Start the development server
```bash
php artisan serve
```

**Step 6:** Access your API
- API: `http://localhost:8000/payus`
- Documentation: `http://localhost:8000/docs`

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
└── messages.json                          # 1500 messages (300 messages per tone)
```

## Development Commands

**View all available API routes:**
```bash
docker compose run --rm app php artisan route:list
```

**Clear all caches (useful after config changes):**
```bash
docker compose run --rm app php artisan optimize:clear
```

**Run code quality checks (Pint, Rector, PHPStan, Tests):**
```bash
docker compose run --rm app composer test
```

**Generate IDE helper files (improves autocomplete in your editor):**
```bash
docker compose run --rm app php artisan ide-helper:generate
docker compose run --rm app php artisan ide-helper:models -N
```

**Export OpenAPI specification to file:**
```bash
docker compose run --rm app php artisan scramble:export
```

## Environment Configuration

Key `.env` variables for self-hosting:

```env
# Application Settings
APP_NAME="PayUs-as-a-Service"
APP_ENV=local                    # Use 'production' for live deployment
APP_DEBUG=true                   # Set to 'false' in production
APP_URL=http://localhost:9006    # Your API URL

# Database (SQLite for development - easiest option)
DB_CONNECTION=sqlite
DB_DATABASE=/var/www/database/database.sqlite

# For MySQL/PostgreSQL (recommended for production)
# DB_CONNECTION=mysql
# DB_HOST=mysql
# DB_PORT=3306
# DB_DATABASE=payus_db
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# API Configuration
API_VERSION_STRATEGY=uri
API_DEFAULT_VERSION=latest

# Rate Limiting (requests per minute per IP)
API_RATE_LIMIT=60
```

## Deployment to Production

### Production Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`
- [ ] Configure a production database (MySQL/PostgreSQL recommended)
- [ ] Set `APP_URL` to your actual domain (e.g., `https://api.yourdomain.com`)
- [ ] Review and adjust CORS settings in `config/cors.php`
- [ ] Adjust rate limiting in `config/apiroute.php` based on your needs
- [ ] Set up Redis for caching (optional but recommended)
- [ ] Configure queue workers for background jobs (if needed)
- [ ] Enable HTTPS/SSL certificates
- [ ] Set up proper monitoring and logging

### Quick Deploy with Docker

Your `docker-compose.yml` already includes Nginx for production use.

**Step 1:** Update `.env` and `.env.db` with production settings

**Step 2:** Build and start containers
```bash
docker compose up -d --build
```

**Step 3:** Your API will be available on port 9006

**Step 4:** Point your reverse proxy (Caddy/Nginx) to the container

**Example Caddy configuration:**
```
api.yourdomain.com {
    reverse_proxy localhost:9006
}
```

**Example Nginx configuration:**
```nginx
server {
    listen 80;
    server_name api.yourdomain.com;

    location / {
        proxy_pass http://localhost:9006;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
```

## Projects Using PayUs-as-a-Service

Here are some projects made by our **BRAVE** developers that integrate PayUs-as-a-Service to deliver their dismay, despair, and disappointment via past-due invoice messages:

- **Your Project Here?** If you're using PayUs-as-a-Service in your project, [open a pull request](https://github.com/sticknologic/payus-as-a-service/pulls) to be featured here!

## Contributing

We welcome contributions! Here's how you can help:

**Step 1:** Fork the repository

**Step 2:** Create your feature branch
```bash
git checkout -b feature/amazing-feature
```

**Step 3:** Make your changes and test them
```bash
composer test
```

**Step 4:** Commit your changes
```bash
git commit -m 'Add amazing feature'
```

**Step 5:** Push to the branch
```bash
git push origin feature/amazing-feature
```

**Step 6:** Open a Pull Request

### Ideas for Contributions
- Add more message variations to `messages.json`
- Improve documentation
- Add new language translations
- Fix bugs or improve performance
- Add new API features or tone categories

## Author

Created with a broken heart and torn wallet by [STICKnoLOGIC](https://sticknologic.is-a.dev)

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Credits

- [Laravel](https://laravel.com) - The PHP Framework
- [Laravel-API-Kit](https://github.com/grazulex/laravel-api-kit) - The laravel Boiler Plate
- [spatie/laravel-query-builder](https://github.com/spatie/laravel-query-builder) - Query Building
- [spatie/laravel-data](https://github.com/spatie/laravel-data) - Data Transfer Objects
- [dedoc/scramble](https://github.com/dedoc/scramble) - API Documentation
- [Pest PHP](https://pestphp.com) - Testing Framework

## Support & Help

Need help? Here are your options:

- **📚 Interactive API Docs:** [https://puaas.sticknologic.is-a.dev/docs](https://puaas.sticknologic.is-a.dev/docs)
- **📖 Wiki & Guides:** [GitHub Wiki](https://github.com/sticknologic/payus-as-a-service/wiki)
- **🐛 Bug Reports:** [GitHub Issues](https://github.com/sticknologic/payus-as-a-service/issues)
- **💬 Discussions:** [GitHub Discussions](https://github.com/sticknologic/payus-as-a-service/discussions)
- **❓ Questions:** Open a [discussion](https://github.com/sticknologic/payus-as-a-service/discussions/new?category=q-a)
