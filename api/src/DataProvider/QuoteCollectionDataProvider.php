<?php


namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Quote;
use Psr\Log\LoggerInterface;

class QuoteCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $quotes = [];

    public function __construct(LoggerInterface $log)
    {
        $this->log= $log;
        $quote1 = new Quote("Life is like a chocolate box");
        //$quote1->setId(1);
        $this->quotes[1] = $quote1;

        $quote2 = new Quote("Hakuna Matata");
        //$quote2->setId(2);
        $this->quotes[2] = $quote2;

        $quote3 = new Quote("May the Force be with you");
        //$quote3->setId(3);
        $this->quotes[3] = $quote3;
    }

    /**
     * Retrieves a collection.
     *
     * @return array|\Traversable
     * @throws ResourceClassNotSupportedException
     *
     */
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        return $this->quotes;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return false;
        return Quote::class === $resourceClass;
    }
}
