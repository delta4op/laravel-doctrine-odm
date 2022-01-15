<?php

namespace Delta4op\MongoODM\Traits;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

trait HasTimestamps
{
    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
    */
    public $createdAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $updatedAt;

    /**
     * @ODM\PrePersist
     */
    public function markCreatedAtTimestamp()
    {
        if(!isset($this->createdAt)){
            $this->createdAt = now();
        }
    }

    /**
     * @ODM\PreUpdate
     */
    public function markUpdatedAtTimestamp()
    {
        if(!isset($this->updateded)){
            $this->updateded = now();
        }
    }

    /**
     * @return Carbon|null
     */
    public function createdAtTimestamp(): ?Carbon
    {
        return $this->{$this->createdAtFieldName()};
    }

    /**
     * @return Carbon|null
     */
    public function updatedAtTimestamp(): ?Carbon
    {
        return $this->{$this->updatedAtFieldName()};
    }

    /**
     * @return string
     */
    public function createdAtFieldName(): string
    {
        return 'created_at';
    }

    /**
     * @return string
     */
    public function updatedAtFieldName(): string
    {
        return 'updated_at';
    }
}