<?php

namespace App\PDO;

use Exception;
use PDO;

class DataBaseConnection
{
    private function connectToDataBase()
    {
        try {
            return new PDO(
                'mysql:host=localhost;dbname=blogphp;charset=utf8',
                'root',
                ''
            );
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getAllUsers()
    {
        $dataBase = $this->connectToDataBase();
        $request = $dataBase->prepare('SELECT * FROM user');
        $request->execute();
        return $request->fetchAll();
    }
}
