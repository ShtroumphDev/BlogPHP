<?php

declare(strict_types=1);

namespace App\Controller;

abstract class AbstractController
{
	protected function renderPage(string $content)
	{
		require_once 'src/Templates/MainContainer.html';
	}

	abstract public function index(): void;
}