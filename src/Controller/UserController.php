<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\EntityManager;
use App\Entity\UserEntity;
use App\Repository\UserRepository;
use Exception;

class UserController extends AbstractController
{
	private readonly UserRepository $userRepository;

	public function __construct()
	{
		$this->userRepository = new UserRepository();
		parent::__construct();
	}

	public function add(): void
	{
		$mandatoryData = ['email', 'pseudo', 'password', 'firstname', 'lastname'];
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

		if (!empty($missingData)) {
			$_SESSION['subscribe_error'] = [];
			array_push($_SESSION['subscribe_error'], ...$missingData);
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$userExist = $this->userRepository->findOneBy(['email' => $_POST['email']]);
		if ($userExist) {
			$_SESSION['subscribe_error'] = [];
			array_push($_SESSION['subscribe_error'], 'email_already_used');
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$user = new UserEntity();
		$user->setEmail($_POST['email']);
		$user->setPseudo($_POST['pseudo']);

		$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$user->setPassword($hashed_password);

		$user->setfirstname($_POST['firstname']);
		$user->setlastname($_POST['lastname']);
		$user->setRole('subscriber');
		if (isset($_POST[$property]) || is_string($_POST[$property])) {
			$user->setLogo($_POST['logo']);
		}

		$em = new EntityManager();
		$em->persist($user);

		try {
			$em->flush();
		} catch (\Throwable $th) {
			$_SESSION['user_flush_error'] = true;
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$_SESSION['subscribe_success'] = true;
		$_SESSION['user_pseudo']       = $_POST['pseudo'];
		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
	}
}