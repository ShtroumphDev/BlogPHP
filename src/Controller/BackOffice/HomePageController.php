<?php

namespace App\Controller\BackOffice;

class HomePageController extends BackOfficeController
{
	public function index()
	{
		ob_start();
		require_once 'src/Templates/HomePageBack.html';
		$content = ob_get_clean();

		$this->renderPage($content, 'RBAB Administration');
	}
}