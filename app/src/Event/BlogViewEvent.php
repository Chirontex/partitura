<?php

declare(strict_types=1);

namespace Partitura\Event;

use Partitura\Dto\Api\BlogResponseDto;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BlogViewEvent
 */
class BlogViewEvent extends Event
{
    public function __construct(protected BlogResponseDto $blogResponseDto)
    {
    }

    public function getBlogResponseDto(): BlogResponseDto
    {
        return $this->blogResponseDto;
    }

    /**
     *
     * @return $this
     */
    public function setBlogResponseDto(BlogResponseDto $blogResponseDto): static
    {
        $this->blogResponseDto = $blogResponseDto;

        return $this;
    }
}
