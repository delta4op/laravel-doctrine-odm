<?php

namespace Delta4op\MongoODM;

use Delta4op\MongoODM\DocumentManagers\DocumentManager;
use Delta4op\MongoODM\DocumentManagers\TransactionalDocumentManager;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\MongoDBException;
use Doctrine\ODM\MongoDB\Types\Type;
use Illuminate\Support\ServiceProvider;
use MongoDB\Client;
use Delta4op\MongoODM\Types\CarbonDate;

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
        $this->mergeConfigFrom(__DIR__.'/../config/mongo-odm.php', 'mongo-odm');
        $this->registerDefaultDM();
        $this->registerTransactionalDM();
        $this->registerCustomTypes();
    }

    public function registerDefaultDM()
    {
        $this->app->singleton('DocumentManager', function (){
            return DocumentManager::create(
                $this->getDefaultClient(),
                $this->getConfiguration()
            );
        });
    }

    public function registerTransactionalDM()
    {
        $this->app->singleton('TransactionalDocumentManager', function (){
            return TransactionalDocumentManager::create(
                $this->getTransactionalClient(),
                $this->getConfiguration()
            );
        });
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
    protected function getDefaultClient(): Client
    {
        $dbConfig = config('database.connections.'. config('mongo-odm.connection'));

        return new Client(
            $dbConfig['dsn'],
            [],
            ['typeMap' => DocumentManager::CLIENT_TYPEMAP]
        );
    }

    /**
     * Creates and returns generic client
     *
     * @return Client
     */
    protected function getTransactionalClient(): Client
    {
        $dbConfig = config('database.connections.'. config('mongo-odm.connectionTransactional'));

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
