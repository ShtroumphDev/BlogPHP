<?php

namespace App\Controller\BackOffice;

use App\Repository\CommentsRepository;
use App\Repository\UserRepository;

class HomePageController extends BackOfficeController
{
	public function index()
	{
		$commentRepository = new CommentsRepository();
		$userRepository    = new UserRepository();
		$pendingComments   = $commentRepository->findBy(['state'=> 'pending']);

		$commentUserNames =[];

		foreach ($pendingComments as $comment) {
			$userId                    = $comment->getUserId();
			$userName                  = $userRepository->find($userId)->getPseudo();
			$commentUserNames[$userId] = $userName;
		}

		ob_start();
		require_once 'src/Templates/HomePageBack.html';
		$content = ob_get_clean();

		$this->renderPage($content, 'RBAB Administration');
	}
}