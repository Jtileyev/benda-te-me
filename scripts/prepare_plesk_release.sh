#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

STAMP="$(date +%Y%m%d-%H%M%S)"
RELEASE_DIR="$ROOT_DIR/output/release"
STAGING_DIR="$RELEASE_DIR/staging-$STAMP"
ARCHIVE_PATH="$RELEASE_DIR/benda-te-me-release-$STAMP.zip"
COMPOSER_CMD="composer"
ARCHIVE_KIND="zip"

if ! command -v rsync >/dev/null 2>&1; then
  echo "rsync is required."
  exit 1
fi

if ! command -v npm >/dev/null 2>&1; then
  echo "npm is required for frontend build."
  exit 1
fi

if ! command -v composer >/dev/null 2>&1; then
  if [[ -x "$ROOT_DIR/composer" ]]; then
    COMPOSER_CMD="$ROOT_DIR/composer"
  else
    echo "Composer is not available. Install composer or provide executable ./composer."
    exit 1
  fi
fi

if ! command -v zip >/dev/null 2>&1; then
  ARCHIVE_KIND="tar"
  ARCHIVE_PATH="$RELEASE_DIR/benda-te-me-release-$STAMP.tar.gz"
fi

echo "Preparing release workspace..."
mkdir -p "$RELEASE_DIR"
rm -rf "$STAGING_DIR"
mkdir -p "$STAGING_DIR"

echo "Copying project files to staging..."
rsync -a ./ "$STAGING_DIR/" \
  --exclude ".git" \
  --exclude ".gitignore" \
  --exclude ".env" \
  --exclude "node_modules" \
  --exclude "tests" \
  --exclude "output" \
  --exclude ".playwright-cli" \
  --exclude "docker" \
  --exclude "docker-compose.yml" \
  --exclude "docker-compose.traefik.yml" \
  --exclude "Dockerfile" \
  --exclude ".phpunit.result.cache" \
  --exclude "phpunit.xml" \
  --exclude "vendor"

echo "Installing production PHP dependencies in staging..."
"$COMPOSER_CMD" install \
  --working-dir "$STAGING_DIR" \
  --no-dev \
  --optimize-autoloader \
  --no-interaction

echo "Building frontend assets in staging..."
(
  cd "$STAGING_DIR"
  npm ci
  npm run build
  rm -rf node_modules
)

echo "Ensuring writable directories exist..."
mkdir -p "$STAGING_DIR/storage/framework/cache/data"
mkdir -p "$STAGING_DIR/storage/framework/sessions"
mkdir -p "$STAGING_DIR/storage/framework/views"
mkdir -p "$STAGING_DIR/storage/logs"
mkdir -p "$STAGING_DIR/bootstrap/cache"

echo "Creating release archive..."
if [[ "$ARCHIVE_KIND" == "zip" ]]; then
  (
    cd "$STAGING_DIR"
    zip -rq "$ARCHIVE_PATH" .
  )
else
  tar -C "$STAGING_DIR" -czf "$ARCHIVE_PATH" .
fi

rm -rf "$STAGING_DIR"

echo "Release archive created:"
echo "$ARCHIVE_PATH"
