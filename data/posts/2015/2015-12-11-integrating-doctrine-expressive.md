---
title: Integrating Doctrine 2 ORM and Migrations into Zend Expressive
tags: [php, zend, expressive, doctrine, zf]
---

I've started a new project in which we're looking at using Doctrine 2 ORM, but
we're in a Zend Expressive project. As of yet, Expressive is in it's infancy,
which means there are still things undocumented and missing. So I'm putting my
two cents into how we got the ORM working in our project.

First up, we're going to use [DoctrineORMModule](https://github.com/doctrine/DoctrineORMModule) -  
we're mostly using ZF components (such as `Zend\Form`) so it makes sense to use
something that already integrates with this later down the line, so start with

~~~ .bash
$ composer require doctrine/doctrine-orm-module
$ composer require doctrine/migrations
~~~

If you don't want to use the ORM, ignore the instructions for ORM, and the same
for Migrations.

Next up, you want your configuration to be included. This would be easy if it
were not for the fact Zend Expressive looks for the `dependencies` config key,
but Doctrine has this all in `service_manager`. So we need to make a shim which
reads the config of both `DoctrineModule` and `DoctrineORMModule` and merge them
into the final config:

~~~ .php
<?php

use Zend\Stdlib\ArrayUtils;

$vendorPath = __DIR__ . '/../../vendor'; // You may need to adjust this depending on your structure...

$doctrineModuleConfig = require_once $vendorPath . '/doctrine/doctrine-module/config/module.config.php';
$doctrineModuleConfig['dependencies'] = $doctrineModuleConfig['service_manager'];
unset($doctrineModuleConfig['service_manager']);

$doctrineOrmModuleConfig = require_once $vendorPath . '/doctrine/doctrine-orm-module/config/module.config.php';
$doctrineOrmModuleConfig['dependencies'] = $doctrineOrmModuleConfig['service_manager'];
unset($doctrineOrmModuleConfig['service_manager']);

return ArrayUtils::merge($doctrineModuleConfig, $doctrineOrmModuleConfig);
~~~

Once this is done, there's a couple more things to do. First we need to provide
our own Doctrine connection / driver / migrations configurations. This is the
normal setup, so check out the DoctrineORMModule docs for this. We simply placed
our config into `doctrine.global.php` with the default configuration, and then
specify platform-specific config into a Git-ignored `local.php`.

Finally, because we're using the ORM with annotations, we need to register the
annotation loader:

~~~ .php
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(
    function ($className) {
        return class_exists($className);
    }
);
~~~

This code can actually live anywhere, but we added a `Bootstrap` middleware
which has a function that calls this. This could be seen as synonymous with a 
`Module.php` in ZF2's bootstrap sequence.

If anyone has any feedback, or simpler ways of doing this, I'd love to hear :)

**EDIT** There was one more thing, in your `dependencies.global.php` you need
to alias `configuration` to `config`, because it looks for `configuration`:

~~~ .php
<?php

return [
    'dependencies' => [
        'aliases' => [
            'configuration' => 'config',
        ],
    ],
];
~~~
