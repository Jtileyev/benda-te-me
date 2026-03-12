#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

if [[ ! -f .env ]]; then
  echo ".env not found in project root."
  exit 1
fi

if ! command -v mysqldump >/dev/null 2>&1; then
  echo "mysqldump is not installed. Export database using your DB tool."
  exit 1
fi

db_host="$(grep -E '^DB_HOST=' .env | tail -1 | cut -d '=' -f2-)"
db_port="$(grep -E '^DB_PORT=' .env | tail -1 | cut -d '=' -f2-)"
db_name="$(grep -E '^DB_DATABASE=' .env | tail -1 | cut -d '=' -f2-)"
db_user="$(grep -E '^DB_USERNAME=' .env | tail -1 | cut -d '=' -f2-)"
db_pass="$(grep -E '^DB_PASSWORD=' .env | tail -1 | cut -d '=' -f2-)"

if [[ -z "${db_name}" || -z "${db_user}" ]]; then
  echo "DB_DATABASE or DB_USERNAME is missing in .env."
  exit 1
fi

STAMP="$(date +%Y%m%d-%H%M%S)"
OUT_DIR="$ROOT_DIR/output/release"
OUT_FILE="$OUT_DIR/benda-te-me-db-$STAMP.sql"
mkdir -p "$OUT_DIR"

echo "Exporting database '$db_name' to $OUT_FILE ..."
MYSQL_PWD="$db_pass" mysqldump \
  --host="${db_host:-127.0.0.1}" \
  --port="${db_port:-3306}" \
  --user="$db_user" \
  --single-transaction \
  --quick \
  --routines \
  --triggers \
  "$db_name" > "$OUT_FILE"

echo "Database dump created:"
echo "$OUT_FILE"
