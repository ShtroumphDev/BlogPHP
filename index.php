<?php
require_once('src\PDO\DataBaseConnection.php');

use App\Entity\EntityManager;
use Dotenv\Dotenv;
use App\Entity\UserEntity;

session_start();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$truc = new UserEntity();
$truc->setFirstName('coucou');
$truc->setEmail('coucou@hotmail.com');
$truc->setPseudo('coucou123');
$truc->setPassword('coucou');
$truc->setLogo('coucou');
$truc->setLastName('coucou');
$truc->setRole('admin');

$machin = new EntityManager();
$machin->persist($truc);
$machin->flush();

if (isset($_GET['page']) && $_GET['page'] !== '') {
    if (file_exists('src\\templates\\' . $_GET['page'] . '.html')) {
        require_once('src\\templates\\' . $_GET['page'] . '.html');
    } else {
        require_once('src\\templates\Error404.html');
    }
} else {
    require_once('src\\templates\HomePage.html');
}
