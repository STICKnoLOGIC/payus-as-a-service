# Self-Hosting Guide

Complete guide to running your own instance of PayUs-as-a-Service.

## Why Self-Host?

- **Privacy:** Keep all data on your own servers
- **Customization:** Add your own messages and tones
- **No Rate Limits:** Control your own rate limiting
- **Reliability:** Don't depend on external services

## Requirements

Choose one of the following:

### Option 1: Docker (Recommended)
- Docker 20.10+
- Docker Compose 2.0+
- 1GB RAM
- 5GB disk space

### Option 2: Manual Installation
- PHP 8.3+
- Composer 2.x
- MySQL 8.0+ or PostgreSQL 13+ (SQLite also supported)
- Nginx or Apache (optional)

---

## Installation with Docker

### Step 1: Clone the Repository

```bash
git clone https://github.com/sticknologic/payus-as-a-service.git
cd payus-as-a-service
```

### Step 2: Configure Environment

Copy the example environment files:

```bash
cp .env.example .env
cp sample.env.db .env.db
```

Edit `.env` and configure these key variables:

```env
APP_NAME="PayUs-as-a-Service"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=mysql_puaas
DB_PORT=3306
DB_DATABASE=db_puaas
DB_USERNAME=sticknologic
DB_PASSWORD=your_secure_password
```

### Step 3: Build and Start Containers

```bash
docker compose build
docker compose up -d
```

### Step 4: Install Dependencies

```bash
docker compose run --rm app composer install --no-dev --optimize-autoloader
```

### Step 5: Generate Application Key

```bash
docker compose run --rm app php artisan key:generate
```

### Step 6: Run Database Migrations

```bash
docker compose run --rm app php artisan migrate --force
docker compose run --rm app php artisan db:seed --force
```

### Step 7: Optimize for Production

```bash
docker compose run --rm app php artisan config:cache
docker compose run --rm app php artisan route:cache
docker compose run --rm app php artisan view:cache
```

### Step 8: Access Your API

Your API is now running at:
- **API:** http://localhost:9006
- **Docs:** http://localhost:9006/docs

---

## Installation without Docker

### Step 1: Install Dependencies

```bash
git clone https://github.com/sticknologic/payus-as-a-service.git
cd payus-as-a-service
composer install --no-dev --optimize-autoloader
```

### Step 2: Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# For SQLite (simplest)
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite

# Or for MySQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=payus_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 3: Set Up Database

For SQLite:
```bash
touch database/database.sqlite
```

For MySQL, create the database first, then run:

```bash
php artisan migrate --force
php artisan db:seed --force
```

### Step 4: Configure Web Server

#### Nginx Configuration

```nginx
server {
    listen 80;
    server_name api.yourdomain.com;
    root /path/to/payus-as-a-service/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Apache Configuration

```apache
<VirtualHost *:80>
    ServerName api.yourdomain.com
    DocumentRoot /path/to/payus-as-a-service/public

    <Directory /path/to/payus-as-a-service/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Step 5: Set Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Step 6: Optimize

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Reverse Proxy Setup

### Caddy

```
api.yourdomain.com {
    reverse_proxy localhost:9006
}
```

### Nginx (as reverse proxy)

```nginx
server {
    listen 80;
    server_name api.yourdomain.com;

    location / {
        proxy_pass http://localhost:9006;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

---

## Customization

### Adding Your Own Messages

Messages are stored in `messages.json`. To add your own:

1. Edit `messages.json`
2. Add messages under the appropriate tone
3. Re-seed the database:

```bash
php artisan migrate:fresh --seed --force
```

### Changing Rate Limits

Edit `app/Providers/AppServiceProvider.php`:

```php
RateLimiter::for('api', fn (Request $request) => 
    Limit::perMinute(120)->by($request->ip()) // Changed from 60 to 120
);
```

Then clear cache:

```bash
php artisan config:clear
```

### Adding New Tones

1. Add to `app/Enums/MessageTone.php`
2. Add messages to `messages.json`
3. Update database:

```bash
php artisan migrate:fresh --seed --force
```

---

## Maintenance

### Update to Latest Version

```bash
git pull origin main
docker compose down
docker compose build
docker compose up -d
docker compose run --rm app composer install --no-dev
docker compose run --rm app php artisan migrate --force
docker compose run --rm app php artisan optimize
```

### View Logs

```bash
# Docker
docker compose logs -f app

# Manual
tail -f storage/logs/laravel.log
```

### Backup Database

```bash
# MySQL (Docker)
docker compose exec mysql_puaas mysqldump -u root -p db_puaas > backup.sql

# SQLite
cp database/database.sqlite database/database.backup.sqlite
```

---

## Troubleshooting

See the [Troubleshooting Guide](Troubleshooting) for common issues and solutions.

## Security Considerations

- Always use HTTPS in production
- Keep dependencies updated
- Use strong database passwords
- Regularly backup your data
- Monitor logs for suspicious activity
- Consider adding authentication for your instance

---

## Need Help?

- [Troubleshooting Guide](Troubleshooting)
- [GitHub Discussions](https://github.com/sticknologic/payus-as-a-service/discussions)
- [GitHub Issues](https://github.com/sticknologic/payus-as-a-service/issues)
