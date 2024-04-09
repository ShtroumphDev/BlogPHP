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
		//! afficher que l'utilisateur a été correctement ajouté ou afficher l'erreur
		//! ouvrir la modale dans le cas d'une erreur sinon afficher la page avec une div pour afficher le succes
		$mandatoryData = ['email', 'pseudo', 'password', 'firstname', 'lastname'];
		$missingData   = [];

		if (!hash_equals($_SESSION['token'], $_POST['token'])) {
			throw new Exception('le token ne correspond pas à celui de la session utilisateur');
		}

		foreach ($mandatoryData as $property) {
			if (!isset($_POST[$property]) || !is_string($_POST[$property]) || $_POST[$property] === '') {
				$missingData[] = $property;
			}
		}

		if (empty($missingData)) {
		}
		$userExist = $this->userRepository->findOneBy(['email' => $_POST['email']]);
		if ($userExist) {
			echo 'coucou';
		}

		$user = new UserEntity();
		$user->setEmail($_POST['email']);
		$user->setPseudo($_POST['pseudo']);
		$user->setPassword($_POST['password']);
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
			//throw $th;
		}

		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
	}
}