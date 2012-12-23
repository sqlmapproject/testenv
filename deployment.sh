#!/usr/bin/env bash

echo "Updating base system"
aptitude update
aptitude full-upgrade

echo "Installing Apache, PHP, git and generic PHP modules"
aptitude install apache2 libapache2-mod-php5 git php5-mysql php5-pgsql php5-dev php5-gd php-pear

echo "Configuring Apache"
rm /var/www/index.html
mkdir /var/www/test
chmod 777 /var/www/test
a2enmod auth_basic auth_digest
sed -i 's/AllowOverride None/AllowOverride AuthConfig/' /etc/apache2/sites-enabled/*

echo "Donwloading sqlmap test environment to /var/www"
cd /var/www
git clone https://github.com/sqlmapproject/testenv.git sqlmap

echo "Installing MySQL database management system (clients, servers, libraries)"
echo "NOTE: when asked for a password, type 'testpass'"
aptitude install mysql-client mysql-server libmysqlclient-dev libmysqld-dev 

echo "Initializing MySQL test database and table"
echo "NOTE: when asked for a password, type 'testpass'"
mysql -u root -p mysql < /var/www/sqlmap/schema/mysql.sql 

echo "Installing PostgreSQL database management system (clients, servers, libraries)"
aptitude install postgresql-client postgresql postgresql-server-dev-all libpq-dev 
update-rc.d postgresql defaults

echo "Initializing PostgreSQL test database and table"
echo "NOTE: when asked for a password, type 'testpass'"
su postgres -c psql
ALTER USER postgres WITH PASSWORD 'testpass';
\q
passwd -d postgres
su postgres -c passwd
psql -U postgres -h 127.0.0.1 -c "CREATE DATABASE testdb;"
psql -U postgres -W -h 127.0.0.1 -d testdb -f pgsql.sql

echo "Installing PHP SQLite module"
aptitude install php5-sqlite

# TODO: verify if needed
echo "Installing PHP ODBC module for Microsoft Access"
aptitude install php5-odbc

# TODO: verify if needed
echo "Installing PHP Interbase module for Firebird"
aptitude install php5-interbase

# Clean up installation
aptitude clean

