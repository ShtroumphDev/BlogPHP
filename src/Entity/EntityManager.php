<?php

namespace App\Entity;

use App\Entity\Abstracts\Entity;
use Exception;
use App\PDO\DataBaseConnection;
use DateTime;
use PDO;

class EntityManager
{
	private array $persistedRequests;

	public function persist(Entity $entity): void
	{
		$entityProperties          = $entity->getOrderedProperties();
		$this->persistedRequests[] = $entityProperties;
	}

	public function flush(): void
	{
		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();
		$dataBase->beginTransaction();

		foreach ($this->persistedRequests as $request) {
			$mode     = $request['mode'];
			$sqlQuery = $this->getSqlQuery($request, $mode);

			if ($sqlQuery === null) {
				throw new Exception('une erreur dans l\'enregristrement est survenue');
			}
			$query = $dataBase->prepare($sqlQuery);

			$this->formatRequest($request['values']);

			$query->execute($request['values']);
		}

		$error = $dataBase->commit();

		if (!$error) {
			$dataBase->rollBack();

			throw new Exception('une erreur est survenue lors de l\'enregistrement en base de donnée');
		}
	}

	public function removeFromDatabase(Entity $entity): void
	{
		if ($entity->getId() === null || empty($entity->getRepository()->find($entity->getId()))) {
			throw new Exception("Cette donnée ne peut pas être supprimé car elle n'est pas présente dans la base de donnée");
		}

		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();

		$sqlQuery = "DELETE FROM {$entity->getDataBaseTableName()} WHERE id = :id";
		$query    = $dataBase->prepare($sqlQuery);
		$query->bindValue('id', $entity->getId(), PDO::PARAM_INT);

		$query->execute();
	}

	private function getSqlQuery(array $request, string $mode): string
	{
		if (count($request) === 0) {
			return null;
		}

		if ($mode === 'insert') {
			$columns = implode(', ', $request['properties']);

			$values = 'NULL, ';
			$i      = 0;
			foreach ($request['properties'] as $property) {
				if ($property === 'id') {
					++$i;

					continue;
				}
				if ($i < count($request['properties']) - 1) {
					$values .= ':' . $property . ', ';
				} else {
					$values .= ':' . $property;
				}
				++$i;
			}

			$sqlQuery = "INSERT INTO {$request['tableName']} ($columns) VALUES ($values)";
		} else {
			$updatedColumn = '';
			$i             = 0;
			foreach ($request['properties'] as $property) {
				if ($i < count($request['properties']) - 1) {
					$updatedColumn .= $property . '= :' . $property . ',';
				} else {
					$updatedColumn .= $property . '= :' . $property;
				}
				++$i;
			}

			$sqlQuery = "UPDATE {$request['tableName']} SET $updatedColumn WHERE id = :id";
		}

		return $sqlQuery;
	}

	private function formatRequest(array &$propertiesValues): array
	{
		foreach ($propertiesValues as $property => $value) {
			if ($value instanceof DateTime) {
				$propertiesValues[$property] = $value->format('Y-m-d');
			}
		}

		return $propertiesValues;
	}
}
