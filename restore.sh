#!/usr/bin/env bash
set -euo pipefail

if [ $# -lt 1 ]; then
    echo "Usage: ./restore.sh backups/db_YYYY-MM-DD_HH-MM-SS.sql"
    echo ""
    ls -lh backups/*.sql 2>/dev/null || echo "No backups found in ./backups/"
    exit 1
fi

DUMP_FILE="$1"

if [ ! -f "$DUMP_FILE" ]; then
    echo "❌ File not found: $DUMP_FILE"
    exit 1
fi

echo "🔄 Restoring database from: $DUMP_FILE"
cat "$DUMP_FILE" | docker compose exec -T mysql sh -c 'exec mysql -uroot -proot_secret_pass salon_booking'
echo "✅ Database restored!"
