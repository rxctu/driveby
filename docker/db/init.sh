#!/bin/bash
set -e

PGDATA="/var/lib/postgresql/data"

if [ ! -f "$PGDATA/PG_VERSION" ]; then
    echo "Initializing PostgreSQL data directory..."
    initdb -D "$PGDATA" --encoding=UTF8 --locale=C

    # Allow connections from any host
    echo "host all all 0.0.0.0/0 md5" >> "$PGDATA/pg_hba.conf"
    echo "listen_addresses='*'" >> "$PGDATA/postgresql.conf"

    # Start PostgreSQL temporarily
    pg_ctl -D "$PGDATA" start -w

    # Create user and database
    psql -c "CREATE USER ${POSTGRES_USER:-epidrive} WITH PASSWORD '${POSTGRES_PASSWORD:-secret}';"
    psql -c "CREATE DATABASE ${POSTGRES_DB:-epidrive} OWNER ${POSTGRES_USER:-epidrive};"
    psql -c "GRANT ALL PRIVILEGES ON DATABASE ${POSTGRES_DB:-epidrive} TO ${POSTGRES_USER:-epidrive};"

    # Stop temporary instance
    pg_ctl -D "$PGDATA" stop -w
fi

exec postgres -D "$PGDATA"
