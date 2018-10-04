FROM php:7-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    libmemcached-dev \
    libzmq3-dev \
    libmemcached-tools \
    memcached \
    mysql-client libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && pecl install zmq-beta \
    && docker-php-ext-enable zmq \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install sockets

#RUN groupadd -g 1000 app \
# && useradd -g 1000 -u 1000 -d /var/www -s /bin/bash app


# Install the php memcached extension
RUN curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
  && mkdir -p memcached \
  && tar -C memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
  && ( \
    cd memcached \
    && phpize \
    && ./configure \
    && make -j$(nproc) \
    && make install \
  ) \
  && rm -r memcached \
  && rm /tmp/memcached.tar.gz \
  && docker-php-ext-enable memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN composer global require "laravel/installer"

#USER app:app

CMD memcached -u nobody -d
