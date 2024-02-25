<?php

namespace App\Entity;

use App\Entity\Abstracts\AbstractEntity;
use Exception;
use App\PDO\DataBaseConnection;
use PDO;

class EntityManager
{
    private array $persistedRequests;

    public function persist(AbstractEntity $entity)
    {
        $entityProperties = $entity->getOrderedProperties();
        $this->persistedRequests[] = $entityProperties;
    }

    public function flush()
    {
        $dataBaseConnection = new DataBaseConnection;
        $dataBase = $dataBaseConnection->connectToDataBase();
        $dataBase->beginTransaction();

        foreach ($this->persistedRequests as $request) {
            $mode = $request['mode'];
            $sqlQuery = $this->getSqlQuery($request, $mode);

            if ($sqlQuery === null) {
                throw new Exception('une erreur dans l\'enregristrement est survenue');
            }
            $query = $dataBase->prepare($sqlQuery);

            $query->execute($request['values']);
        }

        $dataBase->commit();
    }

    public function removeFromDatabase(AbstractEntity $entity)
    {
        //! if $entity->getId() === null ou que l'id n'existe pas dans la bdd, throw exception;
        $dataBaseConnection = new DataBaseConnection;
        $dataBase = $dataBaseConnection->connectToDataBase();

        $sqlQuery = "DELETE FROM {$entity->getDataBaseTableName()} WHERE id = :id";
        $query = $dataBase->prepare($sqlQuery);
        $query->bindValue('id', $entity->getId(), PDO::PARAM_INT);

        $query->execute();
    }

    private function getSqlQuery(array $request, string $mode)
    {
        if (count($request) === 0) {
            return null;
        }

        if ($mode === 'insert') {
            $columns = implode(', ', $request['properties']);

            $values = 'NULL, ';
            $i = 0;
            foreach ($request['properties'] as $property) {
                if ($property === 'id') {
                    $i++;
                    continue;
                }
                if ($i < count($request['properties']) - 1) {
                    $values .= ':' . $property . ', ';
                } else {
                    $values .= ':' . $property;
                }
                $i++;
            }

            $sqlQuery = "INSERT INTO {$request['tableName']} ($columns) VALUES ($values)";
        } else {
            $updatedColumn = '';
            $i = 0;
            foreach ($request['properties'] as $property) {
                if ($i < count($request['properties']) - 1) {
                    $updatedColumn .= $property . '= :' . $property . ',';
                } else {
                    $updatedColumn .= $property . '= :' . $property;
                }
                $i++;
            }

            $sqlQuery = "UPDATE {$request['tableName']} SET $updatedColumn WHERE id = :id";
        }

        return $sqlQuery;
    }
}
