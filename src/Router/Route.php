<?php

declare(strict_types=1);

namespace App\Router;

use Exception;

class Route
{
	private string $path;
	private $callable;
	private bool $protected;
	private ?string $role;
	private array $matches   = [];
	private array $params    = [];
	private array $roleOrder = ['subscriber' => 1, 'writter' => 2, 'admin' => 3, 'superAdmin' =>4];

	public function __construct(string $path, $callable, $protected, $role)
	{
		$this->path      = trim($path, '/');
		$this->callable  = $callable;
		$this->protected = $protected;
		$this->role      = $role;
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
		if ($this->protected === true) {
			try {
				$this->checkAutorization();
			} catch (Exception $error) {
				include_once 'src/Templates/Error403.html';
				die;
			}
		}

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

	private function checkAutorization()
	{
		$userRoleValue  = 0;
		$routeRoleValue = $this->roleOrder[$this->role];

		if ($this->role === null) {
			throw new Exception("Aucun role n'a été défini pour cette route donc elle n'est pas accessible pour le momdent");
		}
		if (!isset($_SESSION['user']) || !is_string($_SESSION['user']->getRole()) || !array_key_exists($_SESSION['user']->getRole(), $this->roleOrder)) {
			throw new Exception("Aucune session utilisateur active ou bien role utilisateur n'est pas correctement défini");
		}

		$userRoleValue = $this->roleOrder[$_SESSION['user']->getRole()];

		if ((int) $userRoleValue < (int) $routeRoleValue) {
			throw new Exception("Vous n'avez pas les droits pour cette opération");
		}
	}
}