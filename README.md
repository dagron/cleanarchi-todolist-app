# Install

``` bash
./docker-compose up -d
docker exec -ti todolist_cli bash

(inside docker todolist_cli):

npm install
composer install
php bin/console doctrine:schema:update --force
```

# MakingOf

``` bash
composer create-project symfony/skeleton todolist
composer require encore
composer require annotations
composer require twig
composer require make --dev
composer require asset
composer require orm
composer require debug
composer require apache-pack
composer require form
composer require validation

php bin/console make:controller
-> HomeController

npm install skeleton-css --save
npm install sass-loader node-sass --save-dev
npm install vue vue-loader vue-template-compiler --save

php bin/console doctrine:schema:update --force
```