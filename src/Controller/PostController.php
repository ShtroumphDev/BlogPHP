<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PostRepository;

class PostController extends AbstractController
{
	private readonly PostRepository $postRepository;

	public function __construct()
	{
		$this->postRepository = new PostRepository();
	}

	public function showOneArticle(int $postId): void
	{
		$homePagePosts = $this->postRepository->find($postId);

		ob_start();
		require_once 'src/Templates/Article.html';
		$content = ob_get_clean();

		$this->renderPage($content);
	}
}