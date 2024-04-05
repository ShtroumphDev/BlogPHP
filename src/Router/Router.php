<?php

declare(strict_types=1);

namespace App\Router;

class Router
{
	private string $url;
	private array $routes = [];
	private string $method;
	private array $namedRoutes = [];

	public function __construct(string $url)
	{
		$this->url    = $url;
		$this->method = $_SERVER['REQUEST_METHOD'];
	}

	public function get(string $path, $callable, $name = null)
	{
		return $this->add($path, $callable, $name, 'GET');
	}

	public function post(string $path, $callable, $name = null)
	{
		return $this->add($path, $callable, $name, 'POST');
	}

	private function add(string $path, $callable, $name, string $method)
	{
		$route                   = new Route($path, $callable);
		$this->routes[$method][] = $route;
		if (is_string($callable) && $name === null) {
			$name = $callable;
		}
		if ($name) {
			$this->namedRoutes[$name] = $route;
		}

		return $route;
	}

	public function run()
	{
		if (!isset($this->routes[$this->method])) {
			throw new RouterException('Aucune route pour cette méthode');
		}

		foreach ($this->routes[$this->method] as $route) {
			if ($route->match($this->url)) {
				return $route->call();
			}
		}

		throw new RouterException('Aucune route ne correspond à cette URL');
	}

	public function url($name, $params = [])
	{
		if (!isset($this->namedRoutes[$name])) {
			throw new RouterException('Aucune route pour ce nom de route');
		}

		return $this->namedRoutes[$name]->getUrl($params);
	}
}
