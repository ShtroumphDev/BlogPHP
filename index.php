<?php

require_once 'vendor/autoload.php';

use App\Controller\HomePageController;
use App\Router\Router;
use Dotenv\Dotenv;

$controller     = new HomePageController();
session_start();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$router = new Router($_GET['url']);
$router->get('/', function () {
	echo 'bienvenue page acceuil';
});
$router->get('/posts', function () {
	echo 'tout les articles';
});
$router->get('/posts/:id-:slug', function ($id, $slug) use ($router) {
	echo $router->url('post.show', ['id' => 1, 'slug' => 'salut-les-gens']);
}, 'post.show')
	->with('id', '[0-9]+')
	->with('slug', '[a-z\-0-9]+');
$router->get('/posts/:id', 'HomePageController#index');
$router->post('/posts/:id', function ($id) {
	echo 'je poste larticle numero ID' . $id;
});
$router->run();
/* $router = new App\Router($_GET['url']); */
// $controller->index();