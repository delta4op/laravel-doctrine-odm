<?php

namespace Delta4op\MongoODM\Traits;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

trait HasDeletedAt
{
    /**
     * @var \Illuminate\Support\Carbon
     * @ODM\Field(type="carbon")
     */
    public $deletedAt;

    /**
     * @return self
     */
    public function markAsDeleted(): self
    {
        $this->{$this->deletedAtFieldName()} = now();

        return $this;
    }

    /**
     * @return string
     */
    public function deletedAtFieldName(): string
    {
        return 'deletedAt';
    }
}