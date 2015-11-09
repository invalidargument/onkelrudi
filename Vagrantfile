# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.network "forwarded_port", guest: 80, host: 8089
  config.vm.provision :shell, path: "bootstrap.sh"
  # wahlweise file unter /vagrant/vendor/phpunit/phpunit/phpunit chmodden
  config.vm.synced_folder ".", "/vagrant", mount_options: ['dmode=777','fmode=777']
  # or chmod 0755 /vagrant/vendor/phpunit/phpunit/phpunit /vagrant/vendor/behat/behat/bin/behat
end
