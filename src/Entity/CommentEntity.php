<?php

namespace App\Entity;

use DateTime;
use App\Entity\Abstracts\Entity;
use App\Repository\CommentsRepository;

class CommentEntity extends Entity
{
	private int $id;
	private string|DateTime $createAt;
	private string|DateTime $updatedAt;
	private string $content;
	private int $userId;
	private int $postId;

	public function __construct()
	{
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getCreateAt(): ?DateTime
	{
		return $this->createAt;
	}

	public function setCreateAt(string $createAt): self
	{
		$this->createAt = $createAt;

		return $this;
	}

	public function getUpdatedAt(): ?DateTime
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(string $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	public function getContent(): ?string
	{
		return $this->content;
	}

	public function setContent(string $content)
	{
		$this->content = $content;

		return $this;
	}

	public function getUserId(): ?int
	{
		return $this->userId;
	}

	public function setUserId(int $userId): self
	{
		$this->userId = $userId;

		return $this;
	}

	public function getPostId(): ?int
	{
		return $this->postId;
	}

	public function setPostId(int $postId): self
	{
		$this->postId = $postId;

		return $this;
	}

	protected function getEntityProperties(): array
	{
		return get_object_vars($this);
	}

	public function getDataBaseTableName(): string
	{
		return 'comment';
	}

	public function getRepository(): CommentsRepository
	{
		return new CommentsRepository();
	}
}
