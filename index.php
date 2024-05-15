<?php

require_once 'vendor/autoload.php';

use App\Constants;
use App\Router\Router;
use Dotenv\Dotenv;

session_start();
if (empty($_SESSION['token'])) {
	$_SESSION['token'] = bin2hex(random_bytes(32));
}

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router($_GET['url']);
$router->get('/', 'FrontOffice#HomePageController#index');
$router->get('/article/:id', 'FrontOffice#PostController#showOnePost');
$router->get('/articles/tous-les-articles', 'FrontOffice#PostController#showAllPosts');
$router->get('/articles/categorie-:id', 'FrontOffice#PostController#showAllPostsByCategory');
$router->get('/posts/:id-:slug', function ($id, $slug) use ($router) {
	echo $router->url('post.show', ['id' => 1, 'slug' => 'salut-les-gens']);
}, 'post.show')
->with('id', '[0-9]+')
->with('slug', '[a-z\-0-9]+');
$router->get('/posts/:id', 'FrontOffice#HomePageController#index');
$router->post('/posts/:id', function ($id) {
	echo 'je poste larticle numero ID' . $id;
});
$router->post('/add-user', 'FrontOffice#UserController#add');
$router->post('/connexion', 'FrontOffice#AuthenticationController#logIn');
$router->get('/deconnexion', 'FrontOffice#AuthenticationController#logOut');
$router->post('/ajouter-commentaire', 'FrontOffice#CommentController#addComment', null, true, Constants::SUBSCRIBER);
$router->get('/retirer-commentaire/:id', 'FrontOffice#CommentController#removeComment', null, true, Constants::SUBSCRIBER);
$router->get('/administration', 'BackOffice#HomePageController#index', null, true, Constants::MODERATOR);

try {
	$router->run();
} catch (\Throwable $error) {
	include_once './src/templates/Error404.html';
}
