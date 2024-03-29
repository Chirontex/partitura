<?php

declare(strict_types=1);

namespace Partitura\Manager;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\Post;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Repository\PostRepository;

/**
 * Class PostManager.
 */
class PostManager
{
    protected PostRepository $postRepository;

    public function __construct(ManagerRegistry $registry)
    {
        $this->postRepository = $registry->getRepository(Post::class);
    }

    /**
     *
     * @throws EntityNotFoundException
     *
     */
    public function getPostByUri(string $uri): Post
    {
        if (empty($uri)) {
            throw new EntityNotFoundException("Post cannot be found by empty uri.");
        }

        $namespace = explode("/", $uri);
        $supposedPosts = $this->postRepository->findPublishedByName(
            $namespace[count($namespace) - 1]
        );

        foreach ($supposedPosts as $supposedPost) {
            if ($supposedPost->getUri() === $uri) {
                return $supposedPost;
            }
        }

        throw new EntityNotFoundException(sprintf("Post with uri \"%s\" was not found.", $uri));
    }
}
