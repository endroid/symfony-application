FROM php:8.0.0RC4-fpm

# User permissions
RUN usermod -u 1000 www-data
RUN chown -R 1000 /var/www/

RUN apt-get update && apt-get install -y git gnupg libfontconfig1 libfreetype6-dev libicu-dev libpng-dev libxrender1 libzip-dev unzip wget

RUN docker-php-ext-configure gd --with-freetype
RUN docker-php-ext-install gd intl pdo_mysql zip

# Install PCOV
RUN git clone --depth 1 https://github.com/krakjoe/pcov.git /usr/src/php/ext/pcov \
    && docker-php-ext-configure pcov --enable-pcov \
    && docker-php-ext-install pcov

# Custom PHP settings
ADD zzzz-config.ini /usr/local/etc/php/conf.d/zzzz-config.ini

# Blackfire
#RUN wget -q -O - https://packages.blackfire.io/gpg.key | apt-key add -
#RUN echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
#RUN apt-get update && apt-get install -y blackfire-agent blackfire-php --fix-missing

RUN ssh-keyscan -t rsa -H github.com >> /var/www/.ssh/known_hosts
RUN ssh-keyscan -t rsa -H github.com >> /root/.ssh/known_hosts

ENTRYPOINT sh /var/www/html/docker/php/entrypoint.sh && php-fpm

ADD .bashrc /var/www/.bashrc

RUN echo "export TERM=xterm" >> /etc/bash.bashrc
