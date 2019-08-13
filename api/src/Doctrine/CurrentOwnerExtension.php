<?php

declare(strict_types=1);

namespace App\Doctrine;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Owner;
use App\Entity\Quote;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CurrentOwnerExtension implements QueryCollectionExtensionInterface
{
    private $security;


    /**
     * CurrentOwnerExtension constructor.
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        if (Quote::class !== $resourceClass) {
            return $queryBuilder;
        }
        // Liste de tous les alias de la req principale - premier = table FROM
        $alias = $queryBuilder->getRootAliases()[0];
        /** @var Owner $user */
        $user = $this->security->getUser();

        //TODO corriger pq ça marche pas
        $queryBuilder
            ->andWhere(":userId = :alias")
            ->setParameter("userId", $user->getId())
            ->setParameter("alias", $alias . ".owner");

        return $queryBuilder;

    }
}