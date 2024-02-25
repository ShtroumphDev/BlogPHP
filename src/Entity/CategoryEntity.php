<?php

namespace App\Entity;

use App\Entity\Abstracts\AbstractEntity;

class CategoryEntity extends AbstractEntity
{
    private ?int $id = null;
    private ?string $name = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->name;
    }

    protected function getEntityProperties(): array
    {
        return get_object_vars($this);
    }

    public function getDataBaseTableName(): string
    {
        return 'category';
    }
}
