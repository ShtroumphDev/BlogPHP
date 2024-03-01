<?php

namespace App\Entity;

use DateTime;
use App\Entity\Abstracts\AbstractEntity;

class PostEntity extends AbstractEntity
{
    private int $id;
    private string $title;
    private string $chapo;
    private string $content;
    private DateTime $createAt;
    private DateTime $updatedAt;
    private int $categoryId;
    private int $userId;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreateAt(): ?DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(DateTime $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?int
    {
        return $this->categoryId;
    }

    public function setCategory(int $categoryId): self
    {
        $this->categoryId = $categoryId;

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

    protected function getEntityProperties(): array
    {
        return get_object_vars($this);
    }

    public function getDataBaseTableName(): string
    {
        return 'post';
    }
}
