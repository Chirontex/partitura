<?php
declare(strict_types=1);

namespace Partitura\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Dto\Api\BlogPostDto;
use Partitura\Exception\ArgumentException;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BlogViewEvent
 * @package Partitura\Event
 */
class BlogViewEvent extends Event
{
    /** @var ArrayCollection<BlogPostDto> */
    protected $blogPostDtoCollection;

    /**
     * @throws ArgumentException
     */
    public function __construct(ArrayCollection $blogPostDtoCollection)
    {
        foreach ($blogPostDtoCollection as $blogPostDto) {
            if (!($blogPostDto instanceof BlogPostDto)) {
                throw new ArgumentException("Invalid collection given.");
            }
        }

        $this->blogPostDtoCollection = $blogPostDtoCollection;
    }

    /**
     * @return ArrayCollection<BlogPostDto>
     */
    public function getBlogPostDtoCollection() : ArrayCollection
    {
        return $this->blogPostDtoCollection;
    }
}
