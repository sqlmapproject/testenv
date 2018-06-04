#!/usr/bin/env bash

/etc/init.d/mysql start

mysqladmin -u root password testpass
mysql -u root -ptestpass mysql < /var/www/sqlmap/schema/mysql.sql

/etc/init.d/apache2 start

echo "Listening..."
tail -f /dev/null
