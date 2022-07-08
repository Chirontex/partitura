<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\PostView;

/**
 * Posts views repository.
 * @package Partitura\Repository
 * @extends Repository<PostView>
 * 
 * @method PostView|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostView|null findOneBy(array $criteria, array $orderBy = null)
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
