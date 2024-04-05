<?php

require_once 'vendor/autoload.php';

use App\Router\Router;
use Dotenv\Dotenv;

session_start();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router($_GET['url']);
$router->get('/', 'HomePageController#index');
$router->get('/article/:id', 'PostController#showOnePost');
$router->get('/articles/tous-les-articles', 'PostController#showAllPosts');
$router->get('/articles/categorie-:id', 'PostController#showAllPostsByCategory');
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
