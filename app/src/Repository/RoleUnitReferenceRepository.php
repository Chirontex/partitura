<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\RoleUnitReference;

/**
 * Role unit references repository.
 * @package Partitura\Repository
 * @extends Repository<RoleUnitReference>
 * 
 * @method RoleUnitReference|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleUnitReference|null findOneBy(array $criteria, array $orderBy = null)
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
