# -*- mode: ruby -*-
# vi: set ft=ruby :

#Parallels provider nehmen, der ist 100 Mal schneller
Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/xenial64"
  config.vm.synced_folder ".", "/var/www/html", :mount_options => ['dmode=777']
  config.vm.network "forwarded_port", guest: 80, host: 8089
  config.vm.provision :shell, path: "bootstrap.sh"
  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
    v.cpus = 1
  end
end
