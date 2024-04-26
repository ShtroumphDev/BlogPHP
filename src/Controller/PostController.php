<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

class PostController extends AbstractController
{
	private readonly PostRepository $postRepository;
	private readonly CommentsRepository $commentRepository;
	private readonly UserRepository $userRepository;

	public function __construct()
	{
		$this->postRepository    = new PostRepository();
		$this->commentRepository = new CommentsRepository();
		$this->userRepository    = new UserRepository();
		parent::__construct();
	}

	public function showOnePost(int $postId): void
	{
		$post            = $this->postRepository->find($postId);
		$comments        = $this->commentRepository->findBy(['post_id' => $postId]);
		$commentUserName =[];

		foreach ($comments as $comment) {
			$userId                   = $comment->getUserId();
			$userName                 = $this->userRepository->find($userId)->getPseudo();
			$commentUserName[$userId] = $userName;
		}
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