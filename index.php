<?php

require_once 'src\PDO\DataBaseConnection.php';

use App\Entity\EntityManager;
use App\Entity\PostEntity;
use App\Repository\PostRepository;
use Dotenv\Dotenv;

session_start();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$em   = new EntityManager();
$repo = new PostRepository();
$post = $repo->getHomePagePost();
var_dump($post);

/* $test = new PostEntity();
$test->setTitle('title');
$test->setChapo('chapo');
$test->setContent('content');
$test->setCreatedAt(new DateTime('2024-02-13'));
$test->setUpdatedAt(new DateTime('2024-02-14'));
$test->setCategory(5);
$test->setUserId(8);

$em->persist($test);
$em->flush(); */

if (isset($_GET['page']) && $_GET['page'] !== '') {
	if (file_exists('src\\Templates\\' . $_GET['page'] . '.html')) {
		require_once 'src\\Templates\\' . $_GET['page'] . '.html';
	} else {
		require_once 'src\\Templates\Error404.html';
	}
} else {
	require_once 'src\\Templates\MainContainer.html';
}
