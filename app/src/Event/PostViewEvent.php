<?php

declare(strict_types=1);

namespace Partitura\Event;

use Partitura\Dto\PostResponseDto;
use Partitura\Entity\Post;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class PostViewEvent
 */
class PostViewEvent extends Event
{
    public function __construct(
        protected Post $post,
        protected PostResponseDto $postResponseDto
    ) {
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getPostResponseDto(): PostResponseDto
    {
        return $this->postResponseDto;
    }

    /**
     *
     * @return $this
     */
    public function setPostResponseDto(PostResponseDto $postResponseDto): static
    {
        $this->postResponseDto = $postResponseDto;

        return $this;
    }
}
