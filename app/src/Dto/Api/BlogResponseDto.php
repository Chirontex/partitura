<?php
declare(strict_types=1);

namespace Partitura\Dto\Api;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class BlogResponseDto
 * @package Partitura\Dto\Api
 */
class BlogResponseDto
{
    #[Serializer\Type('int')]
    #[Serializer\SerializedName('pages')]   
    protected ?int $pages = null;

    /** @var ArrayCollection<BlogPostDto> */
    #[Serializer\Type('ArrayCollection<Partitura\Dto\Api\BlogPostDto>')]
    #[Serializer\SerializedName('posts')]
    protected ArrayCollection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getPages() : int
    {
        return (int)$this->pages;
    }

    /**
     * @param int $pages
     *
     * @return $this
     */
    public function setPages(int $pages) : static
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * @return ArrayCollection<BlogPostDto>
     */
    public function getPosts() : ArrayCollection
    {
        return $this->posts;
    }

    /**
     * @param ArrayCollection<BlogPostDto> $posts
     *
     * @return $this
     */
    public function setPosts(ArrayCollection $posts) : static
    {
        $this->posts = $posts;

        return $this;
    }
}
