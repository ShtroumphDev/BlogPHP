<?php
require_once('src\PDO\DataBaseConnection.php');

use App\PDO\DataBaseConnection;
use Dotenv\Dotenv;

session_start();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (isset($_GET['page']) && $_GET['page'] !== '') {
    if (file_exists('src\\templates\\' . $_GET['page'] . '.html')) {
        require_once('src\\templates\\' . $_GET['page'] . '.html');
    } else {
        require_once('src\\templates\Error404.html');
    }
} else {
    require_once('src\\templates\HomePage.html');
}
