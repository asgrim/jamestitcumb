<?php

$hhvmAbstract = 'HHVM is currently gaining popularity at quite a pace, and it\'s a pretty exciting time for PHP runtimes. Have you ever wondered what is going on beneath this slick and super-speedy engine? I wondered that myself, so I dived into the internals of HHVM, discovering a treasure trove of awesome stuff. In this talk, I\'ll show you how HHVM itself works with a guided tour of the codebase, demonstrating how it all pieces together. I\'ll also show you a couple of ways to write your own incredible HHVM extension. You don\'t need to know C++ to understand this talk - just PHP language knowledge is enough.';
$reflectionLightningAbstract = 'Better Reflection is an awesome new library that uses magical time-warp techniques* to improve on PHP\'s built-in reflection, in this talk we\'ll briefly explore how you can use it to maximise your reflection-fu.<br /><br />* actual magic or time-warp not guaranteed';
$rabbitTutorial = 'As your application grows, you soon realise you need to break up your application into smaller chunks that talk to each other. You could just use web services to interact, or you could take a more robust approach and use the message broker RabbitMQ. In this tutorial, I will introduce RabbitMQ as a solution to scalable, interoperable and flexible applications.<br /><br />We will first set up a hypothetical domain, around which we will structure practical coding exercises to learn the features of RabbitMQ from the ground up. This tutorial is perfect for those who would like a deep dive into RabbitMQ with little or no pre-existing knowledge about message queuing systems. Once you\'ve finished the tutorial, you will have learnt how to set up basic publish/subscribe message queues, control the flow of messages using various exchanges, and understand various features of RabbitMQ such as RPC, TTL, and DLX.';
$rabbitAbstract = 'As your application grows, you soon realise you need to break up your application into smaller chunks that talk to each other. You could just use web services to interact, or you could take a more robust approach and use the message broker RabbitMQ. In this talk, we will take a look at the techniques you can use to vastly enhance inter-application communication, learn about the core concepts of RabbitMQ, cover how you can scale different parts of your application separately, and modernise your development using a message-oriented architecture.';
$securityAbstract = 'Security is an enormous topic, and it’s really, really complicated. If you’re not careful, you’ll find yourself vulnerable to any number of attacks which you definitely don’t want to be on the receiving end of. This talk will give you just a taster of the vast array of things there is to know about security in modern web applications, such as writing secure PHP web applications and securing a Linux server. Whether you are writing anything beyond a basic brochure website, or even developing a complicated business web application, this talk will give you insights to some of the things you need to be aware of.';
$practicalAbstract = 'RabbitMQ is a message broker – an application that allows communication between applications by way of a message queuing system. In this talk, we’ll set up a RabbitMQ instance, take an intermediate-level look into the technical features it provides and also how you can apply RabbitMQ in your applications to scale them efficiently.';
$deploymentAbstract = 'The deadline is looming: one week until we release the new version. Some features aren\'t going to make the cut, but the boss really wants to make sure these critical bugs are fixed. You can\'t wait for the release cycle to be over so you can relax. But what if I told you it didn\'t have to be that way? What if I could show you how to create a world where there is no release cycle? A world where weekend deployments are a rarity, not the norm?! In this talk we will cover the steps we took to achieve the coding utopia of releasing a feature as soon as it\'s ready - many times per day. You\'ll find out that by implementing a continuous deployment flow, you can empower your developers to take ownership and become more productive.';
$loggingAbstract = 'Logging is an absolute must for any API or web application, but when starting out, questions such as "how can we do it without disrupting everything else" and "what is the easiest way to log" often come up. We’re going to examine a tried and tested method to carry out high-performance, low-latency logging using the power of RabbitMQ to ensure minimal impact to the performance of your runtime application. The talk will show you that a really great logging architecture is a low-cost investment in your application that will definitely pay off in the long run.';

return [
    [
        'name' => 'Mirror, Mirror on the Wall',
        'type' => 'lightning',
        'date' => new DateTime('2015-10-14'),
        'event' => 'PHPSW',
        'abstract' => $reflectionLightningAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/15485', 'class' => 'joindin'],
            'PHPSW October' => ['url' => 'http://www.meetup.com/php-sw/events/225148132/'],
        ],
    ],
    [
        'name' => 'Diving into HHVM Extensions',
        'type' => 'talk',
        'date' => new DateTime('2015-10-03'),
        'event' => 'PHPNW15',
        'abstract' => $hhvmAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/15434', 'class' => 'joindin'],
            'PHP North West Conference 2015' => ['url' => 'http://conference.phpnw.org.uk/phpnw15/speakers/james-titcumb/'],
        ],
    ],
    [
        'name' => 'Adding 1.21 Gigawatts to Applications with RabbitMQ',
        'type' => 'tutorial',
        'date' => new DateTime('2015-10-03'),
        'event' => 'PHPNW15',
        'abstract' => $rabbitTutorial,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/15419', 'class' => 'joindin'],
            'PHP North West Conference 2015' => ['url' => 'http://conference.phpnw.org.uk/phpnw15/speakers/james-titcumb/'],
        ],
    ],
    [
        'name' => 'Diving into HHVM Extensions',
        'type' => 'talk',
        'date' => new DateTime('2015-09-07'),
        'event' => 'PHP Dorset',
        'abstract' => $hhvmAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/15163', 'class' => 'joindin'],
            'Eventbrite' => ['url' => 'https://www.eventbrite.co.uk/e/phpdorset-september-james-titcumb-marco-pivetta-tickets-18010155861'],
        ],
    ],
    [
        'name' => 'Adding 1.21 Gigawatts to Applications with RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2015-07-30'),
        'event' => 'PHP Warwickshire',
        'abstract' => $rabbitAbstract,
        'links' => [
            'PHP Warwickshire' => ['url' => 'http://phpwarks.co.uk/'],
        ],
    ],
    [
        'name' => 'Adding 1.21 Gigawatts to Applications with RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2015-06-27'),
        'event' => 'Dutch PHP Conference',
        'abstract' => $rabbitAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/14253', 'class' => 'joindin'],
            'Dutch PHP Conference' => ['url' => 'http://www.phpconference.nl/schedule#conference-day-2/adding-121-gigawatts-applications-rabbitmq'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2015-06-26'),
        'event' => 'Dutch PHP Conference',
        'abstract' => $securityAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/14227', 'class' => 'joindin'],
            'Dutch PHP Conference' => ['url' => 'http://www.phpconference.nl/schedule#conference-day-1/dip-your-toes-sea-security'],
        ],
    ],
    [
        'name' => 'Adding 1.21 Gigawatts to Applications with RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2015-02-19'),
        'event' => 'PHP UK Conference',
        'abstract' => $rabbitAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/13365', 'class' => 'joindin'],
            'PHP UK Conference' => ['url' => 'http://phpconference.co.uk/'],
            'YouTube' => ['url' => 'https://www.youtube.com/watch?v=0cWcCQSAY5o'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2015-01-27'),
        'event' => 'PHP Cambridge',
        'abstract' => $securityAbstract,
        'links' => [
            'PHP Cambridge' => ['url' => 'http://www.meetup.com/phpcambridge/'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/dip-your-toes-in-the-sea-of-security-php-cambridge'],
        ],
    ],
    [
        'name' => 'Practical Message Queueing Using RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2014-12-18'),
        'event' => 'Nomad PHP December 2014',
        'abstract' => $practicalAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/13093', 'class' => 'joindin'],
            'Nomad PHP' => ['url' => 'https://nomadphp.com/2014/09/19/nomadphp-2014-12-eu/'],
            'Slides' => ['url' => 'https://www.slideshare.net/asgrim1/practical-message-queueing-using-rabbit-mq-nomad-php-eu-dec-2014'],
        ],
    ],
    [
        'name' => 'Adding 1.21 Gigawatts to Applications with RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2014-12-02'),
        'event' => 'PHPNW December 2014',
        'abstract' => $rabbitAbstract,
        'links' => [
            'PHPNW' => ['url' => 'http://www.phpnw.org.uk/'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/adding-121-gigawatts-to-applications-with-rabbit-mq-phpnw-dec-2014-meetup'],
        ],
    ],
    [
        'name' => 'You’ll Never Believe How Easy Deployments Can Really Be...',
        'type' => 'talk',
        'date' => new DateTime('2014-11-12'),
        'event' => 'PHPSW November 2014',
        'abstract' => $deploymentAbstract,
        'links' => [
            'PHPSW' => ['url' => 'http://phpsw.org.uk/events/215366502-security-and-deployment'],
            'Meetup.com' => ['url' => 'http://www.meetup.com/php-sw/events/215366502/'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/youll-never-believe-how-easy-deployments-can-really-be'],
        ],
    ],
    [
        'name' => 'Practical Message Queueing Using RabbitMQ',
        'type' => 'lightning',
        'date' => new DateTime('2014-10-04'),
        'event' => 'PHPNW 2014 Uncon',
        'abstract' => $practicalAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/12144', 'class' => 'joindin'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/141004-what-rabbit-mq-can-do-for-you-phpnw14-uncon'],
        ],
    ],
    [
        'name' => 'Low Latency Logging with RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2014-09-20'),
        'event' => 'Brno PHP Conference 2014',
        'abstract' => $loggingAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/11825', 'class' => 'joindin'],
            'Brno PHP Conference' => ['url' => 'https://www.brnophp.cz/conference-2014'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/low-latency-logging-with-rabbitmq-brno-php-cz-20th-sep-2014'],
        ],
    ],
    [
        'name' => 'Low Latency Logging with RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2014-09-04'),
        'event' => 'PHP London',
        'abstract' => $loggingAbstract,
        'links' => [
            'Meetup.com' => ['url' => 'http://www.meetup.com/phplondon/events/204629732/'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/low-latency-logging-with-rabbitmq-php-london-4th-sep-2014'],
        ],
    ],
    [
        'name' => 'Practical Message Queueing Using RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2014-07-03'),
        'event' => 'PHPem',
        'abstract' => $practicalAbstract,
        'links' => [
            'Meetup.com' => ['url' => 'http://www.meetup.com/ugPHPem/events/188218922/'],
            'PHPem' => ['url' => 'http://phpem.info/13-july-3rd-2014'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/practical-message-queuing-using-rabbitmq-phpem-3rd-july-2014'],
        ],
    ],
    [
        'name' => 'The State of PHP in 2014',
        'type' => 'talk',
        'date' => new DateTime('2014-06-21'),
        'event' => 'Portsmouth Linux User Group',
        'abstract' => 'PHP has been around since 1995, which means it has been powering the web for nearly two decades. It is one of the top web scripting languages, and is used on countless websites. What is new in the world of PHP and why is this language, that many seem quick to dismiss, so popular? In this talk, we’ll look at some of the landmark achievements of PHP, why it’s still gaining popularity, and also a glimpse into what the future might hold for the world of PHP.',
        'links' => [
            'Portsmouth LUG' => ['url' => 'http://www.portsmouth.lug.org.uk/'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/the-state-of-php-2014-portsmouth-linux-user-group-6th-june-2014'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2014-06-02'),
        'event' => 'PHP Dorset',
        'abstract' => $securityAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/11353', 'class' => 'joindin'],
            'Video' => ['url' => 'http://vimeo.com/97645043'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/dip-your-toes-in-the-sea-of-security-php-dorset'],
        ],
    ],
    [
        'name' => 'What RabbitMQ Can Do For You',
        'type' => 'lightning',
        'date' => new DateTime('2014-05-22'),
        'event' => 'Nomad PHP',
        'abstract' => $practicalAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/11350', 'class' => 'joindin'],
            'YouTube' => ['url' => 'https://www.youtube.com/watch?v=4lDSwfrfM-I'],
            'Slides' => ['url' => 'https://www.slideshare.net/asgrim1/rabbit-mq-nomad-php-may-2014'],
        ],
    ],
    [
        'name' => 'What RabbitMQ Can Do For You',
        'type' => 'lightning',
        'date' => new DateTime('2014-04-09'),
        'event' => 'PHP Hampshire April 2014',
        'abstract' => 'A lightning talk that gives a quick introduction as to what RabbitMQ is for and what it can do for your applications.',
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/11174', 'class' => 'joindin'],
            'YouTube' => ['url' => 'http://www.youtube.com/watch?v=sY_cKzwyC5k'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/rabbit-mq-32447680'],
        ],
    ],
    [
        'name' => 'What RabbitMQ Can Do For You',
        'type' => 'lightning',
        'date' => new DateTime('2014-03-18'),
        'event' => 'PHPNE14 Uncon',
        'abstract' => 'An introduction to what RabbitMQ is and what it can do for your applications.',
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/10937', 'class' => 'joindin'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/rabbit-mq-32447680'],
        ],
    ],
    [
        'name' => 'Low Latency Logging',
        'type' => 'talk',
        'date' => new DateTime('2013-11-18'),
        'event' => 'BrigntonPHP',
        'abstract' => $loggingAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/9928', 'class' => 'joindin'],
            'Lanyrd' => ['url' => 'http://lanyrd.com/2013/brightonphp-november/'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/low-latency-logging-brighton-php-18th-nov-2013'],
        ],
    ],
    [
        'name' => 'Errors, Exceptionsn &amp; Logging',
        'type' => 'talk',
        'date' => new DateTime('2013-10-09'),
        'event' => 'PHP Hampshire',
        'abstract' => 'The talk is designed to give an entry-level introduction to how you should be handling errors, exceptions and how to effectively log in an application.',
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/9452', 'class' => 'joindin'],
            'YouTube' => ['url' => 'http://www.youtube.com/watch?v=NnhkNhM3aDQ'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/errors-exceptions-logging-php-hants-oct-13'],
        ],
    ],
    [
        'name' => 'Errors, Exceptionsn &amp; Logging',
        'type' => 'lightning',
        'date' => new DateTime('2013-10-05'),
        'event' => 'PHPNW13 Uncon',
        'abstract' => 'A brief introduction to how to handle errors, exceptions and some effective ways to log them.',
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/9470', 'class' => 'joindin'],
            'YouTube' => ['url' => 'http://www.youtube.com/watch?v=NnhkNhM3aDQ'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/errors-exceptions-logging-phpnw13-uncon'],
        ],
    ],
    [
        'name' => 'Composer',
        'type' => 'talk',
        'date' => new DateTime('2013-09-11'),
        'event' => 'PHP Hampshire',
        'abstract' => 'A very quick introduction to the basics of Composer, what problems it solves, what it does, including a live demo.',
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/9341', 'class' => 'joindin'],
            'YouTube' => ['url' => 'http://www.youtube.com/watch?v=nnDUSkvdvWg'],
            'Slideshare' => ['url' => 'http://www.slideshare.net/asgrim1/composer-tutorial-php-hants-sept-13-26138484'],
        ],
    ],
];