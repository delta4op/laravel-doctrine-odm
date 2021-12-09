<?php

namespace Delta4op\MongoODM\Traits;

trait CanFillClassProperties
{
    public function fill(array $attributes = []): static
    {
        foreach($attributes as $key => $value) {

            if(! property_exists($this, $key)){
                abort(500, "Property $key does not exists");
            }

            $this->{$key} = $value;
        }

        return $this;
    }

    public function __get($name)
    {
        return $this->{$name} ?? null;
    }
}
