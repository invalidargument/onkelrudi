#!/usr/bin/env bash

apt-get update
apt-get install -y curl php5-common php5-cli php5-curl dh-make-php php5-dev git

curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

sudo pecl install xdebug
cat /vagrant/config/xdebug.ini.dist > /etc/php5/mods-available/xdebug.ini
php5enmod xdebug

# see https://getcomposer.org/doc/articles/troubleshooting.md#proc-open-fork-failed-errors
/bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
/sbin/mkswap /var/swap.1
/sbin/swapon /var/swap.1
