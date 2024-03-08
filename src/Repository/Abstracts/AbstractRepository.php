<?php

namespace App\Repository\Abstracts;

use App\Entity\Abstracts\Entity;
use App\PDO\DataBaseConnection;
use Exception;
use PDO;

abstract class AbstractRepository
{
	public function find(int $id): ?Entity
	{
		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();

		$databaseName = $this->getTableName();
		$sqlQuery     = "SELECT * FROM {$databaseName} WHERE id = :id";

		$query = $dataBase->prepare($sqlQuery);
		$query->bindValue('id', $id, PDO::PARAM_INT);
		$query->execute();

		$query->setFetchMode(PDO::FETCH_CLASS, $this->getClassName());

		if ($query->fetch() === false) {
			throw new Exception("Cette donnée ne peut pas être récupérée car elle n'est pas présente dans la base de donnée");
		}

		return $query->fetch();
	}

	public function findOneBy(array $queryParams): ?Entity
	{
		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();

		$sqlQuery = $this->getSqlQuery($queryParams);

		$query = $dataBase->prepare($sqlQuery);

		foreach ($queryParams as $property => $value) {
			$query->bindValue($property, $value);
		}
		$query->execute();

		$query->setFetchMode(PDO::FETCH_CLASS, $this->getClassName());

		if ($query->fetch() === false) {
			throw new Exception("Cette donnée ne peut pas être récupérée car elle n'est pas présente dans la base de donnée");
		}

		return $query->fetch();
	}

	public function findBy(array $queryParams): ?array
	{
		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();

		$sqlQuery = $this->getSqlQuery($queryParams);

		$query = $dataBase->prepare($sqlQuery);

		foreach ($queryParams as $property => $value) {
			$query->bindValue($property, $value);
		}

		$query->execute();

		if ($query->fetchAll() === false) {
			throw new Exception("Cette donnée ne peut pas être récupérée car elle n'est pas présente dans la base de donnée");
		}

		return $query->fetchAll();
	}

	public function findAll(): ?array
	{
		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();

		$databaseName = $this->getTableName();
		$sqlQuery     = "SELECT * FROM {$databaseName}";

		$query = $dataBase->prepare($sqlQuery);

		$query->execute();

		if ($query->fetchAll() === false) {
			throw new Exception("Cette donnée ne peut pas être récupérée car elle n'est pas présente dans la base de donnée");
		}

		return $query->fetchAll();
	}

	abstract protected function getTableName(): string;

	abstract protected function getClassName(): string;

	private function getSqlQuery(array $queryParams): string
	{
		if (count($queryParams) === 0) {
			throw new Exception('you must provide an array of parameters to the repository method');
		}

		$properties = array_keys($queryParams);
		$values     = array_values($queryParams);

		if (count($properties) !== count($values)) {
			throw new Exception('mismatching number of properties and values in method argument');
		}

		$stringProperties = implode(', ', $properties);
		$stringValues     = '';

		$i = 0;
		foreach ($properties as $property) {
			if ($i < count($properties) - 1) {
				$stringValues .= ':' . $property . ', ';
			} else {
				$stringValues .= ':' . $property;
			}
			++$i;
		}

		$databaseName = $this->getTableName();
		$sqlQuery     = "SELECT * FROM {$databaseName} WHERE ({$stringProperties}) = ({$stringValues})";

		return $sqlQuery;
	}
}
