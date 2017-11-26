#!/usr/bin/env bash

# BLACKFIRE

if [ $BLACKFIRE_SERVER_ID != "" ] && [ $BLACKFIRE_SERVER_TOKEN != "" ]; then
    sed -i 's/^server-id.*$/server-id='$BLACKFIRE_SERVER_ID'/' /etc/blackfire/agent
    sed -i 's/^server-token.*$/server-token='$BLACKFIRE_SERVER_TOKEN'/' /etc/blackfire/agent
    sed -i 's/^blackfire.server_id.*$/blackfire.server_id = '$BLACKFIRE_SERVER_ID'/' /usr/local/etc/php/conf.d/application.ini
    sed -i 's/^blackfire.server_token.*$/blackfire.server_token = '$BLACKFIRE_SERVER_TOKEN'/' /usr/local/etc/php/conf.d/application.ini
    /etc/init.d/blackfire-agent start
fi

# GITHUB OAUTH

if [ $GITHUB_OAUTH_TOKEN != "" ]; then
    mkdir /var/www/.composer
    chmod -R 777 /var/www/.composer
    echo "{ \"github-oauth\": { \"github.com\": \"$GITHUB_OAUTH_TOKEN\" }}" > /var/www/.composer/auth.json
fi

# ERROR REPORTING

if [ $ENVIRONMENT != DEV ]; then
    sed -i 's/^display_startup_errors.*$/display_startup_errors = Off/' /usr/local/etc/php/conf.d/application.ini
    sed -i 's/^display_errors.*$/display_errors = Off/' /usr/local/etc/php/conf.d/application.ini
else
    sed -i 's/^display_startup_errors.*$/display_startup_errors = On/' /usr/local/etc/php/conf.d/application.ini
    sed -i 's/^display_errors.*$/display_errors = On/' /usr/local/etc/php/conf.d/application.ini
fi

npm install yarn -g
