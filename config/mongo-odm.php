<?php


return [

    // !! The name of the connection Doctrine should use (from database.php)
    'connection' => 'mongodb',
    'connectionTransactional' => 'mongodbTransactional',

    /*
    |--------------------------------------------------------------------------
    | Doctrine Document Mapper Settings
    |--------------------------------------------------------------------------
    |
    | Configure the Doctrine ODM settings here. Change the
    | paths setting to the appropriate path and replace App namespace
    | by your own namespace.
    |
    |
    */
    'default_document_repository' => \Delta4op\MongoODM\DocumentRepositories\DocumentRepository::class,

    // List of array that contains document files
    'paths' => [
        base_path('app/Services/ODM/Documents')
    ],
    
    'metadata' => [
        base_path('app/Services/ODM/Metadata')
    ],

    // Warning: Proxy auto generation should only be enabled in dev!
    'proxies' => [
        'namespace' => 'Proxies',
        'path' => storage_path('proxies'),
        'auto_generate' => env('DOCTRINE_PROXY_AUTOGENERATE', false)
    ],

    // path to hydrators
    'hydrators' => [
        'namespace' => 'Hydrators',
        'path' => storage_path('hydrators'),
    ],

    // TODO: support multiple metadata implementations
    'meta' => env('DOCTRINE_METADATA', 'annotations'),
];
