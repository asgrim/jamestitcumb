# jamestitcumb.com

This is my website.

It's still work in progress, naturally.

## Installation for local dev

 * Clone it: `git clone git@github.com:asgrim/jamestitcumb.git`
 * Configure: `cp config/autoload/local.php.dist config/autoload/local.php` and change if necessary
 * Configure: `cp docker-compose.override.yml.dist docker-compose.override.yml` and change if necessary 
 * Composer install on host: `php8.2 /usr/local/bin/composer install --no-scripts`
 * Serve it with `make run` (need ports in `docker-compose.override.yml`)
 * Visit http://localhost:8180/

### Running tests

```bash
$ make ci # all of the below
$ make cs-check
$ make static-analysis
$ make unit
```

Fix CS issues (needs volume in `docker-compose.override.yml`)

```
$ make cs-fix
```

Shrink the Psalm baseline (needs volume in `docker-compose.override.yml`)

```
$ make update-static-analysis-baseline
```

### Re-index posts

```bash
$ make index-posts
```

### Re-cache ratings

```bash
$ make cache-ratings
```
