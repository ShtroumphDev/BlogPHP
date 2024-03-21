<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\PostEntity;
use App\Repository\PostRepository;
use Exception;

class HomePageController extends AbstractController
{
	private readonly PostRepository $postRepository;
	private readonly PostEntity $postEntity;

	public function __construct()
	{
		$this->postRepository = new PostRepository();
		$this->postEntity     = new PostEntity();
	}

	public function index(): void
	{
		$homePagePosts = $this->postRepository->getHomePagePosts();
		var_dump($homePagePosts);
		/* var_dump($homePagePosts);
		$checkKeys = $this->postEntity->getEntityProperties();
		foreach ($homePagePosts as $post) {
			foreach ($checkKeys as $property => $value) {
				if (!array_key_exists($property, $post)) {
					throw new Exception('a key is missing in response data');
				}
				if ($post[$property] === null) {
					throw new Exception(sprintf('value is null for property %s', $property));
				}
			}
		} */

		/* $posts         = [];
		var_dump($test->getEntityProperties());
		foreach ($homePagePosts as $post) {
			$postEntity = new PostEntity();
			$postEntity->setID($post->id);
			private ?int $id = null;
	private string $title;
	private string $chapo;
	private string $content;
	private DateTime $created_at;
	private DateTime $updated_at;
	private int $category_id;
	private int $user_id;
		} */
		/* var_dump($homePagePosts);
		ob_start();
		require_once 'src/Templates/HomeContent.html';
		$content = ob_get_clean();

		$this->renderPage($content); */
	}

	public function getUrlPageName(): string
	{
		return 'accueil';
	}
}