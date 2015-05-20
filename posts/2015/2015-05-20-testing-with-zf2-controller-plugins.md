---
title: Testing with ZF2 Controller Plugins
---

One of the things I've found that can make controllers difficult to test in Zend Framework 2 is the use of controller plugins. Although it makes the functionality provided by the plugin itself easier to test, I found it makes it difficult to test the controller itself. In the past I've resorted to mocking the controller and in turn mocking the controller plugin as if it was a method.

However, I've looked into this a bit more and it looks like there's a better way. You can simply use the controller's controller plugin manager, and pop the required service in (i.e. the controller plugin - could be a mock or the actual plugin itself, depending on your needs). This simplifies testing a controller that uses plugins greatly. Consider this controller:

~~~ .php
<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class MyController extends AbstractActionController
{
    public function indexAction()
    {
        $foo = $this->foo(); // is a controller plugin that returns something

        return ['foo' => $foo];
    }
}
~~~

And our controller plugin:

~~~ .php
<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Foo extends AbstractPlugin
{
    public function __invoke()
    {
        return "Woo hello!";
    }
}
~~~

And then to write our test for this, we could do the following:

~~~ .php
<?php

namespace ApplicationTest\Controller;

use Application\Controller\MyController;
use Application\Controller\Plugin\Foo;

class MyControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndexActionReturnsFoo()
    {
        $fooMock = $this->getMockBuilder(Foo::class)
            ->setMethods(['__invoke'])
            ->getMock();

        $fooMock->expects($this->once())->method('__invoke')->will($this->returnValue('Hello world!'));

        $controller = new MyController();
        $controller->getPluginManager()->setService('foo', $fooMock);

        $returnValue = $controller->indexAction();

        $this->assertSame(['foo' => 'Hello world!'], $returnValue);
    }
}
~~~

You could substitute the mock in the example above with a real instance of the controller plugin without too much hassle.

I set up a working demo project on GitHub which you can clone [here](https://github.com/asgrim/zf2-controller-plugin-testing).
