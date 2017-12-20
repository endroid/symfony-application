# Installation

## Create the project

    composer create-project endroid/symfony-application <target>

## Create the database and schema

    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force

## Set permissions

    HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
    sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
    sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs

## Install optional services

  * [`ElasticSearch`](http://www.elasticsearch.org/guide/reference/setup/installation/)
  * [`Redis`](http://redis.io/topics/quickstart)
  * [`wkhtmltopdf and wkhtmltoimage`](http://wkhtmltopdf.org/)

## Load optional fixtures

    php app/console doctrine:fixtures:load -n
    php app/console assets:install --symlink
    php app/console fos:elastica:populate

## Note

Please note that if you are using PHP < 5.4 and you want to make use of the provided behaviors
you will have to copy the trait code into your entities instead of using the traits.