#!/usr/bin/env bash

rm -rf var/cache/*

php-cs-fixer fix src

yarn
composer install
node_modules/.bin/encore production

bin/console doctrine:database:drop --force
bin/console doctrine:database:create
bin/console doctrine:schema:update --force

bin/console doctrine:fixtures:load -n --fixtures=src/DataFixtures/ORM
