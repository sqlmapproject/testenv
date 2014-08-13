#!/usr/bin/env bash
echo "### Updating base system"
aptitude update
aptitude full-upgrade

echo "### Installing Apache, PHP, git and generic PHP modules"
aptitude install apache2 libapache2-mod-php5 git php5-dev php5-gd php-pear php5-mysql php5-pgsql php5-sqlite php5-interbase php5-sybase php5-odbc libmdbodbc1 unzip make libaio1 bc screen htop git subversion sqlite sqlite3

echo "### Configuring Apache and PHP"
rm /var/www/index.html
mkdir /var/www/test
chmod 777 /var/www/test
a2enmod auth_basic auth_digest
sed -i 's/AllowOverride None/AllowOverride AuthConfig/' /etc/apache2/sites-enabled/*
sed -i 's/magic_quotes_gpc = On/magic_quotes_gpc = Off/g' /etc/php5/*/php.ini
sed -i 's/extension=suhosin.so/;extension=suhosin.so/g' /etc/php5/conf.d/suhosin.ini
update-rc.d apache2 defaults

echo "### Restarting Apache web server"
service apache2 restart

echo "### Downloading sqlmap test environment to /var/www"
cd /var/www
git clone https://github.com/sqlmapproject/testenv.git sqlmap

echo "### Installing MySQL database management system (clients, server, libraries)"
echo "### NOTE: when asked for a password, type 'testpass'"
aptitude install mysql-client mysql-server libmysqlclient-dev libmysqld-dev
update-rc.d mysql defaults

echo "### Initializing MySQL test database and table"
echo "### NOTE: when asked for a password, type 'testpass'"
mysql -u root -p mysql < /var/www/sqlmap/schema/mysql.sql
sed -i 's/bind-address            = 127.0.0.1/bind-address            = 0.0.0.0/g' /etc/mysql/my.cnf
service mysql restart

echo "### Installing PostgreSQL database management system (clients, server, libraries)"
aptitude install postgresql-client postgresql postgresql-server-dev-all libpq-dev 
update-rc.d postgresql defaults

echo "### Initializing PostgreSQL test database and table"
echo "### NOTE: when asked for a password, type 'testpass'"
echo "Now type: ALTER USER postgres WITH PASSWORD 'testpass'; - hit RETURN, type \q - hit RETURN"
su postgres -c psql
passwd -d postgres
su postgres -c passwd
psql -U postgres -h 127.0.0.1 -c "CREATE DATABASE testdb;"
psql -U postgres -h 127.0.0.1 -d testdb -f /var/www/sqlmap/schema/pgsql.sql
echo "host    all         all         0.0.0.0/0          md5" >> /etc/postgresql/9.1/main/pg_hba.conf
sed -i "s/listen_addresses = 'localhost'/listen_addresses = '*'/g" /etc/postgresql/9.1/main/postgresql.conf
sed -i "s/#listen_addresses = /listen_addresses = /g" /etc/postgresql/9.1/main/postgresql.conf
service postgresql restart

echo "### Configuring PHP for SQLite 2"
wget http://www.spadim.com.br/SQLite-1.0.4.tgz
tar xvf SQLite-1.0.4.tgz
cd SQLite-1.0.4
phpize
./configure
make
make install
echo "extension=sqlite.so" > /etc/php5/conf.d/99-sqlite2.ini

echo "### Installing Firebird database management system (clients, server, libraries)"
echo "### NOTE: when asked for a password, type 'testpass'"
aptitude install firebird2.5-super firebird2.5-dev
dpkg-reconfigure firebird2.5-super
update-rc.d firebird2.5-super defaults

echo "### Initializing Firebird test database"
echo "modify SYSDBA -pw testpass" | gsec -user SYSDBA -password masterkey
chmod 666 /var/www/sqlmap/dbs/firebird/testdb.fdb

echo "### Installing Oracle database management system (clients, server)"
cd /tmp
wget https://oss.oracle.com/debian/dists/unstable/non-free/binary-i386/oracle-xe_10.2.0.1-1.1_i386.deb
wget https://oss.oracle.com/debian/dists/unstable/non-free/binary-i386/oracle-xe-client_10.2.0.1-1.2_i386.deb
dpkg -i oracle-xe_10.2.0.1-1.1_i386.deb
dpkg -i oracle-xe-client_10.2.0.1-1.2_i386.deb
echo "### NOTE: when asked for a password, type 'testpass'"
service oracle-xe configure

echo "### Download the Oracle Basic and SDK Instant Client packages from the OTN Instant Client page, http://www.oracle.com/technetwork/database/features/instant-client/ (e.g. instantclient-basic-linux-11.2.0.3.0.zip and instantclient-sdk-linux-11.2.0.3.0.zip), open a separate shell and unzip them in /opt directory"
echo "### Hit ENTER when you have done it"
read enter
cd /opt/instantclient_*
ln -s libclntsh.so.11.1 libclntsh.so

echo "### Configuring PHP for Oracle"
echo "### NOTE: when asked for a path, provide instantclient,/opt/instantclient_<VERSION>"
pecl install oci8
echo "extension=oci8.so" > /etc/php5/conf.d/99-oracle.ini
sed -i 's/\;oci8.privileged_connect = Off/oci8.privileged_connect = On/g' /etc/php5/*/php.ini

echo "### Patching /etc/profile with new and modified environment variables"
cat << EOF >> /etc/profile

# Oracle
export ORACLE_HOME=/usr/lib/oracle/xe/app/oracle/product/10.2.0/server
export ORACLE_SID=XE

# IBM DB2
export IBM_DB_HOME=/opt/ibm/db2/V9.5
export IBM_DB_LIB=/opt/ibm/db2/V9.5/lib32

# IBM Informix
export INFORMIXDIR=/opt/IBM/informix
export INFORMIXSERVER=ol_informix1170
export ONCONFIG=onconfig.ol_informix1170
export INFORMIXSQLHOSTS=/opt/IBM/informix/etc/sqlhosts.ol_informix1170
export ODBCINI=/etc/odbc.ini
#export CLIENT_LOCALE=en_US.8859-1

export LD_LIBRARY_PATH=/usr/lib/oracle/xe/app/oracle/product/10.2.0/server/lib:/opt/ibm/db2/V9.5/lib32:/opt/IBM/informix/lib:/opt/IBM/informix/lib/cli:/opt/IBM/informix/lib/esql:/opt/IBM/informix/lib/tools
EOF

source /etc/profile

cat << EOF >> /etc/profile

# PATH
export PATH=\$PATH:${ORACLE_HOME}/bin:${IBM_DB_HOME}/bin:${INFORMIXDIR}/bin:${INFORMIXDIR}/extend/krakatoa/jre/bin
EOF

source /etc/profile

echo "### Initializing Oracle test database and table"
sqlplus SYS/testpass@//127.0.0.1:1521/XE AS SYSDBA << EOF
@/var/www/sqlmap/schema/oracle.sql;
ALTER system SET processes=300 scope=spfile;
ALTER system SET sessions=300 scope=spfile;
EOF
service oracle-xe restart

echo "### Initializing system to allow installation of IBM DB2"
cat << EOF >> /etc/sysctl.conf

# Setting for IBM DB2
fs.aio-max-nr = 1048576
fs.file-max = 6815744
kernel.shmall = 2097152
kernel.shmmax = 536870912
kernel.shmmni = 4096
kernel.sem = 250 32000 100 128
net.ipv4.ip_local_port_range = 9000 65500
net.core.rmem_default = 262144
net.core.rmem_max = 4194304
net.core.wmem_default = 262144
net.core.wmem_max = 1048586
EOF
sysctl -p
aptitude install alien autoconf2.13 binutils build-essential cpp-4.4 debhelper g++-4.4 gawk gcc-4.4 gcc-4.4-base gettext html2text ia32-libs-i386 intltool-debian ksh lesstif2 libaio-dev libaio1 libbeecrypt7 libc6 libc6-dev libc6-dev libdb4.8 libelf-dev libelf1 libltdl-dev libltdl7 libodbcinstq4-1 libqt4-core libqt4-gui libsqlite3-0 libstdc++5 libstdc++6 libstdc++6-4.4-dev lsb lsb-core lsb-cxx lsb-desktop lsb-graphics lsb-qt4 make odbcinst openjdk-6-jdk pax po-debconf rpm rpm-common sysstat tzdata-java unixodbc unixodbc-dev unzip xorg iceweasel

echo "### Download IBM DB2 trial from IBM software portal, http://www14.software.ibm.com/webapp/download/preconfig.jsp?id=2007-10-30+16%3A22%3A45.136755R&S_TACT=&S_CMP= and install it in a separate shell"
echo "### An how-to can be found on http://edin.no-ip.com/blog/hswong3i/ibm-db2-v9-7-apache-2-2-php5-3-debian-squeeze-howto"
echo "### Hit ENTER when you have done it"
read enter

cd /tmp
su -c "/opt/ibm/db2/V9.5/bin/db2 \"CREATE DATABASE testdb\"" db2inst1
su -c "/opt/ibm/db2/V9.5/bin/db2 < /var/www/sqlmap/schema/db2.sql" db2inst1

echo "### Configuring PHP for IBM DB2"
echo "### NOTE: when asked for the DB2 installation directory, provide /opt/ibm/db2/V9.5"
pecl install ibm_db2
echo "extension=ibm_db2.so" > /etc/php5/conf.d/99-db2.ini

echo "### NOTE: when asked for a password, type 'testpass'"
adduser informix
passwd informix

echo "### Download IBM Informix (client and server) from IBM software portal, https://www14.software.ibm.com/webapp/download/search.jsp?pn=Informix+Dynamic+Server and install it in a separate shell"
echo "### Hit ENTER when you have done it"
read enter
#wget https://www6.software.ibm.com/sdfdl/2v2/regs2/mstadm/informix/Xa.2/Xb.b8S61sgMER4Xv-OZtTA_T2rbXlP3haBaZHqUsM_qyQ/Xc.iif.11.70.UC7DE.Linux-RHEL5.tar/Xd./Xf.LPr.D1vk/Xg.6871728/Xi.ifxids/XY.regsrvs/XZ.g9hQ35T595nVz7Ids2e0cBZguOE/iif.11.70.UC7DE.Linux-RHEL5.tar
#tar xvf iif.11.70.UC7DE.Linux-RHEL5.tar
#chmod +x ids_install
#./ids_install
# NOTE: in recent versions, client SDK is part of the server installer
#wget https://www6.software.ibm.com/sdfdl/2v2/regs2/mstadm/informix/Xa.2/Xb.YBTN_DlRQVtTQcv6rNBKpda1x-zsBonq_4dH2lYTYQ/Xc.clientsdk.3.70.UC5DE.LINUX.tar/Xd./Xf.LPr.D1vk/Xg.6872524/Xi.ifxdl/XY.regsrvs/XZ._9ztqA4zY_TE9mCBH0YaP9Gkl5k/clientsdk.3.70.UC5DE.LINUX.tar
#tar xvf clientsdk.3.70.UC5DE.LINUX.tar
#./installclientsdk
ln -fs /opt/IBM/informix/etc/sqlhosts.ol_informix1170 /opt/IBM/informix/etc/sqlhosts
ln -fs /opt/IBM/informix/etc/onconfig.ol_informix1170 /opt/IBM/informix/etc/onconfig
echo "FULL_DISK_INIT 1" >> /opt/IBM/informix/etc/onconfig
cat << EOF > /opt/IBM/informix/etc/sqlhosts
ol_informix1170 onipcshm    localhost       none
dr_informix1170 onsoctcp    localhost       dr_informix1170
EOF
onclean -ky
oninit -iyv

echo "### Initializing Informix test database and table"
dbaccessdemo7
isql inf -v < /var/www/sqlmap/schema/informix.sql

echo "### Configuring PHP for IBM Informix"
echo "### NOTE: when asked for the Informix installation directory, provide /opt/IBM/informix"
aptitude install php5-dev re2c
cd /tmp
wget http://pecl.php.net/get/PDO_INFORMIX-1.3.1.tgz
tar xvfz PDO_INFORMIX-1.3.1.tgz
cd PDO_INFORMIX-1.3.0
phpize
ln -s /usr/include/php5 /usr/include/php
./configure
make
make install
echo "extension=pdo_informix.so" > /etc/php5/conf.d/99-pdo_informix.ini

echo "### Initializing Microsoft Access and Informix ODBC driver"
cat << EOF > /etc/odbc.ini
[ODBC Data Sources]
testdb=Microsoft Access Database of testdb
inf=Informix

[testdb]
Description = Microsoft Access Database of testdb
Driver      = MDBToolsODBC
Database    = /var/www/sqlmap/dbs/access/testdb.mdb
Servername  = localhost
UserName    =
Password    =
port        = 4747

[inf]
Description=Informix
Driver=/opt/IBM/informix/lib/cli/iclit09b.so
Database=stores_demo
LogonID=informix
pwd=testpass
Servername=ol_informix1170
CursorBehavior=0
CLIENT_LOCALE=en_US.8859-1
DB_LOCALE=en_US.819
TRANSLATIONDLL=/opt/IBM/informix/lib/esql/igo4a304.so

[ODBC]
UNICODE=UCS-4
Trace=0
TraceFile=/tmp/odbctrace.out
InstallDir=/opt/IBM/informix
TRACEDLL=idmrs09a.so
EOF

cat << EOF > /etc/odbcinst.ini
[ODBC Drivers]
MDBToolsODBC=Installed
Informix=Installed

[MDBToolsODBC]
Description = MDB Tools ODBC drivers
Driver      = /usr/lib/i386-linux-gnu/odbc/libmdbodbc.so.1
Setup       =
FileUsage   = 1
CPTimeout   =
CPReuse     =
UsageCount  = 1

[Informix]
Driver=/opt/IBM/informix/lib/cli/iclit09b.so
Setup=/opt/IBM/informix/lib/cli/iclit09b.so
APILevel=1
ConnectFunctions=YYY
DriverODBCVer=03.51
FileUsage=0
SQLLevel=1
smProcessPerConnect=Y
EOF

# TODO: Add Ingres

# HSQLDB - Apache Tomcat
echo "### Downloading and deploying Tomcat for HSQLDB testbed"
cd /tmp
apt-get install tomcat7
chown -R tomcat7 /var/lib/tomcat7/
cp -r /var/www/sqlmap/hsqldb/ /var/lib/tomcat7/webapps/hsqldb_1_7_2
cp -r /var/www/sqlmap/hsqldb/ /var/lib/tomcat7/webapps/hsqldb_2_2_9

echo "### Compiling Java for HSQLDB testbed"
mkdir /var/lib/tomcat7/webapps/hsqldb_1_7_2/WEB-INF/classes/
javac -classpath /usr/share/tomcat7/lib/servlet-api.jar /var/www/sqlmap/hsqldb/src/*.java
mv -f /var/www/sqlmap/hsqldb/src/*.class /var/lib/tomcat7/webapps/hsqldb_1_7_2/WEB-INF/classes/

# Replace the connection class name and database name for different versions
mkdir /var/lib/tomcat7/webapps/hsqldb_2_2_9/WEB-INF/classes/
sed -i -e 's/org.hsqldb.jdbcDriver/org.hsqldb.jdbc.JDBCDriver/' /var/www/sqlmap/hsqldb/src/Register.java
sed -i -e 's/org.hsqldb.jdbcDriver/org.hsqldb.jdbc.JDBCDriver/' /var/www/sqlmap/hsqldb/src/ViewRecords.java
sed -i -e 's/jdbc:hsqldb:hsqldb-1_7_2/jdbc:hsqldb:hsqldb-2_2_9/' /var/www/sqlmap/hsqldb/src/Register.java
sed -i -e 's/jdbc:hsqldb:hsqldb-1_7_2/jdbc:hsqldb:hsqldb-2_2_9/' /var/www/sqlmap/hsqldb/src/ViewRecords.java
javac -classpath /usr/share/tomcat7/lib/servlet-api.jar /var/www/sqlmap/hsqldb/src/*.java
mv -f /var/www/sqlmap/hsqldb/src/*.class /var/lib/tomcat7/webapps/hsqldb_2_2_9/WEB-INF/classes/

echo "### Downloading HSQLDB 1.7.2.11"
wget http://kent.dl.sourceforge.net/project/hsqldb/hsqldb/hsqldb_1_7_2/hsqldb_1_7_2_11.zip
unzip -q hsqldb_1_7_2_11.zip
mkdir /var/lib/tomcat7/webapps/hsqldb_1_7_2/WEB-INF/lib/
mv -f /tmp/hsqldb/lib/hsqldb.jar /var/lib/tomcat7/webapps/hsqldb_1_7_2/WEB-INF/lib/
rm -rf hsqldb*

echo "### Downloading HSQLDB 2.2.9"
wget http://kent.dl.sourceforge.net/project/hsqldb/hsqldb/hsqldb_2_2/hsqldb-2.2.9.zip
unzip -q hsqldb-2.2.9.zip
mkdir /var/lib/tomcat7/webapps/hsqldb_2_2_9/WEB-INF/lib/
mv -f /tmp/hsqldb-2.2.9/hsqldb/lib/hsqldb.jar /var/lib/tomcat7/webapps/hsqldb_2_2_9/WEB-INF/lib/.
rm -rf hsqldb*

echo "### Restarting Tomcat"
service tomcat7 restart

echo "### Starting DBMS at boot"
cat << EOF > /etc/rc.local
#!/bin/sh -e
#
# rc.local
#
# This script is executed at the end of each multiuser runlevel.
# Make sure that the script will "exit 0" on success or any other
# value on error.
#
# In order to enable or disable this script just change the execution
# bits.
#
# By default this script does nothing.

# Start IBM DB2 at boot
su -c /home/db2inst1/sqllib/adm/db2start db2inst1

# Start IBM Informix at boot
/opt/IBM/informix/bin/oninit -v
exit 0
EOF

echo "### Restarting Apache web server (following installation and setup of PHP modules)"
service apache2 restart

echo "### Checking out sqlmap source code into /opt/sqlmap"
git clone https://github.com/sqlmapproject/sqlmap.git /opt/sqlmap

echo "### Installing sqlmap dependencies"
aptitude install python-setuptools python-dev python-kinterbasdb python-pymssql python-psycopg2 python-pyodbc python-pymssql python-sqlite python-impacket python-jpype
git clone https://github.com/petehunt/PyMySQL /tmp/PyMySQL
cd /tmp/PyMySQL
python setup.py install
cd /tmp
wget http://downloads.sourceforge.net/project/cx-oracle/5.1.2/cx_Oracle-5.1.2.tar.gz
tar xvfz cx_Oracle-5.1.2.tar.gz
cd cx_Oracle-5.1.2
python setup.py install
cd /tmp
git clone https://code.google.com/p/ibm-db ibm-db
cd ibm-db/IBM_DB/ibm_db
python setup.py install
cd /tmp
svn checkout http://python-ntlm.googlecode.com/svn/trunk/ python-ntlm
cd python-ntlm/python26
python setup.py install
easy_install jaydebeapi

echo "### Clean up installation"
aptitude clean

echo "### Patching ~/.bashrc"
cat << EOF >> ~/.bashrc

alias mysqlconn='mysql -u root -p testdb'
alias pgsqlconn='psql -h 127.0.0.1 -p 5432 -U postgres -W testdb'
alias oracleconn='sqlplus SYS/testpass@//127.0.0.1:1521/XE AS SYSDBA'
alias oracleconnscott='sqlplus SCOTT/testpass@//127.0.0.1:1521/XE'
alias db2conn='db2'
alias sqliteconn='sqlite /var/www/sqlmap/dbs/sqlite/testdb.sqlite'
alias sqlite3conn='sqlite3 /var/www/sqlmap/dbs/sqlite/testdb.sqlite3'
alias firebirdconn='isql-fb -u SYSDBA -p testpass /var/www/sqlmap/dbs/firebird/testdb.fdb'
alias accessconn='isql testdb -v'
alias informixconn='isql inf -v'

alias mysqlconnsqlmap='python /opt/sqlmap/sqlmap.py -d mysql://root:testpass@127.0.0.1:3306/testdb -b --sql-shell -v 6'
alias pgsqlconnsqlmap='python /opt/sqlmap/sqlmap.py -d postgresql://postgres:testpass@127.0.0.1:5432/testdb -b --sql-shell -v 6'
alias oracleconnsqlmap='python /opt/sqlmap/sqlmap.py -d oracle://SYS:testpass@127.0.0.1:1521/XE -b --sql-shell -v 6'
alias oracleconnscottsqlmap='python /opt/sqlmap/sqlmap.py -d oracle://SCOTT:testpass@127.0.0.1:1521/XE -b --sql-shell -v 6'
alias db2connsqlmap='python /opt/sqlmap/sqlmap.py -d db2://db2inst1:testpass@127.0.0.1:50000/testdb -b --sql-shell -v 6'
alias sqliteconnsqlmap='python /opt/sqlmap/sqlmap.py -d sqlite:///var/www/sqlmap/dbs/sqlite/testdb.sqlite -b --sql-shell -v 6'
alias sqlite3connsqlmap='python /opt/sqlmap/sqlmap.py -d sqlite3:///var/www/sqlmap/dbs/sqlite/testdb.sqlite3 -b --sql-shell -v 6'
alias firebirdconnsqlmap='python /opt/sqlmap/sqlmap.py -d firebird://SYSDBA:testpass@/var/www/sqlmap/dbs/firebird/testdb.fdb -b --sql-shell -v 6'
alias accessconnsqlmap='python /opt/sqlmap/sqlmap.py -d access:///var/www/sqlmap/dbs/access/testdb.mdb -b --sql-shell -v 6'

alias upgradeall='aptitude update && aptitude -y full-upgrade && aptitude clean && sync'
EOF
source ~/.bashrc

