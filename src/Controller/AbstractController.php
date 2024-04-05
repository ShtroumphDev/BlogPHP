<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;

abstract class AbstractController
{
	private readonly CategoryRepository $categoryRepository;

	public function __construct()
	{
		$this->categoryRepository = new CategoryRepository();
	}

	public function renderPage(string $content)
	{
		$categories = $this->categoryRepository->findAll();

		require_once 'src/Templates/Navigation.html';

		require_once 'src/Templates/MainContainer.html';
	}
}