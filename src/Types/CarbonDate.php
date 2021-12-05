<?php

namespace Delta4op\MongoODM\Types;

use DateTime;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use Illuminate\Support\Facades\Date;
use MongoDB\BSON\UTCDateTime;

class CarbonDate extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value)
    {
        return new UTCDateTime($value);
    }

    public function convertToPHPValue($value)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof UTCDateTime){
            return Date::createFromTimestampMs($value->toDateTime()->format('Uv'));
        }

        return $value;
    }
}
