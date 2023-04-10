<?php

declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\UserFieldValue;

/**
 * User field values repository.
 *
 * @extends Repository<UserFieldValue>
 *
 * @method null|UserFieldValue find($id, $lockMode = null, $lockVersion = null)
 * @method null|UserFieldValue findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, UserFieldValue> findAll()
 * @method ArrayCollection<UserFieldValue> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFieldValueRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserFieldValue::class);
    }
}
