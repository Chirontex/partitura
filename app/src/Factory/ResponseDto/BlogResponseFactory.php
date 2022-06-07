<?php
declare(strict_types=1);

namespace Partitura\Factory\ResponseDto;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Dto\Api\BlogPostDto;
use Partitura\Dto\Api\BlogRequestDto;
use Partitura\Entity\Post;
use Partitura\Enum\PostTypeEnum;
use Partitura\Event\BlogViewEvent;
use Partitura\Repository\PostRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class BlogResponseFactory
 * @package Partitura\Factory\ResponseDto
 */
class BlogResponseFactory
{
    /** @var PostRepository */
    protected $postRepository;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function __construct(
        ManagerRegistry $registry,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->postRepository = $registry->getRepository(Post::class);
        $this->eventDispatcher = $eventDispatcher;
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

        $this->eventDispatcher->dispatch(new BlogViewEvent($result));

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
