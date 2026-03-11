# Benda Te Me Clone (Laravel + Bootstrap + MariaDB)

Full-stack implementation of the requested clone with:
- Laravel 10 (compatible with current PHP 8.1 runtime)
- Bootstrap 5.3 (Blade server-rendered views)
- MariaDB-compatible schema (MySQL driver)
- RU/EN localization
- Public pages + auth + basic admin panel

## Implemented routes
- Public: `/`, `/about`, `/live`, `/search`, `/missing-person`, `/provide-info`, `/video-messages`, `/video-messages/create`
- Auth: `/login`, `/register`, `/logout`, `/password/*`
- Admin: `/admin`, `/admin/requests`, `/admin/video-messages`, `/admin/content`, `/admin/users`

## Core features
- Search form + saved search history
- Missing person request form
- Person info report form
- Video message upload/link submission + moderation status
- Admin moderation for requests and videos
- Admin management for content keys and social links
- Admin user role/status management
- Locale switch (`RU/EN`) via `/locale/{locale}`

## Setup
```bash
cp .env.example .env
# Edit DB_* in .env for your MariaDB instance
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## Default admin account
- Email: `admin@example.com`
- Password: `password`

## Tests
```bash
php artisan test
```

## Docker Compose
```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

Application URL: `http://localhost:8080`  
MariaDB exposed on host: `127.0.0.1:3307`

## Production with Traefik + SSL
Prerequisites:
- Public DNS `A` records for `benda-te-me.com` and `www.benda-te-me.com` point to your server.
- Traefik is running with entrypoints `web` (80), `websecure` (443), and cert resolver `mytlschallenge`.
- This app is started in the same Docker Compose project where Traefik service is running.

Run app with Traefik override:
```bash
docker compose -f docker-compose.yml -f docker-compose.traefik.yml up -d --build
docker compose -f docker-compose.yml -f docker-compose.traefik.yml exec app php artisan key:generate
docker compose -f docker-compose.yml -f docker-compose.traefik.yml exec app php artisan migrate --seed
docker compose -f docker-compose.yml -f docker-compose.traefik.yml exec app php artisan storage:link
```

Traefik labels are configured in `docker-compose.traefik.yml` for:
- domain routing: `benda-te-me.com`, `www.benda-te-me.com`
- automatic Let's Encrypt certificate via `certresolver=mytlschallenge`
- security headers middleware (STS/XSS/NoSniff)

If you run this app in a separate compose stack, create a shared external Docker network and attach both Traefik and this app to it.
