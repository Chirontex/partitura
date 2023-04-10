<?php

declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\RememberToken;

/**
 * Remember-me-tokens repository.
 *
 * @extends Repository<RememberToken>
 *
 * @method null|RememberToken find($id, $lockMode = null, $lockVersion = null)
 * @method null|RememberToken findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, RememberToken> findAll()
 * @method ArrayCollection<RememberToken> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RememberTokenRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RememberToken::class);
    }

    /**
     *
     * @return ArrayCollection<RememberToken>
     */
    public function findByUsername(string $username): ArrayCollection
    {
        return $this->findBy(["username" => $username]);
    }
}
