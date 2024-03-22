<?php

namespace App\Repository;

use App\Entity\PostEntity;
use App\PDO\DataBaseConnection;
use App\Repository\Abstracts\AbstractRepository;
use DateTime;
use Exception;
use PDO;

class PostRepository extends AbstractRepository
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
		return PostEntity::class;
	}

	public function getHomePagePosts(): array
	{
		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();

		$sqlQuery = 'SELECT * FROM post ORDER BY created_at DESC LIMIT 3';

		$query = $dataBase->prepare($sqlQuery);

		$query->execute();

		$query->setFetchMode(PDO::FETCH_OBJ);

		$content = $query->fetchAll();
		if ($content === false) {
			throw new Exception("Cette donnée ne peut pas être récupérée car elle n'est pas présente dans la base de donnée");
		}

		foreach ($content as $post) {
			foreach ($post as $property => $value) {
				if ($value === null) {
					throw new Exception(sprintf('la propriété %s n\'a pas de valeur', $property));
				}
			}
		}

		$posts = [];
		foreach ($content as $post) {
			$newPost   = new PostEntity();
			if ($post->id !== null) {
				$newPost->setId($post->id);
			}
			$newPost->setTitle($post->title);
			$newPost->setChapo($post->chapo);
			$newPost->setContent($post->content);
			$newPost->setCreatedAt(DateTime::createFromFormat('Y-m-d', $post->created_at));
			$newPost->setUpdatedAt(DateTime::createFromFormat('Y-m-d', $post->updated_at));
			$newPost->setCategory($post->category_id);
			$newPost->setUserId($post->user_id);

			$posts[] = $newPost;
		}

		return $posts;
	}
}
