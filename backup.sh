#!/usr/bin/env bash
set -euo pipefail

DATE=$(date +%Y-%m-%d_%H-%M-%S)
BACKUP_DIR="./backups"
mkdir -p "$BACKUP_DIR"

echo "📦 Backing up database..."
docker compose exec mysql sh -c 'exec mysqldump -uroot -proot_secret_pass salon_booking' > "$BACKUP_DIR/db_$DATE.sql"
echo "✅ Database saved: backups/db_$DATE.sql"

echo "📦 Backing up .env..."
cp .env "$BACKUP_DIR/env_$DATE.backup"
echo "✅ .env saved: backups/env_$DATE.backup"

echo "📦 Backing up storage (uploads)..."
tar -czf "$BACKUP_DIR/storage_$DATE.tar.gz" storage/ 2>/dev/null || echo "   ⚠️  No storage/ to backup"

echo ""
echo "🎉 All done! Backups in: $BACKUP_DIR"
echo "   Restore: cat backups/db_$DATE.sql | docker compose exec -T mysql mysql -uroot -proot_secret_pass salon_booking"
