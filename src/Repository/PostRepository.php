<?php

namespace App\Repository;

use App\Entity\PostEntity;
use App\Repository\Abstracts\AbstractRepository;

class PostRepository extends AbstractRepository
{
	private $referenceEntity;

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
}
