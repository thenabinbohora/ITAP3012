#!/usr/bin/env bash
set -euo pipefail

DB_ROOT_PASSWORD="${DB_ROOT_PASSWORD:-admin123}"
APP_DB="${APP_DB:-appdb}"
APP_DB_USER="${APP_DB_USER:-user}"
APP_DB_PASS="${APP_DB_PASS:-user123}"
DOC_ROOT="/workspaces/$(basename "$PWD")/public"

sudo apt update
export DEBIAN_FRONTEND=noninteractive
sudo apt install -y apache2 php libapache2-mod-php php-mysql \
  php-xml php-mbstring php-curl php-zip php-gd mariadb-server mariadb-client

sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/dbconfig-install boolean true"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/app-password-confirm password ${DB_ROOT_PASSWORD}"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/admin-pass password ${DB_ROOT_PASSWORD}"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/mysql/app-pass password ${DB_ROOT_PASSWORD}"
sudo debconf-set-selections <<< "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2"
sudo apt install -y phpmyadmin

sudo a2enmod rewrite

mkdir -p "$DOC_ROOT"
if [ ! -f "$DOC_ROOT/index.php" ]; then
  cat > "$DOC_ROOT/index.php" <<'PHP'
<?php phpinfo();
PHP
fi

sudo tee /etc/apache2/sites-available/000-default.conf >/dev/null <<CONF
<VirtualHost *:80>
    DocumentRoot ${DOC_ROOT}
    <Directory ${DOC_ROOT}>
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
CONF

sudo chown -R "$USER":"$USER" "$DOC_ROOT"
sudo service apache2 restart || sudo apache2ctl -k restart
sudo service mariadb start || true

mysql -u root <<SQL
ALTER USER 'root'@'localhost' IDENTIFIED BY '${DB_ROOT_PASSWORD}';
FLUSH PRIVILEGES;
CREATE DATABASE IF NOT EXISTS \`${APP_DB}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${APP_DB_USER}'@'localhost' IDENTIFIED BY '${APP_DB_PASS}';
GRANT ALL PRIVILEGES ON \`${APP_DB}\`.* TO '${APP_DB_USER}'@'localhost';
FLUSH PRIVILEGES;
SQL
