<?php

namespace Delta4op\MongoODM\Documents;

use Delta4op\MongoODM\Traits\CanFillClassProperties;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Macroable;

abstract class EmbeddedDocument implements Arrayable
{
    use CanFillClassProperties, Macroable;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }
}
