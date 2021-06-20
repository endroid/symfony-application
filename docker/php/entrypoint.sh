#!/usr/bin/env bash

# GITHUB OAUTH

if [ "$GITHUB_OAUTH_TOKEN" != "" ]; then
    mkdir -p /var/www/.composer /root/.composer
    chmod -R 777 /var/www/.composer /root/.composer
    echo "{ \"github-oauth\": { \"github.com\": \"$GITHUB_OAUTH_TOKEN\" }}" > /var/www/.composer/auth.json
    echo "{ \"github-oauth\": { \"github.com\": \"$GITHUB_OAUTH_TOKEN\" }}" > /root/.composer/auth.json
fi

# ERROR REPORTING

if [ "$ENVIRONMENT" != "DEV" ]; then
    sed -i 's/^display_startup_errors.*$/display_startup_errors = Off/' /usr/local/etc/php/conf.d/zzzz-config.ini
    sed -i 's/^display_errors.*$/display_errors = Off/' /usr/local/etc/php/conf.d/zzzz-config.ini
else
    sed -i 's/^display_startup_errors.*$/display_startup_errors = On/' /usr/local/etc/php/conf.d/zzzz-config.ini
    sed -i 's/^display_errors.*$/display_errors = On/' /usr/local/etc/php/conf.d/zzzz-config.ini
fi

composer self-update
