<?php

namespace App\Repository;

use App\Entity\userEntity;
use App\Repository\Abstracts\AbstractRepository;

class UserRepository extends AbstractRepository
{
	private $referenceEntity;

	public function __construct()
	{
		$this->referenceEntity = new userEntity();
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
