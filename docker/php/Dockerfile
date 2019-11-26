FROM php:7.3-fpm

# User permissions
RUN usermod -u 1000 www-data
RUN chown -R 1000 /var/www/

RUN apt-get update && apt-get install -y git libzip-dev libonig-dev unzip wget vim nano gnupg bash-completion iputils-ping libxslt-dev zlib1g-dev libicu-dev g++ libssl-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libsasl2-dev libcurl4-openssl-dev pkg-config libxrender1 libfontconfig1 --fix-missing

RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install zip bcmath ftp gd iconv intl mbstring opcache pcntl pdo pdo_mysql soap xsl

# Custom PHP settings
ADD application.ini /usr/local/etc/php/conf.d/application.ini

# Composer
RUN curl -LsS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN chmod a+x /usr/local/bin/composer
RUN chown 1000 /usr/local/bin/composer

# Node
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get update && apt-get install -y nodejs --fix-missing

# Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn --fix-missing

# Blackfire
RUN wget -q -O - https://packages.blackfire.io/gpg.key | apt-key add -
RUN echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
#RUN apt-get update && apt-get install -y blackfire-agent blackfire-php --fix-missing

ENTRYPOINT sh /var/www/html/docker/php/entrypoint.sh && php-fpm

ADD .bashrc /var/www/.bashrc

RUN echo "export TERM=xterm" >> /etc/bash.bashrc
