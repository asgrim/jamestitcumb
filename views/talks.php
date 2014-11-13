<?php
$additionalHeader = <<<EOF
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/js/joindin-ratings.min.js"></script>
EOF;
require_once('header.php');
?>

<p>Upcoming talks:</p>

<ul>
	<li>
		<h3>Adding 1.21 Gigawatts to Applications with RabbitMQ (PHPNW December 2014, 2nd Dec '14)</h3>
		<p>As your application grows, you soon realise you need to break up your application into smaller chunks that talk to each other. You could just use web services to interact, or you could take a more robust approach and use the message broker RabbitMQ. In this talk, we will take a look at the techniques you can use to vastly enhance inter-application communication, learn about the core concepts of RabbitMQ, cover how you can scale different parts of your application separately, and modernise your development using a message-oriented architecture.</p>
		<p><strong>Links:</strong> <a href="http://www.phpnw.org.uk/">PHPNW</a></p>
	</li>
	<li>
		<h3>Practical Message Queueing Using RabbitMQ (Nomad PHP December 2014, 18th Dec '14)</h3>
		<p>RabbitMQ is a message broker – an application that allows communication between applications by way of a message queuing system. In this talk, we’ll set up a RabbitMQ instance, take an intermediate-level look into the technical features it provides and also how you can apply RabbitMQ in your applications to scale them efficiently.</p>
		<p><strong>Links:</strong> <a href="https://nomadphp.com/2014/09/19/nomadphp-2014-12-eu/">Nomad PHP</a></p>
	</li>
	<li>
		<h3>Dip Your Toes in the Sea of Security (PHP Cambridge, 27th Jan '15)</h3>
		<p>Security is an enormous topic, and it’s really, really complicated. If you’re not careful, you’ll find yourself vulnerable to any number of attacks which you definitely don’t want to be on the receiving end of. This talk will give you just a taster of the vast array of things there is to know about security in modern web applications, such as writing secure PHP web applications and securing a Linux server. Whether you are writing anything beyond a basic brochure website, or even developing a complicated business web application, this talk will give you insights to some of the things you need to be aware of.</p>
		<p><strong>Links:</strong> <a href="http://www.meetup.com/phpcambridge/">PHP Cambridge</a></p>
	</li>
	<li>
		<h3>tbc (tbc, 19th-20th Feb '15)</h3>
		<p>tbc</p>
		<p><strong>Links:</strong></p>
	</li>
</ul>

<p>This is a list of talks I've given:</p>

<ul>
	<li>
		<h3>You’ll Never Believe How Easy Deployments Can Really Be... (PHPSW November 2014, 12th Nov '14)</h3>
		<p>The deadline is looming: one week until we release the new version. Some features aren't going to make the cut, but the boss really wants to make sure these critical bugs are fixed. You can't wait for the release cycle to be over so you can relax. But what if I told you it didn't have to be that way? What if I could show you how to create a world where there is no release cycle? A world where weekend deployments are a rarity, not the norm?! In this talk we will cover the steps we took to achieve the coding utopia of releasing a feature as soon as it's ready - many times per day. You'll find out that by implementing a continuous deployment flow, you can empower your developers to take ownership and become more productive.</p>
		<p><strong>Links:</strong> <a href="http://phpsw.org.uk/events/215366502-security-and-deployment">PHPSW</a> | <a href="http://www.meetup.com/php-sw/events/215366502/">Meetup.com</a> | <a href="http://www.slideshare.net/asgrim1/youll-never-believe-how-easy-deployments-can-really-be">Slides</a></p>
	</li>
	<li>
		<h3>Practical Message Queueing Using RabbitMQ (PHPNW14 Uncon, 4th Oct '14)</h3>
		<p>RabbitMQ is a message broker – an application that allows communication between applications by way of a message queuing system. In this talk, we look at some of the basic concepts of RabbitMQ and how it can help effectively scale your applications.</p>
		<p><strong>Links:</strong> <a href="https://joind.in/talk/view/12144" class="joindin">Joind.in</a> | <a href="http://www.slideshare.net/asgrim1/141004-what-rabbit-mq-can-do-for-you-phpnw14-uncon">Slides</a></p>
	</li>
	<li>
		<h3>Low Latency Logging with RabbitMQ (Brno PHP Conference 2014, 4th Sep '14)</h3>
		<p>Logging is an absolute must for any API or web application, but when starting out, questions such as "how can we do it without disrupting everything else" and "what is the easiest way to log" often come up. We’re going to examine a tried and tested method to carry out high-performance, low-latency logging using the power of RabbitMQ to ensure minimal impact to the performance of your runtime application. The talk will show you that a really great logging architecture is a low-cost investment in your application that will definitely pay off in the long run.</p>
		<p><strong>Links:</strong> <a href="https://www.brnophp.cz/conference-2014">Brno PHP Conference</a> | <a href="https://joind.in/11825" class="joindin">Joind.in</a> | <a href="http://www.slideshare.net/asgrim1/low-latency-logging-with-rabbitmq-brno-php-cz-20th-sep-2014">Slides</a></p>
	</li>
	<li>
		<h3>Low Latency Logging with RabbitMQ (PHP London, 4th Sep '14)</h3>
		<p>Logging is an absolute must for any API or web application, but when starting out, questions such as "how can we do it without disrupting everything else" and "what is the easiest way to log" often come up. We’re going to examine a tried and tested method to carry out high-performance, low-latency logging using the power of RabbitMQ to ensure minimal impact to the performance of your runtime application. The talk will show you that a really great logging architecture is a low-cost investment in your application that will definitely pay off in the long run.</p>
		<p><strong>Links:</strong> <a href="http://www.meetup.com/phplondon/events/204629732/">Meetup</a> | <a href="http://www.slideshare.net/asgrim1/low-latency-logging-with-rabbitmq-php-london-4th-sep-2014">Slides</a></p>
	</li>
	<li>
		<h3>Practical Message Queueing Using RabbitMQ (PHPem, 3rd Jul '14)</h3>
		<p>RabbitMQ is a message broker - an application that allows communication between applications by way of a message queuing system. In this talk, we’ll set up an RabbitMQ instance, take an intermediate-level look into the technical features it provides and also how you can apply RabbitMQ in your in applications to scale them efficiently.</p>
		<p><strong>Links:</strong> <a href="http://www.meetup.com/ugPHPem/events/188218922/">Meetup</a> | <a href="http://phpem.info/13-july-3rd-2014">PHPem</a> | <a href="www.slideshare.net/asgrim1/practical-message-queuing-using-rabbitmq-phpem-3rd-july-2014">Slides</a></p>
	</li>
	<li>
		<h3>The State of PHP in 2014 (Portsmouth Linux User Group, 21st Jun '14)</h3>
		<p>PHP has been around since 1995, which means it has been powering the web for nearly two decades. It is one of the top web scripting languages, and is used on countless websites. What is new in the world of PHP and why is this language, that many seem quick to dismiss, so popular? In this talk, we’ll look at some of the landmark achievements of PHP, why it’s still gaining popularity, and also a glimpse into what the future might hold for the world of PHP.</p>
		<p><strong>Links:</strong> <a href="http://www.portsmouth.lug.org.uk/">Portsmouth LUG</a> | <a href="http://www.slideshare.net/asgrim1/the-state-of-php-2014-portsmouth-linux-user-group-6th-june-2014">Slides</a></p>
	</li>
	<li>
		<h3>Dip Your Toes in the Sea of Security (PHP Dorset, 2nd Jun '14)</h3>
		<p>Security is an enormous topic, and it’s really, really complicated. If you’re not careful, you’ll find yourself vulnerable to any number of attacks which you definitely don’t want to be on the receiving end of. This talk will give you just a taster of the vast array of things there is to know about security in modern web applications, such as writing secure PHP web applications and securing a Linux server. Whether you are writing anything beyond a basic brochure website, or even developing a complicated business web application, this talk will give you insights to some of the things you need to be aware of.</p>
		<p><strong>Links:</strong> <a href="https://joind.in/11353" class="joindin">Joind.in</a> | <a href="http://vimeo.com/97645043">Vimeo</a> | <a href="http://www.slideshare.net/asgrim1/dip-your-toes-in-the-sea-of-security-php-dorset">Slides</a></p>
	</li>
	<li>
		<h3>What RabbitMQ Can Do For You (Nomad PHP, 22nd May '14)</h3>
		<p>RabbitMQ is a message broker – an application that allows communication between applications by way of a message queuing system. In this talk, we look at some of the basic concepts of RabbitMQ and how it can help effectively scale your applications.</p>
		<p><strong>Links:</strong> <a href="https://joind.in/11350" class="joindin">Joind.in</a> | <a href="https://www.youtube.com/watch?v=4lDSwfrfM-I">YouTube</a> | <a href="https://www.slideshare.net/asgrim1/rabbit-mq-nomad-php-may-2014">Slides</a></p>
	</li>
	<li>
		<h3>What RabbitMQ Can Do For You (PHP Hampshire, 9th Apr '14)</h3>
		<p>A lightning talk that gives a quick introduction as to what RabbitMQ is for and what it can do for your applications.</p>
		<p><strong>Links:</strong> <a href="https://joind.in/11174" class="joindin">Joind.in</a> | <a href="http://www.youtube.com/watch?v=sY_cKzwyC5k">YouTube</a> | <a href="http://www.slideshare.net/asgrim1/rabbit-mq-32447680">Slides</a></p>
	</li>
	<li>
		<h3>What RabbitMQ Can Do For You (PHPNE14 Uncon, 18th Mar '14)</h3>
		<p>An introduction to what RabbitMQ is and what it can do for your applications.</p>
		<p><strong>Links:</strong> <a href="https://joind.in/10937" class="joindin">Joind.in</a> | <a href="http://www.slideshare.net/asgrim1/rabbit-mq-32447680">Slides</a></p>
	</li>
	<li>
		<h3>Low Latency Logging (BrightonPHP, 18th Nov '13)</h3>
		<p>Logging is an absolute must for any API or web application, but when starting out, questions such as "how can we do it without disrupting everything else" and "what is the easiest way to log" often come out. I'm going to explore a couple of infrastructure ideas to carry out what I call "high-performance, low-latency" logging to ensure minimal impact to the performance of the runtime application. The talk will show you that a really great logging architecture is a low-cost investment in your application that will definitely pay off in the long run.</p>
		<p><strong>Links:</strong> <a href="https://joind.in/9928" class="joindin">Joind.in</a> | <a href="http://lanyrd.com/2013/brightonphp-november/">Lanyrd</a> | <a href="http://www.slideshare.net/asgrim1/low-latency-logging-brighton-php-18th-nov-2013">Slides</a></p>
	</li>
	<li>
		<h3>Errors, Exceptions &amp; Logging (PHP Hampshire, 9th Oct '13)</h3>
		<p>The talk is designed to give an entry-level introduction to how you should be handling errors, exceptions and how to effectively log in an application.</p>
		<p><strong>Links:</strong> <a href="https://joind.in/9452" class="joindin">Joind.in</a> | <a href="http://www.youtube.com/watch?v=NnhkNhM3aDQ">YouTube</a> | <a href="http://www.slideshare.net/asgrim1/errors-exceptions-logging-php-hants-oct-13">Slides</a></p>
	</li>
	<li>
		<h3>Errors, Exceptions &amp; Logging (PHPNW13 Uncon, 5th Oct '13)</h3>
		<p>A brief introduction to how to handle errors, exceptions and some effective ways to log them.</p>
		<p><strong>Links:</strong> <a href="https://joind.in/9470" class="joindin">Joind.in</a> | <a href="http://www.slideshare.net/asgrim1/errors-exceptions-logging-phpnw13-uncon">Slides</a></p>
	</li>
	<li>
		<h3>Composer (PHP Hampshire, 11th Sep '13)</h3>
		<p>A very quick introduction to the basics of Composer, what problems it solves, what it does, including a live demo.</p>
		<p><strong>Links:</strong> <a href="https://joind.in/9341" class="joindin">Joind.in</a> | <a href="http://www.youtube.com/watch?v=nnDUSkvdvWg">YouTube</a> | <a href="http://www.slideshare.net/asgrim1/composer-tutorial-php-hants-sept-13-26138484">Slides</a></p>
	</li>
</ul>

<?php require_once('footer.php'); ?>
