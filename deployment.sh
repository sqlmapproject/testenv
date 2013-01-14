#!/usr/bin/env bash

echo "Updating base system"
aptitude update
aptitude full-upgrade

echo "Installing Apache, PHP, git and generic PHP modules"
aptitude install apache2 libapache2-mod-php5 git php5-dev php5-gd php-pear php5-mysql php5-pgsql php5-sqlite php5-interbase php5-sybase php5-odbc libmdbodbc

echo "Configuring Apache"
rm /var/www/index.html
mkdir /var/www/test
chmod 777 /var/www/test
a2enmod auth_basic auth_digest
sed -i 's/AllowOverride None/AllowOverride AuthConfig/' /etc/apache2/sites-enabled/*
update-rc.d apache2 defaults
service apache2 restart

echo "Donwloading sqlmap test environment to /var/www"
cd /var/www
git clone https://github.com/sqlmapproject/testenv.git sqlmap

echo "Installing MySQL database management system (clients, server, libraries)"
echo "NOTE: when asked for a password, type 'testpass'"
aptitude install mysql-client mysql-server libmysqlclient-dev libmysqld-dev 
update-rc.d mysql defaults

echo "Initializing MySQL test database and table"
echo "NOTE: when asked for a password, type 'testpass'"
mysql -u root -p mysql < /var/www/sqlmap/schema/mysql.sql 

echo "Installing PostgreSQL database management system (clients, server, libraries)"
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

echo "Initializing Microsoft Access ODBC driver"
cat << EOF > /etc/odbc.ini
[testdb]
Description = Microsoft Access Database of testdb
Driver      = MDBToolsODBC
Database    = /var/www/sqlmap/dbs/access/testdb.mdb
Servername  = localhost
UserName    =
Password    =
port        = 4747
EOF

cat << EOF > /etc/odbcinst.ini
[MDBToolsODBC]
Description = MDB Tools ODBC drivers
Driver      = /usr/lib/libmdbodbc.so.0
Setup       =
FileUsage   = 1
CPTimeout   =
CPReuse     =
UsageCount  = 1
EOF

echo "Installing Firebird database management system (clients, server, libraries)"
echo "NOTE: when asked for a password, type 'testpass'"
aptitude install firebird2.5-super firebird2.5-dev
dpkg-reconfigure firebird2.5-super
update-rc.d firebird2.5-super defaults

echo "Initializing Firebird test database"
echo "modify SYSDBA -pw testpass" | gsec -user SYSDBA -password masterkey
chmod 666 /var/www/sqlmap/dbs/firebird/testdb.fdb

# Clean up installation
aptitude clean
