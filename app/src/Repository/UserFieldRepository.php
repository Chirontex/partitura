<?php

declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\UserField;

/**
 * User fields repository.
 *
 * @extends Repository<UserField>
 *
 * @method null|UserField find($id, $lockMode = null, $lockVersion = null)
 * @method null|UserField findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, UserField> findAll()
 * @method ArrayCollection<UserField> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFieldRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserField::class);
    }
}
