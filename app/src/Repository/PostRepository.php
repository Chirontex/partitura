<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\Post;

/**
 * Posts repository.
 * @package Partitura\Repository
 * @extends Repository<Post>
 * 
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArrayCollection<int, Post> findAll()
 * @method ArrayCollection<Post> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends Repository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @param string $name
     *
     * @return ArrayCollection<Post>
     */
    public function findByName(string $name) : ArrayCollection
    {
        return $this->findBy(["name" => $name]);
    }
}
