#/bin/bash
. .env
mkdir ./mysql
cp ./www/pub2.0/.env.example ./www/pub2.0/.env
docker exec dnmp_php-fpm_1 composer update -d /var/www/html/pub2.0
docker exec dnmp_mysql_1 mysqladmin -u"$DB_USERNAME" -p"$DB_PASSWORD" create "$PUB_DATABASE";
docker exec dnmp_php-fpm_1 php /var/www/html/pub2.0/artisan k:g
docker exec dnmp_php-fpm_1 php /var/www/html/pub2.0/artisan migrate
echo "SUCCESS INSTALL 0(^_^)0"
