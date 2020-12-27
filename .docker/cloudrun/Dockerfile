FROM php:7.4-fpm-alpine

COPY ./php.ini /usr/local/etc/php/php.ini
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk --update --no-cache add \
  curl \
  libzip-dev \
  libpng-dev \
  autoconf \
  gcc \
  g++ \
  make \
  git \
  bash \
  icu-dev \
  oniguruma-dev \
  nodejs \
  nodejs-npm && \
  rm -rf /var/cache/apk/* && \
  git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis && \
  # Install XDebug
  pecl install xdebug && \
  docker-php-ext-enable xdebug && \
  # Install PHP Extension
  docker-php-ext-install \
  pdo_mysql \
  bcmath \
  mbstring \
  zip \
  opcache \
  gd \
  intl \
  redis && \
  # 本家(https://packagist.org/)が不調な時は日本版ミラーサイトを使用
  composer config -g repos.packagist composer https://packagist.jp && \
  # composer plugin (https://github.com/hirak/prestissimo)
  composer global require hirak/prestissimo

RUN mkdir -p /run/nginx

COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app

RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN chown -R www-data: /app

CMD sh /app/.docker/cloudrun/startup.sh