<?php

namespace Delta4op\MongoODM\Documents;

use Delta4op\MongoODM\Traits\CanFillClassProperties;

trait Common
{
    use CanFillClassProperties;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }
}