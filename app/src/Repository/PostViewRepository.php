<?php

declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\PostView;

/**
 * Posts views repository.
 *
 * @extends Repository<PostView>
 *
 * @method null|PostView find($id, $lockMode = null, $lockVersion = null)
 * @method null|PostView findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, PostView> findAll()
 * @method ArrayCollection<PostView> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostViewRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostView::class);
    }
}
