<?php
declare(strict_types=1);

namespace Partitura\Event;

use Partitura\Dto\Api\BlogResponseDto;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BlogViewEvent
 * @package Partitura\Event
 */
class BlogViewEvent extends Event
{
    public function __construct(protected BlogResponseDto $blogResponseDto)
    {
    }

    /**
     * @return BlogResponseDto
     */
    public function getBlogResponseDto() : BlogResponseDto
    {
        return $this->blogResponseDto;
    }

    /**
     * @param BlogResponseDto $blogResponseDto
     *
     * @return $this
     */
    public function setBlogResponseDto(BlogResponseDto $blogResponseDto) : static
    {
        $this->blogResponseDto = $blogResponseDto;

        return $this;
    }
}
