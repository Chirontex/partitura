<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\User;
use Partitura\Exception\EntityNotFoundException;

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

    /**
     * @param string $username
     *
     * @return User
     */
    public function findByUsername(string $username) : User
    {
        $user = $this->findOneBy(["username" => $username]);

        if ($user === null) {
            throw new EntityNotFoundException(sprintf(
                "User with username \"%s\" was not found.",
                $username
            ));
        }

        return $user;
    }
}
