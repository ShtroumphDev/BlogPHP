<?php

namespace App\Repository;

use App\Entity\PostEntity;
use App\PDO\DataBaseConnection;
use App\Repository\Abstracts\AbstractRepository;
use Exception;

readonly class PostRepository extends AbstractRepository
{
	private PostEntity $referenceEntity;

	public function __construct()
	{
		$this->referenceEntity = new PostEntity();
	}

	protected function getTableName(): string
	{
		return $this->referenceEntity->getDataBaseTableName();
	}

	protected function getClassName(): string
	{
		return get_class($this->referenceEntity);
	}

	public function getHomePagePost(): array
	{
		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();

		$sqlQuery = 'SELECT * FROM post ORDER BY created_at DESC LIMIT 3';

		$query = $dataBase->prepare($sqlQuery);

		$query->execute();

		$content = $query->fetchAll();
		if ($content === false) {
			throw new Exception("Cette donnée ne peut pas être récupérée car elle n'est pas présente dans la base de donnée");
		}

		return $content;
	}
}
