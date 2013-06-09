<?php

namespace Asgrim;

use Symfony\Component\Yaml\Yaml;

class Application
{
	/**
	 * @var string
	 */
	protected $configFilename;

	/**
	 * @var array
	 */
	protected $config;

	public function __construct($configFilename)
	{
		$this->configFilename = $configFilename;
	}

	/**
	 * Run our simple application
	 */
	public function run()
	{
		$this->loadConfiguration($this->configFilename);

		$requestUrl = $_SERVER['REQUEST_URI'];
		$matchedRoute = $this->matchRoute($requestUrl);

		if (!$matchedRoute)
		{
			$matchedRoute = [
				'url' => $requestUrl,
				'action' => 'NotFound',
			];
		}

		$viewModel = $this->dispatchRoute($matchedRoute);

		$layout = $this->renderView('template/layout', $viewModel['variables']);
		$viewScript = $this->renderView('scripts/' . $viewModel['template'], $viewModel['variables']);

		$output = str_replace('[content]', $viewScript, $layout);

		echo $output;
	}

	/**
	 * Loads an action based a matched route
	 *
	 * @param array $matchedRoute
	 */
	public function dispatchRoute($matchedRoute)
	{
		$actionClass = '\Asgrim\Action\\' . $matchedRoute['action'] . 'Action';

		$actionInstance = new $actionClass;

		$actionInstance->setApplication($this);
		return $actionInstance->dispatch($matchedRoute);
	}

	/**
	 * Render a template
	 *
	 * @param string $template
	 * @param mixed $variables
	 * @return string
	 */
	public function renderView($template, $variables)
	{
		$fullTemplate = $this->config['directories']['view-scripts'] . '/' . $template . '.phtml';

		if (!file_exists($fullTemplate))
		{
			throw new \Exception("View template '{$fullTemplate}' does not exist");
		}

		ob_start();
		require $fullTemplate;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Rudimentary route matcher, two types of matches can occur:
	 *
	 * If url contains a colon, it will match a parameter using regex
	 *
	 * If not, it will match the URL literally
	 *
	 * @param unknown $requestUrl
	 * @return unknown
	 */
	public function matchRoute($requestUrl)
	{
		foreach ($this->config['routes'] as $routeName => $route)
		{
			if (isset($route['type']) && $route['type'] == 'regex')
			{
				$regex = '/' . str_replace('/', '\\/', $route['url']) . '/';
				if(preg_match_all($regex, $requestUrl, $matches))
				{
					$route['routeName'] = $routeName;

					foreach($matches as $key => $value)
					{
						if (is_string($key))
						{
							$route[$key] = $value[0];
						}
					}

					return $route;
				}
			}
			else
			{
				if ($route['url'] == $requestUrl)
				{
					$route['routeName'] = $routeName;
					return $route;
				}
			}
		}

		return null;
	}

	/**
	 * Loads a configuration file - check it exists, use Symfony's YAML parser
	 *
	 * @param string $filename
	 * @throws \Exception
	 */
	public function loadConfiguration($filename)
	{
		if (!file_exists($filename))
		{
			throw new \Exception("Configuration file '{$filename}' does not exist");
		}

		$fileContents = file_get_contents($filename);

		$this->config = Yaml::parse($fileContents);
	}

	/**
	 * Get some configuration shiz
	 *
	 * @param string $key (returns whole config if null)
	 * @return mixed
	 */
	public function getConfig($key = null)
	{
		if (is_null($key))
		{
			return $this->config;
		}
		else
		{
			return $this->config[$key];
		}
	}
}
