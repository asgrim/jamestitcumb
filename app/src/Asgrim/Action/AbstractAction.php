<?php

namespace Asgrim\Action;

use Asgrim\Application;

abstract class AbstractAction
{
	protected $app;

	abstract public function dispatch($request);

	public function setApplication(Application $app)
	{
		$this->app = $app;
	}

	public function getApplication()
	{
		return $this->app;
	}
}
