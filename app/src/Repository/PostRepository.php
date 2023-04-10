<?php

declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\Post;
use Partitura\Enum\PostTypeEnum;

/**
 * Posts repository.
 *
 * @extends Repository<Post>
 *
 * @method null|Post find($id, $lockMode = null, $lockVersion = null)
 * @method null|Post findOneBy(array $criteria, array $orderBy = null)
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
     *
     * @return ArrayCollection<Post>
     */
    public function findPublishedByName(string $name): ArrayCollection
    {
        return $this->findBy([
            "name" => $name,
            "type" => PostTypeEnum::PUBLISHED->value,
        ]);
    }

    /**
     * @return ArrayCollection<Post>
     */
    public function findAllPublished(): ArrayCollection
    {
        return $this->findBy(["type" => PostTypeEnum::PUBLISHED->value]);
    }
}
