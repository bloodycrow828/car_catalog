#!/usr/bin/env bash

#== Import script args ==

timezone=$(echo "$1")

#== Bash helpers ==

function info {
  echo " "
  echo "--> $1"
  echo " "
}

#== Provision script ==

info "Provision-script user: `whoami`"

export DEBIAN_FRONTEND=noninteractive

info "Configure timezone"
timedatectl set-timezone ${timezone} --no-ask-password

info "Prepare root password for MySQL"
debconf-set-selections <<< "mysql-community-server mysql-community-server/root-pass password \"''\""
debconf-set-selections <<< "mysql-community-server mysql-community-server/re-root-pass password \"''\""
echo "Done!"

info "Add PHp 7.1 repository"
add-apt-repository ppa:ondrej/php -y

info "Update OS software"
apt-get update
apt-get upgrade -y

info "Install additional software"
apt-get install -y php7.1-curl php7.1-cli php7.1-intl php7.1-mysqlnd php7.1-gd php7.1-fpm php7.1-mbstring php7.1-xml php7.1-zip unzip nginx mysql-server-5.7 php-xdebug

info "Configure MySQL"
sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
mysql -uroot <<< "CREATE USER 'root'@'%' IDENTIFIED BY '123'"
mysql -uroot <<< "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%'"
mysql -uroot <<< "DROP USER 'root'@'localhost'"
mysql -uroot <<< "FLUSH PRIVILEGES"
echo "Done!"

info "Configure PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php/7.1/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/7.1/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/7.1/fpm/pool.d/www.conf
echo "Done!"

info "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

info "Enabling site configuration"
ln -s /app/vagrant/nginx/app.conf /etc/nginx/sites-enabled/app.conf
echo "Done!"

info "Initailize databases for MySQL"
mysql -uroot -p'123' <<< "CREATE DATABASE car_catalog"
mysql -uroot -p'123' <<< "CREATE DATABASE car_catalog_test"
echo "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

info "Configure XDEBUG"
echo "xdebug.remote_autostart = on" >> /etc/php/7.1/fpm/php.ini
echo "xdebug.remote_enable = on" >> /etc/php/7.1/fpm/php.ini
echo "xdebug.remote_connect_back = on" >> /etc/php/7.1/fpm/php.ini
echo "xdebug.remote_host = 192.168.99.150" >> /etc/php/7.1/fpm/php.ini
echo "xdebug.remote_port = 9000" >> /etc/php/7.1/fpm/php.ini
echo "xdebug.remote_handler = dbgp" >> /etc/php/7.1/fpm/php.ini
echo "xdebug.idekey = vagrant" >> /etc/php/7.1/fpm/php.ini