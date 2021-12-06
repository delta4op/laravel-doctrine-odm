<?php

namespace Delta4op\MongoODM\DocumentRepositories;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository as BaseDocumentRepository;
use Illuminate\Support\Collection;

class DocumentRepository extends BaseDocumentRepository
{

    /**
     * Similar to findBy method.
     * Difference is it returns collection instead of array
     *
     * @param array $filters
     * @return Collection
     */
    public function getCollectionBy(array $filters = []): Collection
    {
        return collect($this->findBy($filters));
    }

    /**
     * Similar to findAll method.
     * Difference is it returns collection instead of array
     *
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return collect($this->findBy([]));
    }
}
