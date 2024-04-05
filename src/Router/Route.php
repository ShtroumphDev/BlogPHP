<?php

declare(strict_types=1);

namespace App\Router;

class Route
{
	private string $path;
	private $callable;
	private array $matches = [];
	private array $params  = [];

	public function __construct(string $path, $callable)
	{
		$this->path     = trim($path, '/');
		$this->callable = $callable;
	}

	public function match($url)
	{
		$url   = trim($url, '/');
		$path  = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
		$regex = "#^$path$#";

		if (!preg_match($regex, $url, $matches)) {
			return false;
		}
		array_shift($matches);
		$this->matches  =$matches;

		return true;
	}

	private function paramMatch($match)
	{
		if (isset($this->params[$match[1]])) {
			return '(' . $this->params[$match[1]] . ')';
		}

		return '([^/]+)';
	}

	public function call()
	{
		if (is_string($this->callable)) {
			$params     = explode('#', $this->callable);
			$controller =  'App\\Controller\\' . $params[0];
			$controller = new $controller();

			return call_user_func_array([$controller, $params[1]], $this->matches);
		} else {
			return call_user_func_array($this->callable, $this->matches);
		}
	}

	public function with(string $paramName, string $regex)
	{
		$this->params[$paramName] = str_replace('(', '(?:', $regex);

		return $this;
	}

	public function getUrl($params)
	{
		$path = $this->path;
		foreach ($params as $key => $value) {
			$path = str_replace(":$key", (string) $value, $path);
		}

		return $path;
	}
}