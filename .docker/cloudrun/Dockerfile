FROM php:7.4-fpm-alpine

COPY ./php.ini /usr/local/etc/php/php.ini
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk --update --no-cache add nginx supervisord wget

RUN mkdir -p /run/nginx

COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN chown -R www-data: /app

CMD sh /app/.docker/cloudrun/startup.sh