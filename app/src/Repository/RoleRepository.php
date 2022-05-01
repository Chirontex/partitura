<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Partitura\Entity\Role;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Roles repository.
 * @package Partitura\Repository
 * @extends Repository<Role>
 * 
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, Role> findAll()
 * @method ArrayCollection<Role> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }
}
