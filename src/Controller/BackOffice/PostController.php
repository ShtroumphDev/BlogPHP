<?php

declare(strict_types=1);

namespace App\Controller\BackOffice;

use App\Entity\EntityManager;
use App\Entity\PostEntity;
use App\Repository\CategoryRepository;
use Exception;

class PostController extends BackOfficeController
{
	public function createPost()
	{
		$categoryReposytory = new CategoryRepository();
		$categories         = $categoryReposytory->findAll();

		ob_start();
		require_once 'src/Templates/CreatePost.html';
		$content = ob_get_clean();

		$this->renderPage($content, 'RBAB création d\'article');
	}

	public function addPost()
	{
		$mandatoryData = ['chapo', 'title', 'user', 'category', 'content'];
		$missingData   = [];

		if (!hash_equals($_SESSION['token'], $_POST['token'])) {
			throw new Exception('le token ne correspond pas à celui de la session utilisateur');
		}

		foreach ($mandatoryData as $property) {
			if (!isset($_POST[$property]) || !is_string($_POST[$property]) || $_POST[$property] === '') {
				if ($property === 'password' && strlen($_POST[$property]) < 6) {
					$missingData[] = $property;

					continue;
				}
				$missingData[] = $property;
			}
		}

		$_SESSION['addArticle_error'] = [];
		if (!empty($missingData)) {
			foreach ($mandatoryData as $property) {
				$_SESSION['addArticle_error'][$property] = $_POST[$property];
			}
			array_push($_SESSION['addArticle_error'], ...$missingData);
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$newPost = new PostEntity();
		$newPost->setTitle($_POST['title']);
		$newPost->setChapo($_POST['chapo']);
		$newPost->setCreatedAt(date('d-m-Y'));
		$newPost->setCategoryId((int) $_POST['category']);
		$newPost->setUserId((int) $_POST['user']);
		$newPost->setContent($_POST['content']);
		$em = new EntityManager();
		$em->persist($newPost);

		$em->flush();

		$_SESSION['addArticle_succes'] = true;

		header('Location: ./', true, 302);
		exit;
	}
}