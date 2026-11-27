#!/bin/bash
BACKUP_DIR=/home/mulyana/uts-deployment/backup
DATE=$(date +%Y%m%d_%H%M%S)
docker exec mysql mysqldump -uroot -prootpass --databases appdb > $BACKUP_DIR/appdb_$DATE.sql
gzip $BACKUP_DIR/appdb_$DATE.sql
find $BACKUP_DIR -name "*.sql.gz" -mtime +7 -delete
