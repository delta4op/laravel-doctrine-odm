<?php

namespace Delta4op\MongoODM\Traits;

trait CanFillClassProperties
{
    public function fill(array $attributes = []): static
    {
        foreach($attributes as $key => $value) {

            if(! property_exists($this, $key)){
                throw new \Exception("Property $key does not exist");
            }

            $this->{$key} = $value;
        }

        return $this;
    }

    public function __get($name)
    {
        if(isset($this->{$name})) {
            return $this->{$name};
        }
        return null;
    }
}
