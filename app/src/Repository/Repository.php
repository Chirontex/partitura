<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Basic common repository. Direct use not welcome but possible if need to.
 * @package Partitura\Repository
 */
class Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * {@inheritDoc}
     * 
     * @return ArrayCollection<object>
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null) : ArrayCollection
    {
        return new ArrayCollection(parent::findBy($criteria, $orderBy, $limit, $offset));
    }

    /**
     * {@inheritDoc}
     *
     * @return ArrayCollection<int, object>
     */
    public function findAll() : ArrayCollection
    {
        return new ArrayCollection(parent::findAll());
    }
}
