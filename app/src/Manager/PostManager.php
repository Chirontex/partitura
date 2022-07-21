<?php
declare(strict_types=1);

namespace Partitura\Manager;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\Post;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Repository\PostRepository;

/**
 * Class PostManager
 * @package Partitura\Manager
 */
class PostManager
{
    /** @var PostRepository */
    protected $postRepository;

    public function __construct(ManagerRegistry $registry)
    {
        $this->postRepository = $registry->getRepository(Post::class);
    }

    /**
     * @param string[] $namespace
     *
     * @return Post
     */
    public function getPostByNamespace(array $namespace) : Post
    {
        if (empty($namespace)) {
            throw new EntityNotFoundException("Post cannot be found by empty namespace.");
        }

        $supposedPosts = $this->postRepository->findPublishedByName(
            $namespace[count($namespace) - 1]
        );

        foreach ($supposedPosts as $supposedPost) {
            if ($this->checkPostNamespace($supposedPost, $namespace)) {
                return $supposedPost;
            }
        }

        throw new EntityNotFoundException(sprintf(
            "Post with namespace \"%s\" was not found.",
            sprintf("/%s", implode("/", $namespace))
        ));
    }

    /**
     * @param Post $post
     * @param string[] $namespace
     *
     * @return bool
     */
    protected function checkPostNamespace(Post $post, array $namespace) : bool
    {
        if ($post->getName() !== $namespace[count($namespace) - 1]) {
            return false;
        }

        for ($i = count($namespace) - 2; $i >= 0; $i--) {
            $post = $post->getParent();

            if ($post === null) {
                return false;
            }

            if ($post->getName() !== $namespace[$i]) {
                return false;
            }
        }

        return true;
    }
}
