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
        if(property_exists($this, 'defaults') && is_array($this->defaults)) {
            foreach($this->defaults as $key => $value) {
                if(!isset($this->{$key})) {
                    $this->{$key} = $value;
                }
            }
        }
    }
}