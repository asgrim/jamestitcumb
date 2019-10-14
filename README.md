# jamestitcumb.com

[![Build Status](https://travis-ci.org/asgrim/jamestitcumb.svg?branch=master)](https://travis-ci.org/asgrim/jamestitcumb) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/asgrim/jamestitcumb/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/asgrim/jamestitcumb/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/asgrim/jamestitcumb/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/asgrim/jamestitcumb/?branch=master)

This is my website.

It's still work in progress.

## Installation

 * Clone it: `git clone git@github.com:asgrim/jamestitcumb.git`
 * Composer install: `composer install --no-dev --optimize-autoloader`
 * Configure: `cp config/autoload/local.php.dist config/autoload/local.php` and change if necessary
 * Serve it (from `public`)

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
