<?php

namespace App\Entity\Abstracts;

abstract class AbstractEntity
{


    abstract public function getId(): ?int;


    abstract public function getDataBaseTableName(): string;


    abstract protected function getEntityProperties(): array;


    public function getOrderedProperties()
    {
        $entityProps = $this->getEntityProperties();
        $allProperties = ['properties' => [], 'values' => []];
        foreach ($entityProps as $key => $value) {
            $allProperties['properties'][] = $key;
            if ($key === 'id') {
                continue;
            }
            $allProperties['values'][$key] = $value;
        }
        $allProperties['tableName'] = $this->getDataBaseTableName();
        $allProperties['mode'] = $this->getId() === null ? 'insert' : 'update';
        return $allProperties;
    }
}
