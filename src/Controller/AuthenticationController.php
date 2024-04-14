<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Exception;

class AuthenticationController extends AbstractController
{
	private readonly UserRepository $userRepository;

	public function __construct()
	{
		$this->userRepository = new UserRepository();
		parent::__construct();
	}

	public function logIn(): void
	{
		$mandatoryData = ['email', 'password'];
		$missingData   = [];

		if (!hash_equals($_SESSION['token'], $_POST['token'])) {
			throw new Exception('le token ne correspond pas à celui de la session utilisateur');
		}

		foreach ($mandatoryData as $property) {
			if (!isset($_POST[$property]) || !is_string($_POST[$property]) || $_POST[$property] === '') {
				$missingData[] = $property;
			}
		}

		if (!empty($missingData)) {
			$_SESSION['login_error'] = [];
			array_push($_SESSION['login_error'], ...$missingData);
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$userEmail = $_POST['email'];

		$user = $this->userRepository->findOneBy(['email' => $userEmail]);
		if (!$user) {
			$_SESSION['login_error'] = [];
			array_push($_SESSION['login_error'], 'unknown_email');
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$storedPassword = $user->getPassword();
		if (password_verify($_POST['password'], $storedPassword)) {
			$_SESSION['user'] = $user;
			unset($_SESSION['login_error'], $_SESSION['token'], $_SESSION['subscribe_error'], $_SESSION['subscribe_success'], $_SESSION['subscriber_pseudo']);
			$_SESSION['token'] = bin2hex(random_bytes(32));
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}
	}

	public function logOut()
	{
	}
}