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
		parent::__construct();
	}

	public function showOnePost(int $postId): void
	{
		$post = $this->postRepository->find($postId);

		ob_start();
		require_once 'src/Templates/Article.html';
		$content = ob_get_clean();

		$this->renderPage($content);
	}

	public function showAllPosts(): void
	{
		$posts = $this->postRepository->findAll();

		ob_start();
		require_once 'src/Templates/HomeContent.html';
		$content = ob_get_clean();

		$this->renderPage($content);
	}

	public function showAllPostsByCategory(int $categoryId): void
	{
		$posts = $this->postRepository->findBy(['category_id' => $categoryId]);

		ob_start();
		require_once 'src/Templates/HomeContent.html';
		$content = ob_get_clean();

		$this->renderPage($content);
	}
}