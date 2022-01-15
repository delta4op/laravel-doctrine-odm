<?php

namespace Delta4op\MongoODM\Traits;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

trait HasDefaultAttributes
{
    /**
     * @ODM\PrePersist
     */
    public function setDefaults()
    {
        if($this->hasDefaultsField()) {
            foreach($this->getDefaults() as $key => $value) {
                if(!isset($this->{$key})) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    /**
     * @return string
     */
    public function defaultsFieldName(): string
    {
        return "defaults";
    }

    /**
     * @return bool
     */
    public function hasDefaultsField(): bool
    {
        return property_exists($this, $this->defaultsFieldName());
    }

    /**
     * @return mixed
     */
    public function getDefaults(): mixed
    {
        return $this->{$this->defaultsFieldName()};
    }
}