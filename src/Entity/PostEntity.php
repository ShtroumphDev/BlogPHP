<?php

namespace App\Entity;

use App\Entity\Abstracts\Entity;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

class PostEntity extends Entity
{
	private ?int $id                                    = null;
	private ?string $title                              = null;
	private ?string $chapo                              = null;
	private ?string $content                            = null;
	private ?string $created_at                         = null;
	private ?string $updated_at                         = null;
	private ?int $category_id                           = null;
	private ?int $user_id                               = null;

	public function __construct()
	{
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(int $id): self
	{
		$this->id = $id;

		return $this;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getChapo(): ?string
	{
		return $this->chapo;
	}

	public function setChapo(string $chapo): self
	{
		$this->chapo = $chapo;

		return $this;
	}

	public function getContent(): ?string
	{
		return $this->content;
	}

	public function setContent(string $content): self
	{
		$this->content = $content;

		return $this;
	}

	public function getCreatedAt(): ?string
	{
		return $this->created_at;
	}

	public function setCreatedAt($created_at): self
	{
		$this->created_at = $created_at;

		return $this;
	}

	public function getUpdatedAt(): ?string
	{
		return $this->updated_at;
	}

	public function setUpdatedAt($updated_at): self
	{
		$this->updated_at = $updated_at;

		return $this;
	}

	public function getCategoryId(): ?int
	{
		return $this->category_id;
	}

	public function setCategoryId(int $category_id): self
	{
		$this->category_id = $category_id;

		return $this;
	}

	public function getUserId(): ?int
	{
		return $this->user_id;
	}

	public function setUserId(int $user_id): self
	{
		$this->user_id = $user_id;

		return $this;
	}

	public function getUser(): ?UserEntity
	{
		$userRepo = new UserRepository();

		return $userRepo->find($this->getUserId());
	}

	public function getCategory(): ?CategoryEntity
	{
		$categoryRepo = new CategoryRepository();

		return $categoryRepo->find($this->getCategoryId());
	}

	protected function getEntityProperties(): array
	{
		return get_object_vars($this);
	}

	public function getDataBaseTableName(): string
	{
		return 'post';
	}

	public function getRepository(): PostRepository
	{
		return new PostRepository();
	}
}
