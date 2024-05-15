<?php

declare(strict_types=1);

namespace App\Controller;

abstract class GlobalController
{
	public function RenderVue($page)
	{
		require_once 'src/Templates/GlobalTemplate.html';
	}
}