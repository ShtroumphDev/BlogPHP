<?php

namespace App\Repository;

use App\Entity\ContactFormEntity;
use App\Repository\Abstracts\AbstractRepository;

class ContactFormRepository extends AbstractRepository
{
	private $referenceEntity;

	public function __construct()
	{
		$this->referenceEntity = new ContactFormEntity();
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
