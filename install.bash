#/bin/bash
. .env
mkdir ./mysql
docker-compose up -d
cp ./www/pub2.0/.env.example ./www/pub2.0/.env
docker exec blogdocker_php-fpm_1 composer update -d /var/www/html/pub2.0
docker exec blogdocker_mysql_1 mysqladmin -u"$DB_USERNAME" -p"$DB_PASSWORD" create "$PUB_DATABASE";
docker exec blogdocker_php-fpm_1 php /var/www/html/pub2.0/artisan k:g
docker exec blogdocker_php-fpm_1 php /var/www/html/pub2.0/artisan migrate
echo "SUCCESS INSTALL 0(^_^)0"
