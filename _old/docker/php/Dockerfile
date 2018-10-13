FROM php:7-fpm

# User permissions
RUN usermod -u 1000 www-data
RUN chown -R 1000 /var/www/

RUN apt-get update && apt-get install -y wget vim nano gnupg bash-completion iputils-ping zlib1g-dev libxslt-dev libicu-dev g++ libssl-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libsasl2-dev libcurl4-openssl-dev pkg-config libxrender1 libfontconfig1 --fix-missing

RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install bcmath ftp gd iconv intl mbstring opcache pcntl pdo pdo_mysql soap xsl zip

# Custom PHP settings
ADD application.ini /usr/local/etc/php/conf.d/application.ini

# Composer
RUN curl -LsS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN chmod a+x /usr/local/bin/composer
RUN chown 1000 /usr/local/bin/composer

# CS Fixer
RUN curl -LsS http://get.sensiolabs.org/php-cs-fixer.phar -o /usr/local/bin/php-cs-fixer
RUN chmod a+x /usr/local/bin/php-cs-fixer

# PHPUnit
RUN curl -LsS https://phar.phpunit.de/phpunit.phar -o /usr/local/bin/phpunit
RUN chmod a+x /usr/local/bin/phpunit

# Security checker
RUN curl -LsS http://get.sensiolabs.org/security-checker.phar -o /usr/local/bin/security-checker
RUN chmod a+x /usr/local/bin/security-checker

# Node
RUN curl -sL https://deb.nodesource.com/setup_9.x | bash -
RUN apt-get update && apt-get install -y nodejs --fix-missing

# Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn --fix-missing

# Git
RUN apt-get update && apt-get install -y git --fix-missing
RUN git config --global push.default matching

# Blackfire
RUN wget -O - https://packagecloud.io/gpg.key | apt-key add -
RUN echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
RUN apt-get update && apt-get install -y blackfire-agent blackfire-php --fix-missing

#RUN pecl install xdebug
#RUN docker-php-ext-enable xdebug

ENTRYPOINT sh /var/www/html/docker/php/entrypoint.sh && php-fpm

ADD .bashrc /var/www/.bashrc

RUN echo "export TERM=xterm" >> /etc/bash.bashrc
