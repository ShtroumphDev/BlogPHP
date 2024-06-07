<?php

namespace App\Entity;

use App\Entity\Abstracts\Entity;
use App\Repository\CategoryRepository;

class CategoryEntity extends Entity
{
	private ?int $id      = null;
	private ?string $name = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	protected function getEntityProperties(): array
	{
		return get_object_vars($this);
	}

	public function getDataBaseTableName(): string
	{
		return 'category';
	}

	public function getRepository(): CategoryRepository
	{
		return new CategoryRepository();
	}
}
