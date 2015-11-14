#!/usr/bin/env bash

add-apt-repository ppa:webupd8team/java
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password root'
echo debconf shared/accepted-oracle-license-v1-1 select true | sudo debconf-set-selections
echo debconf shared/accepted-oracle-license-v1-1 seen true | sudo debconf-set-selections
apt-get update

apt-get install -y curl php5-common php5-cli php5-curl dh-make-php php5-dev git ant
apt-get install -y oracle-java8-installer
apt-get install -y oracle-java8-set-default

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

sudo pecl install xdebug
cat /vagrant/config/xdebug.ini.dist > /etc/php5/mods-available/xdebug.ini
php5enmod xdebug

# see https://getcomposer.org/doc/articles/troubleshooting.md#proc-open-fork-failed-errors
/bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
/sbin/mkswap /var/swap.1
/sbin/swapon /var/swap.1

chmod 0755 /vagrant/vendor/phpunit/phpunit/phpunit
chmod 0755 /vagrant/vendor/behat/behat/bin/behat
chmod 0755 /vagrant/vendor/alcaeus/liquibase/liquibase

apt-get install -y mysql-server libmysql-java