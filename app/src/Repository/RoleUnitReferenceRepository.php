<?php

declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\RoleUnitReference;

/**
 * Role unit references repository.
 *
 * @extends Repository<RoleUnitReference>
 *
 * @method null|RoleUnitReference find($id, $lockMode = null, $lockVersion = null)
 * @method null|RoleUnitReference findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, RoleUnitReference> findAll()
 * @method ArrayCollection<RoleUnitReference> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleUnitReferenceRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoleUnitReference::class);
    }
}
