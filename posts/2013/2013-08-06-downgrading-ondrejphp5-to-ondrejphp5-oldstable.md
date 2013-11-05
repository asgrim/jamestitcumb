I recently got bitten by the PPA update ondrej/php5 that went from php5.4 to php5.5 and required an upgrade of Apache ([more info here](http://www.justincarmony.com/blog/2013/07/31/ubuntu-12-04-php-5-4-apache2-and-ppaondrejphp5/)). I don't have the time to mess with this (as much as I'd love to use PHP 5.5 right away), so I've just downgraded (annoyingly, I'd already installed the apache PPA to try and get things to work). These are **roughly** the steps I had to take to downgrade (I take no responsibility for messing your system up - _you should be aware of what all these commands are doing before you just blindly run them willy nilly_!!!):

~~~ .bash
$ sudo ppa-purge ppa:ondrej/apache2
$ sudo  ppa-purge ppa:ondrej/php5
$ dpkg  --get-selections | grep php
$ sudo apt-get purge [all packages listed in previous command]
$ dpkg --get-selections | grep apache
$ sudo apt-get purge [all packages listed in previous command]
$ sudo tasksel install lamp-server
$ sudo apt-add-repository ppa:ondrej/php5-oldstable
~~~

Note that this will completely and entirely remove PHP and Apache into oblivion, thus risking losing your configurations. If this matters to you, make sure you back them up first :)

When I get a chance, hopefully I can figure out what broken and get upgraded to PHP 5.5! :)
