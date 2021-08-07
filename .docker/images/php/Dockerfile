FROM php:8.0-fpm


RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git libpq-dev make supervisor\
    && docker-php-ext-install sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql && pecl install ds\
    && pecl install xdebug && pecl install redis && docker-php-ext-enable xdebug redis

RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail \
    && echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025"' >> /usr/local/etc/php/php.ini

RUN apt-get install -y libzip-dev zip && docker-php-ext-install zip
RUN usermod -u 1000 www-data

COPY conf.d     $PHP_INI_DIR/conf.d/
COPY supervisor.conf /etc/supervisor/conf.d/
COPY rabbit_check.sh /tmp/
COPY entrypoint.sh /

RUN apt install -y netcat && chmod +x /tmp/rabbit_check.sh && chmod +x /entrypoint.sh
EXPOSE 9000

ENTRYPOINT '/entrypoint.sh'
