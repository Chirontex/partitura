<?php
declare(strict_types=1);

namespace Partitura\Factory\ResponseDto;

use Partitura\Dto\PostResponseDto;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Manager\PostManager;

/**
 * Class PostResponseFactory
 * @package Partitura\Factory\ResponseDto
 */
class PostResponseFactory
{
    /** @var PostManager */
    protected $postManager;

    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
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

        return (new PostResponseDto())
            ->setTitle($post->getTitle())
            ->setAuthor((string)$post->getAuthor()?->getUsername())
            ->setContent($post->getContent())
            ->setDateCreated($post->getDatetimeCreated());
    }
}
