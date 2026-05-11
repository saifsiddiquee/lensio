# Lensio CRM — Docker Setup

## Stack

| Service    | Image                  | Purpose                          |
|------------|------------------------|----------------------------------|
| `app`      | Custom (PHP 8.4-fpm + Nginx) | Laravel app + web server   |
| `postgres` | `postgres:16-alpine`   | Primary database                 |
| `redis`    | `redis:7-alpine`       | Available for cache/sessions     |

---

## Quick Start

### 1. Copy and configure the environment file

```bash
cp .env.docker .env
```

Edit `.env` and set at minimum:

```dotenv
APP_KEY=                    # leave blank — entrypoint generates it
DB_PASSWORD=your_password   # choose a strong password
```

### 2. Build and start

```bash
docker compose up -d --build
```

The first build takes ~3–5 minutes (compiles PHP extensions, installs Composer/Node deps, builds Vite assets).

### 3. Access the app

```
http://localhost:8080
```

---

## What the entrypoint does automatically

On every container start, `docker/entrypoint.sh` runs:

1. Creates and permissions `storage/` and `bootstrap/cache/`
2. Generates `APP_KEY` if not set
3. Waits for PostgreSQL to be ready (up to 60 seconds)
4. Runs `php artisan migrate --force`
5. Caches config/routes/views (production only)
6. Hands off to supervisord → starts Nginx + PHP-FPM + Queue Worker

---

## Common commands

```bash
# View logs
docker compose logs -f app
docker compose logs -f postgres

# Run artisan commands
docker compose exec app php artisan tinker
docker compose exec app php artisan db:seed

# Run migrations manually
docker compose exec app php artisan migrate

# Open a shell
docker compose exec app bash

# Stop everything
docker compose down

# Stop and remove volumes (wipes database!)
docker compose down -v
```

---

## Switching from MySQL to PostgreSQL

The app was originally configured for MySQL. When running in Docker it uses PostgreSQL.
All Laravel migrations are compatible with both drivers.

If you have existing MySQL data to migrate:

```bash
# Export from MySQL
mysqldump -u root -p lensio > lensio_mysql.sql

# Use pgloader or manually re-seed
docker compose exec app php artisan db:seed
```

---

## File structure

```
docker/
├── entrypoint.sh           # Container startup script
├── nginx/
│   ├── nginx.conf          # Main Nginx config
│   └── default.conf        # Laravel virtual host
├── php/
│   ├── php.ini             # PHP runtime settings
│   └── www.conf            # PHP-FPM pool config
└── supervisor/
    └── supervisord.conf    # Process manager (Nginx + FPM + Queue)
```

---

## Production checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Set a strong `APP_KEY` and `DB_PASSWORD`
- [ ] Put a reverse proxy (Nginx/Traefik/Caddy) in front for TLS
- [ ] Mount a persistent volume for `storage/app/` if using file uploads
- [ ] Set `APP_URL` to your real domain
