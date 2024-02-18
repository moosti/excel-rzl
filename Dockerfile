FROM webdevops/php-nginx:8.2-alpine

ENV WEB_DOCUMENT_ROOT /app/public
ENV PHP_DATE_TIMEZONE "Asia/Tehran"
# enable cron tab
# RUN docker-service enable cron
# COPY ./docker /opt/docker

# RUN apk add --update mongodb-tools nodejs npm
# RUN apk add --update mysql-client
# RUN apk add --update openssh oniguruma-dev autoconf gcc g++ make libzip-dev

# RUN pecl channel-update pecl.php.net
# RUN pecl install swoole
# RUN docker-php-ext-enable swoole

WORKDIR /app

COPY --chown=application:application ./app .

# USER application:application

# RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

# RUN npm install
# RUN npm run production
# #remove node_modules folder
# RUN rm -rf node_modules
# #link storage
# RUN rm -rf public/storage
# RUN php artisan storage:link

# RUN php artisan cache:clear
# RUN php artisan view:clear

#RUN php artisan optimize

RUN chown -R application:application .
