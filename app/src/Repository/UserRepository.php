<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Partitura\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Users repository.
 * @package Partitura\Repository
 * @extends Repository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, User> findAll()
 * @method ArrayCollection<User> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}
