<?php
declare(strict_types=1);

namespace Partitura\Factory\ResponseDto;

use Partitura\Dto\PostResponseDto;
use Partitura\Event\PostViewEvent;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Manager\PostManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class PostResponseFactory
 * @package Partitura\Factory\ResponseDto
 */
class PostResponseFactory
{
    /** @var PostManager */
    protected $postManager;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function __construct(
        PostManager $postManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->postManager = $postManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $uri
     * 
     * @throws EntityNotFoundException
     *
     * @return PostResponseDto
     */
    public function createResponseByUri(string $uri) : PostResponseDto
    {
        $post = $this->postManager->getPostByUri($uri);
        $postViewEvent = new PostViewEvent(
            $post,
            (new PostResponseDto())
                ->setPostId($post->getId())
                ->setTitle($post->getTitle())
                ->setAuthor((string)$post->getAuthor()?->getUsername())
                ->setContent($post->getContent())
                ->setDateCreated($post->getDatetimeCreated())
        );

        $this->eventDispatcher->dispatch($postViewEvent);

        return $postViewEvent->getPostResponseDto();
    }
}
