# Benda Te Me

Веб-приложение на Laravel 10 с серверным рендерингом Blade, Bootstrap 5 и базой данных MariaDB/MySQL.

## Технологии
- PHP 8.2
- Laravel 10
- Bootstrap 5.3
- Vite 5
- MariaDB 11

## Основные разделы
- Публичные страницы: `/`, `/about`, `/live`, `/search`, `/missing-person`, `/provide-info`, `/video-messages`, `/video-messages/create`
- Аутентификация: `/login`, `/register`, `/logout`, `/password/*`
- Админ-панель: `/admin`, `/admin/requests`, `/admin/video-messages`, `/admin/content`, `/admin/users`

## Функциональность
- Поиск и сохранение поисковых запросов
- Форма заявки о пропавшем человеке
- Форма передачи информации о человеке
- Добавление видеосообщений и модерация
- Управление контентом и пользователями в админ-панели
- Переключение локали RU/EN через `/locale/{locale}`

## Локальный запуск (без Docker)
```bash
cp .env.example .env
# Отредактируйте DB_* под вашу базу данных
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## Тесты
```bash
php artisan test
```

## Данные администратора по умолчанию
- Email: `admin@example.com`
- Пароль: `password`

## Запуск через Docker Compose
```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

- Приложение: `http://localhost:8080`
- MariaDB на хосте: `127.0.0.1:3307`

## Продакшн с Traefik и SSL
Требования:
- DNS-записи `A` для `benda-te-me.com` и `www.benda-te-me.com` должны указывать на сервер.
- Traefik должен быть запущен с entrypoints `web` (80) и `websecure` (443).
- В Traefik должен быть настроен cert resolver `mytlschallenge`.
- Приложение запускается в том же Docker Compose-проекте, где запущен Traefik.

Запуск:
```bash
docker compose -f docker-compose.yml -f docker-compose.traefik.yml up -d --build
docker compose -f docker-compose.yml -f docker-compose.traefik.yml exec app php artisan key:generate
docker compose -f docker-compose.yml -f docker-compose.traefik.yml exec app php artisan migrate --seed
docker compose -f docker-compose.yml -f docker-compose.traefik.yml exec app php artisan storage:link
```

В `docker-compose.traefik.yml` уже настроены:
- роутинг доменов `benda-te-me.com` и `www.benda-te-me.com`
- автоматическое получение SSL-сертификата Let's Encrypt через `mytlschallenge`
- заголовки безопасности (STS/XSS/NoSniff)

Если приложение запускается отдельным compose-стеком, подключите Traefik и приложение к общей внешней Docker-сети.
