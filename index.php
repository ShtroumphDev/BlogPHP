<?php

session_start();
var_dump($_GET);
$request_uri = $_SERVER['REQUEST_URI'];
var_dump($request_uri);

if (isset($_GET['page']) && $_GET['page'] !== '') {
    if (file_exists('src\\templates\\' . $_GET['page'] . '.html')) {
        require_once('src\\templates\\' . $_GET['page'] . '.html');
    } else {
        require_once('src\\templates\Error404.html');
    }
} else {
    require_once('src\\templates\HomePage.html');
}
