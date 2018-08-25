FROM php:7-fpm

RUN apt-get update && apt-get install -y wget vim nano git gnupg bash-completion iputils-ping zlib1g-dev libicu-dev g++ libssl-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libsasl2-dev libcurl4-openssl-dev pkg-config libxrender1 libfontconfig1 --fix-missing

RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install bcmath ftp gd iconv intl mbstring opcache pcntl pdo pdo_mysql soap zip

RUN curl -LsS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN composer global require sllh/composer-versions-check

RUN curl -LsS http://get.sensiolabs.org/php-cs-fixer.phar -o /usr/local/bin/php-cs-fixer
RUN chmod a+x /usr/local/bin/php-cs-fixer

RUN curl -LsS https://phar.phpunit.de/phpunit.phar -o /usr/local/bin/phpunit
RUN chmod a+x /usr/local/bin/phpunit

RUN curl -LsS http://get.sensiolabs.org/security-checker.phar -o /usr/local/bin/security-checker
RUN chmod a+x /usr/local/bin/security-checker

RUN curl -LsS https://github.com/sensiolabs-de/deprecation-detector/releases/download/0.1.0-alpha4/deprecation-detector.phar -o /usr/local/bin/deprecation-detector
RUN chmod a+x /usr/local/bin/deprecation-detector

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get update && apt-get install -y nodejs --fix-missing

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt-get update && apt-get install -y yarn --fix-missing

RUN git config --global push.default matching

ADD application.ini /usr/local/etc/php/conf.d/application.ini

RUN wget -O - https://packagecloud.io/gpg.key | apt-key add -
RUN echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
RUN apt-get update && apt-get install -y blackfire-agent blackfire-php --fix-missing
ENTRYPOINT sh /var/www/html/docker/php/entrypoint.sh && php-fpm

ADD .bashrc /var/www/.bashrc

RUN usermod -u 1000 www-data
RUN chown -R 1000 /var/www/

RUN echo "export TERM=xterm" >> /etc/bash.bashrc
