<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\Unit;

/**
 * Units repository.
 * @package Partitura\Repository
 * @extends Repository<Unit>
 * 
 * @method Unit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unit|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, Unit> findAll()
 * @method ArrayCollection<Unit> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnitRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unit::class);
    }
}
