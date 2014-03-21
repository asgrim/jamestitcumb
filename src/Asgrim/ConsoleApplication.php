<?php

namespace Asgrim;

use Symfony\Component\Console\Application;

class ConsoleApplication extends Application
{
	public function __construct()
	{
		parent::__construct('James Titcumb', 'dev-master');

		$commands = array(
			new Command\IndexCommand(),
		);

		foreach ($commands as $command) {
			$this->add($command);
		}
	}
}
