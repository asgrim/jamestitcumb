---
title: Local Packagist Setup
tags: [php, composer, packagist]
---
At [Protected.co.uk](http://www.protected.co.uk/) we are developing some new back end systems, which are broken down "[the right way](http://www.phptherightway.com/)" into lots of little components, all installable via [Composer](http://getcomposer.org/). Because all of our code is closed source, we couldn't use the awesome [Packagist.org](https://packagist.org/). After reading up a little on it, we found a tool called [Satis](https://github.com/composer/satis), which is a static Composer repository generator.

After a little while, we discovered a problem with this - after reaching 15-20 or so components (all hosted remotely on GitHub), the `php bin/satis build` command started taking some time (and sometimes overrunning the cron job we had every minute - which we subsequently lowered to 5 minutes). Ideally what we wanted to do is only update packages that we know are updated (by way of using GitHub push hooks) - but Satis does not yet support this (see [composer/satis#40](https://github.com/composer/satis/issues/40)). So our next logical step was to host our own local Packagist.

Packagist is a little more involved to set up than Satis, and after a trial run, I managed to figure everything out, and now we have our own local version of Packagist. This is how I set it up - apologies if it seems a little like "notes" - but that is what I did when I installed it :). Enjoy! 

Prerequisites
--------
To do this setup, we started with an Ubuntu 12.04.3 (LTS) machine on one of our ESX hosts. First we needed to install some dependencies:

~~~ .bash
$ sudo add-apt-repository ppa:ondrej/php5
$ sudo  add-apt-repository ppa:chris-lea/redis-server
$ sudo   apt-get update
$ sudo apt-get install default-jdk php5 php5-intl php5-mysql php5-curl git mysql-server redis-server
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
$ sudo a2enmod rewrite
$ sudo service apache2 restart
~~~

Steps
-----
* Clone [the repo](https://github.com/composer/packagist)
* Copy `app/config/parameters.yml.dist` to `app/config/parameters.yml`, edit stuff (we changed: database_password, packagist_host, github.client_id, github.client_secret, secret, remember_me, redis_dsn - see notes for GitHub secret etc.)
* `composer install`
* `app/console doctrine:schema:create`
* `app/console assets:install web`
* Make apache vhost (see below)
* Comment FilterProvider bit in .htaccess - this caused errors in my setup for some reason. I didn't investigate this, but it hasn't caused me any issues not having it.
* Set cache/logs perms [see here](http://symfony.com/doc/current/book/installation.html#configuration-and-setup). As our Packagist install is behind a firewall, we weren't so concerned about security so cheated and used 777 permissions. It did however mean we had to use `umask(0000);` in both `app/console` and `web/app.php` to ensure permissions remained at 777.
* Set environment vars (COMPOSER_HOME and HOME) in `app/console` and `web/app.php`
* `ssh-keygen` for www-data (you can log in as www-data by using `sudo -i -u www-data` - then add the generated ssh key to GitHub
* `ssh git@github.com` - to add host fingerprint to known_hosts and to verify it works - you should see a message that you've authenticated, but GitHub does not provide shell access.
* [Install Solr 3.6.2](http://www.gazoakley.com/content/installing-apache-solr-3.6-3.x-ubuntu-debian)
* `app/console packagist:index --all --env=prod`

Notes
-----
* Solr installation was a bit of a pain - the Ubuntu package is too out of date so I had to do a bit of searching. Basically, download it, follow the instructions [here](http://www.gazoakley.com/content/installing-apache-solr-3.6-3.x-ubuntu-debian). Move the schema.xml into `apache-solr-3.6.2/example/solr/conf/schema.xml` and restart it. I seem to recall that more recent versions of Solr don't work with the schema that Packagist includes.
* It's not mentioned on the limited docs available, but for statistics to appear, you need to use the `app/console packagist:stats:compile` command. In my case, statistics didn't work for the first two days of being installed because of the queries that get run for stats in Packagist. This two day limit is easily configurable [in this file](https://github.com/composer/packagist/blob/b3154ce408a97d2695ba1fec6fb69b3c7aabb3a7/src/Packagist/WebBundle/Controller/WebController.php#L889) - just change the `$yesterday` value.
* If a CLI tool isn't doing what you expect, by default Packagist is *as quiet as possible*, which means if you want to see any output, you need to turn on verbosity. For example, instead of `app/console packagist:update --no-debug --env=prod`, try using `app/console packagist:update -v --env=prod`. To increase verbosity, just add more `v`'s to make it more verbose (e.g. `-vvv`).
* To generate GitHub client ID and secret, go to your organisation's settings, then Applications, then hit Register new Application. Fill out the app name (e.g. Packagist), and put in the URL and auth callback URL (in our case was just http://packag.ed/ (that is an internal hostname!). Once generated, you will be able to access the Client ID and Client Secret for the Packagist configuration.

Crontab
-------

~~~
* * * * * /var/www/packagist/app/console packagist:update --no-debug --env=prod
* * * * * /var/www/packagist/app/console packagist:dump --no-debug --env=prod
* * * * * /var/www/packagist/app/console packagist:index --no-debug --env=prod
0 2 * * * /var/www/packagist/app/console packagist:stats:compile --no-debug --env=prod
~~~

Apache Virtual Host
-------------------

~~~
<VirtualHost *:80>
	ServerName packag.ed
	DocumentRoot /var/www/packagist/web

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

	<Directory /var/www/packagist/web>
		AllowOverride All
	</Directory>
</VirtualHost>
~~~
