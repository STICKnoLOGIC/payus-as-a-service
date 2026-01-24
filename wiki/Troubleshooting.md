# Troubleshooting

Common issues and solutions when using or self-hosting PayUs-as-a-Service.

---

## API Usage Issues

### 429 - Rate Limit Exceeded

**Problem:** Getting "Too Many Requests" error.

**Solution:**
- You're making more than 60 requests per minute
- Wait for the rate limit window to reset (1 minute)
- Implement rate limiting on your side
- Consider self-hosting for unlimited requests

**Example Error:**
```json
{
  "message": "Too many requests"
}
```

---

### 404 - Not Found

**Problem:** Endpoint returns 404 error.

**Possible Causes:**
1. Incorrect endpoint URL
2. Typo in tone name
3. API is down

**Solutions:**
```bash
# ❌ Wrong
curl https://puaas.sticknologic.is-a.dev/payus/Professional  # Capital P

# ✅ Correct
curl https://puaas.sticknologic.is-a.dev/payus/professional  # lowercase
```

Valid tones: `professional`, `friendly`, `frank`, `funny`, `playful`

---

### CORS Errors (Browser)

**Problem:** Browser console shows CORS error.

**Solution:**
The API allows CORS from all origins. If you're still getting errors:

1. Check if you're using the correct URL (https, not http)
2. Verify your fetch/axios configuration
3. Check browser console for specific error details

**Example Fix:**
```javascript
// Explicitly set headers
fetch('https://puaas.sticknologic.is-a.dev/payus', {
  method: 'GET',
  headers: {
    'Accept': 'application/json',
  }
});
```

---

## Self-Hosting Issues

### Docker Issues

#### Container Won't Start

**Problem:** `docker compose up -d` fails

**Solution:**
```bash
# Check container logs
docker compose logs app

# Check if port 9006 is already in use
netstat -ano | findstr :9006  # Windows
lsof -i :9006                 # Linux/Mac

# Stop conflicting services or change port in docker-compose.yml
```

#### Permission Denied Errors

**Problem:** Permission errors when accessing the app.

**Solution:**
```bash
# Fix permissions inside container
docker exec -it PayUs-as-a-Service sh -c "chmod -R 755 /var/www/storage /var/www/bootstrap/cache"

# Or rebuild with proper permissions
docker compose down
docker compose build --no-cache
docker compose up -d
```

#### Database Connection Errors

**Problem:** Can't connect to MySQL container.

**Solution:**
```bash
# Check if MySQL container is running
docker compose ps

# Check MySQL logs
docker compose logs mysql_puaas

# Verify database credentials in .env match .env.db

# Try connecting manually
docker compose exec mysql_puaas mysql -u root -p
```

---

### Installation Issues

#### Composer Install Fails

**Problem:** `composer install` throws errors.

**Solutions:**
```bash
# Update Composer
composer self-update

# Clear Composer cache
composer clear-cache

# Install with more memory
php -d memory_limit=-1 /usr/bin/composer install

# Check PHP version
php -v  # Should be 8.3 or higher
```

#### Missing PHP Extensions

**Problem:** Error about missing PHP extensions.

**Required Extensions:**
- pdo_mysql (or pdo_sqlite/pdo_pgsql)
- mbstring
- exif
- pcntl
- bcmath
- gd
- zip

**Solution (Ubuntu/Debian):**
```bash
sudo apt-get install php8.3-mysql php8.3-mbstring php8.3-gd php8.3-zip php8.3-bcmath
sudo systemctl restart php8.3-fpm
```

---

### Migration Issues

#### "Table already exists" Error

**Problem:** Migration fails because tables exist.

**Solution:**
```bash
# Fresh install (WARNING: Deletes all data)
php artisan migrate:fresh --seed --force

# Or drop tables manually first
php artisan db:wipe
php artisan migrate --seed
```

#### No Messages After Seeding

**Problem:** Database seeded but no messages returned.

**Solution:**
```bash
# Verify messages.json exists
ls -la messages.json

# Check seeder ran successfully
docker compose run --rm app php artisan db:seed --class=MessageSeeder --force

# Verify data in database
docker compose exec mysql_puaas mysql -u root -p db_puaas -e "SELECT COUNT(*) FROM messages;"
```

---

### Performance Issues

#### Slow API Responses

**Problem:** API takes too long to respond.

**Solutions:**
```bash
# 1. Enable caching
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Optimize autoloader
composer dump-autoload --optimize

# 3. Enable OPcache in php.ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000

# 4. Check database indexes
# Messages table should have index on 'tone' column
```

#### High Memory Usage

**Problem:** App consuming too much memory.

**Solutions:**
```bash
# Increase PHP memory limit in .ini file
memory_limit = 256M

# Or in Docker's local.ini
# docker/php/local.ini
memory_limit = 256M

# Restart containers
docker compose restart
```

---

### Production Issues

#### Docs Not Accessible in Production

**Problem:** `/docs` returns 403 or 404 in production.

**Solution:**

This was fixed in the AppServiceProvider. Verify:

```php
// app/Providers/AppServiceProvider.php
public function boot(): void
{
    // This allows docs in all environments
    Gate::define('viewApiDocs', fn () => true);
    
    $this->configureRateLimiting();
}
```

Then clear cache:
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

#### SSL/HTTPS Issues

**Problem:** Mixed content or SSL errors.

**Solutions:**
```env
# In .env
APP_URL=https://your-domain.com

# Force HTTPS in AppServiceProvider
URL::forceScheme('https');
```

```nginx
# Nginx config
proxy_set_header X-Forwarded-Proto $scheme;
proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
```

---

### Testing Issues

#### Tests Fail

**Problem:** `composer test` or `./vendor/bin/pest` fails.

**Solutions:**
```bash
# Run specific test suite
./vendor/bin/pest --filter PayUsTest

# Check for syntax errors
./vendor/bin/pint --test

# Run static analysis
./vendor/bin/phpstan analyse

# Clear test cache
php artisan test:clear
```

---

## Debugging Tips

### Enable Debug Mode (Development Only)

```env
# .env
APP_DEBUG=true
LOG_LEVEL=debug
```

### Check Logs

```bash
# Docker
docker compose logs -f app

# Manual
tail -f storage/logs/laravel.log
```

### API Testing Tools

Use these tools to test the API:
- [Postman](https://www.postman.com/)
- [Insomnia](https://insomnia.rest/)
- [HTTPie](https://httpie.io/)
- Browser DevTools (Network tab)

### Verify Routes

```bash
php artisan route:list
```

Expected routes:
- `GET /payus`
- `GET /payus/{tone}`
- `GET /payus/tones`
- `GET /docs`
- `GET /api.json`

---

## Still Having Issues?

If your problem isn't listed here:

1. **Search existing issues:** [GitHub Issues](https://github.com/sticknologic/payus-as-a-service/issues)
2. **Check discussions:** [GitHub Discussions](https://github.com/sticknologic/payus-as-a-service/discussions)
3. **Ask for help:** [Open a new discussion](https://github.com/sticknologic/payus-as-a-service/discussions/new?category=q-a)
4. **Report a bug:** [Create an issue](https://github.com/sticknologic/payus-as-a-service/issues/new)

When reporting issues, please include:
- Operating system and version
- PHP version (`php -v`)
- Docker version (if applicable)
- Error messages (full stack trace)
- Steps to reproduce
- What you've already tried

---

## Quick Fixes Checklist

Before asking for help, try these:

- [ ] Clear all caches: `php artisan optimize:clear`
- [ ] Restart containers: `docker compose restart`
- [ ] Check logs for errors
- [ ] Verify `.env` configuration
- [ ] Ensure database is running
- [ ] Confirm you're using PHP 8.3+
- [ ] Update dependencies: `composer update`
- [ ] Check file permissions
- [ ] Verify network connectivity
- [ ] Test with `curl` or Postman
