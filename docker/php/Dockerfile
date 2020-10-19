FROM php:7.4-fpm

# User permissions
RUN usermod -u 1000 www-data
RUN chown -R 1000 /var/www/

#RUN apt-get update && apt-get install -y  rsync libonig-dev  vim nano  bash-completion iputils-ping libxslt-dev zlib1g-dev  g++ libssl-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libsasl2-dev libcurl4-openssl-dev pkg-config libxrender1 libfontconfig1 --fix-missing
RUN apt-get update && apt-get install -y git gnupg libicu-dev libpng-dev libzip-dev unzip wget

#RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-freetype
#RUN docker-php-ext-install zip bcmath exif ftp  iconv  mbstring opcache pcntl pdo  soap xsl
#RUN docker-php-ext-configure intl

RUN docker-php-ext-install gd intl pdo_mysql zip

# Custom PHP settings
ADD zzzz-config.ini /usr/local/etc/php/conf.d/zzzz-config.ini

# Blackfire
RUN wget -q -O - https://packages.blackfire.io/gpg.key | apt-key add -
RUN echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
RUN apt-get update && apt-get install -y blackfire-agent blackfire-php --fix-missing

# Install pcov
RUN pecl install pcov
RUN docker-php-ext-enable pcov

ENTRYPOINT sh /var/www/html/docker/php/entrypoint.sh && php-fpm

ADD .bashrc /var/www/.bashrc

RUN echo "export TERM=xterm" >> /etc/bash.bashrc
