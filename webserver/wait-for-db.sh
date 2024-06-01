#!/bin/bash

# Wait for the database to be ready
until mysql -h"$1" -uroot -p"$MYSQL_ROOT_PASSWORD" -e 'SELECT 1'; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 1
done

>&2 echo "MySQL is up - executing commands"

# Run updateSQL.php
php "$2"

# Run SQL file
mysql -h"$1" -uroot -p"$MYSQL_ROOT_PASSWORD" < "$3"

# Start Apache server
>&2 echo "Starting Apache server"
apache2-foreground

>&2 echo "SQL file executed successfully"