<?php

declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\ArchivedPost;

/**
 * Archived posts repository.
 *
 * @extends Repository<ArchivedPost>
 *
 * @method null|ArchivedPost find($id, $lockMode = null, $lockVersion = null)
 * @method null|ArchivedPost findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, ArchivedPost> findAll()
 * @method ArrayCollection<ArchivedPost> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchivedPostRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchivedPost::class);
    }
}
