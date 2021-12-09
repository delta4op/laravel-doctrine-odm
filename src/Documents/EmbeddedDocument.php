<?php

namespace Delta4op\MongoODM\Documents;

use Delta4op\MongoODM\Traits\CanFillClassProperties;
use Illuminate\Contracts\Support\Arrayable;

abstract class EmbeddedDocument implements Arrayable
{
    use CanFillClassProperties;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }
}
