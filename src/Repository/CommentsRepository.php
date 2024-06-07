<?php

namespace App\Repository;

use App\Entity\CommentEntity;
use App\Repository\Abstracts\AbstractRepository;

class CommentsRepository extends AbstractRepository
{
	private $referenceEntity;

	public function __construct()
	{
		$this->referenceEntity = new CommentEntity();
	}

	protected function getTableName(): string
	{
		return $this->referenceEntity->getDataBaseTableName();
	}

	protected function getClassName(): string
	{
		return CommentEntity::class;
	}
}
