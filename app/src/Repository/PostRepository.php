<?php
declare(strict_types=1);

namespace Partitura\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception;
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
     * @throws Exception
     * @return int
     */
    public function countBlogPosts() : int
    {
        return $this->countPosts("IN_BLOG = :in_blog", ["in_blog" => 1]);
    }

    /**
     * @param string $where
     * @param array $criteria
     *
     * @throws Exception
     * @return int
     */
    protected function countPosts(string $where, array $criteria) : int
    {
        $sql = sprintf("SELECT COUNT(*) as \"count\" FROM %s t", Post::TABLE_NAME);

        if (!empty($where)) {
            $sql .= sprintf(" WHERE %s", $where);
        }

        $connection = $this->getEntityManager()->getConnection();
        $statement = $connection->prepare($sql);
        $result = $statement->executeQuery($criteria)->fetchAllAssociative();

        return (int)$result["count"];
    }
}
