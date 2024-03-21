<?php

declare(strict_types=1);

namespace App\Controller;

abstract class AbstractController
{
	protected function renderPage(string $content)
	{
		echo $content;
	}
}