<?php

declare(strict_types=1);

namespace App\Controller\BackOffice;

class PostController extends BackOfficeController
{
	public function addPost()
	{
		ob_start();
		require_once 'src/Templates/CreatePost.html';
		$content = ob_get_clean();

		$this->renderPage($content, 'RBAB création d\'article');
	}
}