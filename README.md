Для elacticsearch возможно придется выставить:

`sudo sysctl -w vm.max_map_count=262144`

#Postgres
Инициализация slave, нужно выполнить на slave машине 
su - postgres -c "pg_basebackup --host=postgres --username=default --pgdata=/var/lib/postgresql/data --wal-method=stream --write-recovery-conf"