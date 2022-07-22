<?php
declare(strict_types=1);

namespace Partitura\Loader;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Controller\PostController;
use Partitura\Entity\Post;
use Partitura\Exception\PostsLoaderAlreadyLoadedException;
use Partitura\Repository\PostRepository;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Throwable;

/**
 * Class PostsLoader
 * @package Partitura\Loader
 */
class PostsLoader extends Loader
{
    /** @var bool */
    protected $loaded = false;

    /** @var PostRepository */
    protected $postRepository;

    public function __construct(ManagerRegistry $registry)
    {
        $this->postRepository = $registry->getRepository(Post::class);
    }

    /**
     * {@inheritDoc}
     * 
     * @throws PostsLoaderAlreadyLoadedException
     */
    public function load(mixed $resource, ?string $type = null) : RouteCollection
    {
        if ($this->loaded) {
            throw new PostsLoaderAlreadyLoadedException();
        }

        $routes = new RouteCollection();

        try {
            $posts = $this->postRepository->findAllPublished();
        } catch (Throwable) {
            return $routes;
        }

        foreach ($posts as $post) {
            $route = new Route(
                $post->getUri(),
                ["_controller" => sprintf("%s::showPost", PostController::class)],
                [],
                [],
                "",
                [],
                [Request::METHOD_GET],
                ""
            );

            $routes->add(sprintf("post_%u", $post->getId()), $route);
        }

        $this->loaded = true;

        return $routes;
    }

    /** {@inheritDoc} */
    public function supports(mixed $resource, ?string $type = null) : bool
    {
        return $type === "posts";
    }
}
