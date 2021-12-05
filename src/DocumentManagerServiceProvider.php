<?php

namespace Delta4op\MongoODM;

use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\Types\Type;
use Illuminate\Support\ServiceProvider;
use MongoDB\Client;
use Delta4op\MongoODM\Types\CarbonDate;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

class DocumentManagerServiceProvider extends ServiceProvider
{
    /**
     * Custom type mappings
     *
     * @var array
     */
    public array $types = [];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {}

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('DocumentManager', function ($app){

            $config = config('mongodb-odm.doctrine_dm');
            $connectionConfig = config('database.connections.'. config('mongodb-odm.connection'));

            // Set up the Doctrine configuration object
            $configuration = new Configuration();
            $configuration->setProxyDir($config['proxies']['path']);
            $configuration->setProxyNamespace($config['proxies']['namespace']);
            $configuration->setHydratorDir($config['hydrators']['path']);
            $configuration->setHydratorNamespace($config['hydrators']['namespace']);
            $configuration->setMetadataDriverImpl(AnnotationDriver::create($config['paths']));
            $configuration->setDefaultDB($connectionConfig['database']);
            $configuration->setDefaultDocumentRepositoryClassName(DocumentRepository::class);
            $configuration->setDefaultCommitOptions([]);

            $client = new Client($connectionConfig['dsn'],[],[
                'typeMap' => DocumentManager::CLIENT_TYPEMAP
            ]);

            return DocumentManager::create(
                $client,
                $configuration
            );
        });

        $this->registerCustomTypes();
    }

    /**
     * Registers custom type casting
     *
     * @return void
     */
    public function registerCustomTypes()
    {
        Type::registerType('carbon', CarbonDate::class);

        foreach($this->types as $name => $class) {
            Type::registerType($name, $class);
        }
    }
}
