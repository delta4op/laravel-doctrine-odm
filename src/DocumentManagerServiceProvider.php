<?php

namespace Delta4op\MongoODM;

use Delta4op\MongoODM\DocumentManagers\DocumentManager;
use Delta4op\MongoODM\DocumentManagers\TransactionalDocumentManager;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver;
use Doctrine\ODM\MongoDB\MongoDBException;
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
    public function boot() {
        $this->publishes([
            __DIR__.'/../config/mongo-odm.php' => config_path('mongo-odm.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('DocumentManager', function ($app){
            return DocumentManager::create(
                $this->getClient(),
                $this->getConfiguration()
            );
        });

        $this->app->singleton('TransactionalDocumentManager', function ($app){
            return TransactionalDocumentManager::create(
                $this->getClient(),
                $this->getConfiguration()
            );
        });

        $this->registerCustomTypes();
    }

    /**
     * Returns default configuration
     *
     * @return Configuration
     * @throws MongoDBException
     */
    private function getConfiguration(): Configuration
    {
        $dbConfig = config('database.connections.'. config('mongo-odm.connection'));
        $config = config('mongo-odm');
        $configuration = new Configuration();
        $configuration->setProxyDir($config['proxies']['path']);
        $configuration->setProxyNamespace($config['proxies']['namespace']);
        $configuration->setHydratorDir($config['hydrators']['path']);
        $configuration->setHydratorNamespace($config['hydrators']['namespace']);
        $configuration->setMetadataDriverImpl(AnnotationDriver::create($config['paths']));
        $configuration->setDefaultDB($dbConfig['database']);
        $configuration->setDefaultDocumentRepositoryClassName($config['default_document_repository']);
//        $config->setMetadataDriverImpl(new XmlDriver($config['metadata']));
        $configuration->setDefaultCommitOptions([]);

        return $configuration;
    }


    /**
     * Creates and returns generic client
     *
     * @return Client
     */
    protected function getClient(): Client
    {
        $dbConfig = config('database.connections.'. config('mongo-odm.connection'));

        return new Client(
            $dbConfig['dsn'],
            [],
            ['typeMap' => DocumentManager::CLIENT_TYPEMAP]
        );
    }

    /**
     * Registers custom type casting
     *
     * @return void
     */
    protected function registerCustomTypes()
    {
        Type::registerType('carbon', CarbonDate::class);

        foreach($this->types as $name => $class) {
            Type::registerType($name, $class);
        }
    }
}
