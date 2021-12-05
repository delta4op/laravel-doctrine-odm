<?php

namespace Delta4op\MongoODM\Documents;

use Illuminate\Contracts\Support\Arrayable;
use SYSOTEL\SYSAPP\DB\MongoDB\Traits\CanFillClassProperties;

abstract class EmbeddedDocument implements Arrayable
{
    use CanFillClassProperties;

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }
}
