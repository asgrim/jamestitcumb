# jamestitcumb.com

[![Build Status](https://travis-ci.org/asgrim/jamestitcumb.svg?branch=master)](https://travis-ci.org/asgrim/jamestitcumb)

This is my website.

It's still work in progress, naturally.

## Installation

 * Clone it: `git clone git@github.com:asgrim/jamestitcumb.git`
 * Composer install: `composer install --no-dev --optimize-autoloader`
 * Configure: `cp config/autoload/local.php.dist config/autoload/local.php` and change if necessary
 * Serve it with Docker (see below)

## Docker stuff

```bash
$ docker-compose build
$ docker-compose up
$ docker-compose run php-fpm composer install
```

### Running tests

```bash
$ docker-compose up
$ docker-compose exec php-fpm vendor/bin/phpunit
```

### Index stuff again

```bash
$ docker-compose exec php-fpm /app/app.php index-posts
```
