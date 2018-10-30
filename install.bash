#/bin/bash
. .env
mkdir ./mysql
docker-compose up -d
cp ./www/pub2.0/.env.example ./www/pub2.0/.env
docker exec blogdocker_php-fpm_1 composer update -d /var/www/html/pub2.0
docker exec blogdocker_mysql_1 mysqladmin -u"$DB_USERNAME" -p"$DB_PASSWORD" create "$PUB_DATABASE";
docker exec blogdocker_php-fpm_1 php /var/www/html/pub2.0/artisan k:g
docker exec blogdocker_php-fpm_1 php /var/www/html/pub2.0/artisan migrate
echo "DB_USERNAME=$DB_USERNAME" >> ./www/pub2.0/.env
echo "DB_PASSWORD=$DB_PASSWORD" >> ./www/pub2.0/.env
echo "PUB_DATABASE=$PUB_DATABASE" >> ./www/pub2.0/.env
echo "BLOG_HOME_NAME=$BLOG_HOME_NAME" >> ./www/pub2.0/.env
echo "BLOG_ADMIN_EMAIL=$BLOG_ADMIN_EMAIL" >> ./www/pub2.0/.env
echo "BLOG_ADMIN_PASSWORD=$BLOG_ADMIN_PASSWORD" >> ./www/pub2.0/.env
echo "BLOG_NAME=$BLOG_NAME" >> ./www/pub2.0/.env
echo "HOME_PICTURE=$HOME_PICTURE" >> ./www/pub2.0/.env
echo "SUCCESS INSTALL 0(^_^)0"
