<?php
namespace Delta4op\MongoODM\Facades;

use Illuminate\Support\Facades\Facade;

class DocumentManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'DocumentManager';
    }
}
