FROM debian:6.0.10

# Updating base system
RUN apt-get update
RUN apt-get upgrade -y

# Installing Apache, PHP, git and generic PHP modules
RUN apt-get install -y apache2 libapache2-mod-php5 git php5-dev php5-gd php-pear \
                       php5-mysql php5-pgsql php5-sqlite php5-interbase php5-sybase \
                       php5-odbc unzip make libaio1 bc screen htop git \
                       subversion sqlite sqlite3 mysql-client libmysqlclient-dev

# Configuring Apache and PHP
RUN rm /var/www/index.html
RUN mkdir /var/www/test
RUN chmod 777 /var/www/test
RUN a2enmod auth_basic auth_digest
RUN sed -i 's/AllowOverride None/AllowOverride AuthConfig/' /etc/apache2/sites-enabled/*
RUN sed -i 's/magic_quotes_gpc = On/magic_quotes_gpc = Off/g' /etc/php5/*/php.ini
RUN sed -i 's/extension=suhosin.so/;extension=suhosin.so/g' /etc/php5/conf.d/suhosin.ini

# Downloading sqlmap test environment to /var/www
WORKDIR /var/www
RUN git clone https://github.com/sqlmapproject/testenv.git sqlmap

# Listen on port 80
EXPOSE 80

WORKDIR /var/www/sqlmap
RUN chmod +x /var/www/sqlmap/docker/run.sh

CMD ["/var/www/sqlmap/docker/run.sh"]
