<?php

namespace App\Repository;

use App\Repository\Abstracts\AbstractRepository;

class ContactFormRepository extends AbstractRepository
{
    private $referenceEntity;

    public function __construct()
    {
        //! apres merge de la PR des entitees dans main, adapté ici le nom avec la bonne classe
        // $this->referenceEntity = new contactFormEntity;
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
