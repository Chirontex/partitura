<?php
declare(strict_types=1);

namespace Partitura\Event;

use Partitura\Dto\PostResponseDto;
use Partitura\Entity\Post;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class PostViewEvent
 * @package Partitura\Event
 */
class PostViewEvent extends Event
{
    /** @var Post */
    protected $post;

    /** @var PostResponseDto */
    protected $postResponseDto;

    public function __construct(Post $post, PostResponseDto $postResponseDto)
    {
        $this->post = $post;
        $this->postResponseDto = $postResponseDto;
    }

    /**
     * @return Post
     */
    public function getPost() : Post
    {
        return $this->post;
    }

    /**
     * @return PostResponseDto
     */
    public function getPostResponseDto() : PostResponseDto
    {
        return $this->postResponseDto;
    }

    /**
     * @param PostResponseDto $postResponseDto
     *
     * @return $this
     */
    public function setPostResponseDto(PostResponseDto $postResponseDto) : static
    {
        $this->postResponseDto = $postResponseDto;

        return $this;
    }
}
