<?php

namespace Delta4op\MongoODM\Traits;

trait CanResolveStringID
{
    /**
     * @param string|self $document
     * @return string
     */
    public static function resolveID(string|self $document): string
    {
        return $document instanceof self ? $document->getKey() : $document;
    }
}