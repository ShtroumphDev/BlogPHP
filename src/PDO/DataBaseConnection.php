<?php

namespace App\PDO;

use Exception;
use PDO;

require_once('vendor/autoload.php');

class DataBaseConnection
{
    public function connectToDataBase()
    {
        try {
            return new PDO(
                'mysql:host=' . $_ENV["DB_HOST"] . ';dbname=' . $_ENV["DB_NAME"] . ';charset=utf8',
                $_ENV["DB_USER"],
                $_ENV["DB_PASSWORD"],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ]
            );
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
