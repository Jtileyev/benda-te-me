# Deploy To Plesk Without SSH

This guide is for shared hosting in Plesk where terminal access is unavailable.

## 1) Build release package locally

Run in project root:

```bash
bash scripts/prepare_plesk_release.sh
```

The script creates a zip archive in `output/release/` with production PHP dependencies (`vendor`) and built frontend assets (`public/build`).
If `zip` is unavailable locally, it creates `.tar.gz` automatically.

## 2) Prepare production `.env` locally

Copy and fill values:

```bash
cp .env.production.example .env
```

Set at minimum:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://your-domain.tld`
- `DB_*` credentials from Plesk MariaDB
- `MAIL_*` credentials

Generate an app key locally and paste it into `.env`:

```bash
php -r "echo 'base64:'.base64_encode(random_bytes(32)).PHP_EOL;"
```

Put output into `APP_KEY=...`.

## 3) Prepare database dump locally

You can export by script:

```bash
bash scripts/export_db_dump.sh
```

Or use your preferred DB tool (phpMyAdmin, DBeaver).

The dump should include:
- all tables from this project
- structure + data

## 4) Upload files in Plesk

1. Upload release archive from `output/release/` (`.zip` or `.tar.gz`).
2. Extract archive into domain directory (project root).
3. Upload your prepared `.env` file to project root.
4. Ensure domain document root points to `public`.

## 5) Import SQL in Plesk

Use phpMyAdmin in Plesk:
1. Open the MariaDB database.
2. Import your SQL dump.

## 6) Final checks in Plesk File Manager

- `storage/` writable
- `bootstrap/cache/` writable
- `public/build/manifest.json` exists
- `vendor/autoload.php` exists

## 7) Security note

Do not run seeders in production unless needed.

`SEED_DEFAULT_ADMIN` must stay `false` in production.
