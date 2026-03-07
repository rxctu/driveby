#!/bin/bash
set -e

PGDATA="/var/lib/postgresql/data"

if [ ! -f "$PGDATA/PG_VERSION" ]; then
    echo "Initializing PostgreSQL data directory..."
    su postgres -c "initdb -D $PGDATA --encoding=UTF8 --locale=C"

    # Allow connections from any host
    echo "host all all 0.0.0.0/0 md5" >> "$PGDATA/pg_hba.conf"
    echo "listen_addresses='*'" >> "$PGDATA/postgresql.conf"

    # Start PostgreSQL temporarily
    su postgres -c "pg_ctl -D $PGDATA start -w"

    # Create user and database
    su postgres -c "psql -c \"CREATE USER ${POSTGRES_USER:-epidrive} WITH PASSWORD '${POSTGRES_PASSWORD:-secret}';\""
    su postgres -c "psql -c \"CREATE DATABASE ${POSTGRES_DB:-epidrive} OWNER ${POSTGRES_USER:-epidrive};\""
    su postgres -c "psql -c \"GRANT ALL PRIVILEGES ON DATABASE ${POSTGRES_DB:-epidrive} TO ${POSTGRES_USER:-epidrive};\""

    # Stop temporary instance
    su postgres -c "pg_ctl -D $PGDATA stop -w"
fi

exec su postgres -c "postgres -D $PGDATA"
