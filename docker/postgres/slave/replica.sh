#!/bin/bash

rm -R /var/lib/postgresql/data/*
su - postgres -c "pg_basebackup --host=postgres --username=default --pgdata=/var/lib/postgresql/data --wal-method=stream --write-recovery-conf"
