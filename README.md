# UTS Cloud Computing - Deployment Aplikasi Web

Arsitektur: Web (PHP+Apache) -> ProxySQL -> MySQL, monitoring Netdata, backup mysqldump + cron.
Semua berjalan dalam container Docker di dalam VM VMware (Ubuntu).

## Menjalankan
    git clone https://github.com/muhammadmulyana101-dev/uts-cloud-computing.git
    cd uts-cloud-computing
    docker compose up -d --build

## Akses
- Aplikasi: http://IP-VM
- Monitoring Netdata: http://IP-VM:19999

## Backup dan restore
- Backup: ./backup/backup.sh (cron harian 02.00)
- Restore: gunzip -c backup/FILE.sql.gz | docker exec -i mysql mysql -uroot -prootpass

## Skalabilitas
Vertical scaling: penambahan vCPU/RAM/disk pada VM di VMware.
