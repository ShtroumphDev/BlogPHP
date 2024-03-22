<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PostRepository;

class HomePageController extends AbstractController
{
	private readonly PostRepository $postRepository;

	public function __construct()
	{
		$this->postRepository = new PostRepository();
	}

	public function index(): void
	{
		$homePagePosts = $this->postRepository->getHomePagePosts();

		ob_start();
		require_once 'src/Templates/HomeContent.html';
		$content = ob_get_clean();

		$this->renderPage($content);
	}
}