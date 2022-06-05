<?php
declare(strict_types=1);

namespace Partitura\Factory\ResponseDto;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Dto\Api\BlogPostDto;
use Partitura\Dto\Api\BlogRequestDto;
use Partitura\Entity\Post;
use Partitura\Enum\PostTypeEnum;
use Partitura\Repository\PostRepository;

/**
 * Class BlogResponseFactory
 * @package Partitura\Factory\ResponseDto
 */
class BlogResponseFactory
{
    /** @var PostRepository */
    protected $postRepository;

    public function __construct(ManagerRegistry $registry)
    {
        $this->postRepository = $registry->getRepository(Post::class);
    }

    /**
     * @param BlogRequestDto $requestDto
     *
     * @return ArrayCollection<BlogPostDto>
     */
    public function createBlogPostCollection(BlogRequestDto $requestDto) : ArrayCollection
    {
        $result = new ArrayCollection();
        $offset = $requestDto->getOffset();

        $posts = $this->postRepository->findBy(
            ["type" => PostTypeEnum::PUBLISHED->value],
            ["datetimeCreated" => "DESC"],
            $requestDto->getLimit(),
            $offset > 0 ? $offset : null
        );

        foreach ($posts as $post) {
            $result->add(
                (new BlogPostDto())
                    ->setTitle($post->getTitle())
                    ->setContent($this->handleContent($post->getContent()))
                    ->setAuthor((string)$post->getAuthor()?->getUsername())
                    ->setDateCreated($post->getDatetimeCreated())
            );
        }

        return $result;
    }

    /**
     * @param string $content
     *
     * @return string
     */
    protected function handleContent(string $content) : string
    {
        return strlen($content) > 300 ? sprintf("%s...", substr($content, 0, 300)) : $content;
    }
}
