<?php

declare(strict_types=1);

namespace Partitura\Factory\ResponseDto;

use Partitura\Dto\PostResponseDto;
use Partitura\Event\PostViewEvent;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Manager\PostManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class PostResponseFactory.
 */
class PostResponseFactory
{
    public function __construct(
        protected PostManager $postManager,
        protected EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     *
     * @throws EntityNotFoundException
     *
     */
    public function createResponseByUri(string $uri): PostResponseDto
    {
        $post = $this->postManager->getPostByUri($uri);
        $postViewEvent = new PostViewEvent(
            $post,
            (new PostResponseDto())
                ->setTitle($post->getTitle())
                ->setAuthor((string)$post->getAuthor()?->getUsername())
                ->setContent($post->getContent())
                ->setDateCreated($post->getDatetimeCreated())
        );

        $this->eventDispatcher->dispatch($postViewEvent);

        return $postViewEvent->getPostResponseDto();
    }
}
