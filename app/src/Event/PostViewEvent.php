<?php
declare(strict_types=1);

namespace Partitura\Event;

use Partitura\Dto\PostResponseDto;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class PostViewEvent
 * @package Partitura\Event
 */
class PostViewEvent extends Event
{
    /** @var PostResponseDto */
    protected $postResponseDto;

    public function __construct(PostResponseDto $postResponseDto)
    {
        $this->postResponseDto = $postResponseDto;
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
