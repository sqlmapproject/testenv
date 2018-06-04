FROM debian:wheezy

# Updating base system
RUN apt-get update
RUN apt-get upgrade -y

# Installing Apache, PHP, git and generic PHP modules
RUN DEBIAN_FRONTEND=noninteractive apt-get -qq -y install apache2 libapache2-mod-php5 git php5-dev php5-gd php-pear \
                       php5-mysql php5-pgsql php5-sqlite php5-interbase php5-sybase \
                       php5-odbc unzip make libaio1 bc screen htop git \
                       subversion sqlite sqlite3 mysql-server mysql-client libmysqlclient-dev \
                       netcat libssl-dev libtool zlib1g-dev libc6-dev

# Configuring Apache and PHP
RUN rm /var/www/index.html
RUN mkdir /var/www/test
RUN chmod 777 /var/www/test
RUN a2enmod auth_basic auth_digest
RUN sed -i 's/AllowOverride None/AllowOverride AuthConfig/' /etc/apache2/sites-enabled/*
RUN sed -i 's/magic_quotes_gpc = On/magic_quotes_gpc = Off/g' /etc/php5/*/php.ini

# Copy sqlmap test environment to /var/www
COPY . /var/www/sqlmap/
WORKDIR /var/www/sqlmap

# Listen on port 80
EXPOSE 80

CMD ["/var/www/sqlmap/docker/run.sh"]
