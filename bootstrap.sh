#!/usr/bin/env bash

apt-get update
apt-get install -y software-properties-common python-software-properties
add-apt-repository ppa:webupd8team/java
apt-get update

debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password root'
echo debconf shared/accepted-oracle-license-v1-1 select true | sudo debconf-set-selections
echo debconf shared/accepted-oracle-license-v1-1 seen true | sudo debconf-set-selections

apt-get install -y curl php5 php5-curl php5-xdebug php5-mysql git ant
apt-get install -y oracle-java8-installer
apt-get install -y oracle-java8-set-default

apt-get install -y npm
npm install -g bower
ln -s /usr/bin/nodejs /usr/bin/node

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

# see https://getcomposer.org/doc/articles/troubleshooting.md#proc-open-fork-failed-errors
/bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
/sbin/mkswap /var/swap.1
/sbin/swapon /var/swap.1

chmod 0755 /var/www/html/vendor/phpunit/phpunit/phpunit
chmod 0755 /var/www/html/vendor/behat/behat/bin/behat
chmod 0755 /var/www/html/vendor/alcaeus/liquibase/liquibase

apt-get install -y mysql-server libmysql-java

cp /var/www/html/deployment/000-default.conf /etc/apache2/sites-enabled/000-default.conf
a2enmod rewrite
service apache2 restart

git config --global user.name "Rudi Bieller"
git config --global user.email "kontakt@rudi-bieller.de"
