<?php

namespace Asgrim\Action;

class OpenSourceAction extends AbstractAction
{
	public function dispatch($matchedRoute)
	{
		return [
			'template' => 'open-source',
			'variables' => [],
		];
	}
}
