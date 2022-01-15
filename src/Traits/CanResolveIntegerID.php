<?php

namespace Delta4op\MongoODM\Traits;

trait CanResolveIntegerID
{
    /**
     * @param int|CanResolveIntegerID $document
     * @return int
     */
    public static function resolveID(int|self $document): int
    {
        return $document instanceof self ? $document->getKey() : $document;
    }
}