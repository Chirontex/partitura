<?php
declare(strict_types=1);

namespace Partitura\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Dto\Api\BlogResponseDto;
use Partitura\Exception\ArgumentException;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BlogViewEvent
 * @package Partitura\Event
 */
class BlogViewEvent extends Event
{
    /** @var BlogResponseDto */
    protected $blogResponseDto;

    public function __construct(BlogResponseDto $blogResponseDto)
    {
        $this->blogResponseDto = $blogResponseDto;
    }

    /**
     * @return BlogResponseDto
     */
    public function getBlogResponseDto() : BlogResponseDto
    {
        return $this->blogResponseDto;
    }
}
