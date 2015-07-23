#!/usr/bin/env bash

set -e

echo "Create the database"
mysql -u root -ptestpass mysql < /var/www/sqlmap/schema/mysql.sql

echo "Start apache"
# Apache gets grumpy about PID files pre-existing
rm -f /var/run/apache2/apache2.pid
exec apache2 -DFOREGROUND