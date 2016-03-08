---
title: Zend Expressive + Doctrine integration - now even easier!
---

# Introduction

Zend Expressive is the new framework on the block, and it's super easy to get up and running with it. On many applications, before long, you'll need to start integrating with a database. My go-to solution, because I'm very familiar with it, is Doctrine. I've already written a guide to [set up Doctrine into a Zend Expressive application](http://www.jamestitcumb.com/posts/integrating-doctrine-expressive), but now there's an even easier way of doing this, courtesy of the efforts of [Ben Scholzen](https://twitter.com/dasprid).

I'd like to introduce you to his new binding library, [dasprid/container-interop-doctrine](https://github.com/DASPRiD/container-interop-doctrine), and show you how to get started with this very simple-to-use set of factories.

# Set up a Zend Expressive application

First up, we're going to start from absolute scratch with this project, so we'll start out with a blank canvas using the Zend Expressive skeleton application. As per the [Expressive instructions](https://github.com/zendframework/zend-expressive-skeleton), we simply have to:

~~~ .bash
$ composer create-project zendframework/zend-expressive-skeleton doctrine-test
~~~

When I set up, I accepted all the default options, except I did not opt to install Whoops error handler:

 * Full skeleton
 * FastRoute
 * Zend ServiceManager
 * No template engine
 * No error handler

Now we're set up, don't forget to descend into your new project directory for the rest of the commands.

~~~ .bash
$ cd doctrine-test
~~~

# Install container-interop-doctrine

Because Ben is a neat guy, he put his library on Packagist, which makes it super easy to install with Composer:

~~~ .bash
$ composer require dasprid/container-interop-doctrine
~~~

Let's also do a quick sanity check, to ensure everything is working as we'd expect. Fire up a temporary PHP server using the following:

~~~ .bash
$ php -S 0.0.0.0:8080 -t public/ public/index.php
~~~

If you now open up [http://localhost:8080/](http://localhost:8080/) in your browser, you should see some JSON output indicating everything works:

~~~ .json
{"welcome":"Congratulations! You have installed the zend-expressive skeleton application.","docsUrl":"zend-expressive.readthedocs.org"}
~~~

If you see this, we're looking good, and can go on to start configuring and using container-interop-doctrine.

# Configure container-interop-doctrine

First up we need some configuration, and you'll need an existing MySQL server (or other type of DB that Doctrine supports... take your pick!). I used MySQL, because it was already installed on my machine, so easy to set up. Create your Doctrine configuration in a sensibly named file - to keep things neatly organised, I recommend creating a new file in `config/autoload/doctrine.local.php` specifically for this purpose. 

~~~ .php
<?php
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => 'mysql://username:password@localhost/database',
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'my_entity',
                ],
            ],
            'my_entity' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => __DIR__ . '/../../src/App/Entity',
            ],
        ],
    ],
];
~~~

For your project, you may wish to also create a `doctrine.local.php.dist` containing a template or example of configuration for other users of your project.

Ben's library container-interop-doctrine has made the set up of the rest of the Doctrine factories super simple by requiring you to only register one single little factory! Head into your `dependencies.global.php` and add a register for the following factory:

~~~ .php
<?php
return [
    'dependencies' => [
        'factories' => [
            'doctrine.entity_manager.orm_default' => \ContainerInteropDoctrine\EntityManagerFactory::class,
        ],
    ],
];
~~~

That's actually all the configuration needed to get this thing up and running! Now we can go ahead and make a very basic example to prove everything works as expected.

# Create an entity

As you might've noticed in the configuration above, we've pointed our entity driver at the `src/App/Entity` folder, where we're going to create a very basic entity - just two fields, id and name. This is what my `src/App/Entity/Foo.php` looks like:

~~~ .php
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="foo")
 */
class Foo implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=32)
     * @var string
     */
    private $name;

    /**
     * Application constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
~~~

I'm not going to mess around too much with the ORM stuff, for now, you can run this script manually to create the appropriate database table.

~~~ .sql
CREATE TABLE `foo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT INTO `foo` (`id`, `name`) VALUES
  (1, 'Testing'),
  (2, 'Testing2');
~~~

Naturally, if you're using a different flavour, storage engine, ODM etc., you'll need to adapt this accordingly - this is left as an exercise for the reader.

# Update the HomePageAction and Factory

I'm going to go ahead and hack up the `src/App/Action/HomePageAction.php` now so that it has the pre-configured `EntityManager` injected and ready to go:

~~~ .php
<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Doctrine\ORM\EntityManager;
use App\Entity\Foo;

class HomePageAction
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        return new JsonResponse($this->entityManager->find(Foo::class, 1));
    }
}
~~~

And the factory, in `src/App/Action/HomePageFactory.php` needs updating to only inject the Entity Manager:

~~~ .php
<?php

namespace App\Action;

use Interop\Container\ContainerInterface;

class HomePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get('doctrine.entity_manager.orm_default');

        return new HomePageAction($em);
    }
}
~~~

Naturally, this is not something I'd do in production, but this is just a demo, and the quickest way to prove the concept. If you're interested, I'd wrap this fetch process into a service class to abstract the Doctrine logic away from your controller action, so that it can work with a consistent internal API, rather than external dependencies.

# That's it! Check it and see it work...

Head back to the browser at [http://localhost:8080/](http://localhost:8080/) and you should see your new updated JSON response:

~~~ .json
{"id":1,"name":"Testing"}
~~~

Change the requested ID in the `HomePageAction` to `2` and you'll see the response change accordingly.

~~~ .json
{"id":2,"name":"Testing2"}
~~~

As you can see, setting up and binding the Doctrine library to a new Zend Expressive application has been made trivially easy - and it probably takes about 10 minutes to set this all up. For a bare-bones, quick and easy, set up this is really ideal in my opinion, and I'd encourage you to look into this route. That said, there's still times when the functionality that the [DoctrineORMModule](https://github.com/doctrine/DoctrineORMModule) is a necessity - for example the ObjectSelect and hydrators for binding to Zend\Form instances and so on. If that's something you think you may need, then you could use the above as a basis, but additionally include DoctrineORMModule for the functionality you require.

# P.S., CLI tools?

One of the powerful features of Doctrine is the CLI tools that allow you to manage schema, create migrations and so on. For this, Ben provides instructions on setting up the CLI tools over on the [README.md](https://github.com/DASPRiD/container-interop-doctrine#using-the-doctrine-cli) - which is something you'll probably want to set up too to take advantage.
