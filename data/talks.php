<?php

declare(strict_types=1);

$pieAbstract = 'PHP Installer for Extensions (PIE) is an innovative tool I am writing for the PHP Foundation to modernise how PHP extensions are installed and managed. For decades, PECL has been the go-to mechanism, but it\'s time for a change. In this talk, we\'ll explore why PIE is poised to replace PECL, its goals, and what makes it a game-changer for PHP developers. We\'ll dive into PIE\'s features, demo its usage, and provide a glimpse of its roadmap, including exciting enhancements already in the works. Whether you\'re a seasoned developer or new to PHP extensions, discover how PIE is shaping the future of PHP extension installation.';
$reflectionAbstract = 'Have you ever used PHP\'s built in reflection, only to find you can\'t do quite what you wanted? What about finding types for parameters or properties? What about reflecting on classes that aren\'t loaded, so that you can modify them directly?<br /><br />Better Reflection is an awesome new library that uses magical time-warp techniques* (*actual magic or time-warp not guaranteed) to improve on PHP\'s built-in reflection by providing additional functionality. In this talk we\'ll cover what reflection is all about, explore the cool features of Better Reflection already implemented, the difficulties we faced actually writing the thing, and how you can use Better Reflection in your projects to maximise your reflection-fu.';
$hhvmAbstract = 'HHVM is currently gaining popularity at quite a pace, and it\'s a pretty exciting time for PHP runtimes. Have you ever wondered what is going on beneath this slick and super-speedy engine? I wondered that myself, so I dived into the internals of HHVM, discovering a treasure trove of awesome stuff. In this talk, I\'ll show you how HHVM itself works with a guided tour of the codebase, demonstrating how it all pieces together. I\'ll also show you a couple of ways to write your own incredible HHVM extension. You don\'t need to know C++ to understand this talk - just PHP language knowledge is enough.';
$reflectionLightningAbstract = 'Better Reflection is an awesome new library that uses magical time-warp techniques* to improve on PHP\'s built-in reflection, in this talk we\'ll briefly explore how you can use it to maximise your reflection-fu.<br /><br />* actual magic or time-warp not guaranteed';
$rabbitTutorial = 'As your application grows, you soon realise you need to break up your application into smaller chunks that talk to each other. You could just use web services to interact, or you could take a more robust approach and use the message broker RabbitMQ. In this tutorial, I will introduce RabbitMQ as a solution to scalable, interoperable and flexible applications.<br /><br />We will first set up a hypothetical domain, around which we will structure practical coding exercises to learn the features of RabbitMQ from the ground up. This tutorial is perfect for those who would like a deep dive into RabbitMQ with little or no pre-existing knowledge about message queuing systems. Once you\'ve finished the tutorial, you will have learnt how to set up basic publish/subscribe message queues, control the flow of messages using various exchanges, and understand various features of RabbitMQ such as RPC, TTL, and DLX.';
$rabbitAbstract = 'As your application grows, you soon realise you need to break up your application into smaller chunks that talk to each other. You could just use web services to interact, or you could take a more robust approach and use the message broker RabbitMQ. In this talk, we will take a look at the techniques you can use to vastly enhance inter-application communication, learn about the core concepts of RabbitMQ, cover how you can scale different parts of your application separately, and modernise your development using a message-oriented architecture.';
$securityAbstract = 'Security is an enormous topic, and it\'s really, really complicated. If you\'re not careful, you\'ll find yourself vulnerable to any number of attacks which you definitely don\'t want to be on the receiving end of. This talk will give you just a taster of the vast array of things there is to know about security in modern web applications, such as writing secure PHP web applications and securing a Linux server. Whether you are writing anything beyond a basic brochure website, or even developing a complicated business web application, this talk will give you insights to some of the things you need to be aware of.';
$practicalAbstract = 'RabbitMQ is a message broker – an application that allows communication between applications by way of a message queuing system. In this talk, we\'ll set up a RabbitMQ instance, take an intermediate-level look into the technical features it provides and also how you can apply RabbitMQ in your applications to scale them efficiently.';
$deploymentAbstract = 'The deadline is looming: one week until we release the new version. Some features aren\'t going to make the cut, but the boss really wants to make sure these critical bugs are fixed. You can\'t wait for the release cycle to be over so you can relax. But what if I told you it didn\'t have to be that way? What if I could show you how to create a world where there is no release cycle? A world where weekend deployments are a rarity, not the norm?! In this talk we will cover the steps we took to achieve the coding utopia of releasing a feature as soon as it\'s ready - many times per day. You\'ll find out that by implementing a continuous deployment flow, you can empower your developers to take ownership and become more productive.';
$loggingAbstract = 'Logging is an absolute must for any API or web application, but when starting out, questions such as "how can we do it without disrupting everything else" and "what is the easiest way to log" often come up. We\'re going to examine a tried and tested method to carry out high-performance, low-latency logging using the power of RabbitMQ to ensure minimal impact to the performance of your runtime application. The talk will show you that a really great logging architecture is a low-cost investment in your application that will definitely pay off in the long run.';
$astAbstract = 'The new Abstract Syntax Tree (AST) in PHP 7 means the way our PHP code is being executed has changed. Understanding this new fundamental compilation step is key to understanding how our code is being run.<br /><br />To demonstrate, James will show how a basic compiler works and how introducing an AST simplifies this process. We\'ll look into how these magical time-warp techniques* can also be used in your code to introspect, analyse and modify code in a way that was never possible before.<br /><br />After seeing this talk, you\'ll have a great insight as to the wonders of an AST, and how it can be applied to both compilers and userland code.<br /><br />(*actual magic or time-warp not guaranteed)';
$expressiveAbstract = 'You\'ve heard of Zend\'s new framework, Expressive, and you\'ve heard it\'s the new hotness. In this talk, I will introduce the concepts of Expressive, how to bootstrap a simple application with the framework using best practices, and finally how to integrate a third party tool like Doctrine ORM.';
$ibmiAbstract = 'Zend Server for IBM i has done a great job at allowing enterprise PHP applications to run smoothly on the IBM i platform. But what about developing for the platform? Having recently been hired for a PHP project on IBM i, we wanted to ensure the project was using the best practices possible. This involved embarking on a whole new collaborative journey - uniting expert platform knowledge with bleeding-edge modern PHP development practices. We\'ll show you the process our team went through on the project to revolutionize the client\'s development process by introducing database abstraction, unit tests, functional tests, continuous integration, automated deployment, and more.';
$qualityTalk = 'This prototype works, but it\'s not pretty, and now it\'s in production. That legacy application really needs some TLC. Where do we start? When creating long lived applications, it\'s imperative to focus on good practices. The solution is to improve the whole development life cycle; from planning, better coding and testing, to automation, peer review and more. In this talk, we\'ll take a quick look into each of these areas, looking at how we can make positive, actionable change in our workflow.';
$legacyAbstract = 'You\'ve started a new job. As you dig deeper into the codebase, the WTFs per minute rate rapidly increases, and you\'re left wondering... "Where do I start?!".<br /><br />In this talk, I\'ll draw on my own experiences of joining several different teams to help upgrade their legacy codebase.<br /><br />I\'ll show you what approaches were tried, what worked, what didn\'t work, and how things could\'ve been done differently.<br /><br />You\'ll come out of this talk with some ideas of how to tackle your own codebase and make it easier to refactor.';
$mvpAbstract = 'The honeymoon period is over, and your company or customer is demanding stability in your PHP applications.<br /><br />I\'m going to talk about some essential strategies to set up Continuous Integration and Delivery pipelines to help maintain, and - over time - improve the quality of the software your team delivers.<br /><br />You\'ll learn about some of the tools necessary to set these pipelines up, basic design of CI pipelines, and some key strategies for automating deployments. I\'ll show you how having a solid CI/CD pipeline means that you can still deliver software fast, but with confidence that your deliverables are steadily getting better.';

return [
    [
        'name' => '🥧 A slice of PIE: revolutionising PHP extension installation',
        'type' => 'talk',
        'date' => new DateTime('2025-06-10'),
        'event' => 'Laravel Live UK 2025',
        'abstract' => $pieAbstract,
        'links' => [
            'Laravel Live UK 2025' => ['url' => 'https://laravellive.uk/'],
        ],
    ],
    [
        'name' => '🥧 A slice of PIE: revolutionising PHP extension installation',
        'type' => 'talk',
        'date' => new DateTime('2025-05-15'),
        'event' => 'phpday 2025',
        'abstract' => $pieAbstract,
        'links' => [
            'phpday 2025' => ['url' => 'https://www.phpday.it/'],
        ],
    ],
    [
        'name' => '🥧 A slice of PIE: revolutionising PHP extension installation',
        'type' => 'talk',
        'date' => new DateTime('2025-06-03'),
        'event' => 'PHP Frankfurt am Main',
        'abstract' => $pieAbstract,
        'links' => [
            'PHPUGFFM' => ['url' => 'https://www.phpugffm.de/'],
        ],
    ],
    [
        'name' => '🥧 A slice of PIE: revolutionising PHP extension installation',
        'type' => 'talk',
        'date' => new DateTime('2025-06-04'),
        'event' => 'IPC Berlin 2025',
        'abstract' => $pieAbstract,
        'links' => [
            'IPC Berlin 2025' => ['url' => 'https://phpconference.com/berlin-en/program-berlin-en/'],
        ],
    ],
    [
        'name' => 'Living the Best Life on a Legacy Project',
        'type' => 'talk',
        'date' => new DateTime('2024-09-06'),
        'event' => 'PHP Serbia 2024',
        'abstract' => $legacyAbstract,
        'links' => [
            'PHP Serbia 2024' => ['url' => 'https://2024.phpsrbija.rs/'],
        ],
    ],
    [
        'name' => 'Living the Best Life on a Legacy Project',
        'type' => 'talk',
        'date' => new DateTime('2024-03-15'),
        'event' => 'Dutch PHP Conference 2024',
        'abstract' => $legacyAbstract,
        'links' => [
            'DPC 2024' => ['url' => 'https://phpconference.nl/schedule-2024/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/29612', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Living the Best Life on a Legacy Project',
        'type' => 'talk',
        'date' => new DateTime('2023-11-03'),
        'event' => 'Longhorn PHP 2023',
        'abstract' => $legacyAbstract,
        'links' => [
            'Longhorn PHP' => ['url' => 'https://www.longhornphp.com/schedule'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/29375', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Living the Best Life on a Legacy Project',
        'type' => 'talk',
        'date' => new DateTime('2023-06-22'),
        'event' => 'Laravel Live UK 2023',
        'abstract' => $legacyAbstract,
        'links' => [
            'Laravel Live UK' => ['url' => 'https://laravellive.uk/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/29221', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Living the Best Life on a Legacy Project',
        'type' => 'talk',
        'date' => new DateTime('2023-05-27'),
        'event' => 'PHPers Summit 2023',
        'abstract' => $legacyAbstract,
        'links' => [
            'PHPers Summit 2023' => ['url' => 'https://summit.phpers.pl/en/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/29176', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Minimum Viable PHPipeline',
        'type' => 'talk',
        'date' => new DateTime('2023-05-18'),
        'event' => 'phpday 2023',
        'abstract' => $mvpAbstract,
        'links' => [
            'phpday 2023' => ['url' => 'https://2023.phpday.it/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/29141', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Minimum Viable PHPipeline',
        'type' => 'talk',
        'date' => new DateTime('2023-04-12'),
        'event' => 'PHPSW User Group - April 2023',
        'abstract' => $mvpAbstract,
        'links' => [
            'PHP South West' => ['url' => 'https://www.meetup.com/php-sw/events/292229506/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/29085', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Living the Best Life on a Legacy Project',
        'type' => 'talk',
        'date' => new DateTime('2023-02-15'),
        'event' => 'PHP UK Conference 2023',
        'abstract' => $legacyAbstract,
        'links' => [
            'PHP UK' => ['url' => 'https://www.phpconference.co.uk/schedule/'],
        ],
    ],
    [
        'name' => 'Living the Best Life on a Legacy Project',
        'type' => 'talk',
        'date' => new DateTime('2022-05-19'),
        'event' => 'phpday 2022',
        'abstract' => $legacyAbstract,
        'links' => [
            'phpday' => ['url' => 'https://2022.phpday.it/schedule'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/28770', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Tips for Tackling a Legacy Codebase',
        'type' => 'talk',
        'date' => new DateTime('2021-10-23'),
        'event' => 'Scotland PHP 2021',
        'abstract' => $legacyAbstract,
        'links' => [
            'Scotland PHP' => ['url' => 'https://conference.scotlandphp.co.uk/2021/conference/schedule'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/28573', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2020-04-04'),
        'event' => 'Midwest PHP 2020 (online)',
        'abstract' => $astAbstract,
        'links' => [
            'Midwest PHP' => ['url' => 'https://midwestphp.org/schedule'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications: An Overview (remote talk)',
        'type' => 'talk',
        'date' => new DateTime('2019-10-17'),
        'event' => 'PHP Johannesburg (Oct 2019) Meetup',
        'abstract' => $qualityTalk,
        'links' => [
            'PHP Johannesburg (Oct 2019)' => ['url' => 'https://www.meetup.com/PHP-Johannesburg-Meetup-Group/events/262991441/'],
        ],
    ],
    [
        'name' => 'Best practices for crafting high quality PHP apps',
        'type' => 'tutorial',
        'date' => new DateTime('2019-11-08'),
        'event' => 'Bulgaria PHP Conference 2019',
        'abstract' => $qualityTalk,
        'links' => [
            'Bulgaria PHP' => ['url' => 'https://www.bgphp.org/schedule/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/27735', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Best practices for crafting high quality PHP apps',
        'type' => 'tutorial',
        'date' => new DateTime('2019-10-22'),
        'event' => 'php[world] 2019',
        'abstract' => $qualityTalk,
        'links' => [
            'php[world]' => ['url' => 'https://world.phparch.com/schedule/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/26825', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2019-10-24'),
        'event' => 'php[world] 2019',
        'abstract' => $astAbstract,
        'links' => [
            'php[world]' => ['url' => 'https://world.phparch.com/schedule/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/26826', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2019-05-17'),
        'event' => 'PHP Russia 2019',
        'abstract' => $astAbstract,
        'links' => [
            'PHP Russia' => ['url' => 'https://phprussia.ru/2019/abstracts/5007'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/26218', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Best practices for crafting high quality PHP apps',
        'type' => 'tutorial',
        'date' => new DateTime('2019-02-22'),
        'event' => 'PHP UK Conference 2019',
        'abstract' => $qualityTalk,
        'links' => [
            'PHP UK' => ['url' => 'https://www.phpconference.co.uk/schedule/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/25905', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Best practices for crafting high quality PHP apps',
        'type' => 'tutorial',
        'date' => new DateTime('2018-10-05'),
        'event' => 'ScotlandPHP 2018',
        'abstract' => $qualityTalk,
        'links' => [
            'ScotlandPHP' => ['url' => 'https://conference.scotlandphp.co.uk/schedule'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/25205', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2018-10-06'),
        'event' => 'ScotlandPHP 2018',
        'abstract' => $astAbstract,
        'links' => [
            'ScotlandPHP' => ['url' => 'https://conference.scotlandphp.co.uk/speakers'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/25212', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Kicking off with Zend Expressive and Doctrine ORM',
        'type' => 'talk',
        'date' => new DateTime('2018-09-27'),
        'event' => 'PHP South Africa 2018',
        'abstract' => $expressiveAbstract,
        'links' => [
            'PHP South Africa' => ['url' => 'https://phpsouthafrica.com/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/25094', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Best practices for crafting high quality PHP apps (4h Workshop)',
        'type' => 'tutorial',
        'date' => new DateTime('2018-09-26'),
        'event' => 'PHP South Africa 2018',
        'abstract' => $qualityTalk,
        'links' => [
            'PHP South Africa' => ['url' => 'https://phpsouthafrica.com/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/25134', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2018-09-22'),
        'event' => 'PHP Developer Days Dresden 2018',
        'abstract' => $astAbstract,
        'links' => [
            '2018.phpdd.org' => ['url' => 'https://2018.phpdd.org/talks.html#climbing-the-abstract-syntax-tree'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/24636', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2018-08-16'),
        'event' => 'Southeast PHP 2018',
        'abstract' => $astAbstract,
        'links' => [
            'Southeast PHP 2018' => ['url' => 'https://southeastphp.com/sessions'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/24708', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Best practices for crafting high quality PHP apps (full day)',
        'type' => 'tutorial',
        'date' => new DateTime('2018-06-07'),
        'event' => 'Dutch PHP Conference 2018',
        'abstract' => $qualityTalk,
        'links' => [
            'Dutch PHP Conference 2018' => ['url' => 'https://www.phpconference.nl/schedule#tutorial'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/24185', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications',
        'type' => 'talk',
        'date' => new DateTime('2018-03-29'),
        'event' => 'PHP Warwickshire user group - March 2018',
        'abstract' => $qualityTalk,
        'links' => [
            'PHP Warwickshire' => ['url' => 'https://www.meetup.com/PHP-Warwickshire'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/23965', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications',
        'type' => 'talk',
        'date' => new DateTime('2018-03-14'),
        'event' => 'PHPSW user group - March 2018',
        'abstract' => $qualityTalk,
        'links' => [
            'PHP South West' => ['url' => 'https://www.meetup.com/php-sw/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/23401', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications',
        'type' => 'talk',
        'date' => new DateTime('2018-05-20'),
        'event' => 'PHPkonf 2018 - Istanbul',
        'abstract' => $qualityTalk,
        'links' => [
            'PHPkonf' => ['url' => 'http://phpkonf.org/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/24272', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications',
        'type' => 'talk',
        'date' => new DateTime('2018-02-01'),
        'event' => 'PHPem user group - February 2018',
        'abstract' => $qualityTalk,
        'links' => [
            'PHPem' => ['url' => 'https://www.meetup.com/ugPHPem/events/'],
        ],
    ],
    [
        'name' => 'Kicking off with Zend Expressive and Doctrine ORM',
        'type' => 'talk',
        'date' => new DateTime('2018-03-08'),
        'event' => 'php[MiNDS] (Nottingham) User Group - March 2018',
        'abstract' => $expressiveAbstract,
        'links' => [
            'PHPMiNDS' => ['url' => 'https://phpminds.org/'],
        ],
    ],
    [
        'name' => 'Best practices for crafting high quality PHP apps',
        'type' => 'tutorial',
        'date' => new DateTime('2018-04-13'),
        'event' => 'PHP Yorkshire 2018',
        'abstract' => $qualityTalk,
        'links' => [
            'PHP Yorkshire 2018' => ['url' => 'https://www.phpyorkshire.co.uk/workshops'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/23878', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications',
        'type' => 'talk',
        'date' => new DateTime('2018-01-26'),
        'event' => 'PHP Benelux Conference 2018',
        'abstract' => $qualityTalk,
        'links' => [
            'PHP Benelux Conference 2018' => ['url' => 'https://conference.phpbenelux.eu/2018/speaker/james-titcumb/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/23079', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2018-02-15'),
        'event' => 'PHP UK Conference 2018',
        'abstract' => $astAbstract,
        'links' => [
            'PHP UK 2018' => ['url' => 'https://www.phpconference.co.uk/schedule/#timetable-2-popup-10'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/23293', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications',
        'type' => 'talk',
        'date' => new DateTime('2017-09-13'),
        'event' => 'PHP Hampshire meetup September 2017',
        'abstract' => $qualityTalk,
        'links' => [
            'PHP Hampshire meetups' => ['url' => 'https://www.phphants.co.uk/meetups'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2017-10-24'),
        'event' => 'International PHP Conference Fall 2017',
        'abstract' => $astAbstract,
        'links' => [
            'International PHP Conference Fall 2017' => ['url' => 'https://phpconference.com/php-development/php-7-climbing-the-abstract-syntax-tree/'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2017-10-25'),
        'event' => 'International PHP Conference Fall 2017',
        'abstract' => $securityAbstract,
        'links' => [
            'International PHP Conference Fall 2017' => ['url' => 'https://phpconference.com/performance-security/dip-your-toes-in-the-sea-of-security/'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications',
        'type' => 'talk',
        'date' => new DateTime('2017-12-06'),
        'event' => 'ConFoo Vancouver 2017',
        'abstract' => $qualityTalk,
        'links' => [
            'ConFoo Vancouver 2017' => ['url' => 'https://confoo.ca/en/yvr2017/session/crafting-quality-php-applications'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2017-12-05'),
        'event' => 'ConFoo Vancouver 2017',
        'abstract' => $securityAbstract,
        'links' => [
            'ConFoo Vancouver 2017' => ['url' => 'https://confoo.ca/en/yvr2017/session/dip-your-toes-in-the-sea-of-security'],
        ],
    ],
    [
        'name' => 'Kicking off with Zend Expressive and Doctrine ORM',
        'type' => 'talk',
        'date' => new DateTime('2017-12-04'),
        'event' => 'ConFoo Vancouver 2017',
        'abstract' => $expressiveAbstract,
        'links' => [
            'ConFoo Vancouver 2017' => ['url' => 'https://confoo.ca/en/yvr2017/session/kicking-off-with-zend-expressive-and-doctrine-orm'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2017-10-26'),
        'event' => 'AFUP Forum PHP 2017',
        'abstract' => $astAbstract,
        'links' => [
            'AFUP Forum PHP 2017' => ['url' => 'https://event.afup.org/forumphp2017/programme/?lang=en'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/21736', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications',
        'type' => 'talk',
        'date' => new DateTime('2017-09-21'),
        'event' => 'Nomad PHP EU September 2017',
        'abstract' => $qualityTalk,
        'links' => [
            'Nomad PHP EU - September 2017' => ['url' => 'https://nomadphp.com/crafting-quality-php-applications/'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2017-06-25'),
        'event' => 'CodeiD PHP Odessa conference',
        'abstract' => $astAbstract,
        'links' => [
            'CodeiD PHP Odessa conference' => ['url' => 'http://codeid.com.ua/'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2017-09-28'),
        'event' => 'PHP South Africa 2017',
        'abstract' => $astAbstract,
        'links' => [
            'PHP South Africa 2017' => ['url' => 'http://phpsouthafrica.com/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/21648', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2017-09-29'),
        'event' => 'PHP South Africa 2017',
        'abstract' => $securityAbstract,
        'links' => [
            'PHP South Africa 2017' => ['url' => 'http://phpsouthafrica.com/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/22477', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2017-06-30'),
        'event' => 'Dutch PHP Conference 2017',
        'abstract' => $astAbstract,
        'links' => [
            'Dutch PHP Conference' => ['url' => 'https://www.phpconference.nl/schedule'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/21136', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Crafting Quality PHP Applications',
        'type' => 'talk',
        'date' => new DateTime('2017-05-26'),
        'event' => 'Bucharest Tech Week',
        'abstract' => $qualityTalk,
        'links' => [
            'Bucharest Tech Week' => ['url' => 'http://techweek.ro/business-summits-speakers/'],
        ],
    ],
    [
        'name' => 'Get Started with RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2017-07-18'),
        'event' => 'CoderCruise',
        'abstract' => $rabbitAbstract,
        'links' => [
            'CoderCruise' => ['url' => 'https://www.codercruise.com/?paref=jtd8d9&utm_campaign=jtd8d9'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2017-07-17'),
        'event' => 'CoderCruise',
        'abstract' => $securityAbstract,
        'links' => [
            'CoderCruise' => ['url' => 'https://www.codercruise.com/?paref=jtd8d9&utm_campaign=jtd8d9'],
        ],
    ],
    [
        'name' => 'Kicking off with Zend Expressive and Doctrine ORM',
        'type' => 'talk',
        'date' => new DateTime('2017-05-28'),
        'event' => 'PHP Srbija 2017',
        'abstract' => $expressiveAbstract,
        'links' => [
            'PHP Srbija 2017' => ['url' => 'http://www.conf2017.phpsrbija.rs/schedule#kicking-off-with-zend-expressive-and-doctrine-orm'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/21210', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2017-05-12'),
        'event' => 'phpDay 2017',
        'abstract' => $astAbstract,
        'links' => [
            'phpDay 2017' => ['url' => 'https://2017.phpday.it/schedule.html'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/21227', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Kicking off with Zend Expressive and Doctrine ORM',
        'type' => 'talk',
        'date' => new DateTime('2017-02-17'),
        'event' => 'PHP UK Conference 2017',
        'abstract' => $expressiveAbstract,
        'links' => [
            'PHP UK 2017' => ['url' => 'http://phpconference.co.uk/schedule/#timetable-3-popup-9'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/20348', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Kicking off with Zend Expressive and Doctrine ORM',
        'type' => 'talk',
        'date' => new DateTime('2017-02-03'),
        'event' => 'Sunshine PHP Conference 2017',
        'abstract' => $expressiveAbstract,
        'links' => [
            'Sunshine PHP 2017 Talks' => ['url' => 'http://2017.sunshinephp.com/talks#kicking-off-with-zend-expressive-and-doctrine-orm'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/20090', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2017-01-27'),
        'event' => 'PHP Benelux Conference 2017',
        'abstract' => $securityAbstract,
        'links' => [
            'PHP Benelux' => ['url' => 'https://conference.phpbenelux.eu/2017/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/20175', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => '...now write an interpreter (Part 2)',
        'type' => 'lightning',
        'date' => new DateTime('2016-11-26'),
        'event' => 'PHPem Unconference 2016',
        'abstract' => 'Second half of my two part series on interpreters. In this, I demonstrate how easy it is to write a very basic maths sum interpreter, including a live demo of adding a new language feature!',
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/19833', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Interpret this... (Part 1)',
        'type' => 'lightning',
        'date' => new DateTime('2016-11-26'),
        'event' => 'PHPem Unconference 2016',
        'abstract' => 'First half of a two-part talk. I\'ll show how the Lexer, Parser and AST work in PHP, introducing a little bit of compiler theory that helps explain.',
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/19830', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Mirror, Mirror on the Wall: Building a New PHP Reflection Library',
        'type' => 'talk',
        'date' => new DateTime('2016-11-17'),
        'event' => 'Nomad PHP (Europe) November 2016',
        'abstract' => $reflectionAbstract,
        'links' => [
            'Nomad PHP' => ['url' => 'https://nomadphp.com/nomadphp-2016-11-eu/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/19802', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Kicking off with Zend Expressive and Doctrine ORM',
        'type' => 'talk',
        'date' => new DateTime('2016-10-19'),
        'event' => 'ZendCon 2016',
        'abstract' => $expressiveAbstract,
        'links' => [
            'ZendCon 2016' => ['url' => 'http://www.zendcon.com/session/kicking-zend-expressive-and-doctrine-orm'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/19468', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Bringing Modern PHP Development to IBM i',
        'type' => 'talk',
        'date' => new DateTime('2016-10-20'),
        'event' => 'ZendCon 2016',
        'abstract' => $ibmiAbstract,
        'links' => [
            'ZendCon 2016' => ['url' => 'http://www.zendcon.com/session/bringing-modern-php-development-ibm-i'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/19494', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Zend Expressive',
        'type' => 'lightning',
        'date' => new DateTime('2016-10-12'),
        'event' => 'PHP Hampshire October 2016',
        'abstract' => 'A lightning talk about PSR-7, middleware and Zend Expressive',
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/19279', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2016-10-02'),
        'event' => 'PHPNW16 Conference',
        'abstract' => $securityAbstract,
        'links' => [
            'PHPNW16' => ['url' => 'http://conference.phpnw.org.uk/phpnw16/speakers/james-titcumb/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/18843', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Kicking off with Zend Expressive and Doctrine ORM',
        'type' => 'talk',
        'date' => new DateTime('2016-10-01'),
        'event' => 'PHPNW16 Conference',
        'abstract' => $expressiveAbstract,
        'links' => [
            'PHPNW16' => ['url' => 'http://conference.phpnw.org.uk/phpnw16/speakers/james-titcumb/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/18842', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Climbing the Abstract Syntax Tree',
        'type' => 'talk',
        'date' => new DateTime('2016-10-08'),
        'event' => 'Bulgaria PHP Conference 2016',
        'abstract' => $astAbstract,
        'links' => [
            'Bulgaria PHP' => ['url' => 'http://www.bgphp.org/speakers/#post-108'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/18954', 'class' => 'joindin'],
            'Vimeo' => ['url' => 'https://vimeo.com/album/4217236/video/188950463'],
        ],
    ],
    [
        'name' => 'Adding 1.21 Gigawatts to Applications with RabbitMQ',
        'type' => 'tutorial',
        'date' => new DateTime('2016-10-07'),
        'event' => 'Bulgaria PHP Conference 2016',
        'abstract' => $rabbitTutorial,
        'links' => [
            'Bulgaria PHP' => ['url' => 'http://www.bgphp.org/speakers/#post-108'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/18945', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Adding 1.21 Gigawatts to Applications with RabbitMQ',
        'type' => 'talk',
        'date' => new DateTime('2016-06-29'),
        'event' => 'PHP Oxford',
        'abstract' => $rabbitAbstract,
        'links' => [
            'PHP Oxford' => ['url' => 'http://www.phpoxford.uk/'],
        ],
    ],
    [
        'name' => 'Mirror, mirror on the wall: Building a new PHP reflection library',
        'type' => 'talk',
        'date' => new DateTime('2016-06-24'),
        'event' => 'Dutch PHP Conference 2016',
        'abstract' => $reflectionAbstract,
        'links' => [
            'Dutch PHP Conference' => ['url' => 'http://www.phpconference.nl/schedule#conference-day-1/mirror-mirror-wall-building-new-php-reflection-library'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/17534', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Diving into HHVM Extensions',
        'type' => 'talk',
        'date' => new DateTime('2016-05-25'),
        'event' => 'php[tek] 2016',
        'abstract' => $hhvmAbstract,
        'links' => [
            'php[tek] 2016' => ['url' => 'https://tek.phparch.com/speakers/#65598'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/17057', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Introducing Practical RabbitMQ',
        'type' => 'tutorial',
        'date' => new DateTime('2016-05-24'),
        'event' => 'php[tek] 2016',
        'abstract' => $rabbitTutorial,
        'links' => [
            'php[tek] 2016' => ['url' => 'https://tek.phparch.com/speakers/#65598'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/17077', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2016-05-13'),
        'event' => 'phpDay 2016',
        'abstract' => $securityAbstract,
        'links' => [
            'phpDay' => ['url' => 'http://2016.phpday.it/talk/dip-your-toes-in-the-sea-of-security/'],
            'Joind.in' => ['url' => 'https://joind.in/talk/view/17767', 'class' => 'joindin'],
            'Vimeo' => ['url' => 'https://vimeo.com/album/4061778/video/176057939'],
        ],
    ],
    [
        'name' => 'Mirror, mirror on the wall: Building a new PHP reflection library',
        'type' => 'talk',
        'date' => new DateTime('2016-05-04'),
        'event' => 'PHP Surrey',
        'abstract' => $reflectionAbstract,
        'links' => [
            'PHP Surrey' => ['url' => 'http://phpsurrey.uk/'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2016-02-19'),
        'event' => 'PHP UK Conference 2016',
        'abstract' => $securityAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/16400', 'class' => 'joindin'],
            'PHP UK Conference' => ['url' => 'http://www.phpconference.co.uk/'],
            'YouTube' => ['url' => 'https://www.youtube.com/watch?v=XLNm0-eoLaE'],
        ],
    ],
    [
        'name' => 'Mirror, mirror on the wall',
        'type' => 'lightning',
        'date' => new DateTime('2016-01-29'),
        'event' => 'PHP Benelux 2016 Unconference',
        'abstract' => $reflectionLightningAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/16941', 'class' => 'joindin'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2016-01-21'),
        'event' => 'PHPMiNDS January 2015 meetup',
        'abstract' => $securityAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/16715', 'class' => 'joindin'],
            'PHPMiNDS (Nottingham)' => ['url' => 'http://www.meetup.com/PHPMiNDS-in-Nottingham/'],
        ],
    ],
    [
        'name' => 'Mirror, mirror on the wall',
        'type' => 'lightning',
        'date' => new DateTime('2015-12-17'),
        'event' => 'Nomad PHP December 2015',
        'abstract' => $reflectionLightningAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/16523', 'class' => 'joindin'],
            'Nomad PHP Lightning Talks' => ['url' => 'https://nomadphp.com/category/lightning-talks/'],
            'Nomad PHP December 2015' => ['url' => 'https://nomadphp.com/2015/09/18/using-apigility-to-build-apis-everyone-can-enjoy/'],
            'YouTube' => ['url' => 'https://www.youtube.com/watch?v=mAdrk8O90Z4'],
        ],
    ],
    [
        'name' => 'Mirror, mirror on the wall',
        'type' => 'lightning',
        'date' => new DateTime('2015-11-21'),
        'event' => 'PHPem Unconference 2015',
        'abstract' => $reflectionLightningAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/16429', 'class' => 'joindin'],
            'PHPem' => ['url' => 'http://phpem.uk/event/unconference-2015'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2015-11-19'),
        'event' => 'OWASP Bristol November 2015 meetup',
        'abstract' => $securityAbstract,
        'links' => [
            'OWASP Bristol' => ['url' => 'http://www.meetup.com/OWASP-Bristol/events/226348152/'],
        ],
    ],
    [
        'name' => 'Dip Your Toes in the Sea of Security',
        'type' => 'talk',
        'date' => new DateTime('2015-11-18'),
        'event' => 'PHP Berkshire November 2015 meetup',
        'abstract' => $securityAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/16416', 'class' => 'joindin'],
            'PHP Berkshire' => ['url' => 'http://www.meetup.com/PHP-Berkshire/events/226673368/'],
        ],
    ],
    [
        'name' => 'Diving into HHVM Extensions',
        'type' => 'talk',
        'date' => new DateTime('2015-11-14'),
        'event' => 'BrnoPHP Conference 2015',
        'abstract' => $hhvmAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/16263', 'class' => 'joindin'],
            'BrnoPHP Conference 2015' => ['url' => 'https://www.brnophp.cz/conference-2015'],
        ],
    ],
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
            'YouTube' => ['url' => 'https://www.youtube.com/watch?v=MhfRVmcpwxQ'],
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
        'name' => 'You\'ll Never Believe How Easy Deployments Can Really Be...',
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
        'abstract' => 'PHP has been around since 1995, which means it has been powering the web for nearly two decades. It is one of the top web scripting languages, and is used on countless websites. What is new in the world of PHP and why is this language, that many seem quick to dismiss, so popular? In this talk, we\'ll look at some of the landmark achievements of PHP, why it\'s still gaining popularity, and also a glimpse into what the future might hold for the world of PHP.',
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
        'event' => 'BrightonPHP',
        'abstract' => $loggingAbstract,
        'links' => [
            'Joind.in' => ['url' => 'https://joind.in/talk/view/9928', 'class' => 'joindin'],
            'Lanyrd' => ['url' => 'http://lanyrd.com/2013/brightonphp-november/'],
            'Slides' => ['url' => 'http://www.slideshare.net/asgrim1/low-latency-logging-brighton-php-18th-nov-2013'],
        ],
    ],
    [
        'name' => 'Errors, Exceptions &amp; Logging',
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
        'name' => 'Errors, Exceptions &amp; Logging',
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
            'Joind.in' => ['url' => 'https://joind.in/talk/view/9341', 'class' => 'joindin'],
            'YouTube' => ['url' => 'http://www.youtube.com/watch?v=nnDUSkvdvWg'],
            'Slideshare' => ['url' => 'http://www.slideshare.net/asgrim1/composer-tutorial-php-hants-sept-13-26138484'],
        ],
    ],
];
