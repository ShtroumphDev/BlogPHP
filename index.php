<?php

require_once 'src\PDO\DataBaseConnection.php';

use App\Controller\HomePageController;
use Dotenv\Dotenv;

$controller =new HomePageController();
session_start();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_GET['page']) && $_GET['page'] !== '') {
	if (file_exists('src\\Templates\\' . $_GET['page'] . '.html')) {
		require_once 'src\\Templates\\' . $_GET['page'] . '.html';
	} else {
		require_once 'src\\Templates\Error404.html';
	}
} else {
	$controller->index();
}
