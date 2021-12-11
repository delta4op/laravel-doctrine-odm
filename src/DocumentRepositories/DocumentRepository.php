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
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return Collection
     */
    public function getCollectionBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): Collection
    {
        return collect($this->findBy($criteria,$orderBy,$limit,$offset));
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
