<?php

namespace App\Repository;

use App\Entity\CategoryEntity;
use App\Repository\Abstracts\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
	private $referenceEntity;

	public function __construct()
	{
		$this->referenceEntity = new CategoryEntity();
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
