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
