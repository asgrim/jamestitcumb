<?php

namespace Asgrim\Action;

class NotFoundAction extends AbstractAction
{
	public function dispatch($matchedRoute)
	{
		return [
		'template' => 'not-found',
		'variables' => [],
		];
	}
}