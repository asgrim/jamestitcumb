<?php

namespace Asgrim\Action;

class IndexAction extends AbstractAction
{
	public function dispatch($matchedRoute)
	{
		return [
			'template' => 'index',
			'variables' => [],
		];
	}
}
